        <div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                    <div class="col-md-9">
                     <h2>Purchased Plans</h2> 
                     </div>
                     <div class="col-md-3">  
                    <!-- <a href="javascript:void(0);" data-toggle="modal" data-target="#myModal" style="float:right;" class="btn btn-primary"><i class="fa fa-plus"> Add Money Order</i></a>    -->
                    </div>
                    </div>
                </div>

                <!-- Modal Start -->
                   <!--  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Money Order</h4>
                          </div>
                          <div class="modal-body">
                            <?php echo $this->Custom->errorMsg(); ?>
                            <form method="post" action="<?php echo $this->request->webroot; ?>admins/addMoneyOrder" enctype="multipart/form-data">
                            <div class="col-md-12">                        
                              <div class="col-md-4">
                                  Select Trainee
                              </div>
                              <input type="hidden" id="hidden_id" name="hidden_id">
                              <div class="col-md-8">
                                <select class="form-control" name="trainee" id="trainee" required >
                                  <option value="">Select Trainee</option>
                                  <?php
                                    foreach($trainees as $t) { ?>
                                    <option value="<?php echo $t['user_id']; ?>"><?php echo $t['trainee_name']; ?></option>
                                  <?php } ?>
                                </select>
                              </div>
                          </div></br></br>
                          <div class="col-md-12">                        
                              <div class="col-md-4">
                                  Select Plan
                              </div>
                              <input type="hidden" id="hidden_id" name="hidden_id">
                              <div class="col-md-8">
                                <select class="form-control" name="plan" id="plan" required >
                                  <option value="">Select Plan</option>
                                  <?php
                                    foreach($plans_categories as $pc) { ?>
                                    <option value="<?php echo $pc['pc_name']; ?>" main="<?php echo $pc['id']; ?>"><?php echo $pc['pc_name']; ?></option>
                                  <?php } ?>
                                </select>
                              </div>
                          </div></br></br>
                          <div class="col-md-12">                        
                              <div class="col-md-4">
                                  Select Session
                              </div>
                              <div class="col-md-8">
                                <select class="form-control" name="sessions" id="sessions" required >
                                  <option value="">Select Session</option>
                                </select>
                              </div>
                          </div></br></br>
                          <div id="hidden_div" style="display:none;">
                            <div class="col-md-12">                        
                              <div class="col-md-4">
                                  Price
                              </div>
                              <div class="col-md-8">
                                <input type="text" readonly name="price" id="price" class="form-control">
                              </div>
                          </div></br></br>
                          <div class="col-md-12">                        
                              <div class="col-md-4">
                                  Service Fee
                              </div>
                              <div class="col-md-8">
                                <input type="text" readonly name="service_fee" id="service_fee" class="form-control">
                              </div>
                          </div></br></br>
                          <input type="hidden" id="session_id" name="session_id">
                          </div>
                          <div class="col-md-12">                        
                              <div class="col-md-4">
                                  Money Order No.
                              </div>
                              <div class="col-md-8">
                                <input type="text" name="order_no" id="order_no" class="form-control">
                              </div>
                          </div></br></br>
                          </div></br>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" id="submit-btn" class="btn btn-primary">Submit</button>
                          </div>
                          </form>
                        </div>
                      </div>
                    </div> -->
                <!-- Modal End -->
                 <!-- /. ROW  -->
                 <hr />
                 <?php echo $this->Flash->render('edit') ?>
            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                             Purchased Plans Table
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>S.No.</th>
                                            <th>Trainee</th>
                                            <th>Plan</th>
                                            <th>Price</th>
                                            <th>Service Fee</th>
                                            <th>Transaction Id</th>
                                            <th>Payment Type</th>
                                            <th>Payment Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php $i = 1;
                                    foreach($sessions_data as $c) { ?>
                                    <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $c['trainee_name']; ?></td>
                                    <td><?php echo $c['plan']; ?></td>
                                    <td>$<?php echo $c['price']; ?></td>
                                    <td>$<?php echo $c['service_fee']; ?></td>
                                    <td><?php echo $c['txn_id']; ?></td>
                                    <td><?php echo $c['payment_type']; ?></td>
                                    <td><?php echo date('d F, Y', strtotime($c["added_date"])); ?></td>
                                    <td>
                                     <?php
                                      if($c['status'] == 0) {  ?>
                                        <a href="javascript:void(0);" main="<?php echo base64_encode($c['admin_session_id']); ?>" class="pending_payment" title="Click To Mark Completed">Pending</a>
                                    <?php }
                                      if($c['status'] == 1) { 
                                        echo "Completed";
                                      }
                                      if($c['status'] == 2) { 
                                        echo "Failed";
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
             <!-- /. PAGE INNER  -->
            </div>

<!-- Select Plan Script Start -->

<script type="text/javascript">
  $(document).ready(function(){
    $('body').on('change','#plan',function(){
    $('#hidden_div').hide();
      var id = btoa($('#plan option:selected').attr('main'));
      var table = "Plans_sessions";
      $.ajax({
              url:"<?php echo $this->request->webroot; ?>admins/getSessions",
              type:"post",
              data:{id : id,table : table},   
              dataType : "json",  
              beforeSend: function() {
                  $('.loading').show();
                  $('.loading_icon').show();
               },               
              success: function(data){
                  $('.loading').hide();
                  $('.loading_icon').hide();
                  if(data.message != ""){
                  var sessions = data.message;
                  var i;
                  var option;
                  option += '<option value="">Select Sessions</option>';
                  for(i = 0; i < sessions.length; i++)
                   {
                      option += '<option main="'+sessions[i]["id"]+'" value="'+sessions[i]["ps_name"]+'">' + sessions[i]["ps_name"] + ' Session</option>';
                   }
                   $('#sessions').html(option);
                  }
              }
          });      
    });
  });
</script>

<!-- Select Plan Script End -->

<!-- Session Details Start -->  

<script type="text/javascript">
  $('document').ready(function(){
    $('body').on('change','#sessions',function(){
    $('#hidden_div').hide();
      var id = btoa($('#sessions option:selected').attr('main'));
       $.ajax({
              url:"<?php echo $this->request->webroot; ?>admins/getSessionData",
              type:"post",
              data:{id : id},   
              dataType : "json",  
              beforeSend: function() {
                  $('.loading').show();
                  $('.loading_icon').show();
               },               
              success: function(data){
                  $('.loading').hide();
                  $('.loading_icon').hide();
                  $('#price').val("$" + data.message[0]['ps_price']);
                  $('#service_fee').val("$" + data.message[0]['pc_service_fee']);
                  $('#session_id').val(data.message[0]['sess_id']);
                  $('#hidden_div').show();

              }
          });   
    });
  });
</script>

<!-- Session Details End --> 

<!-- Change Payment Status Start -->

<script type="text/javascript">
  $(document).ready(function(){
    $('body').on('click','.pending_payment',function(){
      var id = $(this).attr('main');
      if (confirm("Are You Sure?")) {
      $.ajax({
              url:"<?php echo $this->request->webroot; ?>admins/chanegPaymentStatus",
              type:"post",
              data:{id:id},
              dataType:"json",
              success: function(data){
                  if(data.message == "success")
                  {
                    window.location.reload();
                  }
              }
          });
        }
        else{
          return false;
        }
    });
  });
</script>

<!-- Change Payment Status End -->







