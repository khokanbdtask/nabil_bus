<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
                <div class="panel-title">
                    <h4>
                        <a href="<?php echo base_url('trip/trip/otherLocationFromLoad') ?>" class="btn btn-sm btn-info" title="Add"><i
                                    class="fa fa-plus"></i> <?php echo display('add') ?></a>
                    </h4>
                </div>
            </div>
            <div class="panel-body">

                <div class="">
                    <table class="datatable table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th><?php echo display('sl_no') ?></th>
                            <th><?php echo display('trip_title') ?></th>
                            <th>Location Name</th>
                            <th>Extra Fee</th>
                            <th><?php echo display('status') ?></th>
                            <th><?php echo display('action') ?></th>
                        </tr>
                        </thead>
                        <tbody> 
                        
                        <?php if (!empty($otherlocation)) ?>
                        <?php $sl = 1; ?>
                        <?php foreach ($otherlocation as $otherlocationValue) { ?>
                            <tr>
                                <td><?php echo $sl++; ?></td>
                                <td><?php echo $otherlocationValue->name ; ?></td>
                                <td><?php echo $otherlocationValue->location_name; ?></td>
                                <td><?php echo $otherlocationValue->extra_fee; ?></td>
                                <td>
                                <?php if (($otherlocationValue->otherstatus == 1)): ?>
                                    <span class="badge bg-success">
                                        Active 
                                    </span>
                                <?php else: ?>
                                    <span class="badge bg-black">
                                        Disable 
                                    </span>
                                <?php endif; ?>
                                </td>
                               
                                <td>

                                    <?php if ($this->permission->method('trip', 'update')->access()): ?>
                                        <a href="<?php echo base_url("trip/trip/otherLocationEdit/$otherlocationValue->otherlocationid") ?>"
                                           class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="left"
                                           title="Update"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                    <?php endif; ?>

                                    <!-- <?php if ($this->permission->method('trip', 'delete')->access()): ?>
                                        <a href="<?php echo base_url("trip/trip/delete/$otherlocationValue->trip_id") ?>"
                                           onclick="return confirm('<?php echo display("are_you_sure") ?>')"
                                           class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="right"
                                           title="Delete "><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                    <?php endif; ?> -->
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

 