<div class="video_chat_wrapper">
    <!-- <div class="m_video_chat_head">Video Chat</div></br> -->
    <div class="col-sm-12" id="auto_termainate_call" style="display:none;">
    <?php echo $this->Custom->errorMsg(); ?>
    </div>
	<div class="m_video_chat_body">
        <div class="col-sm-8">
        	<div class="full_video">
            	<div>
                	<div class="video_chat_videos" id="video_chat_videos"></div>
                </div>
                <div class="psvideo">
                	<div id="publisher_vid"></div>
                </div>
                <div class="video_sect_footer">
                    <div class="calling_time_durtaion"><h3 class="call_timer">00:00:00</h3></div>
                    <div class="calling_ending">
                        <?php if($u_type == "sender"){ ?>
                        <button class="btn" id="end_session" main_id="<?php echo $main_id; ?>" type="button"><i class="fa fa-phone"></i></button>
                        <?php } ?>
                    </div>
                    <div class="full_screen_vid1">
                        <button type="button" id="max-min-btn" class="minimize-call"><i class="fa fa-arrows-alt"></i></button> 
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="chating_wind_wrapper"> 
                <div class="panel panel-default">
                    <div class="panel-heading top-bar">
                        <h3 class="panel-title"><?php echo $r_profile[0][$rtype."_displayName"]; ?><!-- <span class="online_Status_g active_status"></span> --></h3>
                        <!-- <div class="chat_seting_sect">
                            <span class="chat_time_show">08/Jun/2015</span>
                            <a href="javascript:void(0)"><span class="fa fa-gear"></span></a>
                        </div> -->
                    </div>
                    <div class="panel-body msg_container_base" id="load_chat_<?php echo $unique; ?>">
                        <?php foreach($chat_data as $chat){ ?>
                        <?php if($chat["chat_sender_id"] == $uid){ ?>    
                            <div class="msg_container base_sent">
                                <div class="messages msg_sent">
                                    <p><?php echo nl2br($chat["chat_messsage"]); ?></p>
                                    <!-- <time datetime="2009-11-13T20:00">Timothy • 51 min</time> -->
                                </div>
                                <div class="chat_avatar">
                                    <img src="<?php echo $this->request->webroot ?>uploads/<?php echo $type."_profile/".$profile[0][$type."_image"]; ?>" class="img-responsive img-circle">
                                </div>
                            </div>
                        <?php }else{ ?>
                            <div class="msg_container base_receive">
                                <div class="chat_avatar">
                                    <img src="<?php echo $this->request->webroot ?>uploads/<?php echo $rtype."_profile/".$r_profile[0][$rtype."_image"]; ?>" class="img-responsive img-circle">
                                </div>
                                <div class="messages msg_receive">
                                    <p><?php echo nl2br($chat["chat_messsage"]); ?></p>
                                    <!-- <time datetime="2009-11-13T20:00">Timothy • 51 min</time> -->
                                </div>
                            </div>
                        <?php } } ?>
                    </div>
                    <div class="panel-footer">
                        <div class="input-group">
                            <textarea id="btn-input" class="form-control input-sm video_chat_input" unique="<?php echo $unique; ?>" uid="<?php echo $uid; ?>" to_id="<?php echo $main_id; ?>" placeholder="Write your message here..." ></textarea>
                            <form id="send_file" class="input-group-btn">
                                <div class="file_attched_field">
                                    <span class="fa fa-paperclip"></span>
                                    <input type="file" name="chat_file" class="video_chat_file" unique="<?php echo $unique; ?>" to_id="<?php echo $main_id; ?>" uid="<?php echo $uid; ?>">
                                    <input type="hidden" name="unique" value="<?php echo $unique; ?>">
                                    <input type="hidden" name="to_id" value="<?php echo $main_id; ?>">
                                    <input type="hidden" name="uid" value="<?php echo $uid; ?>">
                                </div>
                                
                            </form>   
                            <!-- <span class="input-group-btn">
                            <button class="chat_btn btn" href="#"><span class="fa fa-paper-plane"></span></button>
                            </span> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
     <!-- get current session -->
     <input type="hidden"  id="current_session" value="<?php echo $session_val; ?>" />
    <div class="clearfix"></div>
</div>
<?php //echo $chat_session[0]['session_id']; ?>
<script>
var apiKey = "<?php echo $tokbox[0]['api_key']; ?>";
var sessionID = "<?php echo $chat_session[0]['session_id']; ?>";
var token = "<?php echo $chat_session[0]['token_id']; ?>";
var publisher;
var targetElement = 'publisherContainer';
var systemdevice = "";
var audioInputDevices;
var videoInputDevices;
var audioInput, videoInput;

