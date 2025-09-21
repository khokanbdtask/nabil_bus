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
                <?= form_open('luggage/packages/create_price',array('name'=>'myForm')) ?>


                <div class="form-group row">
                    <label for="package_name" class="col-sm-4 col-form-label">
                        <?php echo display('package_name') ?> *</label>
                    <div class="col-sm-8">
                        <?php echo form_input('package_name','','class="form-control" placeholder="Name should be unique" id="package_name" '); ?>

                    </div>
                </div>

                <div class="form-group row">
                    <label for="route_id" class="col-sm-4 col-form-label">
                        <?php echo display('route_id') ?> *</label>
                    <div class="col-sm-8">
                        <?php echo form_dropdown('route_id',$rout,null,'class="form-control" style="width:100%"') ?>
                    </div>

                </div>
                <div class="form-group row">
                    <label for="vehicle_type_id" class="col-sm-4 col-form-label">
                        <?php echo display('vehicle_type_id') ?> *</label>
                    <div class="col-sm-8">
                        <?php echo form_dropdown('vehicle_type_id',$vehc,null,'class="form-control" style="width:100%" id="vehicle_type_id"') ?>
                    </div>

                </div>
                <div class="form-group row">
                    <label for="vehicle_type_id" class="col-sm-4 col-form-label">
                        <?php echo display('max_weight_limit') ?> *</label>
                    <div class="col-sm-8">
                        <?php echo form_input('max_weight_limit','','class="form-control" id="max_weight_limit" readonly="readonly" '); ?>

                    </div>
                </div>

                <div class="form-group row">
                    <label for="vehicle_type_id" class="col-sm-4 col-form-label">
                        <?php echo display('urgency') ?></label>
                    <div class="col-sm-8">
                        <?php echo "Yes ".form_radio('urgency','1','false','class="" id="urgency" ')."&nbsp; No ".form_radio('urgency','0','false','class="" id="urgency" '); ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="vehicle_type_id" class="col-sm-4 col-form-label">
                        <?php echo display('urgency_price') ?></label>
                    <div class="col-sm-8">
                        <?php echo form_input('urgency_price','','class="form-control" id="urgency_price" '); ?>
                    <small><?php echo display('urgency_price_details'); ?>
                    </small>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="min_weight" class="col-sm-4 col-form-label">
                        <?php echo display('min_weight') ?> *</label>
                    <div class="col-sm-8">
                        <?php echo form_input('min_weight','','class="form-control" id="min_weight" '); ?>
                    
                    </div>
                </div>

                <div class="form-group row">
                    <label for="max_weight" class="col-sm-4 col-form-label">
                        <?php echo display('max_weight') ?> *</label>
                    <div class="col-sm-8">
                        <?php echo form_input('max_weight','','class="form-control" id="max_weight" '); ?>
                    
                    </div>
                </div>

                <div class="form-group row">
                    <label for="vehicle_type_id" class="col-sm-4 col-form-label">Price *</label>
                    <div class="col-sm-8">
                        <?php echo form_input('price','','class="form-control" id="price" '); ?>
                    </div>
                </div>


                <div class="form-group text-right">
                    <button type="reset" class="btn btn-primary w-md m-b-5">
                        <?php echo display('reset') ?>
                    </button>
                    <button type="submit" class="btn btn-success w-md m-b-5">
                        <?php echo display('add') ?>
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

        // $('#submit').click(function(){
        //     $.ajax({
        //         url:$(this).attr('action'),
        //         method: $(this).attr('method'),
        //         data:$('#myForm').serialize(),
        //         success:function(data)
        //         {
        //             // alert(data);
        //             $('#myForm')[0].reset();
        //         }
        //     });
        // });

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