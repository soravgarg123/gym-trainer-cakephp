<script type="text/javascript">
function printDiv(divName) {
    var printContents = document.getElementById(divName).innerHTML;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
}
</script>
 
     <link href="<?php echo base_url(); ?>css/bootstrap.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>css/custom.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>css/responsive.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>css/animsition.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>css/flaticon.css" rel="stylesheet">
    <head>
<style type="text/css">

@page{
        size: auto A4 landscape;
        margin: 3mm;
     }

</style>
</head>
  
<div id="printableArea" style="display:none">
         <div class="container">
    	
        <div class="row">
            <div class="booking_staff_wraper">
            	<div class="col-md-12">
                	<div class="row">
                    	<div class="col-md-12">
                       	  <div class="info_print">
                            	<h2>Vivus Job</h2>
                                <div class="print_page_in">
                                    <div class="printout_page_list">
                                    	<ul>
                                        	<li>
                                            <?php foreach($all_detail as $info) { ?>
                                          		<div class="left_head"> Detail: </div>
                                        		<div class="right_detail">  
                                     
                                                </div>
                                        		<div class="clearfix"></div>
                                            </li>
                                            <li>
                                          		<div class="left_head">Daycare name: </div>
                                        		<div class="right_detail">  
                                             
                                                </div>
                                        		<div class="clearfix"></div>
                                            </li>
                                            <li>
                                          		<div class="left_head"> Address: </div>
                                        		<div class="right_detail">  
                                              
                                                </div>
                                        		<div class="clearfix"></div>
                                            </li>
                                            <li>
                                          		<div class="left_head">  Date and Time: </div>
                                        		<div class="right_detail">  
                                            
                                                </div>
                                        		<div class="clearfix"></div>
                                            </li>
                                            <li>
                                          		<div class="left_head"> Daycare Supervisors Name: </div>
                                        		<div class="right_detail">  
                                              
                                                </div>
                                        		<div class="clearfix"></div>
                                            </li>
                                             <li>
                                          		<div class="left_head"> Phone Number : </div>
                                        		<div class="right_detail">  
                                               
                                                </div>
                                        		<div class="clearfix"></div>
                                            </li>
                                        </ul>
                                        <?php
                                        }?>
                                        
                                    </div>
                                 <div class="printout_page_right">
                                    <img src="images/map.jpg" class="img-responsive">
                                 </div>
                                 </div>
                        	</div> 
                            <div class="clearfix"></div>
                  		</div>
                    
                 
                	</div>
                
             
               
                
                
            </div>
            <div class="clearfix"></div>
        </div>
        
    </div>
 </div>   
    
   
   
</div>
<?php $this->load->view('user_header'); ?>
  <div class="page_title_wrapper">
      <div class="container">
          <div class="row">
              <div class="col-md-8">
                    <h2>print Information</h2>
              
       
</div>
</div>
</div>
</div>
                <div class="container">

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <!-- left column -->
                        <div class="col-md-12">
                            <!-- general form elements -->
                            <div class="box box-primary row inner_form_wrapper">
                                
                                <!-- /.box-header -->
                                <!-- form start -->
                                
                                    
                                    <div class="col-md-4">
                                                                            
                                             <div class="box-body">
                                            <?php foreach($all_detail as $info) { ?>
                                               <div class="form-group">   
                                               <label for="exampleInputEmail1">Employer Name:</label>
                                                <input type="text" name="employer_username" value="<?php echo $info['employer_username'] ?>" class="form-control" readonly>

                                               </div>
                                                <div class="form-group">   
                                               <label for="exampleInputEmail1">Employee Name:</label>
                                                <input type="text" name="employer_username" value="<?php echo $info['employee_username'] ?>" class="form-control" readonly>

                                               </div>
                                              <div class="form-group">   
                                               <label for="exampleInputEmail1">daycare Name:</label>
                                                <input type="text" name="daycare_name" value="<?php echo $info['daycare_name'] ?>" class="form-control" readonly>

                                               </div>
                                               <div class="form-group"> 
                                                 <label for="exampleInputEmail1">daycare Location:</label> 
                                               <textarea name="daycare_location"  class="form-control" id="add_info" readonly><?php echo $info['daycare_location'] ?></textarea>
                                               </div></div></div>
                                                <div class="col-md-4">
                                                                            
                                             <div class="box-body">
                                                <div class="form-group"> 
                                                 <label for="exampleInputEmail1">Job Reuest Information:</label> 
                                               <textarea name="add_info" readonly class="form-control" id="add_info"><?php echo $info['extra_information']; ?></textarea>
                                               </div>

                                            <div class="form-group">
                                                  <label for="exampleInputEmail1">Date:</label>                                      
                                              <input type="text" name="accept_date" value="<?php echo $info['accreq_date']?>" class="form-control" readonly placeholder="Select Date">

                                             
                                                                             
                                              <?php } ?>
                                            </div>
                                        </div>
                                    
                                    </div> 

                                    
                                                                                                                                                                                              
                                    <div class="clearfix"></div>
                                     
                                    <!-- /.box-body -->

                                    <div class="box-footer">
                                     <a href ="<?php echo base_url(); ?>user/employee_login" class="btn btn-default back_botton">Back</a>
                                       <input class="btn btn-default" type="button" onclick="printDiv('printableArea')" value="Print Form" />
                                 </div>
                                    
                                
                               <div class="clearfix"></div>
                                <!-- /.box-body -->

                            </div><!-- /.box -->
                        </div>
                        <!--/.col (left) -->
                    </div>   <!-- /.row -->
                  <!-- Main content -->
                   
           </section>
                <!-- /.content -->

        </div>
                
                
         
        <!-- </div> -->

<?php $this->load->view('user_footer'); ?>

<script type="text/javascript">
    $(document).ready(function(){
        $(".accept_req").click(function(){
            var attrs_id=$(this).attr('main');

            $.ajax({
                  url:"<?php echo base_url() ?>user/accept_request",
                  type:"post",
                  data:'attrs_id='+attrs_id,
                  success: function(response)
                  {
                   // location.reload();                
                   // $('#clearfix').load('<?php echo base_url() ?>user/employer_main_page');
                   // window.location.href="<?php echo base_url() ?>user/view_request_page";
                  }

              });

        });
    });
</script>
<script type="text/javascript">
    $('#accept_date').datetimepicker({
    format: 'YYYY-MM-DD h:mm A'
    //this.autoclose = false;
    });
</script>


