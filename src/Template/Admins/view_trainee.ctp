        <div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                     <h2>View Trainee</h2>   
                        <!-- <h5>Welcome Jhon Deo , Love to see you back. </h5> -->
                       
                    </div>
                </div>
                 <!-- /. ROW  -->
                 <hr />
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            View Trainee
                        </div>
                        <div class="panel-body">
                                <h4>Personal Information</h4>
                                <table class="table table-striped table-bordered table-hover">
                                    <tbody>
                                        <tr>
                                            <td><b>Name</b></td>
                                            <td><?php echo $trainees[0]['trainee_name']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>Gender</b></td>
                                            <td><?php echo $trainees[0]['trainee_gender']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>Age</b></td>
                                            <td><?php echo $trainees[0]['trainee_age']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>Skills</b></td>
                                            <td><?php echo $trainees[0]['trainee_skills']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>Email Id</b></td>
                                            <td><?php echo $trainees[0]['trainee_email']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>Country</b></td>
                                            <td><?php if(!empty($trainees[0]['country_name'])) echo $trainees[0]['country_name']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>State</b></td>
                                            <td><?php if(!empty($trainees[0]['state_name'])) echo $trainees[0]['state_name']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>City</b></td>
                                            <td><?php if(!empty($trainees[0]['city_name'])) echo $trainees[0]['city_name']; ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                        </div>
                    </div>
                </div>
            </div>
                <!-- /. ROW  -->
            </div>
               
            </div>
             <!-- /. PAGE INNER  -->
            </div>



