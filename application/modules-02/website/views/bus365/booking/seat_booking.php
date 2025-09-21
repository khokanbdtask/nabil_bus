<style>
    .close{color:red;}
</style>

<div class="clearfix"></div>

<div class="container part1">
    <div class="row">
        <div class="col-sm-12">
            <div class="tools-ber">
                <div class="row form-block">
                    <div class="row">
                        <div class="col-sm-5 col-xs-12">

                            <div class="price-details">
                                <a style="background-color:#0b2a5b;color:white;text-decoration: none;" href="<?php echo base_url('website/website/how_to_use') ?>"  class="btn btn-block"  onclick="window.open(this.href, '_blank'); return false;"><h4 style="color:white"><?php echo display('how_to_use');?></h4> </a>
                                <div class="seatsList">
                                    <?=
                                    $seats
                                    ?>
                                </div>
                            </div>
                            </div>

                            <div class="seat-details row align">
                                <div class="seat-details-content col">
                                    <div class="seat selected">
                                        <div class="seat-body">
                                            <span class="seat-handle-left"></span>
                                            <span class="seat-handle-right"></span>
                                            <span class="seat-bottom"></span>
                                            <span class="selected_seats"></span>
                                        </div>
                                    </div>
                                    <span><?php echo display('selected_seat') ?></span>
                                </div>
                                <div class="seat-details-content col">
                                    <div class="seat occupied">
                                        <div class="seat-body ">
                                            <span class="seat-handle-left"></span>
                                            <span class="seat-handle-right"></span>
                                            <span class="seat-bottom"></span>
                                            <span class="occupied_seats"></span>

                                        </div>
                                    </div>
                                    <span><?php echo display('available_seat') ?></span>
                                </div>
                                <div class="seat-details-content col">
                                    <div class="seat ladies">
                                        <div class="seat-body ">
                                            <span class="seat-handle-left"></span>
                                            <span class="seat-handle-right"></span>
                                            <span class="seat-bottom"></span>
                                            <span class="booked_seats"></span>

                                        </div>
                                    </div>
                                    <span><?php echo display('booked_seat') ?></span>
                                </div>

                            </div>
                            <div class="col-sm-12 col-xs-12">
<!--                                <div id="outputPreview" class="alert" role="alert" >-->
<!--                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
<!--                                </div>-->
                            </div>

                        </div>
                          <div class="col-sm-7 col-xs-12">
                            <?php echo form_open('website/search/booking/', array('class' => 'price-details', 'id'=>'bookingFrm')) ?>
                            <div class="form-group">
                                <label for="pickup_location"><?php echo display('pickup_location') ?>*</label>
                                <select name="pickup_location" required id="pickup_location" class="select2 location" style="width:100%">
                                    <?=
                                        $location
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="drop_location"><?php echo display('drop_location') ?>*</label>
                                <select name="drop_location" required id="drop_location" class="select2 location" style="width:100%">
                                    <?=
                                        $location
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="offerCode"><?php echo display('offer_code') ?></label>
                                <input name="offer_code" id="offerCode" class="form-control" placeholder="<?php echo display('offer_code') ?>" autocomplete="off" />
                            </div>
                            <div class="form-group">
                                <label for="child_no"><?php echo display('children') ?></label>
                                <input name="child_no" id="child_no" class="form-control seatno" placeholder="<?php echo display('child_no') ?>" autocomplete="off" />
                            </div>
                            <div class="form-group">
                                <label for="adult"><?php echo display('adult') ?></label>
                                <input name="adult" id="adult" class="form-control seatno" placeholder="<?php echo display('adult') ?>" autocomplete="off" />
                            </div>
                            <div class="form-group">
                                <label for="special"><?php echo display('special') ?></label>
                                <input name="special" id="special" class="form-control seatno" placeholder="<?php echo display('special') ?>" autocomplete="off" />
                                <input type="hidden" name="ttlseatw" id="tseats" class="form-control"  />
                            </div>


                            <div class="form-group">
                                <label for="facilities"><?php echo display('request_facilities') ?></label>
                                <div id="facilities">
                                    <?php echo $facilities; ?>
                                    
                                </div>
                            </div>

                            <hr>
                            <div class="table-responsive ">
                                <table class="table table table-bordered table-striped">
                                    <tbody>
                                    <tr>
                                        <td class="text-right" style="width: 30%;"><?php echo display('seats'); ?></td>
                                        <th id="seatPreview">---</th>
                                    </tr>
                                    <tr>
                                        <td class="text-right" style="width: 30%;"><?php echo display('prices'); ?></td>
                                        <th id="prcss"><?php echo $child_pric;   ?></th>
                                    </tr>
                                    <tr>
                                        <td class="text-right"><?php echo display('group_price'); ?></td>
                                        <th id="pricePreview">0</th>
                                    </tr>
                                    <tr>
                                        <td class="text-right"><?php echo display('child_price'); ?></td>
                                        <th id="pricechild">0</th>
                                    </tr>
                                    <tr>
                                        <td class="text-right"><?php echo display('adult_price'); ?></td>
                                        <th id="priceadult">0</th>
                                    </tr>
                                    <tr>
                                        <td class="text-right"><?php echo display('special_price'); ?></td>
                                        <th id="pricespecial">0</th>
                                    </tr>
                                    <tr>
                                        <td class="text-right"><?php echo display('total'); ?></td>
                                        <th id="totalPreview">0</th>
                                    </tr>
                                    <tr>
                                        <td class="text-right"><?php echo display('discount'); ?></td>
                                        <th id="discountPreview">0</th>
                                    </tr>
                                    <tr>
                                        <td class="text-right"><b><?php echo display('grand_total'); ?></b></td>
                                        <th id="grandTotalPreview">0</th>
                                    </tr>
                                    </tbody>
                                </table>

                                <input type="hidden" name="trip_route_id" value="<?=  $trip_route_id  ?>"/>
                                <input type="hidden" name="trip_id_no" value="<?=  $trip_id_no  ?>"/>
                                <input type="hidden" name="fleet_type_id" value="<?=  $fleet_type_id  ?>"/>
                                <input type="hidden" name="total_seat" value=""/>
                                <input type="hidden" name="seat_number" value=""/>
                                <input type="hidden" name="price" value=""/>
                                <input type="hidden" name="offer_code" value=""/>
                                <input type="hidden" name="discount" value=""/>
                                <input type="hidden" name="booking_date" value="<?=  $booking_date  ?>"/>

                            </div>
