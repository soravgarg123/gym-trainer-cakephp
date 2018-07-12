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
        </section>
    <!--Trainee top  sec end--> 
		
     <section class="trainee_dash_body">
     	<div class="container trainee_profile_wrap">
        	
        	<div class="row">
            	<div class="col-sm-3">
                	
                    <div class="trainee_tabs_sect">
                    	  <h3>Trainee Profile</h3>
                    	  <!-- Nav tabs -->
                          <ul class="nav_tabs">
                            <li class="active profile"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">My Profile</a></li>
                            <li class="about"><a href="#about" aria-controls="about" role="tab" data-toggle="tab">About Me</a></li>
                            <li class="photos"><a href="#photos" aria-controls="photos" role="tab" data-toggle="tab">Photos & Videos</a></li>
                            <li class="bmi"><a href="#bmi" aria-controls="bmi" role="tab" data-toggle="tab">Calculate BMI </a></li>
                            <li class="calorie"><a href="#calorie" aria-controls="calorie" role="tab" data-toggle="tab">Calculate Calorie</a></li>
                            <li class="fat"><a href="#fat" aria-controls="fat" role="tab" data-toggle="tab">Calculate Fat</a></li>
                          </ul>
                    </div>
                    
                </div>
                <div class="col-sm-9">
                	<div class="trainee_tab_content">
                    	  <!-- Tab panes -->
                          <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active profile" id="profile">
                            <h3 class="trai_title_sect">My Profile</h3>   
                            	<div class="row">
                                	<div class="col-sm-6">
                                    
                                    	<div class="infoSummary">
                                            <ul>
                                                <li><span>Real Name</span><?php echo ucwords($profile_details[0]['trainee_name']." ".$profile_details[0]['trainee_lname']); ?></li>
                                                <li><span>Email Id</span><div><?php echo $profile_details[0]['trainee_email']; ?></div></li>
                                                <li><span>Age</span><div><?php echo $profile_details[0]['trainee_age']; ?></div></li>
                                                <li><span>Gender</span><div><?php echo ucwords($profile_details[0]['trainee_gender']); ?></div></li>
                                                <li><span>Country</span><?php echo $profile_details[0]['country_name']; ?></li>
                                                <li><span>State</span><?php echo $profile_details[0]['state_name']; ?></li>
                                                <li><span>City</span><?php echo $profile_details[0]['city_name']; ?></li>
                                            </ul>
                                            
                                            <!-- <h3>OVERALL GOAL</h3> -->
                                            <!-- <p>"Throughout November I will be shooting for 4 different magazines. This is my training log showing how I get in cover ready condition."</p> -->
                                        </div>
                                        
                                        
                                    </div>
                                    <div class="col-sm-6">
                                    	
                                        <div class="trainne_widget_section">
                                        	<h4> &nbsp;&nbsp;Current Body Composition</h4>
                                            <div class="trai_widg_body">
                                            	<div class="comp_small_widget">
                                                	<h5>Current Weight</h5>
                                                    <span><?php echo (!empty($profile_details[0]['trainee_current_weight'])) ? $profile_details[0]['trainee_current_weight'] : "0" ?></span><small>Lbs.</small>
                                                </div>
                                                <div class="comp_small_widget">
                                                	<h5>Overall Goal </h5>
                                                    <span><?php echo (!empty($profile_details[0]['trainee_goal'])) ? $profile_details[0]['trainee_goal'] : "0" ?></span><small>Lbs.</small>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane about" id="about">
                            	<h3 class="trai_title_sect">About Me</h3>
                                 <p style="text-align: justify;"><?php echo $profile_details[0]['trainee_aboutme']; ?></p>
                            </div>
                            <div role="tabpanel" class="tab-pane photos" id="photos">
                            	<h3 class="trai_title_sect">Photos & Videos</h3> 
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
                                        	<ul class="clearfix">
                                            <?php  
                                                foreach($gallery_videos as $gv)
                                                    { ?>
                                                <li><video src="<?php echo $this->request->webroot; ?>uploads/trainee_videos/<?php echo $gv['piv_name']; ?>" height="315" id="jwp_video<?php echo $gv['piv_id']; ?>" width="405px"></video></li>
                                            <?php } ?>
                                            </ul>
                                        </div>
                                    </div>
                                    
                                  </div>
                            </div>
                           <div role="tabpanel" class="tab-pane bmi" id="bmi">
                            <h3 class="trai_title_sect">Calculate BMI </h3>
                            <ul class="tai_sub_tab" role="tablist">
                                    <li role="presentation" class="active"><a href="#bmi_results" aria-controls="photos" role="tab" data-toggle="tab">BMI Results</a></li>
                                    <li role="presentation"><a href="#calculate_bmi" aria-controls="gallery" role="tab" data-toggle="tab">Calculate BMI</a></li>
                            </ul></br></br>
                             <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="bmi_results">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>S.No.</th>
                                            <th>Date</th>
                                            <th>BMI</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php $i = 1;
                                    foreach($bmi_results as $br) { ?>
                                        <tr id="row_<?php echo $br['id']; ?>">
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo date('d F, Y', strtotime($br["bmi_date"])); ?></td>
                                            <td><?php echo $br['bmi_calculated']; ?></td>
                                            <td><?php echo $br['bmi_weight_status']; ?></td>
                                        </tr>
                                    <?php $i++; }  ?>
                                    </tbody>
                                </table>
                            </div>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="calculate_bmi">
                            <div class="col-md-12">
                            <div class="col-md-6">
                            <?php echo $this->Custom->successMsg(); ?>
                            <?php echo $this->Custom->errorMsg(); ?>     
                            <?php echo $this->Custom->loadingImg(); ?>
                                <div class="form-group">
                                    <label>Weight (in pounds)</label>
                                    <input type="text" id="weight" value="<?php echo $profile_details[0]['trainee_current_weight']; ?>" placeholder="Weight in pounds" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Height (in inches)</label>
                                    <input type="text" id="height" placeholder="Height in inches" class="form-control">
                                </div>
                              <input type="button" id="cal-bmi-btn" class="btn submit_btn"  value="Calculate" />
                            </div>
                            <div class="col-md-6" id="bmi_image_div">
                                <img style="width:100px;display:none" id="bmi_image" src="">
                            </div></div>
                            </div></div>

                            </div>
                            <div role="tabpanel" class="tab-pane calorie" id="calorie">
                            <h3 class="trai_title_sect">Calculate Burned Calories  </h3>
                            <?php echo $this->Custom->successMsg(); ?>
                            <?php echo $this->Custom->errorMsg(); ?>     
                            <?php echo $this->Custom->loadingImg(); ?>
                            <div class="form-group">
                                <label>Age </label>
                            <input name="trainee_age" id="trainee_age" value="<?php echo $profile_details[0]['trainee_age']; ?>"  type="text" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Gender </label>
                                <select class="form-control" name="trainee_gender" id="trainee_gender">
                                  <option>Select Gender</option>
                                  <option value="male" <?php if(isset($profile_details[0]['trainee_gender']) && $profile_details[0]['trainee_gender'] == "male") echo "selected"; ?>>Male</option>
                                  <option value="female" <?php if(isset($profile_details[0]['trainee_gender']) && $profile_details[0]['trainee_gender'] == "female") echo "selected"; ?>>Female</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Weight (in pounds) </label>
                            <input name="trainee_current_weight" id="trainee_current_weight" value="<?php echo $profile_details[0]['trainee_current_weight']; ?>"  type="text" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Average Heart Rate (in beats per minute) </label>
                            <input name="heart_rate" placeholder="in beats per minute" id="heart_rate" type="text" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Activity Duration </label>
                                <div class="row">
                                <div class="col-md-4">
                                <input name="activity_hours" placeholder="in hours" id="activity_hours" type="text" class="form-control">
                                </div>
                                <div class="col-md-4">
                                <input name="activity_minutes" placeholder="in minutes" id="activity_minutes" type="text" class="form-control">
                                </div>
                                <div class="col-md-4">
                                <input name="activity_seconds" placeholder="in seconds" id="activity_seconds" type="text" class="form-control">
                                </div>
                                </div>
                            </div></br></br>
                            <input type="button" class="btn submit_btn calculate_calorie"  value="Calculate" />
                            </div>
                            <div role="tabpanel" class="tab-pane fat" id="fat">
                            <h3 class="trai_title_sect">Calculate Body Fat  </h3>
                            <?php echo $this->Custom->successMsg(); ?>
                            <?php echo $this->Custom->errorMsg(); ?>     
                            <?php echo $this->Custom->loadingImg(); ?>
                            <div class="form-group">
                                <label>Gender </label>
                                <select class="form-control" name="trainee_gender_fat" id="trainee_gender_fat">
                                  <option value="male" <?php if(isset($profile_details[0]['trainee_gender']) && $profile_details[0]['trainee_gender'] == "male") echo "selected"; ?>>Male</option>
                                  <option value="female" <?php if(isset($profile_details[0]['trainee_gender']) && $profile_details[0]['trainee_gender'] == "female") echo "selected"; ?>>Female</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Weight (in lbs) </label>
                            <input name="trainee_current_weight_fat" placeholder="Weight (in lbs)" id="trainee_current_weight_fat" value="<?php echo $profile_details[0]['trainee_current_weight']; ?>"  type="text" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Waist - At the navel (in inches) </label>
                            <input name="waist" placeholder="Waist - At the navel (in inches)" id="waist" type="text" class="form-control">
                            </div>
                            <div class="female_cal">
                                <div class="form-group">
                                    <label>Hips - At the widest point (in inches) </label>
                                    <input name="hips" placeholder="Hips - At the widest point (in inches)" id="hips" type="text" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Forearm - Unflexed (in inches) </label>
                                    <input name="forearm" placeholder="Forearm - Unflexed (in inches)" id="forearm" type="text" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Wrist (in inches) </label>
                                    <input name="wrist" placeholder="Wrist (in inches)" id="wrist" type="text" class="form-control">
                                </div>
                            </div>
                            <input type="button" class="btn submit_btn calculate_fat"  value="Calculate" />
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

