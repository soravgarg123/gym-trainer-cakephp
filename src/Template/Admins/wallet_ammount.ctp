        <div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                    <div class="col-md-9">
                     <h2>Users Wallet Amount</h2> 
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
                             Users Wallet Amount Table
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>S.No.</th>
                                            <th>User Type</th>
                                            <th>User Name</th>
                                            <th>Total Wallet Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php $i = 1;
                                    foreach($wallet_amt as $wa) { ?>
                                    <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo ucwords($wa['user_type']); ?></td>
                                    <td>
                                    <?php
                                    if($wa['user_type'] == "trainer") {
                                        echo $wa['trainer_name'];
                                    }else{
                                        echo $wa['trainee_name'];
                                    } ?>
                                    </td>
                                    <td>$<?php echo $wa['total_ammount']; ?></td>
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








