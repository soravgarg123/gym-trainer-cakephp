    <!--Main container sec start-->
    <div class="main_container">
    <!--Banner sec start-->
    	<section class="banner_sec">
        	<div id="main_carousel" class="carousel slide carousel-fade" data-ride="carousel" data-interval="9000">
		<!-- Indicators -->
		<ol class="carousel-indicators">
			<li data-target="#main_carousel" data-slide-to="0" class="active"></li>
			<li data-target="#main_carousel" data-slide-to="1"></li>
			<li data-target="#main_carousel" data-slide-to="2"></li>
		</ol>

		<!-- Wrapper for slides -->
		<div class="carousel-inner" role="listbox">
		
			<!-- First slide -->
			<div class="item active banner_bg1" data-type="background" data-speed="8">
				<div class="container">
					<div class="carousel-caption">
					<span data-animation="animated fadeInDown">
						<img src="<?php echo $this->request->webroot; ?>images/logo1.png" alt=" personal trainer app- Virtual Trainer" class="img-responsive">
					</span>
					<div class="second_head" data-animation="animated fadeInDown">
						Welcome to the Future of Fitness
					</div>
                    <p data-animation="animated fadeInDown">
                    Virtual TrainR now allows people to connect and train with certified 
fitness specialists. </br>Anywhere, anytime.
                    </p>
					<button class="btn carusel_btn" id="learn_more" data-animation="animated fadeInDown">Learn More</button>
                    <!-- <a href="<?php echo $this->request->webroot; ?>learnmore" class="btn carusel_btn" data-animation="animated fadeInDown">Learn More</a> -->
				</div>
                </div>
			</div> <!-- /.item -->
			
			<!-- Second slide -->
			<div class="item banner_bg2" data-type="background" data-speed="8">
            	<div class="container">
					<div class="carousel-caption">
					<span data-animation="animated fadeInDown">
						<img src="<?php echo $this->request->webroot; ?>images/logo1.png" alt=" personal trainer app- Virtual Trainer" class="img-responsive">
					</span>
					<div class="second_head" data-animation="animated fadeInDown">
						No excuses! Get ready to achieve your goals. 
					</div>
                    <p data-animation="animated fadeInDown">
                    Sign up and train with a local expert today.
                    </p>
					<button class="btn carusel_btn" data-target="#signup_Modal" data-toggle="modal" data-animation="animated fadeInDown">start now</button>
				</div>
                </div>
			</div><!-- /.item -->
			
			<!-- Third slide -->
			<div class="item banner_bg3" data-type="background" data-speed="8">
            	<div class="container">
					<div class="carousel-caption">
					<span data-animation="animated fadeInDown">
						<img src="<?php echo $this->request->webroot; ?>images/logo1.png" alt=" personal trainer app- Virtual Trainer" class="img-responsive">
					</span>
					<div class="second_head" data-animation="animated fadeInDown">
						Got what it takes? Get paid to train.
					</div>
                    <p data-animation="animated fadeInDown">
                    Become a partner in our growing fitness community and train people today. 
                    </p>
					<button class="btn carusel_btn" id="become_trainr" data-animation="animated fadeInDown">Become a Trainer</button>
				</div>
                </div>
			</div><!-- /.item -->
		
		</div><!-- /.carousel-inner -->
	</div>
        </section>
    <!--Banner sec end--> 
    
     <!--Latest News sec start-->
        <section class="latest_news">
        	<div class="container">
            	<div class="row">
                	<div class="col-sm-12">
                    	<div class="sec_heading ln_heading">
                        	<div class="main_heading">How <span>it</span> works</div>
                            <p></p>
                        </div>
                    </div>
                </div>
                <div class="row ln_body">
                    <div class="col-sm-4">
                    	<div class="lnews_block">
                        	<div class="lnb_top">
                            	<img src="<?php echo $this->request->webroot; ?>images/news_img1.jpg" alt="Discover" class="img-responsive">
                                <a href="javascript:void(0);" class="man"><i class="flaticon1-man316"></i></a>
                            </div>
                            <div class="lnb_bot">
                            	<h3>Discover</h3>
                                <p>Find a certified personal trainer that will guide you to 
achieve your fitness goals. </p>
             <div class="step_btn_box"><a href="javascript:void(0);" class="step_btn">step 1</a></div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                    	<div class="lnews_block">
                        	<div class="lnb_top">
                            	<img src="<?php echo $this->request->webroot; ?>images/news_img2.jpg" alt="Connect" class="img-responsive">
                                <a href="javascript:void(0);" class="cloud"><i class="flaticon1-cloud229"></i> </a>
                            </div>
                            <div class="lnb_bot">
                            	<h3>Connect</h3>
                                <p>Interact with your selected trainer, book a session 
