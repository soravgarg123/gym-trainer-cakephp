<?php include "trainer_dashboard.php"; ?>
     
<section class="trainee_dash_body">

  <!--Main container sec start-->
  <div class="main_container">
    <div class="customer_report_main trainer_dashboard">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12 col-sm-12">
            <div class="notification_wrap">
              <ul>
                <li>
                <?php 
                  $weather_details = $this->Custom->getWheatherDetails();
                  if(!empty($weather_details)){
                    $weather = round($weather_details['main']['temp'] - 273.15,1);
                    $windy   = round($weather_details['wind']['speed'],1);
                    $city    = $weather_details['name'];
                  }else{
                    $weather = "NA";
                    $windy   = "NA";
                    $city   = "NA";
                  }
                ?>
                  <div class="cloud_box blue_light">
                    <div class="cloud blue"><i class="flaticon1-cogwheel" aria-hidden="true"></i><span>Friday</span></div>
                  </div>
                  <div class="cloud_text">
                    <div class="degree_main"><?php echo $weather; ?><span class="degree">0<span class="cvalue">c</span></span></div>
                    <span><?php if(isset($city)) echo $city; ?></span>
                    <span>Weather</span>
                  </div>
                </li>
                <li>
                  <div class="cloud_box">
                    <div class="cloud"><i class="flaticon1-money"></i><span> wallet</span></div>
                  </div>
                  <?php
                        if(empty($total_wallet_ammount)){
                            $wallet_balance =  "0";
                        }
                        else
                        {
                            $wallet_balance =  $total_wallet_ammount[0]['total_ammount'];
                        }
                    ?>
                  <div class="cloud_text"> <span>my wallet</span>
                    <div class="rate_box">$<?php echo round($wallet_balance,2); ?></div>
                    <span class="withraw"><a style="color:#979090;" href="<?php echo $this->request->webroot; ?>trainers/wallet">Withdraw</a></span> </div>
                </li>
                <li>
                  <div class="cloud_box">
                    <div class="cloud"><i class="flaticon1-money-1"></i><span>earing</span></div>
                  </div>
                  <div class="cloud_text"> <span>My Total Earnings</span>
                    <div class="rate_box">$0</div>
                    <span class="last_month">Last Month</span> <span class="last_month">$0</span> </div>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <div class="appointement_dashboard">
          <div class="row">
            <div class="col-md-4 col-sm-4"> 
              <!-- Responsive calendar - START -->
              <div class="responsive-calendar">
                <div class="controls clearfix">
                  <h4 class="text-center"><span data-head-year></span> <span data-head-month></span></h4>
                  <a class="pull-left" data-go="prev">
                  <div class="btn prev_btn "><i class="fa fa-angle-double-left"></i> </div>
                  </a> <a class="pull-right" data-go="next">
                  <div class="btn next_btn"><i class="fa fa-angle-double-right"></i> </div>
                  </a> </div>
                <div class="calendor_content">
                  <div class="heading_payment_main"> </div>
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
                    <div class="days" data-group="days"> </div>
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
        </div>
        <div class="visiter_map_sec">
          <div class="row">
            <div class="col-md-8 col-sm-8">
              <div class="visitor_map"> 
               <div id="chartdiv"></div>									
                			
              </div>
            </div>
            <div class="col-md-4 col-sm-4">
              <div class="session_setails_sec agenda">
              <form method="post" onsubmit="return checkValidation()" action="<?php echo $this->request->webroot; ?>trainers/notesmgmt">
                <div class="heading_payment_main">
                  <h2 class="text-center">Notes <span id="add_notes" title="Add Notes"><i class="fa fa-plus-circle"></i>
                   <span class="ad_notes_main">
                  <span class="pop_over">
                    <input type="hidden" value="" id="notes_id" name="notes_id">
                    <textarea requiredd class="form-control" id="notes_data" name="notes" placeholder="Notes"></textarea>
                    <a href="javascript:void(0);" class="btn_okay notes-cancel-btn">cancel</a>
                    <button class="btn_okay notes-save-btn">Save</button>
                 </span>
                </span>
                  </span></h2>
                </div>
              </form>
                <div class="session_content scroll_content">
                <?php if(!empty($notes)) { 
                  foreach($notes as $n) { ?>
                    <p id="notes_row_<?php echo $n['id']; ?>"><span class="agenda_icon"><i class="fa fa-chevron-right" aria-hidden="true"></i></span>  <?php echo $n['notes']; ?>
                     <span class="icon_edit_delete">
                       <a title="Edit Notes" class="edit_notes" href="javascript:void(0);" main="<?php echo $n['id']; ?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                       <a title="Delete Notes" class="delete_notes" href="javascript:void(0);" main="<?php echo $n['id']; ?>"><i class="fa fa-trash" aria-hidden="true"></i></a>
                     </span>
                    </p>
                <?php }
                  }else{ ?>
                  <br>
                  <center><h4>No notes created. Press the (+) on the top-right corner to insert your private note.</h4></center>
                 <?php } ?>
                  
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="message_wrap">
          <div class="message_wrap_head">
            <h3>inbox </h3>
            <div class="clearfix"></div>
          </div>
          <div class="message_wrap_content_box">
            <ul>
              <li><span class="flaticon1-tool"></span> Inbox</li>
              <li><input type="checkbox" checked="" class="select-all-btn"> Select All</li>
              <li class="dropdown"><a href="#"  class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">action <i class="fa fa-chevron-down"></i></a>
                <ul class="dropdown-menu">
                  <li><a href="javascript:void(0);" id="delete-msgs"><i class="fa fa-trash-o"></i> Delete</a></li>
                </ul>
              </li>
              <li class="pull-right">
              </li>
            </ul>
            <div class="message_wrap_content">
            <?php if(!empty($messages)) { ?>
              <table class="table table-striped">
                <tbody>
                <?php $i = 1; foreach($messages as $m){ ?>
                  <tr>
                    <td><div class="squaredThree">
                        <input type="checkbox" class="msg_cb" value="<?php echo $m['chat_id']; ?>" id="squaredThree_<?php echo $i; ?>" name="check" checked />
                        <label for="squaredThree_<?php echo $i; ?>"></label>
                      </div></td>
                    <td><?php echo $m['trainee_name']." ".$m['trainee_lname']; ?></td>
                    <td><?php echo $m['chat_messsage']; ?></td>
                    <td><?php echo $m['chat_added_date']; ?></td>
                  </tr>
                <?php $i++; } ?>
                </tbody>
              </table>
              <?php } else { ?>
              <center><h4>You have no new messages</h4></center>
            <?php } ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--Main container sec end--> 

