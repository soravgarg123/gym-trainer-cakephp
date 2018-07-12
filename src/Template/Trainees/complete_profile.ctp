<?php include "trainee_common_header.php"; ?>
		 
     <section class="trainee_dash_body parallax-window" >
     	<div class="container trainee_profile_wrap">
        	
        	<div class="row">
            	<div class="col-sm-3">
                	
                    <div class="trainee_tabs_sect">
                    	  <h3>Complete Profile</h3>
                    	  <!-- Nav tabs -->
                          <ul class="nav_tabs">
                            <li class="active informaiton"><a href="#informaiton" aria-controls="informaiton" role="tab" data-toggle="tab">Personal Informaiton </a></li>
                            <li class="social_links"><a href="#social_links" aria-controls="social_links" role="tab" data-toggle="tab">Social Links </a></li>
                            <li class="password"><a href="#password" aria-controls="password" role="tab" data-toggle="tab">Change Password </a></li>
                            <li class="aboutme"><a href="#aboutme" aria-controls="aboutme" role="tab" data-toggle="tab">About Me </a></li>
                          </ul>
                    </div>
                    
                </div>
                <div class="col-sm-9">
                <div class="img-profile">
                 <?php echo $this->Custom->successMsg(); ?>
                 <?php echo $this->Custom->errorMsg(); ?>
                 <?php echo $this->Custom->loadingImg(); ?>
                </div>
                	<div class="trainee_tab_content">
                    	  <!-- Tab panes -->
                          <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active informaiton" id="informaiton">
                            	<h3 class="trai_title_sect">Personal Informaiton</h3>
                                <?php echo $this->Flash->render('edit1') ?>
                                <form method="post" action="<?php echo $this->request->webroot; ?>trainees/updatePersonalInfo/informaiton">
                                <div class="form_wrapper">
                                
                                    <div class="form-group">
                                        <label>Full Name</label>
                                        <input required name="trainee_name" type="text" value="<?php echo $profile_details[0]['trainee_name']; ?>" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" value="<?php echo $profile_details[0]['trainee_email']; ?>" readonly class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Display Name</label>
                                        <input required name="trainee_displayName" type="text" value="<?php echo $profile_details[0]['trainee_displayName']; ?>" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Country</label>
                                        <select required id="trainee_country" name="trainee_country" class="form-control ">
                                            <option value="">Country</option>
                                            <?php 
                                            foreach($countries as $c) { ?>
                                                <option value="<?php echo $c['id']; ?>" <?php if(isset($profile_details[0]['trainee_country']) && $profile_details[0]['trainee_country'] == $c['id'])  echo "selected='selected'"; ?>><?php echo $c['name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Province</label>
                                        <select required id="trainee_state"  name="trainee_state" class="form-control ">
                                            <option value="">Select Province</option>
                                            <?php 
                                            foreach($states as $c) { ?>
                                                <option value="<?php echo $c['id']; ?>" <?php if(isset($profile_details[0]['trainee_state']) && $profile_details[0]['trainee_state'] == $c['id'])  echo "selected='selected'"; ?>><?php echo $c['name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>City</label>
                                        <select required id="trainee_city" name="trainee_city" class="form-control ">
                                            <option value="">City</option>
                                            <?php 
                                            foreach($cities as $c) { ?>
                                                <option value="<?php echo $c['id']; ?>" <?php if(isset($profile_details[0]['trainee_city']) && $profile_details[0]['trainee_city'] == $c['id'])  echo "selected='selected'"; ?>><?php echo $c['name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Current Weight (in lbs)</label>
                                        <input name="trainee_current_weight" type="text" value="<?php echo $profile_details[0]['trainee_current_weight']; ?>" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Goal (in lbs)</label>
                                        <input name="trainee_goal" type="text" value="<?php echo $profile_details[0]['trainee_goal']; ?>" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>School</label>
                                        <input name="school" type="text" value="<?php echo $profile_details[0]['school']; ?>" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Work</label>
                                        <input name="work" type="text" value="<?php echo $profile_details[0]['work']; ?>" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Postal Code</label>
                                        <input required name="trainee_zip" type="text" value="<?php echo $profile_details[0]['trainee_zip']; ?>" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Trainee Skills (Please hit enter to add skills)</label>
                                        <input name="trainee_skills" id="trainee_skills" type="text" value="<?php echo $profile_details[0]['trainee_skills']; ?>" class="form-control">
                                    </div>
                                   
                                </div>
                                <input type="hidden" id="trn_cont" name="trn_cont" value="<?php if(isset($cont_name[0]["name"])) echo $cont_name[0]["name"]; ?>">
                                <input type="hidden" id="trn_state" name="trn_state" value="<?php if(isset($state_name[0]["name"])) echo $state_name[0]["name"]; ?>">
                                <input type="hidden" id="trn_city" name="trn_city" value="<?php if(isset($city_name[0]["name"])) echo $city_name[0]["name"]; ?>">
                                <input type="submit" class="btn submit_btn"  value="Update" />
                                </form>
                            </div>
                            <div role="tabpanel" class="tab-pane social_links" id="social_links">
                                <h3 class="trai_title_sect">Social Links</h3>
                                <?php echo $this->Flash->render('edit2') ?>
                                <?=  $this->Flash->render('edit') ?>
                                <form method="post" action="<?php echo $this->request->webroot; ?>trainees/updatePersonalInfo/social_links">
                                <div class="form_wrapper">
                                <div class="form-group">
                                        <label>Facebook URL</label>
                                        <input name="trainee_facebook" type="url" value="<?php echo $profile_details[0]['trainee_facebook']; ?>" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Linked In URL</label>
                                        <input type="url" value="<?php echo $profile_details[0]['trainee_linkedin']; ?>" name="trainee_linkedin"  class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>BelibiTv URL</label>
                                        <input  name="trainee_belibitv" type="url" value="<?php echo $profile_details[0]['trainee_belibitv']; ?>" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Twitter URL</label>
                                        <input  name="trainee_twitter" type="url" value="<?php echo $profile_details[0]['trainee_twitter']; ?>" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Google URL</label>
                                        <input  name="trainee_google" type="url" value="<?php echo $profile_details[0]['trainee_google']; ?>" class="form-control">
                                    </div>
                                     <div class="form-group">
                                        <label>Instagram URL</label>
                                        <input  name="trainee_instagram" type="url" value="<?php echo $profile_details[0]['trainee_instagram']; ?>" class="form-control">
                                    </div>
                                </div>
                                <input type="submit" class="btn submit_btn"  value="Update" />
                                </form>
                            </div>

                            <div role="tabpanel" class="tab-pane password" id="password">
                            	<h3 class="trai_title_sect">Change Password </h3>

                                <?php echo $this->Custom->successMsg(); ?>
                                <?php echo $this->Custom->errorMsg(); ?>
                                <?php echo $this->Custom->loadingImg(); ?>
                                

                                <div class="form_wrapper">
                                    <div class="form-group">
                                        <label>Current Password </label>
                                        <input type="password" name="trainee_password" id="current_pswd" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>New Password </label>
                                        <input type="password" name="trainee_password" id="new_pswd" class="form-control">
                                    </div>
                                    <input type="hidden" value="<?php echo $profile_details[0]['trainee_password']; ?>" id="old_pswd">
                                    <div class="form-group">
                                        <label>Confirm Password </label>
                                        <input type="password" name="trainee_password" id="cnfm_pswd" class="form-control">
                                    </div>
                                </div>
                                <input type="button" class="btn submit_btn" id="change_pswd" value="Update" />
                            </div>
                            <div role="tabpanel" class="tab-pane aboutme" id="aboutme">
                                <h3 class="trai_title_sect">About Me </h3>
                                <?php echo $this->Flash->render('edit3') ?>
                                <form method="post" action="<?php echo $this->request->webroot; ?>trainees/updateAboutMe">
                                <div class="form_wrapper">
                                    <div class="form-group">
                                        <label>About Me </label>
                                        <textarea required class="form-control" rows="15" name="trainee_aboutme"><?php echo $profile_details[0]['trainee_aboutme']; ?></textarea>
                                    </div>
                                </div>
                                <input type="submit" class="btn submit_btn" id="change_pswd" value="Update" />
                                </form>
                            </div>
                          </div>
                          
                          <div class="clearfix"></div>

                    	  <!-- <a class="btn submit_btn" href="#">Update</a> -->
                    </div>
                    
                </div>
            </div>
            
            
        </div>
     </section>   
     <!-- Modal -->
    <div class="modal fade" id="imagecrop" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Crop Image</h4>
          </div>
          <div class="modal-body">
            <div class="imageBox" >
                <div class="mask"></div>
                <div class="thumbBox"></div>
                <div class="spinner" style="display: none">Loading...</div>
              </div>
              <div class="tools">
                <span id="rotateLeft" >rotateLeft</span>
                <span id="rotateRight" >rotateRight</span>
                <span id="zoomIn" >zoomIn</span>
                <span id="zoomOut" >zoomOut</span>
                <span id="crop" >Crop</span>
                <span id="alertInfo" >alert</span>
                <div class="upload-wapper">
                           Select An Image
                    <input type="file" id="trainee_profile_img1" value="Upload" />
                </div>
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal" id="skip-btn">Skip</button>
            <button type="button" class="btn btn-primary" id="crop-btn">Crop & Save</button>
          </div>
        </div>
      </div>
    </div>
        
    </div>
    <!--Main container sec end-->
  </main>
<!-- Delete Profile Start --> 

  <script type="text/javascript">
 $(document).ready(function(){     
     $("body").on('click','#delete_profile_img',function(){
      if (confirm("Are You Sure?")) {
        $.ajax({
                url:"<?php echo $this->request->webroot; ?>trainees/deleteProfile",
                type:"post",
                data:{id:""},
                dataType:"json",
                success: function(data){
                    window.location.reload();
                }
            });
         }
          else{
            return false;
          }
        });
    });
</script>

<!-- Delete Profile End --> 

  <!-- Change Password Start -->
  
  <script type="text/javascript">
  $(document).ready(function(){
    $('#change_pswd').click(function(){
        var current_pswd = $('#current_pswd').val();
        var new_pswd = $('#new_pswd').val();
        var cnfm_pswd = $('#cnfm_pswd').val();
        var old_pswd = $('#old_pswd').val();
        if(current_pswd == "" || new_pswd =="" || cnfm_pswd == "")
        {
            $("div#password div#error_msg").html("<center><i class='fa fa-times'> Please Fill All Fields First ! </i></center>").show().fadeOut(3000);
            $("div#password div#success_msg").hide();
            return false;
        }
        if(current_pswd != old_pswd)
        {
            $("div#password div#error_msg").html("<center><i class='fa fa-times'> Wrong Current Password ! </i></center>").show().fadeOut(3000);
            $("div#password div#success_msg").hide();
            return false;
        }
        if(new_pswd != cnfm_pswd)
        {
            $("div#password div#error_msg").html("<center><i class='fa fa-times'> Password Not Matched ! </i></center>").show().fadeOut(3000);
            $("div#password div#success_msg").hide();
            return false;
        }
        if(old_pswd == new_pswd)
        {
            $("div#password div#error_msg").html("<center><i class='fa fa-times'>  You Didn`t Have Any Changes !</i></center>").show().fadeOut(3000);
            $("div#password div#success_msg").hide();
            return false;
        }
        $('div#password img#loading-img').show();
        $.ajax({
                url:"<?php echo $this->request->webroot; ?>trainees/changePassword",
                type:"post",
                data:{new_pswd : new_pswd},   
                dataType : "json",                 
                success: function(data){
                     $('div#password img#loading-img').hide();
                    if(data.message == "success")
                    {
                        $('#old_pswd').val(new_pswd);
                        $('input[type="password"]').val("");
                        $("div#password div#success_msg").html("<center><i class='fa fa-check'> Password Successfully Changed </i></center>").show().fadeOut(3000);
                        $("div#password div#error_msg").hide();
                    }
                    else
                    {
                        $("div#password div#error_msg").html("<center><i class='fa fa-times'>  Something is Wrong Please Try Again !</i></center>").show().fadeOut(3000);
                        $("div#password div#success_msg").hide();
                    }
                    
            }
            });

    });
  });
  </script>

  <!-- Change Password End -->

  <!-- Profile Image Uploading Start -->

        <script type="text/javascript">
        $(document).ready(function(){
        $('#trainee_profile_img').change(function(){
            var file_name = $(this).val();
            var fileObj = this.files[0]; // get file object
            var calculatedSize = fileObj.size/(1024*1024); // in MB
            var split_extension = file_name.split(".").pop();
            var ext = [ "jpg", "gif" ];
            if(jQuery.inArray(split_extension.toLowerCase(), ext ) == -1)
            {
                $('#trainee_profile_img').val(fileObj.value = null);
                $("div.img-profile div#error_msg").html("<center><i class='fa fa-times'> You Can Upload Only .jpg, gif files ! </i></center>").show().fadeOut(3000);
                $("div.img-profile div#success_msg").hide();
                return false;
            }
            if(calculatedSize > 10)
            {
                $('#trainee_profile_img').val(fileObj.value = null);
                $("div.img-profile div#error_msg").html("<center><i class='fa fa-times'>  File size should be less than 10 MB ! </i></center>").show().fadeOut(3000);
                return false;
            }
            if(jQuery.inArray(split_extension.toLowerCase(), ext ) != -1 && calculatedSize < 10)
            {
                    $("div.img-profile div#error_msg").hide();
                    $('div.img-profile img#loading-img').show();
                    var data = new FormData($('#profile_form')[0]);
                    $.ajax({
                        type: "post",
                        url: "<?php echo $this->request->webroot; ?>trainees/updateProfileImage",
                        data: data,
                        dataType : "json",
                        contentType: false,
                        processData: false,
                        success: function(data){
                           if(data.message != "")
                               {
                                $('img#profile-img').attr('src','<?php echo $this->request->webroot; ?>uploads/trainee_profile/' + data.message);
                                $("div.img-profile div#success_msg").html("<center><i class='fa fa-check'> Image Uploaded Successfully </i></center>").show().fadeOut(3000);
                                $("div.img-profile div#error_msg").hide();
                               }
                            else
                                {
                                $("div.img-profile div#error_msg").html("<center><i class='fa fa-times'> Something is Wrong Please Try Again ! </i></center>").show().fadeOut(3000);
                                $("div.img-profile div#success_msg").hide();
                                }
                             $('img#loading-img').hide();
                        }
                    });
            }
        });
        });
    </script>

    <!-- Profile Image Uploading End -->

<!-- State Populate Start -->
<script type="text/javascript">
$(document).ready(function(){

$('#trainee_skills').tagit({
    allowSpaces: true
});

$('#trainee_country').change(function(){
    var state = $(this).val();
    var cont = $("option:selected",this).text().trim();
    $("#trn_cont").val(cont);
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
                option += '<option value="">State</option>';
                for(i = 0; i < states.length; i++)
                 {
                    option += '<option value="'+states[i]["id"]+'">' + states[i]["name"] + '</option>';
                 }
                 $('#trainee_state').html(option);
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
$('#trainee_state').change(function(){
    var city = $(this).val();
    var cont = $("option:selected",this).text().trim();
    $("#trn_state").val(cont);
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
                 $('#trainee_city').html(option);
                }
            }
        });
    });
    
    $("body").on("change","#trainee_city",function(){
        var cont = $("option:selected",this).text().trim();
        $("#trn_city").val(cont);
    });
});
</script>
<!-- City Populate End -->

<!-- Manage Tabing Start -->

<script type="text/javascript">
    $(document).ready(function(){
        var pageURL = $(location).attr("href");
        var splitURL = pageURL.split("/"); 
        var result = splitURL[splitURL.length - 1];  

        if(result == "completeProfile" || result == "/")
            {
                $('.'+result).removeClass('active');
                $('.informaiton').addClass('active');
            }
        else
            {
                $('.informaiton').removeClass('active');
                $('.'+result).addClass('active');
            }
    });
</script> 

<!-- Manage Tabing End -->







