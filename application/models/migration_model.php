<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Model extends CI_Model
{

	/**
	 * Constructor for the class
	 */
	public function __construct()
	{

		// Run the parent constructor
		parent::__construct();

		// Load the required libraries
		$this->load->library(array('PasswordHash'));

	}	// End: __construct()

	/**
	 * Method to create the user accounts to be used in the system i.e. basic user accounts
	 * @author Nicholas Kerandi (nkerandi@netmedia.co.ke)
	 * @access public
	 * @return boolean
	 */
	public function init()
	{

		// Truncate the table
		$this->db->truncate('persons');
		$this->db->truncate('users');
		echo '<div style="font-family: \'Courier New\', sans-serif; font-size: 8pt;">';
		echo '<p>Tables Users & Persons truncated successfully ...</p>';
		
		// Create the users array
		$persons = array(
				array(
					'firstname' => 'Nicholas',
					'surname' => 'Kerandi',
					'othernames' => '',
					'date_of_birth' => '1978-02-18',
					'gender' => 'MALE',
					'country_id' => 1,
					'postal_address' => 'P.O. Box 54225-00200, Nairobi, KENYA',
					'mobile_number' => '0722828835',
					'email' => 'nicholas.kerandi@fao.org',
					'organization' => 'FAO/FSNAU',
					'job_title' => 'Database & Applications Developer',
					'photo' => '',
					'password' => 'password'
					),
				array(
					'firstname' => 'Kiprotich',
					'surname' => 'Chemweno',
					'othernames' => '',
					'date_of_birth' => '1980-04-01',
					'gender' => 'MALE',
					'country_id' => 1,
					'postal_address' => 'P.O. Box 1230, Village Market, Nairobi, KENYA',
					'mobile_number' => '4000500',
					'email' => 'kiprotich.chemweno@fao.org',
					'organization' => 'FAO/FSNAU',
					'job_title' => 'Database & Applications Developer',
					'photo' => '',
					'password' => 'password'
					),
				array(
					'firstname' => 'Daniel',
					'surname' => 'Kimani',
					'othernames' => '',
					'date_of_birth' => '1990-09-03',
					'gender' => 'MALE',
					'country_id' => 1,
					'postal_address' => 'P.O. Box 1230, Village Market, Nairobi, KENYA',
					'mobile_number' => '4000500',
					'email' => 'daniel.kimani@fao.org',
					'organization' => 'FAO/FSNAU',
					'job_title' => 'DST Assistant',
					'photo' => '',
					'password' => 'password'
					),
				array(
					'firstname' => 'Mary',
					'surname' => 'Peter',
					'othernames' => 'Weveti',
					'date_of_birth' => '1980-07-23',
					'gender' => 'FEMALE',
					'country_id' => 1,
					'postal_address' => 'P.O. Box 1230, Village Market, Nairobi, KENYA',
					'mobile_number' => '4000500',
					'email' => 'mary.peter@fao.org',
					'organization' => 'FAO/FSNAU',
					'job_title' => 'Data Processor',
					'photo' => '',
					'password' => 'password'
					)
			);

		// Iterate through the array
		foreach ($persons as $person) {
			
			// Grab the details and check the db for the record
			$num_records = $this->db->get_where('persons', array('email' => $person['email']))->num_rows();

			// Check for the number of rows returned
			if ($num_records == 0)
			{

				// Save the password to a temporary variable and then remove the password field from
				// array being used to create the account
				$password = $person['password'];
				unset($person['password']);

				// Person doesn't exist; save the record to the db
				$this->db->insert('persons', $person);

				// Grab the just inserted record's ID
				$person_id = $this->db->insert_id();

				// Notify the user
				echo '<p>Person Account created for ' . $person['firstname'] . ' of email ' . $person['email'] . ' and ID of '.$person_id.'</p>';

				// Now create a user account for the same person
				$db_data = array(
						'person_id' => $person_id,
						'password' => $this->passwordhash->HashPassword($password),
						'account_status' => 'ACTIVE'
					);

				// Insert the record
				$this->db->insert('users', $db_data);

				// Notify the user
				echo '<p>User Account created for ' . $person['firstname'] . ' with password: ' . $this->passwordhash->HashPassword($password) . '</p>';

			}
			else
			{

				// Account already exists
				echo '<p style="color: #f00;">The account for ' . $person['firstname'] . ' with email ' . $person['email'] . ' already exists!</p>';

			}	// Checking if record exists

		}	// Iterating through the persons

		// Return TRUE that the deed is done
		echo '<p>Done!</p>';
		echo '</div>';

	}	// End: migration()



	/**
	 * Method to list users based on the hashing function
	 */
	public function users()
	{

		// Initialize the array of users
		$users = array(
				array('email' => 'nicholas.kerandi@fao.org', 'password' => 'password'),
				array('email' => 'kiprotich.chemweno@fao.org', 'password' => 'password'),
				array('email' => 'daniel.kimani@fao.org', 'password' => 'password'),
				array('email' => 'mary.peter@fao.org', 'password' => 'password')
			);

		// Start the formatting of the output
		echo '<div style="font-family: \'Courier New\', sans-serif; font-size: 8pt;">';

		// Iterate through and see if you can find the records
		foreach ($users as $user)
		{

			// Get the email and query the database
			$rs = $this->db->get_where('persons', array('email' => $user['email']));
			if ($rs->num_rows() == 1)
			{

				// Record found
				$row = $rs->row();
				echo '<p>Record found for '.$row->firstname.' of ID '.$row->id.'</p>';

				// Now using the user ID ... find the corresponding password
				$rs_user = $this->db->get_where('users', array('id' => $row->id));
				if ($rs_user->num_rows() == 1)
				{

					// Record found i.e. password matches
					echo '<p>Matching record found for ID '.$row->id.' in users table!</p>';

					// Grab the newly returned record
					$user_record = $rs_user->row();

					// Let's now match the passwords and see if they are identical
					$passwords_match = $this->passwordhash->CheckPassword($user['password'], $user_record->password);

					// Check if they match
					if ($passwords_match)
					{

						// Passwords match
						echo '<p>Yeeeehaawwww! Passwords match!!!</p>';

					}
					else
					{

						// Passwords don't match
						echo '<p style="color: red;">Passwords DONT match!!!</p>';

					}	// Checking if passwords match

				}
				else
				{

					// Record not found i.e. password didn't match
					echo '<p>No matching record found for ID '.$row->id.' in users table! Try again ...</p>';

				}	// Checking if password matches

			}
			else
			{

				// Record not found
				echo '<p>Record not found for email '.$user['email'].'</p>';

			}	// Checking if record was found

		}	// Iterating through the users

		// Close the formatting of the output
		echo '</div>';

	}	// End: users()


}	// End class: Migration_model

