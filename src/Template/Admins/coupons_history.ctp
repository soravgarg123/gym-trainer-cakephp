        <div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                    <div class="col-md-9">
                     <h2>Coupons History</h2> 
                     </div>
                    </div>
                </div>

                 <!-- /. ROW  -->
                 <hr />
            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                             Coupons History Table
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>S.No.</th>
                                            <th>Name</th>
                                            <th>Promo Code</th>
                                            <th>Trainee</th>
                                            <th>Discount</th>
                                            <th>Validity</th>
                                            <th>Used Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php $i = 1;
                                    foreach($voucher_history as $vh) { ?>
                                    <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $vh['name']; ?></td>
                                    <td><?php echo $vh['vh_promo_code']; ?></td>
                                    <td><?php echo $vh['trainee_name']; ?></td>
                                    <td>
                                    <?php
                                        if($vh['type'] == "Percent")
                                        {
                                            echo $vh['discount']."%";
                                        }
                                        else
                                        {
                                            echo "$".$vh['discount'];
                                        }
                                    ?>
                                    </td>
                                    <td><?php echo $vh['validity_date']; ?></td>
                                    <td><?php echo date('d F Y, h:i A', strtotime($vh["vh_added_date"])); ?></td>
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