var session = OT.initSession(apiKey, sessionID);

OT.getDevices(function(error, devices) {
  audioInputDevices = devices.filter(function(element) {
    return element.kind == "audioInput";
  });
  //console.log(audioInputDevices);
  videoInputDevices = devices.filter(function(element) {
    return element.kind == "videoInput";
  });
  //console.log(videoInputDevices);
  
  if (videoInputDevices.length === 0) {
        systemdevice += "Video device ";
        videoInput = null;
        //console.log(videoInput);
  }else
  {
    videoInput = videoInputDevices[0].deviceId;
  }

  if (audioInputDevices.length === 0) {
        systemdevice += " Audio device";
        audioInput = null;
  }else{
    audioInput = audioInputDevices[0].deviceId;
  }

  if(systemdevice != "")
    {
        if(confirm("Systme dosn't recognise "+systemdevice))
        {
            videocall();
            setTimeout(function(){
                $('#load_chat_<?php echo $unique; ?>').animate({scrollTop: $('#load_chat_<?php echo $unique; ?>')[0].scrollHeight}, 1);    
            },1000);
            
        }else
        {
            var main_id = <?php echo $main_id; ?>;
            var data = main_id+",canclecall";            
            send(data);
            window.location.reload();
        }
    }else
    {
       videocall();
       setTimeout(function(){
                $('#load_chat_<?php echo $unique; ?>').animate({scrollTop: $('#load_chat_<?php echo $unique; ?>')[0].scrollHeight}, 1);    
            },1000);
    }
});


function videocall()
{
    var pubOptions =
    {
        audioSource: audioInput,
        videoSource: videoInput
    };
    
    publisher = OT.initPublisher('publisher_vid', pubOptions, function(error) {
      console.log("OT.initPublisher error: ", error);
    });

    session.connect(token, function(error) {
      if (error) {
        console.log("Error connecting: ", error.code, error.message);
      } else {  

        session.publish(publisher, function(error) {
          if (error) {
            console.log("hi");
            console.log(error);
          } else {
            console.log('Publishing a stream.');
          }
        });
        
        publisher.on('streamCreated', function (event) {
            console.log('The publisher started streaming.');
        });

        publisher.on("streamDestroyed", function (event) {
            event.preventDefault();
          console.log("The publisher stopped streaming. Reason: "
            + event.reason);
            
        });

        console.log("Connected to the session.");
      }
    });

    session.on("streamCreated", function (event) {
        var subOptions = {audioVolume : 100};
        var subContainer = document.createElement('div');
        subContainer.id = 'stream-' + event.stream.streamId;
        document.getElementById('video_chat_videos').appendChild(subContainer);
        session.subscribe(event.stream, subContainer,subOptions);  
       console.log("New stream in the session: " + event.stream.streamId);
    });

    session.on("streamDestroyed", function (event) {
      console.log("Stream stopped. Reason: " + event.reason);
      window.location.reload();
    });
    session.connect(apiKey,token);

}



