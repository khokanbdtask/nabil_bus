<div class="clearfix"></div>
<div class="main-search-container" style="background-image: url(<?php echo base_url('application/modules/website/assets/images/bg.jpg') ?>); margin-bottom: 80px;">
    <div class="main-search-inner" >
        <div class="container">
            <div class="row">
                <div class="col-sm-4">
                    <div class="home-form form-block">
                        <h3 class="form-block_title"><?php echo display('search_tour'); ?></h3>
                        <div class="form-block_des"><?php echo display('find_dream'); ?></div>
                       
                        <form action="<?php echo base_url('website/search') ?>"  style="padding:29px 0">
                            <div class="form-group  mt-2 custom-select">
                                <?php echo form_dropdown('start_point', $location_dropdown, $search->start_point, array('class'=>'select2 form-control','required'=>'required', 'data-placeholder'=>display('start_point')) ) ?> 
                                <i class="fa fa-map-marker"></i>
                            </div>
                            <div class="form-group  mt-2 custom-select">
                                <?php echo form_dropdown('end_point', $location_dropdown, $search->end_point, array('class'=>'select2 form-control','required'=>'required', 'data-placeholder'=>display('end_point')) ) ?> 
                                <i class="fa fa-map-marker"></i>
                            </div>
                            <div class="form-group  mt-2">
                                <input type='text' name="date" class='form-control datepicker' placeholder="<?php echo display('date') ?>" required="required" value="<?php echo $search->date ?>" autocomplete="off">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <div class="form-group  mt-2 custom-select">
                                <?php echo form_dropdown('fleet_type', $fleet_dropdown, $search->fleet_type, array('class'=>'select2 form-control','required'=>'required', 'data-placeholder'=>display('fleet_type')) ) ?> 
                                <i class="fa fa-car"></i>
                            </div>

                            <button type="submit" class="btn btn-block  mt-2"><?php echo display('find_now'); ?></button>
                        </form>
                    </div>
                </div>  



                <div class="col-sm-8">
                    <div class="header-title-inner">
                        <h3><?php echo display('travel_slogan'); ?></h3>
                        <h5><?php echo display('travel_sub_slogan'); ?></h5>
                    </div>

                    <!-- Carousel wrapper -->
                    <div
                            id="carouselMultiItemExample"
                            class="carousel slide carousel-dark text-center mb-5"
                            data-mdb-ride="carousel"
                    >

                        <!-- Inner -->
                        <div class="carousel-inner py-4">
                            <button
                                    class="carousel-control-prev"
                                    type="button"
                                    data-bs-target="#carouselMultiItemExample"
                                    data-bs-slide="prev"
                                    style="margin-left:-48px;"
                            >
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <!-- Single item -->
                    <?php
                        $no_of_offers_in_slide = 3;
                        if (!empty($offers)) {
                            $num_of_offers = count($offers);
                            $slide_no = count($offers)/$no_of_offers_in_slide;

                            for($c=0;$c<$slide_no;$c++)
                            {
//                                echo $slide_no;

                                    ?>
                                    <div class="carousel-item <?=   ($c==0)?"active":""  ?>" data-bs-interval="2000">
                                        <div class="container">
                                            <div class="row">
                    <?php

                                    for($m = 0; $m<$no_of_offers_in_slide;$m++)
                                    {

                                        $offer_position = ($no_of_offers_in_slide*$c)+$m;

//                                        echo $no_of_offers_in_slide;
                                        if($offer_position < $num_of_offers)
                                        {
                    ?>

                                                <div class="col-lg-4 <?=  ($m==0)?"":" d-none d-lg-block"   ?>">
                                                    <div class="card">
                                                        <img
                                                                src="<?php echo base_url($offers[$offer_position]->image); ?>"
                                                                class="card-img-top"
                                                                alt="..."
                                                        />
                                                        <div class="card-body">
                                                            <h5 class="card-title"><?= $offers[$offer_position]->title  ?></h5>
                                                            <p class="card-text visually-hidden">
                                                                Some quick example text to build on the card title and make up the bulk
                                                                of the card's content.
                                                            </p>
                                                            <a href="#!" class="btn btn-primary visually-hidden">Button</a>
                                                        </div>
                                                    </div>
                                                </div>

                    <?php
                                        }
                                    }
                    ?>

                                            </div>
                                        </div>
                                    </div>
                    <?php
                            }
                        }
                    ?>

                            <!--   End Carousel Single Item-->

                        </div>
                        <!-- Inner -->
                            <button
                                    class="carousel-control-next px-4"
                                    id="foo"
                                    type="button"
                                    data-bs-target="#carouselMultiItemExample"
                                    data-bs-slide="next"
                                    style="margin-right:-48px;"
                            >
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                    </div>
                    <!-- Carousel wrapper -->

                </div>


            </div>
        </div>
    </div>
</div>
<section>
<div class="container container-fluid align-content-center">
    <div class="row counter-inner hidden-sm">
        <div class="col-sm-4">
            <div class="counter-content">
                <div class="border">
                    <div class="counter-icon">
                        <i class="fa fa-users" style="line-height:34px;"></i>
                    </div>
                </div>
                <h6><?php echo display('total_passenger') ?></h6>
                <p class="count-number">
                    <?php echo (!empty($notifications->passenger->total)?$notifications->passenger->total:0) ?>
                </p>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="counter-content">
                <div class="border">
                    <div class="counter-icon">
                        <i class="flaticon-bus"></i>
                    </div>
                </div>
                <h6><?php echo display('total_fleet') ?></h6>
                <p class="count-number">
                    <?php echo (!empty($notifications->fleet->total)?$notifications->fleet->total:0) ?>
                </p>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="counter-content">
                <div class="border">
                    <div class="counter-icon">
                        <i class="flaticon-road-perspective-of-curves"></i>
                    </div>
                </div>
                <h6><?php echo display('todays_trip') ?></h6>
                <p class="count-number">
                    <?php echo (!empty($notifications->trip->total)?$notifications->trip->total:0) ?>
                </p>
            </div>
        </div>
    </div>
</div>
</section>
<section>
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <div class="payment-system">
                <h2 class="block-title"><?php echo (!empty($appSetting->about)?$appSetting->about:null) ?></h2>
                <p><?php echo (!empty($appSetting->description)?$appSetting->description:null) ?></p> 
            </div>
        </div>
    </div>
</div>

</section>
<section class="testimonial_inner">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h2 class="block-title"><?php echo display('our_customers_say') ?></h2>
                <?php 
                if (!empty($ratings)) 
                {
                    foreach ($ratings as $rate)
                    {
                        echo "<div class=\"feedback_iner\">
                            <div class=\"feedback_container\">
                                <div class=\"feedback_stars\">" .str_repeat("<i class=\"fa fa-star\"></i>", $rate->rating). "</div>
                                <p>$rate->comment</p>
                            </div>
                            <div class=\"feedback_user\">
                                <div class=\"feedback_useruser_title\">
                                    $rate->name
                                    <span>($rate->tkt_booking_id_no)</span>
                                </div>
                            </div>
                        </div>"; 
                    }
                }
                ?> 
            </div>
        </div>
    </div>
</section>

<script>
    $( document ).ready(function() {
        setInterval(function(){
            $( "#foo" ).trigger( "click" );
        }, 5000);
    });
</script>