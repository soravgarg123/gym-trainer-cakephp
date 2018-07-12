        <div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                    <div class="col-md-9">
                     <h2>Block IP Address</h2> 
                     </div>
                     <div class="col-md-3">  
                    <a href="javascript:void(0);" data-toggle="modal" data-target="#myModal" style="float:right;" class="btn btn-primary"><i class="fa fa-plus"> Block Ip</i></a>   
                    </div>
                    </div>
                </div>

                <!-- Modal Start -->
                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Block IP Address</h4>
                          </div>
                          <div class="modal-body">
                            <?php echo $this->Custom->successMsg(); ?>
                            <?php echo $this->Custom->errorMsg(); ?>
                            <?php echo $this->Custom->loadingImg(); ?>
                            <div class="col-md-12">                        
                                <div class="col-md-4">
                                  IP Address
                              </div>
                              <div class="col-md-8">
                                <input type="text" class="form-control" id="ip_address" />
                          </div>
                        </div>
                           </div></br>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="button" id="submit-btn" class="btn btn-primary">Submit</button>
                          </div>
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
                             Block IP Address Table
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>S.No.</th>
                                            <th>IP Address</th>
                                            <th>Status</th>
                                            <th>Added Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                   <?php $i = 1; 
                                        foreach($blockip as $t)
                                        { ?>
                                        <tr id="row_<?php echo $t['id']; ?>">
                                            <td><?php echo $i ;?></td>
                                            <td><?php echo $t['ip_address']; ?></td>
                                            <td>
                                            <?php if($t['ip_status'] == 0)
                                                {
                                                    echo "Blocked";
                                                }
                                                else
                                                {
                                                    echo "Unblock";
                                                }
                                            ?>
                                            </td>
                                            <td><?php echo date('d F, h:i A', strtotime($t["ip_added_date"])); ?></td>
                                            <td>
                                                <?php
                                                     if($t['ip_status'] == 1)
                                                        { ?>
                                                          <a href="<?php echo $this->request->webroot; ?>admins/blockIps/<?php echo base64_encode($t['id']); ?>" title="Click To Block"><i class="fa fa-check-circle"></i></a> |
                                                      <?php }
                                                      else
                                                        { ?>
                                                          <a href="<?php echo $this->request->webroot; ?>admins/unblockIps/<?php echo base64_encode($t['id']); ?>" title="Click To Unblock"><i class="fa fa-times"></i></a> |
                                                <?php } ?>
                                                <a href="javascript:void(0);" class="delete" title="Delete Block IP" main="<?php echo $t['id']; ?>"><i class="fa fa-trash-o"></i></a> 
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
            var table = ['Block_ips'];
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

<!-- IP Address Add Script Start -->

<script type="text/javascript">
    $(document).ready(function(){
    $('#submit-btn').click(function(){
        var ip = $('#ip_address').val();
        var RegE = /^\d{1,3}.\d{1,3}.\d{1,3}.\d{1,3}$/;
          if(!ip.match(RegE))
              {
                $("div#error_msg").html("<center><i class='fa fa-times'> Please Enter Valid IP Address ! </i></center>").show();
                $("div#success_msg").hide();
              }
          else
              {
                $("div#error_msg").hide();
                $('img#loading-img').show();
                $.ajax({
                url:"<?php echo $this->request->webroot; ?>admins/addIpAddress",
                type:"post",
                data:{ip : ip},   
                dataType : "json",                 
                success: function(data){
                     $('img#loading-img').hide();
                    if(data.message != "")
                    {
                        $('#ip_address').val("");
                        $("div#success_msg").html("<center><i class='fa fa-check'> IP Address Blocked Successfully </i></center>");
                        $("div#success_msg").show();
                        $("div#error_msg").hide();
                        setTimeout(function(){ window.location.reload(1); }, 2000);
                    }
                    else
                    {
                        $("div#error_msg").html("<center><i class='fa fa-times'>  Something is Wrong Please Try Again !</i></center>");
                        $("div#error_msg").show();
                        $("div#success_msg").hide();
                    }
                    
                }
                });
            }
    });
    });
</script>

<!-- IP Address Add Script End -->


