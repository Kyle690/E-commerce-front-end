<?php include "inc/head.php";
include "inc/admin_email_store.php";
$email_admin = new admin_email_store();



$response = '';
if(isset($_POST['contact_name'])){
    $name = mysqli_real_escape_string($con, $_POST['contact_name']);
    $email = mysqli_real_escape_string($con, $_POST['contact_email']);
    $message = mysqli_real_escape_string($con, $_POST['contact_message']);

    if($email_admin->email_admin_contact($name, $email, $message, $db)){
        $response = "Details have been received, one of our service consultants will be in touch with you shortly.";
    }else{
        echo "Error: Please try again!";
    }

    /*
    ini_set("allow_url_fopen", true);
    $responseKey = $_POST['g-recaptcha-response'];
    $secretKey = "6LdpFmEUAAAAAGWLSh6HbcFGHqzvoWfXFiamxK33";
    $clientIP = $_SERVER['REMOTE_ADDR'];
    $url = "https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$responseKey&remoteip=$clientIP";
    $response = file_get_contents($url);
    $response = json_decode($response);
    if ($response->success) {
        // create email
        $email_admin->email_admin_contact($name, $email, $message, $db);
        $response = "Details have been received, one of our service consultants will be in touch with you shortly.";



    }else{
        echo "Error: Please try again!";
    }*/
}
$title ='<title>Contact Us | Vanita Pasta</title>';
include "inc/head_2.php"; ?>
    <div>
        <div class="jumbotron contact_us">
            <h1 class="category text-center text-white" style="padding-top:10%;font-family:'Aguafina Script', cursive;">We'd Love to hear from you</h1>
        </div>
    </div>
    <div style="height:70%;">
        <div class="row" style="padding-top:20px;padding-bottom:20px;margin-left:0px;margin-right:0px;">
            <div class="col-12 text-center">
                <p style="font-size:20px;">Simpy fill in the form below and one of our consultants will get back to you as soon as possible.</p>
                <p class="text-success"><?php echo $response;?></p>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6" id="contact_form_div" style="padding:18px;padding-top:10px;margin:0px;">
                <form method="POST"  class="contact_form" action="contact_us.php" style="padding-top:10px;margin:0px;">
                    <div class="form-group">
                        <label>Name</label>
                        <input class="form-control" id="name" type="text" placeholder="Name" name="contact_name" required="">
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input class="form-control" id="email" type="email" name="contact_email" placeholder="name@email.com" required="">
                    </div>
                    <div class="form-group">
                        <label>Message</label>
                        <textarea class="form-control" id="message" name="contact_message" rows="4" maxlength="255" placeholder="Your message here."></textarea>
                    </div>
                    <div class="g-recaptcha" data-sitekey="6LdpFmEUAAAAAEzDfECKSzsRAdAOrcX_AuLB0myX"></div><br>
                    <button class="btn btn-success btn-block text-center"  id="submit_contact_us" type="submit">Submit</button>
                </form>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6" id="contact_form_div" style="padding:18px;padding-top:10px;margin:0px;">

                <div  class="contact_form" >
                    <h4>Contact Details</h4><i class="fa fa-phone" style="font-size:20px;"></i>
                    <p class="d-inline" style="padding-left:10px;"><?php echo $contact ?></p><br>
                    <i class="fa fa-envelope-o" style="font-size:20px;"></i>
                    <p class="d-inline" style="padding-left:10px;">sales@vanitapasta.co.za</p><br>
                    <br><i class="fa fa-map-marker" style="font-size:20px;"></i>
                    <h4 class="d-inline" style="padding-top:10px;padding-left:10px;">Address</h4><p style="padding-left:10px;">
                    <p>
                        <?php echo $address."<br>".$street."<br>".$suburb."<br>".$city."<br>" ?>
                        Gauteng<br>
                        South Africa</p>

                </div>

            </div>
        </div>
    </div>
    <div>
        <div class="row">
            <div class="col-12">
                <div style="max-width:100%;"><iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d3579.597852132007!2d28.283160691217038!3d-26.20975711757974!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sza!4v1526050306207" width="1600" height="400" frameborder="0" style="border:0" allowfullscreen></iframe></div>
            </div>
        </div>
    </div>
    <div class="social-icons">
        <div class="col">
            <h3 class="category" style="padding-bottom:0px;">Get Social&nbsp;</h3>
        </div>
        <a href="<?php echo $google_plus ?>"><i class="icon ion-social-googleplus" style="background-color:rgba(98,173,197,0);color:#de2015;"></i></a>
        <a href="<?php echo $facebook ?>"><i class="icon ion-social-facebook" style="color:rgb(59,89,152);"></i></a>
        <a href="<?php echo $instagram ?>"><i class="icon ion-social-instagram"></i></a>
        <a href="<?php echo $youtube ?>"><i class="icon ion-social-youtube" style="color:rgb(211,79,70);"></i></a>
    </div>
<?php include 'inc/footer.php'?>