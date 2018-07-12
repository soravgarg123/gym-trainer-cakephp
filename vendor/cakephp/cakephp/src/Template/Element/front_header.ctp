 
<main class="animsition">
    <!--Header sec start-->
        <header class="header_sec navbar-fixed-top" id="header" data-spy="affix" data-offset-top="60">
        <script>
          (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
          (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
          m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
          })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

          ga('create', 'UA-70844321-1', 'auto');
          ga('send', 'pageview');

        </script>
        <div class="header_top">
            <div class="container">
                <nav class="top_nav">
        <?php 
            $this->request->session()->start();
            $session = $this->request->session();
            $user_data = $session->read('Auth.User');
            if(empty($user_data))
                { ?>
                <ul>
                    <li><a href="#" title="Login" data-toggle="modal" data-target="#LoginModal"><span class="flaticon-doorkey"></span>Login</a></li>
                    <li><a href="#" title="Signup" data-toggle="modal" data-target="#signup_Modal"><span class="flaticon-profile7"></span>Signup</a></li>
                </ul>
            <?php }
            else
                { ?>
                <ul>
                <?php
                    if($user_data['user_type'] == "trainer")
                        { ?>
                            <li><a class="noti_icon" title="Notifications" href="<?php echo $this->request->webroot; ?>trainers/notifications"><div class="noti_count"><?php if(isset($notifications)) { echo $notifications; } else { echo "0"; } ?></div><i class="fa fa-bell"></i></a></li>
                            <li><a href="javascript:void(0);" title="<?php echo $user_data['display_name']; ?>">
                            Hi, <?php echo $user_data['display_name']; ?></a>
                              <ul class="pro_btn_hover">
                                <li><a title="View Profile" href="<?php echo $this->request->webroot; ?>trainers/profile">View Profile</a></li>
                                <li><a title="View Inbox" href="<?php echo $this->request->webroot; ?>trainers/inbox">View Inbox</a></li>
                                <!-- <li><a title="My Wallet" href="<?php echo $this->request->webroot; ?>trainees/wallet">My Wallet</a></li> -->
                                <li><a title="Test Call" href="javascript:void(0);" id="test_call">Test Call</a></li>
                              </ul>
                            </li>
                    <?php }
                    if($user_data['user_type'] == "trainee")
                        { ?>
                      <li><a class="noti_icon" title="Notifications" href="<?php echo $this->request->webroot; ?>trainees/notifications"><div class="noti_count"><?php if(isset($notifications)) { echo $notifications; } else { echo "0"; } ?></div><i class="fa fa-bell"></i></a></li>
                           <li><a href="javascript:void(0);" title="<?php echo $user_data['display_name']; ?>">
                           Hi, <?php echo $user_data['display_name']; ?> 
                           </a>

                           <ul class="pro_btn_hover">
                               <li><a title="View Profile" href="<?php echo $this->request->webroot; ?>trainees/profile">View Profile</a></li>
                               <li><a title="View Inbox" href="<?php echo $this->request->webroot; ?>trainees/inbox">View Inbox</a></li>
                               <li><a title="My Wallet" href="<?php echo $this->request->webroot; ?>trainees/wallet">My Wallet</a></li>
                               <li><a title="Test Call" href="javascript:void(0);" id="test_call">Test Call</a></li>
                           </ul>

                           </li> 
                    <?php } ?>
                    
                    <li><a href="<?php echo $this->request->webroot; ?>users/logout">Logout</a></li>
                </ul>
            <?php } ?>
                    
                </nav>
            </div>
        </div>
        <nav class="main_nav">
            <div class="container">
                <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#top_nav" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="<?php echo $this->request->webroot; ?>">
      <!-- <img src="<?php echo $this->request->webroot; ?>images/logo.png" alt="logo"> -->
      <img src="<?php echo $this->request->webroot; ?>img/belibit_tv_logo.png" alt="logo">
      </a>
      <div class="beta_logo">BETA</div>
    </div>
            <div class="collapse navbar-collapse mainmenu_nav navbar-right" id="top_nav">
                <ul>                                                   
                    <li><a href="<?php echo $this->request->webroot; ?>" title="Home">Home</a></li>
                    <li><a href="<?php echo $this->request->webroot; ?>learnmore" title="Learn More">Learn More </a></li>
                    <!-- <li><a href="<?php echo $this->request->webroot; ?>ourTrainers" title="Our Trainers">Our Trainers</a></li> -->
                    <?php
                    if($user_data['user_type'] == "trainer")
                        { ?>
                            <!-- <li><a href="<?php echo $this->request->webroot; ?>ourTrainees" title="Our Trainees">Our Trainees</a></li> -->
                    <?php } ?>
                    <?php
                    if($user_data['user_type'] == "trainee")
                        { ?>
                            <!-- <li><a href="<?php echo $this->request->webroot; ?>trainees/favouritesTrainers" title="Favourites Trainers">My Favourite TrainR(s)</a></li> -->
                            <li><a href="<?php echo $this->request->webroot; ?>ourTrainers" title="Certified Trainers">Certified Trainers</a></li>
                    <?php } ?>
                    <li><a href="<?php echo $this->request->webroot; ?>plans" title="Pircing Plans">Pricing Plan</a></li>
                    <!-- <li><a href="#" title="Store">Store</a></li> -->
                    <!-- <li><a href="<?php echo $this->request->webroot; ?>terms" title="Terms &amp; Conditions">Terms &amp; conditions </a></li> -->
                    <?php if(empty($user_data))
                      { ?>
                    <!-- <li><a href="<?php echo $this->request->webroot; ?>career" title="Career">Career</a></li> -->
                    <!-- <li><a href="<?php echo $this->request->webroot; ?>opportunity" title="Opportunity">Opportunity</a></li> -->
                    <?php } ?>
                    <li><a href="<?php echo $this->request->webroot; ?>contactus" title="Contact Us">Contact Us</a></li>
                    <li><a href="<?php echo $this->request->webroot; ?>becometrainer" title="Become a Trainer" class="btn_trainer">Become a Trainer</a></li>
                </ul>
            </div>
            </div>
        </nav>
    </header>


