<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Signup extends CI_Controller
{

	// constructor
	public function __construct()
	{

		// put code here
		parent::__construct();

	}	// End: __construct()


	// default method
	public function index()
	{

		// Load the form for signing up a new user
		$data = array(
				'view' => 'signup/index'
			);

		// Load the page
		$this->load->view('templates/main', $data);

	}	// end: index()


}	// End Class: Signup


/* End of file signup.php */
/* Location: ./application/controllers/signup.php */