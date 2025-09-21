<?php

// module name
$HmvcMenu["website"] = array(
    //set icon
    "icon"           => "<i class='fa fa-globe'></i>", 

   'websites'  => array( 
        "controller" => "website",
        "method"     => "index",
        "permission" => "read"
    ), 

    // setting
    'web_setting'  => array( 
        "controller" => "setting",
        "method"     => "form",
        "permission" => "update"
    ), 
   
    // Email configuration
    'email_configue'  => array( 
        "controller" => "emails",
        "method"     => "form",
        "permission" => "update"
    ), 
    // offer
    'ticket_offer'  => array( 
        "controller" => "setting",
        "method"     => "offer",
        "permission" => "update"
    ),  



///////////////////////////////////////////
        // feedback
    "feedback" => array(  
        "controller" => "feedback",
        "method"     => "index",
        "permission" => "read"
    ), 

// downtime
    "downtime" => array(  
        "controller" => "Downtime",
        "method"     => "form",
        "permission" => "update"
    ), 

    //   // payemt_terms and condition
    "how_to_use" => array( 
       
            "controller" => "howtouse",
            "method"     => "form",
            "permission" => "read"
 
    ), 

     // payemt_terms and condition
    "term_andcondition" => array(
       
            "controller" => "terms",
            "method"     => "terms_and_condition_list",
            "permission" => "read"
 
    ), 

    // payemt_terms and condition
    "disclaimer" => array(
       
            "controller" => "disclaimer",
            "method"     => "disclaimer_form",
            "permission" => "read"
 
    ), 
    
);
   

 