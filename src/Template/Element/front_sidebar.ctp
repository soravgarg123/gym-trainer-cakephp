<main class="animsition">

<!--Header sec start-->

<?php 
    $this->request->session()->start();
    $session = $this->request->session();
    $user_data = $session->read('Auth.User');
?>

<nav id="leftNavMenu" class="navmenu navmenu-default navmenu-fixed-left offcanvas" role="navigation"> <a class="navmenu-brand" href="<?php echo $this->request->webroot; ?>"><img src="<?php echo $this->request->webroot; ?>img/belibit_tv_logo.png" alt="work out equipment" class="img-responsive"></a>
  <ul class="nav navmenu-nav">
    <li>
      <div class="img_trainer">
       <?php if($user_data['user_type'] == "trainer") { ?>
            <a href="<?php echo $this->request->webroot; ?>trainers/profile"><img class="img-responsive profile-img" src="<?php echo $this->Custom->getImageSrc('uploads/trainer_profile/'.$profile_details[0]['trainer_image']) ?>"></a>
        <?php } ?>
        <?php if($user_data['user_type'] == "trainee") { ?>
            <a href="<?php echo $this->request->webroot; ?>trainees/profile"><img class="img-responsive profile-img" src="<?php echo $this->Custom->getImageSrc('uploads/trainee_profile/'.$profile_details[0]['trainee_image']) ?>"></a>
        <?php } ?>
      </div>
    </li>
    <?php if($user_data['user_type'] == "trainer") { ?>
        <li><a href="<?php echo $this->request->webroot; ?>trainers"><i class="fa fa-user"></i>Overview <i class="fa fa-chevron-left pull-right"></i></a></li>
        <li><a href="<?php echo $this->request->webroot; ?>trainers/messages"><i class="fa fa-envelope"></i>Inbox <i class="fa fa-chevron-left pull-right"></i></a></li>
        <li><a href="<?php echo $this->request->webroot; ?>trainers/appointments"><i class="fa fa-pencil-square-o"></i>Appointments <i class="fa fa-chevron-left pull-right"></i></a></li>
        <li><a href="<?php echo $this->request->webroot; ?>trainers/mytrainees"><i class="fa fa-users"></i>My Clients <i class="fa fa-chevron-left pull-right"></i></a></li>
        <li><a href="<?php echo $this->request->webroot; ?>trainers/inbox"><i class="fa fa-hdd-o"></i>V-Drive <i class="fa fa-chevron-left pull-right"></i></a></li>
        <li><a href="<?php echo $this->request->webroot; ?>trainers/photoalbum"><i class="fa fa-picture-o"></i>Photo Album <i class="fa fa-chevron-left pull-right"></i></a></li>
        <li><a href="<?php echo $this->request->webroot; ?>trainers/wallet"><i class="fa fa-google-wallet"></i>My Wallet <i class="fa fa-chevron-left pull-right"></i></a></li>
        <li><a href="<?php echo $this->request->webroot; ?>trainers/reports"><i class="fa fa-file-o"></i>Reports <i class="fa fa-chevron-left pull-right"></i></a></li>
        <li><a title="Test Call" href="javascript:void(0);" id="test_call"><i class="fa fa-phone"></i> Test Call <i class="fa fa-chevron-left pull-right"></i></a></li>
    <?php } ?>
    <?php if($user_data['user_type'] == "trainee") { ?>
        <li><a href="<?php echo $this->request->webroot; ?>trainees"><i class="fa fa-user"></i>Overview <i class="fa fa-chevron-left pull-right"></i></a></li>
        <li><a href="<?php echo $this->request->webroot; ?>trainees/messages"><i class="fa fa-envelope"></i>Inbox <i class="fa fa-chevron-left pull-right"></i></a></li>
        <li><a href="<?php echo $this->request->webroot; ?>trainees/appointments"><i class="fa fa-pencil-square-o"></i>Appointments <i class="fa fa-chevron-left pull-right"></i></a></li>
        <li><a href="<?php echo $this->request->webroot; ?>trainees/mealplans"><i class="fa fa-pencil-square-o"></i>Meal Plans <i class="fa fa-chevron-left pull-right"></i></a></li>
        <li><a href="<?php echo $this->request->webroot; ?>trainees/grocerylist"><i class="fa fa-pencil-square-o"></i>Grocery List <i class="fa fa-chevron-left pull-right"></i></a></li>
        <!-- <li><a href="<?php echo $this->request->webroot; ?>ourTrainers"><i class="fa fa-users"></i>Certified Trainers <i class="fa fa-chevron-left pull-right"></i></a></li> -->
        <li><a href="<?php echo $this->request->webroot; ?>trainees/searchTrainers"><i class="fa fa-users"></i>Search Trainers <i class="fa fa-chevron-left pull-right"></i></a></li>
        <li><a href="<?php echo $this->request->webroot; ?>trainees/inbox"><i class="fa fa-hdd-o"></i>V-Drive <i class="fa fa-chevron-left pull-right"></i></a></li>
        <li><a href="<?php echo $this->request->webroot; ?>trainees/photoalbum"><i class="fa fa-picture-o"></i>Photo Album <i class="fa fa-chevron-left pull-right"></i></a></li>
        <li><a href="<?php echo $this->request->webroot; ?>trainees/wallet"><i class="fa fa-google-wallet"></i>My Wallet <i class="fa fa-chevron-left pull-right"></i></a></li>
        <li><a href="<?php echo $this->request->webroot; ?>trainees/reports"><i class="fa fa-file-o"></i>Reports <i class="fa fa-chevron-left pull-right"></i></a></li>
        <li><a title="Test Call" href="javascript:void(0);" id="test_call"><i class="fa fa-phone"></i> Test Call <i class="fa fa-chevron-left pull-right"></i></a></li>
    <?php } ?>
  </ul>
