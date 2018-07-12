        <div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                    <div class="col-md-9">
                     <h2>Trainee Wallet Transactions</h2> 
                     </div>
                     <div class="col-md-3">  
                    </div>
                    </div>
                </div>
                 <hr />
                 <?php echo $this->Flash->render('success') ?>
            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                             Trainee Wallet Transactions Table
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>S.No.</th>
                                            <th>Trainee</th>
                                            <th>Payment Type</th>
                                            <th>Transaction Id</th>
                                            <th>Amount</th>
                                            <th>Transaction Date</th>
                                            <th>Type</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php $i = 1;
                                    foreach($all_wallet_txn as $awt) { ?>
                                    <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $awt['trainee_name']; ?></td>
                                    <td><?php echo $awt['payment_type']; ?></td>
                                    <td><?php echo $awt['txn_id']; ?></td>
                                    <td>$<?php echo $awt['ammount']; ?></td>
                                    <td><?php echo date('d F Y, h:i A', strtotime($awt["added_date"])); ?></td>
                                    <td><?php echo $awt['txn_type']; ?></td>
                                    <td>
                                     <?php
                                      if($awt['status'] == "Completed" || $awt['status'] == "Success") { 
                                        echo "Completed";
                                      }
                                      if($awt['status'] == "Pending" || $awt['status'] == "Failure") {  ?>
                                        <a class="wallet_status" href="javascript:void(0);" main1="<?php echo base64_encode($awt['wallet_id']); ?>" main2="<?php echo base64_encode($awt['trainee_id']); ?>" main3="<?php echo base64_encode($awt['ammount']); ?>" title="Click Here To Change Status ">Pending</a>
                                      <?php } ?>
                                    </td> 
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


<!-- Change Payment Status Script Start -->  

<script type="text/javascript">
    $(document).ready(function(){
        $('.wallet_status').click(function(){
         if (confirm("Are You Sure?")) {
            var wallet_id = $(this).attr('main1');
            var trainee_id = $(this).attr('main2');
            var ammount = $(this).attr('main3');
            $.ajax({
                    url:"<?php echo $this->request->webroot; ?>admins/changeWalletPaymentStatus",
                    type:"post",
                    data:{wallet_id:wallet_id, trainee_id:trainee_id, ammount:ammount},
                    dataType:"json",
                    success: function(data){
                       window.location.reload();
                    }
                });
             }
          else{
            return false;
          }
        });
    });
</script>

<!-- Change Payment Status Script End -->








