<style type="text/css">

</style>
<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
                <div class="panel-title">
                    <h4>
                        <a href="<?php echo base_url('trip/route/index') ?>" class="btn btn-sm btn-success"
                           title="List"> <i class="fa fa-list"></i> <?php echo display('list') ?></a>
                        <?php if ($route->id): ?>
                            <a href="<?php echo base_url('trip/route/add') ?>" class="btn btn-sm btn-info"
                               title="Add"><i class="fa fa-plus"></i> <?php echo display('add') ?></a>
                        <?php endif; ?>
                    </h4>
                </div>
            </div>
            <div class="panel-body">

                <?= form_open('trip/route/form') ?>
                <?php echo form_hidden('id', $route->id); ?>

                <div class="form-group row">
                    <label for="name" class="col-sm-3 col-form-label"><?php echo display('route_name') ?> *</label>
                    <div class="col-sm-9" hei>
                        <input name="name" class="form-control" type="text"
                               placeholder="<?php echo display('route_name') ?>" id="name"
                               value="<?php echo $route->name ?>">
                    </div>
                </div>


                <div class="form-group row">
                    <label for="start_point" class="col-sm-3 col-form-label"><?php echo display('start_point') ?>
                        *</label>
                    <div class="col-sm-9">
                        <?php echo form_dropdown('start_point', $location_list, (!empty($route->start_point) ? $route->start_point : null), 'class="form-control startend" id="start"') ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="end_point" class="col-sm-3 col-form-label"><?php echo display('end_point') ?> *</label>
                    <div class="col-sm-9">
                        <?php echo form_dropdown('end_point', $location_list, (!empty($route->end_point) ? $route->end_point : null), ' class="form-control startend" id="end"') ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-3 col-form-label" for="stoppage_points">Stoppage Points*</label>
                    <div class="col-sm-9">

                        <?php echo form_hidden('stoppage_point_id', $route->stoppage_points); ?>

                        <select name="stoppage_points[]" id="stoppage_points" class="form-control tokenfield"
                                multiple="multiple">

                        </select>
                    </div>

                </div>


                <div class="form-group row">
                    <label for="distance" class="col-sm-3 col-form-label"><?php echo display('distance') ?></label>
                    <div class="col-sm-9">
                        <input name="distance" class="form-control" type="text"
                               placeholder="<?php echo display('distance_kmmile') ?>" id="distance"
                               value="<?php echo $route->distance ?>">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="approximate_time"
                           class="col-sm-3 col-form-label"><?php echo display('approximate_time') ?></label>
                    <div class="col-sm-9">
                        <input name="approximate_time" class="form-control" type="text"
                               placeholder="<?php echo display('approximate_time') ?>" id="approximate_time"
                               value="<?php echo $route->approximate_time ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="children_seat"
                           class="col-sm-3 col-form-label"><?php echo display('children_seat') ?></label>
                    <div class="col-sm-9">
                        <input name="children_seat" class="form-control" type="text"
                               placeholder="<?php echo display('children_seat') ?>" id="children_seat"
                               value="<?php echo $route->children_seat ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="special_seat"
                           class="col-sm-3 col-form-label"><?php echo display('special_seat') ?></label>
                    <div class="col-sm-9">
                        <input name="special_seat" class="form-control" type="text"
                               placeholder="<?php echo display('special_seat') ?>" id="special_seat"
                               value="<?php echo $route->special_seat ?>">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="status" class="col-sm-3 col-form-label">Status *</label>
                    <div class="col-sm-9">
                        <label class="radio-inline">
                            <?php echo form_radio('status', '1', (($route->status == 1) ? 1 : 0), 'id="status"'); ?>
                            Active
                        </label>
                        <label class="radio-inline">
                            <?php echo form_radio('status', '0', (($route->status == "0") ? 1 : 0), 'id="status"'); ?>
                            Inactive
                        </label>
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

    $(window).load(function () {

        var spid = $("[name='stoppage_point_id']").val();

        var start = $("#start").val();
        var end = $("#end").val();

        $.ajax({
            url: '<?php echo base_url('trip/route/startendpoints') ?>',
            method: 'post',
            dataType: 'json',
            data: {
                '<?php echo $this->security->get_csrf_token_name() ?>': '<?php echo $this->security->get_csrf_hash() ?>',
                'start_point': start,
                'end_point': end,
                'stoppage_points': spid
            },
            success: function (data) {
                // stopagediv.html(data);
                $('#stoppage_points').html(data);
            },
            error: function (xhr) {
                alert('failed!');
            }
        });

        var spid_array = spid.split(",");
        var i = 0;
        for (i; i < spid_array.length; i++) {
            // alert(spid_array[i]);

            $("#stoppage_points").val(spid_array[i]).trigger("change");

        }

    });
</script> 