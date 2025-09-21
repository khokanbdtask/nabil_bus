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
 
$HmvcConfig['luggage_nitol']["_title"]       = "Luggage Management";
$HmvcConfig['luggage_nitol']["_description"] = "Simple Luggage Management System";

//Set true/false if module have database 
$HmvcConfig['luggage_nitol']['_database'] = true;

// register your module tables. only register tables are imported while installing the module
$HmvcConfig['luggage_nitol']["_tables"] = array(
	'tkt_passenger',
	'luggage_booking',
	'luggage_refund',
	'tkt_feedback',
	'luggage_referal',
	'luggage_booking_downtime'
);
