<div class="form-group text-right">
    <?php if($this->permission->method('price', 'create')->access()): ?>
        <a href="<?php echo base_url('price/price_luggage_controller/create_price'); ?>"><button type="button" class="btn btn-primary btn-md">
        <?php echo display('add_price') ?>
    </button></a>
    <?php endif; ?> 
</div>

<div class="row">
    <!--  table area -->
    <div class="col-sm-12">

        <div class="panel panel-default thumbnail">

            <div class="panel-body">
                <table width="100%" class="datatable table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>
                                <?php echo display('sl') ?>
                            </th>
                            <th>
                                <?php echo display('route_id') ?>
                            </th>
                            <th>
                                <?php echo display('vehicle_type_id') ?>
                            </th>
                            <th>
                                <?php echo display('max_weight_limit') ?>
                            </th>
                             <th>
                                <?php echo display('urgency') ?>
                            </th>
                             <th>
                                <?php echo display('urgency_price') ?>
                            </th>

                            <th>
                                <?php echo display('action') ?>
                            </th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($prices)) { ?>
                            <?php $sl = 1; ?>
                                <?php foreach ($prices as $query) { ?>
                                    <tr class="<?php echo ($sl & 1)?" odd gradeX ":"even gradeC " ?>">
                                        <td>
                                            <?php echo $sl; ?>
                                        </td>
                                        <td>
                                            <?php echo $query->name; ?>
                                        </td>
                                        <td>
                                            <?php echo $query->type; ?>
                                        </td>
                                        <td>
                                            <?php echo $query->max_weight_carry; ?>
                                        </td>
                                         <td>
                                            <?php echo $query->urgency_status; ?>
                                        </td>
                                         <td>
                                            <?php echo $query->urgent_price_add; ?>
                                        </td>
                                       
                                        <td class="center">
                                            <?php if($this->permission->method('price', 'read')->access()): ?>
                                            <a href="<?php echo base_url("price/price_luggage_controller/price_luggage_view/$query->luggage_price_master_id") ?>" class="btn btn-xs btn-default"><i class="fa fa-eye"></i></a>
                                            <?php endif; ?>


                                            <?php if($this->permission->method('price', 'update')->access()): ?>
                                            <a href="<?php echo base_url("price/price_luggage_controller/price_update/$query->luggage_price_master_id") ?>" class="btn btn-xs btn-success"><i class="fa fa-pencil"></i></a>
                                            <?php endif; ?>


                                            <?php if($this->permission->method('price', 'delete')->access()): ?>
                                            <a href="<?php echo base_url("price/price_luggage_controller/price_delete/$query->luggage_price_master_id") ?>" class="btn btn-xs btn-danger" onclick="return confirm('<?php echo display('are_you_sure') ?>') "><i class="fa fa-times" aria-hidden="true"></i>
                                            </a> 
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php $sl++; ?>
                                <?php } ?>
                            <?php } ?>
                    </tbody>
                </table>
                <!-- /.table-responsive -->
            </div>
        </div>
    </div>
</div>




<div id="add0" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header" style="background-color:green; color: white">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <center><strong><?php echo display('add_price') ?></strong></center>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <div class="panel">
                            <div class="panel-body">
                                <?= form_open('price/price_controller/create_price',array('name'=>'myForm')) ?>
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
                                            <?php echo form_dropdown('vehicle_type_id',$vehc,null,'class="form-control" style="width:100%"') ?>
                                        </div>

                                    </div>
                                    <div class="form-group row">
                                        <label for="price" class="col-sm-4 col-form-label">
                                            <?php echo display('price') ?> *</label>
                                        <div class="col-sm-8">
                                            <input name="price" class="form-control" type="text" placeholder="<?php echo display('price') ?>" id="price">
                                        </div>

                                    </div>
                                     <div class="form-group row">
                                        <label for="childere_price" class="col-sm-4 col-form-label">
                                            <?php echo 'children Price' ?> *</label>
                                        <div class="col-sm-8">
                                            <input name="childere_price" class="form-control" type="text" placeholder="<?php echo 'children Price' ?>" id="pchildere_rice">
                                        </div>

                                    </div>
                                     <div class="form-group row">
                                        <label for="special_price" class="col-sm-4 col-form-label">
                                            <?php echo 'Special Price' ?> *</label>
                                        <div class="col-sm-8">
                                            <input name="special_price" class="form-control" type="text" placeholder="<?php echo 'Special Price' ?>" id="special_price">
                                        </div>

                                    </div>
                                    <div class="form-group row">
                                        <label for="group_price_per_person" class="col-sm-4 col-form-label">
                                            <?php echo display('group_price_per_person') ?>
                                        </label>
                                        <div class="col-sm-8">
                                            <input name="group_price_per_person" class="form-control" onkeyup="Checkprice()" type="text" placeholder="<?php echo display('group_price_per_person') ?>" id="group_price_per_person">
                                        </div>

                                    </div>
                                    <div class="form-group row">
                                        <label for="group_size" class="col-sm-4 col-form-label">
                                            <?php echo display('group_size') ?>
                                        </label>
                                        <div class="col-sm-8">
                                            <input type="text" name="group_size" class="form-control" placeholder="<?php echo display('group_size') ?>" id="group_size">
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
            </div>
        </div>
    </div>
</div>
<script>
function Checkprice() {
     var gp = document.getElementById("group_price_per_person").value;
     var ap = document.getElementById("price").value;
           if (parseInt(ap) <= parseInt(gp) ) {
        setTimeout(function(){
        alert('Group Price Can not Greater Than Adult price');
        document.getElementById("group_price_per_person").value = '';

        },1000);

            return false;
        }
        return true;
}
</script>