<div class="form-group text-right">
    <?php if($this->permission->method('price', 'create')->access()): ?>
        <a href="<?php echo base_url('luggage/packages/create_price'); ?>"><button type="button" class="btn btn-primary btn-md">
        <?php echo display('add_package') ?>
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
                                <?php echo display('package_name') ?>
                            </th>
                            <th>
                                <?php echo display('route_id') ?>
                            </th>
                            <th>
                                <?php echo display('vehicle_type_id') ?>
                            </th>
                            <th>
                                <?php echo display('weight_limit') ?>
                            </th>
                            <th>
                                <?php echo display('price') ?>
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
                                            <?php echo $query->package_name; ?>
                                        </td>
                                        <td>
                                            <?php echo $query->name; ?>
                                        </td>
                                        <td>
                                            <?php echo $query->type; ?>
                                        </td>
                                        <td>
                                            <?php echo $query->min_weight." - ".$query->max_weight; ?>
                                        </td>
                                         <td>
                                            <?php echo $query->package_price; ?>
                                        </td>
                                        <td>
                                            <?php echo ($query->urgency_status==1)?"Yes":"No"; ?>
                                        </td>
                                         <td>
                                            <?php echo $query->urgent_price_add; ?>
                                        </td>


                                       
                                        <td class="center">
                                            <?php if($this->permission->method('price', 'read')->access()): ?>
                                            <a href="<?php echo base_url("luggage/packages/price_luggage_view/$query->package_id") ?>" class="btn btn-xs btn-default"><i class="fa fa-eye"></i></a>
                                            <?php endif; ?>


                                            <?php if($this->permission->method('price', 'update')->access()): ?>
                                            <a href="<?php echo base_url("luggage/packages/price_update/$query->package_id") ?>" class="btn btn-xs btn-success"><i class="fa fa-pencil"></i></a>
                                            <?php endif; ?>


                                            <?php if($this->permission->method('price', 'delete')->access()): ?>
                                            <a href="<?php echo base_url("luggage/packages/price_delete/$query->package_id") ?>" class="btn btn-xs btn-danger" onclick="return confirm('<?php echo display('are_you_sure') ?>') "><i class="fa fa-times" aria-hidden="true"></i>
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