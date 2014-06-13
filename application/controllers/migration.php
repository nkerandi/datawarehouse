<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Migration extends CI_Controller
{


	/**
	 * Constructor for the class
	 */
	public function __construct()
	{

		// Call the parent constructor
		parent::__construct();

		// Load the required models
		$this->load->model(array('migration_model'));

	}	// End: __construct()


	/**
	 * Method to call the model method for initializing the users table
	 */
	public function index()
	{
		$this->migration_model->init();
	}


	/**
	 * Method to test if reverse hashing works
	 */
	public function users()
	{
		$this->migration_model->users();
	}


}	// End class: Migration
