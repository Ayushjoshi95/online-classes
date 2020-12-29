<?php
require_once 'header.php';
?>
<style>
#main_price {

    margin-top: 100px;
    margin-left: 9%;
}

#price {
    width: 80%;
    height: 480px;
    border-radius: 25px;
    background: rgb(244, 216, 28);
    background: linear-gradient(90deg, rgba(244, 216, 28, 1) 19%, rgba(242, 178, 82, 1) 100%);
    box-shadow: 1px 6px 30px 2px rgba(112, 107, 107, 0.75);
    -webkit-box-shadow: 1px 6px 30px 2px rgba(112, 107, 107, 0.75);
    -moz-box-shadow: 1px 6px 30px 2px rgba(112, 107, 107, 0.75);
}

#heading {

    background: rgb(244, 89, 28);
    background: linear-gradient(90deg, rgba(244, 89, 28, 1) 19%, rgba(227, 162, 32, 1) 100%);
    text-align: center;
    padding-top: 40px;
    padding-bottom: 30px;
}
</style>
<link rel="stylesheet" href="css/registration.css">
<section class="home-banner-area">
    <div class="container">
        <div class="row justify-content-center fullscreen align-items-center">
            <div class="col-lg-5 col-md-8 home-banner-left">
                <h1 class="text-white">
                    Take the first step <br />
                    to learn with us
                </h1>
                <!-- <p class="mx-auto text-white  mt-20 mb-40">
                Let us take you into a deeper experience, make a moment a lasting conveyable memory because
                 we love what we do and we do what our clients loves.
                </p> -->
                <h3 class="text-white">
                    Web Development Training Program <br />
                </h3>
            </div>
            <div class="offset-lg-2 col-lg-5 col-md-12 home-banner-right">
                <img class="img-fluid" src="img/header-img.png" alt="" />
            </div>
        </div>
    </div>
</section>

<section class="feature-area" style="margin-top:30px">

    <div class="row" id="main_price">

        <div class="col-lg-6">
            <div class="card mb-5 mb-lg-0" id="price">
                <div class="card-body">
                    <h5 class="card-title text-muted text-uppercase text-center">Technology</h5>
                    <hr>
                    <ul class="fa-ul" style="margin-top: 40px;">
                        <li style="font-size: 21px;"><span class="fa-li"></span>HTML</li>
                        <li style="font-size: 21px;margin-top:8px;"><span class="fa-li"></span>CSS</li>
                        <li style="font-size: 21px;margin-top:8px;"><span class="fa-li"></span>JAVASCRIPT</li>
                        <li style="font-size: 21px;margin-top:8px;"><span class="fa-li"></span>SQL</li>
                        <li style="font-size: 21px;margin-top:8px;"><span class="fa-li"></span>PHP</li>
                        <li style="font-size: 21px;margin-top:8px;"><span class="fa-li"></span>AJAX and JSON</li>
                        <li style="font-size: 21px;margin-top:8px;"><span class="fa-li">HT.ACCESS</span></li>
                        <li style="font-size: 21px;margin-top:8px;"><span class="fa-li"></span>GIT</li>
                    </ul>
                </div>
            </div>
        </div>



        <div class="col-lg-6">
            <div class="card mb-5 mb-lg-0" id="price">
                <div class="card-body">
                    <h5 class="card-title text-muted text-uppercase text-center">Benefits</h5>
                    <hr>
                    <ul class="fa-ul" style="margin-top: 40px;">
                        <li style="font-size: 21px;margin-top:8px;"><span class="fa-li"></span>HANDS ON EXPERIENCE</li>
                        <li style="font-size: 21px;margin-top:8px;"><span class="fa-li"></span>FULL STACK DEVELOPER</li>
                        <li style="font-size: 21px;margin-top:8px;"><span class="fa-li"></span>CERTIFICATE</li>
                        <li style="font-size: 21px;margin-top:8px;"><span class="fa-li"></span>INTERNSHIP OFFERS</li>
                    </ul>
                </div>
            </div>
        </div>

    </div>
</section>

<section class="register">

    <div>
        <div id="registration_form">

            <form style="padding-top:70px;" id="registrationForm">
                <div class="form-group" style="padding-left:3vw;">
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name"
                        style="width:90%;border-radius:20px;" required>
                </div>
                <div class="form-group" style="padding-left:3vw;">
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email"
                        style="width:90%;border-radius:20px;" required>
                </div>
                <div class="form-group" style="padding-left:3vw;">
                    <input type="text" class="form-control" id="mobile" name='contact' placeholder="Mobile Number"
                        style="width:90%;border-radius:20px;" required>
                </div>
                <div class="form-group" style="padding-left:3vw;">
                    <input type="text" class="form-control" id="institution" name="college"
                        placeholder="College/School Name" style="width:90%;border-radius:20px;" required>
                </div>
                <div class="form-group" style="padding-left:3vw;">
                    <input type="text" class="form-control" id="standard" name="year" placeholder="Year/Standard"
                        style="width:90%;border-radius:20px;" required>
                    <input type="hidden" class="form-control" id="course_id" name="course_id" value="<?=$course_id?>">
                </div>
                <div style="text-align:center;">
                    <button type="submit" class="btn justify-content-center"
                        style="margin-top:25px;width:40%;border-radius: 20px;background: #F6872B;">Submit</button>
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
                if (a != 'error') {
                    window.location = "paytm_payment?u_token=" + a + "&token=<?=$course_id?>";
                }

            },
            error: function(data) {

            }

        });
    })
    </script>
</section>