<!-- Calculate BMI Start -->
  
<script type="text/javascript">
  $(document).ready(function(){
    $('#cal-bmi-btn').click(function(){
        var weight = $('#weight').val();
        var height = $('#height').val();
        var valid = /^[-+]?[0-9]+(\.[0-9]+)?$/;

        if(!valid.test(weight.trim()) || weight == "")
            {
              $("div#bmi div#error_msg").html("<center><i class='fa fa-times'> Please Enter Valid Weight ! </i></center>").show();
              $("div#bmi div#success_msg").hide();
              return false;
            }

        if(!valid.test(height.trim()) || height == "")
            {
              $("div#bmi div#error_msg").html("<center><i class='fa fa-times'> Please Enter Valid Height ! </i></center>").show();
              $("div#bmi div#success_msg").hide();
              return false;
            }
        $('div#bmi img#loading-img').show();
        var weightFirst = parseFloat(weight) * 703;
        var heightFirst = parseFloat(height) * parseFloat(height);
        var finalBMI = weightFirst / heightFirst;
        var status = "";
        var img_src = "";
        var gender = "<?php echo $profile_details[0]['trainee_gender']; ?>";

        if(finalBMI < 18.5)
        {
          status = "Underweight";
          img_src = "img1_"+gender+".png";
        }
        if(finalBMI >= 18.5 && finalBMI <= 24.9)
        {
          status = "Healthy";
          img_src = "img2_"+gender+".png";
        }
        if(finalBMI >= 25.0 && finalBMI <= 29.9)
        {
          status = "Overweight";
          img_src = "img3_"+gender+".png";
        }
        if(finalBMI >= 30.0)
        {
          status = "Obese";
          img_src = "img4_"+gender+".png";
        }

        $('div#bmi img#loading-img').hide();
        $("div#bmi div#error_msg").hide();
        $("div#bmi div#success_msg").html("<center> <i class='fa fa-check'> <b>Current BMI : </b>" + finalBMI.toFixed(2) + " </br></br> <b>Weight Status : </b>" + status + " </center>").show();
        $('#weight,#height').val("")
        $('img#bmi_image').attr('src','<?php echo $this->request->webroot; ?>images/bmi/'+img_src).show();
        
    });
  });
