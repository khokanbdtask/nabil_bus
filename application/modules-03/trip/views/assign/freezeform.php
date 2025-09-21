<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
                <div class="panel-title">
                    <h4>
                        <a href="<?php echo base_url("trip/assign/freezelist/$tripidassignid") ?>" class="btn btn-sm btn-success"
                           title="List"> <i class="fa fa-list"></i> <?php echo display('list') ?></a>
                        
                    </h4>
                </div>
            </div>
            <div class="panel-body">

                <?= form_open('trip/assign/addfreeze/') ?>

              

               


                <div class="form-group row">
                    <label for="trip" class="col-sm-3 col-form-label">Choose a Sear Number: *</label>
                    <div class="col-sm-9">
                    <select name="seat_number" id="seat_number" class="form-control" required>
                        <?php foreach ($seats as $value) : ?>
                            <option value="<?php echo $value ;?>"><?php echo $value ;?></option>
                        <?php endforeach ?>
                        
                       
                    </select>
                    </div>
                </div>
               <input type="hidden" name="tripid" value="<?php echo $tripid ;?>">
               <input type="hidden" name="status" value="1">


                <div class="form-group text-right">
                    <button type="reset" class="btn btn-primary w-md m-b-5"><?php echo display('reset') ?></button>
                    <button type="submit" class="btn btn-success w-md m-b-5"><?php echo display('save') ?></button>
                </div>

            <?php echo form_close() ?>

            </div>
        </div>
    </div>
</div>
 