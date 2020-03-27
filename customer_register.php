<?php
include "../admin/inc/database.php";
$db = new Database();
if(isset($_POST['email'])) {
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $sql_check = "SELECT email from customer_details WHERE email = '$email'";
    $result = $db->select($sql_check);
    if (sizeof($result) > 0) {
        exit(json_encode(array("status" => 0, "msg" => 'Email already exists!')));
    } else {

        exit(json_encode(array("status" => 1, "msg" => 'Email can be used')));

    }
}

    if(isset($_POST['n_c_email'])){
        $first_name = mysqli_real_escape_string($con, $_POST['n_c_firstName']);
        $last_name = mysqli_real_escape_string($con, $_POST['n_c_lastName']);
        $email = mysqli_real_escape_string($con, $_POST['n_c_email']);
        $password = mysqli_real_escape_string($con, $_POST['n_c_password']);
        if(isset($_POST['marketing'])){
            $accept_marketing = 'yes';
        }else{
            $accept_marketing = 'no';
        }
        if(isset($_POST['newsletter'])){
            $accept_newsletter = 'yes';
        }else{$accept_newsletter = 'no';}
        $responseKey = $_POST['g-recaptcha-response'];
        $secretKey = "6LdpFmEUAAAAAGWLSh6HbcFGHqzvoWfXFiamxK33";
        $clientIP = $_SERVER['REMOTE_ADDR'];

        $url = "https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$responseKey&remoteip=$clientIP";
        $response = file_get_contents($url);
        $response = json_decode($response);
       // if ($response->success) {
        if(isset($clientIP)){
            $password_hashed =  password_hash($password, PASSWORD_BCRYPT);
            $date_created = date("Y-m-d H-i-s");


            $sql_create_user = "INSERT INTO customer_details (first_name, last_name, email, password, marketing, newsletter, date_created) VALUES (?, ?, ?, ?, ?, ?, ?)";

            if($stmt = $mysqli->prepare($sql_create_user)){
                $stmt->bind_param('sssssss',$first_name, $last_name, $email, $password_hashed, $accept_marketing, $accept_newsletter, $date_created  );

                if($stmt->execute()){
                    header("location: customer_login.php");
                }else{
                    // failer with the execute of stmt
                    exit(json_encode(array("status" => 0, "msg" => 'error with execute')));
                }
            }else{
                // failure with preparing the statment
                exit(json_encode(array("status" => 0, "msg" => 'error with stmt')));
            }
            $stmt->close();

// Close connection
            $mysqli->close();
        } else
            echo'Verification failed!';
    }





?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Vanita Pasta</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/typicons/2.0.9/typicons.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Aclonica">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Acme">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Aguafina+Script">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Akronim">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Alegreya+Sans">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Alex+Brush">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Allerta+Stencil">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Allura">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Amarante">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cookie">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Sirin+Stencil">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Stardos+Stencil">
    <link rel="stylesheet" href="assets/css/Carousel-Hero-1.css">
    <link rel="stylesheet" href="assets/css/Carousel-Hero-2.css">
    <link rel="stylesheet" href="assets/css/Carousel-Hero.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.1.1/aos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.8.2/css/lightbox.min.css">
    <link rel="stylesheet" href="assets/css/iframe.css">
    <link rel="stylesheet" href="assets/css/Lightbox-Gallery.css">
    <link rel="stylesheet" href="assets/css/Pretty-Footer.css">
    <link rel="stylesheet" href="assets/css/MUSA_carousel-product-cart-slider.css">
    <link rel="stylesheet" href="assets/css/Paralax-Hero-Banner.css">
    <link rel="stylesheet" href="assets/css/Social-Icons.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/Testimonials.css">

</head>

