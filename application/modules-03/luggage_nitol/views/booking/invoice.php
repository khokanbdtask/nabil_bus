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
                    <!-- <img src="<?php // echo base_url('assets/img/bus-logo.png'); ?>" class="mb-15" alt=""> -->
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
                            <p>Booking Time:  <?php echo(!empty($ticket->create_date) ? date("d-F-Y h:i:s A",strtotime($ticket->create_date)) : null) ?></p>
                        </div>
                    
                    <!-- new code 2021 -->
                 
                   
                        <div class="" align="left">
                            <p>Shipping Time:  <?php echo(!empty($ticket->booking_date) ? date("d-F-Y",strtotime($ticket->booking_date)) : null) ?> <?php echo(!empty($startTime) ? date("h:i:s A",strtotime($startTime)) : null) ?> </p>
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
                                <p class="item-title"><span class="bolder">Luggage Detail :</span><span><?php echo(!empty($ticket->details_luggage) ? $ticket->details_luggage : null) ?></span></p>
                                 <!-- New code 2021 direct update  -->
                            </div>
                        </div>
                    <?php
                        $ticket_price = ($ticket->price+$ticket->urgent_price)-$ticket->discount;
                        
                        if($ticket->total_tax > 0 && !empty($ticket->total_tax))
                        {
                            $tax_amount = number_format($ticket->amount/((100/$ticket->total_tax)+1),3);
                        }
                        else
                        {
                            $tax_amount = 0;
                        }


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
                                    <p class="bolder"><?php echo display('package'); ?></p>
                                    <p><?php echo(!empty($ticket->package_name) ? $ticket->package_name : null) ?></p>
                                </div>
                                <div class="item-title text-right">
                                    <p class="bolder"><?php echo display('amount'); ?></p>
                                    <p>
                                        <?php echo ($appSetting->currency_placement == 'Left')?$appSetting->currency:''; ?>

                                        <?php echo $price = (!empty($ticket->price) ? $ticket->price - $total_commission : 0) ?>

                                        <?php echo ($appSetting->currency_placement == 'Right')?$appSetting->currency:''; ?>
                                            
                                        </p>
                                </div>
                                
                            </div>

                        </div>

                    </div>
                </div>

            </div>

            <?php if (!empty($partial_pay_all)) : ?>
                <!-- TRUE -->
             
                    <div class="invoice-details" style="border-bottom: 1px dashed #ddd;">

                    <?php foreach ($partial_pay_all as $pitem) : ?>
                        
                 

                    <div class="row-data">
                            <div class="item-info">
                                <h5 class="item-title"> <?php echo $pitem->payment_step ; ?></h5>
                            </div>
                            <h5 class="my-5">


                            <?php echo ($appSetting->currency_placement == 'Left')?$appSetting->currency:''; ?>
                                <?php echo $pitem->amount ; ?>
                            <?php echo ($appSetting->currency_placement == 'Right')?$appSetting->currency:''; ?>

                                    
                                </h5>
                        </div>
                <?php endforeach ?>

                    </div>
            <?php endif ?>

            <div class="invoice-details" style="border-bottom: 1px dashed #ddd;">
                <div class="row-data">
                    <div class="item-info">
                        <h5 class="item-title"> <?php echo display('urgency'); ?></h5>
                    </div>
                    <h5 class="my-5">


                    <?php echo ($appSetting->currency_placement == 'Left')?$appSetting->currency:''; ?>
                        <?php echo $ticket->urgent_price; ?>
                    <?php echo ($appSetting->currency_placement == 'Right')?$appSetting->currency:''; ?>

                            
                        </h5>
                </div>
                <div class="row-data">
                    <div class="item-info">
                        <h5 class="item-title"><?php echo display('discount'); ?></h5>
                    </div>
                    <h5 class="my-5">
                    <?php echo ($appSetting->currency_placement == 'Left')?$appSetting->currency:''; ?>
                    <?php echo $discount = (!empty($ticket->discount) ? $ticket->discount : 0) ?>
                    <?php echo ($appSetting->currency_placement == 'Right')?$appSetting->currency:''; ?>
                    </h5>
                </div>
                <div class="row-data">
                    <div class="item-info">
                        <h5 class="item-title"><?php echo display('without_tax'); ?></h5>
                    </div>
                    <h5 class="my-5">
                    <?php echo ($appSetting->currency_placement == 'Left')?$appSetting->currency:''; ?>

                    <?php echo round(($ticket_price-$tax_amount), 2) ; ?>

                    <?php echo ($appSetting->currency_placement == 'Right')?$appSetting->currency:''; ?>

                    </h5>
                </div>
                <div class="row-data">
                    <div class="item-info">
                        <h5 class="item-title"><?php echo display('total_tax')."(".$ticket->total_tax."%)"; ?></h5>
                    </div>
                    <h5 class="my-5">
                    <?php echo ($appSetting->currency_placement == 'Left')?$appSetting->currency:''; ?>

                        <?php echo round($tax_amount ,2) ; ?>

                    <?php echo ($appSetting->currency_placement == 'Right')?$appSetting->currency:''; ?>

                    </h5>
                </div>
                <div class="row-data">
                    <div class="item-info">
                        <h5 class="item-title"><?php echo display('grand_total'); ?></h5>
                    </div>
                    <h5 class="my-5">
                    <?php echo ($appSetting->currency_placement == 'Left')?$appSetting->currency:''; ?>

                        <?php echo $ticket->amount ?>

                    <?php echo ($appSetting->currency_placement == 'Right')?$appSetting->currency:''; ?>

                    </h5>
                </div>

        <!-- New code 2021 direct update  -->
             <?php if ($payment == 'partial'): ?>       
                 <div class="row-data">
                    <div class="item-info">
                        <h5 class="item-title">Partial Paid</h5>
                    </div>
                    <h5 class="my-5">
                    <?php echo ($appSetting->currency_placement == 'Left')?$appSetting->currency:''; ?>

                                        <?php
                                                $this->db->where('luggage_booking_id',$ticket->id_no);
                                                $result = $this->db->get('luggage_partial_payment');
                                                $result = $result->row();
                                        ?>
                                        <?php if (!empty($result)) : ?>
                                                <?php echo $result->amount_paid; ?>
                                                <?php $due = (int)$ticket->amount-(int)$result->amount_paid; ?>
                                                <?php echo ($appSetting->currency_placement == 'Right') ? $appSetting->currency : ''; ?>
                                            <?php else  : ?>
                                                <?php if (!empty($ticket->partialpay)) : ?>
                                                    <?php $due = (int)$ticket->amount-(int)$ticket->partialpay; ?>
                                                        <?php echo $ticket->partialpay; ?>
                                                        <?php echo ($appSetting->currency_placement == 'Right') ? $appSetting->currency : ''; ?>
                                                <?php else : ?>
                                                    <?php  $ticket->partialpay =0; ;?>
                                                    <?php $due = (int)$ticket->amount ?>
                                                    <?php echo $result->partialpay; ?>
                                                    <?php echo ($appSetting->currency_placement == 'Right') ? $appSetting->currency : ''; ?>
                                                <?php endif ?>
                                               
                                            <?php endif ?>

                    </h5>
                </div>


                <div class="row-data">
                    <div class="item-info">
                        <h5 class="item-title">Due</h5>
                    </div>
                    <h5 class="my-5">
                    <?php echo ($appSetting->currency_placement == 'Left')?$appSetting->currency:''; ?>

                                        <?php
                                                $this->db->where('luggage_booking_id',$ticket->id_no);
                                                $result = $this->db->get('luggage_partial_payment');
                                                $result = $result->row();
                                        ?>

                                                <?php echo $due; ?>

                    <?php echo ($appSetting->currency_placement == 'Right')?$appSetting->currency:''; ?>

                    </h5>
                </div>
             <?php endif; ?>
        <!-- New code 2021 direct update -->



            </div>
            <div class="invoice-footer" >
                <div class="row-data">
                    <div class="item-info">
                        <small><?php echo $disclaimers->disclaimer_details; ?>
                                            <br>
                                Created By: <?php echo $user_name->fullname; ?> 
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
