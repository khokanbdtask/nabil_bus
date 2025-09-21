<?php

// module directory name
$HmvcConfig['addon']["_title"]     = "Your Module";
$HmvcConfig['addon']["_directory"] = "your_module";
//$HmvcConfig['addon']["_image"]     = "application/modules/addon/assets/images/thumbnail.jpg";
//$HmvcConfig['addon']["_description"] = "Simple Your Module";

// register your module tables
// only register tables are imported while installing the module
$HmvcConfig['your_module']['_database'] = true;
$HmvcConfig['your_module']["_tables"] = array(
    'module',
    'themes',
);
