<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
                <div class="panel-title">
                    <h4>
                      
                    </h4>
                </div>
            </div>
            <div class="panel-body">

                <?= form_open_multipart('ticket/booking/addPartialPay') ?>

                <div class="form-group row" id="parpay">
                        <label for="partialpayamount" class="col-sm-3 col-form-label">Due Amount</label>
                        <div class="col-sm-9">
                            <input name="partialpayamount" class="form-control" type="text" value="<?= (int) $booking->amount - (int) $booking->partialpay; ?>" readonly>
                        </div>
                </div>
                    
                <div id="partialdiv">
                    <div class="form-group row" id="pay_type">
                        <label for="offerCode" class="col-sm-3 col-form-label">Payment Type</label>
                        <div class="col-sm-9">
                                    <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="pay_type" id="cash" value="cash" required>
                                            <label class="form-check-label" for="pay_type">Cash</label>

                                            <input class="form-check-input" type="radio" name="pay_type" id="check" value="bank">
                                            <label class="form-check-label" for="pay_type">Bank</label>

                                            <input class="form-check-input" type="radio" name="pay_type" id="check" value="eft">
                                            <label class="form-check-label" for="pay_type">EFT</label>
                                    </div>
                                    
                            <div id="offerHelpText"></div>
                        </div>
                    </div>

                    <?php if ($booking->paystep >= 3) : ?>
                        <div class="form-group row" id="parpay">
                            <label for="partialpay" class="col-sm-3 col-form-label">Partial Pay Amount</label>
                            <div class="col-sm-9">
                                <input name="partialpay" class="form-control" type="text" value="<?= (int) $booking->amount - (int) $booking->partialpay; ?>" id="partialpay" required readonly>
                            </div>
                        </div>
                    <?php else : ?>

                        <div class="form-group row" id="parpay">
                            <label for="partialpay" class="col-sm-3 col-form-label">Partial Pay Amount</label>
                            <div class="col-sm-9">
                                <input name="partialpay" class="form-control" type="text" placeholder="Partial Pay Amount" id="partialpay" required>
                            </div>
                        </div>
                        
                    <?php endif ?>
                    

                    <div class="form-group row">
                        <label for="pay_detail" class="col-sm-3 col-form-label">Payment Detail </label>
                        <div class="col-sm-9">
                            <input name="pay_detail" class="form-control" type="text" placeholder="Payment Detail" id="pay_detail" >
                        </div>
                    </div>
                    </div>

                    <input name="bookingid" class="form-control" type="hidden" value="<?= $booking->id;?>">
         
                    <div class="form-group text-right">
                        <button type="reset" class="btn btn-primary w-md m-b-5"><?php echo display('reset') ?></button>
                        <button type="submit" class="btn btn-success w-md m-b-5"><?php echo display('save') ?></button>
                    </div>
                <?php echo form_close() ?>

            </div>  
        </div>
    </div>
</div>
