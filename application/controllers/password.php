<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Password extends CI_Controller
{

	// constructor
	public function __construct()
	{

		// put code here
		parent::__construct();

	}	// End: __construct()


	// Default method
	public function index()
	{

		// Redirect to login page
		redirect(site_url('welcome'), 'refresh');

	}	// End: index()


	// default method
	public function forgot()
	{

		// Check for a posted form
		if ($_POST)
		{

			// A form has been posted
			die('Sending you an email with a reset link ...');

		}	// Checking for a form being posted

		// Load the form for retrieving a forgotten password
		$data = array(
				'view' => 'password/index'
			);

		// Load the page
		$this->load->view('templates/main', $data);

	}	// end: forgot()


}	// End Class: Password


/* End of file password.php */
/* Location: ./application/controllers/password.php */