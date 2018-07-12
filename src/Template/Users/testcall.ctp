
<div class="video_chat_wrapper">
    <div class="m_video_chat_body">
        
        	<div class="full_video">
            	<div>
                	<div class="video_chat_videos test_video_call" id="video_chat_videos"></div>
                </div>
                <div class="psvideo">
                	<div id="publisher_vid"></div>
                </div>
                <div class="video_sect_footer">
                    <div class="calling_time_durtaion"><h3 class="call_timer">00:00:00</h3></div>
                    <div class="calling_ending">
                        <button class="btn" id="end_session" type="button"><i class="fa fa-phone"></i></button>
                    </div>
                    <div class="record_btn_sect">
                        <button type="button" id="record" class="record_btn">Record</button>
                        <audio controls src="" id="play_song" style="display:none"></audio>
                    </div>
                </div>
          </div>
    </div>
    <div class="clearfix"></div>
</div>

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
        }else
        {
            window.location.reload();
        }
    }else
    {
       videocall();
    }
});

videocall();
function videocall()
{
    var pubOptions =
    {
        audioSource: audioInput,
        videoSource: videoInput
    };
    
    publisher = OT.initPublisher('video_chat_videos', pubOptions, function(error) {
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
        document.getElementById('publisher_vid').appendChild(subContainer);
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

    function terminateCall()
    {
        session.unpublish(publisher);
        publisher.destroy();
        window.location.reload();
    }

    /* End call */
    $("body").on("click","#end_session", function(){
        if(confirm("Are You sure"))
        {
            terminateCall();  
        }             
    });
});

function resizePublisher() {
    publisher.element.style.width = "1000px";
    publisher.element.style.height = "750px";
}

</script>
