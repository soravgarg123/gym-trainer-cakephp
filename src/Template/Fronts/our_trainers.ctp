  <main class="animsition">
    <!--Header sec end-->
    <!--Main container sec start-->
    <div class="main_container">
    <!--Trainee top sec start-->
            <section class="our_trainer_top parallax-window" data-parallax="scroll" data-image-src="<?php echo $this->request->webroot; ?>images/fitness.png">
          <div class="trainee_top_inner tr_grad">
            <div class="container">
              <div class="row">
                  <div class="col-sm-12">
                      <div class="trainee_top_wrap">
                          <div class="trainer_search">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input type="text" class="form-control" autofocus="true" id="search_trainer" placeholder="Search Trainer">
                                            <div class="input-group-addon" id="click-btn">
                                                <span class="fa fa-search" style="cursor:pointer;"></span>
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
    <!--Trainee top  sec end--> 
    
     <section class="trainee_dash_body our_trainers">
      <div class="container">
          <div class="row">
              <div class="col-md-12 col-sm-12">
                 <div class="trainers_head">
                     <h3>our trainers</h3>
                     <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries,</p>
                 </div>
              </div>  
            </div>
            <div class="row">
            <?php foreach($trainers as $t) { ?>
                <div class="col-md-4 col-sm-4">
                 <div class="trainers_box_main">
                  <div class="trainer_box_top">
                   <div class="rate_box"> Houlry Rate -  $<?php echo $this->Custom->getHourlyRate($t['user_id']); ?></div>
                    <div class="trainer_box_img">
                     <a href="<?php echo $this->request->webroot; ?>trainerProfile/<?php echo base64_encode($t['user_id']); ?>"> <img src="<?php echo $this->Custom->getImageSrc('uploads/trainer_profile/'.$t['trainer_image']) ?>" class="img-responsive"></a>
                    </div>
                  </div>
                  <div class="trainer_box_bottom">
                    <div class="trainers_name_box">
                      <a href="<?php echo $this->request->webroot; ?>trainerProfile/<?php echo base64_encode($t['user_id']); ?>"><?php echo ucwords($t['trainer_name']." ".$t['trainer_lname']); ?></a>
                    </div>
                    <div class="location_name_box">
                      <div class="location">
                        <ul class="list_trainer">
                          <li>location:</li>
                          <li><a href="javascript:void(0);"><?php echo $this->Custom->getCityName($t['trainer_city']); ?></a></li>
                        </ul>
                      </div>
                      <div class="score_box">
                        <label>score</label>
                        <div class="bar_img">
                        <div id="diagram-id-<?php echo $t['user_id']; ?>"
                                class="diagram"
                                data-circle-diagram='{
                                    "percent": "<?php echo $t['trainer_rating']; ?>",
                                    "size": "280",
                                    "borderWidth": "4",
                                    "bgFill": "#666666",
                                    "frFill": "#f2534c",
                                    "textSize": "56",
                                    "textColor": "#585858"
                                    }'>
                        </div>
                        <script type="text/javascript">
                          $(function() {
                            $("#diagram-id-<?php echo $t['user_id']; ?>").circleDiagram();
                          });
                        </script>
                      </div>
                      </div>
                    </div>
                    <div class="trainers_description">
                      <ul class="list_trainer">
                          <li>Skills : </li>
                          <li><a href="javascript:void(0);"><?php echo substr($t['trainer_skills'],0,45); ?></a></li>
                        </ul>
                         <p><span>Interests :</span>  <?php echo substr($t['interests_hobby'],0,45); ?> </p>
                         <p><span>Certifications :</span> <?php echo substr($t['certification'],0,45); ?>  </p>
                    </div>
                  </div>
                </div>
                </div>
            <?php } ?>
            </div>
        </div>
     </section>   
        
    </div>
    <!--Main container sec end-->

    
