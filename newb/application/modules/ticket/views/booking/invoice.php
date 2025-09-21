<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Bus365</title>

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


            <div class="invoice-head">
                <div class="item-info">
                    <!-- <img src="<?php //echo base_url('assets/img/bus-logo.png'); ?>" class="mb-15" alt=""> -->

                    <img src="<?php echo base_url((!empty($appSetting->logo) ? $appSetting->logo : 'application/modules/website/assets/images/bus365.png')) ?>" class="mb-15" alt="Bus365">

                    <h5 class="item-title"><?php echo display('booking_id') ?>: <?php echo $ticket->id_no; ?></h5>
                    <p class="item-title"><?php echo display('route_name') ?>: <?php echo(!empty($ticket->route_name) ? $ticket->route_name : null) ?></p>
                    
                    <p class="item-title"><?php echo display('payment_status'); ?>: 
                        <?php
                                            $payment = $ticket->payment_status;
                                            if ($payment == 1) {
                                                echo display('unpaid');
                                            } elseif ($payment == 'Refunded') {
                                                echo display('refund');
                                            } else {
                                                echo display('paid');
                                            }
                                            ?>
                                                
                                            </p>
                </div>
                <div class="date-info">
                    <p>Date:  <?php echo(!empty($ticket->booking_date) ? date("D d-F-Y",strtotime($ticket->booking_date)) : null) ?></p>
                </div>
            </div>

            <div class="invoice-details">
                <div class="invoice-list">

                    <div class="invoice-data">


                        <div class="row-data">
                            <div class="item-info">
                                <p class="item-title"><span class="bolder"><?php echo display('passenger_name') ?>:</span><span><?php echo(!empty($passanger->passenger_name) ? $passanger->passenger_name : null) ?></span></p>
                                <p class="item-title"><span class="bolder"><?php echo display('phone') ?>:</span><span><?php echo(!empty($passanger->phone) ? $passanger->phone : null) ?></span></p>
                                <p class="item-title"><span class="bolder"><?php echo display('address') ?> :</span><span><?php echo(!empty($passanger->passenger_address) ? $passanger->passenger_address : null) ?></span></p>
                            </div>
                        </div>

                  
                    <?php
                        $ticket_price = $ticket->price-$ticket->discount;

                         $tax_amount = number_format($ticket->amount/((100/$ticket->total_tax)+1),3);

                        $total_price = $ticket->amount;
                        if ($ticket->booking_type == 'Bank') {
                            $total_commission = ($total_price * $appSetting->bank_commission) / 100;
                        } else {
                            $total_commission = 0;
                        } 
                    ?>
                        <div class="row-data">
                            <div class="pack-info">
                                <div class="item-title">
                                    <p class="bolder"><?php echo display('seat_name'); ?></p>
                                    <p><?php echo(!empty($ticket->seat_numbers) ? $ticket->seat_numbers." = ".$ticket->total_seat : null) ?></p>
                                </div>
                                <div class="item-title text-right">
                                    <p class="bolder"><?php echo display('amount'); ?></p>
                                    <p><?php echo $price = (!empty($ticket->price) ? $ticket->price - $total_commission : 0) ?><?php echo $appSetting->currency; ?></p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

            <div class="invoice-details" style="border-bottom: 1px dashed #ddd;">
                
                <div class="row-data">
                    <div class="item-info">
                        <h5 class="item-title"><?php echo display('discount'); ?></h5>
                    </div>
                    <h5 class="my-5"><?php echo $discount = (!empty($ticket->discount) ? $ticket->discount : 0) ?><?php echo $appSetting->currency; ?></h5>
                </div>
                <div class="row-data">
                    <div class="item-info">
                        <h5 class="item-title"><?php echo display('without_tax'); ?></h5>
                    </div>
                    <h5 class="my-5"><?php echo $ticket_price-$tax_amount; ?><?php echo $appSetting->currency; ?></h5>
                </div>
                <div class="row-data">
                    <div class="item-info">
                        <h5 class="item-title"><?php echo display('total_tax')."(".$ticket->total_tax."%)"; ?></h5>
                    </div>
                    <h5 class="my-5"><?php echo $tax_amount; ?><?php echo $appSetting->currency; ?></h5>
                </div>
                <div class="row-data">
                    <div class="item-info">
                        <h5 class="item-title"><?php echo display('grand_total'); ?></h5>
                    </div>
                    <h5 class="my-5"><?php echo $ticket->amount ?><?php echo $appSetting->currency; ?></h5>
                </div>
            </div>
            <div class="invoice-footer" >
                <div class="row-data">
                    <div class="item-info">
                        <small>DISCLAIMER: All persons entering the coach/bus and/or property owned by Nittol Logistics or under its control, do so entirely at their own risk and the liability of 
Nitol Logistics is excluded for any loss or damages (including consequential or special damages or loss of profits), loss of life, bodily injury or damage to or loss 
of property, of whatsoever nature and howsoever caused and whether or not caused by any form of negligence of Nitol Logistics , its directors, its officers, servants, 
agents or any other person acting on behalf of Nitol Logistics, arising out of or connected in any way with the conveyance or non-conveyance by Nitol Logistics of any passenger or persons and/or the property of any passengers or person.
                        </small>
                    </div>
                </div>
            </div>

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
