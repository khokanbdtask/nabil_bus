<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
                <div class="panel-title">
                    <h4>
                        <a href="<?php echo base_url('trip/assign/freezeform/'.$tripid.'') ?>" class="btn btn-sm btn-info" title="Add"><i
                                    class="fa fa-plus"></i> Add Seat</a>
                    </h4>
                </div>
            </div>
            <div class="panel-body">

                <div class="">
                    <table class="triplist table table-bordered">
                        <thead>
                        <tr>
                            <th><?php echo display('sl_no') ?></th>
                            <th><?php echo display('seat_number') ?></th>
                            <th><?php echo display('status') ?></th>
                            <th><?php echo "Action" ?></th>
                            
                        </tr>
                        </thead>
                        <tbody>
                       
                            <?php $sl = 1; ?>
                            <?php foreach ($seat_list as $assign) { ?>
                            <tr>
                                <td><?php echo $sl++; ?></td>
                                <td><?php echo $assign->seat_number; ?></td>
                                <td><?php echo $assign->status; ?></td>
                               <td width="150">

                                    <?php if ($this->permission->method('trip', 'read')->access()): ?>
                                        <?php if ($assign->status == 1) : ?>
                                        <?php  $status = 0; ?>

                                            <a href="<?php echo base_url("trip/assign/status/".$status.'/'.$assign->id.'/'.$tripid) ?>"
                                            class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="left"
                                            title="Disable"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                                        <?php endif ?>
                                        
                                    <?php endif; ?>

                                    <?php if ($this->permission->method('trip', 'update')->access()): ?>
                                        <?php if ($assign->status == 0) : ?>
                                        <?php  $status = 1; ?>

                                        <a href="<?php echo base_url("trip/assign/status/".$status.'/'.$assign->id.'/'.$tripid) ?>"
                                           class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="left"
                                           title="Update"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                        <?php endif ?>
                                    <?php endif; ?>

                                   
                                    <?php if ($this->permission->method('trip', 'delete')->access()): ?>
                                        <a href="<?php echo base_url("trip/assign/deletefreeze/".$tripid.'/'.$assign->id) ?>"
                                           onclick="return confirm('<?php echo display("are_you_sure") ?>')"
                                           class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="right"
                                           title="Delete "><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                    <?php endif; ?>
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