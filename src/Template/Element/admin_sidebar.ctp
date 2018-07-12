                <nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">
				<li class="text-center">
                    <img src="<?php echo $this->request->webroot; ?>admin_assets/img/find_user.png" class="user-image img-responsive"/>
					</li>
				
					
                    <li>
                        <a class="active-menu"  href="<?php echo $this->request->webroot; ?>admins/home"><i class="fa fa-dashboard fa-3x"></i> Dashboard</a>
                    </li>
                     <li>
                        <a  href="<?php echo $this->request->webroot; ?>admins/trainers"><i class="fa fa-group"></i> Trainers</a>
                    </li>
                    <li>
                        <a  href="<?php echo $this->request->webroot; ?>admins/trainees"><i class="fa fa-group"></i> Trainees</a>
                    </li>
						   <li  >
                        <a   href="<?php echo $this->request->webroot; ?>admins/blockip"><i class="fa fa-desktop"></i> Block IP</a>
                    </li>	
                      <li>
                        <a  href="<?php echo $this->request->webroot; ?>admins/latestNews"><i class="fa fa-newspaper-o"></i> Latest News</a>
                    </li>
                    <li>
                        <a  href="<?php echo $this->request->webroot; ?>admins/latestVideos"><i class="fa fa-video-camera"></i> Latest Videos </a>
                    </li>
                    <li>
                        <a  href="<?php echo $this->request->webroot; ?>admins/services"><i class="fa fa-shield"></i> Services </a>
                    </li>
                    <li>
                        <a  href="<?php echo $this->request->webroot; ?>admins/testimonials"><i class="fa fa-quote-left"></i> Testimonials </a>
                    </li>
                    <li>
                        <a  href="<?php echo $this->request->webroot; ?>admins/blogs"><i class="fa fa-plus"></i> Blogs </a>
                    </li>
                    <li>
                        <a  href="<?php echo $this->request->webroot; ?>admins/tokbox"><i class="fa fa-key"></i> Manage Tokbok Details</a>
                    </li>
                    <li>
                        <a  href="<?php echo $this->request->webroot; ?>admins/fees"><i class="fa fa-money"></i> Manage Fees </a>
                    </li>
                    <li>
                        <a  href="<?php echo $this->request->webroot; ?>admins/withdraws"><i class="fa fa-money"></i> Withdraw Requests</a>
                    </li>
                    <li>
                        <a href="javascript:void(0);"><i class="fa fa-usd"></i> Manage Plans<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="<?php echo $this->request->webroot; ?>admins/plansCategories">Plans Categories</a>
                            </li>
                            <li>
                                <a href="<?php echo $this->request->webroot; ?>admins/planSessions">Plans Sessions</a>
                            </li>
                        </ul>
                    </li>  
                    <li>
                        <a href="javascript:void(0);"><i class="fa fa-file-text-o"></i> Manage Coupons<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="<?php echo $this->request->webroot; ?>admins/allCoupons">Create Coupons</a>
                            </li>
                            <li>
                                <a href="<?php echo $this->request->webroot; ?>admins/couponsHistory">Coupons History</a>
                            </li>
                        </ul>
                    </li>
                    <!--  <li>
                        <a href="<?php echo $this->request->webroot; ?>admins/currency"><i class="fa fa-money"></i>Manage Currency </a>
                    </li>  -->
                    <li>
                        <a  href="<?php echo $this->request->webroot; ?>admins/viewCalls"><i class="fa fa-eye"></i> View Calls </a>
                    </li>
                    <li>
                        <a href="javascript:void(0);"><i class="fa fa-money"></i> Account Management<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="<?php echo $this->request->webroot; ?>admins/walletTransactions">Trainee Wallet Transactions</a>
                            </li>
                            <li>
                                <a href="<?php echo $this->request->webroot; ?>admins/walletAmmount">Users Wallet Ammount</a>
                            </li>
                            <!-- <li>
                                <a href="<?php echo $this->request->webroot; ?>admins/purchasedPlans">Purchased Plans</a>
                            </li>
                            <li>
                                <a href="<?php echo $this->request->webroot; ?>admins/trainerAccount">Trainer Account</a>
                            </li>
                            <li>
                                <a href="<?php echo $this->request->webroot; ?>admins/transactions">All Transactions</a>
                            </li> -->
                        </ul>
                    </li>
                </ul>
               
            </div>
            
        </nav>  