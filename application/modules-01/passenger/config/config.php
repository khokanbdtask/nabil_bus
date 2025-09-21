<?php
/*
|___________________________________________________________________
|	-> Configuration variable name must be $HmvcConfig
|	-> Module Name must be unique 
|	-> Module Name must be same as the module directory
|	-> Set a title and description 
|	-> Set true/false if module have database 
|	-> Must be register your database tables
|___________________________________________________________________
|
*/
 
$HmvcConfig['passenger']["_title"]       = "Passenger";
$HmvcConfig['passenger']["_description"] = "Simple Luggage Management System";

//Set true/false if module have database 
$HmvcConfig['passenger']['_database'] = true;

// register your module tables. only register tables are imported while installing the module
$HmvcConfig['passenger']["_tables"] = array(
	'tkt_passenger'
);
