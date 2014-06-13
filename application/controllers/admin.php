<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller
{

	// Constructor
	public function __construct()
	{

		// put code here
		parent::__construct();

		// Load the admin model
		$this->load->model(array('admin_model','mentor_model','mentee_model','mentorship_model','user_model'));

		// Check if user is logged in
		$this->admin_model->is_logged_in();

	}	// End: __construct()


	// Default method
	public function index()
	{

		// Set the # of mentors and mentees to preview
		$preview_number = 5;

		// Landing page for admin page
		$data = array(
				'current_menu' => 'home',
				'view' => 'admin/index',
				'title' => 'Welcome ' . $this->session->userdata('fullname'),
				'mentors' => $this->mentor_model->preview($preview_number),
				'mentees' => $this->mentee_model->preview($preview_number),
				'preview_number' => $preview_number,
				'mentee_interests' => $this->mentee_model->interest_numbers(),
				'mentor_interests' => $this->mentor_model->interest_numbers(),
				'total_mentor_interests' => $this->db->count_all('mentee_hr_areas'),
				'total_mentee_interests' => $this->db->count_all('mentor_hr_areas'),
				'max_mentee_interests' => $this->mentee_model->highest_interest_numbers(),
				'max_mentor_interests' => $this->mentor_model->highest_interest_numbers()
			);
		$this->load->view('templates/admin', $data);

	}	// end: index()


	// Method to list mentors
	public function mentors()
	{

		// Get the offset
		$offset = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

		// Use pagination to get the list of mentors
		$this->load->library('pagination');
		$config = array(
				'base_url' => site_url('admin/mentors'),
				'total_rows' => $this->db->count_all('mentors'),
				'per_page' => 10,
				'num_links' => 10
			);
		$this->pagination->initialize($config);
		
		// Load the page
		$this->db->order_by('created_at', 'desc');
		$rs = $this->db->get('mentors', $config['per_page'], $this->uri->segment(3));
		$data = array(
				'current_menu' => 'mentor',
				'view' => 'admin/mentors',
				'title' => 'Registered Mentors',
				'mentors' => $rs,
				'offset' => $offset
			);
		$this->load->view('templates/admin', $data);

	}	// End: mentors()


	// Method to get the mentor details
	public function mentor($mentor_id=NULL)
	{

		// Call the method in the model to get the details
		$details = $this->mentor_model->details($mentor_id)->row();

		// Load the page
		$data = array(
				'current_menu' => 'mentor',
				'view' => 'admin/mentor',
				'title' => ucwords(strtolower($details->firstname . ' ' . $details->surname . ' ' . $details->othernames)),
				'mentor_name' => '<ol class="breadcrumb"><li><a href="'.site_url('admin/mentors').'">Mentors</a></li><li>' . ucwords(strtolower($details->firstname . ' ' . $details->surname)) . '</li></ol>',
				'details' => $details
			);

		// Load the template
		$this->load->view('templates/admin', $data);

	}	// End: mentor()


	// Method to get the mentee details
	public function mentee($mentee_id=NULL)
	{

		// Call the method in the model to get the details
		$details = $this->mentee_model->details($mentee_id)->row();

		// Load the page
		$data = array(
				'current_menu' => 'mentee',
				'view' => 'admin/mentee',
				'title' => ucwords(strtolower($details->firstname . ' ' . $details->surname . ' ' . $details->othernames)),
				'mentor_name' => '<ol class="breadcrumb"><li><a href="'.site_url('admin/mentees').'">Mentees</a></li><li>' . ucwords(strtolower($details->firstname . ' ' . $details->surname)) . '</li></ol>',
				'details' => $details
			);

		// Load the template
		$this->load->view('templates/admin', $data);

	}	// End: mentee()


	// Method to list mentees
	public function mentees()
	{

		// Get the offset
		$offset = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

		// Use pagination to get the list of mentees
		$this->load->library('pagination');
		$config = array(
				'base_url' => site_url('admin/mentees'),
				'total_rows' => $this->db->count_all('mentees'),
				'per_page' => 10,
				'num_links' => 10
			);
		$this->pagination->initialize($config);
		
		// Load the page
		$this->db->order_by('created_at', 'desc');
		$rs = $this->db->get('mentees', $config['per_page'], $this->uri->segment(3));

		// Create the data array and load the page
		$data = array(
				'current_menu' => 'mentee',
				'view' => 'admin/mentees',
				'title' => 'Registered Mentees',
				'mentees' => $rs,
				'offset' => $offset
			);
		$this->load->view('templates/admin', $data);

	}	// End: mentees()


	// Method to list users
	public function users($msg=NULL)
	{

		// Make sure the user is an admin
		$this->admin_model->is_admin();

		// First, get the offset
		$offset = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

		// Use pagination to get the list of mentees
		$this->load->library('pagination');
		$config = array(
				'base_url' => site_url('admin/users'),
				'total_rows' => $this->db->count_all('users'),
				'per_page' => 10,
				'num_links' => 10
			);
		$this->pagination->initialize($config);
		
		// Load the page
		$this->db->where('id <>', $this->session->userdata('user_id'));
		$this->db->order_by('fullname', 'asc');
		$rs = $this->db->get('users', $config['per_page'], $offset);
		
		// Load the page
		$data = array(
				'current_menu' => 'user',
				'view' => 'admin/users',
				'title' => 'Managing Users',
				'users' => $rs,
				'offset' => $offset
			);

		// Check if there is a message to load
		if (is_array($msg))
		{
			$data['msg'] = $msg;
		}

		// Load the page
		$this->load->view('templates/admin', $data);

	}	// End: users()


	/**
	 * Method to add a new user
	 */
	public function user_add()
	{

		// Make sure the user is an admin
		$this->admin_model->is_admin();
		
		// Create the page for adding a new user
		$data = array(
				'current_menu' => 'user',
				'view' => 'admin/user_add',
				'title' => 'Add New User'
			);
		$this->load->view('templates/admin', $data);

	}	// End: user_add()


	/**
	 * Method to save a new user
	 */
	public function user_save()
	{

		// Make sure the user is an admin
		$this->admin_model->is_admin();
		
		// Check for the $_POST variable
		if (!$_POST)
		{

			// No form posted
			redirect(site_url('admin/user_add', 'refresh'));

		}
		else
		{

			// Something posted
			$result = $success = $this->user_model->save();
			if (!$result['success'])
			{

				// It failed ... reload
				$data = array(
						'current_menu' => 'user',
						'view' => 'admin/user_add',
						'title' => 'Add New User',
						'msg' => array('style' => 'danger', 'text' => 'The form needs to be completely filled out OR contains some error(s).')
					);
				$this->load->view('templates/admin', $data);

			}
			else
			{

				// Successful ... notify the user ...
				$this->session->set_flashdata('message', array('style' => 'success', 'text' => 'The user account was successfully created.'));
				redirect(site_url('admin/users'), 'refresh');

			}	// Checking if the save was successful

		}	// Checking if a form was posted

	}	// End: user_save()


	/**
	 * Method to edit a user
	 */
	public function user_edit($user_id=NULL)
	{

		// Make sure the user is an admin
		$this->admin_model->is_admin();
		
		// Call the method to edit a user account
		$result = $this->user_model->edit($user_id);

		// Check if the result was successful or not
		if (!$result)
		{

			// Nothing found; redirect to the users listing page
			$this->session->set_flashdata('message', array('style' => 'danger', 'text' => 'The user account was not found.'));
			redirect(site_url('admin/users'), 'refresh');

		}
		else
		{

			// Result found
			$data = array(
					'current_menu' => 'user',
					'view' => 'admin/user_edit',
					'title' => 'Edit User Account',
					'user_details' => $result->row()
				);

			// Load the page
			$this->load->view('templates/admin', $data);

		}	// Checking if the user ID had related details

	}	// End: user_edit()


	/**
	 * Method to update a user account
	 */
	public function user_update()
	{

		// Make sure the user is an admin
		$this->admin_model->is_admin();

		// Ensure a form was posted
		if ($_POST)
		{

			// Call the method for updating the user account
			$result = $this->user_model->update();

			// Check for success or failure
			if (!$result['success'])
			{

				// Update failed ... redirect back to the form editing the user by appending the user ID to the end of the URL
				// Assumption here is that the correct form was posted and the user ID was available as a hidden field
				$this->session->set_flashdata('message', array('style' => 'danger', 'text' => 'There were error(s) in the form you submitted. Correct them below and submit again. Error(s) are: ' . $result['errors']));
				redirect(site_url('admin/user_edit/' . $this->input->post('user_id'), 'refresh'));

			}
			else
			{

				// Update successful
				// Set the message to show the user
				$this->session->set_flashdata('message', array('style' => 'success', 'text' => 'The user account was successfully updated.'));

				// Redirect
				redirect(site_url('admin/users', 'refresh'));

			}	// Checking if user update was succeessful

		}
		else
		{

			// No form posted
			redirect(site_url('admin/users', 'refresh'));

		}	// Checking for form posting

	}	// End: user_update()



	/**
	 * Callback method for checking that a user account being updated has a unique email address
	 * which is not in use by another account of a different user ID
	 */
	public function check_email()
	{
		$user_id = trim($this->input->post('user_id'));
		$email = trim($this->input->post('email'));
		$rs = $this->db->get_where('users', array('id <> ' => $user_id, 'email' => $email));
		if ($rs->num_rows() > 0)
		{
			// Email not unique
			$this->form_validation->set_message('email_check', 'The % you provided already exists for another account.');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}	// End: check_email()



	/**
	 * Method to delete a user
	 */
	public function user_delete($user_id=NULL)
	{

		// Make sure the user is an admin
		$this->admin_model->is_admin();
		
		// Call the model to delete the user account
		$success = $this->user_model->delete($user_id);

		// Check for success or failure
		if (!$success)
		{

			// Delete failed ..
			$this->session->set_flashdata('message', array('style' => 'danger', 'text' => 'The user account could not be deleted; please try again.'));
			redirect(site_url('admin/users', 'refresh'));

		}
		else
		{

			// Delete successful
			$this->session->set_flashdata('message', array('style' => 'success', 'text' => 'The user account was successfully deleted.'));
			redirect(site_url('admin/users', 'refresh'));

		}	// Checking if delete was successful

	}	// End: user_delete()


	// Method to search the database
	public function search($table_name=NULL,$search_term=NULL)
	{

		// // Echo out the search term
		// if (isset($_GET['search_term']))
		// {

		// 	// Check if the search term has anything
		// 	if (isset($_GET['search_term']) && trim($_GET['search_term']) == '' || isset($_GET['table']) && trim($_GET['table']) == '')
		// 	{
		// 		// Nothing searched for OR table is missing
		// 		redirect(site_url('admin'), 'refresh');
		// 		exit();
		// 	}
		// 	else
		// 	{

		// 		// Valid search ... redirect
		// 		redirect(site_url('admin/search/' $_GET['table'] . '/' . $_GET['search_term']), 'refresh');
		// 		exit();

		// 	}	// Checking for valid search parameters

		// }	// Checking if the $_GET variable is set

		// // Ensure that the search term has a value
		// if ($search_term == '')
		// {
		// 	// Nothing to search for
		// 	redirect(site_url('admin'), 'refresh');
		// 	exit();
		// }

		// // Start the search
		// // First, get the offset
		// $offset = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;

		// // Use pagination to get the list of mentees
		// $this->load->library('pagination');
		// $config = array(
		// 		'base_url' => site_url('admin/search/' $table_name . '/' . $search_term),
		// 		'total_rows' => $this->db->count_all('mentees'),
		// 		'per_page' => 10,
		// 		'num_links' => 10
		// 	);
		// $this->pagination->initialize($config);
		
		// // Load the page
		// $this->db->order_by('created_at', 'desc');
		// $rs = $this->db->get('mentees', $config['per_page'], $offset);
		
		// // Load the page
		// $data = array(
		// 		'current_menu' => '',
		// 		'view' => 'admin/search',
		// 		'title' => 'Search Results',
		// 		'search_term' => $search_term
		// 	);
		// $this->load->view('templates/admin', $data);

	}	// End: search()



	// Grab the search results
	public function search_results($table_name=NULL, $search_term=NULL, $offset=0)
	{
		
		// Create the query required for the search results
		// First, get the offset
		// $offset = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;

		// Get the # of records
		$this->db->like('firstname', $search_term);
		$this->db->or_like('surname', $search_term);
		$this->db->or_like('othernames', $search_term);
		$this->db->or_like('email', $search_term);
		$this->db->or_like('organization', $search_term);
		$this->db->or_like('position', $search_term);

		// Use pagination to get the list of mentees
		$this->load->library('pagination');
		$config = array(
				'base_url' => site_url('admin/search_results/' . $table_name . '/' . $search_term),
				'total_rows' => $this->db->get($table_name)->num_rows(),
				'per_page' => 10,
				'num_links' => 10
			);
		$this->pagination->initialize($config);
		
		// Load the page
		$this->db->like('firstname', $search_term);
		$this->db->or_like('surname', $search_term);
		$this->db->or_like('othernames', $search_term);
		$this->db->or_like('email', $search_term);
		$this->db->or_like('organization', $search_term);
		$this->db->or_like('position', $search_term);
		$this->db->order_by('created_at', 'desc');
		$rs = $this->db->get($table_name, $config['per_page'], $offset);
		
		// Load the page
		$data = array(
				'current_menu' => '',
				'view' => 'admin/search',
				'title' => 'Search Results',
				'search_term' => $search_term,
				'search_results' => $rs,
				'offset' => $offset,
				'applicant_type' => ($table_name == 'mentees') ? 'mentee' : 'mentor'
			);
		$this->load->view('templates/admin', $data);

	}	// End: search_results()


	// Logout method
	public function logout()
	{
		
		if ($this->session->userdata('user_id')) {

			//	Set the session array to nothing
			$this->session->userdata = array();

			//	Destroy the session
			$this->session->sess_destroy();

			//	Destroy the cookie by setting its expiration to a past time/date
			setcookie( config_item('sess_cookie_name'), '', time() - 3600 );

		}	//	Check for valid session to avoid non-valid session related errors e.g. Undefined session variables

		//	Clear the cache
		$this->ihrm_model->clear_cache();

		//	Now redirect to the login page
		redirect(site_url('login'), 'refresh');

	}	// End: logout()


}	// End class: Admin

