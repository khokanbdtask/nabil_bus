<div class="form-group text-right"> 
    <a href="<?php echo base_url();?>account/account_controller/create_transaction" class="btn btn-primary"><?php echo display('account_transaction') ?></a>
</div>

 
<div class="row">
        <div class="col-sm-12 col-md-12">
            <div class="panel panel-bd lobidrag">
                <div class="panel-heading">
                    <div class="panel-title">
                        <h4><?php echo (!empty($title)?$title:null) ?></h4>
                    </div>
                </div>
                <div class="panel-body">
                     <!-- New code 2021 direct update  -->
                        <?= form_open_multipart('account/account_controller/transaction_update/'. $data->account_tran_id) ?>
                     <!-- New code 2021 direct update  -->

                    <input type="hidden" name="account_tran_id" value="<?php echo $data->account_tran_id ?>">
                    
                         <div class="form-group row">
                            <label for="account_id" class="col-sm-3 col-form-label"><?php echo display('account_id') ?> *</label>
                            <div class="col-sm-9">
                               <?php echo form_dropdown('account_id', $accountlist, $data->account_id, 'class="form-control"'); ?>
                            </div>
                        </div>


                     <!-- New code 2021 direct update  -->
                        <div class="form-group row">
                            <label for="account_id" class="col-sm-3 col-form-label"><?php echo display('payment_method') ?> *</label>
                            <div class="col-sm-9">


                             <select name="payment_method" id="payment_method" class="form-control">
                             <?php foreach ($paymethod as $value): ?>
                                <?php if ($value->payment_method == $data->payment_method): ?>
                                    <option selected value="<?php echo $value->id ?>"><?php echo $value->payment_method ?></option>
                                    <?php else: ?>
                                        <option  value="<?php echo $value->id ?>"><?php echo $value->payment_method ?></option>
                                <?php endif; ?>
                                
                             <?php endforeach; ?>
                            </select>

                            
                            </div>
                        </div>

                        <div class="form-group row">
                                <label for="account_id" class="col-sm-3 col-form-label"><?php echo display('invoice') ?> *</label>
                                    
                                        <div class="col-sm-9">
                                          <input type="file" name="image" id="image" aria-describedby="fileHelp" accept=".jpg,.png,.pdf,.jpeg,.gif,.bmp">
                                             <small id="fileHelp" class="text-muted"></small>
                                             <img src="<?php echo base_url().$data->document_pic?>" width="200px" />
                                             </div>                     
                         </div>
                     <!-- New code 2021 direct update  -->


                        <div class="form-group row">
                            <label for="amount" class="col-sm-3 col-form-label"><?php echo display('amount') ?> *</label>
                            <div class="col-sm-9">
                               <input name="amount" class="form-control" type="text" placeholder="<?php echo display('amount') ?>" id="amount" value="<?php echo $data->amount?>"> 
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="transaction_description" class="col-sm-3 col-form-label"><?php echo display('transaction_description') ?></label>
                            <div class="col-sm-9">
                                <textarea name="transaction_description" class="form-control" placeholder="<?php echo display('transaction_description') ?>" id="transaction_description"><?php echo $data->transaction_description; ?></textarea>
                            </div>
                        </div>
                         
                        
                        <div class="form-group text-right">
                            <button type="reset" class="btn btn-primary w-md m-b-5"><?php echo display('reset') ?></button>
                            <button type="submit" class="btn btn-success w-md m-b-5"><?php echo display('update') ?></button>
                        </div>
                    <?php echo form_close() ?>

                </div>  
            </div>
        </div>
    </div>