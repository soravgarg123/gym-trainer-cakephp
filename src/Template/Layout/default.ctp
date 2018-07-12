<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset() ?>
	<?php 
		$session = $this->request->session();
	    $user = $session->read('Auth.User');
	    $controller = $this->request->params['controller'];
	    $action = $this->request->params['action'];
	?>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<?php if($controller == "Users" && $action == "index") { ?>
		<meta name="keywords" content="personal trainer app,fitness app,online workouts,mens health workout,online workout programs,american fitness, totalgym, garage gym,totalgymdirect,weider home gym,home gyms,total gym fit,total gym,gyms">
		<meta name="description" content="Connect with a certified fitness expert through our personal training app and get trained at a local gym, at home or anywhere and anytime.Sign up today.">
	<?php } else if($controller == "Fronts" && $action == "becometrainer") { ?>
		<meta name="keywords" content="how to become a certified personal trainer,become a fitness trainer,personal training certification online,mens health workout, online fitness coach,personal trainer app, fitness coach,fitness instructor certification,workout trainer,online fitness coach,workout trainer,fitness coach">
		<meta name="description" content="Become a certified fitness specialist at Virtual TrainR and work independently at your own hours, design your own schedule and control your own income.">
	<?php } else if($controller == "Fronts" && $action == "learnmore") { ?>
		<meta name="keywords" content="home exercise equipment,home fitness equipment,gym machines,fitness gym,walmart exercise equipment,gym equipment,home gym equipment,work out equipment,workout equipment,exercise machines,home workout equipment,exercise machine,sears exercise equipment">
		<meta name="description" content="Virtual TrainR helps clients to achieve their fitness goals by getting trained by personal trainers of their own choice in person,online or at a local gym.">
	<?php } else if($controller == "Fronts" && $action == "terms") { ?>
		<meta name="description" content="Please read the terms of service agreement for You Tag Media & Business Solutions, Inc and Virtual Trainr.">
	<?php } else if($controller == "Fronts" && $action == "contactus") { ?>
		<meta name="description" content="Contact us today for any questions, comments or concerns. We will be glad to help you">
	<?php } ?>

	<?php if($controller == "Users" && $action == "index") { ?>
			<title>Virtual TrainR- Personal Training and Fitness App</title>
	<?php } else if($controller == "Fronts" && $action == "becometrainer") { ?>
			<title>Become a Certified Personal Fitness Trainer-Virtual TrainR</title>
	<?php } else if($controller == "Fronts" && $action == "learnmore") { ?>
			<title>Learn More About Us- Virtual TrainR</title>
	<?php } else if($controller == "Fronts" && $action == "terms") { ?>
			<title>Terms and Conditions - Virtual TrainR</title>
	<?php } else if($controller == "Fronts" && $action == "contactus") { ?>
			<title>Contact Us- Virtual TrainR</title>
	<?php } else { ?>
			<title>Virtual TrainR</title>
	<?php } ?>


	<link href="<?php echo $this->request->webroot; ?>img/favicon.ico" rel="shortcut icon">
	<?php echo  $this->Html->css('bootstrap.min.css') ?>
	<?php echo  $this->Html->css('animsition.min.css') ?>
	<?php echo  $this->Html->css('plugin.css') ?>
	<?php echo  $this->Html->css('font-awesome.min.css') ?>
	<?php echo  $this->Html->css('custom.css') ?>
	<?php echo  $this->Html->css('responsive.css') ?>
	<?php if(!empty($user)) { ?>
	<?php echo  $this->Html->css('lightbox.css') ?>
	<?php } ?>
	<link href="<?php echo $this->request->webroot; ?>css/styleless.less" rel="stylesheet/less">
	<?php echo  $this->Html->css('flaticon.css') ?>
	<?php if(!empty($user)) { ?>
	<?php echo  $this->Html->script('socket.io-1.2.0.js'); ?>
	<?php } ?>
	<?php echo  $this->Html->script('less.min.js'); ?>
	<?php echo  $this->Html->script('modernizr.custom.28101.js'); ?>
	<?php echo  $this->Html->script('jquery.min.js'); ?>
	<?php echo  $this->Html->script('parallax.min.js'); ?>
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?libraries=places&sensor=false"></script>
	<?php if(!empty($user)) { ?>
	<script src="<?php echo $this->request->webroot; ?>player/jwplayer.js"></script>
	<?php echo  $this->Html->script('static_opentok.js'); ?>
	<?php echo  $this->Html->css('bootstrap-datepicker.css'); ?>
	
	<?php echo  $this->Html->css('star-rating.css') ?>
	<?php echo  $this->Html->script('star-rating.min.js') ?>
	<?php echo  $this->Html->script('lightbox.min.js') ?>
	<?php echo  $this->Html->script('MediaStreamRecorder.min.js') ?>
	<?php echo  $this->Html->script('record.min.js') ?>
	<?php echo  $this->Html->script('jquery.circle-diagram.min.js') ?>
	<?php echo  $this->Html->script('mindmup-editabletable.min.js') ?>
	<?php echo  $this->Html->css('responsive-calendar.css') ?>
	<?php echo  $this->Html->script('responsive-calendar.min.js') ?>
	<?php echo  $this->Html->css('percircle.css') ?>
	<?php echo  $this->Html->script('percircle.min.js') ?>
	<?php echo  $this->Html->css('sweetalert2.css') ?>
	<?php echo  $this->Html->script('gmaps.js') ?>
	<?php echo  $this->Html->script('jquery.countdownTimer.min.js') ?>
	<?php echo  $this->Html->script('jquery.gmap.js') ?>
	<?php echo  $this->Html->script('sweetalert2.min.js') ?>
	<?php echo  $this->Html->css('jasny-bootstrap.min.css') ?>
	<?php echo  $this->Html->script('jasny-bootstrap.min.js') ?>
    <script type='text/javascript' src="https://static-na.payments-amazon.com/OffAmazonPayments/us/sandbox/js/Widgets.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js" type="text/javascript" charset="utf-8"></script>
    <?php } ?>
	<!-- jayendra start -->
	<?php if(!empty($user)) { ?>
	<script>
		var socket;
		var user_id = <?php echo (!empty($user))? $user['id'] : "''"; ?>;
		var user_name = "<?php echo (!empty($user))? $user['display_name'] : ''; ?>";

		function send( text ) {
			socket.emit('chatmessage', text);
		}

		/* Get message from sender */
		function setupcall(rdata)
		{
			console.log(rdata);
			var data = rdata.split(",");
			if(data[0] == user_id)
			{
				if(data[1].trim() == "accepted")
				{
					if(data[2].trim() == "video")
					{
						$("#load_videochat .video_chat").load("<?php echo $this->request->webroot; ?>users/videocall?unique="+data[3], function(){
							$("#end_call").modal("hide");
							$("#load_videochat").modal({
						            backdrop: 'static',
						            keyboard: false
			       	   	 	});
						});
						//window.location.href = "<?php echo $this->request->webroot; ?>users/videocall";	
					}else if(data[2].trim() == "call"){
						$("#load_videochat .video_chat").load("<?php echo $this->request->webroot; ?>users/call?unique="+data[3], function(){
							$("#end_call").modal("hide");
							$("#load_videochat").modal({
						            backdrop: 'static',
						            keyboard: false
			       	   	 	});
						});
						//window.location.href = "<?php echo $this->request->webroot; ?>users/call";	
					}
				}else if(data[1].trim() == "rejected")
				{
					$("#end_call").modal("hide");
				}else if(data[1].trim() == "endcall")
				{
					$("#accept_call").modal("hide");
				}else if(data[1] == "endsession")
				{
					//$("#load_videochat").modal("hide");
					window.location.href="<?php echo $this->request->webroot; ?>";
				}else if(data[1] == "canclecall")
				{
					window.location.reload();
					//$("#load_videochat").modal("hide");
					//window.location.href="<?php echo $this->request->webroot; ?>";
				}else if(data[2].trim() == "chat")
				{
					if(typeof data[5] != 'undefined')
					{
						var scall = data[5];
						data = data.toString();
						setupchat(data,scall);
					}else
					{
						data = data.toString();
						console.log(data);
						console.log("setupchat");
						setupchat(data,"receiver");	
					}
				}else
				{
					var t_type = data[3].trim();
				
					var profile1 = createsession(data[0],data[1],t_type,"receiver");
					
					if(profile1 !== "")
					{
						if(t_type.trim() == "trainee")
						{
							if(profile1[0].trainee_image != "")
							{
								var src = "<?php echo $this->request->webroot; ?>uploads/trainee_profile/"+profile1[0].trainee_image;
								$(".accept_img > img").attr("src",src);
							}
							$(".call_name").text(profile1[0].trainee_displayName);
						}else if(t_type.trim() == "trainer")
						{
							if(profile1[0].trainer_image != "")
							{
								var src = "<?php echo $this->request->webroot; ?>uploads/trainer_profile/"+profile1[0].trainer_image;
								$(".accept_img > img").attr("src",src);
							}
							$(".call_name").text(profile1[0].trainer_displayName);
						}

						$("#call_accept").attr("from_id", data[1]);
						$("#call_accept").attr("c_type", data[2]);

						$("#reject_call").attr("from_id", data[1]);

						$("#accept_call").modal({
				            backdrop: 'static',
				            keyboard: false
				        });
					}
				}
			}else if(data[0].trim() == "reopen")
			{
				if(data[7] == user_id)
				{
					data.shift();
					if(data[2].trim() == "chat")
					{
						var scall = data[5];
						data.pop();
						data.pop();
						data = data.toString();
						setupchat(data,scall);
					}
				}
			}else if(data[7] == user_id)
			{
				var to_id;
				data.shift();
				if(data[6] == data[0])
				{
					to_id = data[1];
				}else{
					to_id = data[0];
				}
				data.pop(); 
				var all = data.toString();
				all = all+","+to_id;
				sessionStorage.setItem("rclose_"+to_id,all);
			}else
			{
				var sdata = rdata.split("$@");
				if(sdata[0].trim() == "userchat")
				{
					if(sdata[1] == user_id)
					{
						$('#load_chat_'+sdata[2]).append(sdata[3]);
						$('#load_chat_'+sdata[2]).animate({scrollTop: $('#load_chat_'+sdata[2])[0].scrollHeight}, 1000); // scroll down in chat box
					}
				}
			}
		}

		/* create session for from id */
		function createsession(to_id,from_id,type,call)
		{
			var profile = "";
			$.ajax({
					url:"<?php echo $this->request->webroot ?>users/createsession",
					type:"post",
					data:{ to_id:to_id, from_id:from_id, type:type, call:call },
					async: false,  
					dataType:"json",
					success: function(data)
					{
						if(data.profile != "")
						{
							profile = data.profile;
						}
					}
			});
			return profile;			
		}

		/* Setup chatting */
		function setupchat(data,call)
		{
			console.log(data);
			var all = data.split(",");
			var id,count;
			if(call == "sender")
			{
				id = all[0];
			}else
			{
				id = all[1];
			}
			
			var user_string = $('#hidden_array').val();
		    var user_array = user_string.split(",");
		    if($.inArray(id,user_array) == -1){ // check id exist in id array or not
				var nrow = $(".multi_chat_window_wraper .chat_windo_block").length;
				if(nrow < 4)
				{
					user_array.push(id); // insert id in id array
			        var usertostring = user_array.toString();
			        $('#hidden_array').val(usertostring); // set array string in hidden value 
			        
			        /* check and create openid session Start */
			        var odata = data+","+call;
			        var openid = sessionStorage.getItem("openid");
			        if(openid != null)
			        {
			        	if(openid != "")
			        	{
			        		openid = openid.split(",");
				        	if($.inArray(id,openid) == -1)
				        	{

				        		openid.push(id);
				        		openid = openid.toString();
				        		sessionStorage.setItem("openid",openid);
				        		sessionStorage.setItem("open_"+id,odata);
				        	}
			        	}else
			        	{
			        		sessionStorage.setItem("openid",id);
			        		sessionStorage.setItem("open_"+id,odata);
			        	}			        	
			        }else
			        {
			        	sessionStorage.setItem("openid",id);
			        	sessionStorage.setItem("open_"+id,odata);
			        }
			        /* check and create openid session End */

			        count = parseInt($("#hidden_count").val());
					count = count+1;
					$("#hidden_count").val(count);
					$(".multi_chat_window_wraper").append('<div class="chat_windo_block chat_window_'+count+'"></div>');
					$(".chat_window_"+count).load("<?php echo $this->request->webroot; ?>users/userchat?all="+data+"&count="+count+"&call="+call);
					$(".chat_window_"+count).fadeIn('slow');
					console.log(data);
					send( data );
				}else{
					//alert("limit exceed");
				}
			}
		}

		/* Generate random string */
		function makeid()
		{
		    var text = "";
		    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

		    for( var i=0; i < 15; i++ )
		        text += possible.charAt(Math.floor(Math.random() * possible.length));

		    return text;
		}

		/* For Auto Load ChatBox while page refresh Function */
		function loadopenchat()
		{
			var openid = sessionStorage.getItem("openid");
	        if(openid != null)
	        {
	        	if(openid != "")
	        	{
	        		openid = openid.split(",");
		        	$.each(openid, function(i,n){
		        		var odata = sessionStorage.getItem("open_"+n);
		        		odata = odata.split(",");
		        		var ocall = odata[5];
		        		odata.pop();
		        		odata = odata.toString();
		        		setupchat(odata,ocall);
		        	});
	        	}	        	
	        }
		}

		$(document).ready(function() {
			var hostname = "<?php echo $_SERVER['SERVER_NAME']; ?>";
			if(hostname == "localhost"){
				socket = io('http://localhost:3600');
			}
			if(hostname == "virtualtrainr.com"){
				socket = io('https://virtualtrainr.com:3600');
			}
			if(hostname == "52.201.154.19") {
				socket = io('http://52.201.154.19:3700');
			}
			
			/* While Accept call */
			$("body").on("click","#call_accept", function(){
				var c_type = $(this).attr("c_type");
				var from_id = $(this).attr("from_id");
				var unique_id = makeid();
				data = from_id+",accepted,"+c_type+","+unique_id;
				send( data );
				if(c_type == "video")
				{
					$("#load_videochat .video_chat").load("<?php echo $this->request->webroot; ?>users/videocall?unique="+unique_id, function(){
						$("#accept_call").modal("hide");
						$("#load_videochat").modal({
				            backdrop: 'static',
				            keyboard: false
			       	   	 });
					});
				}else if(c_type == "call"){
					$("#load_videochat .video_chat").load("<?php echo $this->request->webroot; ?>users/call?unique="+unique_id, function(){
						$("#accept_call").modal("hide");
						$("#load_videochat").modal({
				            backdrop: 'static',
				            keyboard: false
			       	   	 });
					});
				}				
			});

			/* While Reject Call */
			$("body").on("click", "#reject_call", function(){
				var from_id = $(this).attr("from_id");
				data = from_id+",rejected";
				send( data );
				$("#accept_call").modal("hide");
			});

			/* While End call */
			$("body").on("click", "#call_end", function(){
				var to_id = $(this).attr("to_id");
				data = to_id+",endcall";
				send( data );
				$("#end_call").modal("hide");
				$('input[name="check_one_to_one"]').val('inactive');
			});

			/* Call to user */
			$("body").on("click", ".user_call", function(){
				var to_id = $(this).attr("to_id");
				var from_id = $(this).attr("from_id");
				var c_type = $(this).attr("c_type");
				var t_type = $(this).attr("t_type"); 
				var profile1 = "";
				var type;
				var uniqe = makeid();
				var data = to_id+","+from_id+","+c_type+","+t_type+","+uniqe;

				if(c_type.trim() == "chat")
				{
					var sdata = sessionStorage.getItem("close_"+to_id); // check to_id in close session data
			        if(sdata != null)
			        {   
			        	sessionStorage.removeItem("close_"+to_id); // remove item from close session
			        	sd = sdata.split(",");
			            var scall = sd[5];
			            sd.pop();
			            sd.pop();
			            sd = sd.toString();
			            setupchat(sd,scall);
			        }else
			        {
			        	setupchat(data,"sender");	
			        }					
				}else{
					
					if(t_type.trim() == "trainer")
					{
						type = "trainee";
					}else if(t_type.trim() == "trainee")
					{
						type = "trainer";
					}
					profile1 = createsession(to_id,from_id,type,"sender");

					if(profile1 !== "")
					{
						console.log(data);
						//console.log(profile1[0].trainee_displayName);
						send( data );
						
						if(t_type.trim() == "trainer")
						{
							if(profile1[0].trainee_image != "")
							{
								var src = "<?php echo $this->request->webroot; ?>uploads/trainee_profile/"+profile1[0].trainee_image;
								$("#end_call .end_img > img").attr("src",src);
							}
							$("#end_call .end_name").text(profile1[0].trainee_displayName);
						}else if(t_type.trim() == "trainee")
						{
							if(profile1[0].trainer_image != "")
							{
								var src = "<?php echo $this->request->webroot; ?>uploads/trainer_profile/"+profile1[0].trainer_image;
								$("#end_call .end_img > img").attr("src",src);
							}
							$("#end_call .end_name").text(profile1[0].trainer_displayName);
						}
						
						$("#call_end").attr("to_id",to_id);

						$("#end_call").modal({
				            backdrop: 'static',
				            keyboard: false
				        });
				        $('#appointment_modal1').modal('hide');
					}	
				}
			});

			/* Close chat box */
			$("body").on('click', '.icon_close', function (e) {
			    var count = $(this).attr("main");
			    var main_id = $(this).attr("main_id");
			    var all = $("#alldata_"+count).val();
			    all = all+","+main_id; 
			    var user_string1 = $('#hidden_array').val();
	            var user_array1 = user_string1.split(",");
	            var index = user_array1.indexOf(main_id);
	            user_array1.splice(index, 1);
	            var usertostring1 = user_array1.toString();
            	$('#hidden_array').val(usertostring1);
			   	
			   	/* store data in close session Start */
			   	sessionStorage.setItem("close_"+main_id,all);	
			   	all = "store,"+all;		   	
			   	send( all );
			    /* store data in close session End */

			    /* Remove Id from opendid session start */
			    var openid = sessionStorage.getItem("openid");
			    openid = openid.split(",");
			    var oindex = openid.indexOf(main_id);
	            openid.splice(oindex, 1);
	            openid = openid.toString();

	            sessionStorage.removeItem("open_"+main_id);
	            sessionStorage.setItem("openid",openid);
			    /* Remove Id from opendid session End */

			    $(".chat_window_"+count ).remove();
			});

			socket.on('chatmessage', function(msg){ 
		    	setupcall(msg);
		    });
			
		});
	</script>
	<?php } ?>
	<!-- jayendra end -->
	<?php echo $this->fetch('meta') ?>
	<?php echo $this->fetch('css') ?>
	<?php echo $this->fetch('script') ?>
