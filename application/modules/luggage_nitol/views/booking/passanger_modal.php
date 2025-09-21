
<!-- ADD NEW sender -->
<div id="senderModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?php echo display('add_sender') ?></h4>
            </div>
            <div class="modal-body">
                <div id="SenderMsg" class="alert hide"></div>

                <?= form_open_multipart('luggage_nitol/luggage/newPassenger', array("id" => "senderFrm")) ?>

                <div class="form-group row">
                    <label for="name" class="col-sm-3 col-form-label"><?php echo display('name') ?> *</label>
                    <div class="col-sm-9">
                        <div class="row">
                            <div class="col-sm-6">
                                <input name="firstname" class="form-control" type="text"
                                       placeholder="<?php echo display('firstname') ?>" id="name"
                                       value="">
                            </div>
                            <div class="col-sm-6">
                                <input name="lastname" class="form-control" type="text"
                                       placeholder="<?php echo display('lastname') ?>"
                                       value="">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="phone" class="col-sm-3 col-form-label"><?php echo display('phone') ?></label>
                    <div class="col-sm-9">
                        <input name="phone" class="form-control" type="text"
                               placeholder="<?php echo display('phone') ?>" id="phone"
                               value="">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="email" class="col-sm-3 col-form-label"><?php echo display('email') ?></label>
                    <div class="col-sm-9">
                        <input name="email" class="form-control" type="text"
                               placeholder="<?php echo display('email') ?>" id="email"
                               value="">
                    </div>
                </div>


                <!-- client 2022 project update -->
                <div class="form-group row">
                    <label for="password" class="col-sm-3 col-form-label"><?php echo display('password') ?></label>
                    <div class="col-sm-9">
                        <input name="password" class="form-control" type="password"
                               placeholder="<?php echo display('password') ?>" id="password"
                               value="">
                    </div>
                </div> 
                <!-- client 2022 project update -->

                <!-- New code 2021 direct update -->
                <div class="form-group row">
                        <label for="nid" class="col-sm-3 col-form-label"><?php echo display('nid_passport') ?> *</label>
                        <div class="col-sm-9">
                            <input name="nid" class="form-control" type="text" placeholder="<?php echo display('nid_passport') ?>"
                                id="nid" value="<?php echo (isset($passenger->nid))? $passenger->nid:'' ?>" >  
                        </div>
                    </div>
                 <!-- New code 2021 direct update -->


                <div class="form-group row">
                    <label for="address_line_1"
                           class="col-sm-3 col-form-label"><?php echo display('address_line_1') ?></label>
                    <div class="col-sm-9">
                        <input name="address_line_1" class="form-control" type="text"
                               placeholder="<?php echo display('address_line_1') ?>" id="address_line_1"
                               value="">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="address_line_2"
                           class="col-sm-3 col-form-label"><?php echo display('address_line_2') ?></label>
                    <div class="col-sm-9">
                        <input name="address_line_2" class="form-control" type="text"
                               placeholder="<?php echo display('address_line_2') ?>" id="address_line_2"
                               value="">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="country" class="col-sm-3 col-form-label"><?php echo display('country') ?></label>
                    <div class="col-sm-9">
                        <?php echo form_dropdown('country', $country_dropdown, "BD", ' class="form-control" id="country" style="width:100%"') ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="city" class="col-sm-3 col-form-label"><?php echo display('city') ?></label>
                    <div class="col-sm-9">
                        <input name="city" class="form-control" type="text" placeholder="<?php echo display('city') ?>"
                               id="city" value="">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="zip_code" class="col-sm-3 col-form-label"><?php echo display('zip_code') ?></label>
                    <div class="col-sm-9">
                        <input name="zip_code" class="form-control" type="text"
                               placeholder="<?php echo display('zip_code') ?>" id="zip_code"
                               value="">
                    </div>
                </div>

                <div class="form-group text-right">
                    <button type="reset" class="btn btn-primary w-md m-b-5"><?php echo display('reset') ?></button>
                    <button type="submit" class="btn btn-success w-md m-b-5"><?php echo display('save') ?></button>
                </div>

                <?php echo form_close() ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>



