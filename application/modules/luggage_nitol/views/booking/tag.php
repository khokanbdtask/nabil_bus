<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>DigitalRainbow</title>

    <!-- Bootstrap -->
    <link href="<?php echo base_url('assets/css/bootstrap.min.css')?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/style.css')?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/bhojon.css')?>" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body onload="window.print()">
<!-- <body> -->
    <div class="page-wrapper">
        <div class="invoice-card" id="PrintMe">

        <?php for($print = 1; $print< $numberofprint; $print++) { ?>

            <div class="invoice-head">
                <div class="item-info">
                    <!-- <img src="<?php // echo base_url('assets/img/bus-logo.png');?>" class="mb-15" alt=""> -->
                    <h4 class="item-title text-left"><?php echo $setting->text_logo   ; ?></h4>
                    <br>

                    <!-- <img src="<?php echo base_url((!empty($appSetting->logo) ? $appSetting->logo : 'application/modules/website/assets/images/bus365.png')) ?>" class="mb-15" alt="Bus365"> -->


                    <b><h5 class="item-title text-left"><?php echo display('booking_id') ?>: <?php echo $ticket->id_no; ?></h5></b>
                    <p class="item-title text-left"><?php echo display('route_name') ?>: <?php echo(!empty($ticket->route_name) ? $ticket->route_name : null) ?></p>
                    
                    <p class="item-title text-left"><b><?php echo display('payment_status'); ?>: 
                        <?php
                                    $payment = $ticket->payment_status;
    if ($payment == 1) {
        echo display('unpaid');
    } elseif ($payment == 'Refunded') {
        echo display('refund');
    }

    // New code 2021 direct update
    elseif ($payment == 'partial') {
        echo "Partial";
    }
    // New code 2021 direct update
    else {
        echo display('paid');
    }
    ?></b>
                                                
                                            </p>
                </div>
                <div class="date-info">
                   
                        <div class="" align="left">
                            <p>Booking Time:  <?php echo(!empty($ticket->create_date) ? date("d-F-Y h:i:s A", strtotime($ticket->create_date)) : null) ?></p>
                        </div>
                    
                    <!-- new code 2021 -->
                 
                   
                        <div class="" align="left">
                            <p>Shipping Time:  <?php echo(!empty($ticket->booking_date) ? date("d-F-Y", strtotime($ticket->booking_date)) : null) ?> <?php echo(!empty($startTime) ? date("h:i:s A", strtotime($startTime)) : null) ?> </p>
                        </div>
                    
                     <!-- new code 2021 -->
                </div>
            </div>

            <div class="invoice-details">
                <div class="invoice-list">

                    <div class="invoice-data">


                        <div class="row-data">
                            <div class="item-info">
                                <p class="item-title"><span class="bolder"><?php echo display('sender_name') ?>:</span><span><?php echo(!empty($sender->passenger_name) ? $sender->passenger_name : null) ?></span></p>
                                <p class="item-title"><span class="bolder"><?php echo display('phone') ?>:</span><span><?php echo(!empty($sender->phone) ? $sender->phone : null) ?></span></p>
                                <!-- <p class="item-title"><span class="bolder"><?php echo display('address') ?> :</span><span><?php echo(!empty($sender->passenger_address) ? $sender->passenger_address : null) ?></span></p> -->
                                <p class="item-title"><span class="bolder">Pick Up Point :</span><span><?php echo $pickup->name ?></span></p>
                            </div>
                        </div>

                        <div class="row-data">
                            <div class="item-info">
                                <p class="item-title"><span class="bolder"><?php echo display('receiver_name') ?>:</span><span><?php echo(!empty($receiver->passenger_name) ? $receiver->passenger_name : null) ?></span></p>
                                <p class="item-title"><span class="bolder"><?php echo display('phone') ?> :</span><span><?php echo(!empty($receiver->phone) ? $receiver->phone : null) ?></span></p>
                                <!--<p class="item-title"><span class="bolder"><?php echo display('address') ?>:</span><span><?php echo(!empty($receiver->passenger_address) ? $receiver->passenger_address : null) ?></span></p>-->
                                 <!-- New code 2021 direct update  -->
                                <p class="item-title"><span class="bolder">Drop off Point :</span><span><?php echo $drop->name ?></span></p>
                                <?php if($ticket->other_location_id != null) : ?> 
                                    <?php
                                    $CI =& get_instance();
                                    $CI->db->where('id', $ticket->other_location_id);
                                    $query = $this->db->get('luggage_other_location');
                                    $OtherLocation =  $query->row();

                                    ?>
                                    <p class="item-title"><span class="bolder">Outside Route Location :</span><span><?php echo $OtherLocation->location_name ?></span></p>
                                <?php endif ?> 
                                <p class="item-title"><span class="bolder">Luggage Detail :</span><span><?php echo(!empty($ticket->details_luggage) ? $ticket->details_luggage : null) ?></span></p>
                                 
                                <!-- New code 2021 direct update  -->
                            </div>
                        </div>
                    
                    </div>
                </div>

            </div>

           


            <?php } ?>

           

        </div>
<!-- 
        <div  class="invoice-card">
            <a href="#" class="btn btn-sm btn-danger" id="print_invoice" title="Print" onClick="printContent('PrintMe')"><i class="fa fa-print"></i> Print</a>
        </div> -->
    </div>

    



    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="<?php echo base_url('assets/js/jquery-1.12.4.min.js')?>"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?php echo base_url('assets/js/bootstrap.min.js')?>"></script>
    <script src="<?php echo base_url('assets/js/script.min.js')?>"></script>
    <script type="text/javascript">
// $(document).ready(function() {
//     // $(".print_invoice").trigger('click');

//             //print a div
//             // function printContent(el) {
//                 var restorepage = $('body').html();
//                 var printcontent = $('#' + el).clone();
//                 $('body').empty().html(printcontent);
//                 window.print();
//                 $('body').html(restorepage);
//                 location.reload();
//             // }
//         });  

    </script>
</body>

</html>
