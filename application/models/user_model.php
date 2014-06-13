<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_Model extends CI_Model
{

	// constructor
	public function __construct()
	{
		// put code here
		parent::__construct();
	}

	// Method to save a new user
	public function save()
	{
		
		// Validate the form details
        // Create the validation config file
        $config = array(
            array('field' => 'fullname', 'label' => '<strong>Full Name(s)</strong>', 'rules' => 'required|xss_clean'),
            array('field' => 'email', 'label' => '<strong>Email Address</strong>', 'rules' => 'required|valid_email|is_unique[users.email]|xss_clean'),
            array('field' => 'password', 'label' => '<strong>Password</strong>', 'rules' => 'required|min_length[6]|xss_clean'),
            array('field' => 'confirm_password', 'label' => '<strong>Password Confirmation</strong>', 'rules' => 'required|min_length[6]|matches[password]|xss_clean')
        );

        // Run the validation and revert
        // Load validation library
        $this->load->library('form_validation');

        // Change the validation error delimiters
        $this->form_validation->set_error_delimiters('<p class="form-error"><small>', '</small></p>');

        // Screw around with the rules
        $this->form_validation->set_message('required', 'The %s is required.');
        $this->form_validation->set_message('is_unique', 'The %s you provided already exists in the database.');

        // Load the validation rules
        $this->form_validation->set_rules($config);

        // Run the validation
        if ($this->form_validation->run() == FALSE)
        {

            // Validation failed ... return error messages
            return array('success' => FALSE, 'errors' => validation_errors());

        }
        else
        {

        	// Validation was successful
        	$db_data = array(
        			'fullname' => $this->input->post('fullname'),
        			'email' => $this->input->post('email'),
        			'password' => sha1($this->input->post('password')),
        			'admin' => $this->input->post('admin')
        		);

        	// Save the record
        	$this->db->insert('users', $db_data);

        	// Return result
        	return array('success' => TRUE, 'errors' => '');

        }	// End validation

	}	// End: save()

	/**
	 * Function: edit()
	 * This method gets the submitted ID and then gets the related details for editing
	 */
	public function edit($user_id)
	{
		
		// Confirm that the user ID is valid
		if (is_null($user_id) || !$user_id || !is_numeric($user_id) || trim($user_id) == '')
		{

			// Invalid user id
			return FALSE;

		}
		else
		{

			// Valid user id
			$result = $this->db->get_where('users', array('id' => $user_id, 'id <> ' => $this->session->userdata('user_id')));
			if ($result->num_rows() <= 0)
			{

				// Invalid user ID
				return FALSE;

			}
			else
			{

				// Valid user ID
				return $result;

			}	// Checking for returned records

		}	// End: edit()

	}	// End: edit()


	/**
	 * Method to update a user's account details
	 */
	public function update()
	{
		
		// If this is called, then a form was submitted
		// Let's ensure that the user ID is provided ... if not, return false anyway
		// Arrgghhhh shoot ... just ignore :) ... for now though
		// Validate the form details
        // Create the validation config file
        $config = array(
            array('field' => 'fullname', 'label' => '<strong>Full Name(s)</strong>', 'rules' => 'required|xss_clean'),
            // array('field' => 'email', 'label' => '<strong>Email Address</strong>', 'rules' => 'required|valid_email|callback_check_emails|xss_clean'),
            array('field' => 'user_id', 'label' => '<strong>User ID</strong>', 'rules' => 'required|integer|xss_clean')
        );

        // Run the validation and revert
        // Load validation library
        $this->load->library('form_validation');

        // Change the validation error delimiters
        $this->form_validation->set_error_delimiters('<p class="form-error"><small>', '</small></p>');

        // Screw around with the rules
        $this->form_validation->set_message('required', 'The %s is required.');
        $this->form_validation->set_message('is_unique', 'The %s you provided already exists in the database.');

        // Load the validation rules
        $this->form_validation->set_rules($config);

        // Run the validation
        if ($this->form_validation->run() == FALSE)
        {

            // Validation failed ... return error messages
            return array('success' => FALSE, 'errors' => validation_errors());

        }
        else
        {

        	// Call the validation for the email
        	$email_check = $this->check_email();
        	if (!$email_check) 
        	{

        		// Email validation failed
        		return array('success' => FALSE, 'errors' => '<ul><li>The email address you provided already exists for another account.</li></ul>');

        	}
        	else
        	{

	        	// Validation successful
	        	$db_data = array(
	        			'fullname' => $this->input->post('fullname'),
	        			'email' => $this->input->post('email'),
	        			'admin' => $this->input->post('admin')
	        		);

	        	// Update the database
	        	$this->db->where('id', $this->input->post('user_id'));
	        	$this->db->update('users', $db_data);

	        	// Now check for the passwords
	        	$password = trim($this->input->post('password'));
	        	$confirm_password = trim($this->input->post('confirm_password'));
	        	if ($password != '' && $confirm_password != '' && $password === $confirm_password)
	        	{

	        		// Update the passwords also
	        		$db_data = array('password' => sha1($password));
	        		$this->db->where('id', $this->input->post('user_id'));
	        		$this->db->update('users', $db_data);

	        	}	// Processing the passwords

	        	// Done ... return success
	        	return array('success' => TRUE);

        	}

        }	// Checking if validation was successful

	}	// End: update()



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
	 * Method to delete a user account
	 */
	public function delete($user_id)
	{

		// Check for a valid user ID
		if (is_null($user_id) || !$user_id || !is_numeric($user_id) || trim($user_id) == '')
		{

			// Invalid user ID
			return FALSE;
		}
		else
		{

			// Valid user ID
			$this->db->delete('users', array('id' => $user_id));
			return TRUE;

		}	// Checking for a valid user ID

	}	// End: delete()



}	// End class: User_Model

