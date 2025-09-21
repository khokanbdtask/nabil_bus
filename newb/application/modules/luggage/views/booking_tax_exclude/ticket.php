<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
                <div class="panel-title">
                    <h4>
                        <a href="<?php echo base_url('luggage/luggage/index') ?>" class="btn btn-sm btn-success"
                           title="List"> <i class="fa fa-list"></i> <?php echo display('list') ?></a>
                        <a href="<?php echo base_url('luggage/luggage/form') ?>" class="btn btn-sm btn-info"
                           title="Add"><i class="fa fa-plus"></i> <?php echo display('add') ?></a>
                        <a href="#" class="btn btn-sm btn-danger" title="Print" onclick="printContent('PrintMe')"><i
                                    class="fa fa-print"></i></a>
<?php if ($ticket->payment_status != 'Refunded'){ ?>
                        <a href="<?php echo base_url('luggage/luggage/invoice/').(!empty($ticket->id_no) ? $ticket->id_no : null) ?>" target='_blank'>
                            <button type="button" class="btn btn-sm btn-primary">
                                <?php echo display('pos_invoice') ?>
                            </button>
                        </a>
<?php } ?>
                    </h4>
                </div>
            </div>

            <div class="panel-body" id="PrintMe">

                <div class="ticket-content">
                    <div class="table-responsive">
                        <table style="width:100%;margin-bottom:10px">
                            <tbody>
                            <tr>
                                <td>
                                    <div class="ticket-logo">
                                        <img src="<?php echo base_url(!empty($appSetting->logo) ? $appSetting->logo : null) ?>"
                                             class="img-responsive" alt="">
                                    </div>
                                </td>
                                <td style="vertical-align:middle;">

                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>


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
                                <td><strong><?php echo display('date') ?>
                                        :</strong> <?php echo(!empty($ticket->booking_date) ? $ticket->booking_date : null) ?>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="passanger-info table-responsive">
                        <div class="col-sm-12">
                            <table width="100%">
                                <tr>
                                    <td>
                                        <strong style="font-size: 16px;"><u><?php echo display('sender') ?></u></strong>
                                        <ul class="list-unstyled">
                                            <li><strong><?php echo display('sender_name') ?> :</strong>
                                                <?php echo(!empty($sender->passenger_name) ? $sender->passenger_name : null) ?>
                                            </li>
                                            <li><strong><?php echo display('address') ?> :</strong>
                                                <?php echo(!empty($sender->passenger_address) ? $sender->passenger_address : null) ?>
                                            </li>
                                            <li><strong><?php echo display('phone') ?> :</strong>
                                                <?php echo(!empty($sender->phone) ? $sender->phone : null) ?>
                                            </li>
                                            <li><strong><?php echo display('email') ?> :</strong>
                                                <?php echo(!empty($sender->email) ? $sender->email : null) ?>
                                            </li>
                                            <li>
                                                <strong><?php echo display('passenger_id') ?> :</strong>
                                                <?php echo(!empty($sender->id_no) ? $sender->id_no : null) ?>
                                            </li>
                                            <li>
                                            
                                        </ul>
                                    </td>

                                    <td>
                                        <strong style="font-size: 16px;"><u><?php echo display('receiver') ?></u></strong>
                                        <ul class="list-unstyled text-left">
                                            <li><strong><?php echo display('receiver_name') ?> :</strong>
                                                <?php echo(!empty($receiver->passenger_name) ? $receiver->passenger_name : null) ?>
                                            </li>
                                            <li><strong><?php echo display('address') ?> :</strong>
                                                <?php echo(!empty($receiver->passenger_address) ? $receiver->passenger_address : null) ?>
                                            </li>
                                            <li><strong><?php echo display('phone') ?> :</strong>
                                                <?php echo(!empty($receiver->phone) ? $receiver->phone : null) ?>
                                            </li>
                                            <li><strong><?php echo display('email') ?> :</strong>
                                                <?php echo(!empty($receiver->email) ? $receiver->email : null) ?>
                                            </li>
                                            <li>
                                                <strong><?php echo display('passenger_id') ?> :</strong>
                                                <?php echo(!empty($receiver->id_no) ? $receiver->id_no : null) ?>
                                            </li>
                                            <li>
                                            
                                        </ul>
                                    </td>
                                    <td>
                                        <dl class="list-unstyled text-right">
                                            <li><strong><?php echo display('booking_id') ?> :</strong>
                                                <?php echo(!empty($ticket->id_no) ? $ticket->id_no : null) ?>
                                            </li>
                                            <li><strong><?php echo display('route_name') ?> :</strong>
                                                <?php echo(!empty($ticket->route_name) ? $ticket->route_name : null) ?>
                                            </li>
                                            <li>
                                                <strong><?php echo display('trip_id') ?> :</strong>
                                                <?php echo(!empty($ticket->trip_id_no) ? $ticket->trip_assing_idno : null) ?>
                                            </li>
                                            <strong><?php echo display('payment_status'); ?> :</strong>
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
                                            </li>
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
                                        <th><?php echo display('package'); ?></th>
                                        <th class="text-right"><?php echo display('amount'); ?></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php

                                    $ticket_price = ($ticket->price+$ticket->urgent_price)-$ticket->discount;

                                    $total_price = $ticket->amount;

                                    if ($ticket->booking_type == 'Bank') {
                                        $total_commission = ($total_price * $appSetting->bank_commission) / 100;
                                    } else {
                                        $total_commission = 0;
                                    } ?>
                                    <tr>
                                        <td><?php echo(!empty($ticket->package_name) ? $ticket->package_name : null) ?></td>

                                        <th class="text-right"><?php echo $price = (!empty($ticket->price) ? $ticket->price - $total_commission : 0) ?><?php echo $appSetting->currency; ?></th>
                                    </tr>
                                    <tr>
                                        <th class="text-right">
                                            <?php echo display('urgency'); ?>
                                        </th>
                                        <th class="text-right">
                                            <?php echo $ticket->urgent_price . $appSetting->currency; ?>
                                        </th>
                                    </tr>

                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th class="text-right"><?php echo display('discount'); ?></th>
                                        <th class="text-right"><?php echo $discount = (!empty($ticket->discount) ? $ticket->discount : 0) ?><?php echo $appSetting->currency; ?></th>
                                    </tr>
                                    <?php if ($ticket->booking_type == 'Bank') {
                                        ?>
                                        <tr>

                                            <th class="text-right"><?php echo display('bank_charge'); ?></th>
                                            <th class="text-right"><?php
                                                echo $total_commission;
                                                echo "(" . $appSetting->bank_commission . '%' . ")" ?><?php echo $appSetting->currency; ?></th>
                                        </tr>
                                    <?php } ?>

                                    <tr>

                                        <th class="text-right"><?php echo display('without_tax'); ?></th>
                                        <th class="text-right"><?php echo $ticket_price; ?><?php echo $appSetting->currency; ?></th>
                                    </tr>
                                    
                                    <tr>

                                        <th class="text-right"><?php echo display('total_tax')."(".$ticket->total_tax."%)"; ?></th>
                                        <th class="text-right"><?php echo (($ticket_price*$ticket->total_tax)/100); ?><?php echo $appSetting->currency; ?></th>
                                    </tr>

                                    <tr>

                                        <th class="text-right"><?php echo display('grand_total'); ?></th>
                                        <th class="text-right"><?php echo $ticket->amount ?><?php echo $appSetting->currency; ?></th>
                                    </tr>

                                    </tfoot>
                                </table>
                                

                                <table class="table table-responsive">
                                    <tbody>
                                    <tr>
                                        <td class="small"> ** This is computer generated copy. No signature required.
                                        </td>
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
</div>
