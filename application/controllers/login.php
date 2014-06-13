<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller
{

	// constructor
	public function __construct()
	{

		// put code here
		parent::__construct();

		// Load the required models
		$this->load->model(array('login_model'));

	}	// end: __construct()


	// default method
	public function index($msg = NULL)
	{

		// Check if the user is logged in
		

		// Check for posted form
		if ($_POST)
		{

			// User has attempted to log in
			die('Authenticating your login details ...');

		}	// Checking for login form posting

		// Load the page with the login form
		$this->load->view('login/index');

	}	// End: index()


	// Method to populate the db
	private function migration()
	{

		// Populate the db with users
		$this->login_model->migration();
		

	}	// end: migration()


}	// end class: Login