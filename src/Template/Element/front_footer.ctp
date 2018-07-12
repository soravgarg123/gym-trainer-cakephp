 <!--Footer sec start-->
    <footer id="footer" class="footer_sec">
        <div class="footersec_inner">
            <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    <div class="footer_left">
                        <p>Copyright &copy; <?php echo date('Y'); ?></p>
                    </div>
                </div>
                <div class="col-sm-9">
                    <nav class="footer_nav">
                        <ul>
                            <li><a href="<?php echo $this->request->webroot; ?>" title="Home">Home</a></li>
                            <li><a href="<?php echo $this->request->webroot; ?>terms" title="Terms &amp; Conditions">Terms &amp; conditions </a></li>
                            <li><a href="<?php echo $this->request->webroot; ?>learn-more" title="Learn More ">Learn More </a></li>
                            <li><a href="<?php echo $this->request->webroot; ?>contact-us" title="Contact Us">Contact us</a></li>
                        </ul>
                    </nav>
                    
                </div>
            </div>
        </div>
        </div>
        <div class="loading" style="display:none">
           <div class="loading_icon" style="display:none"><span class="fa fa-spin fa-spinner"></span>
           </div>
        </div>
    </footer>
    <!--Footer sec end-->

   <!-- jayndra start -->

    <!-- multi window chat start -->
    <div class="multi_chat_window_wraper">

    </div>
    <!-- multi window chat start -->

    <!-- online users list start -->
    <?php
        $new_type = "";
        $class = "";
        $state_type = $this->request->session()->read('state_type');
        if(empty($state_type)){
            $new_type = 'plus';
            $class = "glyphicon icon_minim panel-collapsed glyphicon-plus";
            $style = "display:none";
        }
        if(!empty($state_type) && $state_type == "minus"){
            $new_type = 'minus';
            $class = "glyphicon icon_minim glyphicon-minus";
            $style = "display:block";
        }
        if(!empty($state_type) && $state_type == "plus"){
            $new_type = 'plus';
            $class = "glyphicon icon_minim panel-collapsed glyphicon-plus";
            $style = "display:none";
        }
    ?>

    <?php 
        $this->request->session()->start();
        $session = $this->request->session();
        $user_data1 = $session->read('Auth.User');
    ?>  

    <div class="chat_list_wrapper">
        <div id="chat_window_chat_sect">
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title">Online</h3>
                    <a href="javascript:void(0);" main="<?php echo $new_type; ?>" id="minim_chat_window"><span class="<?php echo $class; ?>"></span></a>
                </div>
                <div class="panel-body" id="online_user_sec" style="<?php echo $style; ?>">
                    <ul class="chat_list_sect">
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <?php if($user_data1['user_type'] == "trainee") { ?>

    <!-- Appointment Modal Start -->

    <div class="modal fade" id="appointment_modal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">please begin your session</h4>
          </div>
          <div class="modal-body">
             <div class="trainer_img">
             <img id="trainer_img" style="height:260px;width:100%" src="" alt="img" class="img-responsive">
            </div>
          </div>
          <div class="modal-footer">
            <div class="trainer_info">
            <a href="javascript:void(0);">
                </a><p><a href="javascript:void(0);"><strong></strong></a><strong>
                <a style="color:white;" href="javascript:void(0);"> Trainer : </a></strong><a style="color:white;" id="trainer_namee" href="javascript:void(0);"> </a> <span class="dte" id="appoint_date"></span></p>
                <p><a href="javascript:void(0);"><strong></strong></a><strong>
                <a style="color:white;" href="javascript:void(0);"> Location : </a></strong><a style="color:white;" id="location_namee" href="javascript:void(0);"> </a> <span class="dte" id="appoint_time"></span></p>
                <div class="trai_rank">
                  <a title="Car" class="btn btn-default treines_cal_btn" href="javascript:void(0);"><i class="fa fa-car" aria-hidden="true"></i></a>               
                  <a id="text_chat_btn" title="Text Chat" c_type="chat" t_type="trainee" from_id="<?php echo $user_data1['id']; ?>" to_id="" class="btn btn-default user_call treines_cal_btn" href="javascript:void(0);"><i class="fa fa-weixin"></i></a>
                  <a id="video_chat_btn" title="Video Call" c_type="video" t_type="trainee" from_id="<?php echo $user_data1['id']; ?>" to_id="" class="btn btn-default user_call treines_cal_btn" href="javascript:void(0);"><i class="fa fa-video-camera" aria-hidden="true"></i></a>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Appointment Modal End -->
    <input type="hidden" name="check_one_to_one" value="inactive"/>
    <?php } ?>

    <!-- online users list end -->

    <div id="load_videochat" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
        <div class="body_blur"></div>
      <div class="modal-dialog modal-lg" id="video-modal">
        <div class="modal-content video_chat">
         
        </div>
      </div>
    </div>

    <!-- jayndra end -->

