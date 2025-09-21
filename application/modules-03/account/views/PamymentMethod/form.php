<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
                <div class="panel-title">
                    <h4>
                        <a href="<?php echo base_url('account/Pamyment_method_controller/index') ?>" class="btn btn-sm btn-success" title="List"><i class="fa fa-list"></i> <?php echo display('list') ?></a> 
                        <?php if($paymentMethod->id): ?>
                        <a href="<?php echo base_url('account/Pamyment_method_controller/form') ?>" class="btn btn-sm btn-info" title="Add"><i class="fa fa-plus"></i> <?php echo display('add') ?></a> 
                        <?php endif; ?>
                    </h4>
                </div>
            </div>
            <div class="panel-body">
                <?= form_open_multipart('account/Pamyment_method_controller/form/') ?>
                    <?php echo form_hidden('id', $paymentMethod->id); ?>

                    <div class="form-group row">
                        <label for="type" class="col-sm-3 col-form-label"><?php echo display('payment_method') ?> *</label>
                        <div class="col-sm-9">
                            <input name="payment_method" class="form-control" type="text" placeholder="<?php echo display('payment_method') ?>" id="payment_method" value="<?php echo $paymentMethod->payment_method ?>">
                        </div>
                    </div> 

                    
                    <div class="form-group text-right">
                        <button type="reset" class="btn btn-primary w-md m-b-5"><?php echo display('reset') ?></button>
                        <button type="submit" class="btn btn-success w-md m-b-5"><?php echo display('save') ?></button>
                    </div>
                <?php echo form_close() ?>

            </div>  
        </div>
    </div>
</div>