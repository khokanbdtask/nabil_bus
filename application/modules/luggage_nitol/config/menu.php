<?php

// module name
$HmvcMenu["luggage_nitol"] = array(
    //set icon
    "icon"           => "<i class='fa fa-suitcase'></i>",


    // luggage
    "luggage_info" => array(
        'add_luggage'    => array(
            "controller" => "luggage",
            "method"     => "form",
            "permission" => "create"
        ),
        'luggage_list'  => array(
            "controller" => "luggage",
            "method"     => "index",
            "permission" => "read"
        ),
        "unpaid_cash_luggage_list" => array(
        "controller" => "luggage",
        "method"     => "unpaid_cash_booking",
        "permission" => "read"
        ),
        
        // "luggage_confirmation" => array(
        //     "controller" => "luggage",
        //     "method"     => "confirmation",
        //     "permission" => "read"
        // ),

    ), 

//// Report
    
    "luggage_report" => array( 
       
            "controller" => "luggage_report",
            "method"     => "index",
            "permission" => "read"
    ),




//confirmation
   
  
    // refund
    // "refund" => array( 
    //     'add_refund'    => array( 
    //         "controller" => "refund",
    //         "method"     => "form",
    //         "permission" => "create"
    //     ), 
    //     'refund_list'  => array( 
    //         "controller" => "refund",
    //         "method"     => "index",
    //         "permission" => "read"
    //     ), 
    // ), 
    
    
        // refund
    "refund_luggage" => array(
        'add_refund_luggage'    => array(
            "controller" => "refund",
            "method"     => "form",
            "permission" => "create"
        ), 
        'refund_list_luggage'  => array(
            "controller" => "refund",
            "method"     => "index",
            "permission" => "read"
        ), 
    ), 

  
    'package_list'   => array(
        "controller" => "packages",
        "method"     => "index",
        "permission" => "read"
    ),

    'luggage_other_location' => array(
            'controller' => "packages",
            'method' => 'luggageOtherLocation',
            'permission' => 'read'
        ),
  
);
   

 