<div class="row">
<!-- Quick Link -->
    <div class="col-sm-3">
        <div class="row">


         <?php if ($this->permission->method('ticket', 'create')->access()): ?>
            <div class="col-sm-12">
                <div class="panel panel-bd">
                    <div class="panel-body">

                        <a href="<?php echo base_url('ticket/booking/form') ?>" class="statistic-box text-center">
                            <div><i class="fa fa-ticket fa-4x text-success"></i></div>
                            <h4><?php echo display('booking') ?></h4>
                        </a>
                    </div>
                </div>
            </div>
           <?php endif;?>




           <?php if ($this->permission->method('reports', 'read')->access()): ?>
            <div class="col-sm-12">
                <div class="panel panel-bd">
                    <div class="panel-body">
                        <a href="<?php echo base_url('reports/booking/report') ?>" class="statistic-box text-center">
                            <div><i class="fa fa-pie-chart fa-4x text-success"></i></div>
                            <h4><?php echo display('reports') ?></h4>
                        </a>
                    </div>
                </div>
            </div>
<?php endif;?>

 <?php if ($this->permission->method('account', 'create')->access()): ?>
            <div class="col-sm-12">
                <div class="panel panel-bd">
                    <div class="panel-body">
                        <a href="<?php echo base_url('account/account_controller/create_transaction') ?>" class="statistic-box text-center">
                            <div><i class="fa fa-money fa-4x text-success"></i></div>
                            <h4><?php echo display('account_transaction') ?></h4>
                        </a>
                    </div>
                </div>
            </div>
<?php endif;?>
        </div>
    </div>


    <!-- Yearly Chart -->
    <div class="col-sm-9">
        <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
                <div class="panel-title">
                    <h4><?php echo display('yearly_progressbar') ?></h4>
                </div>
            </div>
            <div class="panel-body">
                <canvas id="lineChart"></canvas>
            </div>
        </div>
    </div>


    <!-- New code 2021 direct update  -->

    <div class="col-sm-6" id="income">
        <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
                <div class="panel-title">
                    <!-- <h4><?php echo display('yearly_progressbar') ?></h4> -->
                    <h4 class="" id="chartHeading">Yearly Progress bar</h4>
                    <div class="mt-2 mb-2">

                        <select class="form-control text-right" id="incomeexpence">
                        <option value="YEAR">YEAR</option>
                        <option value="MONTH">MONTH</option>
                        <option value="WEEK">WEEK</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <canvas id="incomeExpancelineChart" ></canvas>
            </div>
        </div>
    </div>



    <div class="col-sm-6" id="ticket">
        <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
                <div class="panel-title">
                    <!-- <h4><?php echo display('yearly_progressbar') ?></h4> -->
                    <h4 class="" id="ticketluggageheader">Yearly Progress bar</h4>
                    <div class="mt-2 mb-2">

                        <select class="form-control text-right" id="ticketluggage">
                        <option value="YEAR">YEAR</option>
                        <option value="MONTH">MONTH</option>
                        <option value="WEEK">WEEK</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <canvas id="ticlaugglineChart" ></canvas>
            </div>
        </div>
    </div>

   
  
  
    <div class="d-none col-sm-12" id="agent">
        <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
                <div class="panel-title">
                   
                    <h4 class="" id="agentreporthead"> Progress bar</h4>
                   
                </div>
            </div>
            
            <div class="panel-body">
                <canvas id="agentchart" ></canvas>
            </div>
            
        </div>
    </div>
     

<!-- New code 2021 direct update  -->
                        <!-- <?php if ($this->session->userdata('isAdmin') == 1): ?> -->
                                <!-- <?php endif; ?> -->

</div>


