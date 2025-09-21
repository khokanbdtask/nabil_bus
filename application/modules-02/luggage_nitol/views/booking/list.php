<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
                <div class="panel-title">
                    <h4>
                        <a href="<?php echo base_url('luggage_nitol/luggage/form') ?>" class="btn btn-sm btn-info"
                           title="Add"><i class="fa fa-plus"></i> <?php echo display('add') ?></a>
                    </h4>
                </div>
            </div>
            <div class="panel-body">

           

     <!-- New code 2021 direct update  -->
            <!-- <div class="col-sm-12" style="margin-bottom:20px">
                        <?php echo form_open('luggage_nitol/luggage/index', 'class="form-horizontal" method="post"')?>

                            <div class="form-group">
                                    <label for="luggagebookingid" class="col-sm-2 control-label">Partial Paid</label>
                                    <div class="col-sm-8">
                                         <input name="luggagebookingid" id="luggagebookingid" type="text" placeholder="BOOKING-ID" class="form-control " value="">
                                    </div>
                              
                                    <div class="col-sm-1">
                                                <button type="submit"  class="form-control btn btn-success"><?php echo display('search') ?></button>
                                     </div>
                                       
                                    
                                </div> 

                    
                        <?php echo form_close() ?>
                    </div>

                    <div class="col-sm-12" style="margin-bottom:20px">
                        <?php echo form_open('luggage_nitol/luggage/index', 'class="form-horizontal" method="post"')?>

                            <div class="form-group">
                                    <label for="luggagebookingid" class="col-sm-2 control-label">Date Range</label>
                                    <div class="col-sm-4">
                                    <?php echo form_input('datefrom', date("01-m-Y"), 'class="form-control datepicker"  placeholder="Date From" id="datefrom" type="text" required="required" '); ?>
                                    </div>
                                    <div class="col-sm-4">
                                    <?php echo form_input('dateto', date("d-m-Y"), 'class="form-control datepicker"  placeholder="Date To" id="dateto" type="text"  required="required" '); ?>
                                    </div>
                              
                                    <div class="col-sm-1">
                                                <button type="submit"  class="form-control btn btn-success"><?php echo display('search') ?></button>
                                     </div>
                                       
                                    
                                </div> 

                    
                        <?php echo form_close() ?>
                    </div> -->
   <!-- New code 2021 direct update  -->


                <div class="">
                    <table class="luggagelist table table-bordered ">
                        <thead>
                        <tr>
                            <th><?php echo display('sl_no') ?></th>
                            <th><?php echo display('booking_date') ?></th>
                            <th><?php echo display('booking_id') ?></th>
                            <th><?php echo display('name') ?></th>
                            <th><?php echo display('route_name') ?></th>
                            <th><?php echo display('package') ?></th>
                            <th><?php echo display('price') ?></th>
                            <th><?php echo display('payment_type') ?></th>
                            <th><?php echo display('payment_status') ?></th>
                         <!-- New code 2021 direct update  -->
                            <th>Delivery Status </th>
                         <!-- New code 2021 direct update  -->
                            <th><?php echo display('action') ?></th>
                        </tr>
                        </thead>
                        <tbody>

                        
                        <?php
                       
                        if (!empty($bookings)){
                            ?>
                            <?php $sl = 1;  ?>

                       
                        <?php
                        foreach ($bookings as $booking) {
                            ?>

                            <tr class="<?php echo(!empty($booking->tkt_refund_id) ? "bg-danger" : null) ?>">
                                <td><?php echo $sl++; ?></td>
                                <td><?php echo $booking->booking_date; ?></td>
                                <td><?php echo $booking->id_no; ?></td>
                                <td><?php $result = $this->db->select('firstname,lastname')->from('tkt_passenger')->where('id_no', $booking->luggage_passenger_id_no)->get()->result();
                                    foreach ($result as $name) {
                                        echo $name->firstname . ' ' . $name->lastname;
                                    }
                                    ?></td>
                                <td><?php echo $booking->route_name; ?></td>
                                <td>
                                    <!-- New code 2021 direct update  -->
                                        <?php echo $booking->package_name; ?><br>
                                        (<?php echo $booking->details_luggage; ?>)
                                    <!-- New code 2021 direct update  -->
                                </td>
                                <td><?php echo $currency; ?><?php echo $booking->amount; ?></td>
                                <td><?php echo $booking->booking_type; ?></td>
                                <td>
                                    <?php
                                    if ($booking->payment_status == 1 or $booking->payment_status == 2) {
                                        if (($this->session->userdata('isAdmin') == 1) || ( $this->session->userdata('id') == $booking->booked_by) ) {
                                            echo '<a type="button" class="test btn btn-primary btn-xs" onclick="modal_load(' . "'" . $booking->id_no . "'" . ')" data-toggle="modal">Unpaid</a>';
                                        } else {
                                            echo '';
                                        }
                                    }
                                    elseif ($booking->payment_status == 'Refunded') {
                                        echo "Refunded";
                                    }
                                    // New code 2021 direct update 
                                    elseif ($booking->payment_status == 'partial') {
                                        echo "Partial";
                                    }
                                    // New code 2021 direct update 

                                    else {
                                        echo "Paid";
                                    }
                                    ?>
                                </td>
                                 <!-- New code 2021 direct update  -->
                                <td> <?php echo $booking->delivery_status ; ?> </td>
                                <!-- New code 2021 direct update  -->
                                <td>
                                    <?php if ($this->permission->method('luggage', 'read')->access()): ?>
                                        <a href="<?php echo base_url("luggage_nitol/luggage/view/$booking->id_no") ?>"
                                           class="btn btn-success btn-xs" data-toggle="tooltip" data-placement="left"
                                           title="View"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                    <?php endif; ?>

                                    <?php if ($this->permission->method('refund_luggage', 'create')->access() && empty($booking->luggage_refund_id)): ?>
                                        <a href="<?php echo base_url("luggage_nitol/refund/form?bid=$booking->id_no&pid=$booking->luggage_passenger_id_no") ?>"
                                           class="btn btn-warning btn-xs" data-toggle="tooltip" data-placement="left"
                                           title="Refund"><i class="fa fa-undo" aria-hidden="true"></i></a>
                                        <input type="hidden" id="bookingid" value="<?php echo $booking->id_no; ?>">
                                    <?php endif; ?>


                                    <?php if ($this->permission->method('luggage', 'delete')->access()): ?>
                                        <a href="<?php echo base_url("luggage_nitol/luggage/delete/$booking->id") ?>"
                                           onclick="return confirm('<?php echo display("are_you_sure") ?>')"
                                           class="btn btn-danger btn-xs" data-toggle="tooltip" data-placement="right"
                                           title="Delete "><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                    <?php endif; ?>

                                   
                            <!-- New code 2021 direct update  -->
                            <?php if ($booking->payment_status != 1): ?>
                                   
                                    <?php if ($booking->payment_status == 'partial'): ?>
                                        <?php
                                              $result =  $this->db->where('luggage_booking_id',$booking->id_no)->get('luggage_partial_payment')->row();
                                              if($result)
                                              {
                                                  $payamount = $result->payment_amount - $result->amount_paid;
                                              }
                                        ?>
                                        <a style="" id="mondalid" data-toggle="modal" href="#payment"data-id="<?php echo $booking->id_no;?>"
                                        onclick="paymentFunction('<?php echo $booking->id_no;?>','<?php echo $payamount ;?>')" class="btn btn-primary btn-xs " data-target="#payment" data-placement="left" 
                                           title="pay now"><i class="fa fa-money" aria-hidden="true"></i></a>
                                    <?php endif; ?>
                                 
                                    <?php if (($booking->payment_status != 'partial')&&($booking->payment_status != 'Refunded')): ?>
                                        <a  href="<?php echo base_url("luggage_nitol/luggage/tranjection_details/$booking->id_no") ?>"
                                           class="btn btn-default btn-xs " data-toggle="tooltip" data-placement="left"
                                           title="payment details"><i class="fa fa-file-text-o" aria-hidden="true"></i></a>
                                    <?php endif; ?>


                                    <?php if ((($booking->delivery_status == null ) || ($booking->delivery_status == 'no'))&&(($booking->payment_status != 'partial')&&($booking->payment_status != 'Refunded'))): ?>
                                        <a  href="<?php echo base_url("luggage_nitol/luggage/luggageDeliver/$booking->id_no") ?>"
                                           class="btn btn-info btn-xs " data-toggle="tooltip" data-placement="left"
                                           title="delivered"><i class="fa fa-truck" aria-hidden="true"></i></a>
                                    <?php endif; ?>
                            <!-- New code 2021 direct update  -->
                            <?php endif; ?>   

                                </td>
                            </tr>
                        <?php }} ?>
                        </tbody>
                    </table>
                    <?= $links ?> 
                </div>
            </div>
        </div>
    </div>
