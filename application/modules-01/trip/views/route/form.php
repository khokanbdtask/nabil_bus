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

                    </h4>
                </div>
            </div>
            <div class="panel-body">

                <?= form_open('trip/route/form') ?>
                <?php echo form_hidden('id', ''); ?>

                <div class="form-group row">
                    <label for="name" class="col-sm-3 col-form-label"><?php echo display('route_name') ?> *</label>
                    <div class="col-sm-9" hei>
                        <input name="name" class="form-control" type="text"
                               placeholder="<?php echo display('route_name') ?>" id="name" value="">
                    </div>
                </div>


                <div class="form-group row">
                    <label for="start_point" class="col-sm-3 col-form-label"><?php echo display('start_point') ?>
                        *</label>
                    <div class="col-sm-9">
                        <?php echo form_dropdown('start_point', $location_list, '', 'class="form-control startend" id="start"') ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="end_point" class="col-sm-3 col-form-label"><?php echo display('end_point') ?> *</label>
                    <div class="col-sm-9">
                        <?php echo form_dropdown('end_point', $location_list, '', ' class="form-control startend" id="end"') ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-3 col-form-label" for="stoppage_points">Stoppage Points*</label>
                    <div class="col-sm-9">

                        <select name="stoppage_points[]" id="stoppage_points" class="form-control tokenfield"
                                multiple="multiple">
                            <!-- Options will come from JS -->
                        </select>
                    </div>

                </div>


                <div class="form-group row">
                    <label for="distance" class="col-sm-3 col-form-label"><?php echo display('distance') ?></label>
                    <div class="col-sm-9">
                        <input name="distance" class="form-control" type="text"
                               placeholder="<?php echo display('distance_kmmile') ?>" id="distance">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="approximate_time"
                           class="col-sm-3 col-form-label"><?php echo display('approximate_time') ?></label>
                    <div class="col-sm-9">
                        <input name="approximate_time" class="form-control" type="text"
                               placeholder="<?php echo display('approximate_time') ?>" id="approximate_time">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="children_seat"
                           class="col-sm-3 col-form-label"><?php echo display('children_seat') ?></label>
                    <div class="col-sm-9">
                        <input name="children_seat" class="form-control" type="text"
                               placeholder="<?php echo display('children_seat') ?>" id="children_seat">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="special_seat"
                           class="col-sm-3 col-form-label"><?php echo display('special_seat') ?></label>
                    <div class="col-sm-9">
                        <input name="special_seat" class="form-control" type="text"
                               placeholder="<?php echo display('special_seat') ?>" id="special_seat">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="status" class="col-sm-3 col-form-label">Status *</label>
                    <div class="col-sm-9">
                        <label class="radio-inline">
                            <?php echo form_radio('status', '1', '0', 'id="status"'); ?>Active
                        </label>
                        <label class="radio-inline">
                            <?php echo form_radio('status', '0', '0', 'id="status"'); ?>Inactive
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

    function checkCount(elm) {
        var checkboxes = document.getElementsByClassName("checkbox-btn");
        var selected = [];
        for (var i = 0; i < checkboxes.length; ++i) {
            if (checkboxes[i].checked) {
                selected.push(checkboxes[i].value);
            }
        }
        document.getElementById("stoppage_points").value = selected.join();
        //document.getElementById("total").innerHTML = selected.length;
    }

    function showDiv() {
        document.getElementById('stopagediv').style.display = "block";
        document.getElementById("stoppage_points").placeholder = "Check Stoppage Points From Below";
        document.getElementById('stopagediv2').style.display = "none";
    }
</script>


<script type="text/javascript">
    $(".startend").change(function () {

// document.getElementById('stopagediv2').style.display = "none";
        //set variables
        var start = $("#start").val();
        var end = $("#end").val();
        // var stopagediv  = $("#stopagediv");

        $.ajax({
            url: '<?php echo base_url('trip/route/startendpoints') ?>',
            method: 'post',
            dataType: 'json',
            data: {
                '<?php echo $this->security->get_csrf_token_name() ?>': '<?php echo $this->security->get_csrf_hash() ?>',
                'start_point': start,
                'end_point': end
            },
            success: function (data) {
                // stopagediv.html(data);
                $('#stoppage_points').html(data);
            },
            error: function (xhr) {
                alert('failed!');
            }
        });


    });
</script> 