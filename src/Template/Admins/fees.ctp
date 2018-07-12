        <div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                    <div class="col-md-9">
                     <h2>Manage Fees</h2> 
                     </div>
                     <div class="col-md-3">  
                    </div>
                    </div>
                </div>

                <!-- Modal Start -->
                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Manage Fees</h4>
                          </div>
                          <div class="modal-body">
                            <?php echo $this->Custom->errorMsg(); ?>
                            <form method="post" action="<?php echo $this->request->webroot; ?>admins/manageFees">
                            <div class="col-md-12">                        
                              <div class="col-md-4">
                                  Transaction Fee
                              </div>
                              <div class="col-md-8">
                                <input type="number" min="1" max="99" class="form-control" name="txn_fee" id="txn_fee" required />
                              </div>
                          </div></br></br>
                          <input type="hidden" name="hidden_id" id="hidden_id" >
                          <div class="col-md-12">                        
                              <div class="col-md-4">
                                  Description
                              </div>
                              <div class="col-md-8">
                                <textarea required name="description" id="description" class="form-control" rows="3"></textarea>
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
                             Manage Fees
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>S.No.</th>
                                            <th>Transaction Fee</th>
                                            <th>Type</th>
                                            <th>Description</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      <?php $i = 1; 
                                        foreach($fees as $t)
                                        { ?>
                                        <tr>
                                            <td><?php echo $i ;?></td>
                                            <td><?php echo $t['txn_fee']; ?>%</td>
                                            <td><?php echo $t['type']; ?></td>
                                            <td><?php echo $t['description']; ?></td>
                                            <td>
                                                <a href="javascript:void(0);" class="edit" title="Edit" main="<?php echo $t['id']; ?>"><i class="fa fa-edit"></i></a> 
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


<!-- Edit Script Start -->

<script type="text/javascript">
    $(document).ready(function(){
    $(".table").on('click','.edit',function(){
    $('#myModal').modal('show');
      var id = btoa($(this).attr('main'));
      var table = "Fees";
      $.ajax({
              url:"<?php echo $this->request->webroot; ?>admins/getDataById",
              type:"post",
              data:{id:id, table:table},
              dataType:"json",
              success: function(data){
                $('#description').val(data.message[0]['description']);
                $('#txn_fee').val(data.message[0]['txn_fee']);
                $('#hidden_id').val(data.message[0]['id']);
              }
          });
       
      });
    });
</script>

<!-- Edit Script End -->




