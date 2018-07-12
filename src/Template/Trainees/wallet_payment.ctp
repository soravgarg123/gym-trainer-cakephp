  <main class="animsition">
    <!--Main container sec start-->
    <div class="main_container">
    <!--Trainee top sec start-->
      <section class="trainee_top parallax-window" data-parallax="scroll" data-image-src="<?php echo $this->request->webroot; ?>images/trainee_top_bg.jpg">
          <div class="trainee_top_inner tr_grad">
            <div class="container">
              <div class="row">
                  <div class="col-sm-12">
                      <div class="trainee_top_wrap">
                          <div class="trainee_img">
                              <?php
                                if($profile_details[0]['trainee_image'] != "")
                                { ?>
                                    <a class="example-image-link" href="<?php echo $this->Custom->getImageSrc('uploads/trainee_profile/'.$profile_details[0]['trainee_image']) ?>" data-lightbox="example-set" data-title="Click the right half of the image to move forward.">
                                    <img style="width:200px;height:190px;" src="<?php echo $this->Custom->getImageSrc('uploads/trainee_profile/'.$profile_details[0]['trainee_image']) ?>" alt="img" class="img-responsive"></a>
                            <?php }
                                else
                                { ?>
                                    <img style="width:200px;height:190px;" src="<?php echo $this->request->webroot; ?>img/default.png" alt="img" class="img-responsive">
                            <?php } ?>
                            </div>
                            <div class="trainee_detail">
                              <h1 class="trainee_name"><?php echo $profile_details[0]['trainee_name']; ?></h1>
                                <h3 class="trainee_rank">Current Weight : <span><?php echo $profile_details[0]['trainee_current_weight']; ?> lbs</span></h3>
                                <h3 class="trainee_rank">My Goal : <span><?php echo $profile_details[0]['trainee_goal']; ?> lbs</span></h3>
                                <nav class="trainee_streams">
                                  <ul>
                                    <?php $skills =  $profile_details[0]['trainee_skills']; 
                                        $skillArr = explode(",", $skills);
                                        if(!empty($skillArr)) {
                                        foreach($skillArr as $s) { ?>
                                        <li><a href="javascript:void(0);" class="red_grad" title="<?php echo $s; ?>"><?php echo $s; ?> </a></li>
                                        <?php } } ?>
                                    </ul>
                                </nav>
                               <nav class="trainee_social_link">
                                    <ul>
                                    <?php
                                        if(!empty($profile_details[0]['trainee_linkedin'])) { ?>
                                    <li><a target="_blank" href="<?php echo $profile_details[0]['trainee_linkedin']; ?>" title="Linked In" class="linkedin_grad"><span class="fa fa-linkedin"></span></a></li>
                                    <?php } ?>
                                    <?php
                                        if(!empty($profile_details[0]['trainee_facebook'])) { ?>
                                    <li><a target="_blank" href="<?php echo $profile_details[0]['trainee_facebook']; ?>" title="Facebook" class="facebook_grad"><span class="fa fa-facebook"></span></a></li>
                                    <?php } ?>
                                    <?php
                                        if(!empty($profile_details[0]['trainee_twitter'])) { ?>
                                    <li><a target="_blank" href="<?php echo $profile_details[0]['trainee_twitter']; ?>" title="Twitter" class="twitter_grad"><span class="fa fa-twitter"></span></a></li>
                                    <?php } ?>
                                    <?php
                                        if(!empty($profile_details[0]['trainee_belibitv'])) { ?>
                                    <li><a target="_blank" href="<?php echo $profile_details[0]['trainee_belibitv']; ?>" title="BelibiTv" class="belibitv_grad"><span class="belivitv_icon"><img src="<?php echo $this->request->webroot; ?>img/favicon.png"></span></a></li>
                                    <?php } ?>
                                    <?php
                                        if(!empty($profile_details[0]['trainee_google'])) { ?>
                                    <li><a target="_blank" href="<?php echo $profile_details[0]['trainee_google']; ?>" title="Google" class="google_grad"><span class="fa fa-google-plus"></span></a></li>
                                    <?php } ?>
                                    <?php
                                        if(!empty($profile_details[0]['trainee_instagram'])) { ?>
                                    <li><a target="_blank" href="<?php echo $profile_details[0]['trainee_instagram']; ?>" title="Instagram" class="instagram_grad"><span class="fa fa-instagram"></span></a></li>
                                    <?php } ?>
                                    
                                    
                                    </ul>
                                </nav>
                                <div class="profile_btn_main">
                                    <a class="select_trainr gray_grad" title="Select a Trainer" href="<?php echo $this->request->webroot; ?>trainees/searchTrainers"><span class="fa fa-user"></span> Select a Trainer</a>
                                    <a href="<?php echo $this->request->webroot; ?>trainees/completeProfile" title="Edit Profile" class="hireme_btn gray_grad"><span class="fa fa-edit"></span> Edit Profile</a>
                                    <a href="<?php echo $this->request->webroot; ?>trainees/wallet" title="My Wallet" class="hireme_btn gray_grad"><span class="fa fa-google-wallet"></span> My Wallet</a>
                                </div>
                            </div>
                           
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </section>
    <!--Trainee top  sec end--> 

     <section class="trainee_dash_body">
     	<div class="container">
            <div class="promo_code_wrap" id="payment_div">
            	<div class="panel">
                  <div class="panel-heading">Payment Methods</div>
                  <div class="panel-body">
                  		<div class="bank_method_wrap">
                        	 <ul class="bank_metho_tabs" role="tablist">
                                <li role="presentation" class="active"><a href="#paypal" aria-controls="paypal" role="tab" data-toggle="tab"><span class="fa fa-paypal"></span>Paypal</a></li>
                                <li role="presentation"><a href="#amazon" aria-controls="amazon" role="tab" data-toggle="tab"><span class="fa fa-amazon"></span>Amazon</a></li>
                                <li role="presentation"><a href="#credit" aria-controls="credit" role="tab" data-toggle="tab"><span class="fa fa-credit-card"></span>Credit Card</a></li>
                                <li role="presentation"><a href="#money" aria-controls="money" role="tab" data-toggle="tab"><span class="fa fa-money"></span>Money Order</a></li>
                              </ul>

                              <!-- Tab panes -->
                              <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="paypal">
                                	  <div class="form-group">
                                      <input type="text" id="final_paypal_ammount" value="<?php echo base64_decode($ammount); ?>" readonly class="form-control" placeholder="Ammount">
                                    </div>
                                    <div class="form-group">
                                      <input type="text" class="form-control" value="USD" readonly placeholder="Currency">
                                    </div>
                                    <?php
                                      $action = "";
                                      $bussiness_id = "";
                                      if($_SERVER['HTTP_HOST'] == "localhost" || $_SERVER['HTTP_HOST'] == "127.0.0.1"){
                                          $action = "https://www.sandbox.paypal.com/cgi-bin/webscr";
                                          $bussiness_id = "sourav-facilitator@mobiwebtech.com";
                                      }else{
                                          $action = "https://www.sandbox.paypal.com/cgi-bin/webscr";
                                          $bussiness_id = "sourav-facilitator@mobiwebtech.com";
                                      }
                                    ?>
                                    <form action="<?php echo PAYPAL_FORM_LIVE_URL; ?>" method="post">
                                      <input type="hidden" name="cmd" value="_xclick" />
                                      <input type="hidden" name="charset" value="utf-8" />
                                      <input type="hidden" name="business" value="<?php echo PAYPAL_LIVE_BUSINESS_ID; ?>" />
                                      <input type="hidden" name="item_name" value="virtualtrainr.com" />
                                      <input type="hidden" name="item_number" value="1000<?php echo $order_count + 1; ?>" />
                                      <input type="hidden" id="paypal_ammount" name="amount" value="<?php echo base64_decode($ammount); ?>" />
                                      <input type="hidden" name="currency_code" value="USD" />
                                      <input type="hidden" name="return" value="<?php echo $this->request->webroot; ?>trainees/successPayment" />
                                      <input type="hidden" name="custom" value="front" />
                                      <input type="hidden" name="cancel_return" value="<?php echo $this->request->webroot; ?>trainees/cancelPayment" />
                                      <input type="hidden" name="bn" value="Business_BuyNow_WPS_SE" />
                                       <div class="form-group text-right">
                                       <button class="btn submit_btn" type="submit">Pay</button>
                                      </div>
                                  </form>
                                     
                                </div>
                                <div role="tabpanel" class="tab-pane" id="amazon">
                                 <?php 
                                    $token = md5(uniqid(mt_rand(), true));
                                    $this->request->session()->write('token',$token); 
                                  ?>
                                 <input type="hidden" name="csrf" id="csrf" value="<?php echo $this->request->session()->read('token'); ?>" >
                                 <div class="form-group">
                                      <input type="text" id="amazon_amount" value="<?php echo base64_decode($ammount); ?>" readonly class="form-control" placeholder="Ammount">
                                  </div>
                                  <div class="form-group">
                                      <input type="text" class="form-control" value="USD" readonly placeholder="Currency">
                                  </div>
                                 <div id="AmazonPayButton"></div>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="credit">
                                  <form name="form1" method="post" action="<?php echo $this->request->webroot; ?>creditcard.php">
                                      <div class="form-group">
                                        <input type="number" required name="card_no" class="form-control" placeholder="Card No.">
                                      </div>
                                      <div class="form-group">
                                        <input type="number" required name="expiry_date" class="form-control" placeholder="Expiry Date (MMYY)">
                                      </div>
                                      <div class="form-group">
                                        <input type="number" required name="card_cvv" class="form-control" placeholder="CVV">
                                      </div>
                                      <div class="form-group">
                                        <input type="text" required id="total_amt" name="total_amt" value="<?php echo base64_decode($ammount); ?>" readonly class="form-control" placeholder="Ammount">
                                      </div>
                                      <div class="form-group">
                                        <input type="text" class="form-control" value="USD" readonly placeholder="Currency">
                                      </div>
                                      <div class="form-group text-right">
                                        <button class="btn submit_btn" type="submit">Pay</button>
                                      </div>
                                  </form>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="money">
                                <form method="post" action="<?php echo $this->request->webroot; ?>trainees/moneyOrder">
                                  <div class="form-group">
                                  <textarea class="form-control" rows="4">You Tag Media & Business Solutions, Inc &#013;&#010;1950 Broad Street, Unit 209 Regina, SK S461X6 Canada</textarea>
                                  </div>
                                  <div class="form-group">
                                      <input type="text" id="money_order_ammount" readonly name="money_order_ammount" value="<?php echo base64_decode($ammount); ?>" class="form-control" placeholder="Money Order Ammount">
                                  </div>
                                  <div class="form-group">
                                      <input type="text" class="form-control" value="USD" readonly placeholder="Currency">
                                  </div>
                                  <div class="form-group">
                                      <input type="text" id="order_no" required name="order_no" class="form-control" placeholder="Money Order No.">
                                  </div>
                                  <div class="form-group text-right">
                                       <button class="btn submit_btn" type="submit">Pay</button>
                                  </div>
                                  </form>
                                </div>
                              </div>
                              <div class="clearfix"></div>
                        </div>
                  </div>
                </div>
            </div>
            
        </div>
     </section>   
        
    </div>
    <!--Main container sec end-->

<!-- Amazon Payment Script Start -->
  
  <script type="text/javascript">
    OffAmazonPayments.Button("AmazonPayButton", "AE2I6Q8BHJTXA", {
            type: "hostedPayment",
            hostedParametersProvider: function(done) {
                $.getJSON("<?php echo $this->request->webroot; ?>trainees/walletAmazonPayment", {
                    amount: parseInt($("#amazon_amount").val()),
                    currencyCode: 'USD',
                    sellerNote: "VirtualTrainr.com",
                    csrf:$("#csrf").val()
                }, function(data) {
                    done(data);
                })
            },
            onError: function(errorCode) {
                console.log(errorCode.getErrorCode() + " " + errorCode.getErrorMessage());
            }
        });
  </script>

<!-- Amazon Payment Script End -->

