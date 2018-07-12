    <!--Main container sec start-->
    <div class="main_container">
    <!--Trainee top sec start-->
    	<section class="trainee_top parallax-window" data-parallax="scroll" data-image-src="<?php echo $this->request->webroot; ?>images/trainee_top_bg.jpg">
        	<div class="trainee_top_inner tr_grad">
        		<div class="container">
            	<div class="row">
                	<div class="col-sm-12">
                    	<div class="trainee_top_wrap">
                        	
                           
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </section>
    <!--Trainee top  sec end--> 
		
     <section class="trainee_dash_body">
     	<div class="container trainee_profile_wrap">
        	
        	<div class="row">
            	<div class="col-md-12">
                	<div class="aprotunity_main">
                    	<div class="inner_head">
                        	<h1>Become a Trainer</h1>
                        </div>
                        <div class="inner_pera">
                        	<p><h3>Take Control of your Fitness Career</h3></p>
                           <p> <strong>Be your own boss</strong></br>
                            Become independent. Work your own hours, design your own schedule, and control your own income. The unique Trainer Dashboard is your very own virtual office, designed with you in mind. Entirely safe and secure, the user-friendly Trainer Dashboard manages all of your clientele information, appointments, messages, earnings and more. Our sophisticated system will allow you to work for yourself and earn what you deserve. Virtual TrainR provides you with all the tools and services you need to jumpstart your career.</p>
                        
                        <p><strong>Choose when you get paid</strong></br>
                        Comprehensive finance reports allow you to easily keep track of all client sessions. Client sessions are paid out instantly and funds are deposited into your online wallet. Watch your funds grow in real-time and cash out whenever, wherever.</p>
                    
                    <p><strong>Connect like never before</strong></br>
                        Become an inspiration in the fitness community. Communicate with your clients using our 1-to-1 video chat and personal messaging system. Help organize meal plans, exercise schedules and meet up times with your clients at local gyms using your Trainer Dashboard.Client feedback matters, gain positive reviews and become a legendary trainer today.</p>
                    
                    <p><strong>Money Talks</strong></br>
                        Do the math, the decision is easy. Join our Virtual TrainR community and earn what you deserve for your hard work. Begin your fitness career today.</p>
                    
                    <p><strong>Recruitment</strong></br>
                        Join now and become a certified Virtual TrainR fitness specialist. After you sign up, submit a copy of your personal training certificate and resume to be reviewed by our Administrative Staff. The preliminary screening process and background information checkup takes between 24-to-48 hours. Once your documents have been approved, a member of our Recruitment Team will contact you to get you started on your independent personal training career. Welcome to the future of fitness. </p>
                        </div>
                        <?php
                            $session = $this->request->session();
                            $user_data = $session->read('Auth.User');
                            if(empty($user_data)){ ?>
                            <a href="#signup_Modal_trainer" data-target="#signup_Modal_trainer" data-toggle="modal" class="btn submit_btn">Join now</a>
                        <?php } ?>
                        </div>
                            
                            
                         </div>
                        
                        
                        
                        
                        
                        
                     
                    </div>
                </div>
            </div>
            
            
        </div>
     </section>   
        
    </div>
    <!--Main container sec end-->