and prepare to discover your potential.  </p>
<div class="step_btn_box"><a href="javascript:void(0);" class="step_btn">step 2</a></div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-sm-4">
                    	<div class="lnews_block">
                        	<div class="lnb_top">
                            	<img src="<?php echo $this->request->webroot; ?>images/news_img3.jpg" alt="achieve" class="img-responsive">
                                <a href="javascript:void(0);" class="goa"><i class="flaticon1-goal5"></i> </a>
                            </div>
                            <div class="lnb_bot">
                            	<h3>achieve</h3>
                                <p>Train with your certified personal trainer at a local gym, 
at home, or anywhere using our one-to-one 
video chat.</p>              <div class="step_btn_box"><a href="javascript:void(0);" class="step_btn">step 3</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <!--Latest News sec end --> 
    
    <!--How it works sec start-->   
        <section class="how_it_works">
        	<div class="container">
            	<div class="row">
                	<div class="col-sm-7">
                    	<div class="hiw_left">
                        	<div class="hiw_left_heading sec_heading">
                            	<div class="main_heading">Become your Own Boss</div>
                            </div>
                            <div class="hiw_left_body sec_body">
                            	<p>Get paid what you deserve. Train clients in our growing fitness community. </br> Sign up with Virtual TrainR today and begin your independent personal training career.  </p>
                                
                                <a href="<?php echo $this->request->webroot; ?>become-personal-trainer" title="Become a Trainer" class="trainer1">Become a Trainer</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-5">
                    	<div class="hiw_right">
                        	<img src="<?php echo $this->request->webroot; ?>images/how_it_works.png" alt="how this online workout program works" class="img-responsive">
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <!--How it works sec end--> 
    
    <!--Our services sec start-->       
        <section class="our_services">
        	<div class="container">
            	<div class="row">
                	<div class="col-sm-12">
                    	<div class="searvices_heading sec_heading">
                        	<div class="main_heading">Variety of <span>Activities</span> to choose from</div>
                            
                            <p>
                           Spice up your fitness. We offer various types of fitness activities for your satisfaction. Sign up with Virtual TrainR today and discover our growing fitness community. Fitness revolutionized through Virtual TrainR.
                            </p>
                            <h2>Yours To Discover</h2>
                        </div>
                    </div>
                    <div class="col-sm-12">
                    	<div class="services_body">
                        	<ul class="clearfix">
                            	<li>
                                <div class="ser_img"><img src="<?php echo $this->request->webroot; ?>images/services_img1.jpg" alt="Cardio" class="img-circle image_hover">
                                </div>
                                <div class="ser_txt">
                                	<div class="third_heading">Cardio</div>
                                    <p>Enjoy a variety of classes that provide an effective workout to build cardiovascular endurance.</p>
                                </div>
                                </li>
                                
                                <li>
                                <div class="ser_img"><img src="<?php echo $this->request->webroot; ?>images/services_img2.jpg" alt="Boot Camp" class="img-circle image_hover">
                                </div>
                                <div class="ser_txt">
                                	<div class="third_heading">Boot Camp </div>
                                    <p>Enjoy a variety of classes that provide an effective workout to build cardiovascular endurance.</p>
                                </div>
                                </li>
                                
                                <li>
                                <div class="ser_img"><img src="<?php echo $this->request->webroot; ?>images/services_img3.jpg" alt="Kick Boxing" class="img-circle image_hover">
                                </div>
                                <div class="ser_txt">
                                	<div class="third_heading">Kick Boxing </div>
                                    <p>Enjoy a variety of classes that provide an effective workout to build cardiovascular endurance.</p>
                                </div>
                                </li>
                                <li>
                                <div class="ser_img"><img src="<?php echo $this->request->webroot; ?>images/services_img5.jpg" alt="Mind & Body" class="img-circle image_hover">
                                </div>
                                <div class="ser_txt">
                                	<div class="third_heading">Mind &amp; Body </div>
                                    <p>Enjoy a variety of classes that provide an effective workout to build cardiovascular endurance.</p>
                                </div>
                                </li>
                                
                                <li>
                                <div class="ser_img"><img src="<?php echo $this->request->webroot; ?>images/services_img6.jpg" alt="Active Aging" class=" img-circle image_hover">
                                </div>
                                <div class="ser_txt">
                                	<div class="third_heading">Active Aging </div>
                                    <p>Enjoy a variety of classes that provide an effective workout to build cardiovascular endurance.</p>
                                </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <!--Our services sec end-->
    
    <!--Mobile App sec start-->
        <section class="mobileapp_sec">
        	<div class="container">
            	<div class="row">
                  <div class="col-sm-3">
                    <div class="ms_left">
                        	<img src="<?php echo $this->request->webroot; ?>images/app_img1.png" alt="Virtual TrainR personal training app" class="img-responsive">
                        </div>
                  </div>
                	<div class="col-sm-6">
                    	<div class="ms_center">
                            <div class="ms_heading sec_heading">
                                <h1><span>Virtual</span> Train<span>R</span> App</h1>
                            </div>
                            <div class="ms_body sec_body">
                                <p>All Trainers On Your Mobile</p>
                                <div class="third_heading">COMING SOON</div>
                            
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                    	<div class="ms_right">
                        	<img src="<?php echo $this->request->webroot; ?>images/app_img.png" alt="Our fitness app" class="img-responsive">
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <!--Mobile App sec end-->
     
    <!--Testimonial sec start-->   
        <section class="testimonial_sec">
        	<div class="tetimonialsec_inner">
        		<div class="container">
                <div class="testimonial_carousel">
                    <div id="testi_carousel" class="carousel slide" data-ride="carousel">
                        <!-- Wrapper for slides -->
                        <div class="carousel-inner" role="listbox">
                            <div class="item active">
                              	<div class="testimonial_block clearfix">
                                	<div class="testi_img">
                                    	<img src="<?php echo $this->request->webroot; ?>images/services_img1.jpg" alt="home gym" class="img-responsive">
                                    </div>
                                    <div class="testi_txt">
                                    	<p>Because of Virtual TrainR I was able to stay connected with my personal trainer through out the program. The 1-1 video chat allowed me to stay in touch even when I was out of town.</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="item">
                              	<div class="testimonial_block clearfix">
                                	<div class="testi_img">
                                    	<img src="<?php echo $this->request->webroot; ?>images/services_img2.jpg" alt="online workout programs" class="img-responsive">
                                    </div>
                                    <div class="testi_txt">
                                    	<p>Because of Virtual TrainR I was able to stay connected with my personal trainer through out the program. The 1-1 video chat allowed me to stay in touch even when I was out of town.</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="item">
                              	<div class="testimonial_block clearfix">
                                	<div class="testi_img">
                                    	<img src="<?php echo $this->request->webroot; ?>images/services_img3.jpg" alt="total gym fit" class="img-responsive">
                                    </div>
                                    <div class="testi_txt">
                                    	<p>Because of Virtual TrainR I was able to stay connected with my personal trainer through out the program. The 1-1 video chat allowed me to stay in touch even when I was out of town.</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="item">
                              	<div class="testimonial_block clearfix">
                                	<div class="testi_img">
                                    	<img src="<?php echo $this->request->webroot; ?>images/services_img1.jpg" alt="american fitness" class="img-responsive">
                                    </div>
                                    <div class="testi_txt">
                                    	<p>Because of Virtual TrainR I was able to stay connected with my personal trainer through out the program. The 1-1 video chat allowed me to stay in touch even when I was out of town.</p>
                                    </div>
                                </div>
                            </div>
                         </div>
    
                    </div>
                </div>
            </div>
            </div>
        </section>
  
     <!--Testimonial sec end-->   
    
    <!--Contact Sec start-->    
        <section class="contact_sec">
        <div id="map_display"></div>
            <div class="container">
         
                <div class="row">
                    <div class="col-sm-12">
                        <div class="contact_block">
                            <div class="cb_heading">
                                <div class="main_heading">Contact Us Now</div>
                            </div>
                            <div class="cb_body">
                                <form id="contactForm" method="post" action="<?php echo $this->request->webroot; ?>docontact">
                                    <div class="cb_row clearfix">
                                     <div class="form-group">
                                        <select class="form-control" name="type">
                                          <option value="customer">Customer Service</option>
                                          <option value="business">Business</option>
                                          <option value="sales">Sales</option>
                                        </select>
                                      </div>
                                        <div class="form-group">
                                            <input type="text"  name="name" class="form-control"  placeholder="Name">
                                        </div>
                                        <div class="form-group">
                                            <input type="text"  name="subject" class="form-control"  placeholder="Subject">
                                        </div>
                                        <div class="form-group">
                                            <input type="email" id="contact_email"  name="email" class="form-control"  placeholder="Email ">
                                        </div>
                                     </div>
                                    <div class="form-group">
                                        <textarea class="form-control"  name="message" placeholder="Message"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <input type="button" value="" class="con_submit" title="Click Here To Send">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <!--Contact Sec end-->
    </div>
    <!--Main container sec end-->

    <script type="text/javascript">
        $(document).ready(function(){
            $('body').on('click','#learn_more',function(){
                window.location.href="<?php echo $this->request->webroot; ?>learn-more";
            });
             $('body').on('click','#become_trainr',function(){
                window.location.href="<?php echo $this->request->webroot; ?>become-personal-trainer";
            });
        });
    </script>

    <!-- Contact Form Start -->

<script type="text/javascript">
  $(document).ready(function(){
    $('body').on('click','.con_submit',function(e){
      $('#contactForm input[type=text],#contactForm select, #contactForm input[type=email], #contactForm textarea').each(function() {
        var val = $(this).val();
        var email = $('#contact_email').val();
        var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if(val == "")
            {
               e.preventDefault();
               $(this).addClass('required-error');
            }
        if(!filter.test(email))
            {
               e.preventDefault();
               $('#contact_email').addClass('required-error');
            }
        if(val != "" && filter.test(email))
            {
               $(this).removeClass('required-error');
               $('#contactForm').submit();
            }
        });
    });
  });
</script>

<!-- Contact Form End -->