<?php if ($this->session->userdata('isAdmin') == 1) {?>
 <div class="row">
    <!-- Assign List -->
    <div class="col-sm-8">
        <div class="panel panel-bd">
            <div class="panel-heading">
                <div class="panel-title">
                    <h4><?php echo display('todays_trip') ?></h4>
                </div>
            </div>
            <div class="panel-body">

                <!-- New code 2021 -->
                <?php $weekDayValue = 0;?>

                <?php

    $weekdays = array("7" => "Saturday", "1" => "Sunday", "2" => "Monday", "3" => "Tuesday", "4" => "Wednesday", "5" => "Thursday", "6" => "Friday");

    foreach ($weekdays as $x => $days) {

        if (date("l") == $days) {
            $weekDayValue = $x;

        }

    }
    ?>
                <!-- New code 2021 -->

                 <table class="datatable2 table table-bordered">
                    <thead>
                        <tr>
                            <th><?php echo display('sl_no') ?></th>
                            <th><?php echo display('trip_id') ?></th>
                            <th><?php echo display('reg_no') ?></th>
                            <th><?php echo display('route_name') ?></th>
                            <th><?php echo display('time') ?></th>
                            <th><?php echo display('driver_name') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($assigns)) {
        ;
    }
    ?>
                        <?php $sl = 1;?>
                        <?php foreach ($assigns as $assign) {?>
                <!-- New code 2021 -->
                            <?php $weekValue = 0;?>

                            <?php $offdayValue = explode(",", $assign->weekend)?>

                            <?php foreach ($offdayValue as $values): ?>

                                <?php if ($values == $weekDayValue): ?>

                                    <?php $weekValue += 1;?>
                                <?php endif;?>

                            <?php endforeach;?>

                            <?php if ($weekValue == 0): ?>
                                 <!-- New code 2021 -->
                        <tr>

                            <td><?php echo $sl++; ?></td>
                            <td>
                                <a href="<?php echo base_url("trip/assign/view/$assign->id_no") ?>"><?php echo $assign->id_no; ?></a>
                            </td>
                            <td><?php echo $assign->fleet_registration_name; ?></td>
                            <td><?php echo $assign->name; ?></td>
                            <td><?php echo $assign->start . '-' . $assign->end; ?></td>
                            <td>
                            <!-- New code 2021 direct update  -->
                            <?php $dname = $this->db->select("employee_history.id, CONCAT_WS(' ',first_name, second_name) AS name")
                                                 ->from("employee_history")
                                                 ->join('dynamic_assign', 'dynamic_assign.employeeid = employee_history.id')
                                                ->where('dynamic_assign.employeetype','Driver')
                                                ->where('dynamic_assign.randomid',$assign->id_no)
                                                ->get()
                                                ->result();
                                
                                 ?>
                                    <?php echo $assign->driver_name; ?>
                                    <?php foreach ($dname as $value):?>
                                        <?php if ($value->name != $assign->driver_name): ?>
                                            , <?php echo $value->name; ?>
                                            <?php endif; ?>
                                       
                                    <?php endforeach;?>
                                <!-- New code 2021 direct update  -->
                            </td>



                        </tr>
                         <!-- New code 2021 -->
                        <?php endif;?>
                         <!-- New code 2021 -->
                        <?php }?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <!-- Enquiry -->
    <div class="col-sm-4">
        <div class="panel panel-bd lobidisable">
            <div class="panel-heading">
                <div class="panel-title">
                    <h4><?php echo display('enquiry') ?></h4>
                </div>
            </div>
            <div class="panel-body">
                <table width="100%" class=" table table-striped">
                    <thead>
                        <tr>
                            <th><?php echo display('name') ?></th>
                            <th><?php echo display('date') ?></th>
                            <th><?php echo display('action') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($enquirys)) {?>
                            <?php foreach ($enquirys as $enquiry) {?>
                                <tr>
                                    <td><?php echo $enquiry->name; ?></td>
                                    <td><?php echo $enquiry->created_date; ?></td>
                                    <td class="center">
                                        <a href="<?php echo base_url("enquiry/home/view/$enquiry->enquiry_id") ?>" class="btn btn-xs btn-success"><i class="fa fa-eye"></i></a>
                                    </td>
                                </tr>
                            <?php }?>
                        <?php }?>
                    </tbody>
                </table>  <!-- /.table-responsive -->
            </div>
        </div>
    </div>
</div>
<?php }?>