</script>

<!-- Calculate BMI End -->

<!-- Calculate Calorie Start -->

<script type="text/javascript">
  $(document).ready(function(){
    $('.calculate_calorie').click(function(){
      var hours = $('#activity_hours').val();
      var minutes = $('#activity_minutes').val();
      var seconds = $('#activity_seconds').val();
      var heart_rate = $('#heart_rate').val();
      var age = $('#trainee_age').val();
      var gender = $('#trainee_gender').val();
      var weight = $('#trainee_current_weight').val();
      var valid = /^[-+]?[0-9]+(\.[0-9]+)?$/;
      var number = /[0-9 -()+]+$/; 
      var calorie = "";
      var time = "";

      $('div#calorie img#loading-img').hide();
      $("div#calorie div#success_msg").hide();

      if(!number.test(age.trim()) || age == "")
        {
          $("div#calorie div#error_msg").html("<center><i class='fa fa-times'> Please Enter Valid Age ! </i></center>").show();
          return false;
        }

      if(gender == "Select Gender")
        {
          $("div#calorie div#error_msg").html("<center><i class='fa fa-times'> Please Select Gender ! </i></center>").show();
          return false;
        }

      if(!valid.test(weight.trim()) || weight == "")
        {
          $("div#calorie div#error_msg").html("<center><i class='fa fa-times'> Please Enter Valid Weight ! </i></center>").show();
          return false;
        }


      if(!valid.test(heart_rate.trim()) || heart_rate == "")
        {
          $("div#calorie div#error_msg").html("<center><i class='fa fa-times'> Please Enter Valid Heart Rate ! </i></center>").show();
          return false;
        }

      // if(valid.test(heart_rate.trim()) || heart_rate != "")
      //   {
      //     heart_rate = parseFloat(heart_rate);
      //     if(heart_rate <= 122 || heart_rate >= 170)
      //     {
      //       $("div#calorie div#error_msg").html("<center><i class='fa fa-times'> Heart Rate Should Be Between 122 And 170 BPM ! </i></center>").show();
      //       return false;
      //     }
      //   }

      if(!number.test(hours.trim()) || hours == "")
        {
          $("div#calorie div#error_msg").html("<center><i class='fa fa-times'> Please Enter Valid Hours ! </i></center>").show();
          return false;
        }

      if(!number.test(minutes.trim()) && minutes != "")
        {
          $("div#calorie div#error_msg").html("<center><i class='fa fa-times'> Please Enter Valid Minutes ! </i></center>").show();
          return false;
        }

      if(!number.test(seconds.trim()) && seconds != "")
        {
          $("div#calorie div#error_msg").html("<center><i class='fa fa-times'> Please Enter Valid Seconds ! </i></center>").show();
          return false;
        }
      $('div#calorie img#loading-img').show();
      $("div#calorie div#error_msg").hide();

      var totaltime = parseInt(((hours * 3600) + (minutes * 60))) + parseInt((seconds == "") ? "0" : seconds);
      time = totaltime / 3600;

      if(gender == "male")
      {
        calorie = ((-55.0969 + (0.6309 * heart_rate) + (0.1988 * weight / 2.2046) + (0.2017 * age)) / 4.184) * 60 * time;
      }
      if(gender == "female")
      {
        calorie = ((-20.4022 + (0.4472 * heart_rate) - (0.1263 * weight / 2.2046) + (0.074 * age)) / 4.184) * 60 * time;
      }
      $('div#calorie img#loading-img').hide();
      $("div#calorie div#success_msg").html("<center> <i class='fa fa-check'>  In " + hours + " Hours " + ((minutes == "")? "0" : minutes) + " Minutes And " + ((seconds == "")? "0" : seconds) + " Seconds You Will Burn Approximately " + calorie.toFixed(2) + " Calories </center>").show();
    });
  });
