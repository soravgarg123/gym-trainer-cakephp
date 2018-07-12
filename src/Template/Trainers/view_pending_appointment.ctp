<?php include "trainer_dashboard.php"; ?>

		<section class="payment_details appointements_response">
         <div class="top_bar_wrap">
            <div class="container">
              <div class="row">
                <div class="col-md-12 col-sm-12">
                  <div class="tbw_text">
                   appointment response center
                  </div>
              </div>
             </div>
           </div>
         </div>
         <div class="container">
              
               <div class="row">
               <div class="col-md-8 col-sm-8">
                  <div class="appointment_response_left">
                    <div class="session_user">
                     <div class="img_user_main">
                      <div class="small_circle"></div>
                      <div class="img_user"><img class="img-responsive" src="<?php echo $this->Custom->getImageSrc('uploads/trainee_profile/'.$session_details[0]['trainee_image']) ?>"></div></div>
                      <div class="img_text_main">
                        <?php echo ucwords($session_details[0]['trainee_name']." ".$session_details[0]['trainee_lname']); ?>
                        <?php if(isset($session_details[0]['city_name'])) { ?>
                          <span><?php echo $session_details[0]['city_name']."-".$session_details[0]['state_name'].",".$session_details[0]['country_name']; ?></span>
                        <?php } ?>
                        <?php 
                      	$added_date = $session_details[0]['trainee_added_date']; 
                      	$month = date('F', strtotime($added_date));
                      	$year = date('Y', strtotime($added_date));
                      ?>
                      <p>Member Since <?php echo $month." ".$year; ?></p>
                      <div class="review_box">
                         <ul>
                           <li><a href="javascript:void(0);"><div class="icon_star"><i class="fa fa-heart"></i> </div> Reviewed</a></li>

                           <li><a href="javascript:void(0);"><div class="small_circle"></div> Verified Contact</a></li>
                         </ul>
                      </div>
                      </div>
                    </div>
                    <div class="about_box">
                       <h4>About</h4>
                       <p class="trainee-about"><?php echo $session_details[0]['trainee_aboutme']; ?></p>
                    </div>
                    <div class="event_list">
                       <ul>
                         <li>
                           <div class="icon_block big_icon ">
                              <i class="fa fa-graduation-cap"></i>

                            </div>
                            <div class="text_event">
                                <h4>School</h4>
                                <p><?php echo $session_details[0]['school']; ?></p>
                              </div>
                         </li>
                          <li>
                           <div class="icon_block big_icon ">
                             <i class="fa fa-briefcase"></i>

                            </div>
                            <div class="text_event">
                                <h4>work</h4>
                                <p><?php echo $session_details[0]['work']; ?></p>
                              </div>
                         </li>
                       </ul>
                    </div>
                  </div>
               </div>
                  <div class="col-md-4 col-sm-4">
                    <div class="appointement_head">
                      Session Details 
                    </div>
                        <div class="session_setails_sec appointement_sec appointements_response_sec">
                          <div class="heading_payment_main">
                          
                          </div>
                           <?php $session_data = unserialize($session_details[0]['session_data']); ?>
                           <ul class="session_content scroll_content mCustomScrollbar _mCS_1">
                           	<?php for ($i=1; $i <= count($session_data); $i++) { ?>
                           		<li>
                                    <div class="main_block">
                                    <div class="icon_block big_icon ">
                                       <i class="fa fa-calendar"></i>
                                    </div>
                                    <div class="text_block"><div class="appointer_name"> <?php echo date('F d Y', strtotime($session_data[$i]['modified_dates'])); ?> </div></br> <span><?php echo $session_data[$i]['modified_times']; ?></span></div>
                                    </div>
                                    <?php if(!empty($session_data[$i]['location_address'])){ ?>
                                    <div class="icon_main">
                                      <div class="icon_block"><i class="fa fa-map-marker"></i> </div>
                                      <div class="text_block"><?php echo $session_data[$i]['location_address']; ?></div>                    
                                    </div>
                                    <?php } else { ?>
                                  <div class="icon_main">
                                    <img style="width: 100%;" src="<?php echo $this->request->webroot; ?>img/favicon.ico" title="Virtual Training">
                                  </div>
                                  <?php } ?>
                              	</li>
                           	<?php } ?>
                            </ul>
                            <div class="common_btn">
                               <button type="button" data-toggle="modal" data-target="#respond_now" class="pre_decline">Pre -approve or Decline</button>
                            </div>
                        </div>
                  </div>
                  
               </div>
            </div>
        </section>

