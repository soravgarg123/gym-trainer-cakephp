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
                <div class="col-sm-6">
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
                <div class="col-sm-3">
                    <div class="bowser_point">
                      <a class="best_viewed" href="javascript:void(0);" title="Best Viewed in">Best Viewed in</a>
                      <ul>
                        <li><img title="Mozilla Firefox" src="<?php echo $this->request->webroot; ?>img/firefox.png"><span>mozilla</span>Firefox</li>
                          <li><img  title="Google Chrome" src="<?php echo $this->request->webroot; ?>img/chrome.png">Chrome</li>
                          <div class="clearfix"></div>
                      </ul>
                    </div>
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

<script>
    $(document).ready(function () {
        $('.alert-success').fadeOut(15000);
        $('.alert-danger').fadeOut(15000);
        $('.lb-details').html("");
    });
</script>

<!-- Hidden Modal Script Start -->
<script type="text/javascript">
    $(document).ready(function(){
    $('#LoginModal, #signup_Modal_trainee, #signup_Modal_trainer').on('hidden.bs.modal','shown.bs.modal', function (e) {
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

<!-- Login Modal start-->
<div class="modal fade login_modal" id="LoginModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
       <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h2 class="modal-title" id="loginModalLabel"><span class="flaticon-doorkey"></span>Login</h2>
      </div>
      <div class="modal-body">
      <?php echo $this->Custom->successMsg(); ?>
      <?php echo $this->Custom->errorMsg(); ?>
      <center><img style="display:none;" id="loading-img" src="<?php echo $this->request->webroot; ?>img/loading-spinner-grey.gif" /></center></br>
            <form role="form" method="post">
                <div id="invalid_msg" style="display:none;" class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                   <center><i class="fa fa-times"></i> Invalid Email id Or Password</center>
                </div>
                <div id="inactive_msg" style="display:none;" class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                   <center><i class="fa fa-times"></i> Currently your profile is inactive !</center>
                </div>
                <div id="error_msg_login" style="display:none" class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                   <b></b> <center> <i class="fa fa-times"></i> Something Wrong Please Try Again !</center>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-addon">
                            <span class="fa fa-envelope"></span>
                        </div>
                        <input type="email" id="email" class="form-control" placeholder="Email">
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-addon">
                            <span class="fa fa-lock"></span>
                        </div>
                        <input type="password" id="password" class="form-control" placeholder="Password">
                    </div>
                </div>
                <div class="form-group clearfix">
                    <div class="fp">
                        <a href="javascript:void(0);" data-dismiss="modal" data-toggle="modal" data-target="#ForgotPasswordModal">Forgot Password</a>
                    </div>
                    <div class="dha">
                        <a href="javascript:void(0);" data-dismiss="modal" data-toggle="modal" data-target="#signup_Modal">Don't Have Account</a>
                    </div>
                </div>
                <div class="form-group">
                    <input type="button" id="login-btn" class="lsmb_btn gray_grad" value="Login" title="Click Here to Login">
                </div>
                <div class="form-group">
                    <div class="or">
                        <h3>Or</h3>
                    </div>
                </div>
                <div class="form-group clearfix">
                    <div class="social_btn1">
                        <a onclick="fbSignup('login')" class="btn btn-lg btn-block btn-social btn-facebook">
                          <i class="fa fa-facebook"></i>
                            Facebook
                        </a>
                    </div>
                    <div class="social_btn2">
                        <a onClick="googleSignup('login')" class="btn btn-block btn-social btn-google btn-lg">
                          <i class="fa fa-google-plus"></i>
                          Google +
                        </a>
                    </div>
                </div>
            </form>
      </div>
    </div>
  </div>
</div>
<!-- Login Modal end-->

<!-- Forgot Password Modal start-->
<div class="modal fade login_modal" id="ForgotPasswordModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
       <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h2 class="modal-title" id="loginModalLabel"><span class="flaticon-doorkey"></span>Forgot Password</h2>
      </div>
      <div class="modal-body">
            <?php echo $this->Custom->successMsg(); ?>
            <?php echo $this->Custom->errorMsg(); ?>
            <center><img style="display:none;" id="loading-img" src="<?php  echo $this->request->webroot; ?>img/loading-spinner-grey.gif" /></center></br>
            <form role="form" method="post">
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-addon">
                            <span class="fa fa-envelope"></span>
                        </div>
                        <input type="email" id="forgot-email" class="form-control" placeholder="Email">
                    </div>
                </div>
                <div class="form-group clearfix">
                    <div class="fp">
                        <a href="javascript:void(0);" data-dismiss="modal" data-toggle="modal" data-target="#LoginModal">Login</a>
                    </div>
                    <div class="dha">
                        <a href="javascript:void(0);" data-dismiss="modal" data-toggle="modal" data-target="#signup_Modal">Don't Have Account</a>
                    </div>
                </div>
                <div class="form-group">
                <button type="button" id="forgot-btn" class="lsmb_btn gray_grad">Send</button>
                </div>
            </form>
      </div>
    </div>
  </div>
</div>
<!-- Forgot Password Modal end-->

<!-- Modal -->
<div class="modal fade suoption_modal" id="signup_Modal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h2 class="modal-title" id="myModalLabel">Signup</h2>
      </div>
      <div class="modal-body">
            <nav class="sumodal_nav">
                <ul>
                    <li><a href="javascript:void(0);" class="btn btn-danger btn-lg" data-dismiss="modal" data-toggle="modal" data-backdrop="static" data-keyboard="false" data-target="#signup_Modal_trainee">As Trainee</a></li>
                    <li><a href="javascript:void(0);" class="btn btn-success btn-lg" data-dismiss="modal" data-toggle="modal" data-backdrop="static" data-keyboard="false" data-target="#signup_Modal_trainer">As Trainer</a></li>
                </ul>
            </nav>
      </div>
    </div>
  </div>
</div>

<!--Signup Modal for trainee start-->
<div class="modal fade signup_modal" id="signup_Modal_trainee" tabindex="-1" role="dialog" aria-labelledby="signupModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
       <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h2 class="modal-title" id="signupModalLabel"><span class="flaticon-profile7"></span>Signup For Trainee</h2>
      </div>
      <div class="modal-body">
       <?php echo $this->Custom->successMsg(); ?>
      <?php echo $this->Custom->errorMsg(); ?>
      <center><img style="display:none;" id="loading-img" src="<?php echo $this->request->webroot; ?>img/loading-spinner-grey.gif" /></center>
            <form role="form" method="post" id="trainee_form">
            <div id="success_msg1" style="display:none" class="alert alert-success alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
               <b></b> <center> <i class="fa fa-check"></i> Trainee Created Successfully </center>
            </div>
            <div id="error_msg1" style="display:none" class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
               <b></b> <center> <i class="fa fa-times"></i> Something Wrong Please Try Again !</center>
            </div>
               <div class="suf_row clearfix">
                    <div class="form-group">
                        <input type="text" name="trainee_name" class="form-control" required placeholder="First Name*">
                    </div>
                    <div class="form-group">
                        <input type="text" id="trainee_lname"required name="trainee_lname" class="form-control" placeholder="Last Name*">
                    </div>
               </div>
               <div class="suf_row clearfix">
                    <!-- <div class="suf_col"> -->
                    <div class="form-group">
                        <select required name="trainee_gender" class="form-control ">
                            <option value="">Gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <select required name="trainee_age" class="form-control ">
                           <option value="">Age</option>
                            <?php 
                                for($i=16;$i<=60;$i++) { ?>
                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <!-- </div> -->
                    <!-- <div class="suf_col1"> -->
                        
                    <!-- </div> -->
               </div>
               <div class="suf_row">
                  <div class="form-group">
                      <input required name="trainee_displayName" type="text" class="form-control" placeholder="Display Name*">
                  </div>
                  <div class="form-group">
                        <input type="email" id="trainee_email"required name="trainee_email" class="form-control" placeholder="Email*">
                        <span id="line3" class="text-left"></span>
                    </div>
               </div>
               <div class="suf_row">
                    <div class="form-group">
                        <select required id="trainee_country" name="trainee_country" class="form-control ">
                            <option value="">Country</option>
                            <?php 
                            foreach($countries as $c) { ?>
                                <option value="<?php echo $c['id']; ?>"><?php echo $c['name']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <select required id="trainee_state"  name="trainee_state" class="form-control ">
                            <option value="">Province</option>
                        </select>
                    </div>
               </div>
               <div class="suf_row">
                     <div class="form-group">
                        <!-- <input required type="text" name="trainee_city" class="form-control" placeholder="City"> -->
                        <select required id="trainee_city" name="trainee_city" class="form-control ">
                            <option value="">City</option>
                        </select>
                    </div>
                     <div class="form-group">
                        <input required type="text" name="trainee_zip" class="form-control" placeholder="Postal Code">
                    </div>
               </div>
               <div class="suf_row">
                    <div class="form-group">
                        <input required type="password" id="trainee_password" name="trainee_password" class="form-control" placeholder="Password*">
                    </div>
                    <div class="form-group">
                        <input required type="password" id="trainee_cnfm_password" name="trainee_cnfm_password" class="form-control" placeholder="Confirm Password*">
                        <span id="line5" class="text-left"></span>
                    </div>
               </div>
               <div class="suf_row clearfix">
                    <div class="suf_col">
                        <div class="social_btn1">
                        <a onclick="fbSignup('signup')" class="btn btn-lg btn-block btn-social btn-facebook">
                          <i class="fa fa-facebook"></i>
                            Facebook
                        </a>
                    </div>
                        <div class="social_btn2">
                            <a onClick="googleSignup('signup')" class="btn btn-block btn-social btn-google btn-lg">
                              <i class="fa fa-google-plus"></i>
                              Google +
                            </a>
                        </div>
                    </div>
                    <div class="suf_col">
                        <input type="button" id="trainee" class="lsmb_btn gray_grad" value="Sign in" title="Click Here to Sign in">
                    </div>
               </div>
            </form>
      </div>
    </div>
  </div>
</div> 
<!--Signup Modal for for trainee end--> 

<!--Signup Modal for trainer start-->
<div class="modal fade signup_modal" id="signup_Modal_trainer" tabindex="-1" role="dialog" aria-labelledby="signupModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
       <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h2 class="modal-title" id="signupModalLabel"><span class="flaticon-profile7"></span>Signup For Trainer</h2>
      </div>
      <div class="modal-body">

      <center><img style="display:none;" id="loading-img" src="<?php echo $this->request->webroot; ?>img/loading-spinner-grey.gif" /></center>
            <form role="form" id="trainer_form" method="post">

             <div id="success_msg11" style="display:none" class="alert alert-success alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
               <b></b> <center> <i class="fa fa-check"></i> Trainer Created Successfully </center>
            </div>
            <div id="error_msg" style="display:none" class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
               <b></b> <center> <i class="fa fa-times"></i> Something Wrong Please Try Again !</center>
            </div>
               <div class="suf_row clearfix">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="First Name*" required name="trainer_name">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Last Name*" required name="trainer_lname" id="trainer_lname">
                    </div>
               </div>
               <div class="suf_row clearfix">
                    <!-- <div class="suf_col"> -->
                    <div class="form-group">
                        <select required name="trainer_gender" class="form-control ">
                            <option value="">Gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <select required name="trainer_age" class="form-control ">
                            <option value="">Age</option>
                            <?php 
                                for($i=16;$i<=60;$i++) { ?>
                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <!-- </div> -->
                    <!-- <div class="suf_col1"> -->
                        <!-- <div class="form-group">
                            <input type="text" required name="trainer_displayName" class="form-control" placeholder="Display Name*">
                        </div> -->
                    <!-- </div> -->
               </div>
               <div class="suf_row clearfix">
                    <div class="form-group">
                        <input type="text" required name="trainer_displayName" class="form-control" placeholder="Display Name*">
                    </div>
                   <div class="form-group">
                        <input type="email" class="form-control" placeholder="Email*" required name="trainer_email" id="trainer_email">
                        <span id="line2" class="text-left"></span>
                    </div>
               </div>
               <div class="suf_row clearfix">
                    <div class="form-group">
                        <select required id="trainer_country" name="trainer_country" class="form-control ">
                            <option value="">Country</option>
                            <?php 
                            foreach($countries as $c) { ?>
                                <option value="<?php echo $c['id']; ?>"><?php echo $c['name']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <select required id="trainer_state" name="trainer_state" class="form-control ">
                            <option value="">Province</option>
                        </select>
                    </div>
               </div>
               <div class="suf_row clearfix">
                     <div class="form-group">
                        <!-- <input required name="trainer_city" type="text" class="form-control" placeholder="City"> -->
                        <select required id="trainer_city" name="trainer_city" class="form-control ">
                            <option value="">City</option>
                        </select>
                    </div>
                     <div class="form-group">
                        <input required name="trainer_zip" type="text" class="form-control" placeholder="Postal Code">
                    </div>
               </div>
               <div class="suf_row clearfix">
                    <div class="form-group">
                        <input required name="trainer_password"  type="password" id="trainer_password" class="form-control" placeholder="Password*">
                    </div>
                    <div class="form-group">
                        <input required name="trainer_cnfmpassword" id="trainer_confirm_password" type="password" class="form-control" placeholder="Confirm Password*">
                        <span id="line6" class="text-left"></span>
                    </div>
               </div>

               <div class="suf_row clearfix">
                    <div class="suf_col2">
                        <input type="button" id="trainer" class="lsmb_btn gray_grad" value="Sign in" title="Click Here to Sign in">
                    </div>
               </div>
            </form>
      </div>
    </div>
  </div>
</div> 
<!--Signup Modal for for trainer end-->     




<!-- Trainer Registration Script Start -->
<script type="text/javascript">
$(document).ready(function(){
   $("#trainer").click(function() {
    $('#trainer_form input[type=text], #trainer_form select, #trainer_form input[type=email], #trainer_form input[type=password]').each(function() {
        var val = $(this).val();
        if(val == "")
            {
               $(this).addClass('required-error');
            }
        if(val != "")
            {
               $(this).removeClass('required-error');
            }
        });

    var email = $('#trainer_email').val();
    var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if(!filter.test(email))
            {
                $('#line2').html("Please Enter Valid Email Address !");
                $('#line2').css('color', 'red');
                return false;
            }
        if(filter.test(email))
            {
                $('#line2').html("");
            }
        var pswd = $('#trainer_password').val();
        var cnfm_pswd = $('#trainer_confirm_password').val();
        if(pswd != cnfm_pswd)
            {
                $('#line6').html("Please Enter Same Password");
                $('#line6').css('color', 'red');
                return false;
            }
        if(pswd == cnfm_pswd)
            {
                $('#line6').html("");
            }


        if(!$('#trainer_form input[type=text],#trainer_form select,#trainer_form input[type=email], #trainer_form input[type=password]').hasClass("required-error"))
        {
            $('img#loading-img').show();
            var form_data = $('#trainer_form').serialize();
            $.ajax({
                type: "POST",
                url: "<?php echo $this->request->webroot; ?>trainers/addTrainer",
                data: form_data,
                dataType : "json",
                success: function(data)
                {
                    if(data.message != '')
                        {
                            $('img#loading-img').hide();
                            $('#trainer_form')[0].reset();
                            $('#error_msg').hide();
                            $('div#success_msg11').show();
                            setTimeout(function(){ 
                              $('#signup_Modal_trainer').modal('hide');
                              $('#LoginModal').modal('show');
                             }, 1000);
                        }
                  
                },
                error:function(response)
                    {
                        $('img#loading-img').hide();
                        $('#error_msg').show();
                        $('div#success_msg11').hide();
                    }

              });
        }
});
});
</script>

<!-- Trainer Registration Script end -->

<!-- Trainee Registration Script Start -->
<script type="text/javascript">
$(document).ready(function(){
   $('#loading-img').hide();
   $("#trainee").click(function() {
   $('#success_msg1').hide();
   $('#trainee_form input[type=text], #trainee_form select, #trainee_form input[type=email], #trainee_form input[type=password]').each(function() {
        var val = $(this).val();
        if(val == "")
            {
               $(this).addClass('required-error');
            }
        if(val != "")
            {
               $(this).removeClass('required-error');
            }

    });
    var email = $('#trainee_email').val();
    var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if(!filter.test(email))
            {
                $('#line3').html("Please Enter Valid Email Address !");
                $('#line3').css('color', 'red');
                return false;
            }
        if(filter.test(email))
            {
                $('#line3').html("");
            }
    var pswd = $('#trainee_password').val();
    var cnfm_pswd = $('#trainee_cnfm_password').val();
        if(pswd != cnfm_pswd)
            {
                $('#line5').html("Please Enter Same Password");
                $('#line5').css('color', 'red');
                return false;
            }
        if(pswd == cnfm_pswd)
            {
                $('#line5').html("");
            }

   if(!$('#trainee_form input[type=text],#trainee_form select,#trainee_form input[type=email], #trainee_form input[type=password]').hasClass("required-error"))
        {
   $('img#loading-img').show();
   var form_data = $('#trainee_form').serialize();
        $.ajax({
            type: "POST",
            url: "<?php echo $this->request->webroot; ?>trainees/addTrainee",
            data: form_data,
            dataType : "json",
            success: function(data)
            {
                if(data.message != '')
                    {
                        $('img#loading-img').hide();
                        $('#trainee_form')[0].reset();
                        $('#error_msg1').hide();
                        $('#success_msg1').show();
                        setTimeout(function(){ 
                              $('#signup_Modal_trainee').modal('hide');
                              $('#LoginModal').modal('show');
                             }, 1000);
                    }
            },
            error:function(response)
                {
                    $('img#loading-img').hide();
                    $('#error_msg1').show();
                }
          });
    }
});
});
</script>

<!-- Trainee Registration Script end -->

<!-- Login Script On Click Start -->
<script type="text/javascript">
  $(document).ready(function(){
    $("body").on('click','#login-btn',function(){
        var email = $('#email').val();
        var password = $('#password').val();
        $('img#loading-img').show();

        $.ajax({
            type: "POST",
            url: "<?php echo $this->request->webroot; ?>users/login",
            data:{username : email, password : password},
            dataType : "json",
            success: function(data)
            {
                $('img#loading-img').hide();
                if(data.message == 'failed')
                    {
                        $('#error_msg_login').hide();
                        $('#invalid_msg').show();
                        $('#inactive_msg').hide();
                    }
                if(data.message == 'inactive')
                    {
                        $('#error_msg_login').hide();
                        $('#invalid_msg').hide();
                        $('#inactive_msg').show();
                    }
                if(data.message == 'trainee' && data.message1 == 'success')
                    {
                        $('#error_msg_login').hide();
                        $('#invalid_msg').hide();
                        $('#inactive_msg').hide();
                        $("div#success_msg").html("<center><i class='fa fa-check'> Login Successfully Please Wait..  </i></center>").show();
                        window.location.href="<?php echo $this->request->webroot; ?>trainees";
                    }
                if(data.message == 'trainer' && data.message1 == 'success')
                    {
                        $('#error_msg_login').hide();
                        $('#invalid_msg').hide();
                        $('#inactive_msg').hide();
                        $("div#success_msg").html("<center><i class='fa fa-check'> Login Successfully Please Wait..  </i></center>").show();
                        window.location.href="<?php echo $this->request->webroot; ?>trainers";
                    }
            },
            error:function(response)
                {
                    $('img#loading-img').hide();
                    $('#error_msg_login').show();
                    $('#inactive_msg').hide();
                }
          });
    });
  });
</script>

<!-- Login Script On Click  End -->

<!-- Login Script On Enter Start -->
<script type="text/javascript">
  $(document).ready(function(){
    $("#password, #email").on('keyup',function(e){ 
        if(e.which == 13)
        {
        var email = $('#email').val();
        var password = $('#password').val();
        $('img#loading-img').show();

        $.ajax({
            type: "POST",
            url: "<?php echo $this->request->webroot; ?>users/login",
            data:{username : email, password : password},
            dataType : "json",
            success: function(data)
            {
                $('img#loading-img').hide();
                if(data.message == 'failed')
                    {
                        $('#error_msg_login').hide();
                        $('#invalid_msg').show();
                        $('#inactive_msg').hide();
                    }
                if(data.message == 'inactive')
                    {
                        $('#error_msg_login').hide();
                        $('#invalid_msg').hide();
                        $('#inactive_msg').show();
                    }
                if(data.message == 'trainee' && data.message1 == 'success')
                    {
                        $('#error_msg_login').hide();
                        $('#invalid_msg').hide();
                        $('#inactive_msg').hide();
                        $("div#success_msg").html("<center><i class='fa fa-check'> Login Successfully Please Wait..  </i></center>").show();
                        window.location.href="<?php echo $this->request->webroot; ?>trainees";
                    }
                if(data.message == 'trainer' && data.message1 == 'success')
                    {
                        $('#error_msg_login').hide();
                        $('#invalid_msg').hide();
                        $('#inactive_msg').hide();
                        $("div#success_msg").html("<center><i class='fa fa-check'> Login Successfully Please Wait..  </i></center>").show();
                        window.location.href="<?php echo $this->request->webroot; ?>trainers";
                    }
            },
            error:function(response)
                {
                    $('img#loading-img').hide();
                    $('#error_msg_login').show();
                    $('#inactive_msg').hide();
                }
          });
        }
    });
  });
</script>
<!-- Login Script On Enter End -->

<script type="text/javascript">
$(document).ready(function(){
    $('input[type=text], select, input[type=email], input[type=password]').on("keyup change", function(){
        var val = $(this).val();
        if(val != "")
            {
               $(this).removeClass('required-error');
            }
    });
    });
</script>

<!-- Trainer Email Already Exists Start -->
<script type="text/javascript">
    $(document).ready(function(){
        $('#trainer_email').keyup(function(){
        var email = $('#trainer_email').val();
        var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if(email == "" ||  !filter.test(email))
            {
                $('#line2').html("");
                $('#trainer').attr('disabled', false);
                return false;
            }

        $.ajax({
                url:"<?php echo $this->request->webroot; ?>users/checkEmail",
                type:"post",
                data:{email : email},   
                dataType : "json",                 
                success: function(data){
                    if(data.message == "")
                        {
                            $('#line2').html(" Email Available ");
                            $('#line2').css('color', 'green');
                            $('#trainer').attr('disabled', false);
                        }
                    else
                        {
                            $('#line2').html("Email Already Exists !");
                            $('#line2').css('color', 'red');
                            $('#trainer').attr('disabled', true);
                        }
            }
            });
        });
    });

</script>
<!-- Trainer Email Already Exists End -->

<!-- Trainee Email Already Exists Start -->
<script type="text/javascript">
    $(document).ready(function(){
        $('#trainee_email').keyup(function(){
        var email = $('#trainee_email').val();
        var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if(email == "" ||  !filter.test(email))
            {
                $('#line3').html("");
                $('#trainee').attr('disabled', false);
                return false;
            }

        $.ajax({
                url:"<?php echo $this->request->webroot; ?>users/checkEmail",
                type:"post",
                data:{email : email},   
                dataType : "json",                 
                success: function(data){
                    if(data.message == "")
                        {
                            $('#line3').html(" Email Available ");
                            $('#line3').css('color', 'green');
                            $('#trainee').attr('disabled', false);
                        }
                    else
                        {
                            $('#line3').html("Email Already Exists !");
                            $('#line3').css('color', 'red');
                            $('#trainee').attr('disabled', true);
                        }
            }
            });
        });
    });

</script>
<!-- Trainee Email Already Exists End -->

<!-- Contact Us Map Start -->

<script type="text/javascript">
 
  function initialize() {
  var myLatlng = new google.maps.LatLng(50.447978,-104.6066559);
  var mapOptions = {
    zoom: 16,
    center: myLatlng
  }
  var map = new google.maps.Map(document.getElementById('map_display'), mapOptions);

  var marker = new google.maps.Marker({
      position: myLatlng,
      map: map,
      icon : "<?php echo $this->request->webroot; ?>img/favicon.ico",
      title: 'Virtual TrainR'
  });
}
 google.maps.event.addDomListener(window, 'load', initialize);
</script>

<!-- Contact Us Map End -->

<!-- State Populate Start -->
<script type="text/javascript">
$(document).ready(function(){
$('#trainee_country, #trainer_country').change(function(){
    var state = $(this).val();
    $.ajax({
            url:"<?php echo $this->request->webroot; ?>users/getStates",
            type:"post",
            data:{state : state},   
            dataType : "json",  
            beforeSend: function() {
                $('.loading').show();
                $('.loading_icon').show();
             },                
            success: function(data){
                $('.loading').hide();
                $('.loading_icon').hide();
                if(data.message != ""){
                var states = data.message;
                var i;
                var option;
                option += '<option value="">Province</option>';
                for(i = 0; i < states.length; i++)
                 {
                    option += '<option value="'+states[i]["id"]+'">' + states[i]["name"] + '</option>';
                 }
                 $('#trainee_state, #trainer_state').html(option);
                }
            }
        });
});
});
</script>
<!-- State Populate End -->

<!-- City Populate Start -->
<script type="text/javascript">
$(document).ready(function(){
$('#trainee_state, #trainer_state').change(function(){
    var city = $(this).val();
    $.ajax({
            url:"<?php echo $this->request->webroot; ?>users/getCities",
            type:"post",
            data:{city : city},   
            dataType : "json",  
            beforeSend: function() {
                $('.loading').show();
                $('.loading_icon').show();
             },                
            success: function(data){
                $('.loading').hide();
                $('.loading_icon').hide();
                if(data.message != ""){
                var cities = data.message;
                var i;
                var option;
                option += '<option value="">City</option>';
                for(i = 0; i < cities.length; i++)
                 {
                    option += '<option value="'+cities[i]["id"]+'">' + cities[i]["name"] + '</option>';
                 }
                 $('#trainee_city, #trainer_city').html(option);
                }
            }
        });
});
});
</script>
<!-- City Populate End -->

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

<!-- Forgot Password Start -->
<script type="text/javascript">
    $(document).ready(function(){
    $('#forgot-btn').click(function(){
        var email = $('#forgot-email').val();
        var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if(email == "" || !filter.test(email))
        {
            $("div#error_msg").html("<center><i class='fa fa-times'> Please Enter Valid Email Address ! </i></center>").show();
            $("div#success_msg").hide();
            return false;
        }
        $('img#loading-img').show();

        $.ajax({
                url:"<?php echo $this->request->webroot; ?>users/forgotPassword",
                type:"post",
                data:{email : email},   
                dataType : "json",                 
                success: function(data){
                     $('img#loading-img').hide();
                    if(data.message == "success")
                    {
                        $('#forgot-email').val("");
                        $("div#success_msg").html("<center><i class='fa fa-check'> Success, Please Check Your Email  </i></center>");
                        $("div#success_msg").show();
                        $("div#error_msg").hide();
                        setTimeout(function(){ 
                              $('#ForgotPasswordModal').modal('hide');
                             }, 1000);
                    }
                    if(data.message == "failed")
                    {
                        $("div#error_msg").html("<center><i class='fa fa-times'>  Email Address Doesn`t Exists !</i></center>");
                        $("div#error_msg").show();
                        $("div#success_msg").hide();
                    }
            }
            });
    });
    });
</script>
<!-- Forgot Password End -->

<!-- Load Facebook SDK Start -->
<script type="text/javascript">
     (function(d){  // load SDK
     var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement('script'); js.id = id; js.async = true;
     js.src = "//connect.facebook.net/en_US/all.js";
     ref.parentNode.insertBefore(js, ref);
   }(document));
</script>
<!-- Load Facebook SDK End -->

<!-- Facebook Signup Start -->
<script type="text/javascript"> // Load the SDK asynchronously

    window.fbAsyncInit = function() {
    FB.init({
      appId      : '717505658366417', // Set YOUR APP ID
      status     : true, // check login status
      cookie     : true, // enable cookies to allow the server to access the session
      xfbml      : true  // parse XFBML
    });
    };

function fbSignup(type)
    {
        FB.login(function(response,navigator) {
          console.log(navigator);
           if (response.authResponse) 
           {
                $("div#error_msg").hide();
                getUserInfo(type);
            } else 
            {
                $("div#error_msg").html("<center><i class='fa fa-times'> User Cancelled Login Or Did Not Fully Authorize ! </i></center>").show();
                $("div#success_msg").hide();
            }
         },{scope: 'email,user_photos,user_videos'});
    }

function getUserInfo(type) {

        if(type == "login")
            {
                var myURL = "<?php echo $this->request->webroot; ?>trainees/fbLoginTrainee";
            }
        if(type == "signup")
            {
             var myURL = "<?php echo $this->request->webroot; ?>trainees/fbSignupTrainee";   
            }

        FB.api('/me', function(response) {
        $('img#loading-img').show();
        $.ajax({
            url:myURL,
            type:"post",
            data:{response : response},   
            dataType : "json",                 
            success: function(data){
                $('img#loading-img').hide();
                switch (data.message) {
                    case "Profile inactive":
                        $("div#error_msg").html("<center><i class='fa fa-times'> Currently Your Profile is inactive ! </i></center>").show();
                        $("div#success_msg").hide();
                        break;
                    case "Already Registered" :
                        $("div#error_msg").html("<center><i class='fa fa-times'> User Already Registered ! </i></center>").show();
                        $("div#success_msg").hide();
                        break;
                    case "Email Already Exists" :
                        $("div#error_msg").html("<center><i class='fa fa-times'> Email Id Already Exists ! </i></center>").show();
                        $("div#success_msg").hide();
                        break;
                    case "Success" :
                        $("div#success_msg").html("<center><i class='fa fa-check'> Trainee Created Successfully  </i></center>").show();
                        $("div#error_msg").hide();
                        setTimeout(function(){ 
                              $('#signup_Modal_trainee').modal('hide');
                              $('#LoginModal').modal('show');
                             }, 1000);
                        break;
                    case "User Not Exists" :
                        $("div#error_msg").html("<center><i class='fa fa-times'> User Not Exists ! </i></center>").show();
                        $("div#success_msg").hide();
                        break;
                    case "Login Successfully" :
                        $("div#success_msg").html("<center><i class='fa fa-check'> Login Successfully Please Wait..  </i></center>").show();
                        $("div#error_msg").hide();
                        window.location.href = "<?php echo $this->request->webroot; ?>trainees";
                        break;
                    default :
                        $("div#error_msg").html("<center><i class='fa fa-times'> Something is Wrong Please Try Again ! </i></center>").show();
                        $("div#success_msg").hide();
                }
                FB.logout(function(){ console.log('logout'); });
            }
            });
    });
    }
    
</script>
<!-- Facebook Signup End -->

<!-- Load Google Api Start -->
<script type="text/javascript">
  var auth2 = auth2 || {};
  (function() {
    var po = document.createElement('script');
    po.type = 'text/javascript'; po.async = true;
    po.src = 'https://plus.google.com/js/client:plusone.js?onload=startApp';
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(po, s);
  })();
  </script>
<!-- Load Google Api End -->

<!-- Google Signup Start -->
<script type="text/javascript">
var helper = (function() {
  var authResult = undefined;

  return {
    onSignInCallback: function(authResult) {
      if (authResult['access_token']) {
        this.authResult = authResult;
        gapi.client.load('plus','v1',this.renderProfile);
      } else if (authResult['error']) {
        console.log('There was an error: ' + authResult['error']);
        $('#authResult').append('Logged out');
        $('#authOps').hide('slow');
        $('#gConnect').show();
      }
    },
   
    renderProfile: function() {
      var social_type = sessionStorage.getItem("social_type");
      if(social_type == "signup")
          {
            var myNewUrl = "<?php echo $this->request->webroot; ?>trainees/googleSignupTrainee";
          }
      if(social_type == "login")
          {
            var myNewUrl = "<?php echo $this->request->webroot; ?>trainees/googleLoginTrainee";
          }
          
      var request = gapi.client.plus.people.get( {'userId' : 'me'} );
      request.execute(function(profile) {
        $('img#loading-img').show();
        $.ajax({
            url:myNewUrl,
            type:"post",
            data:{profile : profile},   
            dataType : "json",                 
            success: function(data){
                $('img#loading-img').hide();
                switch (data.message) {
                    case "Profile inactive":
                        $("div#error_msg").html("<center><i class='fa fa-times'> Currently Your Profile is inactive ! </i></center>").show();
                        $("div#success_msg").hide();
                        break;
                    case "Already Registered" :
                        $("div#error_msg").html("<center><i class='fa fa-times'> User Already Registered ! </i></center>").show();
                        $("div#success_msg").hide();
                        break;
                    case "Email Already Exists" :
                        $("div#error_msg").html("<center><i class='fa fa-times'> Email Id Already Exists ! </i></center>").show();
                        $("div#success_msg").hide();
                        break;
                    case "Success" :
                        $("div#success_msg").html("<center><i class='fa fa-check'> Trainee Created Successfully  </i></center>").show();
                        $("div#error_msg").hide();
                        setTimeout(function(){ 
                              $('#signup_Modal_trainee').modal('hide');
                              $('#LoginModal').modal('show');
                             }, 1000);
                        break;
                    case "User Not Exists" :
                        $("div#error_msg").html("<center><i class='fa fa-times'> User Not Exists ! </i></center>").show();
                        $("div#success_msg").hide();
                        break;
                    case "Login Successfully" :
                        $("div#success_msg").html("<center><i class='fa fa-check'> Login Successfully Please Wait..  </i></center>").show();
                        $("div#error_msg").hide();
                        window.location.href = "<?php echo $this->request->webroot; ?>trainees";
                        break;
                    default :
                        $("div#error_msg").html("<center><i class='fa fa-times'> Something is Wrong Please Try Again ! </i></center>").show();
                        $("div#success_msg").hide();
                }
            }
            });
        });
    },

    connectServer: function(code) {
      $.ajax({
        type: 'POST',
        url: window.location.href + 'users/blank?code='+code,
        contentType: 'application/octet-stream; charset=utf-8',
        success: function(result) {
          console.log(result);
          helper.people();
          onSignInCallback(auth2.currentUser.get().getAuthResponse());
        },
        processData: false,
        data: code
      });
    },
    
    people: function(success, failure) {
      success = success || function(result) { helper.appendCircled(result); };
      $.ajax({
        type: 'GET',
        url: window.location.href + 'users/blank',
        contentType: 'application/octet-stream; charset=utf-8',
        success: success,
        error: failure,
        processData: false
      });
    },
   
    appendCircled: function(people) {
      $('#visiblePeople').empty();

      $('#visiblePeople').append('Number of people visible to this app: ' +
          people.totalItems + '<br/>');
      for (var personIndex in people.items) {
        person = people.items[personIndex];
        $('#visiblePeople').append('<img src="' + person.image.url + '">');
      }
    },
  };
})();

$(document).ready(function() {
  $('#disconnect').click(helper.disconnectServer);
  if ($('[data-clientid="567328744788-3l77b4juu25r5elqk41l8cc00r8o6jjr.apps.googleusercontent.com"]').length > 0) {
    alert('This sample requires your OAuth credentials (client ID) ' +
        'from the Google APIs console:\n' +
        '    https://code.google.com/apis/console/#:access\n\n' +
        'Find and replace YOUR_CLIENT_ID with your client ID and ' +
        'YOUR_CLIENT_SECRET with your client secret in the project sources.'
    );
  }
});

function startApp() {
  gapi.load('auth2', function(){

    gapi.auth2.init({
        client_id: '567328744788-3l77b4juu25r5elqk41l8cc00r8o6jjr.apps.googleusercontent.com',
        cookiepolicy: 'single_host_origin',
        fetch_basic_profile: false,
        scope: 'https://www.googleapis.com/auth/userinfo.email'
      }).then(function (){
            auth2 = gapi.auth2.getAuthInstance();
            auth2.then(function() {
                var isAuthedCallback = function () {
                  onSignInCallback(auth2.currentUser.get().getAuthResponse())
                }
                // helper.people(isAuthedCallback);
              });
          });
  });
}

function googleSignup(type) {
 sessionStorage.setItem("social_type", type);
  var signIn = function(result) {
      auth2.signIn().then(
        function(googleUser) {
          onSignInCallback(googleUser.getAuthResponse());
        }, function(error) {
          alert(JSON.stringify(error, undefined, 2));
        });
    };

  var reauthorize = function() {
      auth2.grantOfflineAccess().then(
        function(result){
          helper.connectServer(result.code);
        });
    };

  helper.people(signIn, reauthorize);
}

function onSignInCallback(authResult) {
  helper.onSignInCallback(authResult);
}
</script>
<!-- Google Signup End -->



