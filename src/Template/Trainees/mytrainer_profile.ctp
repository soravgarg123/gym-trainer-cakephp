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
                                if($trainer_detail[0]['trainer_image'] != "")
                                { ?>
                                    <a class="example-image-link" href="<?php echo $this->Custom->getImageSrc('uploads/trainer_profile/'.$trainer_detail[0]['trainer_image']) ?>" data-lightbox="example-set" data-title="Click the right half of the image to move forward.">
                                    <img style="width:200px;height:190px;" src="<?php echo $this->Custom->getImageSrc('uploads/trainer_profile/'.$trainer_detail[0]['trainer_image']) ?>" alt="img" class="img-responsive"></a>
                            <?php }
                                else
                                { ?>
                                    <img style="width:200px;height:190px;" src="<?php echo $this->request->webroot; ?>img/default.png" alt="img" class="img-responsive">
                            <?php } ?>
                            </div>
                            <div class="trainee_detail">
                            	<h1 class="trainee_name"><?php echo $trainer_detail[0]['trainer_name']; ?></h1>
                               <div class="retting_box">
                                    <h3 class="trainee_rank">Rank Level : </h3><input class="trainer-rank" value="<?php echo $trainer_detail[0]['trainer_rating']; ?>" type="number" /> <span class="gray_grad"><?php echo $trainer_detail[0]['trainer_rating']; ?></span>
                                </div>    
                                <nav class="trainee_streams">
                                	<ul>
                                    <?php $skills =  $trainer_detail[0]['trainer_skills']; 
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
                                        if(!empty($trainer_detail[0]['trainer_linkedin'])) { ?>
                                    <li><a target="_blank" href="<?php echo $trainer_detail[0]['trainer_linkedin']; ?>" title="Linked In" class="linkedin_grad"><span class="fa fa-linkedin"></span></a></li>
                                    <?php } ?>
                                    <?php
                                        if(!empty($trainer_detail[0]['trainer_facebook'])) { ?>
                                    <li><a target="_blank" href="<?php echo $trainer_detail[0]['trainer_facebook']; ?>" title="Facebook" class="facebook_grad"><span class="fa fa-facebook"></span></a></li>
                                    <?php } ?>
                                    <?php
                                        if(!empty($trainer_detail[0]['trainer_twitter'])) { ?>
                                    <li><a target="_blank" href="<?php echo $trainer_detail[0]['trainer_twitter']; ?>" title="Twitter" class="twitter_grad"><span class="fa fa-twitter"></span></a></li>
                                    <?php } ?>
                                    <?php
                                        if(!empty($trainer_detail[0]['trainer_belibitv'])) { ?>
                                    <li><a target="_blank" href="<?php echo $trainer_detail[0]['trainer_belibitv']; ?>" title="BelibiTv" class="belibitv_grad"><span class="belivitv_icon"><img src="<?php echo $this->request->webroot; ?>img/favicon.png"></span></a></li>
                                    <?php } ?>
                                    <?php
                                        if(!empty($trainer_detail[0]['trainer_google'])) { ?>
                                    <li><a target="_blank" href="<?php echo $trainer_detail[0]['trainer_google']; ?>" title="Google" class="google_grad"><span class="fa fa-google-plus"></span></a></li>
                                    <?php } ?>
                                    <?php
                                        if(!empty($trainer_detail[0]['trainer_instagram'])) { ?>
                                    <li><a target="_blank" href="<?php echo $trainer_detail[0]['trainer_instagram']; ?>" title="Instagram" class="instagram_grad"><span class="fa fa-instagram"></span></a></li>
                                    <?php } ?>
                                    
                                    
                                    </ul>
                                </nav>
                                <div class="profile_btn_main">
                                     <?php
                                        $session = $this->request->session();
                                        $user_data = $session->read('Auth.User');
                                    if($user_data['user_type'] == 'trainee') {
                                    ?>
                                    <a href="<?php echo $this->request->webroot; ?>trainees/appointments" title="Book a Training Session"  class="hireme_btn gray_grad">Book a Training Session</a>
                                    <?php } ?>
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
        	<div class="row">
            	<div class="col-sm-12">
                <?php echo $this->Custom->successMsg(); ?>
                 <?php echo $this->Custom->errorMsg(); ?>
                 <?php echo $this->Custom->loadingImg(); ?>
                	<div class="trainer_profile_wrap">
                    	<ul>
                        	<li>
                            	<div class="profile_field_title">
                                	Biography   :-
                                </div>
                                <div class="profile_field_des">
                                <?php echo $trainer_detail[0]['biography']; ?>
                                </div>
                            </li>
                            <li>
                            	<div class="profile_field_title">
                                	Certification  :-
                                </div>
                                <div class="profile_field_des">
                                <?php echo $trainer_detail[0]['certification']; ?>
                                </div>
                            </li>
                            <li>
                            	<div class="profile_field_title">
                                	Awards  :-
                                </div>
                                <div class="profile_field_des">
                                   <?php echo $trainer_detail[0]['awards']; ?>
                                </div>
                            </li>
                            <li>
                            	<div class="profile_field_title">
                                	Accomplishments  :-
                                </div>
                                <div class="profile_field_des">
                               <?php echo $trainer_detail[0]['accomplishments']; ?>
                                </div>
                            </li>
                            <li>
                            	<div class="profile_field_title">
                                	Location  :-
                                </div>
                                <div class="profile_field_des">
                              	 	<?php echo $trainer_detail[0]['location']; ?>
                                </div>
                            </li>
                            <li>
                            	<div class="profile_field_title">
                                	Credentials  :-
                                </div>
                                <div class="profile_field_des">
                                <?php echo $trainer_detail[0]['credentials']; ?>
                                </div>
                            </li>
                            <li>
                            	<div class="profile_field_title">
                                	Interest    :-
                                </div>
                                <div class="profile_field_des">
                               <?php echo $trainer_detail[0]['interests_hobby']; ?>
                                </div>
                            </li>
                            <li>
                            	<div class="profile_field_title">
                                	Hobby :-
                                </div>
                                <div class="profile_field_des">
                               <?php echo $trainer_detail[0]['hobby']; ?>
                                </div>
                            </li>
                            <li>
                                <div class="profile_field_title">
                                    Resume:-
                                </div>
                                <div class="profile_field_des">
                                     <?php 
                                foreach($resume as $c) { 
                                if($c['publish_type'] == 1) { ?>
                                <a href="<?php echo $this->request->webroot; ?>trainers/downloadDocument/<?php echo $c['document_file']; ?>" class="btn btn-default" title="Download Resume" >Resume</a>
                                <?php } } ?>
                                </div>
                            </li>
                            <li>
                                <div class="profile_field_title">
                                    Certificates :-
                                </div>
                                <div class="profile_field_des">
                                 <?php 
                                foreach($certificates as $c) { 
                                if($c['publish_type'] == 1) { ?>
                                <a href="<?php echo $this->request->webroot; ?>trainers/downloadDocument/<?php echo $c['document_file']; ?>" class="btn btn-default" title="Download Document" ><?php echo $c['document_name']; ?></a>
                                <?php } } ?>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-sm-8">
                    <div class="trainer_review">
                        <div class="panel_block">
                            <div class="panel_block_heading review_heading">
                                <h3><?php echo ucwords($trainer_detail[0]['trainer_name']); ?> Reviews*</h3>
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
                                                    <!-- <span> <?php echo $f['rating_total']; ?></span> -->
                                                    <input class="rating-input" value="<?php echo $f['rating_total']; ?>" type="number" />
                                                 </div>
                                                 <!-- <div class="rview_rate">
                                                   <?php echo $f['rating_total']; ?> Rating
                                                 </div> -->
                                            </div>
                                            <p style="text-align:justify;"><?php echo $f['rating_message']; ?></p>
                                            <!-- <div class="review_by">
                                                <span>- Reviewer's Name</span>
                                            </div> -->
                                        </div>
                                    </li>
                                <?php }  ?>
                                </ul>
                                <?php } 
                                else
                                { ?>
                                <h4><center>Data Not Found !</center></h4>
                            <?php } ?>
                               
                                    
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <div class="col-sm-4">
                	<div class="innerp_right_bar">
                    	<div class="photo_videos">
                      <!-- Nav tabs -->
                      <ul class="pv_nav" role="tablist">
                        <li role="presentation" class="active"><a href="#photos" aria-controls="photos" role="tab" data-toggle="tab">Photos</a></li>
                        <li role="presentation"><a href="#videos" aria-controls="videos" role="tab" data-toggle="tab">Videos</a></li>
                      </ul>
                    
                      <!-- Tab panes -->
                      <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="photos">
                            <ul class="trainers_pic clearfix">
                            	<?php $i = 1;
                            foreach($gallery_img as $gi) { ?>
                                <li><a href="javascript:void(0);"><img style="height:85px;" src="<?php echo $this->Custom->getImageSrc('uploads/trainer_gallery/'.$gi['piv_name']) ?>" alt="img"></a></li>
                            <?php $i++; if($i == 10) break; } ?>
                            </ul>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="videos">
                        	<ul class="trainers_videos clearfix">
                            <?php $i = 1;
                            foreach($gallery_videos as $gv) { ?>
                                <li><video src="<?php echo $this->Custom->getImageSrc('uploads/trainer_videos/'.$gv['piv_name']) ?>" height="190" id="jwp_video<?php echo $gv['piv_id']; ?>" width="320"></video></li>&nbsp;&nbsp;
                            <?php $i++; if($i == 3) break; } ?>
                            </ul>
                        </div>
                      </div>
                    
                    </div>
                    	
                        <div class="quote_sec">
                        <div class="panel_block white">
                        	<div class="panel_block_heading">
                            	<h3>Quotes</h3>
                            </div>
                            <div class="panel_block_body2">
                            	<div id="quote_carousel" class="carousel slide" data-ride="carousel">
 								 <!-- Wrapper for slides -->
                              		<div class="carousel-inner" role="listbox">
                                    <?php $i = 1;
                                    foreach($quotes as $q) { ?>
                                        <div class="item <?php if($i == 1) echo "active"; ?>">
                                          <p><?php echo $q['lt_content'];?></p>
                                        </div>
                                    <?php $i++; } ?>
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
<!-- Rating Start -->

<script>
    jQuery(document).ready(function () {
     $('.trainer-rank, .rating-input').rating({
              step: 1,
              size: 'xs',
              showClear: false,
              disabled: true
        });
    });
</script>

<!-- Rating End -->
                            