<!-- ADD NEW Reciver -->
<div id="receiverModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?php echo display('add_receiver') ?></h4>
            </div>
            <div class="modal-body">
                <div id="receiverMsg" class="alert hide"></div>

                <?= form_open_multipart('luggage_nitol/luggage/newPassenger', array("id" => "receiverFrm")) ?>

                <div class="form-group row">
                    <label for="name" class="col-sm-3 col-form-label"><?php echo display('name') ?> *</label>
                    <div class="col-sm-9">
                        <div class="row">
                            <div class="col-sm-6">
                                <input name="firstname" class="form-control" type="text"
                                       placeholder="<?php echo display('firstname') ?>" id="name"
                                       value="">
                            </div>
                            <div class="col-sm-6">
                                <input name="lastname" class="form-control" type="text"
                                       placeholder="<?php echo display('lastname') ?>"
                                       value="">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="phone" class="col-sm-3 col-form-label"><?php echo display('phone') ?></label>
                    <div class="col-sm-9">
                        <input name="phone" class="form-control" type="text"
                               placeholder="<?php echo display('phone') ?>" id="phone"
                               value="">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="email" class="col-sm-3 col-form-label"><?php echo display('email') ?></label>
                    <div class="col-sm-9">
                        <input name="email" class="form-control" type="text"
                               placeholder="<?php echo display('email') ?>" id="email"
                               value="">
                    </div>
                </div>


                <!-- client 2022 project update -->
                <div class="form-group row">
                    <label for="password" class="col-sm-3 col-form-label"><?php echo display('password') ?></label>
                    <div class="col-sm-9">
                        <input name="password" class="form-control" type="password"
                               placeholder="<?php echo display('password') ?>" id="password"
                               value="">
                    </div>
                </div> 
                <!-- client 2022 project update -->

                 <!-- New code 2021 direct update -->
                 <div class="form-group row">
                        <label for="nid" class="col-sm-3 col-form-label"><?php echo display('nid_passport') ?> *</label>
                        <div class="col-sm-9">
                            <input name="nid" class="form-control" type="text" placeholder="<?php echo display('nid_passport') ?>"
                                id="nid" value="<?php echo (isset($passenger->nid))? $passenger->nid:'' ?>" >  
                        </div>
                    </div>
                 <!-- New code 2021 direct update -->


                <div class="form-group row">
                    <label for="address_line_1"
                           class="col-sm-3 col-form-label"><?php echo display('address_line_1') ?></label>
                    <div class="col-sm-9">
                        <input name="address_line_1" class="form-control" type="text"
                               placeholder="<?php echo display('address_line_1') ?>" id="address_line_1"
                               value="">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="address_line_2"
                           class="col-sm-3 col-form-label"><?php echo display('address_line_2') ?></label>
                    <div class="col-sm-9">
                        <input name="address_line_2" class="form-control" type="text"
                               placeholder="<?php echo display('address_line_2') ?>" id="address_line_2"
                               value="">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="country" class="col-sm-3 col-form-label"><?php echo display('country') ?></label>
                    <div class="col-sm-9">
                        <?php echo form_dropdown('country', $country_dropdown,"BD", ' class="form-control" id="country" style="width:100%"') ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="city" class="col-sm-3 col-form-label"><?php echo display('city') ?></label>
                    <div class="col-sm-9">
                        <input name="city" class="form-control" type="text" placeholder="<?php echo display('city') ?>"
                               id="city" value="">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="zip_code" class="col-sm-3 col-form-label"><?php echo display('zip_code') ?></label>
                    <div class="col-sm-9">
                        <input name="zip_code" class="form-control" type="text"
                               placeholder="<?php echo display('zip_code') ?>" id="zip_code"
                               value="">
                    </div>
                </div>

                <div class="form-group text-right">
                    <button type="reset" class="btn btn-primary w-md m-b-5"><?php echo display('reset') ?></button>
                    <button type="submit" class="btn btn-success w-md m-b-5"><?php echo display('save') ?></button>
                </div>

                <?php echo form_close() ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>