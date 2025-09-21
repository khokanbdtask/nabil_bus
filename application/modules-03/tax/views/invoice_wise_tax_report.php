<div class="row">
<div class="col-sm-12">
<div class="panel panel-default">
<div class="panel-body"> 

<?php echo form_open('invoice_wise_tax_report', array('class' => 'form-inline', 'method' => 'get')) ?>
<?php
$today = date('Y-m-d');
?>
<div class="form-group">
    <label class="" for="from_date"><?php echo display('start_date') ?></label>
    <input type="text" name="from_date" class="form-control datepicker" id="from_date" placeholder="<?php echo display('start_date') ?>" value="<?php echo (!empty($from_date)?html_escape($from_date):html_escape($today)) ?>">
</div> 

<div class="form-group">
    <label class="" for="to_date"><?php echo display('end_date') ?></label>
    <input type="text" name="to_date" class="form-control datepicker" id="to_date" placeholder="<?php echo display('end_date') ?>" value="<?php echo (!empty($to_date)?html_escape($to_date):html_escape($today)) ?>">
</div>  
<!--  <div class="form-group">
    <label class="" for="to_date"><?php echo display('booking_id') ?></label>
    <input type="text" name="invoice_id" class="form-control" value="<?php echo (!empty($invoice_id)?html_escape($invoice_id):'');?>">
</div>  -->

<button type="submit" class="btn btn-success"><?php echo display('search') ?></button>

<!-- <a  class="btn btn-warning" href="#" onclick="printDiv('purchase_div')"><?php echo display('print') ?></a> -->

<?php echo form_close() ?>

</div>
</div>
</div>
</div>


<!-- TAX -->
<div class="row">
<div class="col-sm-12">
<div class="panel panel-bd lobidrag">
<div class="panel-heading">
<div class="panel-title">
    <h4><?php echo display('tax_report') ?></h4>
</div>
</div>

<div class="panel-body">

<input type="hidden" id="number_of_taxes" value="<?php echo $not = count($taxes)+1; ?>">
<input type="hidden" id="total_bookings" value="<?php echo (count($luggage_tax_paid)>0)?count($luggage_tax_paid):0; ?>">

<div class="" id=""> 
<table class="datatable table table-bordered">
    <thead>
        <tr>
            <th class="text-center"><?php echo display('sl')?></th>
            <th class="text-center"><?php echo display('booking_id') ?></th>
            <th class="text-center"><?php echo display('date')?></th>
            <!-- <td>Tota Rate</td>  -->
            <th class="text-center" id="tax_head0">Total Paid</th>
            <?php 
            $n=1;
            foreach($taxes as $taxfield){
                    $total_taxes[$n]=0; 
                ?>
                <th class="text-center" id="tax_head<?php echo $n; ?>"><?php echo html_escape($taxfield['tax_name'])?></th>
        <?php 
            $n++;
            }
        ?>
            <th class="text-center" id="tax_head<?php echo $n ?>">Total Tax</th>
        </tr>
    </thead>
    <tbody>
        <?php if(!empty($luggage_tax_paid)){?>
        <?php 
            $sl=1;
            
            $c = 0;
 $total_taxes = array();
            foreach($luggage_tax_paid as $taxvalue){
        ?>
        <tr>
            <td class="text-center"><?php echo $sl;?></td>
            <td class="text-center"><?php echo (!empty($taxvalue->id_no)?html_escape($taxvalue->id_no):'');?></td>
            <td class="text-center"><?php echo html_escape(date("d-F-Y",(strtotime($taxvalue->booking_date))));?></td>
            <!-- <td><?php echo $taxvalue->total_tax ?></td> -->
            <td class='text-right' id='tax0'><?php echo $taxvalue->amount ?></td>
            
             <?php 
                $x = 1;
                
                foreach ($taxes as $rates) {
                    echo "<td class='text-right' id='tax".$x."'>";
                    
                    if(array_search($rates['id'], $tax_ids[$c])){

                        $tax_paid_total = (($taxvalue->amount/((100/$taxvalue->total_tax)+1))*$rates['default_value'])/$taxvalue->total_tax; 

                        echo number_format($tax_paid_total,3);

                    }
                    else
                    {
                        echo 0.00;
                    }

                    echo "</td>";
                    $x++;
                }

             ?>
             <td class="text-right" id="tax<?php echo $x ?>">
                <?php 
                    $tax_paid_total = (($taxvalue->amount/((100/$taxvalue->total_tax)+1))*$taxvalue->total_tax)/$taxvalue->total_tax; 
                        
                        echo number_format($tax_paid_total,3);
                ?>
             </td>
        </tr>
    <?php 
            $sl++;
            $c++;
            }
        ?>
    </tbody>
    <tfoot>
        <tr>
            <td></td>
            <td></td>
            <td class="text-right"><b>Total</b></td>
            <td class='text-right' id='total_tax0'></td>
               <?php  
               $b = 1;

               // print_r($total_taxes);
             foreach($taxes as $taxfield){
                echo "<td class='text-right' id='total_tax".$b."'></td>";
                $b++;
                }
                ?>
            <td id="total_tax<?php echo $b ?>" class="text-right"></td>
             
        </tr>
    </tfoot>
    <?php
    }

    ?>


</table>


</div>
<input type="hidden" name="taxnumber" id="taxnumber" value="<?php echo $taxnumber;?>">
</div>

</div>
</div>
</div>
<script>

    var not = $("#number_of_taxes").val();
    var tb = $("#total_bookings").val();

    if(tb>0){

        $(document).ready(function () {

            
            for(var i = 0; i <= not; i++){
                var tc = $('#tax_head'+i+'').each(function (i) {
                    calculateColumn(i);

                });
            }
        });
        function calculateColumn(index) {
            for(var i = 0; i <= not; i++){
                var total = 0;
                $('table tr').each(function () {
                    var value = parseFloat($('#tax'+i+'', this).eq(index).text());
                    if (!isNaN(value)) {
                        total += value;
                    }
                });
                // $('table tfoot td ').eq(0).text('Total');
                $('#total_tax'+i+'').eq(index).text(total.toFixed(3));
            }
        }

    }
    </script>