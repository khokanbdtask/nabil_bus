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
                     <!-- New code 2021 direct update  -->
                    <?php echo form_dropdown('payment_status', [''=>'select option','NULL'=>'Paid','1'=>'Unpaid Cash','partial'=>'Partial Paid'], 'paid', 'id="payment_status" class=" form-control"') ?>
                        <!-- New code 2021 direct update  -->
                </div>


                <div class="col-xs-12 col-sm-3">
                    <label>Agent List</label>
                    <?php echo form_dropdown('agent_id', $agent_list, '', 'id="route_id" class=" form-control"') ?>

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

                    <table class="luggagereport table table-bordered">
                        <caption class="text-center">
                         <h3>Luggage Report</h3>
                         <h4><?php if(isset($datefrom) && isset($dateto)){ echo date("d/F/Y",strtotime($datefrom))." - ".date("d/F/Y",strtotime($dateto)); } ?></h4>
                        </caption>
                        <thead>
                        <tr>
                            <th><?php echo display('sl_no') ?></th>
                            <!-- <th><?php echo display('created_date') ?></th> -->
                            <th><?php echo display('booking_date') ?></th>
                            <th>Created by</th>
                            <th><?php echo display('booking_id') ?></th>
                            <th><?php echo display('name') ?></th>
                            <th><?php echo display('route_name') ?></th>
                            <th class="p">Price</th>
                            <th class="extra">Extra fee</th>
                            <th class="marketval">Market Value</th>
                            <th class="insurancefee">Insurance Fee</th>
                            <th class="wrappingfee">Wrapping Fee</th>
                            <th class="d"><?php echo  display('discount'); ?></th>
                            <th class="a"><?php echo  "Amount"; ?></th>
                            <th>Cleared by</th>
                            <th>Cleared Date & Time</th>
                            <!-- <th><?php echo display('payment_type') ?></th> -->
                            <th>Due</th>
                            <th><?php echo display('payment_status') ?></th>
                            <!-- <th class="c">Commision</th> -->
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
                                <!-- <td><?php echo $filter->create_date; ?></td> -->
                                <td><?php echo $filter->booking_date; ?></td>
                                <td><?php echo $filter->booking_type; ?></td>
                                <td><?php echo $filter->id_no; ?></td>
                                <td><?php $result = $this->db->select('firstname,lastname')->from('tkt_passenger')->where('id_no', $filter->luggage_passenger_id_no)->get()->result();
                                    foreach ($result as $name) {
                                        echo $name->firstname . ' ' . $name->lastname;
                                    }
                                    ?></td>
                                <td><?php echo $filter->route_name; ?></td>
                                <td class="actualprice" align="right"><?php echo $filter->price; ?></td>
                                <td class="extrafee" align="right"><?php echo $filter->extra_fee; ?></td>
                                <td class="marketvalue" align="right"><?php echo $filter->market_value; ?></td>
                                <td class="insurancefeevalue" align="right"><?php echo $filter->insurance_fee; ?></td>
                                <td class="wrappingfeevalue" align="right"><?php echo $filter->wrapping_fee; ?></td>
                                <td class="disamount" align="right"><?php echo $filter->discount; ?></td>
                                <td class="amount" align="right"><?php echo $filter->amount; ?></td>
                                <td>
                                <?php $result = $this->db->select('firstname,lastname')->from('user')->where('id', $filter->deleverby)->get()->result();
                                    foreach ($result as $name) {
                                        echo $name->firstname . ' ' . $name->lastname;
                                    }
                                    ?>
                                    
                                </td>
                                <td><?php echo $filter->deleverytime; ?></td>

                                <td>

                                    <?php
                                        if ($filter->payment_status == 'partial')
                                        {echo (int)$filter->amount - (int)$filter->partialpay;
                                            $result = $this->db->select('*')->from('luggage_partial_payment')->where('luggage_booking_id', $filter->id_no)->get()->result();
                                            foreach ($result as $name) {
                                                echo (int)$name->payment_amount - (int)$name->amount_paid;
                                            }
                                        }
                                        else
                                        {
                                            echo "0";
                                        }
                                    ?>
                                
                                </td>

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
                                    }
                                    //  New code 2021 direct update  
                                    elseif ($filter->payment_status == 'partial') {
                                        echo "Partial Paid";
                                    }
                                     //  New code 2021 direct update  
                                    else {
                                        echo "Paid";
                                    }
                                    ?>
                                </td>
                                <!-- <td class="commissionamount">
                                <?php
                                        $getemail = "";
                                        $type = "";
                                        $result = $this->db->select('*')->from('user')->where('id', $filter->booked_by)->get()->result();
                                        foreach ($result as $name) {
                                             $getemail =  $name->email;
                                             $type =  $name->is_admin;
                                        }
                                       
                                        if ($type == 1)
                                        {
                                           
                                        }
                                        elseif($type == 0)
                                        {
                                            $commission = "";
                                            $commision = $this->db->select('*')->from('agent_info')->where('agent_email', $getemail)->get()->result();
                                            foreach ($commision as $com) {
                                                $commission = $com->agent_commission ;
                                            }

                                            if($filter->payment_status == 'partial')
                                            {
                                                echo  ((int)$filter->amount *(int)$commission)/100 ;
                                            }

                                            if($filter->payment_status == 'NULL')
                                            {
                                                $result = $this->db->select('*')->from('luggage_partial_payment')->where('luggage_booking_id', $filter->id_no)->get()->result();
                                                foreach ($result as $name) {
                                                echo  ((int)$name->amount_paid *(int)$commission)/100 ;
                                            }
                                            }
                                            
                                        }
                                    ?>

                                </td> -->

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
                            <td class="totalextrafee" align="right"></td>
                            <td class="totalmarketvalue" align="right"></td>
                            <td class="totalinsurancevalue" align="right"></td>
                            <td class="totalwrappingvalue" align="right"></td>
                            <td class="discount" align="right"></td>
                            <td class="totalamount" align="right"></td>
                            <td ></td>
                            <td ></td>
                            <td ></td>
                            <td></td>
                            <!-- <td class="commisionshow" align="right"></td> -->
                            
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


        $('.extra').each(function (i) {
            extrafee(i);
        });

        $('.marketval').each(function (a) {
            market(a);
        });

        $('.insurancefee').each(function (b) {
            insurance(b);
        });

        $('.wrappingfee').each(function (r) {
            wrapping(r);
        });

        $('.a').each(function (j) {
            amount(j);
        });

        $('.d').each(function (d) {
            discount(d);
        });

        $('.p').each(function (k) {
            price(k);
        });

    });
    var totalweight = 0;
    var totalprice = 0;
    var totalextrafee = 0;
    var totalmarketvalue = 0;
    var totalinsurancevalue = 0;
    var totalwrappingfeevalue = 0;
    var totalamount = 0;
    var commission = 0;
    var discountprice = 0;

    function amount(index) {

        $('table tr').each(function () {
            var amount = parseFloat($('.amount', this).eq(index).text());

            // alert(amount);
            if (!isNaN(amount)) {
                totalamount += amount;
            }
        });
        $('.totalamount').eq(index).text(totalamount.toFixed(2));
  
    }


    function price(index) {

        $('table tr').each(function () {
            var price = parseFloat($('.actualprice', this).eq(index).text());

            if (!isNaN(price)) {
                totalprice += price;
            }
        });
        $('.totalprice').eq(index).text(totalprice.toFixed(2));

        }

        function extrafee(index) {

        $('table tr').each(function () {
            var extrafee = parseFloat($('.extrafee', this).eq(index).text());
            if (!isNaN(extrafee)) {
                totalextrafee += extrafee;
            }
        });
        $('.totalextrafee').eq(index).text(totalextrafee.toFixed(2));

        }



        function market(index) {

            $('table tr').each(function () {
                var market = parseFloat($('.marketvalue', this).eq(index).text());
                if (!isNaN(market)) {
                    totalmarketvalue += market;
                }
            });
            $('.totalmarketvalue').eq(index).text(totalmarketvalue.toFixed(2));

            }



        function insurance(index) {

            $('table tr').each(function () {
                var insurance = parseFloat($('.insurancefeevalue', this).eq(index).text());
                if (!isNaN(insurance)) {
                    totalinsurancevalue += insurance;
                }
            });
            $('.totalinsurancevalue').eq(index).text(totalinsurancevalue.toFixed(2));

            }


        function wrapping(index) {

            $('table tr').each(function () {
                var wrapping = parseFloat($('.wrappingfeevalue', this).eq(index).text());
                if (!isNaN(wrapping)) {
                    totalwrappingfeevalue += wrapping;
                }
            });
            $('.totalwrappingvalue').eq(index).text(totalwrappingfeevalue.toFixed(2));

            }



    function discount(index) {

        $('table tr').each(function () {
            var discontamount = parseFloat($('.disamount', this).eq(index).text());

            // alert(amount);
            if (!isNaN(discontamount)) {
                discountprice += discontamount;
            }
        });
        $('.discount').eq(index).text(discountprice.toFixed(2));

}

    // New code 2021 direct update 
    // function commis(index)
    // {

    //     $('table tr').each(function () {
    //         var qyaniybtamount = parseFloat($('.commissionamount', this).eq(index).text());

    //         // alert(amount);
    //         if (!isNaN(qyaniybtamount)) {
    //             commission += qyaniybtamount;
    //         }
    //     });
    //     $('.commisionshow').eq(index).text(commission.toFixed(2));

    // }
    // New code 2021 direct update 

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


    $( document ).ready(function() {
        var logo = "<?php echo $logo->text_logo ?>"; 
        $('.luggagereport').DataTable({
        responsive: true,
        paging: true,
        dom: "<'row'<'col-sm-8'lB><'col-sm-4'f>>tp",
        "lengthMenu": [[25, 50, 100, 150, 200, 500, -1], [25, 50, 100, 150, 200, 500, "All"]],
        buttons: [
            {extend: 'copy', className: 'btn-sm'},
            {extend: 'csv', title: logo , className: 'btn-sm'},
            {extend: 'excel', title: logo , className: 'btn-sm'},
            {extend: 'pdf', title: logo , className: 'btn-sm'},
            {extend: 'print',title: logo , className: 'btn-sm'}
        ]
    });
    });

</script>