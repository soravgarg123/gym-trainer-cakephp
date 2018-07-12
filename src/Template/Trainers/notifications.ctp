<?php include "trainer_dashboard.php"; ?>
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
                            <?php $i = 1; foreach($noti_data as $nd) { ?>
                              <li class="panel" id="appo_<?php echo $nd['noti_id']; ?>">
                                <div class="panel-heading">
                                
                                <div class="pbb_left">
                                  <div class="pbbl_img">
                                    <img src="<?php echo $this->Custom->getImageSrc('uploads/trainee_profile/'.$nd['trainee_image']) ?>" alt="img" class="img-circle">
                                  </div>
                                  <div class="pbbl_txt">
                                    <h5><?php echo ucwords($nd['trainee_name']." ".$nd['trainee_lname']." ".$nd['noti_message']); ?> </strong></h5>
                                  </div>

                                </div>
                                <div class="view_btn_main">
                                <!-- <a href="javascript:void(0);" class="btn btn-success app-view-btn" main="<?php echo $nd['parent_id']; ?>">View</a>  -->
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
    $('body').on('click','.appoinment_status',function(){
      var noti_id = $(this).attr('main');
      $.ajax({
            url:"<?php echo $this->request->webroot; ?>trainers/updateNotification",
            type:"post",
            data:{noti_id:noti_id},
            dataType:"json",
            success: function(data){
                
            }
        });
    });
  });
</script>

<!--Update Notifications End -->



