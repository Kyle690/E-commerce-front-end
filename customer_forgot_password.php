<?php
include "../admin/inc/database.php";
$db = new Database();
if(isset($_POST['email'])){
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $sql_check = "SELECT email FROM customer_details WHERE email = '$email'";
    $result = $db->select($sql_check);
    if(sizeof($result) == 1){
        exit(json_encode(array("status" => 1, "msg" => 'Email can be used')));
    }else{
        exit(json_encode(array("status" => 0, "msg" => "Email doesn't exists!")));
    }
}






function generateNewString($len = 10) {
    $token = "poiuztrewqasdfghjklmnbvcxy1234567890";
    $token = str_shuffle($token);
    $token = substr($token, 0, $len);

    return $token;
}
$msg = '';
if(isset($_POST['c-reset_password_email'])){
    $email = mysqli_real_escape_string($con, $_POST['c-reset_password_email']);
    $responseKey = $_POST['g-recaptcha-response'];
    $secretKey = "6LdpFmEUAAAAAGWLSh6HbcFGHqzvoWfXFiamxK33";
    $clientIP = $_SERVER['REMOTE_ADDR'];
    $url = "https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$responseKey&remoteip=$clientIP";
    $response = file_get_contents($url);
    $response = json_decode($response);
    if ($response->success) {

        $sql_check = "SELECT email, first_name FROM customer_details WHERE email = '$email'";
        $result = $db->select($sql_check);
        if (sizeof($result) == 1) {
            $name = $result[0]['first_name'];
            $token = generateNewString();
            $date_expire = date("Y-m-d H-i-s",strtotime(date("Y-m-d H:i:s")." +10 minutes"));
            $sql_token = "UPDATE customer_details SET token = '" . $token . "', token_expire= '".$date_expire."' WHERE email = '" . $email . "'";
            if($con->query($sql_token)){

                require_once '../admin/src/plugins/PHPMailer/src/Exception.php';
                require_once '../admin/src/plugins/PHPMailer/src/PHPMailer.php';
                require_once '../admin/src/plugins/PHPMailer/src/SMTP.php';

                $mail = new PHPMailer\PHPMailer\PHPMailer();
                $mail->isSMTP();
                $mail->Host = "timmy.aserv.co.za";
                $mail->SMTPSecure = "ssl";
                $mail->Port = 465;
                $mail->SMTPAuth = true;
                $mail->Username = 'no_reply@creativeplatform.co.za';
                $mail->Password = 'Noselicks101';
                $mail->addAddress($email);
                $mail->setFrom("info@vanitapasta.co.za", "Vanita Pasta");
                $mail->Subject = "Reset Password";
                $mail->isHTML(true);
                $mail->Body = "
                
	            Hi ".$name.",<br><br>
	            
	            
	            We received a request to reset your password, if this was not you please contact us immediately!<br>
	            <a href='http://admin.crreativeplatform.co.za/storefront/customer_reset_password.php?email=$email&token=$token'> 
	            http://admin.crreativeplatform.co.za/storefront/customer_reset_password.php?email=$email&token=$token</a>
	            <br><br>
	            
	            Kind Regards,<br>
	            Vanita Pasta Team
	        ";
                if($mail->send()){
                    $msg = "<p class='text-success'>Please Check Your Email Inbox!</p>";
                }
                else{
                    $msg = '<p class="text-danger">Something Wrong Just Happened! Please try again!</p>';
                }

            }
        }
    }
}

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password | Vanita Pasta</title>
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
                            <div class="text-center" style="padding-top:20px;">
                                <h4 class="text-muted">Forgot your password?</h4>
                                <p class="text-muted">No worries. We'll send you an email with instructions to reset your password.</p>
                            </div>
                            <div class="text-center">
                                <div><?php echo $msg ?></div>
                            </div>
                            <form method="post" action="customer_forgot_password.php" id="forgot_password_from" style="padding-top:20px;margin-top:20px;">
                                <div class="form-group">
                                    <label class="float-left">Email</label>
                                    <input class="form-control form-control" type="email" id="email" name="c-reset_password_email" required="" placeholder="Email address" maxlength="100">
                                </div>
                                <div class="g-recaptcha" data-sitekey="6LdpFmEUAAAAAEzDfECKSzsRAdAOrcX_AuLB0myX"></div>
                                <button class="btn btn-primary btn-block" type="button" id="reset_btn" style="margin-bottom:15px;margin-top:15px;">Reset Password</button>
                                <p class="text-muted text-center">Don't have an account?<a href="customer_register.php">Create one</a></p>
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
        $("#reset_btn").click(function () {
            var reg =  /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
            var email = $("#email").val();
            if(reg.test(email)== false){
                alert("Please check your email!");
            }else{
                $.ajax({
                    url: "customer_forgot_password.php",
                    method: "POST",
                    dataType: "json",
                    data: {
                         email: email
                    }, success: function (response) {
                        if(response.status == 0){
                            alert(response.msg);
                        }else if(response.status == 1){
                            $('#forgot_password_from').submit();


                        }

                    }


                });
            }
        })
    })
</script>
    <script src='https://www.google.com/recaptcha/api.js'></script>
</body>

</html>