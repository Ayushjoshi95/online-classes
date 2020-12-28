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
    
    //fetching recent courses (3)
    $sql="SELECT * from  courses c order by c.time_stamp desc limit 3";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) 
    {
        if($result->num_rows>0)
        {
            while($row=$result->fetch_assoc())
            {
                    $courses[$row['id']] = $row;
                    $sql = "SELECT count(id) as count from enrolled where course_id=".$row["id"];
                    if($res = $conn->query($sql))
                    {
                        if($res->num_rows)
                        {
                            $raw = $res->fetch_assoc();
                            $courses[$row['id']]['enrolled'] = $raw['count'];
                            $courses[$row['id']]['amount']=$raw['count']*$row['price'];
                        } 
                    }
                    
                    
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
        <!-- Small boxes (Stat box) -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-primary">
                        <div class="inner">
                            <h3><?=$total_users?></h3>

                            <p>User Registrations</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-green">
                        <div class="inner">
                            <h3><?=$enrolled_users?></h3>

                            <p>Enrolled Users</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-users"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3   col-6">
                    <!-- small box -->
                    <div class="small-box bg-yellow">
                        <div class="inner">
                            <h3><?=$nonEnrolled_users?></h3>

                            <p>User Registrations</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-users"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->

                <!-- ./col -->
            </div>
            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-aqua">
                        <div class="inner">
                            <h3><?=$total_trans?></h3>

                            <p>Transactions</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-exchange"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-green">
                        <div class="inner">
                            <h3><?=$sucess_trans?></h3>

                            <p>Completed Transactions</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-check"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3   col-6">
                    <!-- small box -->
                    <div class="small-box bg-red">
                        <div class="inner">
                            <h3><?=$failed_trans?></h3>

                            <p>Failed Transaction</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-exclamation"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->

                <!-- ./col -->
            </div>
            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-aqua">
                        <div class="inner">
                            <h3><?=$total_trans_amt?></h3>

                            <p>Amount</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-money"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-green">
                        <div class="inner">
                            <h3><?=$success_trans_amt?></h3>

                            <p>Success Amount</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-money"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3   col-6">
                    <!-- small box -->
                    <div class="small-box bg-red">
                        <div class="inner">
                            <h3><?=$failed_trans_amt?></h3>

                            <p>Failed Amount</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-money"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->

                <!-- ./col -->
            </div>
            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-primary">
                        <div class="inner">
                            <h3><?=$total_course?></h3>

                            <p>Total Courses</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-book"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-green">
                        <div class="inner">
                            <h3><?=$enrolled_courses?></h3>

                            <p>Enrolled Courses</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-bookmark"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3   col-6">
                    <!-- small box -->
                    <div class="small-box bg-yellow">
                        <div class="inner">
                            <h3><?=$nonEnrolled_courses?></h3>

                            <p>Non Enrolled Courses</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-bookmark-o"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->

                <!-- ./col -->
            </div>
        </div>
        <!-- /.row -->

    </section>
    <!-- Recent section -->
    <section class="content">
    <h3 class="mt-4 mb-4">Courses Overview</h3>
        <div class="row">
            <!-- /.col -->
            <?php
                if(isset($courses))
                {
                    foreach($courses as $detail)
                    {
                ?>
                            <div class="col-md-4">
                <!-- Widget: user widget style 1 -->
                <div class="card card-widget widget-user">
                    <!-- Add the bg color to the header using any of the bg-* classes -->
                    <div class="widget-user-header bg-aqua">
                        <h3 class="widget-user-username"><?=ucfirst($detail['name'])?></h3>
                        <h5 class="widget-user-desc">Rs <?=$detail['price']?> /-</h5>
                    </div>
                    <div class="widget-user-image">
                        <img class="img-circle elevation-2" src="<?=$detail['feature_image']?>" alt="Course Image">
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-sm-4 border-right">
                                <div class="description-block">
                                    <h5 class="description-header"><?=$detail['amount']?></h5>
                                    <span class="description-text">Total </span>
                                </div>
                                <!-- /.description-block -->
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-4 border-right">
                                <div class="description-block">
                                    <h5 class="description-header"><?=$detail['enrolled']?></h5>
                                    <span class="description-text">Enrolled</span>
                                </div>
                                <!-- /.description-block -->
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-4">
                                <div class="description-block">
                                    <h5 class="description-header"><?=$detail['duration']?></h5>
                                    <span class="description-text">Months</span>
                                </div>
                                <!-- /.description-block -->
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                    </div>
                </div>
                <!-- /.widget-user -->
            </div>
                
                <?php
                    }
                }
            
            ?>
          
        </div>
        <!-- /.col -->
    </section>
    <section class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-7">
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
                                        <th>Order ID</th>
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