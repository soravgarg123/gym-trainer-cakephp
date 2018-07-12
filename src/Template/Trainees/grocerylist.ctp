
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
                                    	<h2>Grocery List</h2>
                                    </div>
                                </div>
                            </div>
                            <div class="session_content">
                            <?php if(!empty($trainer_grocery)) { ?>
                              <ul class="nav_tabs">
                              <?php $i = 1; foreach($trainer_grocery as $m) { ?>
                                <li <?php if($i == 1){echo "class='active'";}?>><a data-toggle="tab" role="tab" aria-controls="profile" title="<?php echo $m['trainer_name']." ".$m['trainer_lname']; ?>" href="#profile_<?php echo $i; ?>"><?php echo substr($m['trainer_name']." ".$m['trainer_lname'],0,11); ?></a></li>
                              <?php $i++; } ?>
                              </ul>
                              <div class="tab-content">
                              <?php $j = 1; foreach($grocery_details as $md) { ?>
                                <div id="profile_<?php echo $j; ?>" class="tab-pane <?php if($j == 1){echo "active";}?>" role="tabpanel">
                                  <div class="row">
                                    <div class="col-sm-12">
                                      <div class="table_meal">
                                        <table class="table table-bordered">
                                          <thead>
                                            <tr>
                                            <th></th>
                                            <th>item</th>
                                            <th>qty</th>
                                            <th>store</th>
                                        </tr>
                                          </thead>
                                          <tbody>
                                          <?php 
                                            $inner_arr = array();
                                            $inner_arr = $md; 
                                            foreach($inner_arr as $ia) { ?>
                                            <tr main="<?php echo $ia['trainee_id']; ?>" id="<?php echo $ia['row_id']; ?>">
                                                <td><div class="chk_box"><input type="checkbox" value="none" name="check<?php echo $ia['row_id']; ?>" id="checkb<?php echo $ia['row_id']; ?>" checked ><label for="checkb<?php echo $ia['row_id']; ?>"></label></div></td>
                                                <td main="item"><?php echo $ia['item']; ?></td>
                                                <td main="quantity"><?php echo $ia['quantity']; ?></td>
                                                <td main="store"><?php echo $ia['store']; ?></td>
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
                            <?php } else { ?>
                              </br><div><center><h4>Your grocery list is empty. Please hire a trainer to get started!</h4></center></div>
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



