
<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
                <div class="panel-title">
                    
                </div>
            </div>
            <div class="panel-body">

                <?= form_open('luggage_nitol/packages/upDateOtherLocation/'.$otherlocation->id) ?>

              

                <div class="form-group row">
                    <label for="route" class="col-sm-3 col-form-label"><?php echo display('route') ?> *</label>
                    <div class="col-sm-9">
                    
                        <select class="form-control trips_info" name="trip_route_id" id="">
                        
                        <?php foreach ($route_list as $kye => $item): ?>

                            <?php if ($kye == $otherlocation->trip_route_id) : ?>
                                <option value="<?php echo $kye ?>" selected><?= $item ?></option>
                            <?php else : ?>
                                <option value="<?php echo $kye ?>"><?= $item?></option>
                            <?php endif ?>
                           

                        <?php endforeach ?>
                       
                        </select>
                    </div>
                </div>
                            
                

                <div class="form-group row">
                    <label for="locationName" class="col-sm-3 col-form-label">Location Name *</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control trips_info" name="location_name" value="<?php echo $otherlocation->location_name ?>" required>
                        
                    </div>
                </div>
                
               

                <div class="form-group row">
                    <label for="status" class="col-sm-3 col-form-label">Status *</label>
                    <div class="col-sm-9">
                        


                        <?php if ($otherlocation->status == 1) : ?>
                            <label class="radio-inline"><input type="radio" value="1" name="status" checked>Active</label>
                            <label class="radio-inline"><input type="radio" value="0" name="status">Inactive</label>
                            <?php else : ?>
                            <label class="radio-inline"><input type="radio" value="1" name="status" >Active</label>
                            <label class="radio-inline"><input type="radio" value="0" name="status" checked>Inactive</label>
                        <?php endif ?>
                           
                            
                        
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

<script type="text/javascript">


    $("select.trips_info").change(function () {
        var selectedOptions = [];
        $("select.trips_info").each(function () {
            var value = $(this).val();
            if ($.trim(value)) {
                selectedOptions.push(value);
            }
        });
        $("#trip_title").html(selectedOptions.join('-'));
    });
</script>
