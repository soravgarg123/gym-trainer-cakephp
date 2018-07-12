        <div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                    <div class="col-md-9">
                     <h2>All Currency</h2> 
                     </div>
                     <div class="col-md-3">  
                    <a href="javascript:void(0);" data-toggle="modal" data-target="#myModal" style="float:right;" class="btn btn-primary"><i class="fa fa-plus"> Add Currency</i></a>   
                    </div>
                    </div>
                </div>

                <!-- Modal Start -->
                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Currency</h4>
                          </div>
                          <div class="modal-body">
                            <?php echo $this->Custom->errorMsg(); ?>
                            <form method="post" action="<?php echo $this->request->webroot; ?>admins/addCurrency">
                            <div class="col-md-12">                        
                              <div class="col-md-4">
                                  Currency Name
                              </div>
                              <input type="hidden" id="hidden_id" name="hidden_id">
                              <div class="col-md-8">
                                <input type="text" class="form-control" id="name" name="name" required />
                              </div>
                          </div></br></br>
                          <div class="col-md-12">                        
                              <div class="col-md-4">
                                  Currency Symbol
                              </div>
                              <div class="col-md-8">
                                <input type="text"  class="form-control" id="symbol" name="symbol" required />
                              </div>
                          </div></br></br>
                          <div class="col-md-12">                        
                              <div class="col-md-4">
                                  Currency Value
                              </div>
                              <div class="col-md-8">
                                <input type="text"  class="form-control" id="value" name="value" required />
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
                             Currency Table
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>S.No.</th>
                                            <th>Name</th>
                                            <th>Symbol</th>
                                            <th>Value</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php $i = 1;
                                    foreach($currency as $c) { ?>
                                    <tr id="row_<?php echo $c['id']; ?>">
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $c['name']; ?></td>
                                    <td><?php echo $c['symbol']; ?></td>
                                    <td><?php echo $c['value']; ?></td>
                                    <td>
                                       <a href="javascript:void(0);" class="edit" title="Edit Currency" main="<?php echo $c['id']; ?>"><i class="fa fa-pencil"></i></a> |
                                        <a href="javascript:void(0);" class="delete" title="Delete Currency" main="<?php echo $c['id']; ?>"><i class="fa fa-trash-o"></i></a> 
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
            var table = ['Currency'];
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
      var table = "Currency";
      $.ajax({
              url:"<?php echo $this->request->webroot; ?>admins/getDataById",
              type:"post",
              data:{id:id, table:table},
              dataType:"json",
              success: function(data){
                $('#name').val(data.message[0]['name']);
                $('#symbol').val(data.message[0]['symbol']);
                $('#value').val(data.message[0]['value']);
                $('#hidden_id').val(data.message[0]['id']);
              }
          });
       
      });
    });
</script>

<!-- Edit Script End -->







