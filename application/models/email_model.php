<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Email_Model extends CI_Model
{

	// constructor
	public function __construct()
	{
		// put code here
		parent::__construct();
	}

	// Method to send email about mentor registration
	public function mentor_registration($mentor_id)
	{
		
		// Start the email to both the 'mentor applicant' and the 'IHRM'
		$result = $this->db->get_where('mentors', array('id' => $mentor_id));
		$mentor = $result->row();
		$mentor_name = $mentor->firstname . ' ' . $mentor->surname;
		$mentor_email = $mentor->email;

		// Create the HTML message
		$html = '
		<html>
		<head><title>Registration as HR Mentor</title>
		<style type="text/css">
		body { font-family: Arial, Helvetica, sans-serif; font-size: 10pt; }
		</style>
		<body>
		<p>Dear '.$mentor->firstname.',</p>
		<p>Thank you for registering as a HR Mentor in the IHRM Mentorship Programme. We shall be in touch soon with more details regarding the programme and how you can make your valuable contribution.</p>
		<p>Best Regards,<br/>IHRM Mentorship Programme.</p>
		</body>
		</head>
		';

		// Set the email config variables
		$email_config = array(
				'mailtype' => 'html',
				'wordwrap' => TRUE
			);
		$this->email->initialize($email_config);

		// Send the email
		$this->email->from('mentorship@ihrm.or.ke', 'IHRM Mentorship');
		$this->email->to($mentor_email);
		$this->email->bcc('mentorship@ihrm.or.ke', 'IHRM Mentorship');

		$this->email->subject('Registration as HR Mentor - ' . $mentor_name);
		$this->email->message($html);	

		$this->email->send();

	}	// End: mentor_registration()

	// Method to send email about mentee registration
	public function mentee_registration($mentee_id)
	{
		
		// Start the email to both the 'mentee applicant' and the 'IHRM'
		$result = $this->db->get_where('mentees', array('id' => $mentee_id));
		$mentee = $result->row();
		$mentee_name = $mentee->firstname . ' ' . $mentee->surname;
		$mentee_email = $mentee->email;

		// Create the HTML message
		$html = '
		<html>
		<head><title>Registration as HR Mentee</title>
		<style type="text/css">
		body { font-family: Arial, Helvetica, sans-serif; font-size: 10pt; }
		</style>
		<body>
		<p>Dear '.$mentee->firstname.',</p>
		<p>Thank you for signing up for mentoring under the IHRM Mentorship Programme. We shall be in touch soon with more details regarding the mentoring timetable and associated programmes.</p>
		<p>Best Regards,<br/>IHRM Mentorship Programme.</p>
		</body>
		</head>
		';

		// Set the email config variables
		$email_config = array(
				'mailtype' => 'html',
				'wordwrap' => TRUE
			);
		$this->email->initialize($email_config);

		// Send the email
		$this->email->from('mentorship@ihrm.or.ke', 'IHRM Mentorship');
		$this->email->to($mentee_email);
		$this->email->bcc('mentorship@ihrm.or.ke', 'IHRM Mentorship');

		$this->email->subject('Registration for HR Mentorship - ' . $mentee_name);
		$this->email->message($html);	

		$this->email->send();

	}	// End: mentor_registration()

}	// End class: Email_Model