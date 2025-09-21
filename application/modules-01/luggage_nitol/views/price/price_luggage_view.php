<div class="form-group text-right">
    <a href="<?php echo base_url('luggage_nitol/packages/'); ?>">
        <button type="button" class="btn btn-primary btn-md">
            <?php echo display('package_list') ?>
        </button>
    </a>
    <a href="<?php echo base_url('luggage_nitol/packages/create_price'); ?>">
        <button type="button" class="btn btn-primary btn-md">
            <?php echo display('add_package') ?>
        </button>
    </a>
    <a href="<?php echo base_url().'luggage_nitol/packages/price_update/'.$bb['package_id']; ?>">
        <button type="button" class="btn btn-primary btn-md">
            <?php echo display('update_package') ?>
        </button>
    </a>
</div>
<?php if($this->permission->method('price', 'read')->access()): ?>

    <div class="row">
        <!--  table area -->
        <div class="col-sm-12">

            <div class="panel panel-default thumbnail">

                <div class="panel-body">

                    
                    <div class="form-group row">
                        <label for="package_name" class="col-sm-4 col-form-label">
                            <?php echo display('package_name') ?> *</label>
                        <div class="col-sm-8">
                            <?php echo (isset($data['package_name']))?$data['package_name']:''; ?>
                        </div>

                    </div>

                    <div class="form-group row">
                        <label for="route_id" class="col-sm-4 col-form-label">
                            <?php echo display('route_id') ?> *</label>
                        <div class="col-sm-8">
                            <?php echo (isset($data['name']))?$data['name']:''; ?>
                        </div>

                    </div>
                    <div class="form-group row">
                        <label for="vehicle_type_id" class="col-sm-4 col-form-label">
                            <?php echo display('vehicle_type_id') ?> *</label>
                        <div class="col-sm-8">
                            <?php echo (isset($data['type']))?$data['type']:''; ?>
                        </div>

                    </div>
                    <div class="form-group row">
                        <label for="vehicle_type_id" class="col-sm-4 col-form-label">
                            <?php echo display('max_weight_limit') ?> *</label>
                        <div class="col-sm-8">
                            <?php echo (isset($bb['max_weight_carry']))?$bb['max_weight_carry']:''; ?>

                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="vehicle_type_id" class="col-sm-4 col-form-label">
                            <?php echo display('urgency') ?></label>
                        <div class="col-sm-8">
                            <?php echo (isset($bb['urgency_status']) && $bb['urgency_status'] == 1)?'Yes':'No'; ?>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="vehicle_type_id" class="col-sm-4 col-form-label">
                            <?php echo display('urgency_price') ?> *</label>
                        <div class="col-sm-8">
                            <?php echo (isset($bb['urgent_price_add']))?$bb['urgent_price_add']:''; ?>
                            <small><?php // echo display('urgency_price_details'); ?>
                            </small>
                        </div>
                    </div>


                    <div class="row" >
                        <div class="col-12" style="text-align:center">
                            <label for="vehicle_type_id" class="col-sm-12 col-form-label" >
                                <?php echo display('package_price') ?>
                            </label>
                        </div>
                    </div>
                    <div class="table-responsive  mt-1">
                        <table class="table table-bordered table-hover table-striped table-dark" id="dynamic_field">
                                    <tr>
                                        <th><?php echo display('min_weight') ?></th>
                                        <th><?php echo display('max_weight') ?></th>
                                        <th>Price</th>
                                    </tr>
                            
                                    <tr>
                                        <td><?php echo (isset($bb['min_weight'])) ? $bb['min_weight']:'' ?></td>
                                        <td><?php echo (isset($bb['max_weight'])) ? $bb['max_weight']:'' ?></td>
                                        <td style="text-align:right"><?php echo (isset($bb['package_price'])) ? $bb['package_price']:'' ?></td>

                                    </tr>
                            
                        </table>

                    </div>


                </div>
            </div>
        </div>
    </div>

<?php endif; ?>

