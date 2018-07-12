 
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
          ?>
          <ul>
              <li><a href="javascript:void(0);" title="Login" data-toggle="modal" data-target="#LoginModal"><span class="flaticon-doorkey"></span>Login</a></li>
              <li><a href="javascript:void(0);" title="Signup" data-toggle="modal" data-target="#signup_Modal"><span class="flaticon-profile7"></span>Signup</a></li>
          </ul>
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
      <img src="<?php echo $this->request->webroot; ?>img/belibit_tv_logo.png" alt="work out equipment">
      </a>
      <div class="beta_logo">BETA</div>
    </div>
            <div class="collapse navbar-collapse mainmenu_nav navbar-right" id="top_nav">
                <ul>                                                   
                    <li><a href="<?php echo $this->request->webroot; ?>" title="Home">Home</a></li>
                    <li><a href="<?php echo $this->request->webroot; ?>learn-more" title="Learn More">Learn More </a></li>
                    <li><a href="<?php echo $this->request->webroot; ?>contact-us" title="Contact Us">Contact Us</a></li>
                </ul>
            </div>
            </div>
        </nav>
    </header>


