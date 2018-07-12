    <!--Main container sec start-->
    <div class="main_container">
    <!--Trainee top sec start-->
        <section class="trainee_top parallax-window" data-parallax="scroll" data-image-src="<?php echo $this->request->webroot; ?>images/trainee_top_bg.jpg">
            <div class="trainee_top_inner tr_grad">
                <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="trainee_top_wrap">
                            
                          <div class="plan_header_sect text-center">
                            <h3>Training Packages - All Plans</h3>
                            <p>Choose a personal training package today. We recommend that you purchase a single session for a trial-run with a trainer of your choice. Once you’ve found a trainer that suits your needs you can purchase larger packages at a premium rate.  Every package includes workouts, nutrition information, supplement advice and much more. Whatever your goal, we’ve got you covered.</p>
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
                    

                <?php
                    foreach($all_sessions as $ss)
                    {
                        $all_cat[] = $ss['category_id'];
                    }
                $i = 1;
                foreach($categories as $c) {  
                if (in_array($c['id'], $all_cat)) { ?>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="ps_heading sec_heading" id="msg_box">
                            <h1><?php echo ucwords($c['pc_name']); ?> PLAN</h1></br>
                            <strong><h3><?php echo ucwords($c['pc_title']); ?></h3></strong>
                            <?php if($c['pc_name'] == "BRONZE") { ?>
                            <p>The bronze plan has everything to get you started with a fitness expert today. Whether your goals include weight loss, strength training or staying in shape,  we can find you a certified trainer to help you along the journey.</p>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="plan_error">
                    <?php echo $this->Custom->errorMsg(); ?>
                </div>
                <div class="row ps_body">
                <?php $j = 1;
                foreach($all_sessions as $s) { 
                if($c['id'] == $s['category_id']) { ?>
                <div class="col-sm-3">
                    <div class="price_block">
                        <div class="pb_heading gray_grad">
                            <h2><?php echo $s['ps_name']; echo ($s['ps_name'] == 1)? " Session" : " Sessions"; ?></h2>
                        </div>
                        <div class="pb_body">
                            <div class="session_price">
                                <span>$<?php echo $s['ps_price']; ?></span>
                            </div>
                            <div class="session_order">
                            <?php 
                                $session = $this->request->session();
                                $user = $session->read('Auth.User');
                                if(empty($user))
                                { ?>
                                    <a href="javascript:void(0);" class="without_login" title="Click Here To Order">Order Now</a>
                            <?php  }
                                if(!empty($user) && $user['user_type'] == "trainee")
                                { ?>
                                    <a href="<?php echo $this->request->webroot; ?>trainees/purchasePlan/<?php echo base64_encode($s['id']); ?>" class="order-btn trainee_login" title="Click Here To Order">Order Now</a>
                            <?php  } 
                            if(!empty($user) && $user['user_type'] == "trainer")
                                { ?>
                                    <a href="javascript:void(0);" class="trainer_login" title="Click Here To Order">Order Now</a>
                            <?php  }?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php $j++; } } ?>

                </div> </br></br>

                <?php  } 
                else { ?>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="ps_heading sec_heading" >
                        <?php if($c['pc_name'] == "FLEX RATE"){ ?>
                            <h1 style="color:red;"><?php echo ucwords($c['pc_name']); ?> PLAN</h1></br>
                        <?php }else{ ?>
                            <h1><?php echo ucwords($c['pc_name']); ?> PLAN</h1></br>
                        <?php } ?>
                             <strong><h3><?php echo ucwords($c['pc_title']); ?></h3></strong>
                            <p>Coming Soon</p>
                        </div>
                    </div>
                </div>

                <?php $i++; } } ?> 


                </div>
                
            </div>
            
        </div>
     </section>   
        
    </div>
    <!--Main container sec end-->
  </main>


<script type="text/javascript">
    $(document).ready(function(){
        $('body').on('click','.without_login',function(){
            $('#LoginModal').modal('show');
        });
        $('body').on('click','.trainer_login',function(){
            $("div.plan_error div#error_msg").html("<center><i class='fa fa-times'> You Can`t Purchase Any Plans ! </i></center>").show();
        });
    });
</script>




  
