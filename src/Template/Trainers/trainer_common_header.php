  <main class="animsition">
    <!--Main container sec start-->
    <div class="">
    <!--Trainee top sec start-->
    	<section class="trainee_top parallax-window" data-parallax="scroll" data-image-src="<?php echo $this->request->webroot; ?>images/trainee_top_bg.jpg">
        	<div class="trainee_top_inner tr_grad">
        		<div class="container">
            	<div class="row">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="trainee_top_wrap">
                            <div class="trainee_img">
                            <form id="profile_form" method="post" enctype="multipart/form-data">
                            <?php
                                if($profile_details[0]['trainer_image'] != "")
                                { ?>
                                    <a class="example-image-link" href="<?php echo $this->Custom->getImageSrc('uploads/trainer_profile/'.$profile_details[0]['trainer_image']) ?>" data-lightbox="example-set" data-title="Click the right half of the image to move forward.">
                                    <img id="profile-img" style="width:200px;height:190px;" src="<?php echo $this->Custom->getImageSrc('uploads/trainer_profile/'.$profile_details[0]['trainer_image']) ?>" alt="img" class="img-responsive"></a>
                            <?php }
                                else
                                { ?>
                                    <img id="profile-img" style="width:200px;height:190px;" src="<?php echo $this->request->webroot; ?>img/default.png" alt="img" class="img-responsive">
                            <?php } ?>
                                <?php if($profile_details[0]['trainer_image'] != "default.png") { ?>
                                    <a class="upload_profile_img" href="javascript:void(0);"><input name="trainer_profile_img" id="trainer_profile_img" type="file"/><span class="fa fa-camera"></span>
                                    <span class="trash" id="delete_profile_img" ><i class="fa fa-trash" aria-hidden="true"></i></span>
                                <?php } else{ ?>
                                    <a class="upload_profile_img" href="javascript:void(0);"><input name="trainer_profile_img" id="trainer_profile_img" type="file"/><span class="fa fa-camera single_camera"></span>
                                <?php } ?>
                                </a>
                            </form>
                            </div>
                            <div class="trainee_detail">
                                <h1 class="trainee_name"><?php echo $profile_details[0]['trainer_name']; ?></h1>
                                <div class="retting_box">
                                    <h3 class="trainee_rank">Rank Level : </h3><input class="trainer-rank" value="<?php echo $profile_details[0]['trainer_rating']; ?>" type="number" /> <span class="gray_grad"><?php echo $profile_details[0]['trainer_rating']; ?></span>
                                </div>       
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
            </div>
        </section>
    <!--Trainee top  sec end--> 
    <!-- Rating Start -->

<script>
    jQuery(document).ready(function () {
     $('.trainer-rank').rating({
              step: 1,
              size: 'xs',
              showClear: false,
              disabled: true
        });
    });
</script>

<!-- Rating End -->
