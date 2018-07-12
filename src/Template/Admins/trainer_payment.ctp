        <div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                    <div class="col-md-9">
                     <h2><?php echo ucwords($trainer_acc_details[0]['trainer_name']); ?> Trainer Payment</h2> 
                     </div>
                     <div class="col-md-3">  
                    </div>
                    </div>
                </div>
                 <hr />
                 <?php echo $this->Flash->render('edit') ?>
                 <?php echo $this->Custom->errorMsg(); ?>
            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                             <?php echo ucwords($trainer_acc_details[0]['trainer_name']); ?> Trainer Payment 
                        </div>
                        <div class="panel-body">
                        <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Trainer</th>
                                            <th>Total Ammount</th>
                                            <th>Paid Ammount</th>
                                            <th>Remaining Ammount</th>
                                            <th>Total Sessions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                    <td><?php echo $trainer_acc_details[0]['trainer_name']; ?></td>
                                    <td>$<?php echo number_format((float)$trainer_acc_details[0]['total_ammount'], 2, '.', ''); ?></td>
                                    <td>$<?php echo number_format((float)$trainer_acc_details[0]['paid_ammount'], 2, '.', ''); ?></td>
                                    <td>$<?php echo number_format((float)$trainer_acc_details[0]['remaining_ammount'], 2, '.', ''); ?></td>
                                    <td><?php echo $trainer_acc_details[0]['session']; ?> Session</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                          <div class="bank_method_wrap">
                             <ul class="bank_metho_tabs" role="tablist">
                                <li role="presentation" class="active"><a href="#paypal" aria-controls="paypal" role="tab" data-toggle="tab"><span class="fa fa-paypal"></span>Paypal</a></li>
                                <li role="presentation"><a href="#amazon" aria-controls="amazon" role="tab" data-toggle="tab"><span class="fa fa-amazon"></span>Amazon</a></li>
                                <!-- <li role="presentation"><a href="#money" aria-controls="money" role="tab" data-toggle="tab"><span class="fa fa-money"></span>Money Order</a></li> -->
                              </ul>
                            
                              <!-- Tab panes -->
                              <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="paypal">
                                      
                                    <form id="paypalForm" action="<?php echo PAYPAL_FORM_LIVE_URL; ?>" method="post">
                                        <div class="form-group">
                                          <input type="text" id="final_paypal_ammount" value="<?php echo number_format((float)$trainer_acc_details[0]['remaining_ammount'], 2, '.', ''); ?>" required  class="form-control" placeholder="Ammount">
                                        </div>
                                        <div class="form-group">
                                          <input type="text" class="form-control" value="USD" readonly placeholder="Currency">
                                        </div>
                                      <input type="hidden" name="cmd" value="_xclick" />
                                      <input type="hidden" name="charset" value="utf-8" />
                                      <input type="hidden" name="business" value="<?php echo $trainer_acc_details[0]['paypal_email']; ?>" />
                                      <input type="hidden" name="item_name" value="Plans Payment" />
                                      <input type="hidden" name="item_number" value="VTRAIN" />
                                      <input type="hidden" id="paypal_ammount" name="amount" value="<?php echo number_format((float)$trainer_acc_details[0]['remaining_ammount'], 2, '.', ''); ?>" />
                                      <input type="hidden" name="currency_code" value="USD" />
                                      <input type="hidden" name="return" value="<?php echo $this->request->webroot; ?>admins/successPaypal" />
                                      <input type="hidden" name="custom" value="<?php echo base64_encode($trainer_acc_details[0]['user_id']); ?>" />
                                      <input type="hidden" name="cancel_return" value="<?php echo $this->request->webroot; ?>admins/cancelPayment" />
                                      <input type="hidden" name="bn" value="Business_BuyNow_WPS_SE" />
                                       <div class="form-group text-right">
                                       <button class="btn btn-primary" id="paypal_btn" type="button">Pay</button>
                                      </div>
                                  </form>
                                     
                                </div>
                                <div role="tabpanel" class="tab-pane" id="amazon">...</div>
                                <!-- <div role="tabpanel" class="tab-pane" id="money">
                                <form method="post" action="<?php echo $this->request->webroot; ?>trainees/moneyOrder">
                                  <div class="form-group">
                                  <textarea class="form-control" rows="4">You Tag Media & Business Solutions, Inc &#013;&#010;1950 Broad Street, Unit 209 Regina, SK S461X6 Canada</textarea>
                                  </div>
                                  <div class="form-group">
                                      <input type="text" id="money_order_ammount" readonly name="money_order_ammount" class="form-control" placeholder="Money Order Ammount">
                                  </div>
                                  <div class="form-group">
                                      <input type="text" class="form-control" value="USD" readonly placeholder="Currency">
                                  </div>
                                  <div class="form-group">
                                      <input type="text" id="order_no" required name="order_no" class="form-control" placeholder="Money Order No.">
                                  </div>
                                  <div class="form-group text-right">
                                       <button class="btn submit_btn" type="submit">Pay</button>
                                  </div>
                                  </form>
                                </div> -->
                              </div>
                              <div class="clearfix"></div>
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

<!-- Check Payment Condition Start -->

<script type="text/javascript">
    $(document).ready(function(){
        $('body').on('click','#paypal_btn',function(){
            $('div#error_msg').hide();
            var paid_ammount = parseFloat($('#final_paypal_ammount').val());
            var remaining_ammount = parseFloat("<?php echo $trainer_acc_details[0]['remaining_ammount']; ?>");
            var paypal_email = "<?php echo $trainer_acc_details[0]['paypal_email']; ?>";
            var valid = /^[-+]?[0-9]+(\.[0-9]+)?$/;

            if(paypal_email == "")
            {
              $("div#error_msg").html("<center><i class='fa fa-times'> Trainer Has Not Setup Paypal Bussiness Email Id ! </i></center>").show();
              return false;
            }

            if(!valid.test(paid_ammount) || paid_ammount > remaining_ammount || paid_ammount == 0 || paid_ammount == "")
            {
                $("div#error_msg").html("<center><i class='fa fa-times'> Please Enter Valid Ammount ! </i></center>").show();
                return false;
            }
            else
            {   
                $('#paypal_ammount').val(paid_ammount);
                $("#paypalForm").submit();
            }
        });
    });
</script> 

<!-- Check Payment Condition End -->








