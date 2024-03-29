<?php
    require_once 'header.php';
    require_once 'navbar.php';
    require_once 'left-navbar.php';
 
    $id=$_SESSION['id'];
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if(isset($_POST['delete']))
        {
            $id=test_input($_POST['delete']);
            
            $sql="delete from users where id=$id";
            if($conn->query($sql))
            {
                $resUsers=true;   
            }
            else
            {
                $resUsers=$conn->error;
            }
        }
        
        if(isset($_POST['add']))
        {
            $name=test_input($_POST['name']);
            $college=test_input($_POST['college']);
            $mob=test_input($_POST['mob']);
            $email=test_input($_POST['email']);
            $year=test_input($_POST['year']);
            
            $sql="insert into users(email,name,contact,college,year) values('$email','$name','$mob','$college','$year')";

            if($conn->query($sql))
            {
                    $resUsers = "true";
            }
            else
            {
                $errorUsers=$conn->error;
            }
        }
        
        if(isset($_POST['edit']))
        {
            $name=test_input($_POST['ename']);
            $college=test_input($_POST['ecollege']);
            $mob=test_input($_POST['emob']);
            $email=test_input($_POST['eemail']);
            $year=test_input($_POST['eyear']);
            $id=test_input($_POST['eid']);
            
            $sql="update users set email='$email',college='$college',year='$year',name='$name',contact='$mob' where id=$id";
            if($conn->query($sql))
            {
                    $resUsers = "true";
            }
            else
            {
                $errorUsers=$conn->error;
            }
        }
    }
        
    $sql="select * from users where type='0'";
    $result =  $conn->query($sql);
    if($result->num_rows)
    {
        while($row = $result->fetch_assoc())
        {
            $usersList[] = $row;
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
            Student Transaction
        </h1>
        <ol class="breadcrumb">
            <li>
                <div class="pull-right">
                    <button title="" class="btn btn-primary" data-toggle="modal" data-target="#modal-default"><i class="fa fa-plus"></i></button> 
                    <a href="" data-toggle="tooltip" title="" class="btn btn-default" data-original-title="Rebuild"><i class="fa fa-refresh"></i></a>
                </div>
            </li>
        </ol>
    </section>

    <!-- Main content -->
      <br>
    <section class="content">
        <?php
            if(isset($resUsers))
            {
        ?>
                <div class="alert alert-success"><strong>Success! </strong> your request successfully updated. </div> 
        <?php
            }
            else if(isset($errorUsers))
            {
        ?>
                <div class="alert alert-danger"><strong>Error! </strong><?=$errorUsers?></div> 
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
                             <th>Mobile</th>
                             <th>Email</th>
                             <th>College</th>
                             <th>Year</th>
                             <th>Action</th>
                        </tr>
                    </thead>
                     <tbody> 
 
                    
                     <?php
                        
                            if (isset($usersList)) 
                            {
                                $i = 1;
                                foreach ($usersList as $detail) 
                                {    
                                
                     ?>
                        
                                     <tr> 
                                        <td style="text-align:center;" id="serial<?=$i?>"><?=$i;?></td>
                                        <td id="name<?=$i?>"><?=$detail['name'];?></td> 
                                         <td id="mob<?=$i?>"><?=$detail['contact'];?></td>  
                                         <td id="email<?=$i?>"><?=$detail['email'];?></td>
                                         <td id="college<?=$i?>"><?=$detail['college'];?></td>
                                         <td id="year<?=$i?>"><?=$detail['year'];?></td>
                                        <td>
                                           
                                             <form method="post">
                                                <button name="confirm" type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-edit"  onclick="setEditValues(<?=$detail['id'] ?>,<?=$i?>)" value="<?=$detail['id'] ?>">
                                                            <i class="fa fa-edit">Edit</i>
                                                </button>
                                                <button  class="btn btn-danger" type="submit" name="delete" value="<?=$detail['id']?>">
                                                            <i class="fa fa-trash-o"></i> Delete
                                                </button>
                                            </form>
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

                         
    <div class="modal fade" id="modal-default">
      <div class="modal-dialog" >
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title">Add Member</h4>
           </div>
           <form method="post">
           <div class="modal-body">
               <div class="row">
                  <div class="col-md-6"> 
                       <div class="form-group">
                            <label>Name</label><br>
                            <input type="text"  id="name" name="name" class="form-control">
                        </div> 
                   </div>
                   <div class="col-md-6"> 
                       <div class="form-group">
                            <label>Mobile </label><br>
                            <input type="text"  id="mob" name="mob" class="form-control">
                        </div> 
                   </div>
                </div>
               <div class="row">
                    <div class="col-md-6"> 
                       <div class="form-group">
                            <label>Email</label><br>
                            <input type="text"  id="email" name="email" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6"> 
                       <div class="form-group">
                            <label>Collage</label><br>
                            <input type="text"  id="college" name="college" class="form-control">
                        </div>
                    </div>
                </div>
               <div class="row">
                  <div class="col-md-6"> 
                       <div class="form-group">
                            <label>Year </label><br>
                            <input type="text"  id="year" name="year" class="form-control">
                        </div> 
                   </div>
                 </div>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
            <button type="submit" name="add" class="btn btn-primary" value="">Add</button>
          </div>
             </form>
            </div>
               
            </div>
            <!-- /.modal-content -->
          </div>
    <div class="modal fade" id="modal-edit">
      <div class="modal-dialog" >
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title">Edit Member</h4>
           </div>
           <form method="post">
           <div class="modal-body">
               <div class="row">
                  <div class="col-md-6"> 
                       <div class="form-group">
                            <label>Name</label><br>
                            <input type="text"  id="ename" name="ename" class="form-control">
                        </div> 
                   </div>
                   <div class="col-md-6"> 
                       <div class="form-group">
                            <label>Mobile </label><br>
                            <input type="text"  id="emob" name="emob" class="form-control">
                        </div> 
                   </div>
                </div>
               <div class="row">
                    <div class="col-md-6"> 
                       <div class="form-group">
                            <label>Email</label><br>
                            <input type="text"  id="eemail" name="eemail" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6"> 
                       <div class="form-group">
                            <label>Collage</label><br>
                            <input type="text"  id="ecollege" name="ecollege" class="form-control">
                        </div>
                    </div>
                </div>
               <div class="row">
                  <div class="col-md-6"> 
                       <div class="form-group">
                            <label>Year </label><br>
                            <input type="text"  id="eyear" name="eyear" class="form-control">
                            <input type="hidden"  id="eid" name="eid" class="form-control">
                        </div> 
                   </div>
                 </div>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
            <button type="submit" name="edit" class="btn btn-primary" value="">Edit</button>
          </div>
             </form>
            </div>
             
        </div>
            <!-- /.modal-content -->
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
        $("#ecollege").val($("#college"+count).html());
        $("#emob").val($("#mob"+count).html());
        $("#eemail").val($("#email"+count).html());
        $("#eyear").val($("#year"+count).html());
    }  
</script>
