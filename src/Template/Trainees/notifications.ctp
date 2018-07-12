  <?php include "trainee_dashboard.php"; ?>
     <section class="trainee_dash_body">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="meal_plan_sec">
                      <div class="tab-content">
                      <?php echo $this->Flash->render('edit') ?>    
                        <div class="panel_block notification">
                        <div class="panel_block_heading">
                            <h4>Notification</h4>
                        </div>
                        <div class="notification_panel_body">
                            <ul id="accordion" role="tablist">
                            <?php $i = 1; foreach($noti_data as $nd) { 
                            if($nd['noti_type'] == "Decline Appointment" || $nd['noti_type'] == "Approve Appointment") { ?>
                              <li class="panel" id="appo_<?php echo $nd['noti_id']; ?>">
                                <div class="panel-heading">
                                <div class="pbb_left">
                                  <div class="pbbl_img">
                                    <img src="<?php echo $this->Custom->getImageSrc('uploads/trainer_profile/'.$nd['trainer_image']) ?>" alt="img" class="img-circle">
                                  </div>
                                  <div class="pbbl_txt">
                                    <h5><?php echo ucwords($nd['trainer_name']." ".$nd['trainer_lname']." ".$nd['noti_message']); ?> </strong></h5>
                                  </div>
                                </div>
                                <div class="view_btn_main">
                                  <a href="javascript:void(0);" class="btn btn-success app-view-btn noti-view-btn" main="<?php echo $nd['parent_id']; ?>">View</a>
                                </div>
                                <div class="pbb_right">
                                  <div class="mesg_time">
                                    <?php echo time_elapsed_string($nd['noti_added_date']); ?>
                                  </div>
                                </div>
                              <div class="clearfix"></div>
                              </div>
                              <div id="notification<?php echo $nd['noti_id']; ?>" class="panel-collapse collapse">
                                  <div class="panel-body">
                                   
                                  </div>
                              </div>
                              </li>
                            <?php } 
                            if($nd['noti_type'] == "Make Special Offer") { ?>
                              <li class="panel" id="appo_<?php echo $nd['noti_id']; ?>">
                                <div class="panel-heading">
                                <div class="pbb_left">
                                  <div class="pbbl_img">
                                    <img src="<?php echo $this->Custom->getImageSrc('uploads/trainer_profile/'.$nd['trainer_image']) ?>" alt="img" class="img-circle">
                                  </div>
                                  <div class="pbbl_txt">
                                    <h5><?php echo ucwords($nd['trainer_name']." ".$nd['trainer_lname']." ".$nd['noti_message']); ?> </strong></h5>
                                  </div>
                                </div>
                                <div class="view_btn_main">
                                  <a href="javascript:void(0);" class="btn btn-success app-special-offer-btn noti-view-btn" main="<?php echo $nd['parent_id']; ?>">View</a>
                                </div>
                                <div class="pbb_right">
                                  <div class="mesg_time">
                                    <?php echo time_elapsed_string($nd['noti_added_date']); ?>
                                  </div>
                                </div>
                              <div class="clearfix"></div>
                              </div>
                              <div id="notification<?php echo $nd['noti_id']; ?>" class="panel-collapse collapse">
                                  <div class="panel-body">
                                   
                                  </div>
                              </div>
                              </li>
                            <?php } ?>
                            <?php $i++; } ?>
                            </ul> 
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


<!-- Modal for special offer start-->
<div class="modal fade custom_model" id="Special_Offer" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">

        <div class="modal-content">
            <div class="modal-header">
                <div class="heading_payment_main">
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Special Offer</h4>
            </div>
            <div class="modal-body">
                <div class="session_user">
                    <div class="img_user_main">
                        <div class="small_circle"></div>
                        <div class="img_user"><img src="" id="so-img" class="img-responsive">
                        </div>
                    </div>
                    <div class="img_text_main" id="sp-profile">
                        
                    </div>
                </div>
                <div class="head_custom">
                    <div class="icon_block big_icon ">
                        <i class="fa fa-calendar"></i>
                    </div> Sessions Details
                </div>
                <ul class="session_content scroll_content mCustomScrollbar _mCS_1 noti-view-session" id="so-sessions">
                   
                </ul>
            </div>
            <div class="modal-footer">
                <div class="custom_model_bottom">
                    <p>Total price <span class="pull-right so-final-price"></span>
                    </p>
                    <button type="button" title="Approve" class="btn respond-section" id="so-approve-btn" main="1" appid="">Approve</button>
                    <button type="button" title="Decline" class="btn decline respond-section" id="so-decline-btn" main="2" appid="">Decline</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal for special offer end-->

<!-- Modal for Respond Now start-->
<div class="modal fade custom_model" id="respond_now" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="heading_payment_main">
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Appointment View</h4>
            </div>
            <div class="modal-body">
                <div class="session_user">
                    <div class="img_user_main">
                        <div class="small_circle"></div>
                        <div class="img_user"><img src="" id="app-view-user-img"class="img-responsive">
                        </div>
                    </div>
                    <div class="img_text_main" id="appo-view-profile-view">
                        
                    </div>
                </div>
                <div class="head_custom">
                    <div class="icon_block big_icon ">
                        <i class="fa fa-calendar"></i>
                    </div> Sessions Details
                </div>
                <ul class="session_content scroll_content mCustomScrollbar _mCS_1 noti-view-session" id="all-sessions-list">
                
                </ul>
            </div>
            <div class="modal-footer">
                <div class="custom_model_bottom">
                    <p>Total price <span class="pull-right final-app-price"></span>
                    </p>
                    <button type="button" class="btn decline app-view-status"></button>
                    <button type="button" class="btn decline" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>        
<!-- Modal for Respond Now end-->

