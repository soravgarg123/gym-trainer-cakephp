<?php include "trainee_dashboard.php"; ?>

    <section class="payment_details appointements_page">
         <div class="top_bar_wrap">
            <div class="container">
              <div class="row">
                <div class="col-md-12 col-sm-12">
                  <div class="tbw_text">
                  <i class="fa fa-book"></i> Appointments 
  
                  </div>
                  <div class="step_box">
                    Step 3 of 3
                  </div>
              </div>
             </div>
           </div>
         </div>
         <div class="container">
              
               <div class="row">
               <div class="col-md-4 col-sm-4">
                  <!-- Responsive calendar - START -->

                        <div class="responsive-calendar">
                        <div class="controls clearfix">
                        <h4 class="text-center"><span data-head-year></span> <span data-head-month></span></h4>
                            <a class="pull-left" data-go="prev"><div class="btn prev_btn "><i class="fa fa-angle-double-left"></i>
                            </div></a>
                            <a class="pull-right" data-go="next"><div class="btn next_btn"><i class="fa fa-angle-double-right"></i>
                            </div></a>
                        </div>
                        <div class="calendor_content">
                        <div class="heading_payment_main">
                          </div>
                          <div class="session_content">
                        <div class="day-headers">
                          <div class="day header">Sun</div>
                          <div class="day header">Mon</div>
                          <div class="day header">Tue</div>
                          <div class="day header">Wed</div>
                          <div class="day header">Thu</div>
                          <div class="day header">Fri</div>
                          <div class="day header">Sat</div>
                        </div>
                        <div class="days" data-group="days">
                         </div> 
                        </div>
                      </div>
                     </div>
      <!-- Responsive calendar - END -->
               </div>
                  <div class="col-md-4 col-sm-4">
                            <div class="appointement_head">
                                Upcoming Appointments
                            </div>
                            <div class="session_setails_sec appointement_sec mob_icon">
                                <div class="heading_payment_main">
                                </div>

                                <ul class="session_content scroll_content mCustomScrollbar _mCS_1" id="upcoming_section">
                                  <?php       
                                      if(empty($upcomingArr)){ ?>
                                        </br><center><h4>You have no upcoming appointments</h4></center>
                                    <?php }else{
                                    foreach ($upcomingArr as $u) { ?>
                                    <li>

                                        <div class="main_block">
                                            <div class="icon_block big_icon gray_color">
                                                <img src="<?php echo $this->Custom->getImageSrc('uploads/trainer_profile/'.$u['trainer_image']) ?>">
                                            </div>
                                            <span class="client_name"><?php echo $u['trainer_name']; ?></span>
                                            <div class="text_block">
                                                <div class="appointer_name"><?php echo date('d F, Y', strtotime($u['training_date'])); ?> </br><?php echo $u['training_time']; ?> </div> 
                                              <?php if(!empty($u['latt_longg'])){ ?>
                                                <span class="txt_block"><?php echo $u['training_adrees']; ?></span>
                                                <div class="icon_main block_icon">
                                                    <div class="icon_block"><i class="fa fa-map-marker"></i></i>
                                                    </div>
                                                </div>
                                              <?php } else { ?>
                                                <div class="icon_main">
                                                  <img style="width: 100%;" src="<?php echo $this->request->webroot; ?>img/favicon.ico" title="Virtual Training">
                                                </div>
                                              <?php } ?>
                                                <div class="timer">
                                                    <div id="defaultCountdown"></div>
                                                </div>
                                            </div>
                                            <div class="chat_box">
                                                <div class=" big_icon msg">
                                                <a href="javascript:void(0);"c_type="chat" t_type="trainer" from_id="<?php echo $from_id; ?>" to_id="<?php echo $u['user_id']; ?>" class="user_call envelop-chat" title="Text Chat"><i class="fa fa-envelope-o" aria-hidden="true"></i></a>
                                                </div>
                                                <!-- <div class="vew_details"><a href="#">(view details)</a> </div> -->
                                            </div>
                                        </div>
                                    </li>
                                  <?php } } ?>
                                </ul>
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-4">
                            <div class="appointement_head">
                                Pending Appointments
                            </div>
                            <div class="session_setails_sec appointement_sec pending_appointement">
                                <div class="heading_payment_main">

                                </div>

                                <ul class="session_content scroll_content mCustomScrollbar _mCS_1">
                                  <?php if(empty($pending_appointments)){ ?>
                                  </br><center><h4>You have no pending appointments</h4></center>
                                  <?php }else{ ?>
                                  <?php foreach($pending_appointments as $pa) { ?>
                                    <li>
                                        <div class="main_block">
                                            <div class="icon_block big_icon gray_color">
                                               <img src="<?php echo $this->Custom->getImageSrc('uploads/trainer_profile/'.$pa['trainer_image']) ?>">
                                            </div>
                                            <?php $session_data = unserialize($pa['session_data']); ?>
                                            <span class="client_name pending_confirm">pending confirmation</span>
                                            <div class="text_block text_block1">
                                                <div class="appointer_name gray_txt">
                                                    <p><?php echo count($session_data); ?> <?php echo (count($session_data) > 1) ? "Sessions" : "Session"; ?>  ($<?php echo round($pa['final_price'],2); ?>)
                                                    </p> </div> <span class="txt_block gray_txt"> </span>
                                                <div class="timer">
                                                    <div id="defaultCountdown"></div>
                                                </div>
                                            </div>
                                            <div class="chat_box">
                                                <span><b><?php echo ucwords($pa['trainer_name']); ?></b> has 24 hours to respond</span>
                                                <div class=" big_icon msg">
                                                    <a href="javascript:void(0);" c_type="chat" t_type="trainer" from_id="<?php echo $from_id; ?>" to_id="<?php echo $pa['trainer_id']; ?>" class="user_call envelop-chat" title="Text Chat"><i class="fa fa-envelope-o" aria-hidden="true"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                  <?php } } ?>
                                </ul>
                            </div>
                        </div>
                        </div>
                        <div class="row">

                        <div class="col-md-4 col-sm-4">
                              <div class="session_setails_sec missed_appointement mob_icon">
                                 <div class="heading_payment_main">
                                      Past Appointements
                                </div>   
                                 <div>
                                  <ul class="session_content scroll_content ">
                                    <?php if(empty($past_appo)){ ?>
                                    </br><center><h4>You have no past appointments</h4></center>
                                    <?php }else{ ?>
                                    <?php foreach($past_appo as $pa) { ?>
                                      <li>
                                        <div class="main_block">
                                            <div class="icon_block big_icon gray_color">
                                                <img src="<?php echo $this->Custom->getImageSrc('uploads/trainer_profile/'.$pa['trainer_image']) ?>">
                                            </div>
                                            <span class="client_name"><?php echo ucwords($pa['trainer_name']); ?></span>
                                            <div class="text_block">
                                                <div class="appointer_name"><?php echo date('d F, Y', strtotime($pa['training_date'])); ?> </br><?php echo $pa['training_time']; ?> </div>
                                                <?php if(!empty($pa['latt_longg'])){ ?>
                                                <span class="txt_block"><?php echo $pa['training_adrees']; ?></span>
                                                <div class="icon_main block_icon">
                                                    <div class="icon_block" data-toggle="modal" data-target="#location_model"><i class="fa fa-map-marker"></i></i>
                                                    </div>
                                                </div>
                                                <?php } else { ?>
                                                  <div class="icon_main">
                                                    <img style="width: 100%;" src="<?php echo $this->request->webroot; ?>img/favicon.ico" title="Virtual Training">
                                                  </div>
                                                <?php } ?>
                                                <div class="timer">
                                                    <div id="defaultCountdown"></div>
                                                </div>
                                            </div>         
                                        </div>
                                        <?php if($pa['training_status'] == 0) { ?>
                                         <div class=" radio_box ">
                                            <div class="radio_in">
                                                <input main="<?php echo $pa['app_session_id']; ?>" type="radio" value="completed" name="selector" id="f-option" class="app_status">
                                                <label for="f-option">Mark as completed</label>
                                                <div class="check"></div>
                                            </div>
                                             <div class="radio_in">
                                                <input main="<?php echo $pa['app_session_id']; ?>" type="radio" value="missed" name="selector" id="s-option" class="app_status">
                                                <label for="s-option">Mark as missed</label>
                                                <div class="check"><div class="inside"></div></div>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                        <?php }
                                        else if($pa['training_status'] == 1) { ?>
                                          <div class="completed-section"><input class="trainer-rank" value="<?php echo $pa['app_rating']; ?>" type="number" /></div>
                                        <?php }
                                        else { ?>
                                          <span class="missed-section">Re-scheduled</span>
                                        <?php } ?>
                                    </li>
                                    <?php } } ?>
                                  </ul>
                                 </div> 
                               </div>
                         </div> 

                         <div class="col-md-8 col-sm-8">
                              <div class="session_setails_sec missed_appointement ">

                                 <div class="heading_payment_main">
                                      Missed Appointements
                                </div>   
                                 <div class="session_content scroll_content">
                                 <?php if(empty($missed_appo)) { ?>
                                  </br><center><h4>You have no missed appointments</h4></center></br>
                                 <?php } else { foreach($missed_appo as $m) {?>
                                   <div class="missed_wrap">
                                        <div class="missed_wrap_left pull-left">
                                            You have missed appointement <b><?php echo ucwords($m['trainer_name']." ".$m['trainer_lname']); ?></b>
                                            <span><b><?php echo ($m['training_type'] == 0) ? "Local" : "Virtual" ?>:</b> <?php echo date('d F, Y', strtotime($m['training_date'])); ?> @ <?php echo $m['training_time']; ?></span>
                                        </div>
                                    </div>
                                <?php } } ?>
                                 </div> 
                                 
                               </div>
                         </div>

                         
                     </div>
               </div>
            </div>
        </section>

