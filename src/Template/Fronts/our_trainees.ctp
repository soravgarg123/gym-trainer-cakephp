  <main class="animsition">
    <!--Main container sec start-->
    <div class="main_container">
    <!--Trainee top sec start-->
    	<section class="our_trainer_top parallax-window"  data-parallax="scroll" data-image-src="<?php echo $this->request->webroot; ?>images/fitness.png">
        	<div class="trainee_top_inner tr_grad">
        		<div class="container">
            	<div class="row">
                	<div class="col-sm-12">
                    	<div class="trainee_top_wrap">
                        	<div class="trainer_search">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="search_trainer" placeholder="Search Trainee">
                                            <div class="input-group-addon">
                                                <span class="fa fa-search" style="cursor:pointer;"></span>
                                            </div>
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
		
     <section class="trainee_dash_body">
     	<div class="container">
        	<div class="row">
            	<div class="col-sm-12">
                	<div class="ourtrainer_wrap">
                    	<h3>Our Trainee</h3>
                        <center><img style="display:none;" id="loading-img" src="<?php echo $this->request->webroot; ?>img/loading-spinner-grey.gif" /></center></br>
                        <div id="append_div">
                    	<ul class="row">
                        <?php 
                            foreach($trainees as $t)
                            { ?>
                        <!-- <a href="<?php echo $this->request->webroot; ?>traineeProfile/<?php echo base64_encode($t['user_id']); ?>"> -->
                        <li class="col-sm-4 col-md-3">
                                <div class="trainer_sec">
                                    <div class="trainer_img">
                                    <?php
                                        if($t['trainee_image'] != "")
                                        { ?>
                                            <img style="height:260px;width:100%" src="<?php echo $this->Custom->getImageSrc('uploads/trainee_profile/'.$t['trainee_image']) ?>" alt="img" class="img-responsive">
                                    <?php }
                                        else
                                        { ?>
                                            <img style="height:260px;width:100%" src="<?php echo $this->request->webroot; ?>img/default-user.png" alt="img" class="img-responsive">
                                    <?php } ?>
                                        <nav class="trainer_social_link">
                                            <ul>
                                            <?php if($t['trainee_facebook'] != "") { ?>
                                                <li><a target="_blank" href="<?php echo $t['trainee_facebook']; ?>"><span class="fa fa-facebook"></span></a></li>
                                            <?php } ?>
                                            <?php if($t['trainee_twitter'] != "") { ?>
                                                <li><a target="_blank" href="<?php echo $t['trainee_twitter']; ?>"><span class="fa fa-twitter"></span></a></li>
                                            <?php } ?>
                                            <?php if($t['trainee_linkedin'] != "") { ?>
                                                <li><a target="_blank" href="<?php echo $t['trainee_linkedin']; ?>"><span class="fa fa-linkedin"></span></a></li>
                                            <?php } ?>
                                            <?php if($t['trainee_google'] != "") { ?>                                                
                                                <li><a target="_blank" href="<?php echo $t['trainee_google']; ?>"><span class="fa fa-google-plus"></span></a></li>
                                            <?php } ?>
                                            </ul>
                                        </nav>
                                    </div>
                                    <div class="trainer_info">
                                        <p><strong><a style="color:white;" href="<?php echo $this->request->webroot; ?>traineeProfile/<?php echo base64_encode($t['user_id']); ?>"> Trainee : </strong><?php echo ucwords($t['trainee_name']); ?> </a></p>
                                        <p><strong>Location : </strong> <?php echo $t['city_name']; ?></p>
                                        <!-- <p><strong>Rank :</strong> Level 6</p> -->
                                    </div>
                                </div>
                            </li>
                        <!-- </a> -->
                        <?php } ?>
                        	
                        </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
     </section>   
        
    </div>
    <!--Main container sec end-->
  </main>
    <script>
		$(".dropdown-menu li a").click(function(e){
		  $(this).parents(".dropdown").find('button').html($(this).text() + ' <span class="wcaret"></span>');
		  e.preventDefault();
		});
	</script>

    <script type="text/javascript">
        $(document).ready(function(){
            $("#search_trainer").keyup(function(e){ 
            var val = $('#search_trainer').val();
            $('#loading-img').show();
            $.ajax({
            url:"<?php echo $this->request->webroot; ?>fronts/searchTrainee",
            type:"post",
            data:{val : val},   
            dataType : "json",                 
            success: function(data){
            $('#loading-img').hide();
            if(data.message == "")
            {
                $('#append_div').html('<div class="alert alert-danger alert-dismissable"  id="error_msg"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button><b></b> <center> <i class="fa fa-times"></i> Trainees Not Found </center></div>');
            }
            else
            {
                $('#append_div').html(data.message);
            }
           }
          });
         });
        });
    </script>


