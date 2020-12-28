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
            
            $sql="delete from courses where id=$id";
            if($conn->query($sql))
            {
                $resCourses=true;   
            }
            else
            {
                $resCourses=$conn->error;
            }
        }
        
        if(isset($_POST['add']))
        {
            $name=test_input($_POST['name']);
            $des=test_input($_POST['des']);
            $price=test_input($_POST['price']);
            $duration=test_input($_POST['duration']);
            $file = $_FILES['images']; 
            $uploaded_file_name = upload_image($files);
            if($uploaded_file_name!="err")
            {
                $sql="insert into courses(name,des,price,duration,feature_image) values('$name','$des','$price','$duration','$uploaded_file_name')";
                if($conn->query($sql))
                {
                   $resCourses=true;
                }
            } 
            else
            {
                $errorCourses="Unable To upload Image";
            }  
        }
        
        if(isset($_POST['edit']))
        {
            $name=test_input($_POST['ename']);
            $feature_image=test_input($_POST['efeature_image']);
            $des=test_input($_POST['edes']);
            $price=test_input($_POST['eprice']);
            $duration=test_input($_POST['eduration']);
            $id=test_input($_POST['eid']);
            
            $sql="update courses set name='$name',feature_image='$feature_image',des='$des',price='$price',duration='$duration' where id=$id";
            if($conn->query($sql))
            {
                    $resCourses = "true";
            }
            else
            {
                $errorCourses=$conn->error;
            }
        }
    }
        
    $sql="select * from courses ";
    $result =  $conn->query($sql);
    if($result->num_rows)
    {
        while($row = $result->fetch_assoc())
        {
            $coursesList[] = $row;
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
            Courses
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
            if(isset($resCourses))
            {
        ?>
                <div class="alert alert-success"><strong>Success! </strong> your request successfully updated. </div> 
        <?php
            }
            else if(isset($errorCourses))
            {
        ?>
                <div class="alert alert-danger"><strong>Error! </strong><?=$errorCourses?></div> 
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
                             <th>Feature image</th>
                             <th>Description</th>
                             <th>Price</th>
                             <th>Duration</th>
                             <th>Action</th>
                        </tr>
                    </thead>
                     <tbody> 
 
                    
                     <?php
                        
                            if (isset($coursesList)) 
                            {
                                $i = 1;
                                foreach ($coursesList as $detail) 
                                {    
                                
                     ?>
                        
                                     <tr> 
                                        <td style="text-align:center;" id="serial<?=$i?>"><?=$i;?></td>
                                        <td id="name<?=$i?>"><?=$detail['name'];?></td> 
                                         <td id="feature_image<?=$i?>"><img src="uploads/<?=$detail['feature_image'];?>"/></td>  
                                         <td id="des<?=$i?>"><?=$detail['des'];?></td>
                                         <td id="price<?=$i?>"><?=$detail['price'];?></td>
                                         <td id="duration<?=$i?>"><?=$detail['duration'];?></td>
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
           <form method="post"  enctype="multipart/form-data">
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
                                <label>Feature Image </label><br>
                                <input type="file"  id="mob" name="images" class="form-control">
                            </div> 
                    
                   </div>
                </div>
               <div class="row">
                    <div class="col-md-6"> 
                       <div class="form-group">
                            <label>Description</label><br>
                            <input type="text"  id="des" name="des" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6"> 
                       <div class="form-group">
                            <label>Price</label><br>
                            <input type="text"  id="price" name="price" class="form-control">
                        </div>
                    </div>
                </div>
               <div class="row">
                  <div class="col-md-6"> 
                       <div class="form-group">
                            <label>Duration </label><br>
                            <input type="text"  id="duration" name="duration" class="form-control">
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
                            <label>Feature Image </label><br>
                            <input type="text"  id="efeature_image" name="efeature_image" class="form-control">
                        </div> 
                   </div>
                </div>
               <div class="row">
                    <div class="col-md-6"> 
                       <div class="form-group">
                            <label>Description</label><br>
                            <input type="text"  id="edes" name="edes" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6"> 
                       <div class="form-group">
                            <label>Price</label><br>
                            <input type="text"  id="eprice" name="eprice" class="form-control">
                        </div>
                    </div>
                </div>
               <div class="row">
                  <div class="col-md-6"> 
                       <div class="form-group">
                            <label>Duration </label><br>
                            <input type="text"  id="eduration" name="eduration" class="form-control">
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
        $("#efeature_image").val($("#feature_image"+count).html());
        $("#edes").val($("#des"+count).html());
        $("#eprice").val($("#price"+count).html());
        $("#eduration").val($("#duration"+count).html());
    }  
</script>
