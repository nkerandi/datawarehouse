<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sys_Model extends CI_Model
{

	// constructor
	public function __construct()
	{
		// put code here
		parent::__construct();
	}


    /**
     * Function: debug_array()
     * This method takes an array and dumps its contents in a human readable format
     */
    public function debug_array($arr, $return_string=NULL)
    {
        if ($return_string == 'YES')
        {
            // Create a string of the array
            $str = '';
            foreach ($arr as $key => $value) {
                $str .= strtoupper($key) . ': ' . $value . '; ';
            }
            // Remove the last two characters
            $length_of_str = strlen($str);
            $str = substr($str, 0, ($length_of_str-2));
            // Return the string
            return $str;
        }
        else
        {
            echo '<pre>';
            print_r($arr);
            echo '</pre>';
        }
    }   // End: debug_array()


	/**
	 * Clears the cache to remove any traces of a previous session
	 *
	 * This method clears the cache completely to avoid instances where you've logged out but when you go back
	 * in the browser, the previously loaded page (one that you've logged out already) is loaded as if you haven't
	 * logged out yet; this method totally clears the cache and enables redirecting to the login page
	 * 
	 */
    public function clear_cache()
    {

    	/**
    	 * Run the code to completely clear the cache
    	 */
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
        $this->output->set_header("Pragma: no-cache");

    }	// END: clear_cache()
    

}	// End class: Sys_Model