<!--review Modal start -->
<div class="modal fade" id="review" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">
<i class="fa fa-star-o" aria-hidden="true"></i> Give Your Feedback</h4>
      </div>
      <div class="modal-body">
      <form method="post" id="rating_form">
        <div class="panel review_question_sect">
          <div class="heading_payment_main"><span>1</span> Overall experiance with your trainer? </div>
          <div class="session_content">
            <div class="question_star_rat">
                <input class="rating-input" id="question1" required name="question1" type="number" />
            </div>
          </div>
        </div>
        <input type="hidden" name="app_session_id" id="app_session_id">
        <div class="panel review_question_sect">
            <div class="heading_payment_main"><span>2</span> Was your trainer knowledgeable? </div>
            <div class="session_content">
              <div class="question_star_rat">
                <input class="rating-input" id="question2" name="question2" type="number" />
              </div>
            </div>
        </div>
        <div class="panel review_question_sect">
          <div class="heading_payment_main"><span>3</span> Was all your questions answered? </div>
          <div class="session_content">
            <div class="question_star_rat">
              <input class="rating-input" id="question3" name="question3" type="number" />
            </div>
          </div>
        </div>
        <div class="panel review_question_sect">
          <div class="heading_payment_main"><span>4</span> Professionalism? </div>
          <div class="session_content">
            <div class="question_star_rat">
              <input class="rating-input" id="question4" name="question4" type="number" />
            </div>
          </div>
        </div>
        <div class="panel review_question_sect">
          <div class="heading_payment_main"><span>5</span> Would you recommend to others? </div>
          <div class="session_content">
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
            <button class="btn submit_btn" type="button" id="rating-btn">Submit</button>
            </div>
        </div>
      </form>
      </div>
    </div>
  </div>
