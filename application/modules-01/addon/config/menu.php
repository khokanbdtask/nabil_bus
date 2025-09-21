<?php

// module name
$HmvcMenu["addon"] = array(
    //set icon
    "icon"           => "<i class='fa fa-cubes'></i>",

    //menu name
    "theme" => array(
        "controller" => "Theme",
        "method"     => "index",
        "permission" => "create"
    ),

    "module" => array(
        "controller" => "Module",
        "method"     => "index",
        "permission" => "create"
    ),

);