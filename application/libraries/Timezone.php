<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/// timezone

// require './application/config/database.php';

class Timezone {

  public function __construct()
  {
  		$CI =& get_instance();
		$CI->load->database();
            //// TIME ZONE SET ACCORDING TO USER's Given timezone in WEBSITE SETTINGS
        $timezone = $CI->db->select('*')->from('ws_setting')->get()->row();
        date_default_timezone_set($timezone->timezone);
        date_default_timezone_get();

  }

}
