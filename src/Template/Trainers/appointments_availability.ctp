<?php include "trainer_dashboard.php"; ?>
<div class="calendor_main">
<div class="top_bar_wrap">
            <div class="container">
              <div class="row">
                <div class="col-md-12 col-sm-12">
                  <div class="tbw_text">
                  <i class="fa fa-calendar"></i> set your availability
  
                  </div>
                  <div class="step_box">
                    Step 1 of 3
                  </div>
              </div>
             </div>
           </div>
         </div>
    <section class="calendor_wrap">
            <div class="head_row">
            </div>
            <div class="container">
               <div class="row">
                <form method="post" id="trainer_form">
                  <div class="col-md-6 col-sm-6">
                    <div class="top_text">Please select the date and time which you are unable for booking request.</div>
                    <!-- Responsive calendar - START -->
                        <div class="responsive-calendar">
                        <div class="controls clearfix">
                        <h4><span data-head-year></span> <span data-head-month></span></h4>
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
                  <div class="col-md-6 col-sm-6">
                  <div class="calendor_caption_box">
                    <div class="heading_payment_main">
                          </div>
                    <div class="calendor_caption session_content scroll_content">
                    
                    <?php 
                    if(!empty($time_slots)){
                      $times = unserialize($time_slots[0]['times']);
                    }else{
                      $times = array('0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0');
                    }
                    for ($i=0; $i < count($times); $i++) { ?>
                     <div class="checkbox">
                       <div class="roundedOne">
                          <input <?php if($times[$i] == 1) echo "checked"; ?> type="checkbox" class="time" value="0" main="<?php echo $i; ?>" id="roundedOne_<?php echo $i; ?>" />
                          <label for="roundedOne_<?php echo $i; ?>"></label>
                          <input type="hidden" name="times[]" class="hidden_time" id="time_<?php echo $i; ?>" value="<?php echo $times[$i]; ?>"/>
                        </div>
                        <div class="chekbox_txt"> <span><?php echo $this->Custom->getTimeSlots($i); ?></span><?php echo $this->Custom->getTimeSlots($i+1); ?></div>
                    </div>
                    <?php } ?>
                    </div>
                  </div>
               </div>
               <input type="hidden" id="selected_date" name="selected_date" value="<?php echo date('Y-m-d'); ?>">
               <div class="row">
                 <div class="col-md-12 col-sm-12">
                   <div class="calendor_switches_wrap">
                   <div class="heading_payment_main">
                          </div>
                          <div class="session_content">
                      <div class="calendor_switches_head clearfix">
                          <div class="cs_head_left pull-left">
                            <a href="javascript:void(0);" id="cancel-btn" >cancel</a>
                          </div>
                          <div class="cs_head_right pull-right">
                          <a href="javascript:void(0);" id="save-btn"> save changes</a>
                          </div>
                      </div>
                      <div class="calendor_switches_content">
                        <p>Various Dates </p>
                        <div class="switch_button">
                         <ul class="clearfix">
                           <li class="active"><a href="javascript:void(0);" main="0" class="selection-btn">available</a></li>
                           <li><a href="javascript:void(0);" main="1" class="selection-btn">blocked</a></li>
                         </ul>
                    </div>
                        </div>
                      </div>
                    </div>
                    <div class="calendor_switches_wrap">
                     <div class="heading_payment_main">
                          </div>
                          <div class="session_content">
                           <div class="calendor_switches_head clearfix">
                          <div class="cs_head_left pull-left">
                           <a href="javascript:void(0);" id="cancel-btn"> cancel</a>
                          </div>
                          <div class="cs_head_left">
                            <a href="javascript:void(0);" class="select_all"><span>select all</span></a>
                            <a href="javascript:void(0);" style="display:none;" class="unselect_all"><span>unselect all</span></a>
                          </div>
                          <div class="cs_head_right pull-right">
                           <a href="javascript:void(0);" id="save-btn">save changes</a>
                          </div>
                      </div>
                      <div class="calendor_switches_content">
                        <p>Various times </p>
                        <div class="switch_button">
                       <ul class="clearfix">
                           <li ><a href="javascript:void(0);" main="0" class="selection-btn1">available</a></li>
                           <li class="active"><a href="javascript:void(0);" main="1" class="selection-btn1">blocked</a></li>
                         </ul>
                         </div>
                        </div>
                      </div>
                      </div>
                    </div>
                 </div>
               </div>
              </form>
            </div>
        </section>
   </div>
    
    <script type="text/javascript">
      $(document).ready(function () {
        $(".responsive-calendar").responsiveCalendar({
          time: "<?php date('Y-m'); ?>",
        });
      });
    </script>
    <script type="text/javascript">
    $(document).ready(function(){

      $('body').on('click','.select_all',function(){
        $('.select_all').hide();
        $('.unselect_all').show();
        $('.time').each(function() { 
            this.checked = true;  
        });
        $('.hidden_time').each(function(){
            $(this).val('1');
        });
      });

      $('body').on('click','.unselect_all',function(){
        $('.select_all').show();
        $('.unselect_all').hide();
        $('.time').each(function() { 
            this.checked = false;  
        });
        $('.hidden_time').each(function(){
            $(this).val('0');
        });
      });

      $('body').on('change','.time',function(){
        var i = $(this).attr('main');
        if(this.checked){
          $(this).val('1');
          $('#time_'+i).val('1');
        }else{
          $(this).val('0');
          $('#time_'+i).val('0');
        }
      });

      $('body').on('click','div.day > a',function(){
          var year  = $(this).attr('data-year');
          var month = ($(this).attr('data-month') >= 10) ? $(this).attr('data-month') : "0" + $(this).attr('data-month');
          var day = ($(this).attr('data-day') >= 10) ? $(this).attr('data-day') : "0" + $(this).attr('data-day');
          var date =  year + "-" + month + "-" + day;
          $('#selected_date').val(date);
          $('.day').removeClass('today');
          $(this).parent().addClass('today');
          $.ajax({
            url:"<?php echo $this->request->webroot; ?>trainers/getTimeSlotsDateWise",
            type:"post",
            data:{date:date},
            dataType:"json",
            success: function(response){
                $('.calendor_caption').html(response.message);
            },
            error:function(error){
                console.log(error);  
            }
        });
      });

      $('body').on('click','.selection-btn',function(){
          $('.selection-btn').parent().removeClass('active');
          $(this).parent().addClass('active');
          var type = $(this).attr('main');
          if(type == 1){
            $('.time').each(function() { 
              this.checked = true;  
            });
            $('.hidden_time').each(function(){
                  $(this).val('1');
            });
          }else{
            $('.time').each(function() { 
              this.checked = false;  
            });
            $('.hidden_time').each(function(){
                  $(this).val('0');
            });
          }
      });

      $('body').on('click','.selection-btn1',function(){
          $('.selection-btn1').parent().removeClass('active');
          $(this).parent().addClass('active');
      });

      $('body').on('click','#save-btn',function(){
        var form_data = new FormData($('#trainer_form')[0]);
        $.ajax({
            url:"<?php echo $this->request->webroot; ?>trainers/traineravailability",
            type:"post",
            data:form_data,
            dataType:"json",
            contentType:false,
            processData:false,
            success: function(response){
                console.log(response);
                showAlert('success','Success','Your availability successfully added');
            },
            error:function(error){
                console.log(error);  
            }
        });
      });

    });
    </script>
