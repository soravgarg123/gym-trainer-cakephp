<?php include "trainer_dashboard.php"; ?>
     <section class="trainee_dash_body">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="meal_plan_sec">

                      <!-- Tab panes -->
                      <div class="tab-content">
                       <div id="append_div">
                       <?php
                       if(empty($trainee_data)) { ?>
                       <div class="well"><center><h4>You do not have any clients on the platform to manage. Please begin importing your contacts or invite your friend to begin!</h4></center></div>
                    <?php  }
                       else
                       { ?>
                        <ul class="row">
                        <?php 
                            foreach($trainee_data as $t)
                            { ?>
                        <a href="<?php echo $this->request->webroot; ?>trainers/traineeReport/<?php echo base64_encode($t['user_id']); ?>">
                        <li class="col-sm-4 col-md-3">
                                <div class="trainer_sec">
                                    <div class="trainer_img">
                                    <?php
                                        if($t['trainee_image'] != "")
                                        { ?>
                                            <img style="height:260px;width:100%" src="<?php echo $this->Custom->getImageSrc('uploads/trainee_profile/'.$t['trainee_image']) ?>" alt="img" class="img-responsive">
                                    <?php }
                                        else
                                        { ?>
                                            <img style="height:260px;width:100%" src="<?php echo $this->request->webroot; ?>img/default-user.png" alt="img" class="img-responsive">
                                    <?php } ?>
                                    </div>
                                    <div class="trainer_info">
                                        <p><strong><a style="color:white;" href="<?php echo $this->request->webroot; ?>trainers/traineeReport/<?php echo base64_encode($t['user_id']); ?>"> Trainee : </strong><?php echo ucwords($t['trainee_name']); ?> </a></p>
                                        <p><strong>Location : </strong> <?php echo $t['city_name']; ?></p>
                                        <div class="trai_rank">
                                        <!-- <p><strong>Rank :</strong> Level 6</p> -->
                                         <!-- jayendra start -->
                                        <!-- <a class="btn btn-default user_call" href="javascript:void(0);" t_type="trainer" to_id="<?php echo $t['user_id']; ?>" from_id="<?php echo $user_id; ?>" c_type="video">Video Call</a> -->
                                        <!-- <a class="btn btn-default user_call" href="javascript:void(0);" t_type="trainer" to_id="<?php echo $t['user_id']; ?>" from_id="<?php echo $user_id; ?>" c_type="call">Voice Call</a> -->
                                        <!-- <a class="user_call treines_cal_btn" href="javascript:void(0);" t_type="trainer" to_id="<?php echo $t['user_id']; ?>" from_id="<?php echo $user_id; ?>" c_type="chat">Chat</a> -->
                                        <a class="btn btn-default user_call treines_cal_btn" href="javascript:void(0);" t_type="trainer" to_id="<?php echo $t['user_id']; ?>" from_id="<?php echo $user_id; ?>" title="Text Chat" c_type="chat"><i class="fa fa-weixin"></i></a>
                                        </div>
                                        <!-- jayendra end -->
                                    </div>
                                </div>
                            </li>
                        </a>
                        <?php } ?>
                          
                        </ul>
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
