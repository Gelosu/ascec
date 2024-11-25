<?php
session_start();
if(empty($_SESSION['name']))
{
	header('location:index.php');
}
include('header.php');
include('includes/connection.php');
?>

<head>
    <style>
        .sidebar-menu li.active a {
            color: #009900;
            background-color: #ffffff;
        }
        .dash-widget {
            border: 2px solid;
            border-radius: 16px;
            margin-bottom: 30px;
            padding: 20px;
            position: relative;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.5);
        }
        .dash-widget-bg1 {
            width: 65px;
            float: left;
            color: #fff;
            display: block;
            font-size: 50px;
            text-align: center;
            line-height: 65px;
            background: #009efb;
            border-radius: 50%;
            font-size: 40px;
            height: 65px;
        }
        .dash-widget-bg2 {
            width: 65px;
            float: left;
            color: #fff;
            display: block;
            font-size: 50px;
            text-align: center;
            line-height: 65px;
            background: #ffbc35;
            border-radius: 50%;
            font-size: 40px;
            height: 65px;
        }
        .dash-widget-bg3 {
            width: 65px;
            float: left;
            color: #fff;
            display: block;
            font-size: 50px;
            text-align: center;
            line-height: 65px;
            background: #9933FF;
            border-radius: 50%;
            font-size: 40px;
            height: 65px;
        }
        .dash-widget-bg4 {
            width: 65px;
            float: left;
            color: #fff;
            display: block;
            font-size: 50px;
            text-align: center;
            line-height: 65px;
            background: #55ce63;
            border-radius: 50%;
            font-size: 40px;
            height: 65px;
        }
        .dash-widget-bg5 {
            width: 65px;
            float: left;
            color: #fff;
            display: block;
            font-size: 50px;
            text-align: center;
            line-height: 65px;
            background: #ff3333;
            border-radius: 50%;
            font-size: 40px;
            height: 65px;
        }

        .dash-widget-info span i {
            width: 16px;
            background: #fff;
            border-radius: 50%;
            color: #666666;
            font-size: 9px;
            height: 16px;
            line-height: 16px;
            text-align: center;
            margin-left: 5px;
        }
        .dash-widget-info > span.widget-title1 {
            background: #009efb;
            color: #fff;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 13px;
        }
        .dash-widget-info > span.widget-title2 {
            background: #ffbc35;
            color: #fff;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 13px;
        }
        .dash-widget-info > span.widget-title3 {
            background: #9933FF;
            color: #fff;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 13px;
        }
        .dash-widget-info > span.widget-title4 {
            background: #55ce63;
            color: #fff;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 13px;
        }
        .dash-widget-info > span.widget-title5 {
            background: #ff3333;
            color: #fff;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 13px;
        }
    </style>
</head>


