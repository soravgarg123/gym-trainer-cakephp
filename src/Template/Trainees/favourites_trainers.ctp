  <main class="animsition">
    <!--Main container sec start-->
    <div class="main_container">
    <!--Trainee top sec start-->
        <section class="trainee_top parallax-window" data-parallax="scroll" data-image-src="<?php echo $this->request->webroot; ?>images/trainee_top_bg.jpg">
            <div class="trainee_top_inner tr_grad">
                <div class="container">
                <div class="row">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="trainee_top_wrap">
                            <div class="trainee_img">
                            <form id="profile_form" method="post" enctype="multipart/form-data">
                            <?php
                                if($profile_details[0]['trainee_image'] != "")
                                { ?>
                                    <a class="example-image-link" href="<?php echo $this->Custom->getImageSrc('uploads/trainee_profile/'.$profile_details[0]['trainee_image']) ?>" data-lightbox="example-set" data-title="Click the right half of the image to move forward.">
                                    <img id="profile-img" style="width:200px;height:190px;" src="<?php echo $this->Custom->getImageSrc('uploads/trainee_profile/'.$profile_details[0]['trainee_image']) ?>" alt="img" class="img-responsive"></a>
                            <?php }
                                else
                                { ?>
                                    <img id="profile-img" style="width:200px;height:190px;" src="<?php echo $this->request->webroot; ?>img/default.png" alt="img" class="img-responsive">
                            <?php } ?>
                                <!-- <a class="upload_profile_img" href="javascript:void(0);"><input name="trainee_profile_img" id="trainee_profile_img" type="file"/><span class="fa fa-camera"></span> <span>Upload Photo</span></a> -->
                            </form>
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
                                    <a class="select_trainr gray_grad" title="Select a Trainer" href="<?php echo $this->request->webroot; ?>ourTrainers"><span class="fa fa-user"></span> Select a Trainer</a>
                                    <a href="<?php echo $this->request->webroot; ?>trainees/completeProfile" title="Edit Profile" class="hireme_btn gray_grad"><span class="fa fa-edit"></span> Edit Profile</a>
                                    <a href="<?php echo $this->request->webroot; ?>trainees/wallet" title="My Wallet" class="hireme_btn gray_grad"><span class="fa fa-google-wallet"></span> My Wallet</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
            </div>
        </section></br>
    <!--Trainee top  sec end--> 
        
     <section class="trainee_dash_body">
        <div class="container">
        <h3> My Favourite TrainR(s)</h3>
            <div class="row">
                <div class="col-sm-12">
                    <div class="meal_plan_sec">

                      <!-- Tab panes -->
                      <div class="tab-content">
                      <?php echo $this->Flash->render('edit') ?>
                        <div id="append_div">
                        <?php
                        if(!empty($trainer_details)) { ?>
                        <ul class="row">
                        <?php 
                            foreach($trainer_details as $t)
                            { ?>
                        <a href="<?php echo $this->request->webroot; ?>mytrainerProfile/<?php echo base64_encode($t['user_id']); ?>">
                        <li class="col-sm-4 col-md-3">
                                <div class="trainer_sec">
                                    <div class="trainer_img">
                                    <?php
                                        if($t['trainer_image'] != "")
                                        { ?>
                                            <img style="height:260px;width:100%" src="<?php echo $this->Custom->getImageSrc('uploads/trainer_profile/'.$t['trainee_image']) ?>" alt="img" class="img-responsive">
                                    <?php }
                                        else
                                        { ?>
                                            <img style="height:260px;width:100%" src="<?php echo $this->request->webroot; ?>img/default-user.png" alt="img" class="img-responsive">
                                    <?php } ?>
                                    </div>
                                    <div class="trainer_info">
                                        <p><strong><a style="color:white;" href="<?php echo $this->request->webroot; ?>mytrainerProfile/<?php echo base64_encode($t['user_id']); ?>"> Trainer : </strong><?php echo ucwords($t['trainer_name']); ?> </a></p>
                                        <p><strong>Location : </strong> <?php echo $t['city_name']; ?></p>
                                        <p><strong>Rank :</strong> Level 6</p>
                                        <a class="btn btn-default unfavourite" main="<?php echo base64_encode($t['favourite_id']); ?>" title="Click To Make Unfavourite" href="<?php echo $this->request->webroot; ?>trainees/unfavourite/<?php echo base64_encode($t['favourite_id']); ?>">Unfavourite</a></br></br>
                                    </div>
                                </div>
                            </li>
                        </a>
                        <?php } ?>
                        </ul> 
                        <?php } 
                        else { ?>
                            <div class="well"><center><h3>Data Not Found !</h3></center></div>
                        <?php } ?>
                        </div>
                       
                      </div>
                    
                    </div>
                </div>
            </div>
            
            
        </div>
     </section>   
        
    </div>
    <!--Main container sec end-->


