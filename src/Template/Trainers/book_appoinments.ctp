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
                                    <a class="example-image-link" href="<?php echo $this->request->webroot; ?>uploads/trainee_profile/<?php echo $trainee_detail[0]['trainee_image']; ?>" data-lightbox="example-set" data-title="Click the right half of the image to move forward.">
                                    <img style="width:200px;height:190px;" src="<?php echo $this->request->webroot; ?>uploads/trainee_profile/<?php echo $trainee_detail[0]['trainee_image']; ?>" alt="img" class="img-responsive"></a>
                            <?php }
                                else
                                { ?>
                                    <img style="width:200px;height:190px;" src="<?php echo $this->request->webroot; ?>img/default.png" alt="img" class="img-responsive">
                            <?php } ?>
                            </div>
                               <div class="trainee_detail">
                                  <h1 class="trainee_name"><?php echo $trainee_detail[0]['trainee_name']; ?></h1>
                                  <!-- <h3 class="trainee_rank">Current Weight : <span><?php echo $trainee_detail[0]['trainee_current_weight']; ?> lbs</span></h3>
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
                                  </nav> -->
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
                <h4 class="modal-title" id="myModalLabel">Book Appoinment For <?php echo ucwords($trainee_detail[0]['trainee_name']); ?></h4>
              </div>
              <div class="modal-body">
                <form method="post" action="<?php echo $this->request->webroot; ?>trainers/addAppoinments/<?php echo base64_encode($trainee_detail[0]['user_id']); ?>" >
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



