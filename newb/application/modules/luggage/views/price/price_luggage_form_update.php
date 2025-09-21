<div class="form-group text-right">
        <a href="<?php echo base_url('luggage/packages/'); ?>"><button type="button" class="btn btn-primary btn-md">
        <?php echo display('package_list') ?>
    </button></a>
</div>
<?php if($this->permission->method('price', 'create')->access()): ?>

<div class="row">
    <!--  table area -->
    <div class="col-sm-12">

        <div class="panel panel-default thumbnail">

            <div class="panel-body">

                <?php

                echo form_open('luggage/packages/price_update',array('name'=>'myForm'));

                echo form_hidden('package_id',(isset($packages['package_id']))?$packages['package_id']:'');

                ?>

                 <div class="form-group row">
                    <label for="package_name" class="col-sm-4 col-form-label">
                        <?php echo display('package_name') ?> *</label>
                    <div class="col-sm-8">
                        <?php echo form_input('package_name',(isset($packages['package_name']))?$packages['package_name']:'','class="form-control" id="package_name" readonly '); ?>

                    </div>
                </div>

                <div class="form-group row">
                    <label for="route_id" class="col-sm-4 col-form-label">
                        <?php echo display('route_id') ?> *</label>
                    <div class="col-sm-8">
                        <?php echo form_dropdown('route_id',$rout,(isset($packages['trip_route_id']))?$packages['trip_route_id']:'','class="form-control" style="width:100%"') ?>
                    </div>

                </div>
                <div class="form-group row">
                    <label for="vehicle_type_id" class="col-sm-4 col-form-label">
                        <?php echo display('vehicle_type_id') ?> *</label>
                    <div class="col-sm-8">
                        <?php echo form_dropdown('vehicle_type_id',$vehc,(isset($packages['fleet_type_id']))?$packages['fleet_type_id']:'','class="form-control" style="width:100%" id="vehicle_type_id"') ?>
                    </div>

                </div>
                <div class="form-group row">
                    <label for="vehicle_type_id" class="col-sm-4 col-form-label">
                        <?php echo display('max_weight_limit') ?> *</label>
                    <div class="col-sm-8">
                        <?php echo form_input('max_weight_limit',(isset($packages['max_weight_carry']))?$packages['max_weight_carry']:'','class="form-control" id="max_weight_limit" readonly="readonly" '); ?>

                    </div>
                </div>

                <div class="form-group row">
                    <label for="vehicle_type_id" class="col-sm-4 col-form-label">
                        <?php echo display('urgency') ?> *</label>
                    <div class="col-sm-8">
                        <?php echo "Yes ".form_radio('urgency',1,(isset($packages['urgency_status']) && $packages['urgency_status'] == 1)?'true':'','class="" id="urgency" ')."&nbsp; No ".form_radio('urgency',0,(isset($packages['urgency_status']) && $packages['urgency_status'] == 0)?'true':'','class="" id="urgency" '); ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="vehicle_type_id" class="col-sm-4 col-form-label">
                        <?php echo display('urgency_price') ?> *</label>
                    <div class="col-sm-8">
                        <?php echo form_input('urgency_price',(isset($packages['urgent_price_add']))?$packages['urgent_price_add']:'','class="form-control" id="urgency_price" '); ?>
                    <small><?php echo display('urgency_price_details'); ?>
                    </small>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="min_weight" class="col-sm-4 col-form-label">
                        <?php echo display('min_weight') ?> *</label>
                    <div class="col-sm-8">
                        <?php echo form_input('min_weight',(isset($packages['min_weight'])) ? $packages['min_weight']:'','class="form-control" id="min_weight" '); ?>
                    
                    </div>
                </div>

                <div class="form-group row">
                    <label for="max_weight" class="col-sm-4 col-form-label">
                        <?php echo display('max_weight') ?> *</label>
                    <div class="col-sm-8">
                        <?php echo form_input('max_weight',(isset($packages['max_weight'])) ? $packages['max_weight']:'','class="form-control" id="max_weight" '); ?>
                    
                    </div>
                </div>

                <div class="form-group row">
                    <label for="vehicle_type_id" class="col-sm-4 col-form-label">Price *</label>
                    <div class="col-sm-8">
                        <?php echo form_input('price',(isset($packages['package_price'])) ? $packages['package_price']:'','class="form-control" id="price" '); ?>
                    </div>
                </div>
 
                </div>

                <div class="form-group text-right">
                    <button type="reset" class="btn btn-primary w-md m-b-5">
                        <?php echo display('reset') ?>
                    </button>
                    <button type="submit" class="btn btn-success w-md m-b-5">
                        <?php echo display('update') ?>
                    </button>
                </div>
                <?php echo form_close() ?>
            </div>
        </div>
    </div>
</div>

<?php endif; ?>


<script type="text/javascript">
    $(document).ready(function(){
        var i=1;


        $('#add').click(function(){
            i++;
            $('#dynamic_field').append('<tr id="row'+i+'"><td><input type="text" name="min_weight[]" placeholder="<?php echo display('min_weight') ?>" class="form-control name_list" /></td><td><input type="text" name="max_weight[]" placeholder="<?php echo display('max_weight') ?>" class="form-control name_list" /></td><td><input type="text" name="price[]" placeholder="Price" class="form-control name_list" /></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');
        });

        $(document).on('click', '.btn_remove', function(){
            var button_id = $(this).attr("id");
            $('#row'+button_id+'').remove();
        });


        $('#submit').click(function(){
            $.ajax({
                url:$(this).attr('action'),
                method: $(this).attr('method'),
                data:$('#myForm').serialize(),
                success:function(data)
                {
                    alert(data);
                    $('#add_name')[0].reset();
                }
            });
        });

        $('#vehicle_type_id').change(function () {
            var vehicle_type_id = $('#vehicle_type_id').val();
            $.ajax({
                url:"<?php echo base_url('luggage/packages/max_luggage_weight'); ?>",
                method:"POST",
                data: {'<?php echo $this->security->get_csrf_token_name() ?>':'<?php echo $this->security->get_csrf_hash() ?>',
                    'vehicle_type_id':vehicle_type_id},
                success: function(data) {
                    $('#max_weight_limit').val(data);
                },
                error: function(xhr) {
                    alert('failed!');
                }

            });
        });
    });
</script>