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
                                if($trainee_detail[0]['trainee_image'] != "")
                                { ?>
                                    <a class="example-image-link" href="<?php echo $this->Custom->getImageSrc('uploads/trainee_profile/'.$trainee_detail[0]['trainee_image']) ?>" data-lightbox="example-set" data-title="Click the right half of the image to move forward.">
                                    <img style="width:200px;height:190px;" src="<?php echo $this->Custom->getImageSrc('uploads/trainee_profile/'.$trainee_detail[0]['trainee_image']) ?>" alt="img" class="img-responsive"></a>
                            <?php }
                                else
                                { ?>
                                    <img style="width:200px;height:190px;" src="<?php echo $this->request->webroot; ?>img/default.png" alt="img" class="img-responsive">
                            <?php } ?>
                            </div>
                            <div class="trainee_detail">
                            	<h1 class="trainee_name"><?php echo ucwords($trainee_detail[0]['trainee_name']); ?></h1>
                                <h3 class="trainee_rank">Current Weight : <span><?php echo $trainee_detail[0]['trainee_current_weight']; ?> lbs</span></h3>
                                <h3 class="trainee_rank">My Goal : <span><?php echo $trainee_detail[0]['trainee_goal']; ?> lbs</span></h3>
                                <nav class="trainee_streams">
                                	<ul>
                                    <?php $skills =  $trainee_detail[0]['trainee_skills']; 
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
                                        if(!empty($trainee_detail[0]['trainee_linkedin'])) { ?>
                                    <li><a target="_blank" href="<?php echo $trainee_detail[0]['trainee_linkedin']; ?>" title="Linked In" class="linkedin_grad"><span class="fa fa-linkedin"></span></a></li>
                                    <?php } ?>
                                    <?php
                                        if(!empty($trainee_detail[0]['trainee_facebook'])) { ?>
                                    <li><a target="_blank" href="<?php echo $trainee_detail[0]['trainee_facebook']; ?>" title="Facebook" class="facebook_grad"><span class="fa fa-facebook"></span></a></li>
                                    <?php } ?>
                                    <?php
                                        if(!empty($trainee_detail[0]['trainee_twitter'])) { ?>
                                    <li><a target="_blank" href="<?php echo $trainee_detail[0]['trainee_twitter']; ?>" title="Twitter" class="twitter_grad"><span class="fa fa-twitter"></span></a></li>
                                    <?php } ?>
                                    <?php
                                        if(!empty($trainee_detail[0]['trainee_belibitv'])) { ?>
                                    <li><a target="_blank" href="<?php echo $trainee_detail[0]['trainee_belibitv']; ?>" title="BelibiTv" class="belibitv_grad"><span class="belivitv_icon"><img src="<?php echo $this->request->webroot; ?>img/favicon.png"></span></a></li>
                                    <?php } ?>
                                    <?php
                                        if(!empty($trainee_detail[0]['trainee_google'])) { ?>
                                    <li><a target="_blank" href="<?php echo $trainee_detail[0]['trainee_google']; ?>" title="Google" class="google_grad"><span class="fa fa-google-plus"></span></a></li>
                                    <?php } ?>
                                    <?php
                                        if(!empty($trainee_detail[0]['trainee_instagram'])) { ?>
                                    <li><a target="_blank" href="<?php echo $trainee_detail[0]['trainee_instagram']; ?>" title="Instagram" class="instagram_grad"><span class="fa fa-instagram"></span></a></li>
                                    <?php } ?>
                                    
                                    
                                    </ul>
                                </nav>
                                <?php
                                    $session = $this->request->session();
                                    $user = $session->read('Auth.User');
                                if(!empty($user) && $user['user_type'] == "trainee"){ ?>
                                <div class="profile_btn_main">
                                    <a class="select_trainr gray_grad" title="Select a Trainer" href="<?php echo $this->request->webroot; ?>trainees/searchTrainers"><span class="fa fa-user"></span> Select a Trainer</a>
                                    <a href="<?php echo $this->request->webroot; ?>trainees/completeProfile" title="Edit Profile" class="hireme_btn gray_grad"><span class="fa fa-edit"></span> Edit Profile</a>
                                    <a href="<?php echo $this->request->webroot; ?>trainees/wallet" title="My Wallet" class="hireme_btn gray_grad"><span class="fa fa-google-wallet"></span> My Wallet</a>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </section>
    <!--Trainee top  sec end--> 
		
     <section class="trainee_dash_body">
     	<div class="container trainee_profile_wrap">
        	
        	<div class="row">
            	<div class="col-sm-2">
                	
                    <div class="trainee_tabs_sect">
                    	  <h3>Trainee Profile</h3>
                    	  <!-- Nav tabs -->
                          <ul class="nav_tabs">
                            <li class="active"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">My Profile</a></li>
                            <li><a href="#about" aria-controls="about" role="tab" data-toggle="tab">About Me</a></li>
                            <li><a href="#photos" aria-controls="photos" role="tab" data-toggle="tab">Photos & Videos</a></li>
                          </ul>
                    </div>
                    
                </div>
                <div class="col-sm-10">
                	<div class="trainee_tab_content">
                    	  <!-- Tab panes -->
                          <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="profile">
                             <h3 class="trai_title_sect">My Profile</h3>  
                            	<div class="row">
                                	<div class="col-sm-6">
                                    
                                    	<div class="infoSummary">
                                            <ul>
                                                <li><span>Real Name</span><?php echo ucwords($trainee_detail[0]['trainee_name']." ".$trainee_detail[0]['trainee_lname']); ?></li>
                                                <li><span>Email Id</span><div><?php echo $trainee_detail[0]['trainee_email']; ?></div></li>
                                                <li><span>Age</span><div><?php echo $trainee_detail[0]['trainee_age']; ?></div></li>
                                                <li><span>Gender</span><div><?php echo ucwords($trainee_detail[0]['trainee_gender']); ?></div></li>
                                                <li><span>Country</span><?php echo $trainee_detail[0]['country_name']; ?></li>
                                                <li><span>State</span><?php echo $trainee_detail[0]['state_name']; ?></li>
                                                <li><span>City</span><?php echo $trainee_detail[0]['city_name']; ?></li>
                                            </ul>
                                            
                                        </div>
                                        
                                        
                                    </div>
                                    <div class="col-sm-6">
                                    	
                                        <div class="trainne_widget_section">
                                        	<h4>&nbsp;&nbsp;Current Body Composition</h4>
                                            <div class="trai_widg_body">
                                            	<div class="comp_small_widget">
                                                	<h5>Current Weight</h5>
                                                    <span><?php echo (!empty($trainee_detail[0]['trainee_current_weight'])) ? $trainee_detail[0]['trainee_current_weight'] : "0" ?></span><small>Lbs.</small>
                                                </div>
                                                <div class="comp_small_widget">
                                                	<h5>Overall Goal</h5>
                                                    <span><?php echo (!empty($trainee_detail[0]['trainee_goal'])) ? $trainee_detail[0]['trainee_goal'] : "0" ?></span><small>Lbs.</small>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="about">
                                <h3 class="trai_title_sect">About Me</h3>
                                 <p style="text-align: justify;"><?php echo $trainee_detail[0]['trainee_aboutme']; ?></p>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="photos">
                            	
                                  <!-- Nav tabs -->
                                  <ul class="tai_sub_tab" role="tablist">
                                    <li role="presentation" class="active"><a href="#photos1" aria-controls="photos" role="tab" data-toggle="tab">Progress Photos</a></li>
                                    <li role="presentation"><a href="#gallery" aria-controls="gallery" role="tab" data-toggle="tab">Gallery Photos</a></li>
                                    <li role="presentation"><a href="#videos" aria-controls="videos" role="tab" data-toggle="tab">Videos</a></li>
                                    
                                  </ul>
                                
                                  <!-- Tab panes -->
                                  <div class="tab-content tai_sub_cont">
                                    <div role="tabpanel" class="tab-pane active" id="photos1">
                                        <div class="photo_post_list">
                                            <ul>
                                            <?php $i = 1;
                                                foreach($progress_img as $pi)
                                                    { ?>
                                                <li>
                                                    <a class="example-image-link" href="<?php echo $this->Custom->getImageSrc('uploads/trainee_progress/'.$pi['abi_image_name']) ?>" data-lightbox="example-set" data-title="Click the right half of the image to move forward.">
                                                    <img style="height:170px;" class="example-image img-responsive" src="<?php echo $this->Custom->getImageSrc('uploads/trainee_progress/'.$pi['abi_image_name']) ?>" alt=""/></a>
                                                </li>
                                            <?php $i++; } ?>
                                            </ul>
                                        </div>
                                    </div>
                                    <div role="tabpanel" class="tab-pane" id="gallery">
                                        <div class="photo_post_list">
                                            <ul>
                                            <?php $i = 1;
                                                foreach($gallery_img as $gi)
                                                    { ?>
                                                <li class="img_<?php echo $gi['piv_id']; ?>">
                                                    <a class="example-image-link11" href="<?php echo $this->Custom->getImageSrc('uploads/trainee_gallery/'.$gi['piv_name']) ?>" data-lightbox="example-set1" data-title="Click the right half of the image to move forward.">
                                                    <img style="height:170px;" class="example-image1 img-responsive" src="<?php echo $this->Custom->getImageSrc('uploads/trainee_gallery/'.$gi['piv_name']) ?>" alt=""/></a>
                                                </li>
                                            <?php $i++; } ?>
                                            </ul>
                                        </div>
                                    </div>
                                    <div role="tabpanel" class="tab-pane" id="videos">
                                    	<div class="photo_video_list">
                                        	<ul>
                                            <?php  
                                                foreach($gallery_videos as $gv)
                                                    { ?>
                                                <li><video src="<?php echo $this->request->webroot; ?>uploads/trainee_videos/<?php echo $gv['piv_name']; ?>" height="315" id="jwp_video<?php echo $gv['piv_id']; ?>" width="100%"></video></li>
                                            <?php } ?>
                                            </ul>
                                        </div>
                                    </div>
                                    
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
  </main>

  <!-- Video Player Start -->

    <script type='text/javascript'>
    <?php 
        foreach($gallery_videos as $gv)
        { ?>
        jwplayer("jwp_video<?php echo $gv['piv_id']; ?>").setup({
        flashplayer: "<?php echo $this->request->webroot; ?>player/player.swf",
        plugins: {
                 viral: {
                     onpause: false,
                     oncomplete: false,
                     allowmenu: false
                 }
              }
        });
    <?php } ?>
        
    </script>

    <!-- Video Player End -->
