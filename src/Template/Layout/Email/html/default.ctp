<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset() ?>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<title>
		Virtual TrainR
	</title>
	<link href="<?php echo $this->request->webroot; ?>img/favicon.ico" rel="shortcut icon">
	<?php echo  $this->Html->css('bootstrap.min.css') ?>
	<?php echo  $this->Html->css('animsition.min.css') ?>
	<?php echo  $this->Html->css('plugin.min.css') ?>
	<?php echo  $this->Html->css('font-awesome.min.css') ?>
	<?php echo  $this->Html->css('custom.css') ?>
	<?php echo  $this->Html->css('responsive.css') ?>
	<link href="<?php echo $this->request->webroot; ?>css/styleless.less" rel="stylesheet/less">
	<?php echo  $this->Html->script('less.min.js'); ?>
	<?php echo  $this->Html->script('modernizr.custom.28101.js'); ?>
	<?php echo  $this->Html->script('jquery.min.js'); ?>

	<?php echo $this->fetch('meta') ?>
	<?php echo $this->fetch('css') ?>
	<?php echo $this->fetch('script') ?>
</head>
<body class="mail_page">  
<main class="animsition">
	<!--Header sec start-->
    <header class="header_sec navbar-fixed-top" id="header" data-spy="affix" data-offset-top="60">
    	<div class="header_top">
        	<div class="container">
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
		      <a class="navbar-brand" href="<?php echo $this->request->webroot; ?>" target="_blank" ><img src="<?php echo $this->request->webroot; ?>img/belibit_tv_logo.png" alt="work out equipment"></a>
		    </div>
    		<div class=" mainmenu_nav navbar-right" id="top_nav">
            	<div class="heder_name">
                	<h1>
                    	<span>Virtual </span>
                    	Trainr
                    </h1>
                </div>
            </div>
            </div>
        </nav>
    </header>
    <!--Header sec end-->
	<div id="container">
        <div id="content">
            <div class="">
                <?php echo $this->fetch('content') ?>
            </div>
        </div>
     <!-- footer -->
    <?php echo  $this->Html->script('bootstrap.min.js') ?>
	<?php echo  $this->Html->script('plugin.js') ?>
	<?php echo  $this->Html->script('custom.js') ?>
	<!--Footer sec start-->
    <footer id="footer" class="footer_sec">
    	<div class="footersec_inner">
    		<div class="container">
        	<div class="row">
            	<div class="col-sm-4">
                	<div class="footer_left">
                    	<p>Copyright &copy; <?php echo date('Y'); ?></p>
                    </div>
                </div>
                <div class="col-sm-8">
                	<nav class="footer_nav">
                    	<ul>
                        	<li><a target="_blank" href="<?php echo $this->request->webroot; ?>" title="Home">Home</a></li>
                            <li><a target="_blank" href="<?php echo $this->request->webroot; ?>/learnmore" title="Learn More">Learn more </a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        </div>
    </footer>
    <!--Footer sec end-->
    </div>
</main>
</body>
</html>