</div>

<div id="add1" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header" style="background-color:green; color: white">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <center><strong>Payment info</strong></center>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <div class="panel">

                            <div class="panel-body">

                                <?= form_open('luggage_nitol/luggage/booking_paid') ?>
                                <div class="form-group row">
                                    <label for="fitness_id" class="col-sm-3 col-form-label">
                                    </label>
                                    <div class="col-sm-9">
                                        <h1>Do You Want to Pay Now ??</h1>
                                        <input type="hidden" name="booking_id" value="" id="bookid">
                                    </div>
                                </div>
                                <div class="form-group text-center">
                                    <button type="button" class="btn btn-danger w-md m-b-5" data-dismiss="modal">No
                                    </button>
                                    <button type="submit" class="btn btn-success w-md m-b-5">
                                        Yes
                                    </button>
                                </div>
                                <?php echo form_close() ?>

                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
        <div class="modal-footer">

        </div>

    </div>


</div>


 <!-- New code 2021 direct update  -->
<div id="payment" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header" style="background-color:green; color: white">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <center><strong>Payment </strong></center>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <div class="panel">

                            <div class="panel-body">

                                <?= form_open('luggage_nitol/luggage/booking_partial_paid') ?>

                                <div class="form-group row">

                                    <label for="fitness_id" class="col-sm-3 col-form-label">
                                    </label>
                                    <div class="col-sm-9">
                                        <h1>Choose Pay Type </h1>
                                        <input type="hidden" name="paybookid" value="" id="paybookid">
                                    </div>
                                      
                                       
                                </div>
                                <div class="form-group">
                                <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="paytype" id="cash" value="cash">
                                        <label class="form-check-label" for="paytype">Cash</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="paytype" id="bank" value="bank">
                                        <label class="form-check-label" for="paytype">Bank</label>
                                        </div>

                                        <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="paytype" id="eft" value="eft">
                                        <label class="form-check-label" for="paytype">Eft</label>
                                        </div>
                                </div>

                                <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Pay Amount</label>
                                        <input type="text" name="amount" class="form-control" id="amount" readonly>
                                    </div>

                                    <div class="form-group" id="checkdiv">
                                        <label for="recipient-name" class="col-form-label">Payment Detail</label>
                                        <input type="text" class="form-control" id="checknumber" name="checknumber">
                                    </div>
                                </div>
                                <div class="form-group text-center">
                                    <button type="button" class="btn btn-danger w-md m-b-5" data-dismiss="modal">No
                                    </button>
                                    <button type="submit" class="btn btn-success w-md m-b-5">
                                        Yes
                                    </button>
                                </div>
                                <?php echo form_close() ?>

                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>