<div class="row">
    <div class="col-sm-6">
       
    
        <div class="panel panel-bd lobidisable">
            <div class="panel-heading">
                <div class="panel-title">
                    <h4>Due Ticket</h4>
                </div>
            </div>
            <div class="panel-body">
                <table width="100%" class="dueticketluggage table table-bordered">
                    <thead>
                        <tr>
                            <th>Booking ID</th>
                            <th>Journey Day</th>
                            <th>Route Name</th>
                            <th>Passenger Name</th>
                            <th>Due</th>
                        </tr>
                    </thead>
                    <tbody>

                    <?php foreach ($duebookings as $booking):?>

                        <tr>
                            <td>
                            <a target="_blank" href="<?php echo base_url("ticket/booking/view/$booking->id_no") ?>" class="btn btn-success btn-xs" data-toggle="tooltip" data-placement="left" title="View"><?php echo $booking->id_no; ?></a>
                                
                            </td>
                            <td><?php echo $booking->booking_date;  ?></td>
                            <td><?php echo $booking->route_name; ?></td>
                            <td><?php $result=$this->db->select('firstname,lastname')->from('tkt_passenger')->where('id_no',$booking->tkt_passenger_id_no)->get()->result();
                                 foreach ($result as $name) {
                                    echo $name->firstname.' '.$name->lastname;
                                 }
                                 ?>
                            </td>

                            <td>
                                 <?php echo (int) $booking->amount - (int) $booking->partialpay?>
                            </td>

                        </tr>

                    <?php endforeach;?>
                    
                
                    </tbody>
                </table>  <!-- /.table-responsive -->
            </div>
        </div>
    
                                

    </div>





    <div class="col-sm-6">
       
    
        <div class="panel panel-bd lobidisable">
            <div class="panel-heading">
                <div class="panel-title">
                    <h4>Due Luggage</h4>
                </div>
            </div>
            <div class="panel-body">
                <table width="100%" class="dueticketluggage table table-bordered">
                    <thead>
                        <tr>
                            <th>Booking ID</th>
                            <th>Journey Day</th>
                            <th>Route Name</th>
                            <th>Passenger Name</th>
                            <th>Due</th>
                        </tr>
                    </thead>
                    <tbody>

                    <?php foreach ($dueluggage as $duebooking):?>

                        <tr>
                            <td>
                            <a target="_blank" href="<?php echo base_url("luggage_nitol/luggage/view/$duebooking->id_no") ?>" class="btn btn-success btn-xs" data-toggle="tooltip" data-placement="left" title="View"><?php echo $duebooking->id_no; ?></a>
                                
                            </td>
                            <td><?php echo $duebooking->booking_date;  ?></td>
                            <td><?php echo $duebooking->route_name; ?></td>
                            <td><?php $result = $this->db->select('firstname,lastname')->from('tkt_passenger')->where('id_no', $duebooking->luggage_passenger_id_no)->get()->result();
                                    foreach ($result as $name) {
                                        echo $name->firstname . ' ' . $name->lastname;
                                    }
                            ?></td>

                            <td>
                                 <?php echo (int) $duebooking->amount - (int) $duebooking->partialpay?>
                            </td>

                        </tr>

                    <?php endforeach;?>
                    
                
                    </tbody>
                </table>  <!-- /.table-responsive -->
            </div>
        </div>
    
                                

    </div>
</div>


<!-- Chart js -->
<script src="<?php echo base_url('assets/js/Chart.min.js') ?>" type="text/javascript"></script>

