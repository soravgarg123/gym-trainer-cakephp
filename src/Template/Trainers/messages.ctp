<?php include "trainer_dashboard.php"; ?>
     <section class="trainee_dash_body">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="meal_plan_sec">

                      <!-- Tab panes -->
                    <div id="msg_tab">
                    <div class="panel_block_heading">
                        <h4>Messages</h4>
                    </div>
                    </div>
                      <div class="">
                    <div class="">
                <div class="conversation-wrap col-lg-3 col-md-3 col-sm-3">
                <?php
                if(empty($all_trainees)) { ?>
                <div class="well"><center>Not found any trainees </center></div>
               <?php }
                else
                {
                    $i=1;
                    foreach($all_trainees as $td) { ?>
                    <div  c_type="chat" from_id="<?php echo $from_id; ?>" to_id="<?php echo $td['user_id']; ?>" t_type="trainer" id="mesg_div_<?php echo $td['user_id']; ?>" class="media conversation side_users <?php if($i == 1) echo "active";?>" main="<?php echo base64_encode($td['user_id']); ?>">
                        <a class="pull-left" href="<?php echo $this->request->webroot; ?>trainers/traineeReport/<?php echo base64_encode($td['user_id']); ?>">
                            <img class="media-object" style="width: 50px; height: 50px;" src="<?php echo $this->Custom->getImageSrc('uploads/trainee_profile/'.$td['trainee_image']) ?>">
                        </a>
                        <div class="media-body">
                            <h5 class="media-heading"><?php echo substr(ucwords($td['trainee_name']),0,25); ?></h5>
                            <small><?php echo substr($td['trainee_displayName'],0,30); ?></small>
                        </div>
                    </div>
                <?php $i++; } } ?>
                </div>
                <div class="message-wrap col-lg-9 col-md-9 col-sm-9">
                    <div class="msg-wrap" id="chat_msgs">
                    <?php
                if(empty($chat_data)) { ?>
                <div><center>You have no new messages</center></div>
               <?php }
                else
                {
                foreach($chat_data as $cd) { 
                    // trainer_messages
                if($cd['chat_reciever_id'] != $trainer_id) { ?>
                <div class="media msg" id="msg_body_<?php echo $cd['chat_id'];?>">
                        <a class="pull-left" href="<?php echo $this->request->webroot; ?>trainers/profile">
                            <img class="media-object" style="width: 32px; height: 32px;" src="<?php echo $this->Custom->getImageSrc('uploads/trainer_profile/'.$profile_details[0]['trainer_image']) ?>">
                        </a>
                        <div class="media-body">
                            <small class="pull-right"><i class="fa fa-clock-o"></i> <?php echo date('d F y,h:i A', strtotime($cd["chat_added_date"])); ?></small>
                            <h5 class="media-heading"><?php echo ucwords($profile_details[0]['trainer_name']); ?></h5>
                            <small><?php echo $cd['chat_messsage']; ?></small>
                        </div>
                        </br><span class="delete_msgs" main="<?php echo $cd['chat_id'];?>" style="float:right;cursor:pointer;"><i class="fa fa-trash-o" title="Delete Message"></i></span>
                    </div>
                    <hr>
                <?php } 
                // trainee_messages
                else { ?>
                <div class="media msg" id="msg_body_<?php echo $cd['chat_id'];?>">
                        <a class="pull-left" href="<?php echo $this->request->webroot; ?>trainers/traineeReport/<?php echo base64_encode($trainee_details[0]['user_id']); ?>">
                            <img class="media-object" style="width: 32px; height: 32px;" src="<?php echo $this->Custom->getImageSrc('uploads/trainee_profile/'.$trainee_details[0]['trainee_image']) ?>">
                        </a>
                        <div class="media-body">
                            <small class="pull-right"><i class="fa fa-clock-o"></i> <?php echo date('d F y,h:i A', strtotime($cd["chat_added_date"])); ?></small>
                            <h5 class="media-heading"><?php echo ucwords($trainee_details[0]['trainee_name']); ?></h5>
                            <small><?php echo $cd['chat_messsage']; ?></small>
                        </div>
                        </br><span class="delete_msgs" main="<?php echo $cd['chat_id'];?>" style="float:right;"><i class="fa fa-trash-o" title="Delete Message"></i></span>
                    </div>
                    <hr>
                <?php } } } ?>
                     <div class="text_area">
                        <textarea user="<?php echo $from_id; ?>" to_id="<?php echo $trainee_details[0]['user_id']; ?>" main_id="<?php echo $trainee_details[0]['user_id']; ?>" placeholder="Write your message here" class="form-control" ></textarea>
                        <!-- <form class="soravgarg" id="send_file1">
                            <div class="file_attched_field">
                                <span class="fa fa-paperclip"></span>
                                <input type="file" name="chat_file" class="chat_file_ZDxq8Gz1ALIaJb2" unique="ZDxq8Gz1ALIaJb2" to_id="94" uid="62">
                            </div>
                        </form> -->
                    </div> </br>
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

<!-- Side Users Messages Start -->

<script type="text/javascript">
    $(document).ready(function(){
    $('#chat_msgs').animate({scrollTop: $('#chat_msgs')[0].scrollHeight}, 1);
    $('body').on('click','.side_users',function(){
    var trainee_id = $(this).attr('main');
        $.ajax({
                url:"<?php echo $this->request->webroot; ?>trainers/getMessages",
                type:"post",
                data:{trainee_id:trainee_id},
                dataType:"json",
                beforeSend: function() {
                  $('.loading').show();
                  $('.loading_icon').show();
                },  
                success: function(data){
                    $('.side_users').removeClass('active');
                    $('#mesg_div_'+atob(trainee_id)).addClass('active');
                    $('#chat_msgs').html(data.message);
                    $('.loading').hide();
                    $('.loading_icon').hide();
                }
            });
    });
    $('body').on('click','.delete_msgs',function(){
        var chatid = $(this).attr('main');
        $.ajax({
                url:"<?php echo $this->request->webroot; ?>trainers/deleteChatMessages",
                type:"post",
                data:{chatid:chatid},
                dataType:"json",
                success: function(data){
                    $('#msg_body_'+chatid).remove();
                }
            });
    });
    });
</script>


<!-- Side Users Messages End -->
