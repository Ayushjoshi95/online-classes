<?php
    require_once 'header.php';
    require_once 'navbar.php';
    require_once 'left-navbar.php';
 
    $id=$_SESSION['id'];
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
//        if(isset($_POST['delete']))
//        {
//            $id=test_input($_POST['delete']);
//            
//            $sql="delete from gym_members where id=$id";
//            if($conn->query($sql))
//            {
//                $resTransaction=true;   
//            }
//            else
//            {
//                $errorTransaction=$conn->error;
//            }
//        }
        
       if(isset($_POST['add']))
       {
           $name=test_input($_POST['name']);
           $amt=test_input($_POST['amount']);
           $course=test_input($_POST['course']);
           $status=test_input($_POST['status']);
           
           $sql="insert into gym_members(status,name,mobile,serial_no,fathers_name,address,pkg_month,fee) values('$status','$name','$course','$serial','$fname','$addr','$pmont','$feeamt')";
           if($conn->query($sql))
           {
                $resTransaction = "true";
           }
           else
           {
               $errorTransaction=$conn->error;
           }
       }
        
        if(isset($_POST['edit']))
        {
            $name=test_input($_POST['ename']);
           $amt=test_input($_POST['eamount']);
           $course=test_input($_POST['ecourse']);
           $status=test_input($_POST['estatus']);
            $id=test_input($_POST['eid']);
            
            $sql="update gym_members set status='$status', serial_no='$serial',fathers_name='$fname',address='$addr',pkg_month='$pmont',fee='$feeamt',name='$name',mobile='$course' where id=$id";
            if($conn->query($sql))
            {
                    $resTransaction = "true";
            }
            else
            {
                $errorTransaction=$conn->error;
            }
        }
 
    }
        
    $sql="select t.*, c.name as course_name, u.name as user_name from transactions t , courses c, users u where t.service_id=c.id and t.u_id=u.id";
    $result =  $conn->query($sql);
    if($result->num_rows)
    {
        while($row = $result->fetch_assoc())
        {
            $transactionList[] = $row;
        }
    }
 
?>

<style>
    .box-body{
	overflow: auto!important;
}
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Transaction List
        </h1>
        <ol class="breadcrumb">
            <li>
                <div class="pull-right">
                    <a href="" data-toggle="tooltip" title="" class="btn btn-default" data-original-title="Rebuild"><i class="fa fa-refresh"></i></a>
                </div>
            </li>
        </ol>
    </section>

    <!-- Main content -->
      <br>
    <section class="content">
        <?php
            if(isset($resTransaction))
            {
        ?>
                <div class="alert alert-success"><strong>Success! </strong> your request successfully updated. </div> 
        <?php
            }
            else if(isset($errorTransaction))
            {
        ?>
                <div class="alert alert-danger"><strong>Error! </strong><?=$errorTransaction?></div> 
        <?php
                
            }
        ?>
      
            <div class="box">
              <div class="box-body">
                <table id="example1" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                             <th>Serial No</th>
                             <th>Name</th>
                             <th>Course</th>
                             <th>Amount</th>
                             <th>Order ID</th>
                             <th>Status</th>
                             <th>Time Stamp</th>
                             <th>Action</th>
                        </tr>
                    </thead>
                     <tbody> 
 
                    
                     <?php
                        
                            if (isset($transactionList)) 
                            {
                                $i = 1;
                                foreach ($transactionList as $detail) 
                                {    
                                
                     ?>
                                     <tr> 
                                        <td style="  text-align: center; " id="serial<?=$i?>"><?=$i;?></td>
                                        <td id="name<?=$i?>"><?=ucfirst($detail['user_name']);?></td> 
                                         <td id="course<?=$i?>"><?=ucfirst($detail['course_name']);?></td>  
                                         <td id="amount<?=$i?>"><?=$detail['amt'];?></td>  
                                         <td id="orderId<?=$i?>"><?=$detail['order_id'];?></td>  
                                         <td id="status<?=$i?>"><?=$detail['status'];?></td>
                                         <td id="status<?=$i?>">
                                            <?php
                                                $date=date_create($detail['time_stamp']);
                                                echo date_format($date,"M d Y");
                                            ?>
                                        </td>
                                         <td>
                                                <?php
                                                        if(!empty($detail['invoice']))
                                                        {
                                                ?>
                                                            <a href="invoices/<?=$detail['invoice']?>" class="btn btn-primary" target="_blank"><i class="fa fa-eye"></i></a>
                                                            <a href="invoices/<?=$detail['invoice']?>" class="btn btn-success" download><i class="fa fa-download"></i></a>
                                                <?php
                                                        }
                                                        else
                                                        {
                                                        ?>
                                                            <a href='#!' class='btn btn-warning' ><i class='fa fa-warning'></i></a>
                                                        <?php
                                                        }
                                                ?>
                                                
                                         </td>
                                </tr>
                                 
                            <?php
                                $i++;
                                    
                                            
                                }
                            }
                         ?>
          
                        </tbody>
                                </table>
                       
                        </div>
            <!-- /.box-footer-->
                        </div>    
      <!-- /.box -->
    </section>
    <!-- /.content -->
</div>

                         
  
          

  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->       
  <div class="control-sidebar-bg"></div>

  

<?php
    require_once 'js-links.php';
?>

<script>
    function setEditValues(id,count)
    {
        $("#eid").val(id);
        $("#ename").val($("#name"+count).html());
        $("#eserial").val($("#serial"+count).html());
        $("#eaddr").val($("#addr"+count).html());
        $("#emob").val($("#course"+count).html());
        $("#estatus").val($("#status"+count).html());
        $("#emont").val($("#pkg"+count).html());
        $("#efee").val($("#fee"+count).html());
        $("#ememFName").val($("#fat"+count).html());
    }  
</script>
