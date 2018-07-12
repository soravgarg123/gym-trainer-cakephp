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
                            <li><a href="<?php echo $this->request->webroot; ?>plans" title="Pircing Plan">Pricing plan</a></li>
                            <li><a href="<?php echo $this->request->webroot; ?>terms" title="Terms &amp; Conditions">Terms &amp; conditions </a></li>
                            <li><a href="<?php echo $this->request->webroot; ?>career" title="Career">Career</a></li>
                            <li><a href="<?php echo $this->request->webroot; ?>opportunity" title="Opportunity">Opportunity</a></li>
                            <li><a href="<?php echo $this->request->webroot; ?>contactus" title="Contact Us">Contact us</a></li>
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
            $new_type = 'minus';
            $class = "glyphicon icon_minim glyphicon-minus";
            $style = "display:block";
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
    $(document).ready(function () {
        $('.alert-success').fadeOut(15000);
        $('.alert-danger').fadeOut(15000);
        $('.lb-details').html("");

        $(".chat_list_sect").load("<?php echo $this->request->webroot; ?>users/onlineuser");
        
        setInterval(function(){
            $(".chat_list_sect").load("<?php echo $this->request->webroot; ?>users/onlineuser");    
        }, 10000);
    });
</script>

<!-- Hidden Modal Script Start -->
<script type="text/javascript">
    $(document).ready(function(){
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
