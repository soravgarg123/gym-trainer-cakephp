        <div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                    <div class="col-md-9">
                     <h2>Trainer Account</h2> 
                     </div>
                     <div class="col-md-3">  
                    </div>
                    </div>
                </div>
                 <hr />
                 <?php echo $this->Flash->render('edit') ?>
                 <?php echo $this->Flash->render('cancel') ?>
                 <?php echo $this->Flash->render('success') ?>
                 <?php echo $this->Flash->render('pending') ?>
            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                             Trainer Account Table
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>S.No.</th>
                                            <th>Trainer</th>
                                            <th>Total Ammount</th>
                                            <th>Paid Ammount</th>
                                            <th>Remaining Ammount</th>
                                            <th>Total Sessions</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php $i = 1;
                                    foreach($trainer_account as $ac) { ?>
                                    <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $ac['trainer_name']; ?></td>
                                    <td>$<?php echo number_format((float)$ac['total_ammount'], 2, '.', ''); ?></td>
                                    <td>$<?php echo number_format((float)$ac['paid_ammount'], 2, '.', ''); ?></td>
                                    <td>$<?php echo number_format((float)$ac['remaining_ammount'], 2, '.', ''); ?></td>
                                    <td><?php echo $ac['session']; ?> Session</td>
                                    <td>
                                    <?php if($ac['remaining_ammount'] > 0) { ?>
                                    <a class="pay" title="Click To Pay" href="<?php echo $this->request->webroot;  ?>admins/trainerPayment/<?php echo base64_encode($ac['trainer_account_id']); ?>">Pay</a></td>
                                    <?php } 
                                    else { 
                                        echo "No Due";
                                     } ?>
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








