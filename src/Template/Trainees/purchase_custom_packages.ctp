<?php include "trainee_dashboard.php"; ?>

		<section class="payment_details custom_packages">
    <form method="post" onsubmit="return termsCheck();" action="<?php echo $this->request->webroot; ?>trainees/customPackageOrder">
         <div class="top_bar_wrap">
            <div class="container">
              <div class="row">
                <div class="col-md-12 col-sm-12">
                  <div class="tbw_text">
                  <i class="fa fa-usd"></i> confirm details & payment 
  
                  </div>
                  <div class="step_box">
                    Step 2 of 3
                  </div>
              </div>
             </div>
           </div>
         </div>
         <div class="container">
              <div class="row">
                <div class="col-md-12 col-sm-12">
                  <div class="head_row">
                    <div class="session_user">
                      <div class="img_user"><img src="<?php echo $this->Custom->getImageSrc('uploads/trainer_profile/'.$trainer_details[0]['trainer_image']) ?>" class="img-responsive"></div> <?php if(!empty($trainer_details)) echo ucwords($trainer_details[0]['trainer_name'] ." ".$trainer_details[0]['trainer_lname']); ?>
                    </div>
                  </div>
              </div>
            </div>
               <div class="row">
                  <div class="col-md-6 col-sm-6">
                        <div class="session_setails_sec custom_packages_sec">
                          <div class="heading_payment_main">
                            <h2> Package Details</h2>
                          </div>
                           
                           <ul class="session_content">
                              <li>
                                Package Name : <span><?php echo $custom_plan_details[0]['package_name'];?></span>
                                      
                              </li>
                              <li>
                                Description : <span> <?php echo $custom_plan_details[0]['package_discription'];?></span>
                                      
                              </li>
                             
                            </ul>
                        </div>
                       <div class="price_box">
                         <div class="heading_payment_main">
                          <h5>price</h5>
                          </div>
                          <div class="price_box_content">
                             <ul class="session_content">
                              <?php 
                                $package_price  = $custom_plan_details[0]['package_price'];
                                if(!empty($service_fee_details)){
                                  $service_fee = $service_fee_details[0]['txn_fee'];
                                }else{
                                  $service_fee = '0';
                                }
                                $finalServiceFee = round(($package_price * $service_fee) / 100,2);
                              ?>
                               <li>
                                  <?php echo $custom_plan_details[0]['package_name'];?><span>$<?php echo $custom_plan_details[0]['package_price'];?></span></li>
                               
                               
                               <li>
                                  Service Fee <div class="button_in"> <div class="pop_over_main"> <span class="icon_block question_icon service_fee_btn"><i class="fa fa-question"></i></span>
                                  <div class="pop_over"  id="service_fee_po">
                                     <h4>service fee</h4>
                                     <p>service fees let us provide 24 hours support that you love</p>
                                     <a href="javascript:void(0);" class="btn_okay">okay</a>
                                 </div>
                               </div>
                             </div>
                              <span>$<?php echo $finalServiceFee; ?></span></li>
                              <li style="display:none;" id="promo_code_discount_label">Promo Code Discount <span id="promo_code_discount_price"></span></li>
                                <li>
                                  have a promo code <div class="pop_over_main"><i class="fa fa-question icon_block question_icon promo_code_btn"></i>
                                  <div class="pop_over" id="promo_code_po">
                                     <h4>Promo Code</h4>
                                     <p>Use Virtual TrainR Promo Code for maximum discounts</p>
                                     <a href="javascript:void(0);" class="btn_okay">okay</a>
                                 </div>
                                 </div>
                                  <span title="Click here to apply voucher" id="code-btn">click here</span>
                                  <span id="voucher-section" style="display:none;"><input type="text" class="form-control pop-overbox" id="voucher-code" placeholder="Voucher Code">
                                  <div class="modify_date_time1 save_cancel_section voucher_cancel">
                                    <div class="icon_block" id="cancel_voucher_btn"  title="Cancel"><i class="fa fa-times"></i> </div>
                                    <div class="icon_block" id="apply_voucher_btn" title="Apply"><i class="fa fa-check"></i> </div>
                                  </div>
                                  </span>
                                  <span id="applied_voucher" style="display:none;">
                                    <button type="button" id="applied_promo_code" title="Promo Code Applied" class="btn_applied"> <i class="fa fa-check-circle"></i></button>
                                    <button type="button" id="remove_applied_code" title="Remove Promo Code" class="btn_applied">Remove <i class="fa fa-times-circle"></i></button>
                                  </span>
                                </li>
                               <li>
                                  total<span class="red_color" id="total_final_price">$<?php echo round($package_price + $finalServiceFee,2); ?></span></li>
                                  </ul>
                          </div>
                       </div>
                  </div>
                  <div class="col-md-6 col-sm-6">
                    <div class="right_session_bar">
                      <div class="heading_payment_main">
                          </div>
                             <div class="price_box_content  session_content">
                               <ul class="paypal_list">
                               <li>
                                  Funds In My Wallet:  <span class="red_color">
                                    $<?php
                                        if(empty($total_wallet_ammount)){
                                            echo "0";
                                        }
                                        else
                                        {
                                            echo $total_wallet_ammount[0]['total_ammount'];
                                        }
                                    ?>
                                  </span></li>
                               
                               <li>
                                  Paypal <span><a href="javascript:void(0);"><img src="<?php echo $this->request->webroot; ?>images/paypal.png" class="img-responsive"></a></span></li>
                               <li>
                                  Amazon Payments <span><a href="javascript:void(0);"><img src="<?php echo $this->request->webroot; ?>images/amezon.png" class="img-responsive"></a></span></li>
                               
                                  </ul>
                                  <!-- <div class="ad_credit_card">
                                    
                                     <div class="content_ad_credit_card">
                                       <p>Share details about yourself, your preferences, and what you love about <?php if(!empty($trainer_details)) echo ucwords($trainer_details[0]['trainer_name'] ." ".$trainer_details[0]['trainer_lname']); ?> profile</p>


                                     </div>
                                  </div> -->
                              </div>
                              <input type="hidden" name="total_amount" id="total_amount" value="<?php echo $package_price + $finalServiceFee; ?>">
                              <input type="hidden" name="package" value="<?php echo base64_encode($custom_plan_details[0]['package_id']); ?>">
                              <input type="hidden" name="coupon" id="coupon" value="<?php echo base64_encode('0'); ?>">
                          <div class="agree_message_wrap">
                             <textarea class="form-control" name="trainer_message" placeholder="Please leave any special request/notes for your trainer here"></textarea>
                             <div class="heading_payment_main">
                                </div>
                                <div class="check_box  session_content">
                                 <div class="checkbox">
                                  <input type="checkbox" id="test1" class="terms_cb" />
                                  <label for="test1">I agree with all terms and conditions. <a class="terms-link" href="<?php echo $this->request->webroot; ?>terms" target="_blank">Terms & Conditions</a></label>    
                                 </div>
                                </div>
                          </div>
                  </div>
                  </div>
                  <div class="col-md-12 col-sm-12">
                    <div class="Confirm_btn">

                      <button type="submit">Confirm & Pay</button>
                    </div>
                  </div>
               </div>
            </div>
          </form>
        </section>