<div class="sidebar" id="sidebar">
            <div class="sidebar-inner slimscroll">
                <div id="sidebar-menu" class="sidebar-menu">
                    <?php
                    
                    if($_SESSION['role']==1){?>
                    <ul>
                        
                        <li class="active">
                            <a href="dashboard.php"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a>
                        </li>
                        
						<li>
                            <a href="doctors.php"><i class="fa fa-user-md"></i> <span>Counselors</span></a>
                        </li>
                    
                        <li>
                            <a href="patients.php"><i class="fa fa-wheelchair"></i> <span>Patients</span></a>
                        </li>
                        <li>
                            <a href="appointments.php"><i class="fa fa-calendar"></i> <span>Appointments</span></a>
                        </li>
                        <li>
                            <a href="schedule.php"><i class="fa fa-calendar-check-o"></i> <span>Counselors Schedule</span></a>
                        </li>
                        <li>
                            <a href="departments.php"><i class="fa fa-hospital-o"></i> <span>Services</span></a>
                        </li>
                        <li>
                            <a href="employees.php"><i class="fa fa-user"></i> <span>Employees</span></a>
                        </li>
												                       
                    </ul>
                <?php } else {?>
                    <ul>
                        
                        <li class="active">
                            <a href="dashboard.php"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a>
                        </li>
                        <li>
                            <a href="doctors.php"><i class="fa fa-user-md"></i> <span>Doctors</span></a>
                        </li>
                        <li>
                            <a href="patients.php"><i class="fa fa-wheelchair"></i> <span>Patients</span></a>
                        </li>
                        <li>
                            <a href="appointments.php"><i class="fa fa-calendar"></i> <span>Appointments</span></a>
                        </li>
                        <li>
                            <a href="schedule.php"><i class="fa fa-calendar-check-o"></i> <span>Doctor Schedule</span></a>
                        </li>
                        <li>
                            <a href="departments.php"><i class="fa fa-hospital-o"></i> <span>Departments</span></a>
                        </li>
                        <li>
                            <a href="employees.php"><i class="fa fa-user"></i> <span>Employees</span></a>
                        </li>
                                                                       
                    </ul>
                <?php } ?>
                </div>
            </div>
      </div>





        <div class="page-wrapper">
            <div class="content">
                <div class="row">
                    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                        <div class="dash-widget" style="background-color: #CCE5FF;">
							<span class="dash-widget-bg1"><i class="fa fa-stethoscope" aria-hidden="true"></i></span>
							<?php
							$fetch_query = mysqli_query($connection, "select count(*) as total from tbl_employee where status=1 and role=2"); 
							$doc = mysqli_fetch_row($fetch_query);
							?>
							<div class="dash-widget-info text-right">
								<h3><?php echo $doc[0]; ?></h3>
								<span class="widget-title1">
                                <a href="doctors.php" style="text-decoration: none; color: white;"> Doctors 
                                <i class="fa fa-arrow-right" aria-hidden="true"></i></a></span>
							</div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                        <div class="dash-widget" style="background-color: #FFFFCC;">
                            <span class="dash-widget-bg2"><i class="fa fa-user-o"></i></span>
                            <?php
							$fetch_query = mysqli_query($connection, "select count(*) as total from tbl_patient where status=1"); 
							$patient = mysqli_fetch_row($fetch_query);
							?>
                            <div class="dash-widget-info text-right">
                                <h3><?php echo $patient[0]; ?></h3>
                                <span class="widget-title2">
                                <a href="patients.php" style="text-decoration: none; color: white;"> Patients 
                                <i class="fa fa-arrow-right" aria-hidden="true"></i></a></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                        <div class="dash-widget" style="background-color: #E5CCFF;">
                            <span class="dash-widget-bg3"><i class="fa fa-user-md" aria-hidden="true"></i></span>
                            <?php
							$fetch_query = mysqli_query($connection, "select count(*) as total from tbl_appointment where status=1"); 
							$attend = mysqli_fetch_row($fetch_query);
							?>
                            <div class="dash-widget-info text-right">
                                <h3><?php echo $attend[0]; ?></h3>
                                <span class="widget-title3">
                                <a href="appointments.php" style="text-decoration: none; color: white;"> Appointments 
                                <i class="fa fa-arrow-right" aria-hidden="true"></i></a></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                        <div class="dash-widget" style="background-color: #CCFFCC;">
                            <span class="dash-widget-bg4"><i class="fa fa-heartbeat" aria-hidden="true"></i></span>
                            <?php
							$fetch_query = mysqli_query($connection, "select count(*) as total from tbl_patient where patient_type='OutPatient' and status=1"); 
							$outpatient = mysqli_fetch_row($fetch_query);
							?>
                            <div class="dash-widget-info text-right">
                                <h3><?php echo $outpatient[0]; ?></h3>
                                <span class="widget-title4">
                                <a href="patients.php" style="text-decoration: none; color: white;"> Out Patients 
                                <i class="fa fa-arrow-right" aria-hidden="true"></i></a></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                        <div class="dash-widget" style="background-color: #FFCCCC;">
                            <span class="dash-widget-bg5"><i class="fa fa-heartbeat" aria-hidden="true"></i></span>
                            <?php
							$fetch_query = mysqli_query($connection, "select count(*) as total from tbl_patient where patient_type='InPatient' and status=1"); 
							$inpatient = mysqli_fetch_row($fetch_query);
							?>
                            <div class="dash-widget-info text-right">
                                <h3><?php echo $inpatient[0]; ?></h3>
                                <span class="widget-title5">
                                <a href="patients.php" style="text-decoration: none; color: white;"> In Patients 
                                <i class="fa fa-arrow-right" aria-hidden="true"></i></a></span>
                            </div>
                        </div>
                    </div>
                </div>
				
				<div class="row">
                       <div class="col-12 col-md-6 col-lg-8 col-xl-8">
						<div class="card">
							<div class="card-header bg-dark">
								<h4 class="card-title d-inline-block text-light">New Patients </h4> <a href="patients.php" class="btn btn-success float-right">View all</a>
							</div>
							<div class="card-block">
								<div class="table-responsive">
									<table class="table mb-0 new-patient-table">
										<tbody>
											<?php 
											$fetch_query = mysqli_query($connection, "select * from tbl_patient limit 5");
                                        while($row = mysqli_fetch_array($fetch_query))
                                        { ?>
											<tr>
												<td>
													<img width="28" height="28" class="rounded-circle" src="assets/img/user.jpg" alt=""> 
													<h2><?php echo $row['first_name']." ".$row['last_name']; ?></h2>
												</td>
												<td><?php echo $row['email']; ?></td>
												<td><?php echo $row['phone']; ?></td>
												<?php if($row['patient_type']=="InPatient") { ?>
                                            <td><span class="custom-badge status-red"><?php echo $row['patient_type']; ?></span></td>
                                        <?php } else {?>
                                            <td><span class="custom-badge status-green"><?php echo $row['patient_type']; ?></span></td>
                                        <?php } ?>
												
											</tr>
											<?php } ?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					  <div class="col-12 col-md-6 col-lg-4 col-xl-4">
                        <div class="card member-panel">
							<div class="card-header bg-dark">
								<h4 class="card-title mb-0 text-light">Doctors</h4>
							</div>
                            <div class="card-body">
                                <ul class="contact-list">
                                	<?php 
                                	$fetch_query = mysqli_query($connection, "select * from tbl_employee where status=1 and role=2 limit 5");
                                        while($row = mysqli_fetch_array($fetch_query))
                                        {
                                        ?>
                                    <li>
                                        <div class="contact-cont">
                                            <div class="float-left user-img m-r-10">
                                                <a href="profile.html" title="John Doe"><img src="assets/img/user.jpg" alt="" class="w-40 rounded-circle"><span class="status online"></span></a>
                                            </div>
                                            <div class="contact-info">
                                                <span class="contact-name text-ellipsis"><?php echo $row['first_name']." ".$row['last_name']; ?></span>
                                                <span class="contact-date"><?php echo $row['bio']; ?></span>
                                            </div>
                                        </div>
                                    </li>
                                    <?php } ?>
                                </ul>
                            </div>
                            <div class="card-footer text-center bg-white">
                                <a href="doctors.php" class="text-muted">View all Doctors</a>
                            </div>
                        </div>
                    </div>
				</div>
				
            </div>
            
        </div>
    
 <?php 
 include('footer.php');
?>