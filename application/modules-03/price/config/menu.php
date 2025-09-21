<?php
$HmvcMenu["price"] = array(
	
    "icon" => "<i class='fa fa-money' aria-hidden='true'></i>", 
    
    'price_list'   => array( 
        "controller" => "price_controller",
        "method"     => "create_price",
        "permission" => "read"
    ) ,

    //// For luggage module, it works for weight range with a price 

    // 'price_luggage_list'   => array(
    // "controller" => "price_luggage_controller",
    // "method"     => "create_price",
    // "permission" => "read"
    // )
 );
 