<div class="form-group text-right">
    <?php 
    // if($this->permission->method('tracking', 'create')->access()): 
        ?>
    <a href="<?php echo base_url("tracking/tracking_controller/tracking_insert") ?>">
        <button type="button" class="btn btn-primary btn-md" data-target="#add0" data-toggle="modal"><i class='fa fa-gift' aria-hidden='true'></i> <?php echo display('add') ?>
        </button>
    </a>
    <?php 
// endif; 
?> 
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
                                <?php echo display('tracking_date') ?>
                            </th>
                            
                            <th>
                                <?php echo display('tracking_route_id') ?>
                            </th>

                            <th>
                                <?php echo display('tracking_fleet_id') ?>
                            </th>
                            <th>
                                <?php echo display('stoppage_points') ?>
                            </th>
                            <th>
                                <?php echo display('arrival_time') ?>
                            </th>

                            <th>
                                <?php echo display('progress') ?>
                            </th>

                            <th>
                                <?php echo display('view_details') ?>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if (!empty($trackings)) { ?>
                        <?php $sl = 1; ?>
                        <?php foreach ($trackings as $query) { ?>
 
                        <tr>
                            <td>
                                <?php echo $sl; ?>
                            </td>
                            
                            <td>
                                <?php echo $query->tracking_date; ?>
                            </td>

                            <td>
                                <?php echo $query->trip_title; ?>
                            </td>
                            <td>
                                <?php echo $query->reg_no; ?>
                            </td>
                            <td>
                                <?php echo $query->reached_points; ?>
                            </td>
                            <td>
                                <?php echo $query->arrival_time; ?>
                            </td> 

                            <td>
                                <?= $query->progress ?>
                            </td>
 

                            <td> 

                                <?php if($this->permission->method('tracking', 'create')->access()): ?>
                                <a href="<?php echo base_url("tracking/tracking_controller/view_details/$query->tracking_id") ?>" class="btn btn-xs btn-default"><i class="fa fa-eye"></i></a>
                                <?php endif; ?>

                                <?php if($this->permission->method('tracking', 'update')->access()): ?>
                                <a href="<?php echo base_url("tracking/tracking_controller/tracking_insert/$query->tracking_id") ?>" class="btn btn-xs btn-success"><i class="fa fa-pencil"></i></a><?php endif; ?>

                                <?php if($this->permission->method('tracking', 'delete')->access()): ?>
                                <a href="<?php echo base_url("tracking/tracking_controller/tracking_delete/$query->tracking_id") ?>" class="btn btn-xs btn-danger" onclick="return confirm('<?php echo display('are_you_sure') ?>') "><i class="fa fa-times" aria-hidden="true"></i></a> 
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
