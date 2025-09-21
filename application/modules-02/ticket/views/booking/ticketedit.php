<div id="output" class="hide alert alert-danger"></div>

<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
                <div class="panel-title">
                    <h4>
                        <a href="<?php echo base_url('ticket/booking/index') ?>" class="btn btn-sm btn-success" title="List"> <i class="fa fa-list"></i> <?php echo display('list') ?></a> 
                        <?php if(isset($booking->id)): ?>
                        <a href="<?php echo base_url('ticket/booking/form') ?>" class="btn btn-sm btn-info" title="Add"><i class="fa fa-plus"></i> <?php echo display('add') ?></a> 
                        <?php endif; ?>
                    </h4>
                </div>
            </div>
            <div class="panel-body">

                <?= form_open('ticket/booking/updatebooking', 'id="bookingFrm"') ?> 


                <div class="form-group row">
                    <label for="approximate_time" class="col-sm-3 col-form-label"><?php echo display('booking_date') ?> *</label>
                    <div class="col-sm-9">
                        <input name="approximate_time"  required="" class="findTripByRouteDate form-control datepicker" readonly="true" type="text" placeholder="<?php echo display('booking_date') ?>" id="approximate_time" value="<?php echo  (!empty($date)?$date:date('d-m-Y')) ?>">
                    </div>
                    </div>  
                     <div class="form-group row">
                        <label for="ftypes" class="col-sm-3 col-form-label"><?php echo display('types') ?> *</label>
                        <div class="col-sm-9">
                            <?php echo form_dropdown('ftypes', $tps, (!empty($fleetType)?$fleetType:null), 'id="ftypes" class="findTripByRouteDate form-control" required=""') ?> 
                           <div id="typeHelpText"></div>
                        </div>
                    </div> 

                    <div class="form-group row">
                        <label for="route_id" class="col-sm-3 col-form-label"><?php echo display('route_name') ?> *</label>
                        <div class="col-sm-9">
                            <?php echo form_dropdown('route_id', $route_dropdown, (!empty($triprouteid)?$triprouteid:null), 'id="route_id" class="findTripByRouteDate form-control" required=""') ?> 
                            <div id="routeHelpText"></div>
                        </div>
                    </div> 

                    <div class="form-group row">
                        <label for="tripTable" class="col-sm-3 col-form-label"><?php echo display('trip_id') ?> *</label>
                        <div class="col-sm-9">
                            <div class="row">
                                <div class="col-sm-6" id="availableSeats">
                                    <h4 class="bg-primary" style="padding:5px;margin:0"><?php echo display('select_seats') ?></h4>
                                </div>
                                <div class="col-sm-6" id="tripTable">
                                    <table class="table table-condensed table-striped">
                                        <thead>
                                            <tr class="bg-primary">
                                                <th>#</th>
                                                <th><?php echo display('time')?></th>
                                                <th><?php echo display('available_seats') ?></th>
                                                <th><?php echo display('ac_available')    ?></th> 
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>

                            <input type="hidden" name="total_seat"/>
                            <input type="hidden" name="seat_number"/>

                            <input type="hidden" name="id" value="<?php echo $tkt_booking_id ?>"/>
                            <input type="hidden" name="bookingid" value="<?php echo $bookingid ?>"/>
                            
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







 