<script type="text/javascript">
$(document).ready(function(){
    //line chart
    var value = "<?php echo $this->session->userdata('isAdmin') ?>"
    if(value == false)
    { 
       
        $('#income').hide();  
        $('#ticket').hide();  
        $('#agent').hide();  
    
    }
    var incomeChart;
    var myChart;
    var ctx = document.getElementById("lineChart");
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: [<?php
for ($i = 1; $i <= 12; $i++) {
    if ($i == 1) {
        echo '"January",';
    } elseif ($i == 2) {
        echo '"February",';
    } elseif ($i == 3) {
        echo '"March",';
    } elseif ($i == 4) {
        echo '"April",';
    } elseif ($i == 5) {
        echo '"May",';
    } elseif ($i == 6) {
        echo '"June",';
    } elseif ($i == 7) {
        echo '"July",';
    } elseif ($i == 8) {
        echo '"August",';
    } elseif ($i == 9) {
        echo '"September",';
    } elseif ($i == 10) {
        echo '"October",';
    } elseif ($i == 11) {
        echo '"November",';
    } elseif ($i == 12) {
        echo '"December"';
    }
}
?>],
            datasets: [
                {
                    label: "Assign",
                    borderColor: "rgba(0,0,0,.09)",
                    borderWidth: "1",
                    //backgroundColor: "rgba(0,0,0,.07)",
                    data: [<?php
for ($i = 1; $i <= 12; $i++) {
    $assigninfo = $this->home_model->monthlyassign($i);
    if (!empty($assigninfo)) {

        echo $assigninfo->total_assign . ",";
    } else {
        echo ",";
    }
}
?>]

                },
                {
                    label: "Booking",
                    borderColor: "rgba(55, 160, 0, 0.9)",
                    borderWidth: "1",
                    //backgroundColor: "rgba(55, 160, 0, 0.5)",
                    pointHighlightStroke: "rgba(26,179,148,1)",
                    data: [<?php
for ($i = 1; $i <= 12; $i++) {
    $bookinginfo = $this->home_model->monthlybooking($i);
    if (!empty($bookinginfo)) {

        echo $bookinginfo->total_booking . ",";
    } else {
        echo ",";
    }
}
?>]
                }
            ]
        },
        options: {
            responsive: true,
            tooltips: {
                mode: 'index',
                intersect: false
            },
            hover: {
                mode: 'nearest',
                intersect: true
            },



        }
    });













    
   

     // New code 2021 direct update


         //income expense year chart default display

     var getdata = '<?php echo ($chartyear); ?>';

                        var getdatafromJson = jQuery.parseJSON(getdata);
                        lavel = getdatafromJson['year'];
                        Income = getdatafromJson['income'];
                        Expense = getdatafromJson['expense'];

                        $("#chartHeading").html("Yearly Progress bar");
                       
     var ctx = document.getElementById('incomeExpancelineChart').getContext('2d');

     
                var incomemyChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: lavel,
                    datasets: [

                        {
                        label: '# INCOME',
                        data: Income ,
                        backgroundColor: 'rgba(0, 0, 255)',

                        
                        borderColor: 'rgba(0, 0, 255)',

                        
                        borderWidth: 1
                    },

                    {
                        label: '# EXPENCE',
                        data: Expense,
                        backgroundColor: 'rgba(255, 255, 0)',

                        
                        borderColor: 'rgba(255, 255, 0)',

                        borderWidth: 1
                    },



                ]

                },
                options: {
                    events:[],
                    title: {
                                display: true,
                                text: 'Income & Expense Chart'
                            },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },


                }
            });

           

      //income expense year chart default display





            //drop down income expense chart  

            $( "#incomeexpence" ).change(function() {
                
            
                
                 var graphtype = $('#incomeexpence').val();
                

                if(graphtype == "WEEK")
                    {
                        var getdata = '<?php echo ($chartweek); ?>';
                        var getdatafromJson = jQuery.parseJSON(getdata);

                        $("#chartHeading").html("Weekly Progress bar");

                        lavel = [ 'Sunday', 'Monday', 'Tuesday', 'wednesday', 'Thursday','Friday','Saturday'];
                        Income = getdatafromJson['income'];
                        Expense = getdatafromJson['expense'];
                    }
                    if(graphtype == "MONTH")
                    {
                        var getdata = '<?php echo ($chartmonth); ?>';
                        var getdatafromJson = jQuery.parseJSON(getdata);

                        $("#chartHeading").html("Monthly Progress bar");

                        lavel = ['January', 'February', 'March', 'April', 'May', 'June','July','August','September','October','November','December'];
                        Income = getdatafromJson['income'];
                        Expense = getdatafromJson['expense'];

                    }

                     if(graphtype == "YEAR")
                    {
                        var getdata = '<?php echo ($chartyear); ?>';
                        var getdatafromJson = jQuery.parseJSON(getdata);
                        lavel = getdatafromJson['year'];
                        Income = getdatafromJson['income'];
                        Expense = getdatafromJson['expense'];

                        $("#chartHeading").html("Yearly Progress bar");
                    }

                   
                       
                   
               
                   
               

                var ctx = document.getElementById('incomeExpancelineChart').getContext('2d');
                    
                

                incomeChart  = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: lavel,
                    datasets: [

                        {
                        label: '# INCOME',
                        data: Income,
                        backgroundColor: 'rgba(0, 0, 255)',

                        borderColor: 'rgba(0, 0, 255)',

                        borderWidth: 1
                    },

                    {
                        label: '# EXPENCE',
                        data: Expense,
                        backgroundColor:  'rgba(255, 255, 0)',

                        borderColor: 'rgba(255, 255, 0)',

                        borderWidth: 1
                    },



                ]

                },
                options: {
                    
                    events:[],
                    title: {
                                display: true,
                                text: 'Income & Expense Chart'
                            },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },
                    
                  
            

                },
               

               
                    });
                   
                   
                });



                 //drop down income expense chart 


                //Ticket Luggage  year chart default display

                var getdata = '<?php echo ($ticketluggage); ?>';
                        var getdatafromJson = jQuery.parseJSON(getdata);
                        lavel = getdatafromJson['year'];
                        Income = getdatafromJson['ticket'];

                        Expense = getdatafromJson['luggage'];

                        $("#ticketluggHeading").html("Yearly Progress bar");

     var ctx = document.getElementById('ticlaugglineChart').getContext('2d');
                

                var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: lavel,
                    datasets: [

                        {
                        label: '# TICKET',
                        data: Income ,
                        backgroundColor: [
                            'rgb(0, 255, 255)',

                        ],
                        borderColor: [
                            'rgb(0, 255, 255)',

                        ],
                        borderWidth: 1
                    },

                    {
                        label: '# LUGGAGE',
                        data: Expense,
                        backgroundColor: [
                            'rgb(102, 0, 204)',

                        ],
                        borderColor: [
                            'rgb(102, 0, 204)',

                        ],
                        borderWidth: 1
                    },



                ]

                },
                options: {
                    title: {
                                display: true,
                                text: 'Ticket & Luggage Booking Chart'
                            },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },


                }
            });



            //Ticket Luggage  year chart default display




                //drop down Ticket Luggage  chart  

            $( "#ticketluggage" ).change(function() {
                var graphtype = $('#ticketluggage').val();
                

                if(graphtype == "WEEK")
                    {
                        var getdata = '<?php echo ($ticketluggageweek); ?>';
                        var getdatafromJson = jQuery.parseJSON(getdata);

                        $("#ticketluggageheader").html("Weekly Progress bar");

                        lavel = [ 'Sunday', 'Monday', 'Tuesday', 'wednesday', 'Thursday','Friday','Saturday'];
                        Income = getdatafromJson['ticket'];
                        Expense = getdatafromJson['luggage'];
                    }
                    if(graphtype == "MONTH")
                    {
                        
                        var getdata = '<?php echo ($ticketluggagemonth); ?>';
                       
                        var getdatafromJson = jQuery.parseJSON(getdata);

                        $("#ticketluggageheader").html("Monthly Progress bar");

                        lavel = ['January', 'February', 'March', 'April', 'May', 'June','July','August','September','October','November','December'];
                        Income = getdatafromJson['ticket'];
                        Expense = getdatafromJson['luggage'];

                    }

                     if(graphtype == "YEAR")
                    {
                        var getdata = '<?php echo ($ticketluggage); ?>';
                        var getdatafromJson = jQuery.parseJSON(getdata);
                        lavel = getdatafromJson['year'];
                        Income = getdatafromJson['ticket'];

                        Expense = getdatafromJson['luggage'];

                        $("#ticketluggHeading").html("Yearly Progress bar");
                    }

                var ctx = document.getElementById('ticlaugglineChart').getContext('2d');


                var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: lavel,
                    datasets: [

                                {
                                label: '# TICKET',
                                data: Income ,
                                backgroundColor: [
                                    'rgb(0, 255, 255)',

                                ],
                                borderColor: [
                                    'rgb(0, 255, 255)',

                                ],
                                borderWidth: 1
                                },

                                {
                                label: '# LUGGAGE',
                                data: Expense,
                                backgroundColor: [
                                    'rgb(102, 0, 204)',

                                ],
                                borderColor: [
                                    'rgb(102, 0, 204)',

                                ],
                                borderWidth: 1
                                },



                            ]

                },
                options: {
                    title: {
                                display: true,
                                text: 'Ticket & Luggage Booking Chart'
                            },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },


                }
                    });


                });

            //drop down Ticket Luggage  chart 



            //Agent Report chart default display

            var getdata = '<?php echo ($agentchart); ?>';
                        var getdatafromJson = jQuery.parseJSON(getdata);
                        lavel = getdatafromJson['name'];
                        Income = getdatafromJson['ticket'];

                        Expense = getdatafromJson['luggage'];

     var ctx = document.getElementById('agentchart').getContext('2d');


                var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: lavel,
                    datasets: [

                        {
                        label: '# TICKET',
                        data: Income ,
                        backgroundColor:   'rgb(0, 255, 255)',

                        
                        borderColor:  'rgb(0, 255, 255)',

                        
                        borderWidth: 1
                    },

                    {
                        label: '# LUGGAGE',
                        data: Expense,
                        backgroundColor: 
                            'rgb(102, 0, 204)',

                        
                        borderColor: 
                            'rgb(102, 0, 204)',

                        
                        borderWidth: 1
                    },



                ]

                },
                options: {
                    title: {
                                display: true,
                                text: 'Agent Chart'
                            },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },


                }
            });

            //Agent Report chart default display

            //drop down Agent Report chart default display
            //drop down Agent Report chart default display




   // New code 2021 direct update





});
</script>
