<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
                <div class="panel-title">
                    <h4>
                        <a href="<?php echo base_url('trip/assign/form') ?>" class="btn btn-sm btn-info" title="Add"><i
                                    class="fa fa-plus"></i> <?php echo display('close_trip') ?></a>
                    </h4>
                </div>
            </div>
            <div class="panel-body">

                <div class="">
                    <table class="triplist table table-bordered">
                        <thead>
                        <tr>
                            <th><?php echo display('sl_no') ?></th>
                            <th><?php echo display('trip_name') ?></th>
                            <th><?php echo display('reg_no') ?></th>
                            <th><?php echo display('route_name') ?></th>
                            <th><?php echo display('driver_name') ?></th>
                            <th><?php echo display('status') ?></th>
                            <th><?php echo display('action') ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($assigns)) ?>
                        <?php $sl = 1; ?>
                        <?php foreach ($assigns as $assign) { ?>
                            <tr class="<?php if(!empty($assign->isClosed) && $assign->trip_assign_status == 1){
                                                echo $assign->isClosed;
                                                }
                                                else if(!empty($assign->isClosed) && $assign->trip_assign_status == 0)
                                                {
                                                    echo "bg-danger";
                                                } 
                                                ?>">
                                <td><?php echo $sl++; ?></td>
                                <td><?php echo $assign->trip_title; ?></td>
                                <td><?php echo $assign->reg_no; ?></td>
                                <td><?php echo $assign->trip_route_name; ?></td>
                                <td>
                                <!-- New code 2021 direct update  -->
                                <?php $dname = $this->db->select("employee_history.id, CONCAT_WS(' ',first_name, second_name) AS name")
                                                 ->from("employee_history")
                                                 ->join('dynamic_assign', 'dynamic_assign.employeeid = employee_history.id')
                                                ->where('dynamic_assign.employeetype','Driver')
                                                ->where('dynamic_assign.randomid',$assign->id_no)
                                                ->get()
                                                ->result();
                                
                                 ?>
                                    <?php echo $assign->driver_name; ?>,
                                    <?php foreach ($dname as $value):?>
                                        <?php if ($value->name != $assign->driver_name): ?>
                                            <?php echo $value->name; ?>,
                                            <?php endif; ?>
                                       
                                    <?php endforeach;?>
                                <!-- New code 2021 direct update  -->
                                </td>
                                <td><?php echo(($assign->trip_assign_status == 1) ? display('active') : display('inactive')); ?></td>
                                <td width="150">

                                    <?php if ($this->permission->method('trip', 'read')->access()): ?>
                                        <a href="<?php echo base_url("trip/assign/view/$assign->id_no") ?>"
                                           class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="left"
                                           title="View"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                    <?php endif; ?>

                                    <?php if ($this->permission->method('trip', 'update')->access()): ?>
                                        <a href="<?php echo base_url("trip/assign/form/$assign->id") ?>"
                                           class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="left"
                                           title="Update"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                    <?php endif; ?>


                                    <?php if ($this->permission->method('trip', 'update')->access()): ?>
                                        <?php if (empty($assign->closed_by_id)): ?>
                                            <a href="<?php echo base_url("trip/close/form/$assign->id") ?>"
                                               class="btn btn-primary btn-sm" data-toggle="tooltip"
                                               data-placement="left" title="Close Trip"><i class="fa fa-check"
                                                                                           aria-hidden="true"></i></a>
                                        <?php endif; ?>
                                    <?php endif; ?>


                                    <?php if ($this->permission->method('trip', 'delete')->access()): ?>
                                        <a href="<?php echo base_url("trip/assign/delete/$assign->id") ?>"
                                           onclick="return confirm('<?php echo display("are_you_sure") ?>')"
                                           class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="right"
                                           title="Delete "><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                    <?= $links ?>
                </div>
            </div>
        </div>
    </div>
</div>

 <script>
     $( document ).ready(function() {
        var logo = "<?php echo $logo->text_logo ?>"; 
        $('.triplist').DataTable({
        responsive: true,
        paging: true,
        dom: "<'row'<'col-sm-8'lB><'col-sm-4'f>>tp",
        "lengthMenu": [[25, 50, 100, 150, 200, 500, -1], [25, 50, 100, 150, 200, 500, "All"]],
        buttons: [
            {extend: 'copy', className: 'btn-sm'},
            {extend: 'csv', title: logo , className: 'btn-sm'},
            {extend: 'excel', title: logo , className: 'btn-sm'},
            {extend: 'pdf', title: logo , className: 'btn-sm'},
            {extend: 'print',title: logo , className: 'btn-sm'}
        ]
    });
    });
 </script>