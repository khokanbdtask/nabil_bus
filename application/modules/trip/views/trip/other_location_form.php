
<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
                <div class="panel-title">
                    <h4>
                        <a href="<?php echo base_url('trip/trip/otherLocation') ?>" class="btn btn-sm btn-success" title="List">
                            <i class="fa fa-list"></i> <?php echo display('list') ?></a>
                        <?php if (isset($trips->trip_id)): ?>
                            <a href="<?php echo base_url('trip/trip/otherLocationFromLoad') ?>" class="btn btn-sm btn-info"
                               title="Add"><i class="fa fa-plus"></i> <?php echo display('add') ?></a>
                        <?php endif; ?>
                    </h4>
                </div>
            </div>
            <div class="panel-body">

                <?= form_open('trip/trip/addOtherLocation') ?>

              

                <div class="form-group row">
                    <label for="route" class="col-sm-3 col-form-label"><?php echo display('route') ?> *</label>
                    <div class="col-sm-9">
                        <!-- <?php echo form_multiselect('trip_route_id', $route_list, (!empty($trips->route_id) ? $trips->route_id : null), ' class="form-control trips_info"') ?> -->
                        <?php echo form_dropdown('trip_route_id[]',$route_list,$route_list,' class="form-control trips_info"'); ?>
                    </div>
                </div>


                

                <div class="form-group row">
                    <label for="locationName" class="col-sm-3 col-form-label">Location Name *</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control trips_info" name="location_name" value="" required>
                        
                    </div>
                </div>
                
                <div class="form-group row">
                    <label for="extra_fee" class="col-sm-3 col-form-label">Extra Fee *</label>
                    <div class="col-sm-9">
                        <input type="number" class="form-control trips_info" name="extra_fee" value="" required>
                        
                        
                    </div>
                </div>

               

                <div class="form-group row">
                    <label for="status" class="col-sm-3 col-form-label">Status *</label>
                    <div class="col-sm-9">
                        <label class="radio-inline">
                            <?php echo form_radio('status', '1','selected') ?>
                            <!-- <?php echo form_radio('status', '1', (($trips->status == 1) ? 1 : 0)) ?> -->
                            Active
                        </label>
                        <label class="radio-inline">
                            <!-- <?php echo form_radio('status', '0', (($trips->status == 0) ? 1 : 0)) ?> -->
                            <?php echo form_radio('status', '0') ?>
                            Inactive
                        </label>
                        
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


    $("select.trips_info").change(function () {
        var selectedOptions = [];
        $("select.trips_info").each(function () {
            var value = $(this).val();
            if ($.trim(value)) {
                selectedOptions.push(value);
            }
        });
        $("#trip_title").html(selectedOptions.join('-'));
    });
</script>
