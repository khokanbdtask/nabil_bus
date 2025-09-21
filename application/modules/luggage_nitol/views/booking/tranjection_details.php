<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
                <div class="panel-title">
                    
                </div>
            </div>
            <div class="panel-body" id="PrintMe">
        <div class="card-content">
            <div class="card-content-languages">

                <table class="table table-hover" width="100%">
                    <tr>
                        <th><?php echo display('booking_id') ?></th>
                        <td><?php echo $detail->id_no; ?></td>
                    </tr>

                    <tr>
                        <th><?php echo display('amount') ?></th>
                        <td><?php echo $detail->amount; ?></td>
                    </tr>

                    

                    <tr>
                        <th><?php echo display('date') ?></th>
                        <td><?php echo $detail->create_date ; ?></td>
                    </tr>


                    <?php if ($detail->luggage_booking_id): ?>
                   
                        <tr>
                       <th>Partial Payment Type: </th>
                        <td><?php echo $detail->partial_pay_type; ?></td>
                    </tr> 
                    <tr>
                       <th>Partial Payment Amount: </th>
                        <td><?php echo $detail->amount_paid; ?></td>
                    </tr> 
                    <tr>
                       <th>Partial Payment Detail: </th>
                        <td><?php echo $detail->parital_detail; ?></td>
                    </tr> 

                    <tr>
                       <th> Payment Type: </th>
                        <td><?php echo $detail->full_pay_type; ?></td>
                    </tr> 

                    <tr>
                       <th> Payment Amount: </th>
                        <td><?php echo $detail->full_paid; ?></td>
                    </tr> 

                    <tr>
                       <th> Payment Detail: </th>
                       <?php if ($detail->full_detail == "cash"): ?>
                        <td><?php echo $detail->full_detail; ?></td>
                        <?php else : ?>
                            <td><?php echo $detail->full_detail; ?> </td>
                       <?php endif; ?>
                       
                    </tr> 

                    <?php endif; ?>
                   

                </table>

            </div>
            <?php if (!empty($partial_pay_all)) : ?>
                    <!-- TRUE -->
              
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">Date</th>
                            <th scope="col">Booking Id</th>
                            <th scope="col">Amount</th>
                            <th scope="col">Payment Step</th>
                            <th scope="col">Detail</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($partial_pay_all as $kye => $item) : ?>
                                <tr>
                                    <th scope="row"><?= $kye+1 ;?></th>
                                    <td><?= $item->date ;?></td>
                                    <td><?= $item->booking_id ;?></td>
                                    <td><?= $item->amount ;?></td>
                                    <td><?= $item->payment_step;?></td>
                                    <td><?= $item->detail ;?></td>
                                </tr>
                            <?php endforeach ?>
                            <tr>
                            <td></td>
                            <td></td>
                            <td>Total</td>
                            <td>
                                <b><?= $counts =  array_sum(array_column($partial_pay_all, 'amount')); ?></b>
                               
                            </td>
                            <td></td>
                            </tr>
                           
                        </tbody>
                </table>
             </div>

             <?php endif ?>           



        </div>
            </div> 
        </div>
    </div>
</div>

 


 