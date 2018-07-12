
        <!-- /. NAV SIDE  -->
        <div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                     <h2>Admin Dashboard</h2>   
                        <h5>Welcome Admin </h5>
                    </div>
                </div>              
                 <!-- /. ROW  -->
                  <hr />
                <div class="row">
                <a href="<?php echo $this->request->webroot; ?>admins/trainers">
                <div class="col-md-4 col-sm-6 col-xs-6">           
          			<div class="panel panel-back noti-box">
                          <span class="icon-box bg-color-red set-icon">
                              <i class="fa fa-group"></i>
                          </span>
                          <div class="text-box" >

                              <p class="main-text"> <?php echo $total_trainers; ?> </p>
                              <p class="text-muted">Trainers</p>
                          </div>
                       </div>
          		     </div>
                </a>
                <a href="<?php echo $this->request->webroot; ?>admins/trainees">
                    <div class="col-md-4 col-sm-6 col-xs-6">           
        			     <div class="panel panel-back noti-box">
                        <span class="icon-box bg-color-green set-icon">
                            <i class="fa fa-group"></i>
                        </span>
                        <div class="text-box" >
                            <p class="main-text"> <?php echo $total_trainees; ?> </p>
                            <p class="text-muted">Trainees</p>
                        </div>
                     </div>
      		    </div>
              </a>
              <a href="<?php echo $this->request->webroot; ?>admins/viewCalls">
                <div class="col-md-4 col-sm-6 col-xs-6">           
                <div class="panel panel-back noti-box">
                          <span class="icon-box bg-color-red set-icon">
                              <i class="fa fa-phone"></i>
                          </span>
                          <div class="text-box" >

                              <p class="main-text"> <?php echo $all_calls; ?> </p>
                              <p class="text-muted">Calls</p>
                          </div>
                       </div>
                   </div>
                </a>
                <a href="<?php echo $this->request->webroot; ?>admins/purchasedPlans">
                <div class="col-md-4 col-sm-6 col-xs-6">           
                <div class="panel panel-back noti-box">
                          <span class="icon-box bg-color-green set-icon">
                              <i class="fa fa-money"></i>
                          </span>
                          <div class="text-box" >

                              <p class="main-text"> $<?php  if(!empty($total_earning)) { echo $total_earning[0]['total_ammount']; } else { echo "0";} ?> </p>
                              <p class="text-muted">Total Earning</p>
                          </div>
                       </div>
                   </div>
                </a>
                <!-- <a href="<?php echo $this->request->webroot; ?>admins/purchasedPlans">
                <div class="col-md-4 col-sm-6 col-xs-6">           
                <div class="panel panel-back noti-box">
                          <span class="icon-box bg-color-red set-icon">
                              <i class="fa fa-money"></i>
                          </span>
                          <div class="text-box" >

                              <p class="main-text"> $<?php  if(!empty($total_earning)) { echo $total_earning[0]['total_service_fee']; } else { echo "0";} ?> </p>
                              <p class="text-muted">Total Service Fee</p>
                          </div>
                       </div>
                   </div>
                </a> -->
                <a href="<?php echo $this->request->webroot; ?>admins/trainerAccount">
                <div class="col-md-4 col-sm-6 col-xs-6">           
                <div class="panel panel-back noti-box">
                          <span class="icon-box bg-color-red set-icon">
                              <i class="fa fa-money"></i>
                          </span>
                          <div class="text-box" >

                              <p class="main-text"> $<?php  if(!empty($total_earning)) { echo $total_earning[0]['remaining_ammount']; } else { echo "0";} ?> </p>
                              <p class="text-muted">Total Remianing Ammount</p>
                          </div>
                       </div>
                   </div>
                </a>
                <a href="<?php echo $this->request->webroot; ?>admins/transactions">
                <div class="col-md-4 col-sm-6 col-xs-6">           
                <div class="panel panel-back noti-box">
                          <span class="icon-box bg-color-green set-icon">
                              <i class="fa fa-money"></i>
                          </span>
                          <div class="text-box" >

                              <p class="main-text"> $<?php  if(!empty($total_earning)) { echo $total_earning[0]['paid_ammount']; } else { echo "0";} ?> </p>
                              <p class="text-muted">Total Paid Ammount</p>
                          </div>
                       </div>
                   </div>
                </a>
                

                    <!-- <div class="col-md-4 col-sm-6 col-xs-6">           
			<div class="panel panel-back noti-box">
                <span class="icon-box bg-color-blue set-icon">
                    <i class="fa fa-bell-o"></i>
                </span>
                <div class="text-box" >
                    <p class="main-text">240 New</p>
                    <p class="text-muted">Notifications</p>
                </div>
             </div>
		     </div> -->

			</div>
                 <!-- /. ROW  -->
                <hr />                
                <div class="row">
                    <div class="col-md-6 col-sm-12 col-xs-12">           
               <!--  <span class="icon-box bg-color-blue">
                    <i class="fa fa-warning"></i>
                </span> -->
                <!-- <div class="text-box" >
                    <p class="main-text">52 Important Issues to Fix </p>
                    <p class="text-muted">Please fix these issues to work smooth</p>
                    <p class="text-muted">Time Left: 30 mins</p>
                    <hr />
                    <p class="text-muted">
                          <span class="text-muted color-bottom-txt"><i class="fa fa-edit"></i>
                               Lorem ipsum dolor sit amet, consectetur adipiscing elit gthn. 
                              Lorem ipsum dolor sit amet, consectetur adipiscing elit gthn. 
                               </span>
                    </p>
                </div> -->
		     </div>
                    
                    
                    <div class="col-md-3 col-sm-12 col-xs-12">
                        <!-- <div class="panel back-dash">
                               <i class="fa fa-dashboard fa-3x"></i><strong> &nbsp; SPEED</strong>
                             <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipiscing sit ametsit amet elit ftr. Lorem ipsum dolor sit amet, consectetur adipiscing elit. </p>
                        </div> -->
                       
                    </div>
                    <div class="col-md-3 col-sm-12 col-xs-12 ">
                        <div class="panel ">
          <!-- <div class="main-temp-back">
            <div class="panel-body">
              <div class="row">
                <div class="col-xs-6"> <i class="fa fa-cloud fa-3x"></i> Newyork City </div>
                <div class="col-xs-6">
                  <div class="text-temp"> 10° </div>
                </div>
              </div>
            </div>
          </div> -->
          
        </div>
               <!--  <span class="icon-box bg-color-green set-icon">
                    <i class="fa fa-desktop"></i>
                </span> -->
                <!-- <div class="text-box" >
                    <p class="main-text">Display</p>
                    <p class="text-muted">Looking Good</p>
                </div> -->
            </div>
        </div>
    </div>
  </div>
</div>

