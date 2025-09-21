<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
                <div class="panel-title">
                    <h4>
                        <a href="<?php echo base_url('dashboard/rest_api/index') ?>" class="btn btn-sm btn-success" title="List"> <i class="fa fa-list"></i> <?php echo display('list') ?></a> 
                        <?php if($api->id): ?>
                        <a href="<?php echo base_url('dashboard/rest_api/form') ?>" class="btn btn-sm btn-info" title="Add"><i class="fa fa-plus"></i> <?php echo display('add') ?></a> 
                        <?php endif; ?>
                    </h4>
                </div>
            </div>
            <div class="panel-body">
                <?php echo form_open_multipart("dashboard/rest_api/form/$api->id") ?>
                    
                    <?php echo form_hidden('id',$api->id) ?>
                    
                    <div class="form-group row">
                        <label for="secret_key" class="col-sm-3 col-form-label"><?php echo display('secret_key') ?> *</label>
                        <div class="col-sm-9">
                            <input name="secret_key" readonly="" class="form-control" type="text" placeholder="<?php echo display('secret_key') ?>" id="secret_key"  value="<?php echo $secret_key ?>">
                        </div>
                    </div>

                   
         
                    <div class="form-group text-right">
                        <button type="button" class="btn btn-primary w-md m-b-5" onClick="window.location.reload();"><?php echo display('reset') ?></button>
                        <button type="submit" class="btn btn-success w-md m-b-5"><?php echo display('save') ?></button>
                    </div>
                <?php echo form_close() ?>

            </div>
        </div>
    </div>
</div>

 