</script>

<!-- Calculate Calorie End -->

<!-- On change gender start -->

<script type="text/javascript">
    $(document).ready(function(){
        $('body').on('click','#trainee_gender_fat',function(){
        var gender1 = $('#trainee_gender_fat').val();
            if(gender1 == "male"){
                $('.female_cal').hide();
            }else{
                $('.female_cal').show();
            }
        });
    });
</script>

<!-- On change gender end -->

<!-- Calculate Body Fat Start -->

<script type="text/javascript">
  $(document).ready(function(){
    var gender_auto = "<?php echo $profile_details[0]['trainee_gender']; ?>";
    if(gender_auto == "male"){
        $('.female_cal').hide();
    }else{
        $('.female_cal').show();
    }
    $('.calculate_fat').click(function(){
    var gender = $('#trainee_gender_fat').val();
    var weight = $('#trainee_current_weight_fat').val();
    var waist  = $('#waist').val();
    var hips  = $('#hips').val();
    var forearm  = $('#forearm').val();
    var wrist  = $('#wrist').val();
    var valid  = /^[-+]?[0-9]+(\.[0-9]+)?$/;
    var number = /[0-9 -()+]+$/; 
    var finalFat = "";

    $('div#fat img#loading-img').hide();
    $("div#fat div#success_msg").hide();

    if(!valid.test(weight.trim()) || weight == "")
        {
          $("div#fat div#error_msg").html("<center><i class='fa fa-times'> Please Enter Valid Weight ! </i></center>").show();
          return false;
        }

    if(!valid.test(waist.trim()) || waist == "")
        {
          $("div#fat div#error_msg").html("<center><i class='fa fa-times'> Please Enter Valid Waist ! </i></center>").show();
          return false;
        }

    if(gender == "male") {
        var result1 = ( parseFloat(weight) * 1.082 ) + 94.42;
        var result2 =  result1 - ( waist * 4.15 );
        var result3 = ( parseFloat(weight) - parseFloat(result2) ) * 100;
        finalFat    = result3 / parseFloat(weight);
    }

    $('div#fat img#loading-img').show();
    $("div#fat div#error_msg").hide();

    if(gender == "female") {
        if(!valid.test(hips.trim()) || hips == "")
            {
              $("div#fat div#error_msg").html("<center><i class='fa fa-times'> Please Enter Valid Hips Value! </i></center>").show();
              return false;
            }

        if(!valid.test(forearm.trim()) || forearm == "")
            {
              $("div#fat div#error_msg").html("<center><i class='fa fa-times'> Please Enter Valid Forearm Value! </i></center>").show();
              return false;
            }

        if(!valid.test(wrist.trim()) || wrist == "")
            {
              $("div#fat div#error_msg").html("<center><i class='fa fa-times'> Please Enter Valid Wrist Value! </i></center>").show();
              return false;
            }

        var result11 = parseFloat(weight) * 0.732;
        var result22 = result11 + 8.987;
        var result33 = parseFloat(wrist) / 3.14;
        var result44 = parseFloat(waist) * 0.157;
        var result55 = parseFloat(hips) * 0.249;
        var result66 = parseFloat(forearm) * 0.434;
        var result77 = result22 + result33;
        var result88 = result77 - result44;
        var result99 = result88 - result55;
        var result100 = result66 + result99;
        var result111 = ( parseFloat(weight) - result100 ) * 100;
        finalFat = result111 / parseFloat(weight);
    }

    $('div#fat img#loading-img').hide();
    $("div#fat div#success_msg").html("<center> <i class='fa fa-check'> Estimated Body-Fat Percentage:  " + finalFat.toFixed(2) + " % </center>").show();

  });
  });
</script>

<!-- Calculate Body Fat End -->

