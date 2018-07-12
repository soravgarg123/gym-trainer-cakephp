        <div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                    <div class="col-md-9">
                     <h2>All Coupons</h2> 
                     </div>
                     <div class="col-md-3">  
                    <a href="javascript:void(0);" data-toggle="modal" data-target="#myModal" style="float:right;" class="btn btn-primary"><i class="fa fa-plus"> Add Coupons</i></a>   
                    </div>
                    </div>
                </div>

                <!-- Modal Start -->
                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Coupons</h4>
                          </div>
                          <div class="modal-body">
                            <?php echo $this->Custom->errorMsg(); ?>
                            <form method="post" action="<?php echo $this->request->webroot; ?>admins/addCoupons" enctype="multipart/form-data">
                            <div class="col-md-12">                        
                              <div class="col-md-4">
                                  User Type
                              </div>
                              <div class="col-md-8">
                                <select class="form-control" name="voucher_user_type" id="voucher_user_type" required >
                                  <option value="">Select User Type</option>
                                  <option value="trainer">Trainer</option>
                                  <option value="trainee">Trainee</option>
                                </select>
                              </div>
                          </div></br></br>
                            <div class="col-md-12">                        
                              <div class="col-md-4">
                                  Coupon Name
                              </div>
                              <input type="hidden" id="hidden_id" name="hidden_id">
                              <div class="col-md-8">
                                <input type="text" class="form-control" id="voucher_name" name="voucher_name" required />
                              </div>
                          </div></br></br>
                          <div class="col-md-12">                        
                              <div class="col-md-4">
                                  Coupon Code
                              </div>
                              <div class="col-md-8">
                                <input type="text"  class="form-control" id="voucher_code" name="voucher_code" required />
                              </div>
                          </div></br></br>
                          <div class="col-md-12">                        
                              <div class="col-md-4">
                                  Coupon Type
                              </div>
                              <div class="col-md-8">
                                <select class="form-control" name="voucher_type" id="voucher_type" required >
                                  <option value="">Select Type</option>
                                  <option value="Percent">Percent</option>
                                  <option value="Non-Percent">Non-Percent</option>
                                </select>
                              </div>
                          </div></br></br>
                          <div class="col-md-12">                        
                              <div class="col-md-4">
                                  Set Limit
                              </div>
                              <div class="col-md-8">
                                <select class="form-control" name="no_of_time" id="no_of_time" required >
                                <?php for ($i=1; $i < 51; $i++) {  ?>
                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                <?php } ?>
                                  <option value="0">Multiple Times</option>
                                </select>
                              </div>
                          </div></br></br>
                          <div class="col-md-12">                        
                              <div class="col-md-4">
                                  Coupon Amount
                              </div>
                              <div class="col-md-8">
                                <input type="number" min="1" title="Please Enter Valid Percent" pattern="([1-9][0-9]*|0)(\.[0-9]{1,2})?$" class="form-control" id="voucher_ammount" name="voucher_ammount" required />
                              </div>
                          </div></br></br>

                          <div class="col-md-12">                        
                              <div class="col-md-4">
                                  Coupon Validity
                              </div>
                              <div class="col-md-8">
                                <input type="text" readonly class="form-control datepicker" id="voucher_validity_time" name="voucher_validity_time" required />
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
                    </div>
                <!-- Modal End -->
                 <!-- /. ROW  -->
                 <hr />
                 <?php echo $this->Flash->render('edit') ?>
            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                             Coupons Table
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>S.No.</th>
                                            <th>Name</th>
                                            <th>User</th>
                                            <th>Code</th>
                                            <th>Amount</th>
                                            <th>Limit</th>
                                            <th>Validity</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php $i = 1;
                                    foreach($coupons as $c) { ?>
                                    <tr id="row_<?php echo $c['id']; ?>">
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $c['voucher_name']; ?></td>
                                    <td><?php echo ucwords($c['voucher_user_type']); ?></td>
                                    <td><?php echo $c['voucher_code']; ?></td>
                                    <td><?php 
                                    if($c['voucher_type'] == "Percent")
                                    {
                                      echo $c['voucher_ammount']."%";
                                    }
                                    else
                                    {
                                      echo $c['voucher_ammount']."$";
                                    }
                                    ?></td>
                                    <td><?php echo $c['no_of_time']; ?></td>
                                    <td><?php echo $c['voucher_validity_time']; ?></td>
                                    <td>
                                       <a href="javascript:void(0);" class="edit" title="Edit Copuons" main="<?php echo $c['id']; ?>"><i class="fa fa-pencil"></i></a> |
                                        <a href="javascript:void(0);" class="delete" title="Delete Copuons" main="<?php echo $c['id']; ?>"><i class="fa fa-trash-o"></i></a> 
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

<!-- Delete Script Start -->

<script type="text/javascript">
    $(document).ready(function(){
    var dtable =  $('#dataTables-example').DataTable();
         $(".table").on('click','.delete',function(){
          if (confirm("Are You Sure?")) {
            var id = btoa($(this).attr('main'));
            var table = ['Vouchers'];
            $.ajax({
                    url:"<?php echo $this->request->webroot; ?>admins/delete",
                    type:"post",
                    data:{id:id, table:table},
                    dataType:"json",
                    success: function(data){
                        if(data.message == 'success')
                        {
                          dtable.row('#row_'+atob(id)).remove().draw( false );
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

<!-- Delete Script End -->

<!-- Datepicker Start -->

<script type="text/javascript">
  $(document).ready(function(){
     $('.datepicker').datepicker({
      autoclose: true,
      format : 'yyyy-mm-dd',
     }).on('changeDate', function (ev) {

    var current_date = new Date();
    var selected_date = new Date($('.datepicker').val());

    if(current_date > selected_date)
    {
      $('#submit-btn').attr('disabled',true);
      $('.datepicker').val("");
      $("div#error_msg").html("<center><i class='fa fa-times'> Validity Date Should Be Greater Then To Current Date ! </i></center>").show();
    }

    if(current_date < selected_date)
    {
      $('#submit-btn').attr('disabled',false);
      $("div#error_msg").hide();
    }
       
    });
  });
</script>

<!-- Datepicker End -->

<!-- Edit Script Start -->

<script type="text/javascript">
    $(document).ready(function(){
    $(".table").on('click','.edit',function(){
    $('#myModal').modal('show');
      var id = btoa($(this).attr('main'));
      var table = "Vouchers";
      $.ajax({
          url:"<?php echo $this->request->webroot; ?>admins/getDataById",
          type:"post",
          data:{id:id, table:table},
          dataType:"json",
          success: function(data){
            $('#voucher_user_type').val(data.message[0]['voucher_user_type']);
            $('#no_of_time').val(data.message[0]['no_of_time']);
            $('#voucher_name').val(data.message[0]['voucher_name']);
            $('#voucher_code').val(data.message[0]['voucher_code']);
            $('#voucher_ammount').val(data.message[0]['voucher_ammount']);
            $('#voucher_type').val(data.message[0]['voucher_type']);
            $('#voucher_validity_time').val(data.message[0]['voucher_validity_time']);
            $('#hidden_id').val(data.message[0]['id']);
          }
        });
      });
    });
</script>

<!-- Edit Script End --> 









