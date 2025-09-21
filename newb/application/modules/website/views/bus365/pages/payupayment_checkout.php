
  <script>
    var hash = '<?php echo $hash ?>';
    function submitPayuForm() {
      if(hash == '') {
        return;
      }
      var payuForm = document.forms.payuForm;
      payuForm.submit();
    }
  </script>
  </head>
  <body onload="submitPayuForm()">
    <h2>PayU Form</h2>
    <br/>
    <?php if($formError) { ?>
      <span style="color:red">Please fill all mandatory fields.</span>
      <br/>
      <br/>
    <?php } ?>
 
    <form action="<?php echo $action; ?>" method="post" name="payuForm" >
                    <input type="hidden" name="key" value="<?php echo $mkey; ?>" />
                    <input type="hidden" name="hash" value="<?php echo $hash; ?>"/>
                    <input type="hidden" name="txnid" value="<?php echo $tid; ?>" />

                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name() ?>" value="<?php echo $this->security->get_csrf_hash() ?>">
                    <div class="form-group">
                        <label class="control-label">Total Payable Amount</label>
                        <input class="form-control" name="amount" value="<?php echo $amount; ?>"  readonly/>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Your Name</label>
                        <input class="form-control" name="firstname" id="firstname" value="<?php echo $name; ?>" readonly/>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Email</label>
                        <input class="form-control" name="email" id="email" value="<?php echo $mailid; ?>" readonly/>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Phone</label>
                        <input class="form-control" name="phone" value="<?php echo $phoneno; ?>" readonly />
                    </div>
                    <div class="form-group">
                        <label class="control-label"> Booking Info</label>
                        <textarea class="form-control" name="productinfo" readonly><?php echo $productinfo; ?></textarea>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Address</label>
                        <input class="form-control" name="address1" value="<?php echo $address; ?>" readonly/>     
                    </div>
                    <div class="form-group">
                        <input name="surl" value="<?php echo $sucess; ?>" size="64" type="hidden" />
                        <input name="furl" value="<?php echo $failure; ?>" size="64" type="hidden" />  
                        <!--for test environment comment  service provider   -->
                        <input type="hidden" name="service_provider" value="" size="64" />
                        <input name="curl" value="<?php echo $cancel; ?> " type="hidden" />
                    </div>
                    <div class="form-group float-right">
                      <input type="submit" value="Pay Now" class="btn btn-success" />
                    </div>
                </form> 
  </body>
</html>
