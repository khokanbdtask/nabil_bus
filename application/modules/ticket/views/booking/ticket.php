<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
                <div class="panel-title">
                    <h4>
                        <a href="<?php echo base_url('ticket/booking/index') ?>" class="btn btn-sm btn-success" title="List"> <i class="fa fa-list"></i> <?php echo display('list') ?></a>  
                        <a href="<?php echo base_url('ticket/booking/form') ?>" class="btn btn-sm btn-info" title="Add"><i class="fa fa-plus"></i> <?php echo display('add') ?></a>  
                        <a href="#" class="btn btn-sm btn-danger" title="Print" onclick="printContent('PrintMe')"><i class="fa fa-print"></i></a>  

    <?php if ($ticket->payment_status != 'Refunded'){ ?>

                        <a href="<?php echo base_url('ticket/booking/invoice/').(!empty($ticket->id_no) ? $ticket->id_no : null) ?>" target='_blank'>
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
                                            <!-- <img src="<?php echo base_url(!empty($appSetting->logo)?$appSetting->logo:null) ?>" class="img-responsive" alt=""> -->
                                            <h5 class="item-title"><?php echo $setting->text_logo   ; ?></h5>
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
                                    <td><strong><?php echo display('booking_date') ?>:</strong> <?php echo (!empty($ticket->date)?date("d-F-Y h:i:s A",strtotime($ticket->date)):null) ?></td>
                                     
                                     <!-- new code 2021 -->
                                    <td>
                                        <strong><?php echo display('journey_date') ?>:</strong> <?php echo (!empty($ticket->booking_date)?date("d-F-Y",strtotime($ticket->booking_date)):null) ?> <?php echo(!empty($startTime) ? date("h:i:s A",strtotime($startTime)) : null) ?>
                                    </td>
                                      <!-- new code 2021 -->
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
                                        <ul class="list-unstyled text-right">
                                             <li><strong><?php echo display('booking_id') ?> :</strong>
                                                <?php echo (!empty($ticket->id_no)?$ticket->id_no:null) ?></li>
                                                 <li><strong><?php echo display('route_name') ?> :</strong>
                                            <?php echo (!empty($ticket->route_name)?$ticket->route_name:null) ?></li>
                                            <li>
                                                <strong><?php echo display('trip_id') ?> :</strong> 
                                                <?php echo (!empty($ticket->trip_id_no)?$ticket->trip_id_no:null) ?>
                                            </li>

                                            <?php if( $ticket->other_location_id != null ) : ?>        
                                            <li>
                                                <strong>Other Location :</strong> 

                                                <?php
                                                    $CI =& get_instance();
                                                    $CI->db->where('id', $ticket->other_location_id);
                                                    $query = $this->db->get('other_location');
                                                    $OtherLocation =  $query->row();

                                                ?>
                                                <?php echo $OtherLocation->location_name; ?>
                                            </li>
                                            <?php endif ?> 
                                            <strong><?php echo display('payment_status');?> :</strong> 
                                            <?php
                                                $payment = $ticket->payment_status;
                                                if ($payment == 1) {
                                                    echo display('unpaid');
                                                } elseif (!empty($ticket->tkt_refund_id) ) {
                                                    echo display('refund');
                                                }
                                                elseif ($ticket->payment_status == "partial" ) {
                                                    echo'partial';
                                                }

                                                elseif ($ticket->payment_status == "NULL" ) {
                                                    echo display('paid');
                                                }
                                                //  else {
                                                //     echo display('paid');
                                                // }
                                            ?>
                                            <?php  $counts =  array_sum(array_column($partial_pay_all, 'amount'));  ?>
                                            <?php if( ($ticket->amount- $counts) > 0 ) : ?>
                                                <li>
                                                <strong>Due :</strong> 
                                                <?php echo $ticket->amount- $counts ?>
                                                </li>
                                            <?php endif ?> 

                                        </ul>
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

                                        <?php if( $ticket->other_location_id != null ) : ?>  
                                            <tr>
                                                
                                                <td>
                                               Other Location Name : <b><?php echo $OtherLocation->location_name; ?></b>
                                                </td>
                                                <td colspan="3" class="text-right">
                                                    Extra Fee
                                                </td>
                                                <td  class="text-right"><?= $ticket->extra_fee ;?></td>
                                            </tr>
                                        
                                        <?php endif ?> 
                 <!-- new code invoice desing 2022 feb -->
                                          
                                     <?php foreach ($partial_pay_all as $kye => $item) : ?>
                                            <tr>
                                                
                                                <td><?= $item->payment_step ;?> <small>(<?= $item->date ?>)</small></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td  class="text-right"><?= $item->amount ;?></td>
                                            </tr>
                                    <?php endforeach ?>

                <!-- new code invoice desing 2022 feb -->
                                       
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
                                    ** This is computer generated copy. No signature required.
                                     <br>
                             Created By: <?php echo $user_name->fullname; ?> 
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
