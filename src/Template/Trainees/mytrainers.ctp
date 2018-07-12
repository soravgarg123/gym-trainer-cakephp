<?php include "trainee_dashboard.php"; ?>

     <section class="trainee_dash_body">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="meal_plan_sec">

                      <!-- Tab panes -->
                      <div class="tab-content">
                        <?php echo $this->Custom->successMsg(); ?>
                        <?php echo $this->Custom->errorMsg(); ?>
                        <?php echo $this->Custom->loadingImg(); ?>
                       <div id="append_div">
                       <?php
                       if(empty($trainer_data)) { ?>
                       <div class="well"><center><h4>You don’t have any trainers*</h4></center></div>
                    <?php  }
                       else
                       { ?>
                       <ul class="row">
                        <?php 
                            foreach($trainer_data as $t)
                            { ?>
                        
                        <li class="col-sm-4 col-md-3">
                                <div class="trainer_chat_block">
                                    <div class="trainer_imgchat_block">
                                        <a class="trainer_profile_img" href="<?php echo $this->request->webroot; ?>mytrainerProfile/<?php echo base64_encode($t['user_id']); ?>">
                                    <?php
                                        if($t['trainer_image'] != "")
                                        { ?>
                                            <img src="<?php echo $this->Custom->getImageSrc('uploads/trainer_profile/'.$t['trainer_image']) ?>" alt="img" class="img-responsive">
                                    <?php }
                                        else
                                        { ?>
                                            <img style="height:260px;width:100%" src="<?php echo $this->request->webroot; ?>img/default-user.png" alt="img" class="img-responsive">
                                    <?php } ?>
                                        </a>
                                        <a class="favourite_btn1" main="<?php echo base64_encode($t['user_id']); ?>" title="Click To Make Favourite" href="javascript:void(0);"><i class="fa fa-heart"></i></a>
                                    </div>
                                    <div class="trainer_chat_info">
                                        <p><strong><a style="color:white;" href="<?php echo $this->request->webroot; ?>mytrainerProfile/<?php echo base64_encode($t['user_id']); ?>"> Trainer : </strong><?php echo ucwords($t['trainer_name']); ?> </a></p>
                                        <p><strong>Location : </strong> <?php echo $t['city_name']; ?></p>
                                        <div class="retting_box"><p><strong>Rank :</strong> <input class="trainer-rank" value="<?php echo $t['trainer_rating']; ?>" type="number" /><?php echo $t['trainer_rating']; ?></p></div>
                                        <div class="trai_rank">
                                        
                                        <a class="btn btn-default" main="<?php echo base64_encode($t['user_id']); ?>" title="Review & Rating" href="<?php echo $this->request->webroot; ?>trainees/trainerRating/<?php echo base64_encode($t['user_id']); ?>"><i class="fa fa-star"></i></a>
                                        <!-- jayendra start -->
                                        <?php  
                                        if(empty($session))
                                        { ?>
                                            <a class="btn btn-default blank_session" href="javascript:void(0);"  title="Video Call"><i class="fa fa-video-camera"></i></a>
                                        <?php }
                                        if(!empty($session))
                                        {  
                                        if($session[0]['updated_sessions'] == $session[0]['sessions']) { ?>
                                            <a class="btn btn-default blank_session" href="javascript:void(0);"  title="Video Call"><i class="fa fa-video-camera"></i></a>
                                        <?php }
                                        else { ?>
                                            <a class="btn btn-default user_call" href="javascript:void(0);" t_type="trainee" to_id="<?php echo $t['user_id']; ?>" from_id="<?php echo $user_id; ?>" title="Video Call" c_type="video"><i class="fa fa-video-camera"></i></a>
                                        <?php } };?>
                                        <a class="btn btn-default user_call" href="javascript:void(0);" t_type="trainee" to_id="<?php echo $t['user_id']; ?>" from_id="<?php echo $user_id; ?>" title="Voice Call" c_type="call"><i class="fa fa-phone"></i></a>  
                                        <a class="btn btn-default user_call" href="javascript:void(0);" t_type="trainee" to_id="<?php echo $t['user_id']; ?>" from_id="<?php echo $user_id; ?>" title="Text Chat" c_type="chat"><i class="fa fa-weixin"></i></a>
                                        </div>
                                        <!-- jayendra end -->
                                    </div>
                                </div>
                            </li>
                        <?php } ?>
                        </ul> 
                        <?php } ?>
                        </div>
                       
                      </div>
                      <!-- <input type="button" id="test_call" value="Test call"> -->
                    
                    </div>
                </div>
            </div>
            
            
        </div>
     </section>   
        
    </div>
    <!--Main container sec end-->

<!-- Make Favourite Start -->
  
  <script type="text/javascript">
  $(document).ready(function(){
    $('.favourite_btn1').click(function(){
    var trainer_id = $(this).attr('main');
    $('img#loading-img').show();
    $.ajax({
            url:"<?php echo $this->request->webroot; ?>trainees/makeFavourite",
            type:"post",
            data:{trainer_id : trainer_id},   
            dataType : "json",                 
            success: function(data){
                $('img#loading-img').hide();
                $('html, body').animate({ scrollTop: $("#append_div").offset().top }, 1000);
                if(data.message == "")
                {
                    $("div#success_msg").html("<center><i class='fa fa-check'> Trainer Successfully Added In Favourites List </i></center>").show();
                    $("div#error_msg").hide();
                }
                else
                {
                    $("div#error_msg").html("<center><i class='fa fa-times'>  Trainer Already Added in Favourites List !</i></center>").show();
                    $("div#success_msg").hide();
                }

        }
        });
    });
  });
  </script>

<!-- Make Favourite  End -->

<!-- Session Condition Start -->  

<script type="text/javascript">
    $(document).ready(function(){
        $('.blank_session').click(function(){
            $("div#error_msg").html("<center><i class='fa fa-times'> Insufficient funds.  Please add personal session plans to your account to begin. </i></center>").show();
            $('html, body').animate({ scrollTop: $("#append_div").offset().top }, 1000);
        });
    });
</script>

<!-- Session Condition End -->
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
