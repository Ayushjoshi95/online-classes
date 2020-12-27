<?php
require_once 'header.php';
require_once 'navbar.php';
require_once 'left-navbar.php';
 
    //fetching total website users defined by type =0
    $sql="SELECT count(id) as count from users where type=0";
    if($result=$conn->query($sql))
    {
        if($result->num_rows>0)
        {
            $row=$result->fetch_assoc(); 
            $total_users=$row['count']; 
        }
 
    } 
    //fetching total students which are enrolled in courses
    $sql="SELECT count(distinct(u_id)) as count from enrolled";
    if($result=$conn->query($sql))
    {
        if($result->num_rows>0)
        {
            $row=$result->fetch_assoc(); 
            $enrolled_users=$row['count']; 
        }
 
    }

    //calculating total users which are not enrolled in courses
    $nonEnrolled_users=$total_users-$enrolled_users;
    

    //fetching total course 
    $sql="SELECT count(id) as count from courses ";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) 
    { 
        if($result->num_rows>0)
        {
            $row=$result->fetch_assoc(); 
            $total_course=$row['count']; 
        }
    }
    //fetching course with   enrollment
    $sql="SELECT count(distinct(course_id)) as count from enrolled";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) 
    { 
        if($result->num_rows>0)
        {
            $row=$result->fetch_assoc(); 
            $enrolled_courses=$row['count']; 
        }
    }
    //calculating course with no enrollment
    $nonEnrolled_courses = $total_course-$enrolled_courses;

    //fetching transaction amount 
    $sql="SELECT sum(amt) as count from transactions";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) 
    {
        if($result->num_rows>0)
        {
            $row=$result->fetch_assoc(); 
            $total_trans_amt=$row['count']; 
        }
    }
    //fetching successfull transaction amount 
    $sql="SELECT sum(amt) as count from transactions where status='TXN_SUCCESS'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) 
    {
        if($result->num_rows>0)
        {
            $row=$result->fetch_assoc(); 
            $success_trans_amt=$row['count']; 
        }
    }
    //fetching failed transaction amount 
    $sql="SELECT sum(amt) as count from transactions where status!='TXN_SUCCESS'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) 
    {
        if($result->num_rows>0)
        {
            $row=$result->fetch_assoc(); 
            $failed_trans_amt=$row['count']; 
        }
    }
    //fetching successfull transaction
    $sql="SELECT count(id) as count from transactions where status='TXN_SUCCESS'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) 
    {
        if($result->num_rows>0)
        {
            $row=$result->fetch_assoc(); 
            $sucess_trans=$row['count']; 
        }
    }
    //fetching failed transactions
    $sql="SELECT count(id) as count from transactions where status!='TXN_SUCCESS'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) 
    {
        if($result->num_rows>0)
        {
            $row=$result->fetch_assoc(); 
            $failed_trans=$row['count']; 
        }
    }
    
    //fetching total transaction
    $sql="SELECT count(id) as count from transactions";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) 
    {
        if($result->num_rows>0)
        {
            $row=$result->fetch_assoc(); 
            $total_trans=$row['count']; 
        }
    }
    
    //fetching recent transaction (10)
    $sql="SELECT t.*, c.name as course_name, u.name as user_name from transactions t , courses c, users u where t.service_id=c.id and t.u_id=u.id order by t.time_stamp desc limit 10";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) 
    {
        if($result->num_rows>0)
        {
            while($row=$result->fetch_assoc())
            {
                    $trans[] = $row;
            }
             
        }
    }   

