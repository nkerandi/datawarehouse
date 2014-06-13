<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_Model extends CI_Model
{


	// constructor
	public function __construct()
	{
		// put code here
		parent::__construct();
	}

	// Method to check if the user is logged in
	public function is_logged_in()
	{

		// Simply check if there is a valid session
		if ($this->session->userdata('user_id') <= 0)
		{

			// Redirect to the login page
			redirect(site_url('login'), 'refresh');
			exit();

		}	// Check for valid USER_ID in session variable

		// return true
		return TRUE;

	}	// End: is_logged_in()


	// Method to check if someone is an admin
	public function is_admin()
	{
		
		// Check if the user is an admin
		if ($this->session->userdata('admin') != 'YES')
		{

			// Not an admin ... redirect
			redirect(site_url('admin'), 'refresh');
			exit();

		}	// Checking if user's session admin variable is YES

		// User is an admin
		return TRUE;

	}	// End: is_admin()


	// Method for generating admin menu
	public function menu($current_menu = NULL)
	{

		// Create an array of admin menu items
		$admin_menu_items = array('user');

		// create array of all menu items
		$menu = array(
				array('name' => 'home', 'text' => 'Home', 'url' => site_url('admin')),
				array('name' => 'mentor', 'text' => 'Mentors', 'url' => site_url('admin/mentors')),
				array('name' => 'mentee', 'text' => 'Mentees', 'url' => site_url('admin/mentees')),
				array('name' => 'user', 'text' => 'Users', 'url' => site_url('admin/users')),
				array('name' => 'logout', 'text' => 'Logout', 'url' => site_url('admin/logout'))
			);

		// iterate through the menu items and set the current menu
		$menu_html = '<div class="site-menu pull-right"><ul class="nav nav-pills">';
		foreach ($menu as $menu_item) 
		{

			// Check to ensure that an admin menu item is not displayed by mistake
			// if (in_array($menu_item['name'], $admin_menu_items) && $this->session->userdata('admin') == 'NO')
			// {

			// 	// Then display the item ... otherwise don't
			// 	break;	// Exit the loop

			// }	// Checking if a menu item is an admin menu item
			
			// check for the menu item
			$active_menu = ($menu_item['name'] == $current_menu) ? ' class="active"' : '';
			$badge = '';
			if ($menu_item['name'] == 'mentor' || $menu_item['name'] == 'mentee')
			{
				// get the table
				$table_name = ($menu_item['name'] == 'mentor') ? 'mentors' : 'mentees';
				// Run the query
				$record_count = $this->db->count_all($table_name);
				// Create the badge
				if ($record_count > 0)
				{
					$badge = '<span class="badge">'.$record_count.'</span>';
				}
			}
			$menu_html .= '<li'.$active_menu.'><a href="'.$menu_item['url'].'">'.$menu_item['text'] . $badge . '</a></li>';

		}	// iterating through the menu items

		// close off the menu
		$menu_html .= '</ul></div>';

		// return the menu
		return $menu_html;

	}	// end: menu()


}	// End class: Membership_Model