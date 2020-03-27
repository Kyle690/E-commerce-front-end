<?php
include "../admin/admin_dashboard/inc/functions.php";
secure_session_start();
include "../admin/inc/database.php";
$db = new Database();
if(isset($_POST['email'])){
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $sql_check = "SELECT id, email, first_name, password FROM customer_details WHERE email='$email'";
    $result = $db->select($sql_check);
    if(sizeof($result) == 1){
        if(password_verify($password, $result[0]["password"])===TRUE){

            $_SESSION['user_firstName'] = $result[0]["first_name"];
            $_SESSION['user_id'] = ($result[0]["id"]);
            $user_id = ($result[0]['id']);
            $lastLoggedIn= date("Y-m-d H-i-s");
            $sql_user_logged  = "UPDATE customer_details SET date_logged_in =? WHERE id = '$user_id'";
            if($stmt = $mysqli->prepare($sql_user_logged)){
                $stmt->bind_param('s',$lastLoggedIn );

                if($stmt->execute()){
                    // sql was successfull
                    exit(json_encode(array("status" => 1, "msg" => 'Login successful!')));
                }else{
                    // failure with the execute of stmt
                    echo "Something went wrong with the Sql entry!";
                }
            }else{
                // failure with preparing the statement
                echo "Something went wrong with preparing the statement for the date! ";
            }
        }




    }else{
        exit(json_encode(array("status" => 0, "msg" => 'User with that email does not exist')));

    }
}


?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Vanita Store</title>
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
                            <form method="post" style="padding-top:20px;margin-top:20px;">
                                <h4 class="text-muted text-center">Welcome back!</h4>
                                <h6 class="text-muted text-center">Login with your Email</h6>
                                <div class="form-group">
                                    <label class="float-left">Email</label>
                                    <input class="form-control form-control" type="email" name="c-Login_email" id="email" required="" placeholder="john@smith.co.za" maxlength="100">
                                    <div class="invalid-feedback d-none text-center" id="email_validation">
                                        <h6>Please check your email.</h6>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="float-left">Password</label>
                                    <input class="form-control" type="password" name="c-Login_password" id="password" required="" placeholder="*******" maxlength="55" minlength="5">
                                    <div class="invalid-feedback d-none text-center" id="password_validation">
                                        <h6>Please check your password.</h6>
                                    </div>
                                </div>
                                <a href="customer_forgot_password.php">Forgot password?</a>
                                <button
                                    class="btn btn-primary btn-block" type="button" id="login_btn" style="margin-bottom:15px;margin-top:15px;">Sign In</button>
                                    <div class="form-row">
                                        <div class="col-6"><a class="text-dark" href="customer_register.php">Don't have an account?</a></div>
                                        <div class="col-6"><a class="text-dark float-right" href="index.php">Return to store</a></div>
                                    </div>
                            </form>
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
    $(document).ready(function () {
        $("#login_btn").click(function () {

            var email = $("#email").val();
            var password = $("#password").val();
            var reg =  /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
            var password_pattern = /['!@#$%*\]\[()=_+{}:\";?,.\/A-Za-z0-9\s-]/;
            var emailValid = true;
            var passwordValid = true;
            if( reg.test(email) == false ){
                $("#email").addClass("is-invalid");
                $("#email_validation").removeClass("d-none");
                emailValid = false;
            }else if (emailValid == true){
                $("#email").removeClass('is-invalid');
                $("#email_validation").addClass('d-none');
                emailValid = true;
            }
            if (password_pattern.test(password) == false) {
                $("#password").addClass('is-invalid');
                $("#password_validation").removeClass("d-none");
                passwordValid = false

            } else if (passwordValid == true){
                $("#password").removeClass('is-invalid');
                $("#password_validation").addClass('d-none');

                if(email != '' && password != ''){
                   if(emailValid && passwordValid) {


                       $.ajax({
                           url: "customer_login.php",
                           method: "POST",
                           dataType: 'json',
                           data: {email: email, password: password},
                           success: function (response) {
                               if (response.status == 1){
                                   alert(response.msg);
                                   window.location.href = 'index.php';
                               } else{
                                   alert(response.msg);
                               }
                           }
                       })
                   }
                }
            }





        })
    })




    </script>
</body>

</html>