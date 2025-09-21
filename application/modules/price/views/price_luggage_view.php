<div class="form-group text-right">
    <a href="<?php echo base_url('price/price_luggage_controller/'); ?>">
        <button type="button" class="btn btn-primary btn-md">
            <?php echo display('price_list') ?>
        </button>
    </a>
    <a href="<?php echo base_url('price/price_luggage_controller/create_price'); ?>">
        <button type="button" class="btn btn-primary btn-md">
            <?php echo display('add_price') ?>
        </button>
    </a>
    <a href="<?php echo base_url().'price/price_luggage_controller/price_update/'.$bb['luggage_price_master_id']; ?>">
        <button type="button" class="btn btn-primary btn-md">
            <?php echo display('update_price') ?>
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
                                <?php echo display('luggage_price') ?>
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
                            <?php
                                foreach($price_ranges as $price_range)
                                {
                            ?>
                                    <tr>
                                        <td><?php echo (isset($price_range['min_weight'])) ? $price_range['min_weight']:'' ?></td>
                                        <td><?php echo (isset($price_range['max_weight'])) ? $price_range['max_weight']:'' ?></td>
                                        <td style="text-align:right"><?php echo (isset($price_range['price'])) ? $price_range['price']:'' ?></td>

                                    </tr>
                            <?php
                                }
                            ?>
                        </table>

                    </div>


                </div>
            </div>
        </div>
    </div>

<?php endif; ?>

