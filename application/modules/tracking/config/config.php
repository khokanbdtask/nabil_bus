<?php
// module directory name
$HmvcConfig['tracking']["_title"]       = "tracking";
$HmvcConfig['tracking']["_description"] = "Fleet Tracking";


// register your module tables
// only register tables are imported while installing the module
$HmvcConfig['tracking']['_database'] = true;
$HmvcConfig['tracking']['_extra_query'] = true;
$HmvcConfig['tracking']['_uninstall_query'] = true;
$HmvcConfig['tracking']["_tables"] = array(
	'tracking', 
);
