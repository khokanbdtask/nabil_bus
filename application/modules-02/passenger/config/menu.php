<?php

// module name
$HmvcMenu["passenger"] = array(
    //set icon
    "icon"           => "<i class='fa fa-user'></i>",

    // // passenger
    
        'add_passenger'    => array(
            "controller" => "passenger",
            "method"     => "form",
            "permission" => "create"
        ), 
        'passenger_list'  => array(
            "controller" => "passenger",
            "method"     => "index",
            "permission" => "read"
        ), 
    

  
);
   

 