<?php include "trainee_dashboard.php"; ?>

<form method="post" id="booking_session_form" action="<?php echo $this->request->webroot; ?>trainees/confirmPay">
<div class="top_bar_wrap sec_pad">
            <div class="container">
              <div class="row">
                <div class="col-md-12 col-sm-12">
                  <div class="tbw_text">
                  <i class="fa fa-calendar"></i> select session
  
                  </div>
                  <div class="step_box">
                    Step 2 of 3
                  </div>
              </div>
             </div>
           </div>
         </div>
    
    <section class="calendor_wrap">
           
           
            <div class="container">
            <div class="session_user">
              <div class="img_user"><img src="<?php echo $this->Custom->getImageSrc('uploads/trainer_profile/'.$trainer_details[0]['trainer_image']) ?>" class="img-responsive"></div> <?php if(!empty($trainer_details)) echo ucwords($trainer_details[0]['trainer_name'] ." ".$trainer_details[0]['trainer_lname']); ?>
            </div>
            <div class="top_row">
              <div class="row">
              <div class="col-md-3 col-sm-3 col-xs-4">
                <div class="drop_box dropdown">
                       <h2 aria-expanded="false" aria-haspopup="true" role="button" data-toggle="dropdown" id="change_session" class="dropdown-toggle"><?php echo $session; ?> Sessions  <i class="fa fa-caret-down"></i></h2>
                       <ul class="dropdown-menu">
                         <li><a main="1" class="select_session" href="javascript:void(0);">1 session</a></li>
                         <li><a main="3" class="select_session" href="javascript:void(0);">3 session</a></li>
                         <li><a main="10" class="select_session" href="javascript:void(0);">10 session</a></li>
                         <li><a main="20" class="select_session" href="javascript:void(0);">20 session</a></li>
                       </ul>
                       </div>
              </div>
               <div class="col-md-4 col-sm-3 col-xs-4">
                 <h2><i class="fa fa-calendar"></i> select date</h2>
              </div>
              <div class="col-md-5 col-sm-3 col-xs-4">
               <h2><i class="fa fa-clock-o"></i> select time</h2>
              </div>
            </div>
            </div>
             <div class="appointe_box">
                <div class="heading_payment_main">
                       </div>
                   <div class="session_content">
                    <div class="head_row"></br>
                      <h3 class="session_heading">session #01</h3>
                      <p>please fill in the following information and select the date and time</p>
                    </div>
                    <div class="row">
               <div class="col-md-3 col-sm-6">
                 <div class="preference_wrap">
                   <div class="pref_box pref_color1">
                      <h2 class="session_number"> 01 <span>session</span></h2>
                   </div>
                   <div class="pref_box pref_color2">
                   <div class="pop_over_main"> <span class="icon_block question_icon"><i class="fa fa-question"></i></span>
                                  <div class="pop_over">
                                     <h3>local</h3>
                                     <p>meet your trainre in person at a gym or a specific location</p>
                                     <h3>virtual</h3>
                                     <p>train virtually through our platform using our built in 1-1 video chat.Restriction apply as not supported on all devices . we recommend desktop and gogle chrome browser. </p>
                                      <a class="btn_okay" href="javascript:void(0);">okay</a>
                                 </div>
                               </div>
                     <h4>Select Training Preference</h4>
                     <ul>
                      <li>
                        <input type="radio" id="f-option" checked name="selector" value="0" class="local-option">
                        <label for="f-option">Local</label>
                        <div class="check"></div>
                      </li>
                      <li>
                        <input type="radio" id="s-option" name="selector" value="1" class="virtual-option">
                        <label for="s-option">Virtual</label>
                        <div class="check"><div class="inside"></div></div>
                      </li>
                      </ul>
                   </div>
                   <?php 
                      $own_location_details = $this->Custom->getlatlngbyip();
                      if(!empty($own_location_details) && $own_location_details['status'] != "fail"){
                        $lat = $own_location_details['lat'];
                        $lon = $own_location_details['lon'];
                        $address = $own_location_details['city']." ".$own_location_details['regionName']." ".$own_location_details['country'];
                      }else{
                        $lat = $profile_details[0]['lat'];
                        $lon = $profile_details[0]['lng'];
                        $address = $profile_details[0]['city_name']."-".$profile_details[0]['state_name'].",".$profile_details[0]['country_name'];
                      }
                    ?>
                   <div class="pref_box pref3">
                    <div class="location_section">
                      <p>please enter the address of your local meetup</p>
                      <div title="Select Location" main="2" class="icon_block select_location" title="Select Location"><i class="fa fa-map-marker"></i> </div>
                      <p class="location_address" title="<?php echo $address; ?>"><?php echo $address; ?></p>
                    </div>
                    <div class="virtual_section" style="display:none;">
                      <center>
                        <p>virtual training</p>
                        <img style="width: 15%;" src="<?php echo $this->request->webroot; ?>img/favicon.ico" title="Virtual Training">
                      </center>
                   </div> 
                   </div>
                 </div>
               </div>
                  <div class="col-md-4 col-sm-6">
                    <!-- Responsive calendar - START -->
                        <div class="responsive-calendar">
                        <div class="controls clearfix">
                        <h4 ><span data-head-year></span> <span data-head-month></span></h4>
                            <a class="pull-left" data-go="prev"><div class="btn prev_btn "><i class="fa fa-angle-double-left"></i>
