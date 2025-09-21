<?php
$HmvcMenu["tax"] = array(
	
    "icon" => "<i class='fa fa-dollar' aria-hidden='true'></i>", 
    
    'tax_list'   => array( 
        "controller" => "tax",
        "method"     => "tax_settings_updateform",
        "permission" => "read"
    ) ,

// 'income_tax'   => array( 
//         "controller" => "tax",
//         "method"     => "bdtask_income_tax",
//         "permission" => "read"
//     ) ,

// 'manage_income_tax'   => array( 
//         "controller" => "tax",
//         "method"     => "manage_income_tax",
//         "permission" => "read"
//     ) ,

// 'tax_reports'   => array( 
//         "controller" => "tax",
//         "method"     => "bdtask_tax_report",
//         "permission" => "read"
//     ) ,

'invoice_wise_tax_report'   => array( 
        "controller" => "tax",
        "method"     => "invoice_wise_tax_report",
        "permission" => "read"
    ) 

);
 
   