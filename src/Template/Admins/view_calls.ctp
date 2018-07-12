        <div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                    <div class="col-md-9">
                     <h2>View Calls</h2> 
                     </div>
                     <div class="col-md-3">  
                    </div>
                    </div>
                </div>
                 <hr />
                 <?php echo $this->Flash->render('edit') ?>
            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                             View Calls Table
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>S.No.</th>
                                            <th>Trainer</th>
                                            <th>Trainee</th>
                                            <th>Time</th>
                                            <th>Session</th>
                                            <th>Ammount</th>
                                            <th>Call Date</th>
                                            <!-- <th>Payment Status</th> -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php $i = 1;
                                    foreach($all_calls as $ac) { ?>
                                    <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $ac['trainer_name']; ?></td>
                                    <td><?php echo $ac['trainee_name']; ?></td>
                                    <td><?php echo $ac['time']; ?></td>
                                    <td><?php echo $ac['used_session']; ?></td>
                                    <td>$<?php echo $ac['total_ammount']; ?></td>
                                    <td><?php echo date('d F Y, h:i A', strtotime($ac["added_date"])); ?></td>
                                    <!-- <td>
                                     <?php
                                      if($ac['status'] == 0) { 
                                        echo "Pending";
                                      }
                                      if($ac['status'] == 1) { 
                                        echo "Completed";
                                      }
                                     ?>
                                    </td> -->
                                    </tr>

                                    <?php $i++; } ?>
                                    </tbody>
                                </table>
                            </div>
                            
                        </div>
                    </div>
                    <!--End Advanced Tables -->
                </div>
            </div>
                <!-- /. ROW  -->
        </div>
               
            </div>
             <!-- /. PAGE INNER  -->
            </div>








