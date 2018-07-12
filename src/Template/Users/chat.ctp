    <!--Main container sec start-->
    <div class="main_container">
    <!--Trainee top sec start-->
        <section class="trainee_top parallax-window" data-parallax="scroll" data-image-src="<?php echo $this->request->webroot; ?>images/trainee_top_bg.jpg">
            <div class="trainee_top_inner tr_grad">
                <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                    <?php
                    if($user_type == "trainer")
                    { ?>
                        <div class="trainee_top_wrap">
                            <div class="trainee_img">
                                <?php
                                if($profile_details[0]['trainer_image'] != "")
                                { ?>
                                    <img style="width:200px;height:190px;" src="<?php echo $this->Custom->getImageSrc('uploads/trainer_profile/'.$profile_details[0]['trainer_image']) ?>" alt="img" class="img-responsive">
                            <?php }
                                else
                                { ?>
                                    <img style="width:200px;height:190px;" src="<?php echo $this->request->webroot; ?>img/default.png" alt="img" class="img-responsive">
                            <?php } ?>
                            </div>
                            <div class="trainee_detail">
                                <h1 class="trainee_name"><?php echo $profile_details[0]['trainer_name']; ?></h1>
                                <h3 class="trainee_rank">Rank Level : <span>5</span></h3>
                                <nav class="trainee_streams">
                                     <ul>
                                    <?php $skills =  $profile_details[0]['trainer_skills']; 
                                        $skillArr = explode(",", $skills);
                                        if(!empty($skillArr)) {
                                        foreach($skillArr as $s) { ?>
                                        <li><a href="javascript:void(0);" class="red_grad" title="<?php echo $s; ?>"><?php echo $s; ?> <span>&times;</span></a></li>
                                        <?php } } ?>
                                    </ul>
                                </nav>
                                <nav class="trainee_social_link">
                                    <ul>
                                    <li><a href="#" title="Linked In" class="linkedin_grad"><span class="fa fa-linkedin"></span></a></li>
                                    <li><a href="#" title="Facebook" class="facebook_grad"><span class="fa fa-facebook"></span></a></li>
                                    <li><a href="#" title="Twitter" class="twitter_grad"><span class="fa fa-twitter"></span></a></li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                   <?php }
                    if($user_type == "trainee")
                    { ?>
                        <div class="trainee_top_wrap">
                            <div class="trainee_img">
                                <?php
                                if($profile_details[0]['trainee_image'] != "")
                                { ?>
                                    <img style="width:200px;height:190px;" src="<?php echo $this->Custom->getImageSrc('uploads/trainee_profile/'.$session_details[0]['trainee_image']) ?>" alt="img" class="img-responsive">
                            <?php }
                                else
                                { ?>
                                    <img style="width:200px;height:190px;" src="<?php echo $this->request->webroot; ?>img/default.png" alt="img" class="img-responsive">
                            <?php } ?>
                            </div>
                            <div class="trainee_detail">
                                <h1 class="trainee_name"><?php echo $profile_details[0]['trainee_name']; ?></h1>
                                <h3 class="trainee_rank">Rank Level : <span>5</span></h3>
                                <nav class="trainee_streams">
                                     <ul>
                                    <?php $skills =  $profile_details[0]['trainee_skills']; 
                                        $skillArr = explode(",", $skills);
                                        if(!empty($skillArr)) {
                                        foreach($skillArr as $s) { ?>
                                        <li><a href="javascript:void(0);" class="red_grad" title="<?php echo $s; ?>"><?php echo $s; ?> <span>&times;</span></a></li>
                                        <?php } } ?>
                                    </ul>
                                </nav>
                                <nav class="trainee_social_link">
                                    <ul>
                                    <li><a href="#" title="Linked In" class="linkedin_grad"><span class="fa fa-linkedin"></span></a></li>
                                    <li><a href="#" title="Facebook" class="facebook_grad"><span class="fa fa-facebook"></span></a></li>
                                    <li><a href="#" title="Twitter" class="twitter_grad"><span class="fa fa-twitter"></span></a></li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    <?php } ?>
                        
                    </div>
                </div>
            </div>
            </div>
        </section>
    <!--Trainee top  sec end--> 
		
     <section class="trainee_dash_body">
        <div class="container">
            <div class="well">
                <h4>Share link for call</h4>
                <?php echo $_SERVER['SERVER_NAME'].$this->request->webroot."users/chat/". base64_encode($user_id); ?>
            </div>
        </div>
     	<div class="container video_chat_wrapper">
        	
        	<div class="row">
            	<div class="col-sm-8">
                	<div class="video_chat_videos" id="video_chat_videos">
                    </div>
                </div>
                <div class="col-sm-4">
                	<div id="publisher_vid"></div>
                    <br/>
                    <button class="btn btn-danger" id="end_call" type="button">End Call</button>
                </div>
            </div>
        </div>
     </section>   
        
    </div>
    <!--Main container sec end-->
<script>
var apiKey = "<?php echo $tokbox[0]['api_key']; ?>";
var sessionID = "<?php echo $chat_session[0]['session_id']; ?>";
var token = "<?php echo $chat_session[0]['token_id']; ?>";
var publisher;
var targetElement = 'publisherContainer';

var session = OT.initSession(apiKey, sessionID);

var pubOptions = { //videoSource: null
};
publisher = OT.initPublisher('publisher_vid',pubOptions);

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

    var subContainer = document.createElement('div');
    subContainer.id = 'stream-' + event.stream.streamId;
    document.getElementById('video_chat_videos').appendChild(subContainer);
    session.subscribe(event.stream, subContainer);  
   console.log("New stream in the session: " + event.stream.streamId);
});
// Replace with a valid token:
session.connect(apiKey,token);



$(document).ready(function(){
    $("#end_call").click(function(){
        session.unpublish(publisher);
         publisher.destroy();
         window.location.href="<?php echo $this->request->webroot; ?>";
        console.log("end call");
    });
});

function resizePublisher() {
    publisher.element.style.width = "1000px";
    publisher.element.style.height = "750px";
}

</script>