<body>
    <div class="c-portal" style="height:100%;">
        <div class="container c-portal">
            <div class="row">
                <div class="col-md-2 col-lg-3 col-xl-3 d-none d-sm-none d-md-block"></div>
                <div class="col-sm-12 col-md-8 col-lg-6 col-xl-6 login_card" style="padding-top:10%;padding-bottom:10%;">
                    <div class="card">
                        <div class="card-body">
                            <div class="text-center"><img src="assets/img/Vanita Logo.png" id="logoLarge"></div>
                            <form method="post" id="form_new_customer"  style="padding-top:20px;margin-top:20px;" action="customer_register.php">
                                <h4 class="text-muted text-center">Welcome&nbsp;</h4>
                                <h6 class="text-muted text-center">We just need a few of your details and you'll be ready to go.</h6>

                                <div class="form-group">
                                    <label>First Name</label>
                                    <input class="form-control" type="text" name="n_c_firstName"  id="n_c_firstName" required placeholder="First Name" maxlength="55">
                                </div>
                                <div class="form-group">
                                    <label>Last name</label>
                                    <input class="form-control" type="text" name="n_c_lastName" id="n_c_lastName" required placeholder="Last Name" minlength="55">
                                </div>
                                <div class="form-group">
                                    <label class="float-left">Email</label>
                                    <input class="form-control form-control" type="email" id="n_c_email" name="n_c_email" required placeholder="email@host.co.za" maxlength="100">
                                </div>
                                <div class="form-group">
                                    <label class="float-left">Password</label>
                                    <input class="form-control" type="password" name="n_c_password" id="n_c_password" required placeholder="*******" maxlength="55" minlength="5">
                                </div>
                                <div class="form-group">
                                    <label class="float-left">Confirm Password</label>
                                    <input class="form-control" type="password" name="n_c_confirm_password" id="n_c_confirm_password" required placeholder="*******" maxlength="55" minlength="5">
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" checked name="marketing">
                                    <label class="form-check-label">Accept Marketing</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" checked name="newsletter">
                                    <label class="form-check-label">Sign up for newsletter</label>
                                </div><br>
                                <div class="g-recaptcha" data-sitekey="6LdpFmEUAAAAAEzDfECKSzsRAdAOrcX_AuLB0myX"></div>
                            </form>
                                <div>
                                    <button class="btn btn-primary btn-block submit_btn " type="button" style="margin-bottom:15px;margin-top:15px;">Continue</button>
                                    <p class="text-center" style="font-size:10px;">By signing up you agree to the&nbsp;<a href="Terms_of_use.html">Terms</a>&nbsp;and&nbsp;<a href="privacy_policy.html">Privacy policy</a></p>
                                </div>
                                <p>Don't feel like creating an account,&nbsp;<a href="index.php">continue shopping</a></p>


                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-lg-3 d-none d-sm-none d-md-block"></div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/bs-animation.js"></script>
    <script src="assets/js/cart_func.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.1.1/aos.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.8.2/js/lightbox.min.js"></script>
    <script src="assets/js/Paralax-Hero-Banner.js"></script>
    <script src="assets/js/store.js"></script>

    <script type="text/javascript">
    $(document).ready(function (){
        $(".submit_btn").click(function(){
            var reg =  /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
            var password_pattern = /['!@#$%*\]\[()=_+{}:\";?,.\/A-Za-z0-9\s-]/;
            var name_pattern = /^([A-Za-z0-9_\-\.])/;
            var first_name = $('#n_c_firstName').val();
            var last_name = $("#n_c_lastName").val();
            var email = $("#n_c_email").val();
            var password = $("#n_c_password").val();
            var confrim_password = $("#n_c_confirm_password").val();

            if(password != ''){
                if(password == confrim_password ){
                    if(reg.test(email)== false){
                        alert("Please check your email!");
                    }else if (name_pattern.test(first_name)== false){
                        alert("Please check your name input!");
                    }else if(name_pattern.test(last_name)== false){
                        alert("Please check your last name input!");
                    }
                    else{
                        $.ajax({
                            url:'customer_register.php',
                            method: 'POST',
                            dataType: 'json',
                            data:{ email: email},
                            success: function (response) {
                                if (response.status == 0){
                                    alert(response.msg);

                                }else if(response.status == 1){

                                    $('#form_new_customer').submit();
                                }

                            }
                        })
                    }
                }else{
                    alert("Passwords don't match!");
                }
            }else {
                alert("Password cant be blank!");
            }




        })



    });

    </script>
    <script src='https://www.google.com/recaptcha/api.js'></script>
</body>

</html>