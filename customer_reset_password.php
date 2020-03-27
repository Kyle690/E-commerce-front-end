<?php
/**
 * Created by PhpStorm.
 * User: kyle
 * Date: 2018/06/28
 * Time: 6:09 PM
 */
include "../admin/inc/database.php";
$db = new Database();
if(isset($_GET['email'])){

    $email = mysqli_real_escape_string($con, $_GET['email']);
    $token = mysqli_real_escape_string($con, $_GET['token']);
    $date_now = date("Y-m-d H-i-s");
    $sql_check = "SELECT email, token, token_expire FROM customer_details WHERE email='$email' AND token='$token' AND token<>'' AND token_expire > NOW()";
    $result = $db->select($sql_check);
    if(sizeof($result) ==1){
        if($result[0]['email'] == $email){
            if($result[0]['token'] == $token){
                if($result[0]['token_expire'] > $date_now){
                    $msg = '<div class="text-center" style="padding-top:20px;">
                    <h4 class="text-muted">Reset your password</h4>
                    <p class="text-muted">Please enter your new password.</p>
                </div>    
                <form method="post" action="customer_reset_password.php" id="reset_password_from" style="padding-top:20px;margin-top:20px;">
                    <div class="form-group">
                        <label class="float-left">Password</label>
                        <input class=" form-control" type="password" id="password" name="reset_password" required="" placeholder="********" maxlength="100">
                        <input type="hidden" name="reset_email" value="'.$email.'">
                    </div>
                    <div class="g-recaptcha" data-sitekey="6LdpFmEUAAAAAEzDfECKSzsRAdAOrcX_AuLB0myX"></div>
                    <button class="btn btn-primary btn-block" type="button" id="reset_btn" style="margin-bottom:15px;margin-top:15px;">Reset Password</button>

                </form>';
                }else{

                    $msg = '<div class="text-center">
                <h6 class="text-center"> Token has expired, please try again</h6>
                  <a class="text-center" href="customer_forgot_password.php">Forgot password</a></div> ';
                }

            }else{
                $msq = '<div class ="text-center"><h6 class="text-center"> Error with token </h6>
                  <a class="text-center" href="customer_forgot_password.php">Forgot password</a></div> ';
            }

        }else{
            $msg = '<div class="text-center"><h6 class="text-center"> Error with  email address</h6>
                  <a class="text-center" href="customer_forgot_password.php">Forgot password</a></div>';
        }

    }else {
        $msg = '<div class="text-center"><h6 class="text-center"> Error with token or email address</h6>
                  <a  class="text-center" href="customer_forgot_password.php">Forgot password</a></div>';
    }
}

if(isset($_POST['reset_email'])){
    $email = mysqli_real_escape_string($con, $_POST['reset_email']);
    $password = mysqli_real_escape_string($con, $_POST['reset_password']);
    $responseKey = $_POST['g-recaptcha-response'];
    $secretKey = "6LdpFmEUAAAAAGWLSh6HbcFGHqzvoWfXFiamxK33";
    $clientIP = $_SERVER['REMOTE_ADDR'];
    $url = "https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$responseKey&remoteip=$clientIP";
    $response = file_get_contents($url);
    $response = json_decode($response);
    if ($response->success) {
        $password_hashed =  password_hash($password, PASSWORD_BCRYPT);
        $token='';
        $sql_password_update = "UPDATE customer_details SET password=?, token=? WHERE email='$email'";
        if($stmt = $mysqli->prepare($sql_password_update)){
            $stmt->bind_param('ss', $password_hashed, $token  );

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
    }
}

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password | Vanita Pasta</title>
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
                        <div class="text-center">
                            <img src="assets/img/Vanita Logo.png" id="logoLarge">
                        </div>
                        <div>
                            <?php echo $msg ?>
                        </div>

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
    $("#reset_btn").click(function () {
        var password = $("#password").val();
        var password_pattern = /['!@#$%*\]\[()=_+{}:\";?,.\/A-Za-z0-9\s-]/;
        if(password_pattern.test(password)== false){
            alert("Check your password!");
        }else{
            $("#reset_password_from").submit();
        }
    })
})
</script>
<script src='https://www.google.com/recaptcha/api.js'></script>
</body>

</html>