<!--                            <button class="btn btn-block">--><?php //echo display('continue');?><!--</button>-->
                            <input  class="btn btn-block" type="submit" name="submit" value="Continue">
                            <?php echo form_close() ?>
                        </div>
                    </div>

                      
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container part2">

</div>


<script type="text/javascript">

$(document).ready(function() {


    var trip_id_no = $('input[name=trip_id_no]');
    var trip_route_id = $('input[name=trip_route_id]');
    var fleet_registration_id = $('input[name=fleet_registration_id]');
    var fleet_type_id = $('input[name=fleet_type_id]');
    var total_seat = $('input[name=total_seat]');
    var seat_number = $('input[name=seat_number]');
    var price = $('input[name=price]');
    var offer_code = $('input[name=offer_code]');
    var discount = $('input[name=discount]');
    var booking_date = $('input[name=booking_date]');
    var seatPreview = $('#seatPreview');
    var pricePreview = $('#pricePreview');
    var pricechild = $('#pricechild');
    var priceadult = $('#priceadult');
    var pricespecial = $('#pricespecial');
    var totalPreview = $('#totalPreview');
    var discountPreview = $('#discountPreview');
    var grandTotalPreview = $('#grandTotalPreview');
    var outputPreview = $('#outputPreview');

    //reset trip information with modal hidden
    $("#myModal").on('hidden.bs.modal', function (event) {
        trip_id_no.val('');
        trip_route_id.val('');
        fleet_registration_id.val('');
        fleet_type_id.val('');
        total_seat.val('');
        seat_number.val('');
        price.val('');
        offer_code.val('');
        discount.val('');
        booking_date.val('');
        seatPreview.html('---');
        pricePreview.html('0');
        pricechild.html('0');
        priceadult.html('0');
        pricespecial.html('0');
        totalPreview.html('0');
        discountPreview.html('0');
        grandTotalPreview.html('0');
        outputPreview.addClass('hide').removeClass('alert-success').removeClass('alert-danger').html('');
        history.go(0);
    });

    /*
    *------------------------------------------------------
    * New Booking
    * @function: findOfferByCode
    * @return: discount
    *------------------------------------------------------
    */https://localhost/bus_demo_v6/website/user/newlog

    // var frm = $("#bookingFrm");
    // frm.on('submit', function (e) {
    //     e.preventDefault();
    //     $.ajax({
    //         url: $(this).attr('action'),
    //         method: $(this).attr('method'),
    //         dataType: 'json',
    //         data: frm.serialize(),
    //         success: function (data) {
    //             if (data.status == true) {
    //                 // outputPreview.empty().html(data.message).addClass('alert-success').removeClass('alert-danger').removeClass('hide');
    //                 // $('.modal-body').html(data.payment);
    //                 $('.part1').attr("style","display:none");
    //                 $('.part2').html(data.payment);
    //                 $(window).scrollTop(0);
    //             } else {
    //                 outputPreview.empty().html(data.exception).addClass('alert-danger').removeClass('alert-success').removeClass('hide');
    //             }
    //         },
    //         error: function (xhr) {
    //             alert('Error !');
    //         }
    //     });
    // });


    $('body').on('click', '.ChooseSeat', function () {
        var seat = $(this);

        if (seat.attr('data-item') != "selected") {
            seat.removeClass('occupied').addClass('selected').attr('data-item', 'selected');
        } else if (seat.attr('data-item') == "selected") {
            seat.removeClass('selected').addClass('occupied').attr('data-item', '');
        }

        //reset seat serial for each click
        var seatSerial = "";
        var countSeats = 0;
        var child = $('#child_no').val();
        var adult = $('#adult').val();
        var special = $('#special').val();
        $("div[data-item=selected]").each(function (i, x) {
            countSeats = i + 1;
            seatSerial += $(this).text().trim() + ", ";
        });


        total_seat.val(countSeats);
        seat_number.val(seatSerial);
        seatPreview.html(seatSerial);


        $('.selected_seats').html(countSeats);


    });

    /* ######################################################
     three types product info */

    $('.seatno').on('keyup', function () {
        var gr_tot = 0;
        var seatSerial = "";
        var countSeats = 0;
        var child = $('#child_no').val();
        var adult = $('#adult').val();
        var special = $('#special').val();
        $("div[data-item=selected]").each(function (i, x) {
            countSeats = i + 1;
            seatSerial += $(this).text().trim() + ", ";
        });

        total_seat.val(countSeats);
        seat_number.val(seatSerial);
        seatPreview.html(seatSerial);

        $(".seatno").each(function () {
            isNaN(this.value) || 0 == this.value.length || (gr_tot += parseFloat(this.value))
        });
        $("#tseats").val(gr_tot);
        total_bseats = $('#tseats').val();
        if (total_bseats > countSeats) {
            alert('please check your Seat Number');
            document.getElementById("tseats").value = '';
            document.getElementById("child_no").value = '';
            document.getElementById("special").value = '';
            document.getElementById("adult").value = '';
        }

        //#---------price selection --------------

        $.ajax({
            url: '<?php echo base_url('website/search/findPriceBySeat') ?>',
            method: 'post',
            dataType: 'json',
            data:
                {
                    '<?php echo $this->security->get_csrf_token_name() ?>': '<?php echo $this->security->get_csrf_hash() ?>',
                    'trip_route_id': trip_route_id.val(),
                    'fleet_type_id': fleet_type_id.val(),
                    'total_seat': countSeats,
                    'child': child,
                    'adult': adult,
                    'special': special
                },
            success: function (data) {
                if (data.status == true) {
                    price.val(data.total);
                    pricePreview.html(data.price);
                    pricechild.html(data.pricechild);
                    priceadult.html(data.priceadult);
                    pricespecial.html(data.pricespecial);
                    totalPreview.html(data.total);
                    grandTotalPreview.html(data.total - discount.val());
                    outputPreview.addClass("hide").html('');
                } else {
                    price.val('0');
                    totalPreview.html('0');
                    grandTotalPreview.html('0');
                    outputPreview.removeClass("hide").addClass('alert-danger').html(data.exception);
                }
            },
            error: function (xhr) {
                alert('failed!');
            }
        });

    });
    /*
    *------------------------------------------------------
    * Offer
    * @function: findOfferByCode
    * @return: discount
    *------------------------------------------------------
    */
    $("#offerCode").on('keyup', function () {

        if ($(this).val().length > 2) {

            $.ajax({
                url: '<?php echo base_url('website/search/findOfferByCode') ?>',
                method: 'post',
                dataType: 'json',
                data: {
                    '<?php echo $this->security->get_csrf_token_name() ?>': '<?php echo $this->security->get_csrf_hash() ?>',
                    'offer_code': $(this).val(),
                    'trip_route_id': trip_route_id.val(),
                    'booking_date': booking_date.val()
                },
                success: function (data) {
                    if (data.status == true) {
                        offerDiscount = data.discount;
                        outputPreview.removeClass('hide').removeClass('alert-danger').addClass('alert-success').html(data.message);
                    } else {
                        offerDiscount = 0;
                        outputPreview.removeClass('hide').removeClass('alert-success').addClass('alert-danger').html(data.message);
                    }
                    discount.val(offerDiscount);
                    offer_code.val($("#offerCode").val());
                    discountPreview.html(offerDiscount);
                    grandTotalPreview.html(price.val() - offerDiscount);
                },
                error: function (e) {
                    alert('failed!');
                }
            });
        }
    });


});

</script>