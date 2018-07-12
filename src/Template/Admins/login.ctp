    <div class="container">
        <div class="row text-center ">
            <div class="col-md-12">
                <br /><br />
                
            <img alt="logo" src="<?php echo $this->request->webroot;  ?>images/logo.png">
               
                <h5></h5>
                 <br />
            </div>
        </div>
         <div class="row ">

               
                  <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1">
                    <?php echo $this->Custom->successMsg(); ?>
                    <?php echo $this->Custom->errorMsg(); ?>
                    <?php echo $this->Custom->loadingImg(); ?>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                        <strong>   Enter Details To Login </strong>  
                            </div>
                            <div class="panel-body">
                                <form role="form">
                                       
                                     <div class="form-group input-group">
                                            <span class="input-group-addon"><i class="fa fa-tag"  ></i></span>
                                            <input type="text" class="form-control" id="email" placeholder="Username " />
                                        </div>
                                        <div class="form-group input-group">
                                            <span class="input-group-addon"><i class="fa fa-lock"  ></i></span>
                                            <input type="password" class="form-control"  id="password" placeholder="Password" />
                                        </div>
                                        <!-- <div class="form-group">
                                            <label class="checkbox-inline">
                                                <input type="checkbox" /> Remember me
                                            </label>
                                        </div> -->
                                     <center><input id="login-btn" type="button" class="btn login_btn" value="Login Now"></center>
                                
                                    </form>
                            </div>
                           
                        </div>
                    </div>
                
                
        </div>
    </div>
<!-- Login Script On Click Start -->
<script type="text/javascript">
  $(document).ready(function(){
    $("#login-btn").click(function(e){
        var email = $('#email').val();
        var password = $('#password').val();
        $('img#loading-img').show();

        $.ajax({
            type: "POST",
            url: "<?php echo $this->request->webroot; ?>admins/adminLogin",
            data:{username : email, password : password},
            dataType : "json",
            success: function(data)
            {
                $('img#loading-img').hide();
                if(data.message == 'admin')
                {
                  $("#error_msg").hide();
                  $("#success_msg").html("<center><i class='fa fa-check'> Login Successfully Please Wait .. </i></center>").show();
                  window.location.href="<?php echo $this->request->webroot; ?>admins/home";
                }
                else
                {
                  $("#success_msg").hide();
                  $("#error_msg").html("<center><i class='fa fa-times'> Username Or Password is invalid </i></center>").show();
                }
            },
            error:function(response)
                {
                    $('img#loading-img').hide();
                    $("#success_msg").hide();
                    $("#error_msg").html("<center><i class='fa fa-times'> Something is Wrong Please Try Again ! </i></center>").show();
                }
          });
    });
  });
</script>

<!-- Login Script On Click End -->

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
            url: "<?php echo $this->request->webroot; ?>admins/adminLogin",
            data:{username : email, password : password},
            dataType : "json",
            success: function(data)
            {
                $('img#loading-img').hide();
                if(data.message == 'admin')
                {
                  $("#error_msg").hide();
                  $("#success_msg").html("<center><i class='fa fa-check'> Login Successfully Please Wait .. </i></center>").show();
                  window.location.href="<?php echo $this->request->webroot; ?>admins/home";
                }
                else
                {
                  $("#success_msg").hide();
                  $("#error_msg").html("<center><i class='fa fa-times'> Username Or Password is invalid </i></center>").show();
                }
            },
            error:function(response)
                {
                    $('img#loading-img').hide();
                    $("#success_msg").hide();
                    $("#error_msg").html("<center><i class='fa fa-times'> Something is Wrong Please Try Again ! </i></center>").show();
                }
          });
        }
    });
  });
</script>

<!-- Login Script On Enter End -->
