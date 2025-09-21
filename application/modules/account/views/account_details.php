<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
                <div class="panel-title">
                    <h4>
                        <a href="<?php echo base_url("/account/account_controller/create_transaction");?>" class="btn btn-sm btn-primary"><i class="fa fa-list"></i><?php echo display('list') ?></a>
                        <a href="#" class="btn btn-sm btn-danger" onclick="printContent('PrintMe')" title="Print"> <i class="fa fa-print"></i></a>
                    </h4>
                </div>
            </div>
            <div class="panel-body" id="PrintMe">
        <div class="card-content">
            <div class="card-content-languages">

                <table class="table table-hover" width="100%">
                    <tr>
                        <th><?php echo display('account_name') ?></th>
                        <td><?php echo $detail->account_name; ?></td>
                    </tr>
                    <tr>
                        <th><?php echo display('account_type') ?></th>
                        <td><?php echo (($detail->account_type==0)?"Expense":"Income"); ?></td>
                    </tr>
                    <tr>
                        <th><?php echo display('amount') ?></th>
                        <td><?php echo $currency; ?><?php echo $detail->amount; ?></td>
                    </tr> 
                    
                    <!-- New code 2021 direct update  -->
                    <tr>
                        <th><?php echo display('payment_method') ?></th>
                        <td><?php echo rtrim($detail->payment_method,','); ?></td>
                    </tr>

                    <tr>
                        <th><?php echo display('date') ?></th>
                        <td><?php echo rtrim($detail->date,','); ?></td>
                    </tr>

                    <!-- New code 2021 direct update  -->

                    <tr>
                        <th><?php echo display('description') ?></th>
                        <td><?php echo rtrim($detail->transaction_description,','); ?></td>
                    </tr>    
                    <tr>
                        <th><?php echo display('create_by_id') ?></th>
                        <td><?php echo $detail->created_by;?></td>
                    </tr> 
                    
                     <!-- New code 2021 direct update  -->

                     <tr>
                        <th><?php echo display('invoice') ?></th>
                        <td>
                        <img src="<?php echo base_url().$detail->document_pic?>" width="300px" /><br>
                        <br>
                        <a target = "_blak" href="<?php echo base_url().$detail->document_pic?>" class=" mt-3 btn btn-primary">View</a>
                        
                        </td>
                    </tr>  

                      <!-- New code 2021 direct update  -->

                </table>

            </div>
        </div>
            </div> 
        </div>
    </div>
</div>

 


 