</div></a>
                            
                            <a class="pull-right" data-go="next"><div class="btn next_btn"><i class="fa fa-angle-double-right"></i>
                            
</div></a>
                        </div>
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
      <!-- Responsive calendar - END -->
                  </div>
                  <div class="col-md-5 col-sm-12">
                    <div class="calendor_caption">

                    <?php 
                      if(!empty($time_slots)){
                        $times = unserialize($time_slots[0]['times']);
                      }else{
                        $times = array('0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0');
                      }
                      for ($i=0; $i < 24; $i++) {
                    ?>
                     
                      <div class="checkbox <?php echo ($times[$i] == 1) ? 'blocked_section' : '' ?>">
                       <div class="not_avail"><?php echo ($times[$i] == 1) ? 'Not Available' : 'Available' ?> </div>
                       <div class="roundedOne <?php echo ($times[$i] == 1) ? 'bookedlabel' : 'unbookedlabel' ?>">
                          <input <?php if($times[$i] == 1) echo "checked"; ?> <?php if($times[$i] == 1) echo "disabled"; ?> type="checkbox" class="time <?php echo ($times[$i] == 1) ? 'booked' : 'unbooked' ?>" value="0" time1="<?php echo $this->Custom->getTimeSlots($i); ?>" time2="<?php echo $this->Custom->getTimeSlots($i+1); ?>" main="<?php echo $i; ?>" id="roundedOne_<?php echo $i; ?>" />
                          <label for="roundedOne_<?php echo $i; ?>"></label>
                          <input type="hidden" name="times[]" class="hidden_time" id="time_<?php echo $i; ?>" value="<?php echo $times[$i]; ?>"/>
                        </div>
                        <div class="chekbox_txt"> 
                        <?php if($times[$i] == 1) { ?>
                          <span class="blocked_time"><?php echo $this->Custom->getTimeSlots($i); ?></span><?php echo $this->Custom->getTimeSlots($i+1); ?>
                        <?php } else{ ?>
                          <span><?php echo $this->Custom->getTimeSlots($i); ?></span><?php echo $this->Custom->getTimeSlots($i+1); ?>
                        <?php } ?>
                        </div>
                    </div>
                    <?php } ?>
                      
                      
                    </div>
                  </div>
                  <div class="col-md-12 col-sm-12">
                   <div class="request_btn save_nxt">
                    <?php if($session == 1) { ?>
                      <button type="button" id="save-preview-btn">Save & Preview</button>
                    <?php } else { ?>
                      <button type="button" id="back-btn" main="1" style="display:none;">back</button>
                      <button type="button" id="save-next-btn" main="1">Save & Next</button>
                      <button type="button" id="preview-btn" style="display:none;">preview</button>
                    <?php } ?>
                    </div>
                  </div>
               </div>
                  </div>
              </div>
               <div class="row">
                 <div class="col-md-12 col-sm-12">
                   <div class="price_box">
                     <div class="heading_payment_main">
                          <h5>price</h5>
                       </div>
                       <?php
                          $finalSessionPrice1 = $this->Custom->getSessionRate($session,$rates_plan);
                          $finalSessionPrice = round($finalSessionPrice1 * $session,2);
                          if(!empty($service_fee_details)){
                            $service_fee = $service_fee_details[0]['txn_fee'];
                          }else{
                            $service_fee = '0';
                          }
                          $finalServiceFee = round(($finalSessionPrice * $service_fee) / 100,2);
                        ?>
                        <input type="hidden" name="sessions_price" value="<?php echo $finalSessionPrice; ?>">
                        <input type="hidden" name="service_fee" value="<?php echo $finalServiceFee; ?>">
                        <input type="hidden" name="total_price" value="<?php echo $finalSessionPrice + $finalServiceFee; ?>">

                        <?php for ($i=1; $i <= $session; $i++) { ?>
                          <input type="hidden" name="booking[<?php echo $i; ?>][preference]" id="prefernce_val_<?php echo $i; ?>" value="0">
                          <input type="hidden" name="booking[<?php echo $i; ?>][status]" id="status_val_<?php echo $i; ?>" value="0">
                          <input type="hidden" name="booking[<?php echo $i; ?>][locations]" id="location_val_<?php echo $i; ?>" value="">
                          <input type="hidden" name="booking[<?php echo $i; ?>][location_address]" id="location_address_<?php echo $i; ?>" value="">
                          <input type="hidden" name="booking[<?php echo $i; ?>][modified_dates]" id="date_val_<?php echo $i; ?>" value="">
                          <input type="hidden" name="booking[<?php echo $i; ?>][modified_times]" id="time_val_<?php echo $i; ?>" value="">
                          <input type="hidden" id="time_main_val_<?php echo $i; ?>" value="">
                        <?php } ?>
                        <div class="price_box_content session_content mCustomScrollbar_mCS_4">
                          <ul>
                            <li>
                              $<?php echo $finalSessionPrice1; ?> x <?php echo $session; ?>  Sessions <span>$<?php echo $finalSessionPrice; ?></span></li>
                            <li>
                            Service Fee <div class="button_in"> <div class="pop_over_main"> <span class="icon_block question_icon"><i class="fa fa-question"></i></span>
                            <div class="pop_over">
                                 <h4>service fee</h4>
                                 <p>service fees let us provide 24 hours support that you love</p>
                                  <a href="javascript:void(0);" class="btn_okay">okay</a>
                            </div>
                            </div>
                            </div>
                            <span>$<?php echo $finalServiceFee; ?></span></li>
                            <li>total<span class="red_color">$<?php echo $finalSessionPrice + $finalServiceFee; ?></span></li>
                          </ul>
                       </div>
                   </div>
                    
                 </div>
                 <div class="col-md-12 col-sm-12">
                    <div class="request_btn">
                      <!-- <button>Request To Book</button> -->
                    </div>
                  </div>
               </div>
            </div>
        </section>
        <input type="hidden" id="rid" name="rid" value="<?php echo $rateid; ?>">
        <input type="hidden" id="tid" name="tid" value="<?php echo $trainer_id; ?>">
        <input type="hidden" id="totalsession" name="totalsession" value="<?php echo $session; ?>">
        <input type="hidden" id="trainer_id" name="trainer_id" value="<?php echo $trainer_details[0]['user_id']; ?>">
      </form>

