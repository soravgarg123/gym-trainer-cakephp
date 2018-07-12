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
                                                echo "0";
                                            }
                                            else
                                            {
                                                echo $total_wallet_ammount[0]['total_ammount'];
                                            }
                                        ?>
                                        <span>Your Wallet Balance</span>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            <div class="col-md-6 col-md-6">
                            	<div class="wallet_amount">
                                	<input type="number" min="1" class="form-control"  required  title="Please Enter Only Numbers" id="wallet_ammount" placeholder="Enter amount to be added in wallet">
                                </div>
                            </div>
                            <div class="col-md-3 col-md-3">
                            	<div class="add_money">
                                <a class="red_grad" id="add-money-btn" href="javascript:void(0);">Add funds to wallet</a>
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
                                            <th>S.No.</th>
                                            <th>Payment Type</th>
                                            <th>Transaction ID</th>
                                            <th>Amount</th>
                                            <th>Type</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                   <tbody>
                                       <?php $i = 1;
                                        foreach($wallet_txn as $wt) { ?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $wt['payment_type']; ?></td>
                                            <td><a href="<?php echo $this->request->webroot; ?>trainees/reportpdf?id=<?php echo $wt['id']; ?>" class="txns"><?php echo $wt['txn_id']; ?></a></td>
                                            <td>$<?php echo $wt['ammount']; ?></td>
                                            <td><?php echo $wt['txn_type']; ?></td>
                                            <td><?php echo $wt['status']; ?></td>
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
            var url = "<?php echo $this->request->webroot; ?>trainees/walletPayment/"+btoa(ammount);
            $('#add-money-btn').attr('href', url);
         }
        });
    });
</script>

<!-- Number Validation Script End -->

