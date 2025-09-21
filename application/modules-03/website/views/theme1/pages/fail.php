<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <div class="payment-system ticket-content">
                <h2 class="block-title">Dear Customer</h2>
                <p class="text-center">We are sorry! Your last transaction was Failed.</p> 

                <p class="text-center">
                     <input type="hidden" name="<?php echo $this->security->get_csrf_token_name() ?>" value="<?php echo $this->security->get_csrf_hash() ?>">
                <a href="<?php echo base_url() ?>" class="btn btn-primary">Back to Home</a>
            	</p>
            </div>
        </div>
    </div>
</div>