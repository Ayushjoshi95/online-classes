<?php
require_once 'header.php';
$course_id=1;
?>

<link rel="stylesheet" href="css/registration.css">

<div>
    <div id="registration_form" >
    
    <form style="padding-top:70px;" id="registrationForm">
        <div class="form-group" style="padding-left:3vw;">
        <input type="text" class="form-control" id="name" name="name"   placeholder="Enter Name" style="width:90%;border-radius:20px;" required>
        </div>
        <div class="form-group" style="padding-left:3vw;">
            <input type="email" class="form-control" id="email" name="email"placeholder="Enter Email" style="width:90%;border-radius:20px;" required>
        </div>
        <div class="form-group" style="padding-left:3vw;">
            <input type="text" class="form-control" id="mobile" name='contact'  placeholder="Mobile Number" style="width:90%;border-radius:20px;" required>
        </div>
        <div class="form-group" style="padding-left:3vw;">
            <input type="text" class="form-control" id="institution" name="college" placeholder="College/School Name" style="width:90%;border-radius:20px;" required>
        </div>
        <div class="form-group" style="padding-left:3vw;">
            <input type="text" class="form-control" id="standard" name="year" placeholder="Year/Standard" style="width:90%;border-radius:20px;" required>
            <input type="hidden" class="form-control" id="course_id" name="course_id" value="<?=$course_id?>"> 
        </div>
        <div style="text-align:center;">
            <button type="submit" class="btn justify-content-center" style="margin-top:25px;width:40%;border-radius: 20px;background: #F6872B;">Submit</button>
        </div>
        
    </form>
    
    </div>
</div>
 
<?php
  require_once "js-links.php";
?>
<script>
        $("#registrationForm").submit(function(e) {
            e.preventDefault()
            // ajax for  user registration
            $.ajax({
                url: "register_ajax.php",
                type: "POST",
                data: $(this).serialize(),
                success: function(a) { 
                    if(a!='error')
                    {
                        window.location = "paytm_payment?u_token="+a+"&token=<?=$course_id?>";
                    }
                     
                },
                error: function(data) {

                }

            });
        }) 
</script> 