</nav>

<header class="header_sec inner_header" id="header" data-spy="affix" data-offset-top="5">
  <div class="header_top">
    <div class="container-fluid">
      <div class="ht_left">
        <button type="button" class="btn navbar-toggle" id="leftSideBarMenu" data-autohide= "true" data-toggle="offcanvas" data-target="#leftNavMenu" data-canvas="body"> <span> <i class="fa fa-align-center"></i></span> </button>
      </div>
      <div class="ht_middle">
        <div class="slide_text">
          <ul>
            <li><a href=""> <i class="fa fa-refresh"></i> </a></li>
            <li><a href="javascript:void(0);"> <i class="fa fa-times"></i> </a></li>
            <!-- <li><a href="javascript:void(0);"><marquee> Your next scheduled appointment with andre begins in 18:34 HRS ** @ 19340 walters rd, saskatoon, sk. *** </marquee></a></li> -->
          </ul>
        </div>
      </div>
      <div class="ht_right">
        <ul>
          <li>
             <div class="mobile_search"><i class="fa fa-search"></i></div>
              <div class="input-group mobile_view">
                <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)" placeholder="Find <?php echo ($user_data['user_type'] == "trainer") ? "Trainees" : "Trainers" ?>">
                <span class="input-group-addon"><i class="fa fa-search"></i></span> </div>
          </li>
          <li> <span class="icon_tip"><?php if(isset($notifications)) { echo $notifications; } else { echo "0"; } ?></span> 
          <?php if($user_data['user_type'] == "trainer") { ?>
            <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" title="Notifications" href="<?php echo $this->request->webroot; ?>trainers/notifications"><i class="fa fa-bell"></i> </a>
           <div class="dropdown-menu notification">
                <div class="list_drop">
            <ul>
            <?php 
            if(!empty($noti_data)){
            foreach($noti_data as $nd) { ?>
              <li><a href="<?php echo $this->request->webroot; ?>trainers/notifications">
                <div class="notifi_inner">
                  <div class="noti_img">
                    <img class="profile-img" src="<?php echo $this->Custom->getImageSrc('uploads/trainee_profile/'.$nd['trainee_image']) ?>">
                  </div>
                  <div class="niti_text">
                    <p><?php echo ucwords($nd['trainee_name']." ".$nd['trainee_lname']." ".$nd['noti_message']); ?></p>
                  </div>
                  <div class="clearfix"></div>
                </div></a>
              </li>
            <?php } } else { ?>
              </br><li><center><h4>You have no new notifications</h4></center></li>
            <?php } ?>
           
            </ul>
           
            </div>
             <div class="see_all">
                  <ul><li><a href="<?php echo $this->request->webroot; ?>trainers/notifications">See all</a></li><ul>
            </div>
            </div>
          <?php } ?>
            <?php if($user_data['user_type'] == "trainee") { ?>
            <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" title="Notifications" href="<?php echo $this->request->webroot; ?>trainees/notifications"><i class="fa fa-bell"></i></a>
             <div class="dropdown-menu notification">
              <div class="list_drop">
            <ul>
            <?php 
            if(!empty($noti_data)){
            foreach($noti_data as $nd) { ?>
              <li><a href="<?php echo $this->request->webroot; ?>trainees/notifications">
                <div class="notifi_inner">
                  <div class="noti_img">
                    <img class="profile-img" src="<?php echo $this->Custom->getImageSrc('uploads/trainer_profile/'.$nd['trainer_image']) ?>">
                  </div>
                  <div class="niti_text">
                    <p><?php echo ucwords($nd['trainer_name']." ".$nd['trainer_lname']." ".$nd['noti_message']); ?></p>
                  </div>
                  <div class="clearfix"></div>
                </div></a>
              </li>
            <?php } } else { ?>
              </br><li><center><h4>You have no new notifications</h4></center></li>
            <?php } ?>
            
            </ul>
            </div>
            <div class="see_all">
                  <ul><li><a href="<?php echo $this->request->webroot; ?>trainees/notifications">See all</a></li><ul>
                       </div>
            <div>
          <?php } ?>
         </li>
        <li> <span class="icon_tip yellow"><?php echo (isset($messages) && !empty($messages)) ? count($messages) : "0"; ?></span> 
        <?php if($user_data['user_type'] == "trainer") { ?>
            <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" title="Notifications" href="javascript:void(0);"><i class="fa fa-envelope"></i></a> 
              <div class="dropdown-menu notification">
              <div class="list_drop">
              <ul>
              <?php 
              if(!empty($messages)){
              foreach($messages as $m) { ?>
                <li>
                  <div class="notifi_inner">
                    <div class="noti_img">
                      <img class="profile-img" src="<?php echo $this->Custom->getImageSrc('uploads/trainee_profile/'.$m['trainee_image']) ?>">
                    </div>
                    <div class="niti_text">
                      <h4><?php echo ucwords($m['trainee_name']." ".$m['trainee_lname']); ?></h4>
                      <p><?php echo $m['chat_messsage']; ?></p>
                    </div>
                    <div class="clearfix"></div>
                  </div>
                </li>
              <?php } } else { ?>
                </br><li><center><h4>You have no new messages</h4></center></li>
              <?php } ?>
              
              </ul>
              </div>
              <div class="see_all">
                  <ul><li><a href="<?php echo $this->request->webroot; ?>trainers/messages">See all</a></li><ul>
                       </div>
              </div>
          <?php } ?>
          <?php if($user_data['user_type'] == "trainee") { ?>
            <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" title="Notifications" href="javascript:void(0);"><i class="fa fa-envelope"></i></a> 
             <div class="dropdown-menu notification">
              <div class="list_drop"> 
              <ul>
              <?php 
              if(!empty($messages)){
              foreach($messages as $m) { ?>
                <li>
                  <div class="notifi_inner">
                    <div class="noti_img">
                      <img class="profile-img" src="<?php echo $this->Custom->getImageSrc('uploads/trainer_profile/'.$m['trainer_image']) ?>">
                    </div>
                    <div class="niti_text">
                      <h4><?php echo ucwords($m['trainer_name']." ".$m['trainer_lname']); ?></h4>
                      <p><?php echo $m['chat_messsage']; ?></p>
                    </div>
                    <div class="clearfix"></div>
                  </div>
                </li>
              <?php } } else { ?>
                </br><li><center><h4>You have no new messages</h4></center></li>
              <?php } ?>
              
              </ul>
             
              </div>
              <div class="see_all">
                  <ul><li><a href="<?php echo $this->request->webroot; ?>trainees/messages">See all</a></li><ul>
                       </div>
              </div>
          <?php } ?>
          </li>

          <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
            <div class="circle_img">
            <?php if($user_data['user_type'] == "trainer") { ?>
                <img class="profile-img" src="<?php echo $this->Custom->getImageSrc('uploads/trainer_profile/'.$profile_details[0]['trainer_image']) ?>">
            <?php } ?>
            <?php if($user_data['user_type'] == "trainee") { ?>
                <img class="profile-img" src="<?php echo $this->Custom->getImageSrc('uploads/trainee_profile/'.$profile_details[0]['trainee_image']) ?>">
            <?php } ?>
            </div>
            <?php if($user_data['user_type'] == "trainer") { ?>
              Hi, <?php echo (isset($profile_details[0]['trainer_name']) && (!empty($profile_details[0]['trainer_name']))) ? $profile_details[0]['trainer_name'] : $user_data['display_name'] ?> <i class="fa fa-chevron-down"></i> </a>
            <?php } ?>
            <?php if($user_data['user_type'] == "trainee") { ?>
              Hi, <?php echo (isset($profile_details[0]['trainee_name']) && (!empty($profile_details[0]['trainee_name']))) ? $profile_details[0]['trainee_name'] : $user_data['display_name'] ?> <i class="fa fa-chevron-down"></i> </a>
            <?php } ?>
            <ul class="dropdown-menu">
            <?php if($user_data['user_type'] == "trainer") { ?>
                <li><a href="<?php echo $this->request->webroot; ?>trainerProfile/<?php echo base64_encode($user_data['id']); ?>"><i class="fa fa-user"></i> My Profile</a></li>
            <?php } ?>
            <?php if($user_data['user_type'] == "trainee") { ?>
                <li><a href="<?php echo $this->request->webroot; ?>traineeProfile/<?php echo base64_encode($user_data['id']); ?>"><i class="fa fa-user"></i> My Profile</a></li>
            <?php } ?>
            <?php if($user_data['user_type'] == "trainer") { ?>
                <li><a href="<?php echo $this->request->webroot; ?>trainerProfile/<?php echo base64_encode($user_data['id']); ?>"><i class="fa fa-user"></i> My Profile</a></li>
            <?php } ?>
            <?php if($user_data['user_type'] == "trainee") { ?>
                <li><a href="<?php echo $this->request->webroot; ?>traineeProfile/<?php echo base64_encode($user_data['id']); ?>"><i class="fa fa-user"></i> My Profile</a></li>
            <?php } ?>
                <li><a href="<?php echo $this->request->webroot; ?>users/logout"><i class="fa fa-sign-out"></i> Logout</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </div>
  </div>
</header>


<!--Header sec end--> 