<div aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade custom_model">
    <div role="document" class="modal-dialog  visitor_model">
        <div class="modal-content">
            <div class="modal-header">
                <div class="heading_payment_main">
                </div>
                <button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span>
                </button>
                <h4 id="myModalLabel" class="modal-title">indore ,mp,india <span class="badges">10</span></h4>
            </div>
            <div class="modal-body" id="visitors">
                
            </div>
        <div class="modal-footer">
            <div class="custom_model_bottom">
              <button data-dismiss="modal" class="btn decline" type="button">Close</button>
            </div>
        </div>
    </div>
</div>

</section>  

<script type="text/javascript">

$(document).ready(function(){
  $('body').on('click','#delete-msgs',function(){
    var msg = [];
     $.each($("input.msg_cb:checked"), function(){            
            msg.push($(this).val());
      });
    var chatids = msg.join(",");
    if(chatids == ""){
      showAlert('error','Error','Please select messages !!');
      return false;
    }
    $.ajax({
          url:"<?php echo $this->request->webroot; ?>trainers/deleteMessages",
          type:"post",
          data:{chatids:chatids},
          dataType:"json",
          success: function(response){
            if(response.message == "success"){
              showAlert('success','Success','Messages deleted successfully');
              setTimeout(function(){
                window.location.reload();
              }, 1000);
            }
          },
          error:function(error){
              console.log(error);  
          }
      });
  });
$('body').on('click','#add_notes .notes-cancel-btn',function(){
  setTimeout(function(){
    $('.ad_notes_main  > .pop_over').css("display","none");
  },100);
});

  $('body').on('click','#add_notes',function(){
    $('#add_notes .ad_notes_main .pop_over').css("display","block");
  });

$('body').on('click','.delete_notes',function(){
  var notesid = $(this).attr('main');
  $.ajax({
          url:"<?php echo $this->request->webroot; ?>trainers/deleteNotes",
          type:"post",
          data:{notesid:notesid},
          dataType:"json",
          success: function(data){
              $('#notes_row_'+notesid).remove();
          }
      });
});

$('body').on('click','.edit_notes',function(){
  var notesid = $(this).attr('main');
  $.ajax({
          url:"<?php echo $this->request->webroot; ?>trainers/getNotesData",
          type:"post",
          data:{notesid:notesid},
          dataType:"json",
          success: function(data){
            var result = data.message;
            $('#notes_data').val(result[0]['notes']);
            $('#notes_id').val(result[0]['id']);
            $('#add_notes .ad_notes_main .pop_over').css("display","block");
          }
      });
});

$(".select-all-btn").change(function () {
    $("input.msg_cb").prop('checked', $(this).prop("checked"));
});

});
</script>

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