<script type="text/javascript">
  $(document).ready(function(){

    $('body').on('click','#code-btn',function(){
      $('#code-btn').hide();
      $('#voucher-section').show();
    });

    $('body').on('click','#cancel_voucher_btn',function(){
      $('#code-btn').show();
      $('#voucher-section').hide();
    });  

  });
</script>

<!-- Voucher Apply Script Start -->  

<script type="text/javascript">
  $(document).ready(function(){
    $('body').on('click','#apply_voucher_btn',function(){
      var code = $('#voucher-code').val().trim();
      hidePopover();
      if(code == "")
      {
        showPopover('top','Please enter promo code !');
        return false;
      }
      $.ajax({
            type: "POST",
            url: "<?php echo $this->request->webroot; ?>trainees/applyCoupon",
            data: {code:code},
            dataType:"json",
            success:function(data){
              if(data.voucher_status == "invalid" && data.voucher_data == "")
              {
                showPopover('top','Invalid promo code !');
              }
              if(data.voucher_status == "success" && data.voucher_data != "")
              {
                $('#voucher-code').val("");
                var voucherData = data.voucher_data;
                var disscount = parseFloat(voucherData[0]['voucher_ammount']);
                var session_price = parseFloat($('#total_amount').val());
                var final_price;
                if(voucherData[0]['voucher_type'] == "Percent"){
                  var deduct_discount = parseFloat(session_price/disscount).toFixed(2);
                  final_price = parseFloat(session_price - deduct_discount).toFixed(2);
                }
                else{
                  var deduct_discount = disscount.toFixed(2);
                  final_price = parseFloat(session_price - disscount).toFixed(2);
                }
                $('#coupon').val(btoa(voucherData[0]['id']));
                $('#total_amount').val(final_price);
                $('#total_final_price').text("$"+final_price);
                $('#applied_promo_code').html(code + " <i class='fa fa-check-circle'></i>");
                $('#promo_code_discount_price').text("$"+deduct_discount);
                $('#code-btn,#voucher-section').hide();
                $('#applied_voucher,#promo_code_discount_label').show();
            }
          }
      });
    });
  });
</script>

<!-- Voucher Apply Script End -->

<!-- Voucher Remove Script Start -->

<script type="text/javascript">
  $(document).ready(function(){
    $('body').on('click','#remove_applied_code',function(){
      var amount = "<?php echo $package_price + $finalServiceFee; ?>";
      $('#total_amount').val(amount);
      $('#promo_code_discount_price').text("");
      $('#total_final_price').text("$"+amount);
      $('#code-btn').show();
      $('#coupon').val(btoa('0'));
      $('#applied_voucher,#promo_code_discount_label').hide();
    }); 
    $('body').on('click','.btn_okay',function(){
      var data = $(this).parent().css('display','none');
    });
    $('body').on('mouseover','.service_fee_btn',function(){
      $('#service_fee_po').css('display','block');
    });
    $('body').on('mouseover','.promo_code_btn',function(){
      $('#promo_code_po').css('display','block');
    });
  });
  function termsCheck()
  {
    if (!$('input.terms_cb').is(':checked')){
      showAlert('error','Error','Please accept terms & conditions');
      return false;
    }else{
      return true;
    }
  }
</script>

<!-- Voucher Remove Script End -->

        
