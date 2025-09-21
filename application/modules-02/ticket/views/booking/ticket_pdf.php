<style type="text/css">

/*ticket*/
.row {
    margin-right: -15px;
    margin-left: -15px;
    }

     {
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
    }

    div {
        display: block;
    }
    .passanger-info {
        background-color: #f6f8fa;
        padding: 15px 5px;
        margin-bottom: 20px;
        margin-right: -20px;
        margin-left: -20px;
        border-top: 1px solid #e1e6ef;
        border-bottom: 1px solid #e1e6ef;
    }

    .well {
        margin-bottom: 0;
        background-color: #f1f5f8;
        border-radius: 0;
        -webkit-box-shadow: none;
        box-shadow: none;
        margin-top: 15px;
    }
    .ticket-inner {
        float:left;
        width:100%;
        border: 1px solid #e3e3e3;
        height: auto;
        padding: 10px;
    }
        
    .seat {
        margin: 5px 0;
        color:#fff;
    }

    .price-details tr:last-child th:first-child{
        text-align: left;
    } 
    .table-striped > tbody > tr:nth-of-type(2n+1) {
        background-color: #fff;
    }
    .table-striped > tbody > tr:nth-of-type(2n+2) {
        background-color: #f9f9f9;
    }
    .price-details p {
        margin: 0 0 15px;
        font-size: 14px;
    }

    .table-bordered>tbody>tr>td, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>td, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>thead>tr>th {
        border: 1px solid #ddd;
    }
    .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
        padding: 8px;
        line-height: 1.42857143;
        vertical-align: top;
        border-top: 1px solid #ddd;
    }
    td, th {
        padding: 0;
    }
    .table{
        width: 100%;
    }
    .ticket-content .table > thead > tr > th {
        border-bottom: 1px solid #ddd;
        color: #000;
    }
    li {
        display: list-item;
        text-align: -webkit-match-parent;
    }
    .list-unstyled {
        padding-left: 0;
        list-style: none;
    }
    user agent stylesheet
    ul, menu, dir {
        display: block;
        list-style-type: none;
        -webkit-margin-before: 1em;
        -webkit-margin-after: 1em;
        -webkit-margin-start: 0px;
        -webkit-margin-end: 0px;
        -webkit-padding-start: 40px;
    }
    {
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
    }
    /*user agent stylesheet*/
    li {
        display: list-item;
        text-align: -webkit-match-parent;
    }
    .list-unstyled {
        padding-left: 0;
        list-style: none;
    }
    .text-right {
        text-align: right;
    }
    table {
        border-spacing: 0;
        border-collapse: collapse;
    }
    user agent stylesheet
    table {
        display: table;
        border-collapse: separate;
        border-spacing: 2px;
        border-color: grey;
    }
    body {
        font-family: 'Open Sans', sans-serif;
        font-size: 13px;
        color: #828282;
        overflow-x: hidden;
        overflow-y: auto;
    }
    body {
        font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
        font-size: 14px;
        line-height: 1.42857143;
        color: #333;
        background-color: #fff;
    }

    .ticket-content {
        border: 1px solid #e1e6ef;
        padding: 20px;
    }

    .ticket-logo img {
        background: #e1e6ef !important;
        height: 40px !important;
    }
    .list-unstyled {
        padding-left: 0;
        list-style: none;
    }
    .ticket-content strong {
        color: #000;
        font-weight: 600;
    }
</style>

<div class="clearfix"></div>