</div>

 <!-- New code 2021 direct update  -->


<script type="text/javascript">

$( document ).ready(function() {
        var logo = "<?php echo $logo->text_logo ?>"; 
        $('.luggagelist').DataTable({
        responsive: true,
        paging: true,
        dom: "<'row'<'col-sm-8'lB><'col-sm-4'f>>tp",
        "lengthMenu": [[25, 50, 100, 150, 200, 500, -1], [25, 50, 100, 150, 200, 500, "All"]],
        buttons: [
            {extend: 'copy', className: 'btn-sm'},
            {extend: 'csv', title: logo , className: 'btn-sm'},
            {extend: 'excel', title: logo , className: 'btn-sm'},
            {extend: 'pdf', title: logo , className: 'btn-sm'},
            {extend: 'print',title: logo , className: 'btn-sm'}
        ]
    });
    });


    function modal_load(id_no) {
        $('#bookid').val(id_no);
        $('#add1').modal('show');
    }
    // New code 2021 direct update
    function paymentFunction(id_no,paymentamount) {
        
        $('#paybookid').val(id_no);
        $('#amount').val(paymentamount);
    }

    // $( "#cash" ).click(function() {
    //     var inputString = $("#cash").val();
    //     if( inputString == "cash")
    //     {
    //         $('#checkdiv').hide();
    //     }
       
        
    // });

    // $( "#check" ).click(function() {
        
    //     var inputString = $("#check").val();
    //     if(inputString == "check")
    //     {
    //         $('#checkdiv').show();
    //     }
        
    // });

    // $( document ).ready(function() {
    //     $('#checkdiv').hide();
    //     });
    
   // New code 2021 direct update
</script>