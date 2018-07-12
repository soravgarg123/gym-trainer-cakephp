<?php include "trainer_dashboard.php"; ?>

    <section class="payment_details appointements_page">
         <div class="top_bar_wrap">
            <div class="container">
              <div class="row">
                <div class="col-md-12 col-sm-12">
                  <div class="tbw_text">
                  <i class="fa fa-book"></i> Manage Appointments 
  
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
                                      foreach($upcomingArr as $upcomingArr) { ?>
                                      <li>
                                        <div class="main_block">
                                            <div class="icon_block big_icon gray_color">
                                                <img src="<?php echo $this->Custom->getImageSrc('uploads/trainee_profile/'.$upcomingArr['trainee_image']) ?>">
                                            </div>
                                            <span class="client_name"><?php echo $upcomingArr['trainee_name']; ?></span>
                                            <div class="text_block">
                                                <div class="appointer_name"><?php echo date('d F, Y', strtotime($upcomingArr['training_date'])); ?> </br><?php echo $upcomingArr['training_time']; ?> </div> 
                                              <?php if(!empty($upcomingArr['latt_longg'])){ ?>
                                                <span class="txt_block"><?php echo $upcomingArr['training_adrees']; ?></span>
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
                                                <a href="javascript:void(0);" c_type="chat" t_type="trainer" from_id="<?php echo $from_id; ?>" to_id="<?php echo $upcomingArr['user_id']; ?>" class="user_call envelop-chat" title="Text Chat"><i class="fa fa-envelope-o" aria-hidden="true"></i></a>
                                                </div>
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
                                               <img src="<?php echo $this->Custom->getImageSrc('uploads/trainee_profile/'.$pa['trainee_image']) ?>">
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
                                                <span><b><?php echo ucwords($pa['trainee_name']); ?></b> has 24 hours to respond</span>
                                                <div class=" big_icon msg">
                                                    <a href="javascript:void(0);" c_type="chat" t_type="trainer" from_id="<?php echo $from_id; ?>" to_id="<?php echo $pa['trainee_id']; ?>" class="user_call envelop-chat" title="Text Chat"><i class="fa fa-envelope-o" aria-hidden="true"></i></a>
                                                </div>
                                                <div class="vew_details"><a title="View Details" href="<?php echo $this->request->webroot; ?>trainers/viewPendingAppointment?aid=<?php echo base64_encode($pa['app_id']); ?>">(view details)</a> </div>
                                            </div>
                                        </div>
                                    </li>
                                  <?php } } ?>
                                </ul>
                            </div>
                        </div>
               </div>
                <div class="row">
                         <div class="col-md-12 col-sm-12">
                              <div class="session_setails_sec missed_appointement">
                                 <div class="heading_payment_main">
                                      Missed Appointement
                                </div>   
                                 <div class="session_content scroll_content">
                                 <?php if(empty($missed_appo)) { ?>
                                  </br><center><h4>You have no missed appointments</h4></center></br>
                                 <?php } else { foreach($missed_appo as $m) {?>
                                  <div class="missed_wrap">
                                          <div class="missed_wrap_left pull-left">
                                              You have missed appointement <b><?php echo ucwords($m['trainee_name']." ".$m['trainee_lname']); ?></b>
                                              <span><b><?php echo ($m['training_type'] == 0) ? "Local" : "Virtual" ?>:</b> <?php echo date('d F, Y', strtotime($m['training_date'])); ?> @ <?php echo $m['training_time']; ?></span>
                                          </div>
                                           <div class="missed_wrap_right pull-right">
                                           <a href="<?php echo $this->request->webroot; ?>trainers/bookReschduleAppointment?asid=<?php echo base64_encode($m['app_session_id']); ?>" title="Click here to re-schedule appointment">Reschedule</a>
                                            </div>
                                            <div class="clearfix"></div>
                                    </div>
                                  <?php } } ?>
                                 </div> 
                               </div>
                         </div>
                     </div>
            </div>
</section>

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
          url:"<?php echo $this->request->webroot; ?>trainers/getUpcomingAppointmentsByDate",
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


