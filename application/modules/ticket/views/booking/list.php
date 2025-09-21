<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
                <div class="panel-title">
                    <h4> 
                        <a href="<?php echo base_url('ticket/booking/form') ?>" class="btn btn-sm btn-info" title="Add"><i class="fa fa-plus"></i> <?php echo display('add') ?></a>  
                    </h4>
                   
                </div>
                <!-- client 2022 project update -->
                <div class="text-right">
                <?= form_open('ticket/booking/findticketBySearch','class="form-inline"') ?> 
                    
                        <div class="form-group">
                            <input type="text" class="form-control" id="exampleInputName2" name="bookingid" placeholder="Bookingid" required>
                        </div>
                        
                        <button type="submit" class="btn btn-info"><i class="fa fa-search"></i></button>
                <?php echo form_close() ?>
                </div>
                 <!-- client 2022 project update -->
            </div>
           
            <div class="panel-body">
 
                <div class="" >
                    <table class="ticketbookinglist table table-bordered " id="version">
                        <thead>
                            <tr>
                                <th><?php echo display('sl_no') ?></th>
                                <th><?php echo display('journey_date') ?></th>
                                <th><?php echo display('booking_id') ?></th>

                                    <!-- new code 2021 -->
                                    <!-- <th><?php echo display('entry_date') ?></th> -->
                                    <!-- new code 2021 -->

                                <th><?php echo display('name') ?></th>
                                <th><?php echo display('route_name') ?></th>
                                <th><?php echo display('total_seat') ?></th>
                                <th><?php echo display('price') ?></th>
                                <th><?php echo display('seat_numbers') ?></th>
                                <th><?php echo display('payment_type') ?></th>
                                <th><?php echo display('payment_status') ?></th>
                                <th>Due</th>
                                <th><?php echo display('action') ?></th> 
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($bookings)){ ?>
                            <?php $sl = 1; ?>
                            <?php foreach ($bookings as $booking) { 

                       
                                ?>

                            <tr class="<?php echo (!empty($booking->tkt_refund_id) ? "bg-danger" : null ) ?>">
                                <td><?php echo $sl++; ?></td>
                                <td><?php echo $booking->booking_date;  ?></td>
                                <td>
                                    <?php echo $booking->id_no; ?>
                                  
                            </td>
                                 <!-- new code 2021 -->
                                 <!-- <td><?php echo $booking->date; ?></td> -->
                                  <!-- new code 2021 -->
                                <td><?php $result=$this->db->select('firstname,lastname')->from('tkt_passenger')->where('id_no',$booking->tkt_passenger_id_no)->get()->result();
                                 foreach ($result as $name) {
                                    echo $name->firstname.' '.$name->lastname;
                                 }
                                 ?></td>
                                <td><?php echo $booking->route_name; ?></td>
                                <td><?php echo $booking->total_seat; ?></td>
                                <td>
                        <?php 
                            echo ($appSetting->currency_placement == 'Left')?$appSetting->currency:''; 
                        ?>
                                    <?php echo $booking->amount; ?>
                        <?php 
                            echo ($appSetting->currency_placement == 'Right')?$appSetting->currency:''; 
                        ?>
                                </td>
                                <td><?php echo $booking->seat_numbers; ?></td>
                                <td><?php  echo $booking->booking_type; ?></td>
                               
                                <td class="text-center"><?php 
                                if($booking->payment_status == 1 OR $booking->payment_status == 2){
                                    if(($this->session->userdata('isAdmin')==1) ||( $this->session->userdata('id') == $booking->booked_by) ){

                                    // echo '<a type="button" class="test btn btn-primary btn-xs" onclick="modal_load('."'".$booking->id_no."'".')" data-toggle="modal">Unpaid</a>';
                                   
                                    echo '<a href="'.base_url("ticket/booking/partialpay/$booking->id").'" class="test btn btn-primary btn-xs">Unpaid</a>';
                                        
                                    
                                   
                                
                                }else{
                                        echo '';
                                    }

                                    }
                                    #------New Code 2021 Show refund for refund ticket------#

                                    elseif(!empty($booking->tkt_refund_id))
                                    {
                                        echo "Refund";
                                    }

                                     #------New Code 2021 Show refund for refund ticket------#

                                     
                                    //  client 2022 project update
                                     
                                    elseif($booking->payment_status == "partial")
                                    {
                                        if($booking->paystep == "1")
                                        {
                                            echo '<div class ="ml-1 p-2 bg-red text-white">Partial</div>';
                                           
                                        }
                                        if($booking->paystep == "2")
                                        {
                                            echo '<div class ="ml-1 p-2 bg-yellow text-white">Partial</div>';
                                        }
                                        if($booking->paystep == "3")
                                        {
                                            echo '<div style ="background:#75d2b2" class ="ml-1 p-2 text-white">Partial</div>';
                                        }
                                       
                                       
                                    }
                                     
                                    //  client 2022 project update

                                    else{
                                     echo '<div class ="ml-1 p-2 bg-green text-white">Paid</div>';
                                } ?>
                                </td>

                                <td>
                                    <?php if ($booking->tkt_refund_id != Null) : ?>
                                       0
                                    <?php elseif ($booking->payment_status == "NULL") : ?>
                                       0
                                    <?php elseif(($booking->payment_status == "unpaid")) : ?>
                                        <?php echo (int) $booking->amount ;?>
                                    <?php else:?>
                                        <?php echo (int) $booking->amount - (int) $booking->partialpay?>
                                    <?php endif ?>
                                  
                                </td>

                                <td>

                                <?php if($this->permission->method('ticket','read')->access()): ?>

                                <!-- #------New Code 2021 Hide show button for refund ticket Only admin can show the refund ticket------# -->


                                    <?php if(!empty($booking->tkt_refund_id)):?>
                                        <?php if($this->session->userdata('isAdmin')==1 ):?>
                                            <a href="<?php echo base_url("ticket/booking/view/$booking->id_no") ?>" class="btn btn-success btn-xs" data-toggle="tooltip" data-placement="left" title="View"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                        <?php endif; ?>
                                    
                                    <?php else: ?>

                                        <!-- client 2022 project update -->
                                        <?php if(($booking->payment_status == "NULL")||($booking->payment_status == "partial")):?>
                                            <a href="<?php echo base_url("ticket/booking/view/$booking->id_no") ?>" class="btn btn-success btn-xs" data-toggle="tooltip" data-placement="left" title="View"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                        <?php endif; ?>
                                        <!-- client 2022 project update -->
                                       
                                       
                                    <?php endif; ?>
                                            
                                 <!-- #------New Code 2021 Hide show button for refund ticket Only admin can show the refund ticket------# -->

                                <?php endif; ?>





                                <?php if($this->permission->method('ticket','update')->access() && empty($booking->tkt_refund_id)): ?>

                                    <?php if ($booking->payment_status != "1") : ?>
                                        <a href="<?php echo base_url("ticket/refund/form?bid=$booking->id_no&pid=$booking->tkt_passenger_id_no") ?>" class="btn btn-warning btn-xs" data-toggle="tooltip" data-placement="left" title="Refund"><i class="fa fa-undo" aria-hidden="true"></i></a>
                                        <input type="hidden" id="bookingid" value="<?php echo $booking->id_no; ?>">
                                    <?php endif ?>
                                    
                                <?php endif; ?>

                                <?php if($this->permission->method('ticket','delete')->access()): ?>
                                    <a href="<?php echo base_url("ticket/booking/delete/$booking->id") ?>" onclick="return confirm('<?php echo display("are_you_sure") ?>')" class="btn btn-danger btn-xs" data-toggle="tooltip" data-placement="right" title="Delete "><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                <?php endif; ?>

                                <!-- New code 2021 direct update -->
                                <a href="<?php echo base_url("ticket/booking/paymentdetail/$booking->id") ?>"  class="btn btn-primary btn-xs" data-toggle="tooltip" data-placement="right" title="Invoice "><i class="fa fa-sticky-note-o" aria-hidden="true"></i></a>

                                <a href="<?php echo base_url("ticket/booking/updateform/$booking->id") ?>"  class="btn btn-info btn-xs" data-toggle="tooltip" data-placement="right" title="Edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                    <!-- New code 2021 direct update -->

                                     <!-- client 2022 project update -->
                                <?php if($booking->payment_status == "partial"): ?>
                                    <?php if(($this->session->userdata('isAdmin')==1) ||( $this->session->userdata('id') == $booking->booked_by)): ?>
                                    <a href="<?php echo base_url("ticket/booking/partialpay/$booking->id") ?>"  class="btn btn-primary btn-xs" data-toggle="tooltip" data-placement="right" title="payment"><i class="fa fa-money" aria-hidden="true"></i></a>
                                    <?php endif; ?>
                                <?php endif; ?>

                                 <!-- client 2022 project update -->
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

                                <?= form_open('ticket/Booking/booking_paid') ?>
                                    <div class="form-group row">
                                        <label for="fitness_id" class="col-sm-3 col-form-label">
                                          </label>
                                        <div class="col-sm-9">
                                           <h1>Do You Want to Pay Now ??</h1>
                                           <input type="hidden" name="booking_id" value="" id="bookid">
                                        </div>
                                    </div>
                                    <div class="form-group text-center">
                                        <button type="button" class="btn btn-danger w-md m-b-5" data-dismiss="modal">No</button>
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

<script type="text/javascript">
function modal_load(id_no){
    $('#bookid').val(id_no);
    $('#add1').modal('show');
}

$( document ).ready(function() {
    var textlogo = "<?php echo $logo->text_logo ?>";
    $('.ticketbookinglist').DataTable({
        responsive: true,
        paging: true,
        dom: "<'row'<'col-sm-8'lB><'col-sm-4'f>>tp",
        "lengthMenu": [[25, 50, 100, 150, 200, 500, -1], [25, 50, 100, 150, 200, 500, "All"]],
        buttons: [
            {extend: 'copy', className: 'btn-sm'},
            {extend: 'csv', title: textlogo, className: 'btn-sm'},
            {extend: 'excel', title: textlogo, className: 'btn-sm'},
            {extend: 'pdf', title: textlogo, className: 'btn-sm'},
            {extend: 'print',title: textlogo, className: 'btn-sm'}
        ]
    });

    
});

</script>