<!-- Modal for Respond Now start-->
<div class="modal fade custom_model" id="respond_now" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="heading_payment_main">
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Respond Now</h4>
            </div>
            <div class="modal-body">
                <div class="session_user">
                    <div class="img_user_main">
                        <div class="small_circle"></div>
                        <div class="img_user"><img src="<?php echo $this->Custom->getImageSrc('uploads/trainee_profile/'.$session_details[0]['trainee_image']) ?>" class="img-responsive">
                        </div>
                    </div>
                    <div class="img_text_main">
                        <?php echo ucwords($session_details[0]['trainee_name']." ".$session_details[0]['trainee_lname']); ?>
                        <span><?php echo count($session_data); ?> Sessions - $<?php echo $session_details[0]['final_price']; ?></span>
                    </div>
                </div>
                <div class="head_custom">
                    <div class="icon_block big_icon ">
                        <i class="fa fa-calendar"></i>
                    </div> Sessions Details
                </div>
                <ul class="session_content scroll_content mCustomScrollbar _mCS_1">
                <?php for ($i=1; $i <= count($session_data); $i++) { ?>
                    <li>
                        <div class="main_block">
                            <div class="icon_block big_icon"><i class="fa fa-calendar"></i>
                            </div>
                            <div class="text_block"><?php echo date('F d, Y', strtotime($session_data[$i]['modified_dates'])); ?></br> <span><?php echo $session_data[$i]['modified_times']; ?></span>
                            </div>
                        </div>
                        <?php if(!empty($session_data[$i]['location_address'])){ ?>
                        <div class="icon_main">
                            <div class="icon_block"><i class="fa fa-map-marker"></i> </div>
                            <div class="text_block"><?php echo $session_data[$i]['location_address']; ?></div>
                        </div>
                        <?php } else { ?>
                          <div class="icon_main">
                            <img style="width: 100%;" src="<?php echo $this->request->webroot; ?>img/favicon.ico" title="Virtual Training">
                          </div>
                        <?php } ?>
                    </li>
                <?php } ?>
                </ul>
            </div>
            <div class="modal-footer">
                <div class="custom_model_bottom">
                    <?php if(!empty($session_details[0]['special_offer_modify_date'])){ ?>
                      <a href="javascript:void(0);" class="special_offer">Special Offer Created</a>
                    <?php } else{ ?>
                      <button type="button" class="btn respond-section" main="1" appid="<?php echo base64_encode($session_details[0]['app_id']); ?>">Approve</button>
                      <button type="button" class="btn decline respond-section" main="2" appid="<?php echo base64_encode($session_details[0]['app_id']); ?>">Decline</button>
                      <a href="javascript:void(0);" data-dismiss="modal" data-toggle="modal" data-target="#Make_Special_Offer" class="special_offer">Make Special Offer</a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>        
<!-- Modal for Respond Now end-->

<!-- Modal for Make a Special Offer start-->
<div class="modal fade custom_model" id="Make_Special_Offer" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">

        <div class="modal-content">
            <div class="modal-header">
                <div class="heading_payment_main">
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Make a Special Offer</h4>
            </div>
            <div class="modal-body">
                <form method="post" action="<?php echo $this->request->webroot; ?>trainers/makeSpecialOffer/<?php echo $_GET['aid']; ?>" novalidate>
                <div class="session_user">
                    <div class="img_user_main">
                        <div class="small_circle"></div>
                        <div class="img_user"><img src="<?php echo $this->Custom->getImageSrc('uploads/trainee_profile/'.$session_details[0]['trainee_image']) ?>" class="img-responsive">
                        </div>
                    </div>
                    <div class="img_text_main">
                        <?php echo ucwords($session_details[0]['trainee_name']." ".$session_details[0]['trainee_lname']); ?>
                        <span><?php echo count($session_data); ?> Sessions - $<?php echo $session_details[0]['final_price']; ?></span>
                    </div>
                </div>
                <div class="head_custom">
                    <div class="icon_block big_icon ">
                        <i class="fa fa-calendar"></i>
                    </div> Sessions Details
                </div>
                <ul class="session_content scroll_content mCustomScrollbar _mCS_1">
                  <?php for ($i=1; $i <= count($session_data); $i++) { ?>
                    <li>
                        <div class="main_block">
                            <div class="icon_block big_icon"><i class="fa fa-calendar"></i>
                            </div>
                            <div class="text_block make_date" id="make_date_<?php echo $i; ?>" main="<?php echo $i; ?>"><?php echo date('F d, Y', strtotime($session_data[$i]['modified_dates'])); ?></br> 
                            <span class="make_time" id="make_time_<?php echo $i; ?>" main="<?php echo $i; ?>"><?php echo $session_data[$i]['modified_times']; ?></span>
                            </div>
                        </div>
                        <input type="hidden" name="booking[<?php echo $i; ?>][preference]" value="<?php echo $session_data[$i]['preference']; ?>" class="make_preference" id="make_preference_<?php echo $i; ?>" main="<?php echo $i; ?>">
                        <input type="hidden" name="booking[<?php echo $i; ?>][modified_dates]" value="<?php echo $session_data[$i]['modified_dates']; ?>" class="make_date_hidden" id="make_date_hidden_<?php echo $i; ?>" main="<?php echo $i; ?>">
                        <input type="hidden" name="booking[<?php echo $i; ?>][modified_times]" value="<?php echo $session_data[$i]['modified_times']; ?>" class="make_time_hidden" id="make_time_hidden_<?php echo $i; ?>" main="<?php echo $i; ?>">
                        <input type="hidden" name="booking[<?php echo $i; ?>][locations]" value="<?php echo $session_data[$i]['locations']; ?>" class="make_lat_lng" id="make_lat_lng_<?php echo $i; ?>" main="<?php echo $i; ?>">
                        <!-- <input type="hidden" name="booking[<?php echo $i; ?>][notes]" value="<?php echo $session_data[$i]['notes']; ?>" class="make_notes" id="make_notes_<?php echo $i; ?>" main="<?php echo $i; ?>"> -->
                        <input type="hidden" name="booking[<?php echo $i; ?>][status]" id="status_val_<?php echo $i; ?>" value="0">
                        <div class="icon_main" id="location_modify_section_<?php echo $i; ?>" <?php if(empty($session_data[$i]['location_address'])){ echo "style='display:none;'"; }?>>
                            <div class="icon_block"><i class="fa fa-map-marker"></i> </div>
                            <div class="text_block make_location" id="make_location_<?php echo $i; ?>" main="<?php echo $i; ?>"><?php echo $session_data[$i]['location_address']; ?></div>
                            <input type="hidden" name="booking[<?php echo $i; ?>][location_address]" value="<?php echo $session_data[$i]['location_address']; ?>" class="make_location_addess" id="make_location_addess_<?php echo $i; ?>" main="<?php echo $i; ?>">
                        </div>
                        <div class="pen_icon"><a href="javascript:void(0);" data-toggle="modal" data-target="#Modify_Event" class="edit_appo" id="edit_appo_<?php echo $i; ?>" main="<?php echo $i; ?>"><i class="fa fa-pencil"></i> </a>
                        </div>
                    </li>
                  <?php } ?>
                </ul>
            </div>
            <div class="modal-footer">
                <div class="custom_model_bottom">
                    <div class="set_price_section col-sm-12" style="display:none;" >
                      <div class="col-sm-8">
                        <input id="set_own_price" type="number" min="0" max="<?php echo $session_details[0]['final_price']; ?>" name="set_price" value="<?php echo $session_details[0]['final_price']; ?>" class="form-control">
                        <input type="hidden" id="set_own_price_hidden" name="set_own_price_hidden" value="<?php echo $session_details[0]['final_price']; ?>">
                      </div>
                      <div class="col-sm-2">
                        <div class="icon_block cancel_set_price_btn" id="cancel_set_price_btn" title="Cancel Set Price"><i class="fa fa-times"></i> </div>
                      </div>
                      <div class="col-sm-2">
                        <div class="icon_block save_set_price_btn" id="save_set_price_btn" title="Save Set Price"><i class="fa fa-check"></i> </div>
                      </div>
                    </div>
                    <span id="modify_price" style="display:none;">
                      <button type="button" id="applied_new_price" title="Applied New Price" class="btn_applied"> <i class="fa fa-check-circle"></i></button>
                      <button type="button" id="remove_new_price" title="Remove Applied New Price" class="btn_applied">Remove <i class="fa fa-times-circle"></i></button>
                    </br></span>
                    <button type="button" class="btn decline set_price">Set a Price</button>
                    <button type="submit" class="special_offer">Make Special Offer</button>
                </div>
            </div>
          </form>
        </div>
    </div>
</div>
<!-- Modal for Make a Special Offer end-->

<!-- Modal for Make a Modify Event start-->
<div class="modal fade custom_model" id="Modify_Event" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="heading_payment_main">
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Modify Event</h4>
            </div>
            <div class="modal-body">
                <div class="head_custom" id="modify_heading">
                    Session 3 
                </div>
                <div class="save_changes">
                    <button type="button" id="modify-save-btn">save change</button>
                </div>
                <ul class="session_content">
                    <li>
                        <div class="main_block" id="modify-section">
                            <div class="pen_icon" id="modify-date-time" title="Modify Date & Time"> <i class="fa fa-pencil"></i> </div>
                        </div>
                        <div class="modify_date_time1 save_cancel_section" style="display:none;">
                          <div class="icon_block cancel-modify-btn" id="cancel_modify_btn" title="Cancel"><i class="fa fa-times"></i> </div>
                          <div class="icon_block save-modify-btn" id="save_modify_btn" title="Save"><i class="fa fa-check"></i> </div>
                        </div>
                        <div class="text_block" id="app_date"> <span id="app_time"></span>
                        </div>
                        <div class="icon_main" id="location_section">
                            <div class="icon_block select_location" title="Select Location"><i class="fa fa-map-marker"></i> </div>
                            <div class="text_block" id="app_location"></div>
                        </div>
                    </li>
                </ul>
                <div class="custom_model_bottom">
                    <p>Select Training Preference</p>
                    <button type="button" id="local_btn" class="btn preference-btn" main="0">Local</button>
                    <button type="button" id="virtual_btn" class="btn decline preference-btn" main="1">Virtual</button>
                </div>
            </div>
            <div class="modal-footer session_wrap ">
                <div class="responsive-calendar">
                    <div class="controls clearfix">
                        <h4 class="text-center"><span data-head-year></span> <span data-head-month></span></h4>
                        <a class="pull-left" data-go="prev">
                            <div class="btn prev_btn "><i class="fa fa-angle-double-left"></i>
                            </div>
                        </a>
                        <a class="pull-right" data-go="next">
                            <div class="btn next_btn"><i class="fa fa-angle-double-right"></i>
                            </div>
                        </a>
                    </div>
                    <div class="heading_payment_main">
                    </div>
                    <div class="calendor_content session_content">
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
                <input type="hidden" value="" id="location-lat-lng">
                <input type="hidden" value="" id="training_preference">
                <input type="hidden" value="" id="training_date">
                <div class="calendor_caption_main">
                    <div class="heading_payment_main">
                    </div>
                    <div class="calendor_caption session_content mCustomScrollbar _mCS_4">
                    <?php 
                      if(!empty($time_slots)){
                        $times = unserialize($time_slots[0]['times']);
                      }else{
                        $times = array('0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0');
                      }
                      for ($i=0; $i < 24; $i++) {
                    ?>
                      <div class="checkbox">
                       <div title="<?php echo ($times[$i] == 1) ? 'Blocked' : 'Available' ?>" class="roundedOne <?php echo ($times[$i] == 1) ? 'bookedlabel' : 'unbookedlabel' ?>">
                          <input <?php if($times[$i] == 1) echo "checked"; ?> <?php if($times[$i] == 1) echo "disabled"; ?> type="checkbox" class="time <?php echo ($times[$i] == 1) ? 'booked' : 'unbooked' ?>" value="0" time1="<?php echo $this->Custom->getTimeSlots($i); ?>" time2="<?php echo $this->Custom->getTimeSlots($i+1); ?>" main="<?php echo $i; ?>" id="roundedOne_<?php echo $i; ?>" />
                          <label for="roundedOne_<?php echo $i; ?>"></label>
                          <input type="hidden" name="times[]" class="hidden_time" id="time_<?php echo $i; ?>" value="<?php echo $times[$i]; ?>"/>
                        </div>
                        <div class="chekbox_txt"> <span><?php echo $this->Custom->getTimeSlots($i); ?></span><?php echo $this->Custom->getTimeSlots($i+1); ?></div>
                    </div>
                    <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal for Make a Modify Event end-->

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
    lat_long_val = $('#location-lat-lng').val();
    address_text = $('#app_location').text();
    if(lat_long_val == ""){
      lat_long_val = "50.447978,-104.6066559";
    }
    if(address_text == ""){
      address_text = "You Tag Media & Business Solutions, Inc 1950 Broad Street, Unit 209 Regina, SK S4P 1X6 Canada";
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

<!-- Appoinment Respond Section Start -->

<script type="text/javascript">
  $(document).ready(function(){

    $('body').on('click','.respond-section',function(){
      var type  = $(this).attr('main');
      var appid = $(this).attr('appid');
      window.location.href = "<?php echo $this->request->webroot; ?>trainers/respondnow?type="+type+"&appid="+appid;
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

    $('body').on('click','.edit_appo',function(){
      var app_no   = $(this).attr('main');
      var date     = $('#make_date_hidden_'+app_no).val();
      var time     = $('#make_time_hidden_'+app_no).val();
      var location = $('#make_location_'+app_no).text();
      var preference = $('#make_preference_'+app_no).val();
      var latlng = $('#make_lat_lng_'+app_no).val();
      $('#modify_heading').text('Session '+app_no);
      $('#app_location').text(location);
      $('#modify-save-btn').attr('main',app_no);
      $('#location-lat-lng').val(latlng);
      $('#app_date').html(convertDate(date) +' </br><span id="app_time">'+time+'</span>');
      if(preference == 0){
        $('#virtual_btn').addClass('decline');
        $('#local_btn').removeClass('decline');
        $('#location_section').show();
      }else{
        $('#local_btn').addClass('decline');
        $('#virtual_btn').removeClass('decline');
        $('#location_section').hide();
      }
    });

    $('body').on('click','div.day > a',function(){
          var year  = $(this).attr('data-year');
          var month = ($(this).attr('data-month') >= 10) ? $(this).attr('data-month') : "0" + $(this).attr('data-month');
          var day = ($(this).attr('data-day') >= 10) ? $(this).attr('data-day') : "0" + $(this).attr('data-day');
          var date =  year + "-" + month + "-" + day;
          $('.day').removeClass('today');
          $(this).parent().addClass('today');
          $.ajax({
            url:"<?php echo $this->request->webroot; ?>trainers/getTimeSlotsDateWise",
            type:"post",
            data:{date:date},
            dataType:"json",
            success: function(response){
                $('.calendor_caption').html(response.message);
                $(".calendor_caption").mCustomScrollbar("update");
                $(".calendor_caption").mCustomScrollbar();
            },
            error:function(error){
                console.log(error);  
            }
          });
    });

    $('body').on('click','#modify-date-time',function(){
        $(this).hide();
        $('.modify_date_time1').show();
    });

    $('body').on('click','.cancel-modify-btn',function(){
        $('.modify_date_time1').hide();
        $('#modify-date-time').show();
    });

    $('body').on('click','.save-modify-btn',function(){
        var year     = $('div.today > a').attr('data-year');
        var month    = ($('div.today > a').attr('data-month') >= 10) ? $('div.today > a').attr('data-month') : "0" + $('div.today > a').attr('data-month');
        var day      = ($('div.today > a').attr('data-day') >= 10) ? $('div.today > a').attr('data-day') : "0" + $('div.today > a').attr('data-day');
        var date     =  year + "-" + month + "-" + day;
        var time_val = $('.unbooked:checked').attr('main');
        var time1    = $('.unbooked:checked').attr('time1');
        var time2    = $('.unbooked:checked').attr('time2');
        $('#training_date').val(date);
        if(time_val == undefined){
          alert('Please select time');
          return false;
        }
        var converted_date = convertDate(date);
        $('#app_date').html(convertDate(date) +' </br><span id="app_time">'+time1 +"-"+time2+'</span>');
        $('.unbooked').prop('checked',false).val('0');
        $('.modify_date_time1').hide();
        $('#modify-date-time').show();
    });

    $('body').on('click','.preference-btn',function(){
      var type = $(this).attr('main');
      $('#training_preference').val(type);
      if(type == 1){
        $('#location_section').hide();
        $('#local_btn').addClass('decline');
        $('#virtual_btn').removeClass('decline');
      }else{
        $('#location_section').show();
        $('#local_btn').removeClass('decline');
        $('#virtual_btn').addClass('decline');
      }
    });    

    $('body').on('click','#save-location-btn',function(){
      $('#location-lat-lng').val(place.geometry.location.lat() + "," + place.geometry.location.lng());
      $('#app_location').text(marker_title);
      $('#location_model').modal('hide');
    });

    $('body').on('click','#modify-save-btn',function(){
      var session_no    = $(this).attr('main');
      var location_text = $('#app_location').text();
      var lat_lng       = $('#location-lat-lng').val();
      var preference    = $('#training_preference').val();
      var date          = $('#training_date').val();
      var time          = $('#app_time').text();  
      $('#make_date_'+session_no).text("").html(convertDate(date) + "<br> <span class='make_time' id='make_time_'"+session_no+" main='"+session_no+"'>"+time+"</span>");
      $('#make_location_'+session_no).text("").text(location_text);
      $('#make_preference_'+session_no).val(preference);
      $('#make_date_hidden_'+session_no).val(date);
      $('#make_time_hidden_'+session_no).val(time);
      $('#make_lat_lng_'+session_no).val(lat_lng);
      $('#make_location_addess_'+session_no).val(location_text);
      if(preference == 0){
        $('#location_modify_section_'+session_no).show();
      }else{
        $('#make_lat_lng_'+session_no).val("");
        $('#make_location_addess_'+session_no).val("");
        $('#location_modify_section_'+session_no).hide();
      }
      $('#Modify_Event').modal('hide');
    });

    $('body').on('click','.set_price',function(){
      $('.set_price,#modify_price').hide();
      $('.set_price_section').show();
    });

    $('body').on('click','.cancel_set_price_btn',function(){
      $('#set_own_price_hidden').val("<?php echo $session_details[0]['final_price']; ?>");
      $('.set_price_section,#modify_price').hide();
      $('.set_price').show();
    });

    $('body').on('click','.save_set_price_btn',function(){
      var prev_price = parseFloat("<?php echo $session_details[0]['final_price']; ?>");
      var new_price  = parseFloat($('#set_own_price').val());
      if(isNaN(new_price) || new_price < 0)
      {
        showAlert('error','Error !','Please enter valid price !');
        return false;
      }
      if(new_price > prev_price)
      {
        showAlert('error','Error !','price should be less then $' + prev_price + ' !');
        return false;
      }
      if(new_price == prev_price)
      {
        showAlert('error','Error !','Modified price can not be same !');
        return false;
      }
      $('.set_price_section,.set_price').hide();
      $('#applied_new_price').html('$'+new_price+' <i class="fa fa-check-circle"></i>');
      $('#set_own_price_hidden').val(new_price);
      $('#modify_price').show();
    });

    $('body').on('click','#remove_new_price',function(){
      $('#set_own_price_hidden').val("<?php echo $session_details[0]['final_price']; ?>");
      $('.set_price_section,#modify_price').hide();
      $('.set_price').show();
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

<!-- Appoinment Respond Section End -->