<div class="form-group text-right">
    <a href="<?= base_url("/tracking/tracking_controller/tracking_list") ?>">
    <button type="button" class="btn btn-primary btn-md" data-target="#add0" data-toggle="modal"><i class='fa fa-gift' aria-hidden='true'></i> <?php echo display('list') ?>
    </button></a>

</div>
<div class="row">
    <!--  table area -->
    <div class="col-sm-12">

        <div class="panel">

                <div class="panel-body">

                    <?= form_open('tracking/tracking_controller/create_tracking') ?>
                        <?php  
                            $data = array(
                                    'type'  => 'hidden',
                                    'name'  => 'tracking_id',
                                    'id'    => 'tracking_id',
                                    'value' => (isset($tracks[0]->tracking_id))?$tracks[0]->tracking_id:''
                            );

                            echo form_input($data);
                        ?>
                         <div class="form-group row">
                            <div for="trips" class="col-sm-3 col-form-div">
                                <?php echo display('trip_name') ?> *</div>
                            <div class="col-sm-9">
                                <select type="text" name="trips" class="form-control" placeholder="<?php echo display('trips') ?>" id="tracking_route_id">
                                    <?= $trips ?>
                                </select>
                            </div>

                        </div>

                        <div class="form-group row">
                            <div for="tracking_date" class="col-sm-3 col-form-div">
                                <?php echo display('tracking_date') ?> *</div>
                            <div class="col-sm-9">
                                <input name="tracking_date" class="datepicker form-control" type="text" placeholder="<?php echo display('tracking_date') ?>" id="tracking_date" value="<?php echo (isset($tracks[0]->tracking_id))?$tracks[0]->tracking_date:date("Y-m-d"); ?>">
                            </div> 
                        </div>



                        <div class="form-group row">
                            <div for="reached_points" class="col-sm-3 col-form-div">
                                <?php echo display('reached_points') ?> *</div>
                            <div class="col-sm-9">
                                <select type="text" name="reached_points" class="form-control" placeholder="<?php echo display('reached_points') ?>" id="reached_points">

                                </select>

                        

                        <?php  
                            $data = array(
                                    'type'  => 'hidden',
                                    'name'  => 'reached_point',
                                    'id'    => 'reached_point',
                                    'value' => (isset($tracks[0]->reached_points))?$tracks[0]->reached_points:''
                            );

                            echo form_input($data);
                        ?>
                            </div>

                        </div>

                        <div class="form-group row">
                            <div for="arrival_time" class="col-sm-3 col-form-div">
                                <?php echo display('arrival_time') ?> *</div>
                            <div class="col-sm-9">
                                <input type="time" name="arrival_time" class=" form-control" placeholder="<?php echo display('arrival_time') ?>" id="arrival_time" value='<?php echo (isset($tracks[0]->arrival_time))?date("H:i",strtotime($tracks[0]->arrival_time)):date("H:i"); ?>'>
                            </div>
                        </div>



                        <div class="form-group text-right">

                            <button type="reset" class="btn btn-primary w-md m-b-5">
                                <?php echo display('reset') ?>
                            </button>

                            <button type="submit" class="btn btn-success w-md m-b-5" id="check_username_availability" name="submit">
                                <?php echo display('save') ?>
                            </button>

                        </div>
                        <?php echo form_close() ?>

                    </div>
                </div>
    </div>
</div>


<script type="text/javascript">
$(function() {
    $(".datepicker").datepicker({
        dateFormat: "yy-mm-dd"
    }).val();

});

$(document).ready(function() {

    console.log( "ready!" );

    if($.isNumeric(window.location.pathname.split("/").pop()))
    {
        var route_id = $("#tracking_route_id").val();
        var reached_point = $("#reached_point").val();
        $.ajax({
                url: '<?php echo base_url("tracking/tracking_controller/stoppages") ?>',
                type: 'POST',
                dataType: 'json',
                data: {route_id: route_id, reached_point:reached_point},
                success: function(data) 
                {
                    $('#reached_points').empty().html(data);
                },
                error: function(xhr)
                {
                    alert('failed!');
                }
            });


    }
    else
    {
        $("#tracking_route_id").on('change', function() {
            
            var route_id = $("#tracking_route_id").val();

            $.ajax({
                url: '<?php echo base_url("tracking/tracking_controller/stoppages") ?>',
                type: 'POST',
                dataType: 'json',
                data: {route_id: route_id},
                success: function(data) 
                {
                    $('#reached_points').empty().html(data);
                },
                error: function(xhr)
                {
                    alert('failed!');
                }
            });
            
        });
    }
});


</script>
 



