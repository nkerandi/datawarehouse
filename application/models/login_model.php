<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login_Model extends CI_Model
{


	// constructor
	public function __construct()
	{
		// put code here
		parent::__construct();
	}


	// Method to validate login details
	public function authenticate()
	{
		
		// Do the form validation checks
        $config = array(
            array('field' => 'email', 'label' => '<strong>Email</strong>', 'rules' => 'required|valid_email|xss_clean'),
            array('field' => 'password', 'label' => '<strong>Password</strong>', 'rules' => 'required|xss_clean')
        );

        // Load validation library
        $this->load->library('form_validation');

        // Load the validation rules
        $this->form_validation->set_rules($config);

        // Run the validation
        if ($this->form_validation->run() == FALSE)
        {

            // Validation failed ... return error messages
            return FALSE;

        }
        else
        {

        	// Validation passed ... now authenticate the user
        	$result = $this->db->get_where('users', array('email' => $this->input->post('email'), 'password' => sha1($this->input->post('password'))));

        	// Check for the # of records
        	if ($result->num_rows() <= 0)
        	{

        		// Error ... return false
        		return FALSE;

        	}
        	else
        	{

        		// Success ... get the record
        		$user = $result->row();

        		// Create the sessions
        		$session_variables = array(
        				'user_id' => $user->id,
        				'fullname' => $user->fullname,
        				'email' => $user->email,
        				'admin' => $user->admin
        			);

        		// Set the session
        		$this->session->set_userdata($session_variables);

        		// Return true
        		return TRUE;

        	}	// End: checking if the login details were valid

        }	// Checking if validation ran successfully

	}	// End: authenticate()


	// migration
	public function migration()
	{

		// Truncate the table
		$this->db->truncate('users');
		echo 'Users table truncated ...<br/>';
		
		// Create the users array
		$users = array(
				array('fullname' => 'IHRM Administrator', 'email' => 'admin@ihrm.or.ke', 'password' => 'HR3s0nrC3', 'admin' => 'YES'),
				array('fullname' => 'Nicholas Kerandi', 'email' => 'nkerandi@netmedia.co.ke', 'password' => 'P@$$word2012', 'admin' => 'YES'),
				array('fullname' => 'Samson Osero', 'email' => 'samson.osero@ihrm.or.ke', 'password' => '0S3r02014', 'admin' => 'YES'),
				array('fullname' => 'Rebecca Muriithi', 'email' => 'rebecca.muriithi@ihrm.or.ke', 'password' => 'R3B3cc@2012', 'admin' => 'NO')
			);

		// Iterate through the array
		foreach ($users as $user) {
			
			// grab the details and check the db for the record
			$result = $this->db->get_where('users', array('email' => $user['email']));
			if ($result->num_rows() == 0)
			{
				// record doesn't exist
				$data = array(
						'fullname' => $user['fullname'],
						'email' => $user['email'],
						'password' => sha1($user['password']),
						'admin' => $user['admin']
					);
				// save the record to the db
				$this->db->insert('users', $data);
				// notify ...
				echo 'Account created for ' . $user['fullname'] . '<br/>';
			}	// checking if record exists

		}	// end: migration()

		// Now proceed to log in ..
		echo 'Done! <a href="' . site_url('login') . '">Login in</a>';		

	}	// end: migration()


	// authenticate



}	// End class: Login_Model