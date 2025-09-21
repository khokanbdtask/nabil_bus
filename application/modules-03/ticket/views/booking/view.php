<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
                <div class="panel-title">
                    
                </div>
            </div>

            <div class="panel-body" id="PrintMe">
                <table class="table table-hover" width="100%">
                    <thead>
                    <tr>
                        <th>Payment Type</th>
                        <td><?php echo $paytype; ?></td>
                    </tr>
                    <tr>
                        <th>Payment Detail</th>
                        <td><?php echo $paydetail; ?></td>
                    </tr>
                   
                    </thead>
                </table>

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





