        <div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                    <div class="col-md-9">
                     <h2>Plans Sesions</h2> 
                     </div>
                     <div class="col-md-3">  
                    <a href="javascript:void(0);" data-toggle="modal" data-target="#myModal" style="float:right;" class="btn btn-primary"><i class="fa fa-plus"> Add Sesions</i></a>   
                    </div>
                    </div>
                </div>

                <!-- Modal Start -->
                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Plans Sesions</h4>
                          </div>
                          <div class="modal-body">
                            <?php echo $this->Custom->errorMsg(); ?>
                            <form method="post" action="<?php echo $this->request->webroot; ?>admins/addPlansSessions" >
                            <div class="col-md-12">                        
                              <div class="col-md-4">
                                  Select Plan 
                              </div>
                              <div class="col-md-8">
                                <select class="form-control" name="category_id" id="category_id" required >
                                  <option value="">Select Plan</option>
                                  <?php foreach($categories as $c) { ?>
                                    <option value="<?php echo $c['id']; ?>"><?php echo $c['pc_name']; ?></option>
                                  <?php } ?>
                                </select>
                              </div>
                          </div></br></br>
                          <div class="col-md-12">                        
                              <div class="col-md-4">
                                  No. Of Sessions
                              </div>
                              <input type="hidden" name="hidden_id1" id="hidden_id1">
                              <div class="col-md-8">
                                <input type="number" class="form-control" id="ps_name" name="ps_name" required />
                              </div>
                          </div></br></br>
                          <div class="col-md-12">                        
                              <div class="col-md-4">
                                  Session Price
                              </div>
                              <div class="col-md-8">
                                <input type="number" class="form-control" id="ps_price" name="ps_price" required />
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
                             Plans Sesions Table
                        </div>
                        <div class="panel-body">
                            <ul class="nav nav-pills">
                            <?php if(!empty($categories)) {
                            $i = 1; 
                            foreach($categories as $c) { ?>
                                <li class="<?php if($i == 1) echo "active"; ?>"><a href="#<?php echo $c['pc_name']; ?>" data-toggle="tab"><?php echo ucwords($c['pc_name']); ?></a>
                                </li>
                            <?php $i++; } } ?>
                            </ul>

                            <div class="tab-content">
                              <?php if(!empty($categories)) {
                              $i = 1; 
                                foreach($categories as $c1) { ?>
                                  <div class="tab-pane fade <?php if($i == 1) echo "active in"; ?>" id="<?php echo $c1['pc_name']; ?>">
                                    <h4><?php echo ucwords($c1['pc_name']); ?></h4>
                                  <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>S.No.</th>
                                            <th>Plan Name</th>
                                            <th>Service Fee</th>
                                            <th>Session Name</th>
                                            <th>Session Price</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php if(!empty($sessions)) {
                                    $i = 1; 
                                    foreach($sessions as $c) { 
                                      if($c1['id'] == $c['category_id']) {
                                    ?>
                                    <tr id="row_<?php echo $c['sess_id']; ?>">
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $c['pc_name']; ?></td>
                                    <td>$ <?php echo $c['pc_service_fee']*$c['ps_name']; ?></td>
                                    <td><?php echo $c['ps_name']; ?> Session</td>
                                    <td>$ <?php echo $c['ps_price']; ?></td>
                                    <td>
                                       <a href="javascript:void(0);" class="edit" title="Edit Category" main="<?php echo $c['sess_id']; ?>"><i class="fa fa-pencil"></i></a> |
                                        <a href="javascript:void(0);" class="delete" title="Delete Category" main="<?php echo $c['sess_id']; ?>"><i class="fa fa-trash-o"></i></a> 
                                    </td>
                                    </tr>
                                    <?php $i++;  } } } ?>
                                   
                                    </tbody>
                                </table>
                                </div>
                                </div>
                                <?php $i++; } } ?>

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
      var table = ['Plans_sessions'];
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
      $.ajax({
              url:"<?php echo $this->request->webroot; ?>admins/getSessionData",
              type:"post",
              data:{id:id},
              dataType:"json",
              success: function(data){
                $('#category_id').val(data.message[0]['category_id']);
                $('#ps_name').val(data.message[0]['ps_name']);
                $('#ps_price').val(data.message[0]['ps_price']);
                $('#hidden_id1').val(data.message[0]['id']);
              }
          });
       
      });
    });
</script>

<!-- Edit Script End -->






