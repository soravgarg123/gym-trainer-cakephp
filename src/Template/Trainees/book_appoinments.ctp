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
                                    <a class="example-image-link" href="<?php echo $this->request->webroot; ?>uploads/trainer_profile/<?php echo $trainer_detail[0]['trainer_image']; ?>" data-lightbox="example-set" data-title="Click the right half of the image to move forward.">
                                    <img style="width:200px;height:190px;" src="<?php echo $this->request->webroot; ?>uploads/trainer_profile/<?php echo $trainer_detail[0]['trainer_image']; ?>" alt="img" class="img-responsive"></a>
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
                                    <a class="select_trainr gray_grad" title="Select a Trainer" href="<?php echo $this->request->webroot; ?>ourTrainers"><span class="fa fa-user"></span> Select a Trainer</a>
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

    <!-- Book Appoinment Modal Start -->
        <div class="modal fade" id="book_appo_Modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Book Appoinment For <?php echo ucwords($trainer_detail[0]['trainer_name']); ?></h4>
              </div>
              <div class="modal-body">
                <form method="post" action="<?php echo $this->request->webroot; ?>trainees/addAppoinments/<?php echo base64_encode($trainer_detail[0]['user_id']); ?>" >
                  <div class="col-md-12">                        
                      <div class="col-md-4"> Date</div>
                      <div class="col-md-8">
                        <input type="text" readonly id="app_date" name="app_date" class="form-control" />
                      </div>
                  </div></br></br>
                  <div class="col-md-12">                        
                      <div class="col-md-4">Start Time</div>
                      <div class="col-md-8">
                        <input type="text"   id="app_start_time" required="required" name="app_start_time" class="form-control" />
                      </div> 
                  </div></br></br>
                  <div class="col-md-12">                        
                      <div class="col-md-4">End Time</div>
                      <div class="col-md-8">
                        <input type="text"  id="app_end_time" required="required" name="app_end_time" class="form-control" />
                      </div>
                  </div></br></br>
                  <div class="col-md-12">                        
                      <div class="col-md-4">Color</div>
                      <div class="col-md-8">
                        <input type="color"  id="app_color"  name="app_color" class="form-control" />
                      </div>
                  </div></br></br>
                  <div class="col-md-12">                        
                    <div class="col-md-4"> Message</div>
                    <div class="col-md-8">
                      <textarea required name="app_message" id="app_message" class="form-control" rows="2"></textarea>
                    </div>
                </div></br></br>
               </div></br>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" id="submit-btn" class="btn btn-primary">Submit</button>
              </div>
              </form>
            </div>
          </div>
        </div>
        <!--  Book Appoinment Modal End -->
		
     <section class="trainee_dash_body">
     	<div class="container">
      <?php echo $this->Flash->render('edit') ?>
        <div id='calendar'></div>
        </div>
     </section>   
        
    </div>
    <!--Main container sec end-->
  </main>

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