<script type="text/javascript">
$(document).ready(function() {
 
    

    var frm = $("#bookingFrm");
    var output = $("#output");
    frm.on('submit', function(e) {
        e.preventDefault(); 
        $.ajax({
            url : $(this).attr('action'),
            method : $(this).attr('method'),
            dataType : 'json',
            data : frm.serialize(),
            success: function(data) 
            {
                if (data.status == true) {
                    output.empty().html(data.message).addClass('alert-success').removeClass('alert-danger').removeClass('hide');

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
                                          setTimeout(function() {
                                            location.reload();
                                        }, 1500);
                                        });
                            $("<iframe>")                             // create a new iframe element
                            .hide()                               // make it invisible
                            .attr("src", "<?php echo base_url('ticket/booking/invoice/'); ?>"+data.id_no) // point the iframe to the page you want to print
                            .appendTo("body");                    // add iframe to the DOM to cause it to load the page

                            // $("#luggage_form").load(location.href+" #luggage_form>*","");

                            // $("#bookingFrm").trigger("reset");
                            $("#bookingFrm")[0].reset();
                          break;
                     
                        case "catch":
                          window.open("<?php echo base_url('ticket/booking/view/'); ?>"+data.id_no, '_self','',false);
                          break;
                     
                        default:
                          window.open("<?php echo base_url('ticket/booking/index/'); ?>");
                      }
                    });
 

                } else {
                    // output.empty().html(data.exception).addClass('alert-danger').removeClass('alert-success').removeClass('hide');

                    var html = $.parseHTML(data.exception); //parseHTML return HTMLCollection
                    var msg = $(html).text(); //use $() to get .text() method


                    swal({
                                title: "ERROR!",
                                text: msg,
                            });
                }
            },
            error: function(xhr)
            {
                alert('failed!');
            }
        });
    });


    /*
    *------------------------------------------------------
    * Trip schedule 
    *------------------------------------------------------
    */

    // initial variables
    var countSeats  = 0;
    var seatSerial  = "";

    //findTripByRouteDate
    $(".findTripByRouteDate").change(function() {
       
        //reset previous data
        countSeats = 0;
        $('input[name="total_seat"]').val(0);
        $('input[name="seat_number"]').val("");
        $("#price").val(0);
        $("#amount").val(0);
        $("#offerCode").val("");
        $("#discount").val(0);

        //set variables
        var routeHelpText  = $("#routeHelpText");
        var typeHelpText  = $("#typeHelpText");
        var availableSeats = $("#availableSeats");
        var tripLocation   = $(".tripLocation");
        var route_id       = $("#route_id").val();
        var date           = $("#approximate_time").val();
        var tripTable      = $("#tripTable");
        var tps            = $("#ftypes").val();
        
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
                url: '<?php echo base_url('ticket/booking/findTripByRouteDate') ?>',
                method : 'post',
                dataType: 'json',
                data: {
                    '<?php echo $this->security->get_csrf_token_name() ?>':'<?php echo $this->security->get_csrf_hash() ?>',
                    'route_id': route_id, 
                    'date'    : date,
                    'tps'     : tps
                },
                success: function(data) {
                   
                    tripTable.empty().html(data.html );
                    tripLocation.empty().html(data.location);
                    availableSeats.empty();
                }, 
                error: function(xhr) {
                    alert('failed!');
                }
            });
        }
    }

    });


    //find setas by trip id
    $('body').on('click', ".tripIdNo", function() {

      var bdate =$("#approximate_time").val();
              //reset previous data
        countSeats = 0;
        $('input[name="total_seat"]').val(0);
        $('input[name="seat_number"]').val("");
        $("#price").val(0);
        $("#amount").val(0);
        $("#offerCode").val("");
        $("#discount").val(0);


        //set variables
        var availableSeats = $("#availableSeats");
        var requestFacilities = $("#requestFacilities");
       
        var tripIdNo       = $(this).val();
        
        var fleetRegNo     = $(this).attr('data-fleetRegNo');
        var fleetTp     = $(this).attr('data-fleetTypeId');

        // request to get available seats 
        $.ajax({
            url: '<?php echo base_url('ticket/booking/findSeatsByTripID') ?>',
            method : 'post',
            dataType: 'json',
            data: {
                '<?php echo $this->security->get_csrf_token_name() ?>':'<?php echo $this->security->get_csrf_hash() ?>',
                'tripIdNo'  : tripIdNo, 
                'fleetTp': fleetTp,
                'bdate'     : bdate
            },
            success: function(data) {
                availableSeats.html(data.html);
                requestFacilities.html(data.facilities);
            }, 
            error: function(xhr) {
                alert('failed!');
            }
        });

    });

 
    /*
    *------------------------------------------------------
    * Seat booking & price selection 
    *------------------------------------------------------
    */

    var clicksit =0;  
    $('body').on('click', '.ChooseSeat', function(){
        var seat = $(this); 
        var ts = '<?php echo  $totalseat ?>';
        
        
        if(ts > clicksit)
        {
        if (seat.attr('data-item') != "selected") {
            seat.removeClass('btn-primary').addClass('btn-success').attr('data-item','selected'); 
            clicksit +=1;
            console.log(clicksit)
        }
        }
        else if (seat.attr('data-item') == "selected")  {
            seat.removeClass('btn-success').addClass('btn-primary').attr('data-item','');
            clicksit -=1;  
        } 
        
        //reset seat serial for each click
        seatSerial = "";
        countSeats = 0;
        $("button[data-item=selected]").each(function(i, x) {
            countSeats = i+1;
            seatSerial += $(this).text()+","; 
        }); 
 // alert($("input[name=tripIdNo]").attr('data-fleetTypeId'));
        $('input[name="total_seat"]').val(countSeats);
        $('input[name="seat_number"]').val(seatSerial);


    });




});

