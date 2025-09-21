<div id="output" class="hide alert alert-danger"></div>

<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
                <div class="panel-title">
                    <h4>
                        <a href="<?php echo base_url('luggage/luggage/index') ?>" class="btn btn-sm btn-success"
                           title="List"> <i class="fa fa-list"></i> <?php echo display('list') ?></a>
                        <?php if (isset($booking->id)): ?>
                            <a href="<?php echo base_url('luggage/luggage/form') ?>" class="btn btn-sm btn-info"
                               title="Add"><i class="fa fa-plus"></i> <?php echo display('add') ?></a>
                        <?php endif; ?>
                    </h4>
                </div>
            </div>
            <div class="panel-body">
            <div id="luggage_form">
                <?php echo form_open('luggage/luggage/createBooking', 'id="bookingFrm"') ?>


                <div class="form-group row">
                    <label for="approximate_time" class="col-sm-3 col-form-label"><?php echo display('booking_date') ?>
                        *</label>
                    <div class="col-sm-9">
                        <input name="approximate_time" class="findTripByRouteDate form-control datepicker" type="text"
                               placeholder="<?php echo display('booking_date') ?>" id="approximate_time"
                               value="<?php echo(!empty($booking->approximate_time) ? $booking->approximate_time : date('d-m-Y')) ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="ftypes" class="col-sm-3 col-form-label"><?php echo display('fleet_type') ?> *</label>
                    <div class="col-sm-9">
                        <?php echo form_dropdown('ftypes', $tps, '', 'id="ftypes" class="findTripByRouteDate form-control"') ?>
                        <div id="typeHelpText"></div>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="route_id" class="col-sm-3 col-form-label"><?php echo display('route_name') ?> *</label>
                    <div class="col-sm-9">
                        <?php echo form_dropdown('route_id', $route_dropdown, '', 'id="route_id" class="findTripByRouteDate form-control"') ?>
                        <div id="routeHelpText"></div>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="tripTable" class="col-sm-3 col-form-label"><?php echo display('trip_id') ?> *</label>
                    <div class="col-sm-9">
                        <div class="row">
                            <div class="col-sm-12" id="tripTable">
                                <table class="table table-condensed table-striped">
                                    <thead>
                                    <tr class="bg-primary">
                                        <th>#</th>
                                        <th><?php echo display('start') ?></th>
                                        <th><?php echo display('end') ?></th>
                                        <th><?php echo display('total_weight') ?></th>
                                        <th><?php echo display('fleet_type') ?></th>
                                        <th><?php echo display('reg_no') ?></th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>

                        <!--  <input type="hidden" name="total_weight"/> -->
                        <!--  <input type="hidden" name="total_weight_available"/> -->
                    </div>
                </div>


                <!-- <div class="form-group row">
                    <label for="weight" class="col-sm-3 col-form-label"><?php echo display('weight') ?> *</label>
                    <div class="col-sm-9">
                        <input name="weight" id="weight" class="form-control weight"
                               placeholder="<?php echo display('weight') ?>" type="number"/>
                        <small id="limit_msg" style="color:red"></small>
                    </div>
                </div> -->


                <div class="form-group row">
                    <label for="packages"
                           class="col-sm-3 col-form-label"><?php echo display('packages') ?></label>
                    <div class="col-sm-9">
                        <select class="packages form-control" name="packages" id="packages"></select>
                    </div>
                </div>



                <div class="form-group row">
                    <label for="urgent" class="col-sm-3 col-form-label"><?php echo display('urgent') ?> </label>
                    <div class="col-sm-3">
                        <input name="urgent" id="urgent" class="form-control urgent" style="width: auto"
                               placeholder="<?php echo display('urgent') ?>" type="checkbox" disabled/>
                        <!--                        <input type="hidden" id="urgent_price" name="urgent_price" value="">-->

                        <small id="urgent_message" style="color:red"></small>
                    </div>
                </div>


                <div class="form-group row">
                    <label for="tax" class="col-sm-3 col-form-label"><?php echo display('tax') ?> </label>
                    <?php
                    $total_tax = 0;
                    $taxids = ",";
                    $tax_count = count($taxes);   
                    if($tax_count > 0){
                        foreach ($taxes as $tax) {

                            $total_tax += $tax['default_value'];
                            $taxids .= $tax['id'].",";

                            ?>

                        <div class="col-sm-2">
                            <label><input name="tax[]" id="taxid" class="tax"
                                   placeholder="<?php echo display('tax') ?>" value="<?php echo $tax['default_value'] ?>" type="checkbox" data-taxid="<?php echo  $tax['id']; ?>" checked/> <?php echo  $tax['tax_name']; ?></label>

                            
                        </div>
                <?php
                        $tax_count--;
                        }
                            echo '<input type="hidden" id="total_tax" name="total_tax" value="'.$total_tax.'">';

                            echo '<input type="hidden" id="taxids" name="taxids" value="'.$taxids.'">';

                    }
                ?>
                    
                    <small id="tax_message" style="color:red"></small>
                </div>

                <div class="form-group row">
                    <label for="offerCode" class="col-sm-3 col-form-label"><?php echo display('offer_code') ?></label>
                    <div class="col-sm-9">
                        <input name="offer_code" class="form-control" type="text"
                               placeholder="<?php echo display('offer_code') ?>" id="offerCode"
                               value="<?php echo (isset($booking->offer_code)) ? $booking->offer_code : '' ?>">
                        <div id="offerHelpText"></div>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="price" class="col-sm-3 col-form-label"><?php echo display('price') ?> *</label>
                    <div class="col-sm-9">
                        <div class="row">
                            <strong class="col-sm-3"><?php echo display('price') ?></strong>
                            <strong class="col-sm-3"><?php echo display('discount') ?></strong>
                            <strong class="col-sm-3"><?php echo display('urgency') ?></strong>
                            <strong class="col-sm-3"><?php echo display('amount') ?></strong>
                        </div>
                        <div class="row">
                            <div class="col-sm-3">
                                <input name="price" class="form-control text-right" type="text"
                                       placeholder="" id="price"
                                       value="<?php echo (isset($booking->price)) ? $booking->price : '' ?>">

                                <!-- <input type="hidden" name="price_hidden" value="" id="price_hidden"> -->

                            </div>
                            <div class="col-sm-3">
                                <input name="discount" class="form-control text-right" type="text"
                                       placeholder="" id="discount"
                                       value="<?php echo (isset($booking->discount)) ? $booking->discount : '' ?>">
                            </div>
                            <div class="col-sm-3">
                                <input name="urgent_price" class="form-control text-right" type="text"
                                       placeholder="" id="urgent_price" readonly="true"
                                       value="<?php echo (isset($booking->urgent_price)) ? $booking->urgent_price : '' ?>">
                            </div>
                            <div class="col-sm-3">
                                <input name="amount" class="form-control text-right" type="text"
                                       placeholder="" id="amount" readonly="true"
                                       value="<?php echo (isset($booking->amount)) ? $booking->amount : '' ?>">
                            </div>
                        </div>
                    </div>
                </div>


                <div class="form-group row">
                    <label for="sender_id_no"
                           class="col-sm-3 col-form-label"><?php echo display('sender_email')." /Phone" ?> *</label>
                    <div class="col-sm-9">
                        <div class="row">
                            <div class="col-sm-9">
                                <input name="sender" class="form-control" type="text"
                                       placeholder="<?php echo display('sender_email')."/Phone" ?>" id="sender_email" value="<?php echo (isset($booking->email)) ? $booking->email : '' ?>">
                                <input name="sender_id_no" class="form-control" type="hidden"
                                       placeholder="<?php echo display('sender_id')."/Phone" ?>" id="sender_id_no" value="<?php echo (isset($booking->sender_id_no)) ? $booking->sender_id_no : '' ?>">
                                <div id="senderHelpText"></div>
                            </div>
                            <div class="col-sm-3">
                                <a href="#" data-toggle="modal" data-target="#senderModal"
                                   class="btn btn-success"><?php echo display('add_sender') ?></a>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="form-group row">
                    <label for="receiver_id_no"
                           class="col-sm-3 col-form-label"><?php echo display('receiver')." Email/Phone" ?> *</label>
                    <div class="col-sm-9">
                        <div class="row">
                            <div class="col-sm-9">
                                <input name="receiver" class="form-control" type="text"
                                       placeholder="<?php echo display('receiver')." Email/Phone" ?>" id="receiver"
                                       value="<?php echo (isset($booking->receiver_email)) ? $booking->receiver_email : '' ?>">
                                <input name="receiver_id_no" class="form-control" type="hidden"
                                       placeholder="<?php echo display('receiver_id') ?>" id="receiver_id_no"
                                       value="<?php echo (isset($booking->receiver_id_no)) ? $booking->receiver_id_no : '' ?>">
                                <div id="receiverHelpText"></div>
                            </div>
                            <div class="col-sm-3">
                                <a href="#" data-toggle="modal" data-target="#receiverModal"
                                   class="btn btn-success"><?php echo display('add_receiver') ?></a>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="form-group row">
                    <label for="pickup_location"
                           class="col-sm-3 col-form-label"><?php echo display('pickup_location') ?></label>
                    <div class="col-sm-9">
                        <select class="tripLocation form-control" name="pickup_location" id="pickup_location"></select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="drop_location"
                           class="col-sm-3 col-form-label"><?php echo display('drop_location') ?></label>
                    <div class="col-sm-9">
                        <select class="tripLocation form-control" name="drop_location" id="drop_location"></select>
                    </div>
                </div>

              <!--   <div class="form-group row">
                    <label for="pickup_location" class="col-sm-3 col-form-label"><?php echo display('pickup_location') ?></label>
                    <div class="col-sm-9">
                        <input name="pickup_location" class="form-control" type="text"
                               placeholder="<?php echo display('pickup_location') ?>" id="pickup_location"
                               value="<?php echo (isset($booking->pickup_location)) ? $booking->pickup_location : '' ?>">
                        <div id="offerHelpText"></div>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="drop_location" class="col-sm-3 col-form-label"><?php echo display('drop_location') ?></label>
                    <div class="col-sm-9">
                        <input name="drop_location" class="form-control" type="text"
                               placeholder="<?php echo display('drop_location') ?>" id="drop_location"
                               value="<?php echo (isset($booking->drop_location)) ? $booking->drop_location : '' ?>">
                        <div id="offerHelpText"></div>
                    </div>
                </div> -->

                <div class="form-group row">
                    <label for="payment_status" class="col-sm-3 col-form-label"><?php echo display('payment_status') ?>
                        *</label>
                    <div class="col-sm-9">
                        <select class="form-control" name="status" id="status" required="">
                            <option value="">Select Option</option>
                            <option value="NULL"><?php echo display('paid') ?></option>
                            <option value="1"><?php echo display('unpaid') ?></option>
                        </select>
                    </div>
                </div>

                <div class="form-group text-right">
                    <button type="reset" class="btn btn-primary w-md m-b-5"><?php echo display('reset') ?></button>
                    <button type="submit" class="btn btn-success w-md m-b-5"><?php echo display('save') ?></button>
                </div>
                <?php echo form_close() ?>
            </div>
            </div>
        </div>
    </div>
