<div class="form-group text-right">
    <?php if($this->permission->method('offer', 'create')->access()): ?>
    <button type="button" class="btn btn-primary btn-md" data-target="#add0" data-toggle="modal"><i class='fa fa-gift' aria-hidden='true'></i> <?php echo display('add_offer') ?>
    </button>
    <?php endif; ?> 
</div>
<div class="row">
    <!--  table area -->
    <div class="col-sm-12">

        <div class="panel panel-default thumbnail">

            <div class="panel-body">

                <table width="100%" class="datatable table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Date</th>
                            <th>In Time</th>
                            <th>Out Time</th>
                            <th>Worked Hours</th>
                            <th>Wastage Hours</th>
                            <th>Net Hours</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if (!empty($ofer)) { ?>
                        <?php $sl = 1; ?>
                        <?php foreach ($ofer as $query) { ?>
                            <?php
                            $cd=$query->offer_start_date;
                            $ab=$query->offer_end_date;
                            $bc=date('Y-m-d');
                            $date1 = new DateTime("$bc");
                            $date2 = new DateTime("$cd");
                            $days = $date1->diff($date2);
                            // this will output 4 days
                            $d=$days->days;

                            if ($bc>$ab) {
                                $tr ="#ffc8c8";
                            }else {
                                $tr ="#ffffff";
                            }
                            ?>
                            <tr>
                                <td>1</td>
                                <td>March 27, 2021</td>
                                <td>09:49:25</td>
                                <td>17:28:59</td>
                                <td>7:39:34</td>
                                <td> 0:28:46</td>
                                <td>7:10:48</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>March 25, 2021</td>
                                <td>09:47:10</td>
                                <td>19:13:24</td>
                                <td>9:26:14</td>
                                <td> 0:23:44</td>
                                <td>9:2:30</td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>March 24, 2021</td>
                                <td>09:43:51</td>
                                <td>18:51:23</td>
                                <td>9:7:32</td>
                                <td> 0:23:22</td>
                                <td>8:44:10</td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>March 23, 2021</td>
                                <td>09:38:16</td>
                                <td>19:31:17</td>
                                <td>9:53:1</td>
                                <td> 1:30:14</td>
                                <td>8:22:47</td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td>March 22, 2021</td>
                                <td>10:05:57</td>
                                <td>18:34:04</td>
                                <td>8:28:7</td>
                                <td> 0:22:49</td>
                                <td>8:5:18</td>
                            </tr>
                            <tr>
                                <td>6</td>
                                <td>March 21, 2021</td>
                                <td>10:05:31</td>
                                <td>19:23:52</td>
                                <td>9:18:21</td>
                                <td> 0:32:59</td>
                                <td>8:45:22</td>
                            </tr>
                            <tr>
                                <td>7</td>
                                <td>March 18, 2021</td>
                                <td>09:33:11</td>
                                <td>18:56:18</td>
                                <td>9:23:7</td>
                                <td> 0:50:59</td>
                                <td>8:32:8</td>
                            </tr>
                            <tr>
                                <td>8</td>
                                <td>March 16, 2021</td>
                                <td>09:17:30</td>
                                <td>15:58:51</td>
                                <td>6:41:21</td>
                                <td> 0:34:50</td>
                                <td>6:6:31</td>
                            </tr>
                            <tr>
                                <td>9</td>
                                <td>March 15, 2021</td>
                                <td>10:14:20</td>
                                <td>19:02:51</td>
                                <td>8:48:31</td>
                                <td> 0:36:53</td>
                                <td>8:11:38</td>
                            </tr>
                            <tr>
                                <td>10</td>
                                <td>March 14, 2021</td>
                                <td>09:25:34</td>
                                <td>19:00:37</td>
                                <td>9:35:3</td>
                                <td> 0:34:40</td>
                                <td>9:0:23</td>
                            </tr>
                            <tr>
                                <td>11</td>
                                <td>March 13, 2021</td>
                                <td>09:21:59</td>
                                <td>18:54:26</td>
                                <td>9:32:27</td>
                                <td> 0:36:52</td>
                                <td>8:55:35</td>
                            </tr>
                            <tr>
                                <td>12</td>
                                <td>March 11, 2021</td>
                                <td>09:43:08</td>
                                <td>18:51:58</td>
                                <td>9:8:50</td>
                                <td> 0:24:24</td>
                                <td>8:44:26</td>
                            </tr>
                            <tr>
                                <td>13</td>
                                <td>March 10, 2021</td>
                                <td>09:47:54</td>
                                <td>19:07:24</td>
                                <td>9:19:30</td>
                                <td> 0:26:20</td>
                                <td>8:53:10</td>
                            </tr>
                            <tr>
                                <td>14</td>
                                <td>March 09, 2021</td>
                                <td>09:28:55</td>
                                <td>18:45:24</td>
                                <td>9:16:29</td>
                                <td> 0:20:32</td>
                                <td>8:55:57</td>
                            </tr>
                            <tr>
                                <td>15</td>
                                <td>March 08, 2021</td>
                                <td>09:45:32</td>
                                <td>18:48:00</td>
                                <td>9:2:28</td>
                                <td> 0:27:46</td>
                                <td>8:34:42</td>
                            </tr>
                            <tr>
                                <td>16</td>
                                <td>March 07, 2021</td>
                                <td>10:07:08</td>
                                <td>19:15:10</td>
                                <td>9:8:2</td>
                                <td> 0:26:14</td>
                                <td>8:41:48</td>
                            </tr>
                            <tr>
                                <td>17</td>
                                <td>March 06, 2021</td>
                                <td>09:24:56</td>
                                <td>19:01:21</td>
                                <td>9:36:25</td>
                                <td> 0:24:7</td>
                                <td>9:12:18</td>
                            </tr>
                            <tr>
                                <td>18</td>
                                <td>March 04, 2021</td>
                                <td>09:34:08</td>
                                <td>18:41:22</td>
                                <td>9:7:14</td>
                                <td> 0:25:35</td>
                                <td>8:41:39</td>
                            </tr>
                            <tr>
                                <td>19</td>
                                <td>March 02, 2021</td>
                                <td>10:09:23</td>
                                <td>18:52:36</td>
                                <td>8:43:13</td>
                                <td> 0:27:3</td>
                                <td>8:16:10</td>
                            </tr>
                            <tr>
                                <td>20</td>
                                <td>March 01, 2021</td>
                                <td>09:40:00</td>
                                <td>19:07:19</td>
                                <td>9:27:19</td>
                                <td> 0:26:6</td>
                                <td>9:1:13</td>
                            </tr>

                            <?php $sl++; break; ?>
                        <?php } ?>
                    <?php } ?>

                    </tbody>
                </table>
                <!-- /.table-responsive -->
            </div>
        </div>
    </div>
