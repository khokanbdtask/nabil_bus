<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
                <div class="panel-title">
                    <h4> 
                        <a target ="_blank"href="<?php echo base_url('ticket/booking/journelistpdf/'.$jdate.'/'.$vehicelid.'/'.$triptypeId) ?>" class="btn btn-sm btn-info" title="Print"><i class="fa fa-print"></i> <?php echo display('print') ?></a>  
                    </h4>
                </div>
            </div>
            <div class="panel-body">
             <!-- New code 2021 direct update  -->
                    <div class="col-sm-12" style="margin-bottom:20px">
                        <?php echo form_open('ticket/booking/journeyList', 'class="form-horizontal" method="post"')?>

                            <div class="form-group">
                                    <label for="date" class="col-sm-2 control-label"><?php echo display('date') ?></label>
                                    <div class="col-sm-10">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <input name="start_date" id="start_date" type="text" placeholder="<?php echo display('start_date') ?>" class="form-control datepicker" value="">
                                                <div id="dateError"></div>
                                            </div>
                                      
                                        </div>
                                    </div>
                                </div> 


                                <div class="form-group" id="fleet">
                                            <label for="ftypes" class="col-sm-2 control-label"><?php echo display('types') ?></label>
                                            <div class="col-sm-10">
                                                <select name="fleetType" id="fleetType" class="form-control">
                                                        <option selected="true" value="" disabled="disabled">Choose One</option>
                                                    <?php foreach ($fleetType as $fleetValue):?>
                                                       
                                                            <option value="<?php echo $fleetValue['id'] ;?>"><?php echo $fleetValue['type'] ;?></option>
                                                    <?php endforeach;?>     
                                                </select>
                                                <div id="fleetError"></div>
                                                <div id="typeHelpText"></div>
                                            </div>
                                           
                                </div>



                                <div class="form-group" id="route">
                                            <label for="routetype" class="col-sm-2 control-label"><?php echo display('route_name') ?></label>
                                            <div class="col-sm-10">
                                                <select name="routetype" id="routetype" class="form-control">
                                                        <option selected="true" value="" disabled="disabled">Choose One</option>
                                                    <?php foreach ($tripRoutType as $tripRoutValue):?>
                                                       
                                                            <option value="<?php echo $tripRoutValue['id'] ;?>"><?php echo $tripRoutValue['name'] ;?></option>
                                                    <?php endforeach;?>     
                                                </select>
                                                <div id="typeHelpText"></div>
                                            </div>
                                </div>

                               

                                <div class="form-group" id="tripTypediv">
                                            <label for="tripType" class="col-sm-2 control-label"><?php echo display('trip_id') ?></label>
                                            <div class="col-sm-10">
                                                <select name="tripType" id="tripType" class="form-control">
                                                    <option selected="true" value="" disabled="disabled">Choose One</option>
                                                </select>
                                                <div id="typeHelpText"></div>
                                            </div>
                                </div>


                                <div class="form-group" id="vehiclediv">
                                            <label for="vehicle" class="col-sm-2 control-label">Vehicle list</label>
                                            <div class="col-sm-10">
                                                <select name="vehicle" id="vehicle" class="form-control">
                                                    <option selected="true" value="" disabled="disabled">Choose One</option>
                                                </select>
                                                <div id="typeHelpText"></div>
                                            </div>
                                </div>



                                <div class="form-group">
                                  
                                    <div class="col-sm-12">
                                        <div class="row">
                                            <div class="col-sm-5">
                                                
                                            </div>
                                            
                                            <div class="col-sm-5">
                                               
                                            </div>

                                            <div class="col-sm-2">
                                                <button type="submit"  class="form-control btn btn-success"><?php echo display('search') ?></button>
                                            </div>
                                        </div>
                                    </div>
                                </div> 

                    
                        <?php echo form_close() ?>
                    </div>
             <!-- New code 2021 direct update  -->
 
                <div class="" id="printTable">
                    <table class="journeylist table table-bordered ">
                  
                        <thead>
                            <tr>
                                <th><?php echo display('sl_no') ?></th>
                                <!-- <th><?php echo display('journey_date') ?></th> -->
                                <th><?php echo display('booking_id') ?></th>

                                    <!-- new code 2021 -->
                                    <!-- <th><?php echo display('entry_date') ?></th> -->
                                    <!-- new code 2021 -->

                                <th><?php echo display('name') ?></th>
                                <th><?php echo display('nid_passport') ?></th>
                                <th><?php echo display('phone') ?></th>
                                
                                <th><?php echo display('seat_numbers') ?></th>
                                <th><?php echo display('start_point') ?></th>
                                <th><?php echo display('end_point') ?></th>
                                <th><?php echo display('child_detail') ?></th> 
                            </tr>
                        </thead>
                             
                      

                        <tbody>
                        <?php if (!empty($passengarlist)): ?>
                            <?php $sl = 1; ?>
                            <?php foreach ($passengarlist as $pvalue): ?>

                       
                               

                            <tr>
                                <td><?php echo $sl++; ?></td>
                                <td><?php echo $pvalue->customerbookingId; ?></td>
                                <td class=""><?php echo ucwords(strtolower($pvalue->firstname.' '.$pvalue->lastname)); ?></td>
                                <td><?php echo $pvalue->nid; ?></td>
                                <td><?php echo $pvalue->phone; ?></td>
                                <td><?php echo $pvalue->seat_numbers; ?></td>

                                <td>
                                        <?php
                                        $CI =& get_instance();
                                        $CI->db->where('id', $pvalue->pickup_trip_location);
                                        $query = $this->db->get('trip_location');
                                        $picuplocation =  $query->row();

                                        $CI->db->where('id', $pvalue->drop_trip_location);
                                        $query = $this->db->get('trip_location');
                                        $droplocation =  $query->row();

                                        ?>
                                  <?php echo empty($picuplocation->name) ? "none":$picuplocation->name ; ?>
                                </td>
                                <td>
                                <?php echo empty($droplocation->name) ? "none":$droplocation->name ; ?>
                                </td>

                                <td>

                                    <?php

                                            $CI =& get_instance();
                                          
                                            $CI->db->where('booking_id', $pvalue->customerbookingId);
                                            $query = $this->db->get('child_passenger');
                                            $childDetails =  $query->result();
                                     
                                     ?>
                                            
                                             
                                    <?php if (!empty($childDetails)): ?>
                                     <?php foreach ($childDetails as $cvalue): ?>
                                       
                                       Name: <?php echo ucwords(strtolower($cvalue->firstName.' '.$cvalue->lastName)); ?><br>
                                       Nid:<?php echo $cvalue->nid; ?><br>
                                       
                                       <?php endforeach; ?>
                                    <?php endif; ?> 

                                
                                </td>
                                
                     
                             
                                
                            </tr>
                            <?php endforeach; ?>

                        <?php endif; ?>  
                        </tbody>



                    </table>
                    <!-- <?= $links ?> -->
                </div>
            </div> 
        </div>
    </div>