<!-- Modal For Bookign Preview Start-->

<div class="modal fade custom_model" id="respond_now" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="heading_payment_main">
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Booking Session Preview</h4>
            </div>
            <div class="modal-body">
                <div class="session_user">
                    <div class="img_user_main">
                        <div class="small_circle"></div>
                        <div class="img_user">
                          <img src="<?php echo $this->Custom->getImageSrc('uploads/trainer_profile/'.$trainer_details[0]['trainer_image']) ?>" id="app-view-user-img"class="img-responsive">
                        </div>
                    </div>
                    <div class="img_text_main" id="appo-view-profile-view">
                          <?php if(!empty($trainer_details)) echo ucwords($trainer_details[0]['trainer_name'] ." ".$trainer_details[0]['trainer_lname']); ?>
                          <span><?php echo $session; ?> <?php echo ($session > 1) ? "Sessions" : "Session"; ?></span>
                    </div>
                </div>
                <div class="head_custom">
                    <div class="icon_block big_icon ">
                        <i class="fa fa-calendar"></i>
                    </div> Booking Sessions Details
                </div>
                <ul class="session_content scroll_content mCustomScrollbar _mCS_1 noti-view-session" id="so-sessions">
                    
                </ul>
            </div>
            <div class="modal-footer">
                <div class="custom_model_bottom">
                    <button type="button" class="btn decline" data-dismiss="modal">Close</button>
                    <button type="button" class="btn decline request-btn">Book</button>
                </div>
            </div>
        </div>
    </div>
