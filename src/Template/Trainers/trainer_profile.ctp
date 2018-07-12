
    <!--Main container sec start-->
    <div class="main_container">
    <!--Trainee top sec start-->
        <section class="trainee_top parallax-window" data-parallax="scroll" data-image-src="<?php echo $this->request->webroot; ?>images/trainee_top_bg.jpg">
            <div class="trainee_top_inner tr_grad">
                <div class="container">
                <div class="row">
                
                    <div class="col-sm-6 col-md-7">
                        <div class="trainee_top_wrap trainer_banner">
                            <div class="trainee_img">
                                <a class="example-image-link" href="<?php echo $this->Custom->getImageSrc('uploads/trainer_profile/'.$profile_details[0]['trainer_image']) ?>" data-lightbox="example-set" data-title="Click the right half of the image to move forward.">
                                    <img style="width:200px;height:190px;" src="<?php echo $this->Custom->getImageSrc('uploads/trainer_profile/'.$profile_details[0]['trainer_image']) ?>" alt="img" class="img-responsive"></a>
                                <p>$<?php if(!empty($rate_plans)) echo $rate_plans[0]['rate_hour']; else echo "0"; ?>/<span>HR</span></p>
                            </div>
                            <div class="trainee_detail">
                                <h1 class="trainee_name"><?php echo $profile_details[0]['trainer_name']." ".$profile_details[0]['trainer_lname']; ?></h1>
                                <div>
                                    <h3 class="trainee_rank">Rank Level :</h3>
                                    <div class="dashboard_rating"><input class="trainer-rank" value="<?php echo $profile_details[0]['trainer_rating']; ?>" type="number" /></div>
                                </div>
                                <nav class="trainee_streams">
                                <?php if(!empty($profile_details[0]['trainer_skills'])) { ?>
                                     <ul>
                                        <?php $skills =  $profile_details[0]['trainer_skills']; 
                                            $skillArr = explode(",", $skills);
                                            foreach($skillArr as $s) { ?>
                                            <li><a href="javascript:void(0);" class="red_grad" title="<?php echo $s; ?>"><?php echo $s; ?> </a></li>
                                            <?php } ?>
                                    </ul>
                                <?php } ?>
                                </nav>
                                <nav class="trainee_social_link">
                                    <ul>
                                    <?php
                                        if(!empty($profile_details[0]['trainer_linkedin'])) { ?>
                                    <li><a target="_blank" href="<?php echo $profile_details[0]['trainer_linkedin']; ?>" title="Linked In" class="linkedin_grad"><span class="fa fa-linkedin"></span></a></li>
                                    <?php } ?>
                                    <?php
                                        if(!empty($profile_details[0]['trainer_facebook'])) { ?>
                                    <li><a target="_blank" href="<?php echo $profile_details[0]['trainer_facebook']; ?>" title="Facebook" class="facebook_grad"><span class="fa fa-facebook"></span></a></li>
                                    <?php } ?>
                                    <?php
                                        if(!empty($profile_details[0]['trainer_twitter'])) { ?>
                                    <li><a target="_blank" href="<?php echo $profile_details[0]['trainer_twitter']; ?>" title="Twitter" class="twitter_grad"><span class="fa fa-twitter"></span></a></li>
                                    <?php } ?>
                                    <?php
                                        if(!empty($profile_details[0]['trainer_belibitv'])) { ?>
                                    <li><a target="_blank" href="<?php echo $profile_details[0]['trainer_belibitv']; ?>" title="BelibiTv" class="belibitv_grad"><span class="belivitv_icon"><img src="<?php echo $this->request->webroot; ?>img/favicon.png"></span></a></li>
                                    <?php } ?>
                                    <?php
                                        if(!empty($profile_details[0]['trainer_google'])) { ?>
                                    <li><a target="_blank" href="<?php echo $profile_details[0]['trainer_google']; ?>" title="Google" class="google_grad"><span class="fa fa-google-plus"></span></a></li>
                                    <?php } ?>
                                    <?php
                                        if(!empty($profile_details[0]['trainer_instagram'])) { ?>
                                    <li><a target="_blank" href="<?php echo $profile_details[0]['trainer_instagram']; ?>" title="Instagram" class="instagram_grad"><span class="fa fa-instagram"></span></a></li>
                                    <?php } ?>
                                    
                                    
                                    </ul>
                                </nav>
                            </div>
                            
                        </div>
                    </div>
                    
                    <div class="col-sm-6 col-md-5">
                    <div class="trainee_top_wrap trainer_banner">
                    <div class="session_sec">
                        <ul class="shearing_list">
                            <li><a href="javascript:void(0);"><i class="fa fa-commenting"></i></a></li>
                            <li><a href="javascript:void(0);" title="Social Sharing"><i class="fa fa-share-alt"></i></a>
                                <nav class="trainee_social_link share_in_block">
                                <?php
                                    $trainer_profile_url = $this->request->webroot."trainerProfile/".base64_encode($profile_details[0]['user_id']);
                                ?>
                                    <ul>
                                        <li><a target="_blank" href="https://www.linkedin.com/cws/share?url=<?php echo $trainer_profile_url; ?>" title="Share Profile On Linked In" class="linkedin_grad"><span class="fa fa-linkedin"></span></a></li>
                                        <li><a target="_blank" href="http://www.facebook.com/sharer.php?u=<?php echo $trainer_profile_url; ?>" title="Share Profile On Facebook" class="facebook_grad"><span class="fa fa-facebook"></span></a></li>
                                        <li><a target="_blank" href="http://twitter.com/home?status=<?php echo $trainer_profile_url; ?>" title="Share Profile On Twitter" class="twitter_grad"><span class="fa fa-twitter"></span></a></li>
                                        <li><a target="_blank" href="https://plus.google.com/share?url=<?php echo $trainer_profile_url; ?>" title="Share Profile On Google" class="google_grad"><span class="fa fa-google-plus"></span></a></li>
                                    </ul>
                                </nav>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                         <a href="<?php echo $this->request->webroot; ?>trainers/completeProfile" title="Edit Profile" class="hireme_btn gray_grad">Edit Profile<span class="fa fa-edit"></span></a> 
                    </div>
                    <div class="clearfix"></div>
                    
                    <div class="session_main">
                    <?php if(!empty($rate_plans)) { ?>
                        <ul class="session_list">
                            <li><h3>1 Session</h3><h2>$<?php echo $rate_plans[0]['rate_hour'] - $rate_plans[0]['adgust1']; ?><span></span></h2><a href="javascript:void(0)">Order Now</a></li>
                            <li><h3>3 Sessions</h3><h2>$<?php echo ( 3 * $rate_plans[0]['rate_hour'] ) - $rate_plans[0]['adgust2']; ?><span></span></h2><a href="javascript:void(0)">Order Now</a></li>
                            <li><h3>10 Sessions</h3><h2>$<?php echo ( 10 * $rate_plans[0]['rate_hour'] ) - $rate_plans[0]['adgust3']; ?><span></span></h2><a href="javascript:void(0)">Order Now</a></li>
                            <li><h3>20 Sessions</h3><h2>$<?php echo ( 20 * $rate_plans[0]['rate_hour'] ) - $rate_plans[0]['adgust4']; ?><span></span></h2><a href="javascript:void(0)">Order Now</a></li>
                        </ul>
                    <?php } ?>
                    <div class="clearfix"></div>
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
            <div class="row">
                <div class="col-sm-8">
                
                <div class="profile_photo">
                <?php $i = 1; if(!empty($gallery_img)) { ?>
                    <ul class="photo_list">
                    <?php foreach($gallery_img as $gi) { ?>
                        <li <?php if($i != 1) echo "style='display:none;'" ?>><div class="photo_des"><a class="example-image-link" href="<?php echo $this->Custom->getImageSrc('uploads/trainer_gallery/'.$gi['piv_name']) ?>" data-lightbox="example-set" data-title="Click the right half of the image to move forward."><img style="height:190px;" src="<?php echo $this->Custom->getImageSrc('uploads/trainer_gallery/'.$gi['piv_name']) ?>" alt="" class="img-responsive"></a><div class="photo_inner"><h2>Photos</h2></div></div></li>
                    <?php $i++; } ?>
                    <?php $j = 1;
                        foreach($gallery_videos as $gv) { ?>
                            <li><video src="<?php echo $this->request->webroot; ?>uploads/trainer_videos/<?php echo $gv['piv_name']; ?>" height="190" id="jwp_video<?php echo $gv['piv_id']; ?>" width="370"></video></li>&nbsp;&nbsp;
                        <?php $j++; if($j == 2) break; } ?>
                    </ul>
                <?php } ?>
                </div>
                
                    <div class="trainer_profile_wrap">
                        <ul>
                            <li>
                                <div class="profile_field_title">
                                    Biography   :-
                                </div>
                                <div class="profile_field_des">
                                <?php echo $profile_details[0]['biography']; ?>
                                </div>
                            </li>
                            <li>
                                <div class="profile_field_title">
                                    Certification  :-
                                </div>
                                <div class="profile_field_des">
                                <?php echo $profile_details[0]['certification']; ?>
                                </div>
                            </li>
                            <li>
                                <div class="profile_field_title">
                                    Awards  :-
                                </div>
                                <div class="profile_field_des">
                                    <?php echo $profile_details[0]['awards']; ?>
                                </div>
                            </li>
                            <li>
                                <div class="profile_field_title">
                                    Accomplishments  :-
                                </div>
                                <div class="profile_field_des">
                               <?php echo $profile_details[0]['accomplishments']; ?>
                                </div>
                            </li>
                            <li>
                                <div class="profile_field_title">
                                    Location  :-
                                </div>
                                <div class="profile_field_des">
                                    <?php echo $profile_details[0]['location']; ?>
                                </div>
                            </li>
                            <li>
                                <div class="profile_field_title">
                                    Credentials  :-
                                </div>
                                <div class="profile_field_des">
                                 <?php echo $profile_details[0]['credentials']; ?>
                                </div>
                            </li>
                            <li>
                                <div class="profile_field_title">
                                    Interests   :-
                                </div>
                                <div class="profile_field_des">
                               <?php echo $profile_details[0]['interests_hobby']; ?>
                                </div>
                            </li>
                            <li>
                                <div class="profile_field_title">
                                    Hobbies :-
                                </div>
                                <div class="profile_field_des">
                               <?php echo $profile_details[0]['hobby']; ?>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-4">
                
                <div class="order_main">
                <?php if(!empty($custom_packages)) { ?>
                    <ul class="order_list clearfix">
                    <?php foreach($custom_packages as $cm) { ?>
                        <li><h3><?php echo $cm['package_name']; ?></h3><p><?php echo $cm['package_discription']; ?></p><h2>$<?php echo $cm['package_price']; ?></h2><a href="javascript:void(0);">Order Now</a></li>
                    <?php } ?>
                    </ul>
                <?php } ?>
                </div>
                
                    <div class="trainer_review">
                        <div class="panel_block">
                            <div class="panel_block_heading review_heading">
                                <h3><?php echo ucwords($profile_details[0]['trainer_name']." ".$profile_details[0]['trainer_lname']); ?> Reviews*</h3>
                            </div>
                            <div class="review_body">
                            <?php if(!empty($feedback)) { ?>
                                <ul>
                                <?php foreach($feedback as $f) { ?>
                                    <li class="clearfix">
                                        <div class="rtrainee_img">
                                            <img src="<?php echo $this->Custom->getImageSrc('uploads/trainee_profile/'.$f['trainee_image']) ?>" alt="img">
                                        </div>
                                        <div class="review_txt">
                                            <h4><?php echo $f['trainee_displayName']; ?></h4>
                                            <div class="rating_rage">
                                                 <div class="review_rating">
                                                    <input class="rating-input" value="<?php echo $f['rating_total']; ?>" type="number" />
                                                 </div>
                                            </div>
                                            <p style="text-align:justify;"><?php echo $f['rating_message']; ?></p>
                                        </div>
                                    </li>
                                <?php } ?>
                                </ul>
                            <?php } ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="quotes_main">
                    <h1>Quotes</h1>
                    <div class="quotes_slider">
                    <!-- slider-->
                    <div id="carousel-example-generic1" class="carousel slide" data-ride="carousel"> 
              <!-- Indicators -->
             <ol class="carousel-indicators">
                <li data-target="#carousel-example-generic1" data-slide-to="0" class=""></li>
                <li class="active" data-target="#carousel-example-generic1" data-slide-to="1"></li>
                <li class="" data-target="#carousel-example-generic1" data-slide-to="2"></li>
              </ol>
              
              <!-- Wrapper for slides -->
              <div class="carousel-inner" role="listbox">
              <?php $i = 0; foreach($quotes as $q) { ?>
                <div class="item <?php if($i == 0) echo "active"; ?>">
                  <div class="text-slider">
                    <p><?php echo $q['lt_content'];?></p>
                  </div>
                </div>
              <?php $i++; } ?>
              </div>
            </div>
                    <!-- slider end-->
                    
                    
                    </div>
                    </div>
                    
                </div>
            </div>
        </div>
     </section>   
        
    </div>
    <!--Main container sec end-->
    <!-- Rating Start -->

    <script>
        jQuery(document).ready(function () {
         $('.rating-input, .trainer-rank').rating({
                  step: 1,
                  size: 'xs',
                  showClear: false,
                  disabled: true
            });
        });
    </script>

    <!-- Rating End -->

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
