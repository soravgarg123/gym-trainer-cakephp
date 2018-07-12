  <main class="animsition">
    <!--Main container sec start-->
    <div class="main_container">
    <!--Trainee top sec start-->
    	<section class="trainee_top parallax-window" data-parallax="scroll" data-image-src="<?php echo $this->request->webroot; ?>images/trainee_top_bg.jpg">
        	<div class="trainee_top_inner tr_grad">
        		<div class="container">
            	<div class="row">
                	<div class="col-sm-12">
                    	
                        	<div class="contact_form_title">Contact Us</div>
                        
                    </div>
                </div>
            </div>
            </div>
        </section>
    <!--Trainee top  sec end--> 
		
     <section class="trainee_dash_body">
     	<div class="container">
        	<div class="row">
            	
            	<div class="col-sm-7">

                	<div class="plan_header_sect contact_head">
                    	<h3>Contact Us</h3>
                        <p>Please don’t hesitate to contact us. If you have any questions, comments or concerns we’ll gladly help
                    </p>
                    <?php echo $this->Flash->render('edit') ?>
                    </div>
                    
                    <div class="contact-page_form">
                    	<form id="contactForm" method="post" action="<?php echo $this->request->webroot; ?>docontact">
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
                            <input type="email"  id="contact_email" name="email" class="form-control"  placeholder="Email ">
                          </div>
                          <div class="form-group">
                            <input type="text"  name="subject" class="form-control"  placeholder="Subject ">
                          </div>
                          <div class="form-group">
                            <textarea  class="form-control" name="message" rows="5" placeholder="Message"></textarea>
                          </div>
                          
                          <button type="button" class="btn submit_btn">Submit</button>
                        </form>
                    </div>
                    
                    
                </div>
                <div class="col-sm-5">
                	
                    <div class="contact-sidebar">
                        <address>
                          <strong>Contact Information</strong>
                          <ul>
                          	<li><span class="fa fa-phone"></span> +403-800-4843</li>
                            <li><span class="fa fa-envelope"></span> <a href="mailto:help@virtualtrainr.com ">help@virtualtrainr.com </a></li>
                            <li><span class="fa fa-home"></span> You Tag Media & Business Solutions, Inc
1950 Broad Street, Unit 209 Regina, SK S4P 1X6 Canada</li>
                          </ul>
                        </address>
                    </div>
                    
                </div>
            </div>
            
        </div>
     </section>   
        
    </div>
    <!--Main container sec end-->
  </main>

<!-- Contact Form Start -->

<script type="text/javascript">
  $(document).ready(function(){
    $('body').on('click','.submit_btn',function(e){
      $('#contactForm select, #contactForm input[type=text], #contactForm input[type=email], #contactForm textarea').each(function() {
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

