<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
                <div class="panel-title">
                    <h4> <?php if($this->permission->method('account','create')->access()): ?>
                        <a href="<?php echo base_url('account/Pamyment_method_controller/form') ?>" class="btn btn-sm btn-info" title="Add"><i class="fa fa-plus"></i> <?php echo display('add') ?></a>  
                        <?php endif; ?>
                    </h4>
                </div>
            </div>
            <div class="panel-body">
 
                <div class="">
                    <table class="datatable2 table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th><?php echo display('sl_no') ?></th>
                              <th><?php echo display('account_number') ?></th>
                                <th><?php echo display('action') ?></th> 
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($bank)) ?>
                            <?php $sl = 1; ?>
                            <?php foreach ($paymentMethod as $paymentMethod) { ?>
                            <tr>
                                <td><?php echo $sl++; ?></td>
                                <td><?php echo $paymentMethod->payment_method; ?></td>
                                
                                <td>

                                <?php if($this->permission->method('account','update')->access()): ?>
                                    <a href="<?php echo base_url("account/Pamyment_method_controller/form/$paymentMethod->id") ?>" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="left" title="Update"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                <?php endif; ?>

                                <?php if($this->permission->method('account','delete')->access()): ?>
                                    <a href="<?php echo base_url("account/Pamyment_method_controller/delete/$paymentMethod->id") ?>" onclick="return confirm('<?php echo display("are_you_sure") ?>')" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="right" title="Delete "><i class="fa fa-trash-o" aria-hidden="true"></i></a>
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

 