<div class="ticket-info">
    <div class="container">
        <div class="row">

            <div class="col-sm-12 col-md-8 col-md-offset-2"  style="margin-bottom:20px">
                 <div class="btn-group">
                    <button type="button" onclick="printContent('PrintMe')" class="btn btn-danger"><i class="fa fa-print"></i></button> 
                </div>
            </div>


            <div class="col-sm-12 col-md-8 col-md-offset-2" id="PrintMe">
                <div class="ticket-content">
                    <div class="table-responsive">
                        <table style="width:100%;">
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="ticket-logo">
                                            <img src="<?php echo base_url($appSetting->logo); ?>"  alt="BDTASK BUS 365">
                                            
                                        </div>
                                    </td>
                                    <td style="vertical-align:middle;">
                                        <p class="text-right"><strong><?php echo display('phone') ?> : </strong><?php echo (!empty($appSetting->phone)?$appSetting->phone:null) ?></p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
 
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <td><strong><?php echo display('pickup_location') ?>:</strong> <span><?php echo (!empty($ticket->pickup_trip_location)?$ticket->pickup_trip_location:null) ?></span></td>
                                    <td><strong><?php echo display('drop_location') ?>:</strong> <span><?php echo (!empty($ticket->drop_trip_location)?$ticket->drop_trip_location:null) ?></span></td>
                                    <td><strong><?php echo display('date') ?>:</strong> <span><?php echo (!empty($ticket->booking_date)?$ticket->booking_date:null) ?></span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="passanger-info table-responsive">
                        <div class="col-sm-12">
                            <table width="100%">
                                <tr>
                                    <td>
                                        <ul class="list-unstyled">
                                           <li><strong><?php echo display('passenger_name') ?> :</strong>
                                            <?php echo (!empty($ticket->passenger_name)?$ticket->passenger_name:null) ?>
                                            </li>
                                             <li><strong><?php echo display('nid') ?> :</strong>
                                            <?php echo (!empty($ticket->nid)?$ticket->nid:null) ?>
                                            </li>
                                            <li><strong><?php echo display('phone') ?> :</strong>
                                                <?php echo (!empty($appSetting->phone)?$appSetting->phone:null) ?></li>
                                                  <li>
                                            <strong><?php echo display('passenger_id') ?> :</strong> 
                                            <?php echo (!empty($ticket->tkt_passenger_id_no)?$ticket->tkt_passenger_id_no:null) ?></li>
                                            <li>
                                            <li><strong><?php echo display('facilities') ?> :</strong>
                                                <ul class="list-inline">
                                                <?php
                                                    foreach(explode(',', $ticket->request_facilities) AS $facilities) 
                                                    {
                                                        echo (!empty(trim($facilities))?"<li>&radic;$facilities</li>":null);
                                                    }
                                                ?>
                                                </ul>
                                            </li>
                                        </ul>
                                    </td>
                                    <td>  
                                        <ul class="list-unstyled text-right" >
                                            <li><strong><?php echo display('booking_id') ?> :</strong>
                                                <?php echo (!empty($ticket->booking_id_no)?$ticket->booking_id_no:null) ?></li>
                                                 <li><strong><?php echo display('route_name') ?> :</strong>
                                            <?php echo (!empty($ticket->route_name)?$ticket->route_name:null) ?></li>
                                            <li>
                                            <strong><?php echo display('trip_id') ?> :</strong> 
                                            <?php echo (!empty($ticket->trip_id_no)?$ticket->trip_id_no:null) ?></li>
                                        </ul>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <!-- Ticket Information -->
                         <div class="table-responsive">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <td><strong><?php echo display('pickup_location') ?>
                                        :</strong> <?php echo(!empty($pickup->name) ? $pickup->name : null) ?>
                                </td>
                                <td><strong><?php echo display('drop_location') ?>
                                        :</strong> <?php echo(!empty($drop->name) ? $drop->name : null) ?>
                                </td>
                                    <td><strong><?php echo display('date') ?>:</strong> <?php echo (!empty($ticket->booking_date)?$ticket->booking_date:null) ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="passanger-info table-responsive">
                        <div class="col-sm-12">
                            <table width="100%">
                                <tr>
                                    <td>
                                        <ul class="list-unstyled">
                                          <li><strong><?php echo display('passenger_name') ?> :</strong>
                                            <?php echo (!empty($ticket->passenger_name)?$ticket->passenger_name:null) ?>
                                            </li>
                                             
                                            <li><strong><?php echo display('phone') ?> :</strong>
                                                <?php echo (!empty($appSetting->phone)?$appSetting->phone:null) ?></li>
                                                  <li>
                                            <strong><?php echo display('passenger_id') ?> :</strong> 
                                            <?php echo (!empty($ticket->tkt_passenger_id_no)?$ticket->tkt_passenger_id_no:null) ?></li>
                                            <li>
                                            <li><strong><?php echo display('facilities') ?> :</strong>
                                                <ul class="list-inline">
                                                <?php
                                                    foreach(explode(',', $ticket->request_facilities) AS $facilities) 
                                                    {
                                                        echo (!empty(trim($facilities))?"<li>&radic;$facilities</li>":null);
                                                    }
                                                ?>
                                                </ul>
                                            </li>
                                        </ul>
                                    </td>
                                    
                                    <td>  
                                        <dl class="list-unstyled text-right">
                                             <li><strong><?php echo display('booking_id') ?> :</strong>
                                                <?php echo (!empty($ticket->id_no)?$ticket->id_no:null) ?></li>
                                                 <li><strong><?php echo display('route_name') ?> :</strong>
                                            <?php echo (!empty($ticket->route_name)?$ticket->route_name:null) ?></li>
                                            <li>
                                            <strong><?php echo display('trip_id') ?> :</strong> 
                                            <?php echo (!empty($ticket->trip_id_no)?$ticket->trip_id_no:null) ?></li>
                                            <strong><?php echo display('payment_status');?> :</strong> 
                                            <?php $payment=$ticket->payment_status;
                                            if($payment == 1){
                                           echo display('unpaid');
                                            }else{
                                            echo display('paid');}?></li>
                                        </dl>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th><?php echo display('seat_name'); ?></th>
                                            <th><?php echo display('adult'); ?></th>
                                            <th><?php echo display('child'); ?></th>
                                            <th><?php echo display('special'); ?></th>
                                            <th class="text-right"><?php echo display('amount'); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                         <?php 



                                         $total_price=$ticket->adult*$pricess->price+$ticket->child*$pricess->children_price+$ticket->special*$pricess->special_price;

                                         $ticket_price =$total_price-$ticket->discount;

                                            if($ticket->booking_type == 'Bank'){
                                            $total_commission=($total_price*$appSetting->bank_commission)/100;}else{
                                             $total_commission = 0;   
                                            }?>
                                        <tr>
                                            <td><?php echo (!empty($ticket->seat_numbers)?(str_replace(',', ', ', $ticket->seat_numbers)):null) ?></td>
                                            <td  class="text-right"><?php echo (!empty($ticket->adult)?$ticket->adult:0) ?></td>
                                            <td  class="text-right"><?php echo (!empty($ticket->child)?$ticket->child:0) ?></td>
                                            <td  class="text-right"><?php echo (!empty($ticket->special)?$ticket->special:0) ?></td>
                                            <th class="text-right">
                        <?php 
                            echo ($appSetting->currency_placement == 'Left')?$appSetting->currency:''; 
                        ?>
                                    <?php echo $price = (!empty($ticket->price)?number_format($ticket->price-$total_commission,3):0) ?> 
                        <?php 
                            echo ($appSetting->currency_placement == 'Right')?$appSetting->currency:''; 
                        ?>
                                            </th>
                                        </tr>
                                       
                                    </tbody>
                                    <tfoot>
                                         <tr>
                                         
                                            <th colspan="4"  class="text-right"><?php echo display('discount'); ?></th>
                                            <th class="text-right">
                        <?php 
                            echo ($appSetting->currency_placement == 'Left')?$appSetting->currency:''; 
                        ?>
                                    <?php echo $discount = (!empty($ticket->discount)?number_format($ticket->discount,3):0) ?> 
                        <?php 
                            echo ($appSetting->currency_placement == 'Right')?$appSetting->currency:''; 
                        ?>
                                                
                                            </th>
                                        </tr> 
                                         <?php if($ticket->booking_type == 'Bank'){ 
                                        ?>
                                        <tr>
                                            <td colspan="3"></td>
                                            <th  class="text-right"><?php echo display('bank_charge'); ?></th>
                                            <th class="text-right">
                                                <?php 
                            echo ($appSetting->currency_placement == 'Left')?$appSetting->currency:''; 
                        ?>
                                    <?php
                                            echo number_format($total_commission,3);
                                            echo "(".$appSetting->bank_commission.'%'.")"
                                    ?> 
                        <?php 
                            echo ($appSetting->currency_placement == 'Right')?$appSetting->currency:''; 
                        ?>
                                                

                                            </th>
                                        </tr> 
                                        <?php }?>
                                        <tr>
                                            <td colspan="3"></td>
                                            <th class="text-right"><?php echo display('total_tax')."(".$ticket->total_tax."%)"; ?></th>
                                            <th class="text-right">
                        <?php 
                            echo ($appSetting->currency_placement == 'Left')?$appSetting->currency:''; 
                        ?>
                                    <?php echo number_format((($ticket_price*$ticket->total_tax)/100),3); ?>
                        <?php 
                            echo ($appSetting->currency_placement == 'Right')?$appSetting->currency:''; 
                        ?>
                                            </th>
                                        </tr>
                                        <tr>
                                            
                                            <th colspan="4"  class="text-right"><?php echo display('grand_total'); ?></th>
                                            <th class="text-right">
                        <?php 
                            echo ($appSetting->currency_placement == 'Left')?$appSetting->currency:''; 
                        ?>
                                    <?php echo number_format($ticket->amount,3) ?> 
                        <?php 
                            echo ($appSetting->currency_placement == 'Right')?$appSetting->currency:''; 
                        ?>
                                            </th>
                                        </tr>
                                        
                                    </tfoot>
                                </table>
                                
                                 <table class="table table-responsive">
                            <tbody>
                                <tr>
                                    <td class="small"> 
                                    <?php echo $disclaimers->disclaimer_details; ?>
                                            <br>
                                    ** This is computer generated copy. No signature required.</td>
                                </tr>
                            </tbody>
                        </table>
                            </div>
                        </div> 
                    </div>
                </div>
            </div>   
    </div>
</div>