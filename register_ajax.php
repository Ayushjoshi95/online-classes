<?php
    require_once 'lib/core.php'; 

    //api for registering users 
	if(isset($_POST['name'])&&isset($_POST['email'])&&isset($_POST['college'])&&isset($_POST['contact'])&&isset($_POST['year']))
   {
       //extrating user details
       $name = $_POST['name'];
       $email = $_POST['email'];
       $college = $_POST['college'];
       $contact = $_POST['contact'];
       $year = $_POST['year'];

        //inserting user deatils into database
        $sql="INSERT into users(name,email,contact,college,year) values('$name','$email','$contact','$college','$year')";
        if($result=$conn->query($sql))
        { 
            //sending success response back to client
            echo $conn->insert_id; 
        }
        else
        {
            //sending failure response back to client
            echo "error";
        }
    }
    
    //api for initiating users transaction
	if(isset($_POST['u_id'])&&isset($_POST['transaction']))
   {
       //extrating user details
       $name = $_POST['name'];
       $email = $_POST['email'];
       $college = $_POST['college'];
       $contact = $_POST['contact'];
       $year = $_POST['year'];

        //inserting user deatils into database
        $sql="INSERT into users(name,email,contact,college,year) values('$name','$email','$contact','$college','$year')";
        if($result=$conn->query($sql))
        { 
            //sending success response back to client
            echo $conn->insert_id; 
        }
        else
        {
            //sending failure response back to client
            echo "error";
        }
	}
 
?>