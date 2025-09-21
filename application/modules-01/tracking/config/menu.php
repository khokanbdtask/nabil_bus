<?php
// module name
$HmvcMenu["tracking"] = array(
    // set icon
    "icon" => "<i class='fa fa-gift' aria-hidden='true'></i>", 
    
    'tracking_list'   => array(  
        "controller" => "tracking_controller",
        "method"     => "tracking_list",
        "permission" => "read"
    ), 

    'add_tracking'   => array(  
        "controller" => "tracking_controller",
        "method"     => "tracking_insert",
        "permission" => "read"
    ), 
);


