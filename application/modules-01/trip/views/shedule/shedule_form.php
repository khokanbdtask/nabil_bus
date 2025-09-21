<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="panel">
            <div class="panel-body">
                <?= form_open('trip/shedule/add_shedule', array('name' => 'myForm')) ?>


                <div class="form-group row">
                    <label for="start" class="col-sm-4 col-form-label">
                        <?php echo 'Start'; ?> *</label>
                    <div class="col-sm-8">
                        <input type="text" name="start" id="start" placeholder="Start Time"
                               class="form-control timepicker" value="<?php
                        echo (isset($sheduledata->start)) ? $sheduledata->start : ''; ?>">
                        <input type="hidden" name="shedule_id" value="<?php
                        echo (isset($sheduledata->shedule_id)) ? $sheduledata->shedule_id : ''; ?>">

                    </div>

                </div>

                <div class="form-group row">
                    <label for="end" class="col-sm-4 col-form-label">
                        <?php echo 'End'; ?> *</label>
                    <div class="col-sm-8">
                        <input type="text" name="end" id="end" placeholder="End Time" class="form-control timepicker"
                               value="<?php
                               echo (isset($sheduledata->end)) ? $sheduledata->end : ''; ?>">

                    </div>

                </div>
                <div class="form-group row">
                    <label for="duration" class="col-sm-4 col-form-label">
                        <?php echo 'Duration'; ?> *</label>
                    <div class="col-sm-8">
                        <input type="text" name="duration" id="duration" placeholder="Duration" class="form-control"
                               value="<?php
                               echo (isset($sheduledata->duration)) ? $sheduledata->duration : ''; ?>">
                    </div>

                </div>
                <div class="form-group text-right">
                    <button type="reset" class="btn btn-primary w-md m-b-5">
                        <?php echo display('reset') ?>
                    </button>
                    <button type="submit" class="btn btn-success w-md m-b-5">
                        <?php echo display('add') ?>
                    </button>
                </div>
                <?php echo form_close() ?>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">

    function durationss() {
        var start = $('#start').val();
        var end = $('#end').val();
        // alert(start);
        document.getElementById("duration").value = start;


    }


    $(document).ready(function (e) {
        function calculation() {
            var valuestart = $("#start").val();
            var valuestop = $("#end").val();
            //$('#duration').val(hourDiff);

            var start = valuestart.split(':');
// alert(start.split(':'));
            var end = valuestop.split(':');
// alert(end.split(':'));
            var diff = Array();
// var diff = start.split(':').map((item,index) => end.split(':')[index] - item);
// alert(diff[0]);


            if ((end[0] - start[0]) < 0 && (end[1] - start[1]) < 0) {
                diff[0] = ((23 - parseInt(start[0])) + parseInt(end[0]));
            } else if ((end[0] - start[0]) < 0 && (end[1] - start[1]) >= 0) {
                diff[0] = ((24 - parseInt(start[0])) + parseInt(end[0]));
            } else {
                diff[0] = end[0] - start[0];
            }

            if ((end[1] - start[1]) < 0 && (end[2] - start[2]) < 0) {
                diff[1] = ((59 - parseInt(start[1])) + parseInt(end[1]));
            } else if ((end[1] - start[1]) >= 0 && (end[2] - start[2]) < 0) {
                diff[1] = end[1] - start[1] - 1;
            } else if ((end[1] - start[1]) < 0 && (end[2] - start[2]) >= 0) {
                diff[1] = ((60 - parseInt(start[1])) + parseInt(end[1]));
            } else {
                diff[1] = end[1] - start[1];
            }

            if ((end[2] - start[2]) < 0) {
                diff[2] = ((60 - parseInt(start[2])) + parseInt(end[2]));
            } else {
                diff[2] = end[2] - start[2];
            }

            // alert(diff);


            $('#duration').val(diff.join(':'));

        }

        $('#sart,#end').change(calculation)


    });

</script>