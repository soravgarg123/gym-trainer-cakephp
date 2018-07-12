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
                            </div>
                            <a class="select_trainr gray_grad" title="Select a Trainer" href="<?php echo $this->request->webroot; ?>ourTrainers"><span class="fa fa-user"></span> Select a Trainer</a>
                            <a href="<?php echo $this->request->webroot; ?>trainees/completeProfile" title="Edit Profile" class="hireme_btn gray_grad"><span class="fa fa-edit"></span> Edit Profile</a>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </section>
    <!--Trainee top  sec end--> 

     <section class="trainee_dash_body">
     	<div class="container">
        
        	<div class="promo_code_wrap">
           <?php echo $this->Custom->successMsg(); ?>
                 <?php echo $this->Custom->errorMsg(); ?>
                 <?php echo $this->Custom->loadingImg(); ?>
                 <?php echo $this->Flash->render('cancel') ?>
                 <?php echo $this->Flash->render('success') ?>
                 <?php echo $this->Flash->render('pending') ?>
            	<div class="panel">
                  <div class="panel-heading">Promo Code</div>

                  <div class="panel-body">
                  		<table cellpadding="0" cellspacing="0" b border="0" class="table table-bordered">
                        	<thead>
                            	<tr>
                                <th>Plan Name</th>
                                <th>Session</th>
                                <th>Promo Code</th>
                                <th id="action_th">Action</th>
                                <th>Price</th>
                                </tr>
                            </thead>
                            <tbody>
                            	<tr>
                                <td><?php echo $sessions[0]['pc_name']; ?></td>
                                <td><?php echo $sessions[0]['ps_name']; ?> Session</td>
                                <td><input type="text" id="voucher_field" main="<?php echo base64_encode($sessions[0]['sess_id']); ?>" placeholder="Enter Promo code" class="form-control"/></td>
                                <td id="action_td"><button id="voucher_apply" class="btn btn-success">Apply</button></td>
                                <td>$<span id="session_price"><?php echo $sessions[0]['ps_price']; ?></span></td>
                                <input type="hidden" value="<?php echo $sessions[0]['ps_price']; ?>" class="sess_price" />
                                </tr>
                            </tbody>
                        </table>
                        <?php $this->request->session()->write('session_id', base64_encode($sessions[0]['sess_id'])); ?>
                  </div>
                  <div class="promo_footer text-right">
                        <a class="btn btn-primary" href="<?php echo $this->request->webroot;  ?>trainees/wallet" title="Add funds to wallet" >Add funds to wallet</a>
                        <button class="btn btn-primary" role="button" id="proces_pay" aria-expanded="false" aria-controls="proces_pay">Processed to pay</button>
                  </div>
                </div>
            </div>
            
            <div class="promo_code_wrap collapse" id="payment_div">
            	<div class="panel">
                  <div class="panel-heading">Purchase Plans</div>
                  <div class="panel-body">
                  <p>Total payment to be made : <span id="total_payment">$0</SPAN></p>  </br>
                  <h5><i class="fa fa-check"></i> Awesome ! You have sufficient balance in your wallet</h5></br>
                  <div class="row">
                    <div class="col-sm-3">
                      <div class="well plans_money">Money in your wallet <h4 id="current_wallet_money"><?php echo $total_wallet_ammount[0]['total_ammount']; ?></h4></div> 
                    </div> 
                    <div class="col-sm-1"> <h2 class="desh_center">-</h2></div>
                    <div class="col-sm-3">
                      <div class="well plans_money">Payment to be made <h4 id="total_payment">$0</h4></div>
                    </div>
                    <form method="post" action="<?php echo $this->request->webroot; ?>trainees/insertPurchasedPlan">
                    <input type="hidden" name="plan" value="<?php echo $sessions[0]['pc_name']; ?>">
                    <input type="hidden" name="session" value="<?php echo $sessions[0]['ps_name']; ?>">
                    <input type="hidden" name="main_price" value="<?php echo $sessions[0]['ps_price']; ?>">
                    <input type="hidden" name="service_fee" value="<?php echo $sessions[0]['pc_service_fee']; ?>">
                    <input type="hidden" name="price_after_voucher" class="sess_price" value="<?php echo $sessions[0]['ps_price']; ?>">
                    <input type="hidden" name="plan_id" value="<?php echo base64_encode($sessions[0]['sess_id']); ?>">
                    <div class="col-sm-5 add_money money_btn">
                    <button class="red_grad">Pay now</button>
                    </div>
                    </form>
                  </div>
                  
                  <p>Remaining balance <span id="remaining_ammount">$0</span></p>
                </div>
                </div>
            </div>
            
        </div>
     </section>   
        
    </div>
    <!--Main container sec end-->

