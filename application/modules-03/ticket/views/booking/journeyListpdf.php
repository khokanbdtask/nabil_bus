<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<style type="text/css" >
      .table {
          display: table;
      }
      .tr {
          display: table-row;
      }
      /* .highlight {
          background-color: greenyellow;
          display: table-cell;
      } */
  </style>
</head>

<body>
<h1 class="text-center"><?php echo $logo->text_logo ?></h1>
<h5 class="text-center">Trip Name : <?php echo $tripname->trip_title ?></h5>
<h6 class="text-center">Departure Point : <?php echo $startlocation[0]['name']; ?></h6>
<h6 class="text-center">Destination Point : <?php echo $endlocation[0]['name']; ?></h6>


    <h6 class="text-center" >Driver Name :
    <?php foreach ($employees as $evalue): ?>
        <?php if ($evalue->employeetype == 'Driver'): ?>
       <small> <?php echo $evalue->first_name . $evalue->second_name;  ?>,</small> 
       <?php endif; ?> 
     <?php endforeach; ?>
        </h6>

    <h6 class="text-center" >Assistant Name :
    <?php foreach ($employees as $evalue): ?>
        <?php if ($evalue->employeetype == 'Assistant'): ?>
       <small> <?php echo $evalue->first_name . $evalue->second_name;  ?>,</small> 
       <?php endif; ?> 
     <?php endforeach; ?>
        </h6>

 <!-- client 2022 project update      -->
 <h6 class="text-center" >Vehicle Registration No :
    <small> <?php echo $vehicledetail->reg_no ;?></small> 
 </h6>
 <!-- client 2022 project update      -->

<div class="" id="printTable">
                    <table width="100%" page-break-inside: auto; class="table table-bordered" >
                  
                        <thead>
                            <tr>
                                <th><?php echo display('sl_no') ?></th>
                                <!-- <th><?php echo display('journey_date') ?></th> -->
                                <th><?php echo display('booking_id') ?></th>

                                <th><?php echo display('name') ?></th>
                                <th><?php echo display('nid_passport') ?></th>
                                <th><?php echo display('phone') ?></th>
                                
                                <th><?php echo display('seat_numbers') ?></th>
                                <th><?php echo display('start_point') ?></th>
                                <th><?php echo display('end_point') ?></th>
                                <th><?php echo display('child_detail') ?></th> 
                            </tr>
                        </thead>
                             
                      

                        <tbody>
                        <?php if (!empty($passengarlist)): ?>
                            <?php $sl = 1; ?>
                            <?php foreach ($passengarlist as $pvalue): ?>

                       
                               

                                <tr>
                                <td><?php echo $sl++; ?></td>
                                <td><?php echo $pvalue->customerbookingId; ?></td>
                                <td class=""><?php echo ucwords(strtolower($pvalue->firstname.' '.$pvalue->lastname)); ?></td>
                                <td><?php echo $pvalue->nid; ?></td>
                                <td><?php echo $pvalue->phone; ?></td>
                                <td><?php echo $pvalue->seat_numbers; ?></td>

                                <td>
                                        <?php
                                        $CI =& get_instance();
                                        $CI->db->where('id', $pvalue->pickup_trip_location);
                                        $query = $this->db->get('trip_location');
                                        $picuplocation =  $query->row();

                                        $CI->db->where('id', $pvalue->drop_trip_location);
                                        $query = $this->db->get('trip_location');
                                        $droplocation =  $query->row();

                                        ?>
                                  <?php echo empty($picuplocation->name) ? "none":$picuplocation->name ; ?>
                                </td>
                                <td>
                                <?php echo empty($droplocation->name) ? "none":$droplocation->name ; ?>
                                </td>

                                <td>

                                    <?php

                                            $CI =& get_instance();
                                          
                                            $CI->db->where('booking_id', $pvalue->customerbookingId);
                                            $query = $this->db->get('child_passenger');
                                            $childDetails =  $query->result();
                                     
                                     ?>
                                            
                                             
                                    <?php if (!empty($childDetails)): ?>
                                     <?php foreach ($childDetails as $cvalue): ?>
                                       
                                        Name: <?php echo ucwords(strtolower($cvalue->firstName.' '.$cvalue->lastName)); ?><br>
                                       Nid:<?php echo $cvalue->nid; ?><br>
                                       
                                       <?php endforeach; ?>
                                    <?php endif; ?> 

                                
                                </td>
                                
                     
                             
                                
                            </tr>
                            <?php endforeach; ?>

                        <?php endif; ?>  
                        </tbody>



                    </table>
                   
                </div>

</body>

<script type="text/javascript">

$(document).ready(function () {
    window.print();
});

</script>
</html>



