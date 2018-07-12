        <div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                     <h2>View Trainer</h2>   
                        <!-- <h5>Welcome Jhon Deo , Love to see you back. </h5> -->
                       
                    </div>
                </div>
                 <!-- /. ROW  -->
                 <hr />
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            View Trainer
                        </div>
                        <div class="panel-body">
                            <ul class="nav nav-pills">
                                <li class="active"><a href="#personal" data-toggle="tab">Personal Informaiton</a>
                                </li>
                                <li class=""><a href="#achievements" data-toggle="tab">Achievements</a>
                                </li>
                                <li class=""><a href="#others" data-toggle="tab">Others</a>
                                </li>
                            </ul>

                            <div class="tab-content">
                                <div class="tab-pane fade active in" id="personal">
                                    <h4>Personal Information</h4>
                                    <table class="table table-striped table-bordered table-hover">
                                        <tbody>
                                            <tr>
                                                <td><b>Name</b></td>
                                                <td><?php echo $trainers[0]['trainer_name']; ?></td>
                                            </tr>
                                            <tr>
                                                <td><b>Gender</b></td>
                                                <td><?php echo $trainers[0]['trainer_gender']; ?></td>
                                            </tr>
                                            <tr>
                                                <td><b>Age</b></td>
                                                <td><?php echo $trainers[0]['trainer_age']; ?></td>
                                            </tr>
                                            <tr>
                                                <td><b>Skills</b></td>
                                                <td><?php echo $trainers[0]['trainer_skills']; ?></td>
                                            </tr>
                                            <tr>
                                                <td><b>Email Id</b></td>
                                                <td><?php echo $trainers[0]['trainer_email']; ?></td>
                                            </tr>
                                            <tr>
                                                <td><b>Phone</b></td>
                                                <td><?php echo $trainers[0]['trainer_phone']; ?></td>
                                            </tr>
                                            <tr>
                                                <td><b>Country</b></td>
                                                <td><?php echo $trainers[0]['country_name']; ?></td>
                                            </tr>
                                            <tr>
                                                <td><b>State</b></td>
                                                <td><?php echo $trainers[0]['state_name']; ?></td>
                                            </tr>
                                            <tr>
                                                <td><b>City</b></td>
                                                <td><?php echo $trainers[0]['city_name']; ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="achievements">
                                    <h4>Achievements</h4>
                                     <table class="table table-striped table-bordered table-hover">
                                        <tbody>
                                            <tr>
                                                <td><b>Biography</b></td>
                                                <td><?php echo $trainers[0]['biography']; ?></td>
                                            </tr>
                                            <tr>
                                                <td><b>Certification</b></td>
                                                <td><?php echo $trainers[0]['certification']; ?></td>
                                            </tr>
                                            <tr>
                                                <td><b>Awards</b></td>
                                                <td><?php echo $trainers[0]['awards']; ?></td>
                                            </tr>
                                            <tr>
                                                <td><b>Accomplishments</b></td>
                                                <td><?php echo $trainers[0]['accomplishments']; ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="others">
                                    <h4>Others</h4>
                                    <table class="table table-striped table-bordered table-hover">
                                        <tbody>
                                            <tr>
                                                <td><b>Location</b></td>
                                                <td><?php echo $trainers[0]['location']; ?></td>
                                            </tr>
                                            <tr>
                                                <td><b>Credentials</b></td>
                                                <td><?php echo $trainers[0]['credentials']; ?></td>
                                            </tr>
                                            <tr>
                                                <td><b>Interests & Hobby</b></td>
                                                <td><?php echo $trainers[0]['interests_hobby']; ?></td>
                                            </tr>
                                            <tr>
                                                <td><b>Hobby</b></td>
                                                <td><?php echo $trainers[0]['hobby']; ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                <!-- /. ROW  -->
        </div>
               
            </div>
             <!-- /. PAGE INNER  -->
            </div>