//  2021 code for date booking date disable 

$( document ).ready(function() {
    $("#approximate_time").datepicker({
  minDate: 0,
  onSelect: function(date) {
    $("#approximate_time").datepicker('option', 'minDate', date);
  }
});
});

// 2021 code for date booking date disable 

function validate()
{
    var countSeats  = 0;
    var seatSerial  = "";
       
       //reset previous data
       countSeats = 0;
       $('input[name="total_seat"]').val(0);
       $('input[name="seat_number"]').val("");
       $("#price").val(0);
       $("#amount").val(0);
       $("#offerCode").val("");
       $("#discount").val(0);

       //set variables
       var routeHelpText  = $("#routeHelpText");
       var typeHelpText  = $("#typeHelpText");
       var availableSeats = $("#availableSeats");
       var tripLocation   = $(".tripLocation");
       var route_id       = $("#route_id").val();
       var date           = $("#approximate_time").val();
       var tripTable      = $("#tripTable");
       var tps            = $("#ftypes").val();
       
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
               url: '<?php echo base_url('ticket/booking/findTripByRouteDate') ?>',
               method : 'post',
               dataType: 'json',
               data: {
                   '<?php echo $this->security->get_csrf_token_name() ?>':'<?php echo $this->security->get_csrf_hash() ?>',
                   'route_id': route_id, 
                   'date'    : date,
                   'tps'     : tps
               },
               success: function(data) {
                  
                   tripTable.empty().html(data.html );
                   tripLocation.empty().html(data.location);
                   availableSeats.empty();
               }, 
               error: function(xhr) {
                   alert('failed!');
               }
           });
       }
   }

  
}


function findseat()
{


    

var bdate =$("#approximate_time").val();
        //reset previous data
  countSeats = 0;
  


  //set variables
  var availableSeats = $("#availableSeats");
  var requestFacilities = $("#requestFacilities");
  
  var tripIdNo       = '<?php echo $tripassignid ?>';
    // var fleetRegNo     = '<?php echo $tripassignid ?>';
  var fleetTp     = '<?php echo $fleettypeid ?>';

  
  $.ajax({
      url: '<?php echo base_url('ticket/booking/findSeatsByTripID') ?>',
      method : 'post',
      dataType: 'json',
      data: {
          '<?php echo $this->security->get_csrf_token_name() ?>':'<?php echo $this->security->get_csrf_hash() ?>',
          'tripIdNo'  : tripIdNo, 
          'fleetTp': fleetTp,
          'bdate'     : bdate
      },
      success: function(data) {
         
          availableSeats.html(data.html);
          requestFacilities.html(data.facilities);
      }, 
      error: function(xhr) {
          alert('failed!');
      }
  });




}



$(document).ready(function(){
  // we call the function
  var vehicelid = '<?php echo $vehicelid ?>';
  validate();

  setTimeout(function (){

    findseat();
   
}, 1000)
 

 

});

</script>