</div>        

<!-- Modal For Bookign Preview End-->

<!-- Choose Location Modal Start -->

  <div class="modal fade" id="location_model" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel"><i class="fa fa-map-marker"></i> choose a location</h4>
        </div>
        <div class="modal-body">
          <input type="text" class="span6 form-control" name="keyword" id="keyword" placeholder="Select Location"></br>
           <div class="map_sec thumbnail" id="map-container">
             
           </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="save-location-btn">Save changes</button>
        </div>
      </div>
    </div>
  </div>

<!-- Choose Location Modal End -->

<script src="https://maps.googleapis.com/maps/api/js?libraries=places&sensor=false"></script>
  <script>
  function map_init(var_lati,var_long,var_markerTitle,var_contentString){
    
    var var_location = new google.maps.LatLng(var_lati,var_long);
  
    var var_mapoptions = {
      zoom: 14,
      mapTypeControl: false,
      center:var_location,
      panControl:false,
      rotateControl:false,
      streetViewControl: false,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    };
 
    var_map = new google.maps.Map(document.getElementById("map-container"), var_mapoptions);
 
    var_infowindow = new google.maps.InfoWindow({
      content: var_contentString
    });
    
    var_marker = new google.maps.Marker({
    position: var_location,
    map: var_map,
    title:var_markerTitle,
    icon : "<?php echo $this->request->webroot; ?>img/favicon.ico",
    maxWidth: 200,
    maxHeight: 200
    });

    input = document.getElementById("keyword");

    var autocomplete = new google.maps.places.Autocomplete(input);
    autocomplete.bindTo("bounds", var_map);

    google.maps.event.addListener(autocomplete, "place_changed", function()
    {
        place = autocomplete.getPlace();
        marker_title = place.formatted_address;
        lat_lng = place.geometry.location;
        if (!place.geometry) {
          window.alert("Please enter valid location");
          return;
        }

        if (place.geometry.viewport) {
            var_map.fitBounds(place.geometry.viewport);
        } else {
            var_map.setCenter(place.geometry.location);
            var_map.setZoom(15);
        }

        contentHTML = "";
        contentHTML += '<div id="mapInfo">';
        contentHTML += '<p><strong>' + marker_title + '</strong>';
        contentHTML += '</div>';

        var_infowindow.setContent(contentHTML);
        var_marker.setPosition(place.geometry.location);
        var_marker.setTitle(marker_title);
        var_infowindow.open(var_map, var_marker);
    });

    google.maps.event.addListener(var_marker, 'click', function() {
      var_infowindow.open(var_map,var_marker);
    });
 
      $('#location_model').on('shown.bs.modal', function () {
          google.maps.event.trigger(var_map, "resize");
          var_map.setCenter(var_location);
      });
  }
 
  $(document).on("click", ".select_location", function () {
    var total_no_sessions = parseInt('<?php echo $session; ?>');
    if(total_no_sessions == 1){
      var no  = 1;
    }else{
      var no  = $('#save-next-btn').attr('main');
    }
    var latlng = $('#location_val_'+no).val();
    var loc_addr = $('#location_address_'+no).val();
    if(latlng != "" && loc_addr != ""){
      lat_long_val = latlng;
      address_text = loc_addr;
    }else{
      lat_long_val = '<?php echo $lat; ?>'+","+'<?php echo $lon; ?>';
      address_text = '<?php echo $address; ?>';
    }
    var lat_long_arr = lat_long_val.split(",");
    map_init(lat_long_arr[0],lat_long_arr[1],address_text,
            '<div id="mapInfo">'+
            '<p><strong>'+ address_text +'</strong>'+
            '</div>');
    $('#keyword').val(address_text);
    $('#location_model').modal('show');
  });