</div>

 



<script type="text/javascript">
function modal_load(id_no){
    $('#bookid').val(id_no);
    $('#add1').modal('show');
}

$( document ).ready(function() {
        var logo = "<?php echo $logo->text_logo ?>"; 
        $('.journeylist').DataTable({
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




$(document).ready(function(){

    $("#start_date").change(function(){
        $("#vehicle").empty();
       
        var stardate = $('#start_date').val();
        if (stardate == "") {
            $("#dateError").html("<small class = 'text-danger'>Please Select Date</small>");
        }
        else{
           
            $("#dateError").empty();
        }
    
    });

    $("#fleetType").change(function(){
        $("#fleetError").empty();
        $("#vehicle").empty();
        $("#tripType").empty();

        var stardate = $('#start_date').val();
      
        if (stardate == "") {
            $("#dateError").html("<small class = 'text-danger'>Please Select Date</small>");
        }
        else{
            $("#dateError").empty();
        }
    });



    $("#routetype").change(function(){
        var fleetType = $('#fleetType').val();
        var routetype = $('#routetype').val();
        var stardate = $('#start_date').val();

        $("#vehicle").empty();
       
        if (fleetType == null) {
          
            $("#fleetError").html("<small class = 'text-danger'>Please Select Type</small>");

            }

            else
            {

                $("#fleetError").empty();
        

                $.ajax({
                    type:'POST',
                    data : {"datarout" : routetype, "datafleet" : fleetType, "date" : stardate},
                    url: '<?php echo base_url('ticket/booking/getTripScheduleAjax') ?>',
                    success:function(result)
                    {
                        
                        var len = result.length;
                        $("#tripType").empty();
                        var jsonresult =  JSON.parse(result);
                        $("#tripType").append("<option value='' disable='disable'>select One</option>")
                        jsonresult.forEach(function (getresult) {
                          
                            $("#tripType").append("<option value='"+getresult['trip_id']+"'>"+getresult['trip_title']+"</option>");
                                
                            });
 
                    }
                });

            }

       


    });

    $("#tripType").change(function(){
        var vehicle = $('#tripType').val();
       
         $.ajax({
                    type:'POST',
                    data : {"vehicle" : vehicle},
                    url: '<?php echo base_url('ticket/booking/getVehicleListAjax') ?>',
                    success:function(result)
                    {
                       
                       
                        $("#vehicle").empty();
                        var jsonresult =  JSON.parse(result);
                        jsonresult.forEach(function (getresult) {

                            $("#vehicle").append("<option value='"+getresult['id']+"'>"+getresult['reg_no']+"</option>");
                            console.log(getresult['id']);
                            });
 
                    }
                });

          
       


    });


   
   

});

</script>