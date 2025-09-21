<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
                <div class="panel-title">
                    <h4>
                      <?php echo display('disclaimer') ?>
                    </h4>
                </div>
            </div>
            <div class="panel-body">

                <?= form_open_multipart('website/disclaimer/disclaimer_form') ?>
                    <?php echo form_hidden('id', (!empty($disclaimer->id))?$disclaimer->id:'') ?>
                    <div class="form-group row">
                        <label for="disclaimer" class="col-sm-3 col-form-label"><?php echo display('disclaimer') ?> *</label>
                        <div class="col-sm-9">   
                        <textarea name="disclaimer_details" class="tinymce form-control"  placeholder="<?php echo display('disclaimer') ?>" rows="7"><?php echo (!empty($disclaimer->disclaimer_details)?$disclaimer->disclaimer_details:'') ?></textarea>
                                   
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
