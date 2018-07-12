<?php
use Cake\Error\Debugger;
$title = "";
if($this->fetch('title') == "Database Error"){
    $title = "Scheduled Maintenance"; 
}else{
    $title = "404 Not Found";
}
$session = $this->request->session();
$user = $session->read('Auth.User');
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <link href="<?php echo $this->request->webroot; ?>img/favicon.ico" rel="shortcut icon">
    <?php echo  $this->Html->css('bootstrap.min.css') ?>
    <?php echo  $this->Html->css('animsition.min.css') ?>
    <?php echo  $this->Html->css('plugin.css') ?>
    <?php echo  $this->Html->css('font-awesome.min.css') ?>
    <?php echo  $this->Html->css('custom.css') ?>
    <?php echo  $this->Html->css('responsive.css') ?>
    <link href="<?php echo $this->request->webroot; ?>css/styleless.less" rel="stylesheet/less">
    <?php echo  $this->Html->css('flaticon.css') ?>
    <?php echo  $this->Html->script('less.min.js'); ?>
    <?php echo  $this->Html->script('jquery.min.js'); ?>
    <?php echo  $this->Html->script('parallax.js'); ?>
</head>
<body>
    <?php
        if($this->fetch('title') == "Database Error"){ ?>
        <?php echo $this->element('sql_header'); ?>
        <div id="container">
            <div id="content">
                <div class="">
                <body class="error_page">
                <!--Main container sec start-->
                <div class="main_container">
                <!--Trainee top sec start-->
                    <section class="eror_sec_404">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="error_wrap">
                                        <div class="row">
                                                <div class="pera_404">
                                                    <h1>Scheduled Maintenance</h1>
                                                    <p>
                                                    We are upgrading to ensure the quality of service meets customer requirements.  We will be back in a jiffy! Call 403-800-4843 for immediate assistance.
                                                    </p>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                <!--Trainee top  sec end--> 
                </div>
                <!--Main container sec end-->
                </div>
            </div>
        <?php echo $this->element('sql_footer'); ?>
        </div>
        <?php }
        else{ ?>
            <?php echo $this->element('front_header'); ?>
        <div id="container">
            <div id="content">
                <div class="">
                <body class="error_page">
                <!--Main container sec start-->
                <div class="main_container">
                <!--Trainee top sec start-->
                    <section class="eror_sec_404">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="error_wrap">
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6">
                                                <div class="img_404"><img src="<?php echo $this->request->webroot; ?>images/404.png" class=""></div>
                                            </div>
                                            <div class="col-md-6 col-sm-6">
                                                <div class="pera_404">
                                                    <h1>Yikes!</h1>
                                                    <p>
                                                    The link you are requesting cannot be found. Please check the link to ensure its correct or check back later. </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                <!--Trainee top  sec end--> 
                </div>
                <!--Main container sec end-->
                </div>
            </div>
        <?php
            if(!empty($user))
            {
                echo $this->element('front_footer');
            }else
            {
                echo $this->element('index_footer');
            }
        ?>
        </div>
        <?php } ?>
    <?php echo  $this->Html->script('bootstrap.min.js') ?>
    <?php echo  $this->Html->script('plugin.js') ?>
    <?php echo  $this->Html->script('custom.js') ?>
    <script type="text/javascript">
        function bindEvent(selector, eventName, listener) {
            var els = document.querySelectorAll(selector);
            for (var i = 0, len = els.length; i < len; i++) {
                els[i].addEventListener(eventName, listener, false);
            }
        }

        function toggleElement(el) {
            if (el.style.display === 'none') {
                el.style.display = 'block';
            } else {
                el.style.display = 'none';
            }
        }

        function each(els, cb) {
            var i, len;
            for (i = 0, len = els.length; i < len; i++) {
                cb(els[i], i);
            }
        }

        window.addEventListener('load', function() {
            bindEvent('.stack-frame-args', 'click', function(event) {
                var target = this.dataset['target'];
                var el = document.getElementById(target);
                toggleElement(el);
                event.preventDefault();
            });

            var details = document.querySelectorAll('.stack-details');
            var frames = document.querySelectorAll('.stack-frame');
            bindEvent('.stack-frame a', 'click', function(event) {
                each(frames, function(el) {
                    el.classList.remove('active');
                });
                this.parentNode.classList.add('active');

                each(details, function(el) {
                    el.style.display = 'none';
                });

                var target = document.getElementById(this.dataset['target']);
                toggleElement(target);
                event.preventDefault();
            });

            bindEvent('.toggle-vendor-frames', 'click', function(event) {
                each(frames, function(el) {
                    if (el.classList.contains('vendor-frame')) {
                        toggleElement(el);
                    }
                });
                event.preventDefault();
            });
        });
    </script>
</body>
</html>