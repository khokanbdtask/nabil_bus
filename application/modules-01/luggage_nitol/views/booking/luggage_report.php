<div class="row">
    <div class="col-sm-12 col-md-12">

        <div class=" panel">


                <?php echo form_open(base_url('luggage_nitol/luggage_report/filter')); ?>
            <div class="row" style="padding: 10px; width: 100%;">
                <div class="col-xs-6 col-sm-3">
                    <label>Date From</label>

                    <?php echo form_input('datefrom', date("01-m-Y"), 'class="form-control datepicker"  placeholder="Date From" id="datefrom" type="text" required="required" '); ?>

                </div>
                <div class="col-xs-6 col-sm-3">
                    <label>Date To</label>

                    <?php echo form_input('dateto', date("d-m-Y"), 'class="form-control datepicker"  placeholder="Date To" id="dateto" type="text"  required="required" '); ?>

                </div>
                <div class="col-xs-12 col-sm-3">
                    <label>Fleet Type</label>
                    <?php echo form_dropdown('ftypes', $tps, '', 'id="ftypes" class=" form-control"') ?>

                </div>

                <div class="col-xs-12 col-sm-3">
                    <label>Route</label>
                    <?php echo form_dropdown('route_id', $route_dropdown, '', 'id="route_id" class=" form-control"') ?>

                </div>

            </div>
            <div class="row" style="padding: 10px; width: 100%;">
                <div class="col-xs-6 col-sm-3">
                    <label>Payment Type</label>
                    <?php echo form_dropdown('payment_status', ['NULL'=>'Paid','1'=>'Unpaid Cash'], 'paid', 'id="payment_status" class=" form-control"') ?>

                </div>


                <div class="col-xs-12 col-sm-3">
                    <br>
                    <?php echo form_submit('mysubmit', 'Filter', 'class="btn btn-primary" style="margin-top:5px;"'); ?>
                </div>
            </div>

            <?php echo form_close(); ?>
        </div>


        <div class="panel ">
            <div class="panel-heading">
                <div class="panel-title">
                    <h4>Luggage Report</h4>
                </div>
            </div>
            <div class="panel-body">

                <div class="">

                    <table class="datatable_luggage table table-bordered">
                        <caption class="text-center">
                         <h3>Luggage Report</h3>
                         <h4><?php if(isset($datefrom) && isset($dateto)){ echo date("d/F/Y",strtotime($datefrom))." - ".date("d/F/Y",strtotime($dateto)); } ?></h4>
                        </caption>
                        <thead>
                        <tr>
                            <th><?php echo display('sl_no') ?></th>
                            <th><?php echo display('created_date') ?></th>
                            <th><?php echo display('booking_date') ?></th>
                            <th><?php echo display('booking_id') ?></th>
                            <th><?php echo display('name') ?></th>
                            <th><?php echo display('route_name') ?></th>
                            <th><?php echo display('package'); ?></th>
                            <th class="p"><?php echo  display('discount'); ?></th>
                            <th class="p"><?php echo  "Amount"; ?></th>
                            <th><?php echo display('payment_type') ?></th>
                            <th><?php echo display('payment_status') ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($filters)){ ?>
                        <?php $sl = 1; ?>
                        <?php
                        $c = count($filters);

                        foreach ($filters as $filter) {
                            if($filter->luggage_refund_id == null && $filter->delete_status == 0 ){
                            ?>

                            <tr class="">
                                <td><?php echo $filter->id; ?></td>
                                <td><?php echo $filter->create_date; ?></td>
                                <td><?php echo $filter->booking_date; ?></td>
                                <td><?php echo $filter->id_no; ?></td>
                                <td><?php $result = $this->db->select('firstname,lastname')->from('tkt_passenger')->where('id_no', $filter->luggage_passenger_id_no)->get()->result();
                                    foreach ($result as $name) {
                                        echo $name->firstname . ' ' . $name->lastname;
                                    }
                                    ?></td>
                                <td><?php echo $filter->route_name; ?></td>
                                <td><?php echo $filter->package_name; ?></td>
                                <td class="amount" align="right"><?php echo $filter->discount; ?></td>
                                <td class="amount" align="right"><?php echo $filter->amount; ?></td>
                                <td><?php echo $filter->booking_type; ?></td>
                                <td>
                                    <?php
                                    if ($filter->payment_status == 1 or $filter->payment_status == 2) {
                                        if ($this->session->userdata('isAdmin') == 1) {
                                            echo 'Unpaid';
                                        } else {
                                            echo '';
                                        }
                                    } elseif ($filter->payment_status == 'Refunded') {
                                        echo "Refunded";
                                    }else {
                                        echo "Paid";
                                    }
                                    ?>
                                </td>

                            </tr>
                            <?php
                        }
                        }}
                        ?>
                        </tbody>
                        <tfoot>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>Total</td>
                            <td class="totalprice" align="right"></td>
                            <td class="totalprice" align="right"></td>
                            <td></td>
                            <td></td>
                        </tr>
                        </tfoot>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {


        $('.w').each(function (i) {
            weight(i);
        });

        $('.p').each(function (j) {
            price(j);
        });

    });
    var totalweight = 0;
    var totalprice = 0;

    function price(index) {

        $('table tr').each(function () {
            var amount = parseFloat($('.amount', this).eq(index).text());

            // alert(amount);
            if (!isNaN(amount)) {
                totalprice += amount;
            }
        });
        $('.totalprice').eq(index).text(totalprice.toFixed(2));
    }

    // function weight(lol) {

    //     $('table tr').each(function () {
    //         var weight = parseInt($('.weight', this).eq(lol).text());
    //         // alert(weight);
    //         if (!isNaN(weight)) {
    //             totalweight += weight;
    //         }

    //     });

    //     $('.totalweight').eq(lol).text(totalweight);
    // }


</script>