        <div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                    <div class="col-md-9">
                     <h2>Manage Withdraw Requests</h2> 
                     </div>
                     <div class="col-md-3">  
                    </div>
                    </div>
                </div>

                <!-- Paypal Modal Start -->
                    <div class="modal fade" id="paypal_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Manage Withdraw Requests</h4>
                          </div>
                          <div class="modal-body">
                            <?php echo $this->Custom->errorMsg(); ?>
                            <form action="<?php echo PAYPAL_FORM_LIVE_URL; ?>" method="post">
                            <div class="col-md-12">                        
                              <div class="col-md-4">
                                  Trainer Name
                              </div>
                              <div class="col-md-8">
                                <input type="text" class="form-control" id="paypal_trainer_name"  value="" />
                              </div>
                          </div></br></br>
                          <div class="col-md-12">                        
                              <div class="col-md-4">
                                  Amount
                              </div>
                              <div class="col-md-8">
                                <input type="text" class="form-control" id="paypal_amount"  value="" />
                              </div>
                          </div></br></br>
                          <div class="col-md-12">                        
                              <div class="col-md-4">
                                  Payment Type
                              </div>
                              <div class="col-md-8">
                                <input type="text" class="form-control" id="paypal_type"  value="" />
                              </div>
                          </div>
                          <input type="hidden" name="cmd" value="_xclick" />
                          <input type="hidden" name="charset" value="utf-8" />
                          <input type="hidden" name="business" id="paypal_bussiness_id" value="" />
                          <input type="hidden" name="item_name" value="Withdraw Amount" />
                          <input type="hidden" name="item_number" value="SASK#" />
                          <input type="hidden" name="amount" id="paypal_withdraw_amt" value="" />
                          <input type="hidden" name="currency_code" value="USD" />
                          <input type="hidden" name="custom" id="withdraw_id" value="" /> 
                          <input type="hidden" name="return" value="https://virtualtrainr.com/admins/paypalWithdraw" />
                          <input type="hidden" name="cancel_return" value="https://virtualtrainr.com/admins/paypalWithdrawCancel" />
                          <input type="hidden" name="notify_url" value="https://virtualtrainr.com/admins/paypalWithdrawNotify" />
                           </div></br>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" id="submit-btn" class="btn btn-primary">Pay</button>
                          </div>
                          </form>
                        </div>
                      </div>
                    </div>
                <!-- Paypal Modal End -->

                 <!-- /. ROW  -->
                 <hr />
                 <?php echo $this->Flash->render('edit') ?>
            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                             Manage Withdraw Requests
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>S.No.</th>
                                            <th>Trainer</th>
                                            <th>Withdraw Amount</th>
                                            <th>Withdraw Fee</th>
                                            <th>Final Amount</th>
                                            <th>Payment Type</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      <?php $i = 1; 
                                        foreach($withdraws as $t)
                                        { ?>
                                        <tr>
                                            <td><?php echo $i ;?></td>
                                            <td><?php echo $t['trainer_name']." ".$t['trainer_lname']; ?></td>
                                            <td>$<?php echo $t['ammount']; ?></td>
                                            <td>$<?php echo $t['withdraw_fees']; ?></td>
                                            <td>$<?php echo $t['final_withdraw_amount']; ?></td>
                                            <td>
                                              <?php
                                                switch ($t['withdraw_payment_type']) {
                                                  case '0':
                                                    echo "Paypal";
                                                    $email = 'paypal_email';
                                                    break;
                                                  case '1':
                                                    echo "Amazon";
                                                    $email = 'amazon_email';
                                                    break;
                                                  default:
                                                    echo "Direct Payment";
                                                    $email = '';
                                                    break;
                                                }
                                              ?>
                                            </td>
                                            <td>
                                              <?php
                                                switch ($t['withdraw_status']) {
                                                  case '0':
                                                    echo "Pending";
                                                    break;
                                                  case '1':
                                                    echo "Completed";
                                                    break;
                                                  case '2':
                                                    echo "Failed";
                                                    break;
                                                  default:
                                                    echo "NA";
                                                    break;
                                                }
                                              ?>
                                            </td>
                                            <td>
                                                <?php
                                                switch ($t['withdraw_status']) {
                                                  case '0': ?>
                                                    <a href='javascript:void(0);' bussinessid="<?php echo $t[$email]; ?>" trainername="<?php echo $t['trainer_name']." ".$t['trainer_lname']; ?>" main="<?php echo base64_encode($t['withdraw_id']); ?>" class='pay' type="<?php echo $t['withdraw_payment_type']; ?>" amount="<?php echo $t['final_withdraw_amount']; ?>" title='Pay'>Pay</a>
                                                  <?php break;
                                                  case '1':
                                                    echo "Completed";
                                                    break;
                                                  case '2':
                                                    echo "Failed";
                                                    break;
                                                  default:
                                                    echo "NA";
                                                    break;
                                                }
                                              ?>
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
    </div>

<script type="text/javascript">
  $(document).ready(function(){
      $(".table").on('click','.pay',function(){
      var name   = $(this).attr('trainername');
      var wid    = $(this).attr('main');
      var type   = $(this).attr('type');
      var amount = $(this).attr('amount');
      var bussinessid = $(this).attr('bussinessid');
      if(type == 0){
        $('#paypal_trainer_name').val(name);
        $('#paypal_amount').val("$" + amount);
        $('#paypal_type').val('Paypal');
        $('#withdraw_id').val(wid);
        $('#paypal_withdraw_amt').val(amount);
        $('#paypal_bussiness_id').val(bussinessid);
        $('#paypal_modal').modal('show');
      }
    });
  });
</script>