</script>

<script type="text/javascript">
  $(document).ready(function(){
    total_sessions = parseInt('<?php echo $session; ?>');
    dateTimeArr = [];

    $('body').on('click','.select_session',function(){
      var session = $(this).attr('main');
      var rid     = $('#rid').val();
      var tid     = $('#tid').val();
      window.location.href= "<?php echo $this->request->webroot; ?>trainees/bookingSession?session="+session+"&rid="+rid+"&tid="+tid;
    });

    $('body').on('click','div.day > a',function(){
        var year  = $(this).attr('data-year');
        var month = ($(this).attr('data-month') >= 10) ? $(this).attr('data-month') : "0" + $(this).attr('data-month');
        var day = ($(this).attr('data-day') >= 10) ? $(this).attr('data-day') : "0" + $(this).attr('data-day');
        var date =  year + "-" + month + "-" + day;
        $('#selected_date').val(date);   
        var trainer_id = $('#trainer_id').val();
        $('.day').removeClass('today');
        $(this).parent().addClass('today');
        $.ajax({
          url:"<?php echo $this->request->webroot; ?>trainees/getTimeSlotsDateWise",
          type:"post",
          data:{date:date,trainer_id:trainer_id},
          dataType:"json",
          beforeSend: function() {
              $('.loading').show();
              $('.loading_icon').show();
          },     
          success: function(response){
              $('.calendor_caption').html(response.message);
              $('.loading').hide();
              $('.loading_icon').hide();
          },
          error:function(error){
              console.log(error);  
          }
        });
    });

    $('body').on('change','.time',function(){
        var i = $(this).attr('main');
        if(this.checked){
          $(this).val('1');
          $('#time_'+i).val('1');
          $('.unbooked').each(function() { 
            this.checked = false;  
          });
          $('#roundedOne_'+i).prop('checked',true);
        }else{
          $(this).val('0');
          $('#time_'+i).val('0');
        }
    });

    $('body').on('change','input[name="selector"]',function(){
      if(total_sessions == 1){
        var no  = 1;
      }else{
        var no  = $('#save-next-btn').attr('main');
      }
      var preference_val = $('input[name="selector"]:checked').val();
      $('#prefernce_val_'+no).val(preference_val);
      if(preference_val == 0){
        $('.virtual_section').hide();
        $('.location_section').show();
      }else{
        $('#location_val_'+no).val("");
        $('#location_address_'+no).val("");
        $('.virtual_section').show();
        $('.location_section').hide();
      }
    });

    $('body').on('click','#save-location-btn',function(){
      if(total_sessions == 1){
        var no  = 1;
      }else{
        var no  = $('#save-next-btn').attr('main');
      }
      $('#location_val_'+no).val(place.geometry.location.lat() + "," + place.geometry.location.lng());
      $('#location_address_'+no).val(marker_title);
      $('.location_address').text(marker_title);
      $('.location_address').attr('title',marker_title);
      $('#location_model').modal('hide');
    });

    $('body').on('click','#save-next-btn',function(){
      var no    = parseInt($(this).attr('main'));
      var year  = $('div.today > a').attr('data-year');
      var month = ($('div.today > a').attr('data-month') >= 10) ? $('div.today > a').attr('data-month') : "0" + $('div.today > a').attr('data-month');
      var day   = ($('div.today > a').attr('data-day') >= 10) ? $('div.today > a').attr('data-day') : "0" + $('div.today > a').attr('data-day');
      var date  =  year + "-" + month + "-" + day;
      $('#date_val_'+no).val(date);
      var time  = $('.unbooked:checked').attr('time1')+"-"+$('.unbooked:checked').attr('time2');
      $('#time_val_'+no).val(time);
      $('#time_main_val_'+no).val($('.unbooked:checked').attr('main'));
      var datetime = date +" "+ time;
      var preference_val = $('#prefernce_val_'+no).val();
      var errorMsgs = "";
      if($('#prefernce_val_'+no).val() == ""){
          errorMsgs += 'Please select training preference ..';
      }
      if(preference_val == 0){
        if($('#location_val_'+no).val() == ""){
            errorMsgs += 'Please select location .. ';
        }
      }
      if($('#date_val_'+no).val() == ""){
          errorMsgs += 'Please select training date ..';
      }
      if($('#time_val_'+no).val() == "undefined-undefined"){
          errorMsgs += 'Please select training time ..';
      }
      if(errorMsgs != ""){
        var nth_session1 = (no >= 10) ? no : "0" + no;
        showAlert('error','Error - Session '+nth_session1,errorMsgs);
        return false;
      }else{
        if(jQuery.inArray(datetime, dateTimeArr ) != -1 && dateTimeArr != "")
        {
          var nth_session1 = (no >= 10) ? no : "0" + no;
          showAlert('error','Error - Session '+nth_session1,'This Date & Time Alreay Selected !!');
          return false;
        }else{
          $('.unbooked').each(function() { 
            this.checked = false;  
          });
          no = parseInt(no + 1);
          $('#save-next-btn').attr('main',no);
          var nth_session = (no >= 10) ? no : "0" + no;
          if(total_sessions == nth_session)
          {
            $('#save-next-btn').hide(); 
            $('#preview-btn').show(); 
          }
          dateTimeArr.push(datetime);
          $('.loading').show();
          $('.loading_icon').show();
          $('#back-btn').show(); 
          $('.session_number').html(nth_session + "<span>Session</span>");
          $('.session_heading').text('session #'+nth_session);
          if($('#prefernce_val_'+no).val() != ""){
            if($('#prefernce_val_'+no).val() == 0){
              $('.location_address').text($('#location_address_'+no).val());
              $('.location_address').attr('title',$('#location_address_'+no).val());
              $('.virtual_section').hide();
              $('.location_section').show();
              $('.local-option').prop('checked',true);
            }else{
              $('.virtual_section').show();
              $('.location_section').hide();
              $('.virtual-option').prop('checked',true);
            }
          }else{
            $('.location_address').text('<?php echo $address; ?>');
            $('.location_address').attr('title','<?php echo $address; ?>');
            $('.virtual_section').hide();
            $('.location_section').show();
            $('.local-option').prop('checked',true);
          }
          if($('#time_main_val_'+no).val() == ""){
            $('.unbooked').prop('checked',false);
          }else{
            $('#roundedOne_'+$('#time_main_val_'+no).val()).prop('checked',true);
          }
          $('.loading').hide();
          $('.loading_icon').hide();
        }
      }
    });

    $('body').on('click','#back-btn',function(){
      $('.loading').show();
      $('.loading_icon').show();
      $('.unbooked').each(function() { 
        this.checked = false;  
      });
      var back_index = (parseInt($('#save-next-btn').attr('main')) - 1);
      if(back_index == "1")
      {
        $('#back-btn').hide(); 
      }
      if(total_sessions == $('#save-next-btn').attr('main'))
      {
        $('#preview-btn').hide(); 
        $('#save-next-btn').show(); 
      }
      $('#save-next-btn').attr('main',back_index);
      var nth_prev_session = (back_index >= 10) ? back_index : "0" + back_index;
      $('.session_number').html(nth_prev_session + "<span>Session</span>");
      $('.session_heading').text('session #'+nth_prev_session);
      var preference_type  = $('#prefernce_val_'+back_index).val();
      var location_val    = $('#location_val_'+back_index).val();
      var location_address1 = $('#location_address_'+back_index).val();
      var modified_dates = $('#date_val_'+back_index).val();
      var modified_times = $('#time_val_'+back_index).val();
      var modified_times_main = $('#time_main_val_'+back_index).val();
      if(preference_type == 0){
        $('.location_address').text(location_address1);
        $('.location_address').attr('title',location_address1);
        $('.virtual_section').hide();
        $('.location_section').show();
        $('.local-option').prop('checked',true);
      }else{
        $('.virtual_section').show();
        $('.location_section').hide();
        $('.virtual-option').prop('checked',true);
      }
      $('#roundedOne_'+modified_times_main).prop('checked',true);
      var spliceVal = modified_dates + " " + modified_times;
      var index = dateTimeArr.indexOf(spliceVal);
      if (index > -1) {
          dateTimeArr.splice(index, 1);
      }
      $('.loading').hide();
      $('.loading_icon').hide();
    });

    $('body').on('click','#preview-btn',function(){
      var spliceVal = $('#date_val_'+total_sessions).val() + " " + $('#time_val_'+total_sessions).val();
      var index = dateTimeArr.indexOf(spliceVal);
      if (index > -1) {
          dateTimeArr.splice(index, 1);
      }
      var year  = $('div.today > a').attr('data-year');
      var month = ($('div.today > a').attr('data-month') >= 10) ? $('div.today > a').attr('data-month') : "0" + $('div.today > a').attr('data-month');
      var day   = ($('div.today > a').attr('data-day') >= 10) ? $('div.today > a').attr('data-day') : "0" + $('div.today > a').attr('data-day');
      var date  =  year + "-" + month + "-" + day;
      $('#date_val_'+total_sessions).val(date);
      var time  = $('.unbooked:checked').attr('time1')+"-"+$('.unbooked:checked').attr('time2');
      $('#time_val_'+total_sessions).val(time);
      $('#time_main_val_'+total_sessions).val($('.unbooked:checked').attr('main'));
      var datetime = date +" "+ time;
      var preference_val = $('#prefernce_val_'+total_sessions).val();
      var errorMsgs = "";
      if($('#prefernce_val_'+total_sessions).val() == ""){
          errorMsgs += 'Please select training preference ..';
      }
      if(preference_val == 0){
        if($('#location_val_'+total_sessions).val() == ""){
            errorMsgs += 'Please select location .. ';
        }
      }
      if($('#date_val_'+total_sessions).val() == ""){
          errorMsgs += 'Please select training date ..';
      }
      if($('#time_val_'+total_sessions).val() == "undefined-undefined"){
          errorMsgs += 'Please select training time ..';
      }
      if(errorMsgs != ""){
        var nth_session1 = (total_sessions >= 10) ? total_sessions : "0" + total_sessions;
        showAlert('error','Error - Session '+nth_session1,errorMsgs);
        return false;
      }  
      if(jQuery.inArray(datetime, dateTimeArr ) != -1 && dateTimeArr != "")
        {
          var nth_session1 = (total_sessions >= 10) ? total_sessions : "0" + total_sessions;
          showAlert('error','Error - Session '+nth_session1,'This Date & Time Alreay Selected !!');
          return false;
        }
      $('.loading').show();
      $('.loading_icon').show();
      dateTimeArr.push(datetime);
      var sessionHTML = "";
      for (var i = 1; i <= total_sessions; i++) {
      sessionHTML += '<li><div class="main_block"><div class="icon_block big_icon"><i class="fa fa-calendar"></i>';
      sessionHTML += '</div><div class="text_block">' + convertDate($('#date_val_'+i).val()) + '</br> <span>' + $('#time_val_'+i).val() + '</span>';
      sessionHTML += '</div></div>'; 
      if($('#location_address_'+i).val() != ""){
        sessionHTML += '<div class="icon_main"><div class="icon_block"><i class="fa fa-map-marker"></i> </div><div class="text_block">' + $('#location_address_'+i).val() + '</div></div>';  
      }else{
        sessionHTML += '<div class="icon_main"><img style="width: 100%;" src="<?php echo $this->request->webroot; ?>img/favicon.ico" title="Virtual Training"></div>';  
      }
      };
      $('#so-sessions').html(sessionHTML);
      $('#respond_now').modal('show');
      $('.loading').hide();
      $('.loading_icon').hide();
    });

    $('body').on('click','.request-btn',function(){
      $('#booking_session_form').submit();
    });

    $('body').on('click','#save-preview-btn',function(){
       var spliceVal = $('#date_val_'+total_sessions).val() + " " + $('#time_val_'+total_sessions).val();
      var index = dateTimeArr.indexOf(spliceVal);
      if (index > -1) {
          dateTimeArr.splice(index, 1);
      }
      var year  = $('div.today > a').attr('data-year');
      var month = ($('div.today > a').attr('data-month') >= 10) ? $('div.today > a').attr('data-month') : "0" + $('div.today > a').attr('data-month');
      var day   = ($('div.today > a').attr('data-day') >= 10) ? $('div.today > a').attr('data-day') : "0" + $('div.today > a').attr('data-day');
      var date  =  year + "-" + month + "-" + day;
      $('#date_val_'+total_sessions).val(date);
      var time  = $('.unbooked:checked').attr('time1')+"-"+$('.unbooked:checked').attr('time2');
      $('#time_val_'+total_sessions).val(time);
      $('#time_main_val_'+total_sessions).val($('.unbooked:checked').attr('main'));
      var datetime = date +" "+ time;
      var preference_val = $('#prefernce_val_'+total_sessions).val();
      var errorMsgs = "";
      if($('#prefernce_val_'+total_sessions).val() == ""){
          errorMsgs += 'Please select training preference ..';
      }
      if(preference_val == 0){
        if($('#location_val_'+total_sessions).val() == ""){
            errorMsgs += 'Please select location .. ';
        }
      }
      if($('#date_val_'+total_sessions).val() == ""){
          errorMsgs += 'Please select training date ..';
      }
      if($('#time_val_'+total_sessions).val() == "undefined-undefined"){
          errorMsgs += 'Please select training time ..';
      }
      if(errorMsgs != ""){
        var nth_session1 = (total_sessions >= 10) ? total_sessions : "0" + total_sessions;
        showAlert('error','Error - Session '+nth_session1,errorMsgs);
        return false;
      }  
      if(jQuery.inArray(datetime, dateTimeArr ) != -1 && dateTimeArr != "")
        {
          var nth_session1 = (total_sessions >= 10) ? total_sessions : "0" + total_sessions;
          showAlert('error','Error - Session '+nth_session1,'This Date & Time Alreay Selected !!');
          return false;
        }
      $('.loading').show();
      $('.loading_icon').show();
      dateTimeArr.push(datetime);
      var sessionHTML = "";
      for (var i = 1; i <= total_sessions; i++) {
      sessionHTML += '<li><div class="main_block"><div class="icon_block big_icon"><i class="fa fa-calendar"></i>';
      sessionHTML += '</div><div class="text_block">' + convertDate($('#date_val_'+i).val()) + '</br> <span>' + $('#time_val_'+i).val() + '</span>';
      sessionHTML += '</div></div>'; 
      if($('#location_address_'+i).val() != ""){
        sessionHTML += '<div class="icon_main"><div class="icon_block"><i class="fa fa-map-marker"></i> </div><div class="text_block">' + $('#location_address_'+i).val() + '</div></div>';  
      }else{
        sessionHTML += '<div class="icon_main"><img style="width: 100%;" src="<?php echo $this->request->webroot; ?>img/favicon.ico" title="Virtual Training"></div>';  
      }
      };
      $('#so-sessions').html(sessionHTML);
      $('#respond_now').modal('show');
      $('.loading').hide();
      $('.loading_icon').hide();
    });

  });

  function convertDate(val) 
    {
      var t = val.split(/[- :]/);
      var month = ['January','February','March','April','May','June','July','August','September','October','November','December'];
      var mo = parseInt(t[1]);
      var newmonth  = month[mo-1];
      var s = newmonth+' '+t[2]+'th '+t[0];
      return s;
    }
</script>