<!-- Payment Section Start -->

<script type="text/javascript">
  $(document).ready(function(){
    $('#payment_div').hide();
    $('#proces_pay').click(function(){
    var ammount = parseFloat($('.sess_price').val());
    var wallet_ammount = parseFloat("<?php echo $total_wallet_ammount; ?>");
    if(ammount > wallet_ammount)
      {
        $('html, body').animate({ scrollTop: $(".promo_code_wrap").offset().top }, 1000);
        $("div#error_msg").html("<center><i class='fa fa-times'> Insufficient funds.  Please add personal session plans to your account to begin ! </i></center>").show();
        return false;
        
      }
    else
      {
        var remaining_amt = parseFloat(wallet_ammount - ammount);
        $('span#total_payment').text('$'+ammount);
        $('h4#total_payment').text('$'+ammount);
        $('h4#current_wallet_money').text('$'+wallet_ammount);
        $('span#remaining_ammount').text('$'+remaining_amt.toFixed(2));
        $('html, body').animate({ scrollTop: $(".red_grad").offset().top }, 1000);
        $('#payment_div').show();
      }
    
    
    });
  });
</script>

<!-- Payment Section End -->

<!-- Voucher Apply Script Start -->  

<script type="text/javascript">
  $(document).ready(function(){
    $('body').on('click','#voucher_apply',function(){
      var code = $('#voucher_field').val();
      $('#payment_div').hide();
      var session_id = $('#voucher_field').attr('main');
      $("div#success_msg,div#error_msg,img#loading-img").hide();

      if(code == "")
      {
        $("div#error_msg").html("<center><i class='fa fa-times'> Please Enter Promo Code ! </i></center>").show();
        return false;
      }
      $('img#loading-img').show();
      $.ajax({
            type: "POST",
            url: "<?php echo $this->request->webroot; ?>trainees/applyCoupon",
            data: {code:code, session_id:session_id},
            dataType:"json",
            success:function(data){
              $('img#loading-img').hide();
              if(data.voucher_status == "invalid" && data.voucher_data == "")
              {
                $("div#error_msg").html("<center><i class='fa fa-times'> Please Enter Valid Promo Code ! </i></center>").show();
              }

              if(data.voucher_status == "success" && data.voucher_data != "")
              {
                var voucherData = data.voucher_data;
                var disscount = parseFloat(voucherData[0]['voucher_ammount']);
                var session_price = parseFloat($('span#session_price').text());
                var final_price;
                if(voucherData[0]['voucher_type'] == "Percent"){
                  var deduct_discount = parseFloat(session_price/disscount);
                  final_price = parseFloat(session_price - deduct_discount);
                }
                else{
                  final_price = parseFloat(session_price - disscount);
                }
                $('span#session_price').text(final_price.toFixed(2));
                $('.sess_price').val(final_price.toFixed(2));
                $('#final_paypal_ammount,#paypal_ammount,#money_order_ammount').val(final_price.toFixed(2));
                $('#voucher_field').val("")
                $('#voucher_apply, th#action_th, td#action_td').remove();
                $('#voucher_field').attr('readonly','true');
                $("div#success_msg").html("<center><i class='fa fa-check'> Promo code Applied Successfully </i></center>").show();
              }

            }
      });
    });
  });
</script>

<!-- Voucher Apply Script End -->