$(document).ready(function(){
    
/* Call Timer for Video Call Start */
    var hours = 0, minutes = 0, seconds = 0, t, savecall; 
    var u_type = "<?php echo $u_type; ?>";
    var myVar;
    var i = 10;

    var handler_s = function()
    {
        terminateCall();
    }

    function add()
    {
        seconds++;
        if (seconds >= 60) {
            seconds = 0;
            minutes++;
            if (minutes >= 60) {
                minutes = 0;
                hours++;
            }
        }

        var current_time = (hours ? (hours > 9 ? hours : "0" + hours) : "00") + ":" + (minutes ? (minutes > 9 ? minutes : "0" + minutes) : "00") + ":" + (seconds > 9 ? seconds : "0" + seconds);
        $(".call_timer").html((hours ? (hours > 9 ? hours : "0" + hours) : "00") + ":" + (minutes ? (minutes > 9 ? minutes : "0" + minutes) : "00") + ":" + (seconds > 9 ? seconds : "0" + seconds));
        var total_session = $('#current_session').val();
        var total_time = total_session > 10 ? total_session : "0" + total_session + ":00:00";
        var ago = total_session - 1;
        var used_time = ago > 10 ? ago : "0" + ago;
        if(current_time ==   "00:59:50")
        {
            $('#auto_termainate_call').show();
            counterMsg();
            myVar = setInterval(counterMsg, 1000);
        }
        if(current_time == total_time)
        {
            terminateCall();
        }
        timer();
    }

    function counterMsg() {
       $("div#error_msg").html("<center><i class='fa fa-times'> You Have Only " + i + " Seconds Left ! </i></center>").show();
       i--;
       if(i===-1){
        $("div#error_msg").hide();
        clearInterval(myVar);
       }
    }

    function timer() {
        t = setTimeout(add, 1000);
    }
    setTimeout(function(){
        timer();
    },10000);
    

    if(u_type == "sender")
    {
        setTimeout(function(){
            savecall = setInterval(function(){ savecalltimer(); }, 3000);
        },10000);
    }  


    function savecalltimer()
    {
        var from_id = <?php echo $uid; ?>;
        var to_id = <?php echo $main_id; ?>;
        var chat_id = <?php echo $clid; ?>;
        var time = $(".call_timer").text();
        var result;
        $.ajax({
                url:"<?php echo $this->request->webroot; ?>users/savecalltimer",
                type:"post",
                data:{from_id:from_id, to_id:to_id, chat_id:chat_id, time:time},
                dataType:"json",
                async : false,
                success: function(data)
                {
                    result = true;
                }
        });

        return result;
    }

    function terminateCall()
    {
        var main_id = <?php echo $main_id; ?>;
        session.unpublish(publisher);
        publisher.destroy();
        var data = main_id+",endsession";
        clearInterval(savecall);
        if(savecalltimer())
        {
            var from_id = <?php echo $uid; ?>;
            var to_id = <?php echo $main_id; ?>;
            var time = $(".call_timer").text();
            $.ajax({
                    url:"<?php echo $this->request->webroot; ?>trainees/updateSession",
                    type:"post",
                    data:{from_id:from_id,time:time,to_id:to_id},
                    dataType:"json",
                    async : false,
                    success: function(data)
                    {
                        console.log(data.call_data);
                    }
            });
            send( data );
            if(u_type == "sender")
            {
               $(window).unbind('unload', handler_s);
            }
            window.location.reload();
            //window.location.href="<?php echo $this->request->webroot; ?>";    
        }  
    }
/* Call Timer for Video Call End */
   
    /* End call */
    $("body").on("click","#end_session", function(){
        if(confirm("Are You sure ?"))
        {
            terminateCall();  
        }             
    });



/* For Chatting Start */

   $("body").on("keyup",".video_chat_input", function(e){
        if ( e.keyCode == 13 && !e.shiftKey) {
            e.preventDefault();
            var user_msg = $(this).val().trim();
            if(user_msg != "")
            {
                var unique   = $(this).attr("unique");
                var uid      = $(this).attr("uid");            
                var to_id    = $(this).attr("to_id");
                var chat = "";
                var rchat = "";
                $(this).val("");

                /* Save chat data in database Start */
                $.ajax({
                        url:"<?php echo $this->request->webroot; ?>users/savetextchat",
                        type:"post",
                        data:{ to_id:to_id, from_id:uid, msg:user_msg},
                        dataType:"json",
                        success: function(data)
                        {
                            //console.log(data);
                        }
                });
                /* Save chat data in database End */
                user_msg = nl2br(user_msg);
                /* store chat data in variable start */
                chat += '<div class="msg_container base_sent">';
                chat += '    <div class="messages msg_sent">';
                chat += '        <p>'+user_msg+'</p>';
                //chat += '        <time datetime="2009-11-13T20:00">Timothy • 51 min</time>';
                //chat += '        <span>'+dtime+'</span>';
                chat += '    </div>'
                chat += '    <div class="chat_avatar">'
                chat += '        <img src="<?php echo $this->request->webroot ?>uploads/<?php echo $type."_profile/".$profile[0][$type."_image"] ?>" class="img-responsive img-circle">';
                chat += '    </div>';
                chat += '</div>';
              
                rchat += '<div class="msg_container base_receive">';
                rchat += '    <div class="chat_avatar">';
                rchat += '        <img src="<?php echo $this->request->webroot ?>uploads/<?php echo $type."_profile/".$profile[0][$type."_image"] ?>" class="img-responsive img-circle">';
                rchat += '    </div>';
                rchat += '    <div class="messages msg_receive">';
                rchat += '        <p>'+user_msg+'</p>';
                // chat += '        <time datetime="2009-11-13T20:00">Timothy • 51 min</time>';
                //chat += '        <span>'+dtime+'</span>';
                rchat += '    </div>';
                rchat += '</div>';
                /* store chat data in variable End */

                /* Append data on Sender Side Start */
                $('#load_chat_'+unique).append(chat);
                $('#load_chat_'+unique).animate({scrollTop: $('#load_chat_'+unique)[0].scrollHeight}, 1000);
                /* Append data on Sender Side End */

                /* Send Data to Receiver Start */
                var jay = "userchat$@"+to_id+"$@"+unique+"$@"+rchat;
                send(jay);
                /* Send Data to Receiver Start */
            }
        }
   }); 
   
   /* For File Transfer in TextChat */
   $("body").on("change",".video_chat_file", function(){
        var unique   = $(this).attr("unique");
        var uid      = $(this).attr("uid");            
        var to_id    = $(this).attr("to_id");
        var fd = new FormData($("#send_file")[0]);
        $(this).val("");
        $.ajax({
                url:"<?php echo $this->request->webroot; ?>users/sendfile",
                type:"post",
                data:fd,
                dataType:"json",
                cache:false,
                contentType:false,
                processData:false,
                success: function(data)
                {
                    if(data.message.trim() == "success")
                    {
                        var img_ext = ["jpeg","jpg","tif","gif","png"];
                        var msg = "";
                        var rmsg = "";
                        var ext = data.ext.toLowerCase();
                        var file;

                        if($.inArray(ext,img_ext) == -1)
                        {
                           file = '<a target="_blank" href="<?php echo $this->request->webroot; ?>uploads/chat_data/'+data.newname+'"  class="file_data">'+data.newname+'</a>';
                        }else
                        {
                           file = '<img src="<?php echo $this->request->webroot; ?>uploads/chat_data/'+data.newname+'" class="file_img">';
                        }

                        /* store chat data in variable start */
                        msg += '<div class="msg_container base_sent">';
                        msg += '    <div class="messages msg_sent">';
                        msg += '        <p>'+file+'</p>';
                        //msg += '        <time datetime="2009-11-13T20:00">Timothy • 51 min</time>';
                        //msg += '        <span>'+dtime+'</span>';
                        msg += '    </div>'
                        msg += '    <div class="chat_avatar">'
                        msg += '        <img src="<?php echo $this->request->webroot ?>uploads/<?php echo $type."_profile/".$profile[0][$type."_image"] ?>" class="img-responsive img-circle">';
                        msg += '    </div>';
                        msg += '</div>';
                      
                        rmsg += '<div class="msg_container base_receive">';
                        rmsg += '    <div class="chat_avatar">';
                        rmsg += '        <img src="<?php echo $this->request->webroot ?>uploads/<?php echo $type."_profile/".$profile[0][$type."_image"] ?>" class="img-responsive img-circle">';
                        rmsg += '    </div>';
                        rmsg += '    <div class="messages msg_receive">';
                        rmsg += '        <p>'+file+'</p>';
                        // rmsg += '        <time datetime="2009-11-13T20:00">Timothy • 51 min</time>';
                        //rmsg += '        <span>'+dtime+'</span>';
                        rmsg += '    </div>';
                        rmsg += '</div>';
                        /* store chat data in variable End */

                        /* Append data on Sender Side Start */
                        $('#load_chat_'+unique).append(msg);
                        $('#load_chat_'+unique).animate({scrollTop: $('#load_chat_'+unique)[0].scrollHeight}, 1000);
                        /* Append data on Sender Side End */

                        /* Send Data to Receiver Start */
                        var jay = "userchat$@"+to_id+"$@"+unique+"$@"+rmsg;
                        send(jay);
                        /* Send Data to Receiver Start */
                    }
                }
        });
   });
/* For Chatting End */    

   function nl2br(someText) {
      return someText.replace ( /\n/gm, '<br />' );
   }

   if(u_type == "sender")
   {
       $(window).bind('unload', handler_s);
   } 



});

function resizePublisher() {
    publisher.element.style.width = "1000px";
    publisher.element.style.height = "750px";
}

$(document).ready(function(){
    $('body').on('click','.minimize-call',function(){
        $('#max-min-btn').removeClass('minimize-call').addClass('maximize-call');
        $('#video-modal').addClass('maximize-modal');
    });
    $('body').on('click','.maximize-call',function(){
        $('#max-min-btn').removeClass('maximize-call').addClass('minimize-call');
        $('#video-modal').removeClass('maximize-modal');
    });
});

</script>