window.map = AmCharts.makeChart("chartdiv", {
    type: "map",
    "theme": "none",
    "projection":"miller",
    path: "http://www.amcharts.com/lib/3/",

    imagesSettings: {
        rollOverColor: "#089282",
        rollOverScale: 3,
        selectedScale: 3,
        selectedColor: "#089282",
        color: "#13564e"
    },

    areasSettings: {
        unlistedAreasColor: "#15A892"
    },

    dataProvider: {
        map: "worldLow",
        images: <?php echo json_encode($final_visitors_count); ?>
    }
});

// add events to recalculate map position when the map is moved or zoomed
map.addListener("positionChanged", updateCustomMarkers);

});

// this function will take current images on the map and create HTML elements for them
function updateCustomMarkers (event) {
    // get map object
    var map = event.chart;
    
    // go through all of the images
    for( var x in map.dataProvider.images) {
        // get MapImage object
        var image = map.dataProvider.images[x];
        
        // check if it has corresponding HTML element
        if ('undefined' == typeof image.externalElement)
            image.externalElement = createCustomMarker(image);

        // reposition the element accoridng to coordinates
        var xy = map.coordinatesToStageXY(image.longitude, image.latitude);
        image.externalElement.style.top = xy.y + 'px';
        image.externalElement.style.left = xy.x + 'px';
    }
}

// this function creates and returns a new marker element
function createCustomMarker(image) {
    // create holder
    var holder = document.createElement('div');
    holder.className = 'map-marker';
    holder.title = image.title;
    holder.style.position = 'absolute';
    
    // maybe add a link to it?
    if (undefined != image.url) {
        holder.onclick = function() {
            window.location.href = image.url;
        };
        holder.className += ' map-clickable';
    }
    
    // create dot
    var dot = document.createElement('div');
    dot.className = 'dot';
    holder.appendChild(dot);
    
    // create pulse
    var pulse = document.createElement('div');
    pulse.className = 'pulse';
    holder.appendChild(pulse);
    
    // append the marker to the map container
    image.chart.chartDiv.appendChild(holder);
    
    return holder;
}

/*window.onload = function(){
setTimeout(function(){
  $('.map-marker').each(function (index, value) { 
    console.log($(this).attr('title')); 
    $(this).tooltip({
       html:true
      })
    });
},1000);
}*/

$('body').on('click','.pulse',function(){
  var modal_heading = $(this).parent().attr('title');
  $('#myModalLabel').text(modal_heading);
  var titleArr = modal_heading.split(" ");
  $('.loading').show();
  $('.loading_icon').show();
  $.ajax({
      url:"<?php echo $this->request->webroot; ?>trainers/getVisitorsData",
      type:"post",
      data:{title:titleArr[0]},
      dataType:"json",
      success: function(data){
        var result = data.message;
        $('#visitors').html(result);
        $('#myModal').modal('show');
        $('.loading').hide();
        $('.loading_icon').hide();
      }
  });
});

function checkValidation()
{
  var notes = $('#notes_data').val();
  if(notes == "")
  {
    showAlert('error','Error','Please enter notes !!');
    return false;
  }
}
</script>