</div>

<div id="add0" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color:green; color: white">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <center><strong>Add New Offers</strong></center>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <div class="panel">

                            <div class="panel-body">

                                <?= form_open('offer/offer_controller/create_offer') ?>

                                    <div class="form-group row">
                                        <div for="offer_name" class="col-sm-3 col-form-div">
                                            <?php echo display('offer_name') ?> *</div>
                                        <div class="col-sm-9">
                                            <input name="offer_name" class="form-control" type="text" placeholder="<?php echo display('offer_name') ?>" id="offer_name">
                                        </div>

                                    </div>
                                    <div class="form-group row">
                                        <div for="offer_start_date" class="col-sm-3 col-form-div">
                                            <?php echo display('offer_start_date') ?> *</div>
                                        <div class="col-sm-9">
                                            <input name="offer_start_date" class="datepicker form-control" type="text" placeholder="<?php echo display('offer_start_date') ?>" id="offer_start_date">
                                        </div> 
                                    </div>

                                    <div class="form-group row">
                                        <div for="offer_end_date" class="col-sm-3 col-form-div">
                                            <?php echo display('offer_end_date') ?> *</div>
                                        <div class="col-sm-9">
                                            <input type="text" name="offer_end_date" class="datepicker form-control" placeholder="<?php echo display('offer_end_date') ?>" id="offer_end_date">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div for="offer_code" class="col-sm-3 col-form-div">
                                            <?php echo display('offer_code') ?> *
                                        </div>
                                        <div class="col-sm-9">
                                            <input type="text" name="offer_code" class="form-control" placeholder="<?php echo display('offer_code') ?>" id="offer_code" > 
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div for="offer_discount" class="col-sm-3 col-form-div">
                                            <?php echo display('offer_discount') ?> *</div>
                                        <div class="col-sm-9">
                                            <input type="text" name="offer_discount" class="form-control" placeholder="<?php echo display('offer_discount') ?>" id="offer_discount">
                                        </div>

                                    </div>

                                    <div class="form-group row">
                                        <div for="offer_terms" class="col-sm-3 col-form-div">
                                            <?php echo display('offer_terms') ?>
                                        </div>
                                        <div class="col-sm-9">
                                            <textarea name="offer_terms" class="form-control" placeholder="<?php echo display('offer_terms') ?>" id="offer_terms"></textarea>
                                        </div>

                                    </div>
                                    <div class="form-group row">
                                        <div for="offer_route_id" class="col-sm-3 col-form-div">
                                            <?php echo display('offer_route_id') ?> *</div>
                                        <div class="col-sm-9">

                                            <?php echo form_dropdown('offer_route_id',$rout,null,'class="form-control" style="width:100%"') ?>
                                        </div>

                                    </div>

                                    <div class="form-group row">
                                        <div for="offer_number" class="col-sm-3 col-form-div">
                                            <?php echo display('offer_number') ?></div>
                                        <div class="col-sm-9">
                                            <input name="offer_number" class="form-control" type="text" placeholder="<?php echo display('offer_number') ?>" id="offer_number">

                                        </div>

                                    </div>

                                    <div class="form-group text-right">
                                        <button type="reset" class="btn btn-primary w-md m-b-5">
                                            <?php echo display('reset') ?>
                                        </button>
                                        <button type="submit" class="btn btn-success w-md m-b-5" id="check_username_availability">
                                            <?php echo display('add') ?>
                                        </button>
                                    </div>
                                    <?php echo form_close() ?>

                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div> 
    </div>

</div>

<script type="text/javascript">
    $(function() {
        $(".datepicker").datepicker({
            dateFormat: "yy-mm-dd"
        }).val()
    });


</script>
 