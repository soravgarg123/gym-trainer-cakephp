<?php include "trainer_dashboard.php"; ?>

<!--Main container sec start-->
<section class="wallet_dash_body">
<div class="main_container">
<div class=" customer_report_main trainer_report_main">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12 col-sm-12">
        <div class="session_setails_sec">
          <div class="heading_payment_main">
            <h2> Search</h2>
          </div>
          <form onsubmit="return checkValidation()" method="post" id="report_form" action="<?php echo $this->request->webroot; ?>trainers/reports">
          <div class="session_content">
            <div class="transaction_date_wrap">
              <div class="form-group">
                <input type="radio" id="f-option" checked name="selector" class="seacrh_type" main="date" value="date">
                <label for="f-option"> From</label>
                <div class="check">
                  <div class="inside"></div>
                </div>
              </div>
              <div class="form-group">
                <div class='input-group date' id='datetimepicker2'>
                  <input type='text' readonly value="<?php echo $this->Flash->render('start_date') ?>" class="form-control datepicker" id="start_date" name="from_date" />
                  <span class="input-group-addon"> <span class="glyphicon glyphicon-calendar"></span> </span> <span class="divider">to</span> </div>
              </div>
              <div class="form-group">
                <div class='input-group date' id='datetimepicker2'>
                  <input type='text' readonly id="end_date" value="<?php echo $this->Flash->render('end_date') ?>" class="form-control datepicker" name="to_date" />
                  <span class="input-group-addon"> <span class="glyphicon glyphicon-calendar"></span> </span> </div>
              </div>
            </div>
            <div class="transaction_date_wrap year_wrap">
              <div class="form-group">
                <input type="radio" id="f-option1" name="selector" class="seacrh_type" main="week" value="week">
                <label for="f-option1">Weekly</label>
                <div class="check">
                  <div class="inside"></div>
                </div>
              </div>
              <div class="form-group">
                <div class="input-group date">
                  <select class="form-control" id="week" name="week">
                    <option value="1">1 Week</option>
                    <option value="2">2 Week</option>
                    <option value="3">3 Week</option>
                    <option value="4">4 Week</option>
                  </select>
                  <div class="icon_arrow"><i class="fa fa-caret-down"></i></div>
                </div>
              </div>
              <div class="form-group">
                <input type="radio" id="f-option3" name="selector" class="seacrh_type" main="month" value="month">
                <label for="f-option3">Monthly</label>
                <div class="check">
                  <div class="inside"></div>
                </div>
              </div>
              <div class="form-group">
                <div class="input-group date">
                  <select class="form-control" id="month" name="month">
                    <option value="01">January</option>
                    <option value="02">Feburary</option>
                    <option value="03">March</option>
                    <option value="04">April</option>
                    <option value="05">May</option>
                    <option value="06">June</option>
                    <option value="07">July</option>
                    <option value="08">August</option>
                    <option value="09">September</option>
                    <option value="10">October</option>
                    <option value="11">November</option>
                    <option value="12">December</option>
                  </select>
                  <div class="icon_arrow"><i class="fa fa-caret-down"></i></div>
                </div>
              </div>
              <div class="form-group">
                <input type="radio" id="f-option4" name="selector" class="seacrh_type" main="annual" value="annual">
                <label for="f-option4">Annual</label>
                <div class="check">
                  <div class="inside"></div>
                </div>
              </div>
              <div class="form-group">
                <div class="input-group date">
                  <select class="form-control" id="annual" name="annual">
                    <?php for ($i= 2010; $i < 2101; $i++) { ?>
                         <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                    <?php } ?>
                  </select>
                  <div class="icon_arrow"><i class="fa fa-caret-down"></i></div>
                </div>
              </div>
            </div>
            <div class="statement_button">
              <button type="reset" class="clear">clear</button>
              <button type="submit" name="filter_report">Get Statement</button>
            </div>
          </div>
         </form>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6 col-sm-6">
        <div class="session_setails_sec wallet_balance">
          <div class="heading_payment_main">
            <h2>My Total Earnings</h2>
          </div>
          <div class="session_content total_earn">
            <p>Current Balance</p>
            <div class="cloud_box">
              <div class="cloud"><i class="fa fa-usd"></i></div>
            </div>
            <?php
                if(empty($total_wallet_ammount)){
                    $wallet_balance =  "0";
                }
                else
                {
                    $wallet_balance =  $total_wallet_ammount[0]['total_ammount'];
                }
            ?>
            <div class="rate_box">$0</div>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-sm-6">
        <div class="session_setails_sec wallet_balance">
          <div class="heading_payment_main">
            <h2> Wallet balance</h2>
          </div>
          <ul class="session_content">
            <p>Current Balance</p>
            <div class="cloud_box">
              <div class="cloud"><i class="fa fa-money"></i></div>
            </div>
            <div class="rate_box">$<?php echo round($wallet_balance,2); ?></div>
          </ul>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-12 col-md-12">
        <div class="customer_report_table_sec">
          <div class="cr_table_head">
            <div class="row">
              <div class="col-md-6 col-sm-6">
                <h2>custom packages sold</h2>
              </div>
              <div class="col-md-6 col-sm-6 text-right">
                <ul class="list_table_icon">
                  <li><a href="<?php echo $this->request->webroot; ?>trainers/getneratePDFReport/custom"><i class="fa fa-file-pdf-o"></i> </a></li>
                  <li><a href="<?php echo $this->request->webroot; ?>trainers/getnerateExcelReport/custom"> <i class="fa fa-file-excel-o"></i> </a></li>
                </ul>
              </div>
            </div>
          </div>
          <div class="cr_table_content">
            <table class="table">
              <thead >
                <tr>
                  <th>TRANS #</th>
                  <th>Customer</th>
                  <th>package name</th>
                  <th>price</th>
                  <th>date</th>
                </tr>
              </thead>
              <tbody>
              <?php if(!empty($custom_packages)) { ?>
                <?php $i = 1;
                  foreach($custom_packages as $t){ ?>
                  <tr>
                    <td><a class="txns" href="<?php echo $this->request->webroot; ?>trainers/packagepdf?id=<?php echo $t['cp_id']; ?>">SK<?php echo ($i >= 10) ? $i : "0".$i ?></a></td>                                   
                    <td><?php echo $t['trainee_name']." ".$t['trainee_lname']; ?></td>
                    <td><?php echo $t['package_name']; ?></td>
                    <td>$<?php echo $t['price']; ?></td>
                    <td><?php echo date('d F Y, h:i A', strtotime($t['created_date'])); ?></td>
                  </tr>
                <?php $i++; } ?>
              <?php } else{ ?>
                <tr><td colspan="5">No custom packages found</td></tr>
              <?php } ?>
            </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-12 col-md-12">
        <div class="customer_report_table_sec">
          <div class="cr_table_head">
            <div class="row">
              <div class="col-md-6 col-sm-6">
                <h2>rate plans packages sold</h2>
              </div>
              <div class="col-md-6 col-sm-6 text-right">
                <ul class="list_table_icon">
                  <li><a href="<?php echo $this->request->webroot; ?>trainers/getneratePDFReport/sessions"><i class="fa fa-file-pdf-o"></i> </a></li>
                  <li><a href="<?php echo $this->request->webroot; ?>trainers/getnerateExcelReport/sessions"> <i class="fa fa-file-excel-o"></i> </a></li>
                </ul>
              </div>
            </div>
          </div>
          <div class="cr_table_content">
            <table class="table">
              <thead >
                <tr>
                  <th>TRANS #</th>
                  <th>Customer</th>
                  <th>session name</th>
                  <th>price</th>
                  <th>date</th>
                </tr>
              </thead>
              <tbody>
              <?php if(!empty($appointments)) { ?>
                <?php $i = 1;
                  foreach($appointments as $t){ 
                  $totalSessions = count(unserialize($t['session_data']));
                ?>
                  <tr>
                    <td><a class="txns" href="<?php echo $this->request->webroot; ?>trainers/sessionpdf?id=<?php echo $t['appo_id']; ?>">SK<?php echo ($i >= 10) ? $i : "0".$i ?></a></td>                                   
                    <td><?php echo $t['trainee_name']." ".$t['trainee_lname']; ?></td>
                    <td><?php echo $totalSessions; ?> Sessions</td>
                    <td>$<?php echo $t['final_price']; ?></td>
                    <td><?php echo date('d F Y, h:i A', strtotime($t['created_date'])); ?></td>
                  </tr>
                <?php $i++; } ?>
              <?php } else{ ?>
                <tr><td colspan="5">Not found any rate plans sold packages</td></tr>
              <?php } ?>
            </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-12 col-md-12">
        <div class="customer_report_table_sec">
          <div class="cr_table_head">
            <div class="row">
              <div class="col-md-6 col-sm-6">
                <h2>Transactions History</h2>
              </div>
              <div class="col-md-6 col-sm-6 text-right">
                <ul class="list_table_icon">
                  <li><a href="<?php echo $this->request->webroot; ?>trainers/getneratePDFReport/txn"><i class="fa fa-file-pdf-o"></i> </a></li>
                  <li><a href="<?php echo $this->request->webroot; ?>trainers/getnerateExcelReport/txn"> <i class="fa fa-file-excel-o"></i> </a></li>
                </ul>
              </div>
            </div>
          </div>
          <div class="cr_table_content">
            <table class="table">
              <thead>
                <tr>
                  <th>TRANS #</th>
                  <th>Transaction Name</th>
                  <th>Transaction Id</th>
                  <th>Amount</th>
                  <th>Date</th>
                  <th>status</th>
                </tr>
              </thead>
              <tbody>
              <?php if(!empty($txn_details)) { ?>
                <?php $i = 1;
                  foreach($txn_details as $t){ ?>
                  <tr>
                    <td><a class="txns" href="<?php echo $this->request->webroot; ?>trainers/txnpdf?id=<?php echo $t['id']; ?>">SK<?php echo ($i >= 10) ? $i : "0".$i ?></a></td>                                   
                    <td><?php echo $t['txn_name']; ?></td>
                    <td><?php echo $t['txn_id']; ?></td>
                    <td>$<?php echo $t['total_amount']; ?></td>
                    <td><?php echo date('d F Y, h:i A', strtotime($t['added_date'])); ?></td>
                    <td>Completed</td>
                  </tr>
                <?php $i++; } ?>
              <?php } else{ ?>
                <tr><td colspan="7">You have no transactions</td></tr>
              <?php } ?>
            </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</section>
<!--Main container sec end--> 
<script type="text/javascript">
  function checkValidation()
  {
    var from_date = $('input[name="from_date"]').val();
    var to_date   = $('input[name="to_date"]').val();
    var selector  = $('input[name="selector"]:checked').val();
    if(selector == "date"){
      if(from_date == "" || to_date == ""){
        showAlert('error','Error','Please select dates');
        return false;
      }
    }
  }
</script>
