        <div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                    <div class="col-md-9">
                     <h2>Plans Categories</h2> 
                     </div>
                     <div class="col-md-3">  
                    <a href="javascript:void(0);" data-toggle="modal" data-target="#myModal" style="float:right;" class="btn btn-primary"><i class="fa fa-plus"> Add Categories</i></a>   
                    </div>
                    </div>
                </div>

                <!-- Modal Start -->
                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Plans Categories</h4>
                          </div>
                          <div class="modal-body">
                            <?php echo $this->Custom->errorMsg(); ?>
                            <form method="post" action="<?php echo $this->request->webroot; ?>admins/addPlansCategories" >
                            <div class="col-md-12">                        
                              <div class="col-md-4">
                                  Plan Name
                              </div>
                              <div class="col-md-8">
                                <input type="text" class="form-control" name="pc_name" id="pc_name" required />
                              </div>
                          </div></br></br>
                          <div class="col-md-12">                        
                              <div class="col-md-4">
                                  Plan Title
                              </div>
                              <div class="col-md-8">
                                <input type="text" class="form-control" name="pc_title" id="pc_title" required />
                              </div>
                          </div></br></br>
                          <div class="col-md-12">                        
                              <div class="col-md-4">
                                  Plan Service Fees
                              </div>
                              <input type="hidden" name="hidden_id" id="hidden_id">
                              <input type="hidden" name="hidden_cat" id="hidden_cat">
                              <div class="col-md-8">
                                <input type="number"  class="form-control" id="pc_service_fee" name="pc_service_fee" required />
                              </div>
                          </div>
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
                             Plans Categories Table
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>S.No.</th>
                                            <th>Plan Name</th>
                                            <th>Plan Title</th>
                                            <th>Plan Service Fee</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php $i = 1; 
                                    foreach($categories as $c) { ?>
                                    <tr id="row_<?php echo $c['id']; ?>">
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $c['pc_name']; ?></td>
                                    <td><?php echo $c['pc_title']; ?></td>
                                    <td>$ <?php echo $c['pc_service_fee']; ?></td>
                                    <td>
                                       <a href="javascript:void(0);" class="edit" title="Edit Category" main="<?php echo $c['id']; ?>"><i class="fa fa-pencil"></i></a> |
                                        <a href="javascript:void(0);" class="delete" title="Delete Category" main="<?php echo $c['id']; ?>"><i class="fa fa-trash-o"></i></a> 
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
      var table = ['Plans_categories'];
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

<!-- Edit Script Start -->

<script type="text/javascript">
    $(document).ready(function(){
    $(".table").on('click','.edit',function(){
    $('#myModal').modal('show');
      var id = btoa($(this).attr('main'));
      var table = "Plans_categories";
      $.ajax({
              url:"<?php echo $this->request->webroot; ?>admins/getDataById",
              type:"post",
              data:{id:id, table:table},
              dataType:"json",
              success: function(data){  
                $('#pc_name').val(data.message[0]['pc_name']);
                $('#pc_title').val(data.message[0]['pc_title']);
                $('#hidden_cat').val(data.message[0]['pc_name']);
                $('#pc_service_fee').val(data.message[0]['pc_service_fee']);
                $('#hidden_id').val(data.message[0]['id']);
              }
          });
       
      });
    });
</script>

<!-- Edit Script End -->