</head>
<body>  
	<?php
		if(!empty($user))
		{
	 		echo $this->element('front_sidebar');
	 	}else{
	 		echo $this->element('front_header');
	 	}
	?>
	<input type="hidden" id="hidden_array">
	<input type="hidden" id="hidden_count" value="0">
	<div id="container">

		<div id="content">
			<?php echo $this->Flash->render() ?>

			<div class="">
				<?php echo $this->fetch('content') ?>
			</div>
		</div>
		<?php
			if(!empty($user))
			{
				echo $this->element('front_footer');
			}else
			{
				echo $this->element('index_footer');
			}
		?>

		<?php echo  $this->Html->script('bootstrap.min.js') ?>
		<?php echo  $this->Html->script('bootstrap-datepicker.min.js') ?>
		<?php echo  $this->Html->script('plugin.min.js') ?>
		<?php if(!empty($user)) { ?>
		<?php echo  $this->Html->script('worldLow.min.js') ?>
		<?php } ?>
		<?php echo  $this->Html->script('custom.js') ?>

	</div>

<?php if(!empty($user)) { ?>

<!-- jayendra start -->
<!-- modal for end call Start -->
<div class="modal fade bs-example-modal-sm" id="end_call">
  <div class="modal-dialog modal-sm">
    <div class="modal-content calling_modal_box">
      <div class="modal-body">
      	<div class="calling_dilog_box">
      		<div class="row">
      			<div class="col-sm-12">
      				<span class="end_img"><img src="<?php echo $this->request->webroot; ?>img/default.png"></span>
      				
      				<span class="end_rest"><img src="<?php echo $this->request->webroot; ?>img/calling.GIF"></span>
      			</div>
      			<div class="col-sm-12">
      				<span class="end_name"></span>
      				<div class="call_ing_button">
      				<button type="button" class="btn reject_btn" id="call_end">End Call</button>
      				</div>
      			</div>
      		</div>
      	</div>
      	
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- modal for end call End -->

<!-- modal for Accept and End call Start -->
<div class="modal fade bs-example-modal-sm" id="accept_call">
  <div class="modal-dialog modal-sm">
    <div class="modal-content calling_modal_box">
      <div class="modal-body">
      	<div class="calling_dilog_box">
      		<div class="row">
      			<div class="col-sm-12">
      			<span class="accept_img"><img src="<?php echo $this->request->webroot; ?>img/default.png"></span>
      			<span class="accept_rest"> <img src="<?php echo $this->request->webroot; ?>img/calling.GIF"></span>
      			</div>
      			<div class="col-sm-12">
      				<span class="call_name"> </span>
      				<div class="call_ing_button">
      					<button type="button" class="btn accept_btn" id="call_accept">Accept Call</button>
	        			<button type="button" class="btn reject_btn" id="reject_call">Reject Call</button>
      				</div>
      			</div>
      		</div>
        </div>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- modal for Accept and End call End -->

<!-- jayendra end -->
<?php } ?>

</body>
</html>
