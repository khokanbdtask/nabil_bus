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


</head>

<body onload="window.print()">
    <!-- <body> -->

    <?php for($print = 1; $print<= $numberofprint; $print++) { ?>

    <div class="" style="width: 100%; height:1000px">

        <table class="table table-bordered" style="width: 100%; margin-bottom: 10px;">
            <tr>
                <th colspan="4" style="background-color: #4066d7!important; line-height: 1;">
                    <div style="display: flex; justify-content: center; align-items: center;">
                        <img src="/logo.png" alt="">
                        <span style="font-size: 50px; font-weight: 700; color: #fff!important; margin-left: 15px;">NITOL CLASSICS</span>
                    </div>
                </th>
            </tr>
            <tr>
                <th colspan="2" style="font-size: 20px;">Destination (Address)</th>
                <th colspan="2" style="font-size: 20px;">Traveling Date</th>
            </tr>
            <tr>
                <th colspan="2"
                    style="color: #d90b0b!important; font-size: 45px; border-bottom: 6px solid #4066d7!important; line-height: 1;">
                    <?php echo $drop->name ?> </th>
                <th colspan="2"
                    style="color: #d90b0b!important; font-size: 45px; border-bottom: 6px solid #4066d7!important; line-height: 1;">
                    <?php echo(!empty($ticket->booking_date) ? date("d-F-Y",strtotime($ticket->booking_date)) : null) ?>
                </th>
            </tr>
            <tr>
                <th colspan="2" style="font-size: 20px;">Sender Details</th>
                <th colspan="2" style="font-size: 20px;"> Receiver Details</th>
            </tr>
            <tr>
                <th colspan="2" style="line-height: 1;">
                    <p style="font-size: 16px;">Name & Surname</p>
                    <h3 style="color: #d90b0b!important; font-size: 40px; font-weight: 600; margin-top: 5px;">
                        <?php echo(!empty($sender->passenger_name) ? $sender->passenger_name : null) ?></h3>
                </th>
                <th colspan="2" style="line-height: 1;">
                    <p style="font-size: 16px;">Name & Surname</p>
                    <h3 style="color: #d90b0b!important; font-size: 40px; font-weight: 600; margin-top: 5px;">
                        <?php echo(!empty($receiver->passenger_name) ? $receiver->passenger_name : null) ?></h3>
                </th>
            </tr>
            <tr>
                <th colspan="2" style="border-bottom: 6px solid #4066d7!important; line-height: 1;">
                    <p style="font-size: 16px;">Cell Number</p>
                    <h3 style="color: #d90b0b!important; font-size: 40px; font-weight: 600; margin-top: 5px;">
                        <?php echo(!empty($sender->phone) ? $sender->phone : null) ?></h3>
                </th>
                <th colspan="2" style="border-bottom: 6px solid #4066d7!important; line-height: 1;">
                    <p style="font-size: 16px;">Cell Number</p>
                    <h3 style="color: #d90b0b!important; font-size: 40px; font-weight: 600; margin-top: 5px;">
                        <?php echo(!empty($receiver->phone) ? $receiver->phone : null) ?></h3>
                </th>
            </tr>
            <tr>
                <th colspan="2" style="width: 50%; font-size: 17px;">Booking id</th>
                <th style="font-size: 17px;">Number Of Items</th>
                <th style="font-size: 17px;">Payment Status</th>
            </tr>
            <tr>
                <th colspan="2" style="width: 50%; color: #d90b0b!important; font-size: 40px; line-height: 1;">
                    <?php echo $ticket->id_no; ?></th>
                <th style="color: #d90b0b!important; font-size: 40px; line-height: 1;"><?php echo $print. ' Of ' . $numberofprint ?>
                </th>
                <th style="line-height: 1;">

                    <?php $payment = $ticket->payment_status; $payment_text = ''; ?>

                    <?php if($payment == 1) : $payment_text = 'Unpaid'; ?>
                    <div class="i-check">
                        <input tabindex="9" type="checkbox" id="square-checkbox-3" checked>
                        <label for="square-checkbox-3" style="font-size: 17px;">Unpaid</label>
                    </div>
                    <?php elseif($payment == 'Refunded') : $payment_text = 'Refunded'; ?>

                    <div class="i-check">
                        <input tabindex="9" type="checkbox" id="square-checkbox-3" checked>
                        <label for="square-checkbox-3" style="font-size: 17px;">Refunded</label>
                    </div>

                    <?php elseif($payment == 'partial') : $payment_text = 'Partial'; ?>
                    <div class="i-check">
                        <input tabindex="10" type="checkbox" id="square-checkbox-2" checked>
                        <label for="square-checkbox-2" style="font-size: 17px;">Partial</label>
                    </div>

                    <?php else : $payment_text = 'Paid'; ?>
                    <div class="i-check" style="color: #d90b0b;">
                        <input tabindex="9" type="checkbox" id="square-checkbox-1" checked>
                        <label for="square-checkbox-1" style="font-size: 17px;">Paid</label>
                    </div>

                    <?php endif ?>

                </th>
            </tr>
        </table>

        <div class="text-center">
            <p style="color: #d90b0b !important; font-size: 100px; font-weight: bold; line-height: 1;">
                <?php echo $drop->name; ?><br></p>
            <p style="font-size: 80px; font-weight: bold; line-height: 1; margin-top: 20px;">
                <?php echo $payment_text; ?></p>
            <?php if($ticket_arr['sender_id_no'] == $ticket_arr['receiver_id_no']){ ?>
                <p style="font-size: 70px; font-weight: bold; line-height: 1; margin-top: 20px;">ACO</p>
            <?php } ?>
        </div>

    </div>

    <?php } ?>


    <script src="<?php echo base_url('assets/js/jquery-1.12.4.min.js')?>"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?php echo base_url('assets/js/bootstrap.min.js')?>"></script>
    <script src="<?php echo base_url('assets/js/script.min.js')?>"></script>
    <script type="text/javascript">
    // Listen for the afterprint event
    window.addEventListener('afterprint', function(event) {
        // Return to the previous page
        history.back();
    });
    </script>
</body>

</html>