
<?php include "trainee_dashboard.php"; ?>

     <section class="trainee_dash_body">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="meal_plan_sec">
                      <!-- Tab panes -->
                      <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="home">
                        	<div class="meal_plan_heading">
                            	<div class="row">
                                	<div class="col-sm-4 mph_left">
                                    	<h2>Meal Plans</h2>
                                    </div>
                                </div>
                            </div>
                            <div class="session_content">
                            <?php if(!empty($trainer_meal_plans)) { ?>
                              <ul class="nav_tabs">
                              <?php $i = 1; foreach($trainer_meal_plans as $m) { ?>
                                <li <?php if($i == 1){echo "class='active'";}?>><a data-toggle="tab" role="tab" aria-controls="profile" title="<?php echo $m['trainer_name']." ".$m['trainer_lname']; ?>" href="#profile_<?php echo $i; ?>"><?php echo substr($m['trainer_name']." ".$m['trainer_lname'],0,11); ?></a></li>
                              <?php $i++; } ?>
                              </ul>
                              <div class="tab-content">
                              <?php $j = 1; foreach($meal_plans_details as $md) { ?>
                                <div id="profile_<?php echo $j; ?>" class="tab-pane <?php if($j == 1){echo "active";}?>" role="tabpanel">
                                  <div class="row">
                                    <div class="col-sm-12">
                                      <div class="table_meal">
                                        <table class="table table-bordered">
                                          <thead>
                                            <tr>
                                              <th></th>
                                              <th>sunday</th>
                                              <th>monday</th>
                                              <th>tuesday</th>
                                              <th>wednesday</th>
                                              <th>Thursday </th>
                                              <th>Friday </th>
                                              <th>Saturday </th>
                                            </tr>
                                          </thead>
                                          <tbody>
                                          <?php 
                                            $inner_arr = array();
                                            $inner_arr = $md; 
                                            foreach($inner_arr as $ia) { 
                                          ?>
                                            <tr>
                                              <td><?php echo $ia['meal_plan']; ?></td>
                                              <td><?php echo $ia['sunday']; ?></td>
                                              <td><?php echo $ia['monday']; ?></td>
                                              <td><?php echo $ia['tuesday']; ?></td>
                                              <td><?php echo $ia['wednesday']; ?></td>
                                              <td><?php echo $ia['thursday']; ?></td>
                                              <td><?php echo $ia['friday']; ?></td>
                                              <td><?php echo $ia['saturday']; ?></td>
                                            </tr>
                                          <?php } ?>
                                          </tbody>
                                        </table>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              <?php $j++; } ?>
                              </div>
                            <?php } else{ ?>
                              </br><div><center><h4>You have no current meal plans</h4></center></div>
                            <?php } ?>
                            </div>
                        </div>
                      </div>
                    </div>
                </div>
            </div>
        </div>
     </section>   
        
    </div>
    <!--Main container sec end-->



