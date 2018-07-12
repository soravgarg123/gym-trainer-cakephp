        <div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                    <div class="col-md-9">
                     <h2>Manage Toxbox Details</h2> 
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
                            <h4 class="modal-title" id="myModalLabel">Manage Toxbox Details</h4>
                          </div>
                          <div class="modal-body">
                            <?php echo $this->Custom->errorMsg(); ?>
                            <form method="post" action="<?php echo $this->request->webroot; ?>admins/manageTokboxDetails">
                            <div class="col-md-12">                        
                              <div class="col-md-4">
                                  Api Key
                              </div>
                              <div class="col-md-8">
                                <input type="number" min="1" class="form-control" name="api_key" id="api_key" required />
                              </div>
                          </div></br></br>
                          <input type="hidden" name="id" id="id" >
                          <div class="col-md-12">                        
                              <div class="col-md-4">
                                  Api Secret
                              </div>
                              <div class="col-md-8">
                              <textarea required name="api_secret" id="api_secret" class="form-control" rows="2"></textarea>
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
                             Manage Toxbox Details
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>S.No.</th>
                                            <th>Api Key</th>
                                            <th>Api Secret</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      <?php $i = 1; 
                                        foreach($tokbox as $t)
                                        { ?>
                                        <tr>
                                            <td><?php echo $i ;?></td>
                                            <td><?php echo $t['api_key']; ?></td>
                                            <td><?php echo $t['api_secret']; ?></td>
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
      $.ajax({
              url:"<?php echo $this->request->webroot; ?>admins/getToxBokDetails",
              type:"post",
              data:{id:id},
              dataType:"json",
              success: function(data){
                console.log(data);
                $('#api_secret').val(data.message[0]['api_secret']);
                $('#api_key').val(data.message[0]['api_key']);
                $('#id').val(data.message[0]['id']);
              }
          });
       
      });
    });
</script>

<!-- Edit Script End -->