</div>
<!--review Modal end -->

<script type="text/javascript">
  $(document).ready(function(){

  $('.responsive-calendar').responsiveCalendar({
  onInit:function(){
    $(".al_heading h4").text( $(this).data('year'));
    },
    allRows:false,
    startFromSunday:true,
    events: <?php echo json_encode($app_counts); ?>
  });

  $('body').on('click','div.day > a',function(){
        var year  = $(this).attr('data-year');
        var month = ($(this).attr('data-month') >= 10) ? $(this).attr('data-month') : "0" + $(this).attr('data-month');
        var day = ($(this).attr('data-day') >= 10) ? $(this).attr('data-day') : "0" + $(this).attr('data-day');
        var date =  year + "-" + month + "-" + day;
        $('.day').removeClass('today');
        $(this).parent().addClass('today');
        $.ajax({
          url:"<?php echo $this->request->webroot; ?>trainees/getUpcomingAppointmentsByDate",
          type:"post",
          data:{date:date},
          dataType:"json",
          beforeSend: function() {
              $('.loading').show();
              $('.loading_icon').show();
          }, 
          success: function(response){
            var appendHTML = response.message;
            $('#upcoming_section').html(appendHTML);
            $('.loading').hide();
            $('.loading_icon').hide();
          },
          error:function(error){
              console.log(error);  
              $('.loading').hide();
              $('.loading_icon').hide();
          }
      });
    });

  });
</script>

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
    if($('#message').val() == ""){
        showAlert('error','Error','Please enter feedback message !!');
        return false;
    }
    var data = $('#rating_form').serialize();
    $.ajax({
            url:"<?php echo $this->request->webroot; ?>trainees/insertRating",
            type:"post",
            data:data,   
            dataType : "json",                 
            success: function(data){
              var result = data.message;
              if(result > 0){
                showAlert('success','success','Appointment completed marked successfully');
                setTimeout(function(){
                  window.location.reload();
                },1000);
              }else{
                showAlert('error','Error','Failed please try again !!');
                return false;
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

<!-- Rating-Review & Missed Appoitnent Start -->

<script type="text/javascript">
  $(document).ready(function(){
    $('body').on('change','.app_status',function(){
      var type = $('.app_status:checked').val();
      var appId  = $(this).attr('main');
      if(type == "completed"){
        $('#app_session_id').val(appId);
        $('#review').modal('show');
      }else{
        if (confirm("Are You Sure?")) {
          window.location.href = "<?php echo $this->request->webroot; ?>trainees/markMissedAppointment?appid="+btoa(appId);
        }
        else{
          $('input[value="missed"]').prop('checked',false);
          return false;
        }
      }
    });
  });
</script>

<!-- Rating-Review & Missed Appoitnent End -->

