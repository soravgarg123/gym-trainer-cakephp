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
                                if($profile_details[0]['trainer_image'] != "")
                                { ?>
                                    <a class="example-image-link" href="<?php echo $this->Custom->getImageSrc('uploads/trainer_profile/'.$profile_details[0]['trainer_image']) ?>" data-lightbox="example-set" data-title="Click the right half of the image to move forward.">
                                    <img style="width:200px;height:190px;" src="<?php echo $this->Custom->getImageSrc('uploads/trainer_profile/'.$profile_details[0]['trainer_image']) ?>" alt="img" class="img-responsive"></a>
                            <?php }
                                else
                                { ?>
                                    <img style="width:200px;height:190px;" src="<?php echo $this->request->webroot; ?>img/default.png" alt="img" class="img-responsive">
                            <?php } ?>
                            </div>
                            <div class="trainee_detail">
                                <h1 class="trainee_name"><?php echo $profile_details[0]['trainer_name']; ?></h1>
                                <div class="retting_box">
                                    <h3 class="trainee_rank">Rank Level : </h3><input class="trainer-rank" value="<?php echo $profile_details[0]['trainer_rating']; ?>" type="number" /> <span class="gray_grad"><?php echo $profile_details[0]['trainer_rating']; ?></span>
                                </div>  
                                <nav class="trainee_streams">
                                    <ul>
                                    <?php $skills =  $profile_details[0]['trainer_skills']; 
                                        $skillArr = explode(",", $skills);
                                        if(!empty($skillArr)) {
                                        foreach($skillArr as $s) { ?>
                                        <li><a href="javascript:void(0);" class="red_grad" title="<?php echo $s; ?>"><?php echo $s; ?> </a></li>
                                        <?php } }?>
                                    </ul>
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
                </div>
            </div>
            </div>
        </section>
    <!--Trainee top  sec end--> 

     <section class="trainee_dash_body">
     	<div class="container trainee_profile_wrap">
        <form method="post" id="rating_form">
        	<div class="row">
            	<div class="col-sm-9">
                <?php echo $this->Custom->successMsg(); ?>
                <?php echo $this->Custom->errorMsg(); ?>
                <?php echo $this->Custom->loadingImg(); ?>
                
                	<div class="panel review_question_sect">
                      <div class="panel-heading"><span>1</span> Overall experiance with your trainer? </div>
                      <div class="panel-body">
                      	<div class="question_star_rat">
                        	<input class="rating-input" id="question1" required name="question1" type="number" />
                        </div>
                      </div>
                    </div>
                    
                    <div class="panel review_question_sect">
                      <div class="panel-heading"><span>2</span> Was your trainer knowledgeable? </div>
                      <div class="panel-body">
                      	<div class="question_star_rat">
                        	<input class="rating-input" id="question2" name="question2" type="number" />
                        </div>
                      </div>
                    </div>
                    
                    <div class="panel review_question_sect">
                      <div class="panel-heading"><span>3</span> Was all your questions answered? </div>
                      <div class="panel-body">
                      	<div class="question_star_rat">
                        	<input class="rating-input" id="question3" name="question3" type="number" />
                        </div>
                      </div>
                    </div>
                    
                    <span class="blank_star"></span>
                    <div class="panel review_question_sect">
                      <div class="panel-heading"><span>4</span> Professionalism? </div>
                      <div class="panel-body">
                      	<div class="question_star_rat">
                        	<input class="rating-input" id="question4" name="question4" type="number" />
                        </div>
                      </div>
                    </div>
                    
                    <div class="panel review_question_sect">
                      <div class="panel-heading"><span>5</span>  Would you recommend to others? </div>
                      <div class="panel-body">
                      	<div class="question_star_rat">
                        	<input class="rating-input" id="question5" name="question5" type="number" />
                        </div>
                      </div>
                    </div>
                    
                    <div class="review_feedback_wrap">
                    	<div class="form-group">
                    	<textarea class="form-control" id="message" name="rating_message" rows="3" placeholder="Feedback"></textarea>
                        </div>
                        <div class="form-group">
                        <button type="button" id="rating-btn" class="btn submit_btn">Submit</button>
                        </div>
                    </div> 
                   
                  </form>  
	
                </div>
                
            	<div class="col-sm-3">
                	<div class="re_trainer_list_wra">
                    	<h4>Recommended Trainers</h4>
                    	<ul>
                        <?php 
                        foreach($trainers as $t) { ?>
                        <li><a href="<?php echo $this->request->webroot; ?>mytrainerProfile/<?php echo base64_encode($t['user_id']); ?>"><span><img class="img-responsive" src="<?php echo $this->Custom->getImageSrc('uploads/trainer_profile/'.$t['trainer_image']) ?>"/></span><h3><?php echo $t['trainer_displayName']; ?></h3></a></li>
                        <?php } ?>
                        </ul>
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
     $('.rating-input').rating({
              min: 0,
              max: 5,
              step: 1,
              size: 'xs',
              showClear: false
        });
    });
</script>

<!-- Rating End -->

<!-- Insert Feedback Form Start -->

<script type="text/javascript">
    $(document).ready(function(){
    $('#rating-btn').click(function(){
    $('html, body').animate({ scrollTop: $(".trainee_top_wrap").offset().top }, 1000);
        if($('#question1').val() == 0 || $('#question2').val() == 0 || $('#question3').val() == 0 || $('#question4').val() == 0 || $('#question5').val() == 0)
        {
            $("div#error_msg").html("<center><i class='fa fa-times'> Please Fill All Answers ! </i></center>").show();
            return false;
        }
        if($('#message').val() == ""){
            $("div#error_msg").html("<center><i class='fa fa-times'> Please Enter Message ! </i></center>").show();
            return false;
        }
    var data = $('#rating_form').serialize();
    var trainer_id = "<?php echo base64_encode($profile_details[0]['user_id']); ?>";
    $('img#loading-img').show();
    $.ajax({
            url:"<?php echo $this->request->webroot; ?>trainees/insertRating?trainer_id=" + trainer_id,
            type:"post",
            data:data,   
            dataType : "json",                 
            success: function(data){
            $('#rating_form')[0].reset();
            $('img#loading-img').hide();
            if(data.message == 0) 
                {
                    $("div#error_msg").html("<center><i class='fa fa-times'> You Have Alreday Submitted Rating For This Trainer ! </i></center>").show();
                    $("div#success_msg").hide();
                }
            if(data.message != 0) 
                {
                    $("div#success_msg").html("<center><i class='fa fa-check'> Thank You For Your Valuable Feedback </i></center>").show();
                    $("div#error_msg").hide();
                }
        }
        });
    });
    });
</script>

<!-- Insert Feedback Form End -->

<!-- Rating Start -->

<script>
    jQuery(document).ready(function () {
     $('.trainer-rank').rating({
              step: 1,
              size: 'xs',
              showClear: false,
              disabled: true
        });
    });
</script>

<!-- Rating End -->