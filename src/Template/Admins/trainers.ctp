        <div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                     <h2>Trainers</h2>   
                        <!-- <h5>Welcome Jhon Deo , Love to see you back. </h5> -->
                       
                    </div>
                </div>
                 <!-- /. ROW  -->
                 <hr />
                 <?php echo $this->Flash->render('edit') ?>
            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                             Trainers Table
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>S.No.</th>
                                            <th>Name</th>
                                            <th>Email Id</th>
                                            <th>Age</th>
                                            <th>Gender</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php $i = 1; 
                                        foreach($trainers as $t)
                                        { ?>
                                        <tr id="row_<?php echo $t['user_id']; ?>">
                                            <td><?php echo $i ;?></td>
                                            <td><?php echo $t['trainer_name']; ?></td>
                                            <td><?php echo $t['trainer_email']; ?></td>
                                            <td><?php echo $t['trainer_age']; ?></td>
                                            <td><?php echo $t['trainer_gender']; ?></td>
                                            <td>
                                            <?php if($t['trainer_status'] == 0)
                                                {
                                                    echo "Blocked";
                                                }
                                                else
                                                {
                                                    echo "Unblock";
                                                }
                                            ?>
                                            </td>
                                            <td>
                                                 <?php
                                                     if($t['trainer_status'] == 1)
                                                        { ?>
                                                          <a href="<?php echo $this->request->webroot; ?>admins/blockTrainer/<?php echo base64_encode($t['user_id']); ?>" title="Click To Block"><i class="fa fa-check-circle"></i></a> |
                                                      <?php }
                                                      else
                                                        { ?>
                                                          <a href="<?php echo $this->request->webroot; ?>admins/unblockTrainer/<?php echo base64_encode($t['user_id']); ?>" title="Click To Unblock"><i class="fa fa-times"></i></a> |
                                                <?php } ?>
                                                <a href="<?php echo $this->request->webroot; ?>admins/viewTrainer/<?php echo base64_encode($t['user_id']); ?>" title="View Trainer" main="<?php echo $t['id']; ?>"><i class="fa fa-eye"></i></a> |
                                                <a href="<?php echo $this->request->webroot; ?>admins/editTrainer/<?php echo base64_encode($t['user_id']); ?>" title="Edit Trainer" ><i class="fa fa-pencil"></i></a> |
                                                <a href="javascript:void(0);" class="delete" title="Delete Trainer" main="<?php echo $t['user_id']; ?>"><i class="fa fa-trash-o"></i></a> |
                                                <a href="javascript:void(0);" class="pdf" title="Export PDF File" main="<?php echo $t['user_id']; ?>"><i class="fa fa-file-pdf-o"></i></a> 
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
            var table = ['Trainers','Users'];
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

