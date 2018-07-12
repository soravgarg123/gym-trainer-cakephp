<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset() ?>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<title>
		Virtual TrainR Admin
	</title>
	<link href="<?php echo $this->request->webroot; ?>img/favicon.ico" rel="shortcut icon">
	<link href="<?php echo $this->request->webroot; ?>admin_assets/css/bootstrap.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link href="<?php echo $this->request->webroot; ?>admin_assets/js/morris/morris-0.4.3.min.css" rel="stylesheet" />
    <link href="<?php echo $this->request->webroot; ?>admin_assets/css/custom.css" rel="stylesheet" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    <link href="<?php echo $this->request->webroot; ?>admin_assets/js/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
	<?php echo  $this->Html->script('jquery.min.js') ?>
	<script src="<?php echo $this->request->webroot; ?>player/jwplayer.js"></script>
	<link href="<?php echo $this->request->webroot; ?>admin_assets/datepicker/bootstrap-datepicker.css" rel="stylesheet" />
	

	<?php echo  $this->fetch('meta') ?>
	<?php echo  $this->fetch('css') ?>
	<?php echo  $this->fetch('script') ?>
</head>
<body>  
	<?php 
		$session = $this->request->session();
	    $user_data = $session->read('Auth.User');
    ?>
	<?php 
	if(!empty($user_data) && $user_data['user_type'] == "admin")
		{
			echo  $this->element('admin_header'); 
		}
	else
		{
			echo  $this->element('admin_login_header');
		}
	 ?>
	 <?php 
	if(!empty($user_data) && $user_data['user_type'] == "admin")
		{
			echo  $this->element('admin_sidebar'); 
		}
	 ?>
	<?php echo  $this->fetch('content') ?>
	<?php 
	if(!empty($user_data) && $user_data['user_type'] == "admin")
		{
			echo  $this->element('admin_footer'); 
		}
	else
		{
			echo  $this->element('admin_login_footer');
		}
	 ?>

    <script src="<?php echo $this->request->webroot; ?>admin_assets/js/jquery-1.10.2.js"></script>
    <script src="<?php echo $this->request->webroot; ?>admin_assets/js/bootstrap.min.js"></script>
    <script src="<?php echo $this->request->webroot; ?>admin_assets/js/jquery.metisMenu.js"></script>
    <script src="<?php echo $this->request->webroot; ?>admin_assets/js/morris/raphael-2.1.0.min.js"></script>
    <script src="<?php echo $this->request->webroot; ?>admin_assets/js/morris/morris.js"></script>
    <script src="<?php echo $this->request->webroot; ?>admin_assets/js/custom.js"></script>
    <script src="<?php echo $this->request->webroot; ?>admin_assets/js/dataTables/jquery.dataTables.js"></script>
    <script src="<?php echo $this->request->webroot; ?>admin_assets/js/dataTables/dataTables.bootstrap.js"></script>
    <script src="<?php echo $this->request->webroot; ?>admin_assets/datepicker/bootstrap-datepicker.js"></script>
    
	</div>
</body>
</html>