<script>

    function addZero(i) {
        if (i < 10) {
            i = "0" + i;
        }
        return i;
    }

    function getCureentTime()
    {
        var d = new Date(); 
        var hours = addZero(d.getHours());
        var day   = addZero(d.getDate());
        var minutes= addZero(d.getMinutes());
        var month = "<?php echo date('m'); ?>";
        var year  = "<?php echo date('Y'); ?>";
        var arr = [day,month,year,hours,minutes];
        return arr;
    }

    $(document).ready(function () {
        var hostname = "<?php echo $_SERVER['SERVER_NAME']; ?>";
        $('.alert-success').fadeOut(15000);
        $('.alert-danger').fadeOut(15000);
        $('.lb-details').html("");
        

        $(".chat_list_sect").load("<?php echo $this->request->webroot; ?>users/onlineuser");
        
        if(hostname != "localhost"){
            setInterval(function(){
                $(".chat_list_sect").load("<?php echo $this->request->webroot; ?>users/onlineuser");    
            }, 1000);
        }
        

        var userType = "<?php echo $user_data1['user_type'] ?>";

        if(userType == "trainee" && hostname != "localhost"){
            setInterval(function(){
            var current_date_time = getCureentTime();
            var date = current_date_time[2]+"-"+current_date_time[1]+"-"+current_date_time[0];
            var time = current_date_time[3]+":"+current_date_time[4];
            var oneTone = $('input[name="check_one_to_one"]').val();
                $.ajax({
                    url: '<?php echo $this->request->webroot; ?>trainees/getVideoCalls',
                    type: 'post',
                    data: {date:date,time:time},
                    dataType: 'json',
                    success:function(response){
                        var result = response.message;
                        if(result != "" && oneTone == 'inactive'){
                           $('input[name="check_one_to_one"]').val('active');
                           $('#trainer_img').attr('src','<?php echo $this->request->webroot; ?>uploads/trainer_profile/'+result[0]['trainer_image']);
                           $('#trainer_namee').text(result[0]['trainer_name']+" "+result[0]['trainer_lname']);
                           $('#appoint_date').text(result[0]['date']);
                           $('#location_namee').text(response.city);
                           $('#appoint_time').text(result[0]['start_time']);
                           $('#text_chat_btn').attr('to_id',result[0]['trainer_id']);
                           $('#video_chat_btn').attr('to_id',result[0]['trainer_id']);
                           $('#appointment_modal1').modal({backdrop:'static',keyboard:false, show:true}); 
                        }else{
                            $('#appointment_modal1').modal('hide');
                        }
                    },
                    error:function(error){
                        console.log(error);
                    }
                });
            }, 10000);
        }
    });

    $('#end_call').on('hidden.bs.modal', function () {
        $('input[name="check_one_to_one"]').val('inactive');
    });
</script>

<!-- Hidden Modal Script Start -->
<script type="text/javascript">
    $(document).ready(function(){
    var sweet_alert_sucess_msg = "<?php echo $this->request->session()->read('sucess_alert'); ?>";
    var sweet_alert_error_msg  = "<?php echo $this->request->session()->read('error_alert'); ?>";
    if(sweet_alert_sucess_msg != ""){
        showAlert('success','Success',sweet_alert_sucess_msg);
        <?php $this->request->session()->delete('sucess_alert'); ?>
    }
    if(sweet_alert_error_msg != ""){
        showAlert('error','Error !',sweet_alert_error_msg);
        <?php $this->request->session()->delete('error_alert'); ?>
    }
    $('#LoginModal, #signup_Modal_trainee, #signup_Modal_trainer').on('hidden.bs.modal', 'shown.bs.modal',function (e) {
        $('input, select').val("");
        $('input, select').removeClass('required-error');
        $('#success_msg, #inactive_msg, #error_msg, img#loading-img, #success_msg1, #error_msg1, #invalid_msg, #error_msg_login').hide();
        $('#line2, #line3, #line5, #line6, #trainee_state, #trainee_city, #trainer_state, #trainer_city').html("");
        $('#trainee, #trainer').attr('disabled', false);
        $('#login-btn').val('Login');
        $('#trainee, #trainer').val('Sign in');
    });
    });
</script>
<!-- Hidden Modal Script End -->

<!-- jayendra code 15-12-2015 test call start -->
<script type="text/javascript">
    $(document).ready(function(){
        $("body").on("click","#test_call", function(){
            $('#leftNavMenu').offcanvas('hide');
            $(".video_chat").load("<?php echo $this->request->webroot; ?>users/testcall", function(){
                $("#load_videochat").modal({
                        backdrop: 'static',
                        keyboard: false
                });
            });
        });
    });
</script>

<!-- jayendra code 15-12-2015 test call end -->

<!-- For minimize-maximize Text chat start -->

<script type="text/javascript">
    $(document).on('click', '.panel-heading span.icon_minim', function (e) {
    var $this = $(this);
    if (!$this.hasClass('panel-collapsed')) { // minus to plus
        $this.parents('.panel').find('.panel-body').slideUp(); 
        $this.parents('.panel').find('.panel-footer').slideUp();
        $this.addClass('panel-collapsed');
        $this.removeClass('glyphicon-minus').addClass('glyphicon-plus');
        $('#minim_chat_window').attr('main','plus'); // save current status
    } else { // plus to minus
        $this.parents('.panel').find('.panel-body').slideDown();
        $this.parents('.panel').find('.panel-footer').slideDown();
        $this.removeClass('panel-collapsed');
        $this.removeClass('glyphicon-plus').addClass('glyphicon-minus');
        $('#minim_chat_window').attr('main','minus'); // save current status
    }
    var val = $('#minim_chat_window').attr('main');
    $.ajax({
        url: '<?php echo $this->request->webroot; ?>users/saveChatState',
        type: 'post',
        data: { val: val },
        dataType: 'json',
        success:function(response){
            console.log(response);
        },
        error:function(error){
            console.log(error);
        }
    });
});
</script>

<!-- For minimize-maximize Text chat start -->
