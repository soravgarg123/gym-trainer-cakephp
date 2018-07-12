        <div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                    <div class="col-md-9">
                     <h2>All Transactions</h2> 
                     </div>
                     <div class="col-md-3">  
                    </div>
                    </div>
                </div>
                 <hr />
            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                             All Transactions Table
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>S.No.</th>
                                            <th>Trainer</th>
                                            <th>Ammount</th>
                                            <th>Payment Type</th>
                                            <th>Transaction Id</th>
                                            <th>Payment Date</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php $i = 1;
                                    foreach($transactions as $t) { ?>
                                    <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $t['trainer_name']; ?></td>
                                    <td>$<?php echo $t['ammount']; ?></td>
                                    <td><?php echo $t['payment_type']; ?></td>
                                    <td><?php echo $t['txn_id']; ?></td>
                                    <td><?php echo date('d F Y, h:i A', strtotime($t["added_date"])); ?></td>
                                    <td><?php 
                                     if($t['status'] == 0)
                                     {
                                        echo "Pending";
                                     }
                                     if($t['status'] == 1)
                                     {
                                        echo "Completed";
                                     }
                                     if($t['status'] == 2)
                                     {
                                        echo "Failed";
                                     }
                                     ?></td>
                                    
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








