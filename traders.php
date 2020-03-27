<?php
include "inc/head.php";
include "inc/admin_email_store.php";
$email_admin = new admin_email_store();

$response = '';
// check if email is posted
if(isset($_POST['trader_Email'])){

    $first_name = mysqli_real_escape_string($con, $_POST['trader_firstName']);
    $last_name = mysqli_real_escape_string($con, $_POST['trader_lastName']);
    $email = mysqli_real_escape_string($con, $_POST['trader_Email']);
    $contact = mysqli_real_escape_string($con, $_POST['trader_Number']);
    $company_name = mysqli_real_escape_string($con, $_POST['trader_companyName']);
    $area = mysqli_real_escape_string($con, $_POST['trader_area']);
    $message = mysqli_real_escape_string($con, $_POST['trader_message']);


    $name = $first_name.' '.$last_name;
    if($email_admin->trader_email($name, $email, $contact, $company_name, $area, $message, $db)){
        $response = "Details have been received, one of our service consultants will be in touch with you shortly.";
    }else{
        echo "Error: Please try again!";
    }

    /*
    $responseKey = $_POST['g-recaptcha-response'];
    $secretKey = "6LdpFmEUAAAAAGWLSh6HbcFGHqzvoWfXFiamxK33";
    $clientIP = $_SERVER['REMOTE_ADDR'];
    $url = "https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$responseKey&remoteip=$clientIP";
    $response = file_get_contents($url);
    $response = json_decode($response);
    if ($response->success) {
        // create email
        $email_admin->trader_email($name, $email, $contact, $company_name, $area, $message, $db);
        $response = "Details have been received, one of our service consultants will be in touch with you shortly.";



    }else{
        echo "Error: Please try again!";
    }*/


}


 $title ="   <title>Traders | Vanita Pasta</title>";
  $meta='  <meta name="description" content="We can stock your commercial kitchen with frozen pasta">
           <meta name="keywords" content="frozen pasta, bulk pasta ">';
 include "inc/head_2.php"; ?>
    <div class="traders_bg" style="max-height:600px;height:400px;">
        <div class="container">
            <div class="row">
                <div class="col text-center text-white">
                    <h1 style="padding:15%;">Do you have a commercial kitchen or would like to become a stockist ?&nbsp;</h1>
                </div>

            </div>
        </div>
    </div>
    <div>
        <div class="row" style="padding-top:10px;">
            <div class="col-12 text-center" style="padding-left:10%;padding-right:10%;">
                <p style="padding-right:20px;padding-left:20px;">If you are interested in stocking our products please fill in the form below and our consultants will get back to you and arrange a meeting with you.</p>
                <div class="text-center text-success"><?php echo $response ?></div>
            </div>

            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <div class="card" style="margin:15px;">
                    <div class="card-body contact_form">
                        <form method="POST" action="traders.php">
                        <div class="form-group">
                            <label>First Name</label>
                            <input type="text" name="trader_firstName" placeholder="First name" class="form-control" max-length="55">
                        </div>
                        <div class="form-group">
                            <label>Last Name</label>
                            <input type="text" name="trader_lastName" required="" placeholder="Last Name" maxlength="55" inputmode="latin-name" class="form-control" max-length="55">
                        </div>
                        <div class="form-group">
                            <label>Email&nbsp;</label>
                            <input type="email" name="trader_Email" required="" placeholder="name@email.com" maxlength="100" inputmode="email" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Contact Number</label>
                            <input type="text" name="trader_Number" required="" placeholder="011 748 0203" maxlength="12" inputmode="tel" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Company Name</label>
                            <input type="text" name="trader_companyName" required="" placeholder="My Company" maxlength="100" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Area</label>
                            <input type="text" name="trader_area" required="" placeholder="Area" maxlength="55" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Message</label>
                            <textarea rows="3" wrap="hard" spellcheck="true" name="trader_message" placeholder="Your message here." maxlength="300"  class="form-control"></textarea>
                        </div>
                        <div class="g-recaptcha" data-sitekey="6LdpFmEUAAAAAEzDfECKSzsRAdAOrcX_AuLB0myX"></div><br>
                        <button class="btn btn-success text-center" type="submit">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                <div class="card" style="margin:15px;">
                    <div class="card-body contact_form">
                        <h4>Contact Details</h4><i class="fa fa-phone" style="font-size:20px;"></i>
                        <p class="d-inline" style="padding-left:10px;"><?php echo $contact ?></p>

                        <br><i class="fa fa-envelope-o" style="font-size:20px;"></i>
                        <p class="d-inline" style="padding-left:10px;">sales@vanitapasta.co.za</p><br><br>
                        <h4 class="d-inline" style="padding-top:10px;padding-left:10px;">Address</h4><i class="fa fa-map-marker" style="font-size:20px;"></i>
                        <p style="padding-left:10px;">
                            <?php echo $address."<br>".$street."<br>".$suburb."<br>".$city."<br>" ?>
                            Gauteng<br>
                            South Africa</p><br>
                        </p>
                    </div>
                </div>
                <div class="card" style="margin:15px;">
                    <div class="card-body contact_form" style="height:360px;">
                        <div style="height:100%;width:100%;"><iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d11234.435802320128!2d28.281876182088485!3d-26.20503365241058!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xcb1188278996f3f6!2sReef+Industrial+Park!5e0!3m2!1sen!2sza!4v1526210932975" width="100%" height="100%" frameborder="0" style="border:0" allowfullscreen></iframe></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php include 'inc/footer.php'?>