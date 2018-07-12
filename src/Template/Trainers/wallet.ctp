<?php include "trainer_dashboard.php"; ?>
		
     <section class="wallet_dash_body">
     	<div class="container">
        	<div class="row">
            	<div class="col-md-12 col-sm-12">
                <?php echo $this->Flash->render('success') ?>
                <?php echo $this->Custom->errorMsg(); ?>
                	<div class="wallet_info">
                    	<div class="row">
                        	<div class="col-md-3 col-md-3">
                            	<div class="price_walet">
                           	    	<div class="walet_icn">
                                    	<img src="<?php echo $this->request->webroot; ?>images/wallet.png" class="img-responsive">
                                    </div>
                                    <div class="price_right">
                                    	$<?php
                                            if(empty($total_wallet_ammount)){
                                                $wallet_amt =  "0";
                                            }
                                            else
                                            {
                                                $wallet_amt = round($total_wallet_ammount[0]['total_ammount'],2);
                                            }
                                            echo $wallet_amt;
                                        ?>
                                        <span>Your Wallet Balance</span>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            <form method="post" action="<?php echo $this->request->webroot; ?>trainers/withdrawRequest">
                            <div class="col-md-9 col-md-9">
                            	<div class="wallet_amount">
                                	<input type="number" name="withdraw_amount" min="1" class="form-control"  required  title="Please Enter Only Numbers" id="wallet_ammount" placeholder="Enter amount to be withdraw" value="<?php echo $wallet_amt; ?>" max="<?php echo $wallet_amt; ?>">
                                </div>
                            </div>
                            </div>
                           <div class="row">
                          
                            <div class="col-md-9 col-md-9 col-md-offset-3 col-sm-offset-3 ">
                              <div class="transaction_date_wrap withraw_amount">
                               <div class="form-group">
                                <input type="radio" value="0" name="payment_type" id="f-option" class="payment-type" main="paypal_email" checked>
                                  <label for="f-option">Paypal</label>
                                  <div class="check"><div class="inside"></div></div>
                                  </div>
                               <div class="form-group">
                                <input type="radio" value="1" name="payment_type" class="payment-type" main="amazon_email" id="f-option5">
                                  <label for="f-option5">Amazon</label>
                                  <div class="check"><div class="inside"></div></div>
                                </div>
                             <span><input type="text" readonly class="form-control" id="payment-id" value="<?php echo $profile_details[0]['paypal_email']; ?>"></span>
                            </div>

                        </div>
                        <div class="col-md-9 col-md-9 col-md-offset-3 col-sm-offset-3">
                            <div class="add_money">
                            <button class="red_grad" id="add-money-btn">Withdraw Amount</button>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
               
            <div class="row">
            	<div class="col-md-12 col-sm-12">
                	<div class="wallet_tab">
                    	
                      <!-- Nav tabs -->
                      <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Latest Transactions*</a></li>
                      </ul>
                    
                      <!-- Tab panes -->
                      <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="home">
                        	<div class="transaction_table">
                            	 <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Transaction ID</th>
                                            <th>Transaction Name</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                   <tbody>
                                       <?php $i = 1;
                                        foreach($wallet_txn as $wt) { ?>
                                        <tr>
                                            <td><?php echo $wt['txn_id']; ?></td>
                                            <td><?php echo $wt['txn_name']; ?></td>
                                            <td>$<?php echo $wt['total_amount'] - ($wt['administration_fee'] + $wt['service_fee']); ?></td>
                                            <td><?php echo ($wt['status'] == 0) ? "Success" : "Failed"; ?></td>
                                            <td><?php echo date('d F, Y', strtotime($wt["added_date"])); ?></td>
                                        </tr>
                                       <?php $i++; } ?>
                                   </tbody>
                                </table>
                            </div>
                        </div>
                      </div>
                      
                    </div>
                </div>
            </div>
            
        </div>
     </section>   
        
    </div>
    <!--Main container sec end-->

<!-- Number Validation Script Start -->

<script type="text/javascript">
    $(document).ready(function(){

      $('#add-money-btn').click(function(){
       var ammount = $('#wallet_ammount').val();
       var number = /^\d*[0-9]\d*$/;  // for positive integer numbers only

      if(!number.test(ammount.trim()) || ammount == "" || ammount == 0)
       {
          $("div#error_msg").html("<center><i class='fa fa-times'> Please enter numeric value to continue. </i></center>").show();
          return false;
       }
      else
       {
          
       }
      });

      $('body').on('change','.payment-type',function(){
        var type = $(this).attr('main');
        var emailid = "";
        switch (type) {
            case "paypal_email":
                emailid = "<?php echo $profile_details[0]['paypal_email']; ?>";
                break;
            case "amazon_email":
                emailid = "<?php echo $profile_details[0]['amazon_email']; ?>";
                break;
            default: 
                emailid = "";
        }
        $('#payment-id').val(emailid);
      });

    });
</script>

<!-- Number Validation Script End -->
