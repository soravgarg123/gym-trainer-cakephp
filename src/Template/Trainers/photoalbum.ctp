<?php include "trainer_dashboard.php"; ?>
     <section class="trainee_dash_body">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="meal_plan_sec">

                      <!-- Tab panes -->
                      <div class="tab-content">
                        
                         <div class="panel_block_heading">
                            <h4>Photo Album</h4>
                        </div>
                        	<div class="dash_photo_gallery">
                            	
                                  <!-- Nav tabs -->
                                  <ul class="photos_tabs" role="tablist">
                                    <li class="active gallery_phots" role="presentation"><a href="#gallery_phots" aria-controls="gallery_phots" role="tab" data-toggle="tab">Gallery Photos</a></li>
                                    <li class="videos" role="presentation"><a href="#videos" aria-controls="videos" role="tab" data-toggle="tab">Videos</a></li>
                                  </ul>
                                  <!-- Tab panes -->
                                  <div class="tab-content photos_tab_content">
                                    <div role="tabpanel" class="tab-pane active gallery_phots" id="gallery_phots">
                                     <?php echo $this->Custom->successMsg(); ?>
                                     <?php echo $this->Custom->errorMsg(); ?>
                                     <?php echo $this->Custom->loadingImg(); ?>

                                    	<div class="photo_gall_content">
                                        	<ul class="photo_gallery_list">
                                            	<li class="photo_upload_sect">
                                                <form id="submit_form1" method="post" enctype="multipart/form-data">
                                                    <input style="cursor:pointer" id="uploadImage1" name="gallery_img" value="Photo Upload" type="file"/>
                                                    <span class="fa fa-cloud-upload"></span>
                                                    <div id="dvPreview"></div>
                                                </form>
                                                    <h5>Upload your Photo</h5>
                                                </li>
                                                <?php
                                                    foreach($gallery_img as $gi)
                                                        { ?>
                                                    <li class="img_<?php echo $gi['piv_id']; ?>">
                                                        <span class="delte_img" main2="<?php echo $gi['piv_name']; ?>" main="<?php echo base64_encode($gi['piv_id']); ?>"><i class="fa fa-close"></i></span>
                                                        <a class="example-image-link" href="<?php echo $this->Custom->getImageSrc('uploads/trainer_gallery/'.$gi['piv_name']) ?>" data-lightbox="example-set" data-title="Click the right half of the image to move forward.">
                                                        <img style="height:170px;" class="example-image img-responsive" src="<?php echo $this->Custom->getImageSrc('uploads/trainer_gallery/'.$gi['piv_name']) ?>" alt=""/></a>
                                                    </li>
                                                <?php } ?>
                                            </ul>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>
                                    <div role="tabpanel" class="tab-pane videos" id="videos">
                                    <?php echo $this->Custom->successMsg(); ?>
                                     <?php echo $this->Custom->errorMsg(); ?>
                                     <?php echo $this->Custom->loadingImg(); ?>
                                    	<div class="photo_gall_content">
                                        	<ul class="photo_video_list">
                                            	<li class="photo_upload_sect">
                                                <form id="submit_form2" method="post" enctype="multipart/form-data">
                                                    <input style="cursor:pointer" id="uploadVideo" name="trainer_videos" value="Video Upload" type="file"/>
                                                    <span class="fa fa-cloud-upload"></span>
                                                </form>
                                                    <h5>Upload Your Video</h5>
                                                </li>
                                                <?php  
                                                    foreach($gallery_videos as $gv)
                                                        { ?>
                                                    <li class="img_<?php echo $gi['piv_id']; ?>">
                                                    <video src="<?php echo $this->request->webroot; ?>uploads/trainer_videos/<?php echo $gv['piv_name']; ?>" height="175" id="jwp_video<?php echo $gv['piv_id']; ?>" width="260px"></video>
                                                    </li>
                                                <?php } ?>
                                            </ul>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>
                                  </div>
                                
                            </div>
                        <!-- </div> -->
                      </div>
                    
                    </div>
                </div>
            </div>
        </div>
     </section>   
        
    </div>
    <!--Main container sec end-->
    
    <!-- Gallery Image Uploading Start -->

    <script type="text/javascript">

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $("#dvPreview").html("<img class='append_img'/>").show();
                    $('#dvPreview img').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }  

        $(document).ready(function(){
        $('#uploadImage1').change(function(){
            $("#dvPreview").html("").hide();
            var file_name = $(this).val();
            var fileObj = this.files[0]; // get file object
            var calculatedSize = fileObj.size/(1024*1024); // in MB
            var split_extension = file_name.split(".").pop();
            var ext = [ "jpg", "gif","jpeg","tiff" ];
            if(jQuery.inArray(split_extension.toLowerCase(), ext ) == -1)
            {
                $('#uploadImage1').val(fileObj.value = null);
                $("div#gallery_phots div#error_msg").html("<center><i class='fa fa-times'> You Can Upload Only .jpg, gif,jpeg,tiff  Files ! </i></center>").show();
                return false;
            }
            if(calculatedSize > 10)
            {
                $('#uploadImage1').val(fileObj.value = null);
                $("div#gallery_phots  div#error_msg").html("<center><i class='fa fa-times'>  File size should be less than 10 MB ! </i></center>").show();
                return false;
            }
            if(jQuery.inArray(split_extension.toLowerCase(), ext ) != -1 && calculatedSize < 10)
            {
                    readURL(this);
                    $("div#gallery_phots div#error_msg").hide();
                    $('div#gallery_phots img#loading-img').show();
                    var data = new FormData($('#submit_form1')[0]);
                    $.ajax({
                        type: "post",
                        url: "<?php echo $this->request->webroot; ?>trainers/addGalleryImage",
                        data: data,
                        dataType : "json",
                        contentType: false,
                        processData: false,
                        success: function(response){
                            $('div#gallery_phots img#loading-img').hide();
                           if(data.message != "")
                               {
                                $("div#gallery_phots div#success_msg").html("<center><i class='fa fa-check'> Image Uploaded Successfully </i></center>").show();
                                $("div#gallery_phots div#error_msg").hide();
                                setTimeout(function(){ window.location.href="<?php echo $this->request->webroot; ?>trainers/photoalbum/gallery_phots"; }, 1000);
                               }
                            else
                                {
                                $("div#gallery_phots div#error_msg").html("<center><i class='fa fa-times'> Something is Wrong Please Try Again ! </i></center>").show();
                                $("div#gallery_phots div#success_msg").hide();
                                }
                        }
                    });
            }
        });
        });
    </script>

    <!-- Gallery Image Uploading End -->


    <!-- Video Uploading Start -->

    <script type="text/javascript">
        $(document).ready(function(){
        $('#uploadVideo').change(function(){
            var file_name = $(this).val();
            var split_extension = file_name.split(".").pop();
            var ext = [ "mkv", "flv","avi","mp4","mp3","m4v","mpeg-4" ];
            if(jQuery.inArray(split_extension.toLowerCase(), ext ) != -1)
            {
                    $("div#videos div#error_msg").hide();
                    $('div#videos img#loading-img').show();
                    var data = new FormData($('#submit_form2')[0]);
                    $.ajax({
                        type: "post",
                        url: "<?php echo $this->request->webroot; ?>trainers/addVideos",
                        data: data,
                        dataType : "json",
                        contentType: false,
                        processData: false,
                        success: function(response){
                            $('div#videos img#loading-img').hide();
                           if(data.message != "")
                               {
                                $("div#videos div#success_msg").html("<center><i class='fa fa-check'> Video Uploaded Successfully </i></center>");
                                $("div#videos div#success_msg").show();
                                $("div#videos div#error_msg").hide();
                                setTimeout(function(){ window.location.href="<?php echo $this->request->webroot; ?>trainers/photoalbum/videos"; }, 1000);
                               }
                            else
                                {
                                $("div#videos div#error_msg").html("<center><i class='fa fa-times'> Something is Wrong Please Try Again ! </i></center>");
                                $("div#videos div#error_msg").show();
                                $("div#videos div#success_msg").hide();
                                }
                        }
                    });
              }
            else
                {
                    $("div#videos div#error_msg").html("<center><i class='fa fa-times'> You Can Upload Only .mkv, flv, avi, mp4,mp3,m4v,mpeg-4 Files ! </i></center>");
                    $("div#videos div#error_msg").show();
                    $("div#videos div#success_msg").hide();
                }
        });
        });
    </script>

    <!-- Video Uploading End -->

    <!-- Video Player Start -->

    <script type='text/javascript'>
    <?php 
        foreach($gallery_videos as $gv)
        { ?>
        jwplayer("jwp_video<?php echo $gv['piv_id']; ?>").setup({
        flashplayer: "<?php echo $this->request->webroot; ?>player/player.swf",
        plugins: {
                 viral: {
                     onpause: false,
                     oncomplete: false,
                     allowmenu: false
                 }
              }
        });
    <?php } ?>
        
    </script>

    <!-- Video Player End -->

    <!-- Delete gallery Images/Videos Start -->
    <script type="text/javascript">
        $(document).ready(function(){
        $('body').on('click','.delte_img',function(){
        var p_id = $(this).attr('main');
        var file = $(this).attr('main2');
        if (confirm("Are You Sure?")) {
            $('img#loading-img').show();
            $.ajax({
                    url:"<?php echo $this->request->webroot; ?>trainers/deleteGallery",
                    type:"post",
                    data:{p_id:p_id,file:file},
                    dataType:"json",
                    success: function(data){
                     $('img#loading-img').hide();
                     if(data.message == "success")
                     {
                       $('li.img_'+atob(p_id)).remove(); 
                     }
                    }
                });
             }
          else{
            return false;
          }
        });
        });
    </script>
    <!-- Delete gallery Images/Videos End -->


    <script type="text/javascript">
        $(document).ready(function(){
            var pageURL = $(location).attr("href");
            var splitURL = pageURL.split("/"); 
            var result = splitURL[splitURL.length - 1];  

            if(result == "photoalbum" || result == "/")
                {
                    $('.'+result).removeClass('active');
                    $('.gallery_phots').addClass('active');
                }
            else
                {
                    $('.gallery_phots').removeClass('active');
                    $('.'+result).addClass('active');
                }
        });
    </script> 