<!-- Time Ago Script Start -->
  <?php
      function time_elapsed_string($datetime, $full = false)
      {
          $now     = new DateTime;
          $ago     = new DateTime($datetime);
          $diff    = $now->diff($ago);
          $diff->w = floor($diff->d / 7);
          $diff->d -= $diff->w * 7;
          
          $string = array(
              'y' => 'year',
              'm' => 'month',
              'w' => 'week',
              'd' => 'day',
              'h' => 'hour',
              'i' => 'minute',
              's' => 'second'
          );
          foreach ($string as $k => &$v) {
              if ($diff->$k) {
                  $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
              } else {
                  unset($string[$k]);
              }
          }
          
          if (!$full)
              $string = array_slice($string, 0, 1);
          return $string ? implode(', ', $string) . ' ago' : 'just now';
      }
  ?>

<!-- Time Ago Script End -->

<!--Update Notifications Start -->

<script type="text/javascript">
  $(document).ready(function(){

    $('body').on('click','.meal_plans_noti, .appoinment_status, .hire_status',function(){
      var noti_id = $(this).attr('main');
      $.ajax({
            url:"<?php echo $this->request->webroot; ?>trainees/updateNotification",
            type:"post",
            data:{noti_id:noti_id},
            dataType:"json",
            success: function(data){
                
            }
        });
    });

    $('body').on('click','.app-view-btn',function(){
      var id = $(this).attr('main');
      $.ajax({
            url:"<?php echo $this->request->webroot; ?>trainees/getNotificationData",
            type:"post",
            data:{id:id},
            dataType:"json",
            success: function(data){
              var result = data.message;
              console.log(result);
              var sessions = result.session_data;
              $('#app-view-user-img').attr('src','<?php echo $this->request->webroot; ?>uploads/trainee_profile/'+result[0]['trainee_image']);
              var profile_html = "";
              var sessionHTML  = "";
              var status  = "";
              profile_html +=  result[0]['trainee_name'] + " " + result[0]['trainee_lname'];
              profile_html +=  "<span>" + result.total_session +" Sessions - $"+result[0]['final_price']+"<span class='app_sttaus'></span></span></span>";
              $('#appo-view-profile-view').html(profile_html);
              for (var i = 1; i <= result.total_session; i++) {
                sessionHTML += '<li><div class="main_block"><div class="icon_block big_icon"><i class="fa fa-calendar"></i>';
                sessionHTML += '</div><div class="text_block">' + convertDate(sessions[i]['modified_dates']) + '</br> <span>' + sessions[i]['modified_times'] + '</span>';
                sessionHTML += '</div></div>'; 
                if(sessions[i]['location_address'] != ""){
                  sessionHTML += '<div class="icon_main"><div class="icon_block"><i class="fa fa-map-marker"></i> </div><div class="text_block">' + sessions[i]['location_address'] + '</div></div>';  
                }
              };
              $('#all-sessions-list').html(sessionHTML);
              if(result[0]['trainer_app_status'] == '2' && result[0]['trainee_app_status'] == '2'){
                status = "Declined";
              }
              if(result[0]['trainer_app_status'] == '1' && result[0]['trainee_app_status'] == '1'){
                status = "Approved";
              }
              $('.app_sttaus').text(status);
              $('.app-view-status').text(status);
              $('.final-app-price').text("$"+result[0]['final_price']);
              $('#respond_now').modal('show');
            }
        });
    });  

    $('body').on('click','.app-special-offer-btn',function(){
      var id = $(this).attr('main');
      $.ajax({
            url:"<?php echo $this->request->webroot; ?>trainees/getSpecialOfferData",
            type:"post",
            data:{id:id},
            dataType:"json",
            success: function(data){
              var result = data.message;
              var sessions = result.session_data;
              $('#so-img').attr('src','<?php echo $this->request->webroot; ?>uploads/trainer_profile/'+result[0]['trainer_image']);
              var profile_html = "";
              var sessionHTML  = "";
              var status  = "";
              profile_html +=  result[0]['trainer_name'] + " " + result[0]['trainer_lname'];
              profile_html +=  "<span>" + result.total_session +" Sessions - $"+result[0]['final_price']+"</span>";
              $('#sp-profile').html(profile_html);
              for (var i = 1; i <= result.total_session; i++) {
                sessionHTML += '<li><div class="main_block"><div class="icon_block big_icon"><i class="fa fa-calendar"></i>';
                sessionHTML += '</div><div class="text_block">' + convertDate(sessions[i]['modified_dates']) + '</br> <span>' + sessions[i]['modified_times'] + '</span>';
                sessionHTML += '</div></div>'; 
                if(sessions[i]['location_address'] != ""){
                  sessionHTML += '<div class="icon_main"><div class="icon_block"><i class="fa fa-map-marker"></i> </div><div class="text_block">' + sessions[i]['location_address'] + '</div></div>';  
                }
              };
              $('#so-sessions').html(sessionHTML);
              $('.so-final-price').text("$"+result[0]['special_offer_price']);
              $('.respond-section').attr('appid',btoa(result[0]['app_id']));
              $('#Special_Offer').modal('show');
            }
        });
    }); 

    $('body').on('click','.respond-section',function(){
      var type  = $(this).attr('main');
      var appid = $(this).attr('appid');
      window.location.href = "<?php echo $this->request->webroot; ?>trainees/specialOfferrespond?type="+type+"&appid="+appid;
    });

  });

function convertDate(val) 
    {
      var t = val.split(/[- :]/);
      var month = ['January','February','March','April','May','June','July','August','September','October','November','December'];
      var mo = parseInt(t[1]);
      var newmonth  = month[mo-1];
      var s = newmonth+' '+t[2]+' '+t[0];
      return s;
    }
</script>

<!--Update Notifications End -->


