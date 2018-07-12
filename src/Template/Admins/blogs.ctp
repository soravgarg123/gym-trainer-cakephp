        <div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                    <div class="col-md-9">
                     <h2>Blogs</h2> 
                     </div>
                     <div class="col-md-3">  
                    <a href="javascript:void(0);" data-toggle="modal" data-target="#myModal" style="float:right;" class="btn btn-primary"><i class="fa fa-plus"> Add Blogs</i></a>   
                    </div>
                    </div>
                </div>

                <!-- Modal Start -->
                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Blogs</h4>
                          </div>
                          <div class="modal-body">
                            <?php echo $this->Custom->errorMsg(); ?>
                            <form method="post" action="<?php echo $this->request->webroot; ?>admins/addBlogs" enctype="multipart/form-data">
                            <div class="col-md-12">                        
                              <div class="col-md-4">
                                  Title
                              </div>
                              <div class="col-md-8">
                                <input type="text" class="form-control" name="lt_title" required />
                              </div>
                          </div></br></br>
                          <div class="col-md-12">                        
                              <div class="col-md-4">
                                  Image
                              </div>
                              <div class="col-md-8">
                                <input type="file" id="lt_attachement" class="form-control" name="lt_attachement" required />
                              </div>
                          </div></br></br>
                          <div class="col-md-12">                        
                              <div class="col-md-4">
                                  Content
                              </div>
                              <div class="col-md-8">
                                <textarea required name="lt_content" class="form-control" rows="3"></textarea>
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
                             Latest News Table
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>S.No.</th>
                                            <th>Title</th>
                                            <th>Image</th>
                                            <th>Content</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                   <?php $i = 1; 
                                        foreach($blogs as $t)
                                        { ?>
                                        <tr id="row_<?php echo $t['id']; ?>">
                                            <td><?php echo $i ;?></td>
                                            <td><?php echo $t['lt_title']; ?></td>
                                            <td>
                                              <img src="<?php echo $this->Custom->getImageSrc('uploads/blogs/'.$t['lt_attachement']) ?>" style="width:100px;height:100px;">
                                            </td>
                                            <td><?php echo $t['lt_content']; ?></td>
                                            <td>
                                                <a href="javascript:void(0);" class="delete" title="Delete Blogs" main="<?php echo $t['id']; ?>"><i class="fa fa-trash-o"></i></a> 
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
            var table = ['Latest_things'];
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

<!-- Image Validation Start -->
<script type="text/javascript">
  $(document).ready(function(){
  $('#lt_attachement').change(function(){
        var file_name = $(this).val();
        var split_extension = file_name.split(".").pop();
        if(split_extension.toLowerCase() == 'jpg' || split_extension.toLowerCase() == 'jpeg' || split_extension.toLowerCase() == 'png' || split_extension.toLowerCase() == 'tif' || split_extension.toLowerCase() == 'gif' || split_extension.toLowerCase() == 'bmp')
            {
              $("div#error_msg").hide();
            }
        else
            {
              var file = this.files[0];
              $('#lt_attachement').val(file.value = null);
              $("div#error_msg").html("<center><i class='fa fa-times'> You Can Upload Only .jpg, jpeg, png, tif, gif, bmp files ! </i></center>").show();
            }
      });
  });
</script>
<!-- Image Validation End -->

