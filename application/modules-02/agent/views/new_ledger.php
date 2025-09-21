<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
                <div class="panel-title">
                    <h4> 
                       Agent Ledger
                    </h4>
                </div>
            </div>
                

            <div class=" panel">


                <?php echo form_open(base_url('agent/agent_controller/agent_ledger_new/'.$agentid)); ?>
                    <div class="row" style="padding: 10px; width: 100%;">

                    <div class="col-xs-6 col-sm-3">
                        <label>Date From</label>

                        <?php echo form_input('datefrom', date("01-m-Y"), 'class="form-control datepicker"  placeholder="Date From" id="datefrom" type="text" required="required" '); ?>

                    </div>
                    <div class="col-xs-6 col-sm-3">
                        <label>Date To</label>

                        <?php echo form_input('dateto', date("d-m-Y"), 'class="form-control datepicker"  placeholder="Date To" id="dateto" type="text"  required="required" '); ?>

                       
                    </div>
                    
                    <div class="col-xs-6 col-sm-3 mt-4">
                    <br>
                    <?php echo form_submit('mysubmit', 'Filter', 'class="btn btn-success" style="margin-top:5px;"'); ?>

                    </div>


                    </div>
                    

                <?php echo form_close(); ?>
            </div>



            <div class="panel-body">
                
                <div class="text-center">
                   <h2> <?php echo $detls->agent_first_name.' '.$detls->agent_second_name; ?></h2>
                   <h4><?php echo $detls->agent_company_name; ?></h4>
                   <h4><?php echo 'phone :'.''.$detls->agent_phone; ?></h4>
                </div>
                <table width="100%" class="agentlegernew table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                             <th class="text-center"><?php echo display('serial') ?></th>
                            <th class="text-center"><?php echo display('date') ?></th>
                           
                             <th class="text-center"><?php echo display('debit') ?></th>
                            <th class="text-center"><?php echo display('credit') ?></th>
                            <th class="text-center"><?php echo display('balance') ?></th>
                            <th class="text-center">Transaction detail</th>
                           
                           
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($ledger)) { ?>
                            <?php $sl = 1; ?>
                            <?php
                            $balance = 0;
                            $total_credit = 0;
                            $total_debit = 0;
                            $total_balance = 0;
                             foreach ($ledger as $query) {
                                $amount = $query->debit - $query->credit;
                                $balance = $balance - $amount;
                                $total_credit += $query->credit;
                                $total_debit += $query->debit;
                                $total_balance += $amount;
                              ?>
                               <tr>
                                    <td><?php echo $sl; ?></td>
                                    <td><?php echo $query->date; ?></td>
                                     
                                    <td class="text-right"><?php echo $currency; ?> <?php echo $query->debit; ?></td>
                                    <td class="text-right"> <?php echo $currency; ?> <?php echo $query->credit; ?></td>  
                                    <td class="text-right" class="text-right"><?php echo $currency; ?> <?php echo $balance; ?></td>  
                                    <td class="text-center"> <?php echo $query->detail; ?></td> 
                                </tr>
                                <?php $sl++; ?>
                            <?php } ?> 
                        <?php } ?> 
                    </tbody>
                    <tfooter>
                        <tr><td colspan="2" class="text-right"><b>Total </b></td><td class="text-right"><b><?php echo $currency; ?> <?php echo (!empty($total_debit))?$total_debit:0;?></b></td><td class="text-right"><b><?php echo $currency; ?> <?php echo (!empty($total_credit))?$total_credit:0;?></b></td><td class="text-right"><b><?php echo $currency; ?> <?php echo (!empty($total_balance))?$total_credit-$total_debit:0;?></b></td><td></td></tr>
                    </tfooter>
                </table>  <!-- /.table-responsive -->
            </div> 
        </div>
    </div>
</div>
<script type="text/javascript">
 
    $( document ).ready(function() {
        var logo = "<?php echo $logo->text_logo ?>"; 
        $('.agentlegernew').DataTable({
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