?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Dashboard
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
        </ol>
    </section>

    <!-- overview section -->
    <section class="content">
        <!-- Info boxes -->
        <!-- user overiew section starts -->
        <div class="row">
            <section class="content-header" style="margin-bottom: 10px;">
                <h1>
                    Users Overview
                </h1>
            </section>
            <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-aqua"><i class="fa fa-users"></i></span>

                    <div class="info-box-content">

                        <span class="info-box-text">Total Users</span>
                        <span class="info-box-number"><?=$total_users?></span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-green"><i class="fa fa-users"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Enrolled Users</span>
                        <span class="info-box-number"><?=$enrolled_users;?></span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <!-- fix for small devices only -->
            <div class="clearfix visible-sm-block"></div>

            <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-yellow"><i class="fa fa-users"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text" style="font-size:13px">Non Enrolled Users</span>
                        <span class="info-box-number"><?=$nonEnrolled_users?></span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- user overiew section ends -->
        <!-- transaction overiew section starts -->
        <div class="row">
            <section class="content-header" style="margin-bottom: 10px;">
                <h1>
                    Transaction Overview
                </h1>
            </section>
            <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-teal"><i class="fa fa-exchange"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Total Transactions </span>
                        <span class="info-box-number"><?=$total_trans?></span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-green"><i class="fa fa-check"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text" style="font-size:13px">Completed Transactions</span>
                        <span class="info-box-number"><?=$sucess_trans?></span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->


            <!-- fix for small devices only -->
            <div class="clearfix visible-sm-block"></div>

            <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-red"><i class="fa fa-exclamation"></i></span>

                    <div class="info-box-content">

                        <span class="info-box-text">Failed Transactions</span>
                        <span class="info-box-number"><?=$failed_trans?></span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
        </div>
        <div class="row">
            <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-teal"><i class="fa fa-money"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Total Amount </span>
                        <span class="info-box-number"><?=$total_trans_amt?></span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-green"><i class="fa fa-money"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text" style="font-size:13px">Success Amount</span>
                        <span class="info-box-number"><?=$success_trans_amt?></span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->


            <!-- fix for small devices only -->
            <div class="clearfix visible-sm-block"></div>

            <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-red"><i class="fa fa-money"></i></span>

                    <div class="info-box-content">

                        <span class="info-box-text">Failed Amount</span>
                        <span class="info-box-number"><?=$failed_trans_amt?></span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- transaction overiew section ends -->
        <!-- course overiew section starts -->
        <div class="row">
            <section class="content-header" style="margin-bottom: 10px;">
                <h1>
                    Courses Overview
                </h1>
            </section>
            <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-aqua"><i class="fa fa-book"></i></span>

                    <div class="info-box-content">

                        <span class="info-box-text">Total Courses</span>
                        <span class="info-box-number"><?=$total_course?></span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-green"><i class="fa fa-bookmark"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Enrolled Courses</span>
                        <span class="info-box-number"><?=$enrolled_courses;?></span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <!-- fix for small devices only -->
            <div class="clearfix visible-sm-block"></div>

            <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-yellow"><i class="fa fa-bookmark-o"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text" style="font-size:13px">Non Enrolled Courses</span>
                        <span class="info-box-number"><?=$nonEnrolled_courses?></span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
        </div>
    </section>
<!-- Recent section -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Recent Transactions</h3>

                            <div class="box-tools">
                                <div class="input-group input-group-sm" style="width: 150px;">
                                    <input type="text" name="table_search" class="form-control float-right"
                                        placeholder="Search">

                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default"><i
                                                class="fas fa-search"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body table-responsive p-0" style="height: 300px;">
                            <table class="table table-head-fixed text-nowrap">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>User</th>
                                        <th>Course</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        if(isset($trans))
                                        {
                                            foreach($trans as $details)
                                            {
                                                $class = ''; 
                                                switch($details['status'])
                                                {
                                                    case 'Pending': 
                                                        $class="label label-warning";
                                                        break;
                                                    case 'TXN_SUCCESS': 
                                                        $class="label label-success";
                                                        break;
                                                    case 'TXN_FAILURE': 
                                                        $class="label label-danger";
                                                        break;
                                                }
                                        ?>
                                                <tr>
                                                    <td><?=$details['order_id']?></td>
                                                    <td><?=$details['user_name']?></td>
                                                    <td><?=$details['course_name']?></td>
                                                    <td>
                                                        <?php
                                                            $date=date_create($detail['time_stamp']);
                                                            echo date_format($date,"M d Y");
                                                        ?>
                                                    </td>
                                                    <td><span class="<?=$class?>"><?=$details['status']?></span></td>
                                                    <td><?=$details['amt']?></td>
                                                </tr>
                                        <?php
                                            }
                                        }
                                    ?>
                                    
                                </tbody>
                            </table>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
            </div>
            <!-- /.row -->









        </div>
    </section>
</div>

<div class="control-sidebar-bg"></div>
<?php
require_once 'js-links.php';
?>