</div>



<?php  
include 'passanger_modal.php';
?>

<script type="text/javascript">
    $(document).ready(function () {

        /*
        |----------------------------------------------
        |  Add sender
        |----------------------------------------------
        */


        $("#senderFrm").submit(function (e) {
            e.preventDefault();
            var senderMsg = $("#senderMsg");
            var sender_id_no = $("#sender_id_no");
            var senderHelpText = $("#senderHelpText");
            var sender_email = $("#sender_email");
            $.ajax({
                url: $(this).attr('action'),
                method: $(this).attr('method'),
                dataType: 'json',
                data: $(this).serialize(),
                beforeSend: function () {
                    senderMsg.removeClass('hide');
                    sender_id_no.val('');
                    senderHelpText.html('');
                },
                success: function (data) {
                    if (data.status == true) {
                        senderMsg.addClass('alert-success').removeClass('alert-danger').html(data.message);
                        sender_id_no.val(data.sender_id_no);
                        sender_email.val(data.email).trigger('change');
                        $('#senderModal').modal('hide');
                    } else {
                        senderMsg.addClass('alert-danger').removeClass('alert-success').html(data.exception);
                    }
                },
                error: function (xhr) {
                    alert('failed!');
                }

            });

        });

/*
        |----------------------------------------------
        |  Add receiver
        |----------------------------------------------
        */


        $("#receiverFrm").submit(function (e) {
            e.preventDefault();
            var receiverMsg = $("#receiverMsg");
            var receiver_id_no = $("#receiver_id_no");
            var receiverHelpText = $("#receiverHelpText");
            var receiver_email = $("#receiver");
            $.ajax({
                url: $(this).attr('action'),
                method: $(this).attr('method'),
                dataType: 'json',
                data: $(this).serialize(),
                beforeSend: function () {
                    receiverMsg.removeClass('hide');
                    receiver_id_no.val('');
                    receiverHelpText.html('');
                },
                success: function (data) {
                    if (data.status == true) {
                        receiverMsg.addClass('alert-success').removeClass('alert-danger').html(data.message);
                        receiver_id_no.val(data.receiver_id_no);
                        receiver_email.val(data.email).trigger('change');
                        $('#receiverModal').modal('hide');
                    } else {
                        receiverMsg.addClass('alert-danger').removeClass('alert-success').html(data.exception);
                    }
                },
                error: function (xhr) {
                    alert('failed!');
                }

            });

        });


        // $("#ftypes").change(function () {
        //     if ($(this).val() != null) {
        //         var fleetTp = $(this).val();
        //         $.ajax({
        //             url: '<?php echo base_url('luggage/luggage/fleetfacilities') ?>',
        //             method: 'post',
        //             dataType: 'json',
        //             data:
        //                 {
        //                     '<?php echo $this->security->get_csrf_token_name() ?>': '<?php echo $this->security->get_csrf_hash() ?>',
        //                     'fleetTp': fleetTp,
        //                 },
        //             success: function (data) {
        //                 $("#requestFacilities").html(data);
        //             },
        //             error: function (xhr) {
        //                 alert('failed!');
        //             }
        //         });
        //     }
        // });


        /*
        |----------------------------------------------
        | Create booking
        |----------------------------------------------
        */

        var frm = $("#bookingFrm");
        var output = $("#output");
        frm.on('submit', function (e) {
           e.preventDefault();
           $.ajax({
               url: $(this).attr('action'),
               method: $(this).attr('method'),
               dataType: 'json',
               data: frm.serialize(),
               success: function (data) { 
                   // if (data.status == true) {
                       // output.empty().html(data.message).addClass('alert-success').removeClass('alert-danger').removeClass('hide');
  
   // $("<iframe>")                             // create a new iframe element
   //      .hide()                               // make it invisible
   //      .attr("src", "<?php echo base_url('luggage/luggage/invoice/'); ?>"+data.id_no) // point the iframe to the page you want to print
   //      .appendTo("body");                    // add iframe to the DOM to cause it to load the page

                        // w = window.open("<?php echo base_url('luggage/luggage/view/'); ?>"+data.ticket.id_no+"","_blank");
                        // w.document.open();
                        // w.document.write(w);
                        // w.document.close();
                        // w.focus();
                        // w.print();
                        // w.close();
        
                       // setInterval(function(){
                       // window.location.href = "<?php //echo base_url('ticket/booking/view/') ?>//"+data.id_no+"";
                       // window.open("<?php //echo base_url('assets/data/pdf/') ?>//" + data.id_no + ".html");
                       // }, 1000);

                ///////////// Sweet Alert


                    swal("Do you want to Print the invoice?", {
                      buttons: {
                        cancel: "No",
                        catch: {
                          text: "Don't Print",
                          value: "catch",
                        },
                        Yes: true,
                      },
                    })
                    .then((value) => {
                      switch (value) {
                     
                        case "Yes":
                        swal({
                          title: "Please Wait!",
                          text: "Your Invoice Print Option will Come Soon.",
                          type: "success",
                          timer: 3000,
                          closeOnClickOutside: false,
                          closeOnEsc: false,
                          buttons: false
                       })
                        .then((value) => {
                                          location.reload();
                                        });
                            $("<iframe>")                             // create a new iframe element
                            .hide()                               // make it invisible
                            .attr("src", "<?php echo base_url('luggage/luggage/invoice/'); ?>"+data.id_no) // point the iframe to the page you want to print
                            .appendTo("body");                    // add iframe to the DOM to cause it to load the page

                            // $("#luggage_form").load(location.href+" #luggage_form>*","");

                            // $("#bookingFrm").trigger("reset");
                            $("#bookingFrm")[0].reset();
                          break;
                     
                        case "catch":
                          window.open("<?php echo base_url('luggage/luggage/view/'); ?>"+data.id_no, '_self','',false);
                          break;
                     
                        default:
                          window.open("<?php echo base_url('luggage/luggage/index/'); ?>");
                      }
                    });

                    ////////////Sweet Alert



                //     // if(confirm("Do you want to print the invoice?"))
                //     // {
                //     //     // alert(data.ticket.id_no);
                //     //     window.open("<?php echo base_url('luggage/luggage/invoice/'); ?>"+data.ticket.id_no+"", "_blank");
                //     // }
        


                   // } else {
                   //     output.empty().html(data.exception).addClass('alert-danger').removeClass('alert-success').removeClass('hide');
                   // }


               }
               // ,
               // error: function (xhr) {
               //     alert('failed!');
               // }
           });
        });


        /*
        *------------------------------------------------------
        * Trip schedule
        *------------------------------------------------------
        */

        // initial variables
        var countSeats = 0;
        var seatSerial = "";

        //findTripByRouteDate
        $(".findTripByRouteDate").change(function () {

            //reset previous data
            countSeats = 0;
            $('input[name="total_seat"]').val(0);
            $('input[name="seat_number"]').val("");
            $("#price").val(0);
            $("#amount").val(0);
            $("#offerCode").val("");
            $("#discount").val(0);

            //set variables
            var routeHelpText = $("#routeHelpText");
            var typeHelpText = $("#typeHelpText");
            var availableSeats = $("#availableSeats");
            var tripLocation = $(".tripLocation");
            var packages = $(".packages");
            var route_id = $("#route_id").val();
            var date = $("#approximate_time").val();
            var tripTable = $("#tripTable");
            var tps = $("#ftypes").val();

            if (tps.length == 0) {
                typeHelpText.empty().append('<p class="help-block text-danger">Please select the Bus Type</p>');
            } else {
                typeHelpText.empty();
                if (route_id.length == 0) {
                    routeHelpText.empty().append('<p class="help-block text-danger">Please select the route name</p>');
                } else {
                    routeHelpText.empty();
                    // request to get fleet schedule
                    $.ajax({
                        url: '<?php echo base_url('luggage/luggage/findTripByRouteDate') ?>',
                        method: 'post',
                        dataType: 'json',
                        data: {
                            '<?php echo $this->security->get_csrf_token_name() ?>': '<?php echo $this->security->get_csrf_hash() ?>',
                            'route_id': route_id,
                            'date': date,
                            'tps': tps
                        },
                        success: function (data) {
                            tripTable.empty().html(data.html);
                            tripLocation.empty().html(data.location);
                            packages.empty().html(data.packages);
                        },
                        error: function (xhr) {
                            alert('failed!');
                        }
                    });
                }
            }

        });


        $("#price").on('keyup', function () {
            var price =  parseFloat($(this).val());
            var discount =  parseFloat($("#discount").val());
            var urgent_price = parseFloat($("#urgent_price").val());

            var total_price_without_tax = (urgent_price + price) - discount;

            var total_tax = parseFloat($("#total_tax").val());

            var total_price = parseFloat(((total_price_without_tax*total_tax)/100)+total_price_without_tax);

            $("#amount").val(total_price);

        });

        $("#discount").on('keyup', function () {
            var price = parseFloat($("#price").val());
            var urgent_price = parseFloat($("#urgent_price").val());
            var discount = parseFloat($(this).val());

            var total_price_without_tax = (urgent_price + price) - discount;

            var total_tax = parseFloat($("#total_tax").val());

            var total_price = parseFloat(((total_price_without_tax*total_tax)/100)+total_price_without_tax);

            $("#amount").val(total_price);

        });


//// Package Price & Package Urgent Price

        $('#packages').change(function () {

            var package_id = $('#packages').val();

            // alert(package_id);

                $.ajax({
                    url: '<?php echo base_url('luggage/luggage/priceByRouteTypeAndFleetType') ?>',
                    method: 'post',
                    dataType: 'json',
                    data:
                        {
                            '<?php echo $this->security->get_csrf_token_name() ?>': '<?php echo $this->security->get_csrf_hash() ?>',
                            'package_id': package_id,
                        },
                    success: function (data) {
 
                        
                        $("#price").val(data.package_price);

                        $("#amount").val(data.package_price);

                        $("#urgent").prop('checked', false);
                        

                        if (data.urgency_status == '1') {
                            $("#urgent").removeAttr('disabled');
                            $("#urgent_price").val(0);
                            $("#urgent").attr('data-urgent_price', data.urgent_price_add);
                            $("#urgent_message").html('Price May Increase');
                        }
                        else
                        {
                            $("#urgent").attr('data-urgent_price', 0);
                            $("#urgent_price").val(0);
                            $("#urgent").attr('disabled',true);
                            $("#urgent_message").html('Urgent Service Not Available');
                        }

                            var price = parseFloat($("#price").val());
                            var discount = parseFloat($("#discount").val());
                            var total_tax = parseFloat($("#total_tax").val());
                            var total_price_without_tax = price-discount;

                            var total_price = parseFloat((total_price_without_tax*total_tax)/100);

                            $("#amount").val(total_price+total_price_without_tax);

                    }
                });

        });

        ////////// If Urgent Checked

        $("#urgent").change(function () {
            var price = parseFloat($("#price").val());
            var discount = parseFloat($("#discount").val());
            var urgent_price = parseFloat($("input[name=urgent]").attr('data-urgent_price'));

            if (this.checked) {
                $("#urgent_price").val(urgent_price);

                var total_price_without_tax = (urgent_price + price) - discount;

            } else {
                $("#urgent_price").val(0);

                var total_price_without_tax = parseFloat(price - discount);

            }

                var total_tax = parseFloat($("#total_tax").val());

                var total_price = parseFloat((total_price_without_tax*total_tax)/100);

                $("#amount").val(total_price+total_price_without_tax);



        });


        ////////// If tax Checked

       

        $(".tax").change(function () {
            var sel = $('input[id=taxid]:checked').map(function(_, el) {
                return $(el).val();
            }).get();

            var taxids = $('input[id=taxid]:checked').map(function(_, xl) {
                return $(xl).data("taxid");
            }).get();

            // alert(tax_name);

            $("#taxids").val(","+taxids+",");

            var i = 0;

            var total_tax = 0;

            for(i=0;i<sel.length;i++)
            {
                // alert(sel[i]);
                total_tax += parseFloat(sel[i]);
            }
            // alert(total_tax);
            $("#total_tax").val(total_tax);

            var price = parseFloat($("#price").val());
            var discount = parseFloat($("#discount").val());
            var urgent_price = parseFloat($("input[name=urgent_price]").val());

            var total_price_without_tax = parseFloat((price-discount)+urgent_price);

            var total_price = ((total_price_without_tax*total_tax)/100)+total_price_without_tax;

            $("#amount").val(total_price);

        });

        /*
        *------------------------------------------------------
        * Offer
        *------------------------------------------------------
        */
        $("#offerCode").on('change', function () {

            var offerHelpText = $("#offerHelpText");
            var offerRouteId = $("#route_id").val();
            var tripDate = $("#approximate_time").val();
            var offerCode = $(this).val();
            var price = parseFloat($("#price").val());
            var urgent_price = parseFloat($("#urgent_price").val());
            var total_luggage_price = parseFloat(price + urgent_price);
            var offerDiscount = 0.00;

            if ($(this).val().length != null) {

                $.ajax({
                    url: '<?php echo base_url('luggage/luggage/findOfferByCode') ?>',
                    method: 'post',
                    dataType: 'json',
                    data: {
                        '<?php echo $this->security->get_csrf_token_name() ?>': '<?php echo $this->security->get_csrf_hash() ?>',
                        'offerCode': offerCode,
                        'offerRouteId': offerRouteId,
                        'tripDate': tripDate
                    },
                    success: function (data) {
                        offerHelpText.empty().html(data.message);
                        if (data.status) {
                            offerDiscount = parseFloat(data.discount);
                        } else {
                            offerDiscount = 0.00;
                        }

                        $("#discount").val(offerDiscount);
                        
                        // $("#amount").val(total_luggage_price - offerDiscount);

                       var total_price_without_tax = (total_luggage_price - offerDiscount);


                        var total_tax = parseFloat($("#total_tax").val());

                        var total_price = parseFloat((total_price_without_tax*total_tax)/100);

                        $("#amount").val(total_price+total_price_without_tax);


                    },
                    error: function (e) {
                        alert('failed!');
                    }
                });
            }

        });


        /*
        *------------------------------------------------------
        * sender
        *------------------------------------------------------
        */
        $("#sender_email").bind('change paste', function () {

            var senderHelpText = $("#senderHelpText");

            $.ajax({
                url: '<?php echo base_url('luggage/luggage/findPassengerName') ?>',
                method: 'post',
                dataType: 'json',
                data: {
                    '<?php echo $this->security->get_csrf_token_name() ?>': '<?php echo $this->security->get_csrf_hash() ?>',
                    'passengerEamil': $(this).val(),
                },
                success: function (data) {
                    senderHelpText.empty().html(data.name);
                    $("#sender_id_no").val(data.passenger_id);
                },
                error: function (e) {
                    alert('failed!');
                }
            });
        });


        $("#receiver").bind('change paste', function () {

            var receiverHelpText = $("#receiverHelpText");

            $.ajax({
                url: '<?php echo base_url('luggage/luggage/findPassengerName') ?>',
                method: 'post',
                dataType: 'json',
                data: {
                    '<?php echo $this->security->get_csrf_token_name() ?>': '<?php echo $this->security->get_csrf_hash() ?>',
                    'passengerEamil': $(this).val(),
                },
                success: function (data) {
                    receiverHelpText.empty().html(data.name);
                    $("#receiver_id_no").val(data.passenger_id);
                },
                error: function (e) {
                    alert('failed!');
                }
            });
        });


    });
</script>
