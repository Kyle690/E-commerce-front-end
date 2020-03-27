<?php
/**
 * Created by PhpStorm.
 * User: kyle
 * Date: 2018/06/27
 * Time: 9:36 PM
 */?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php echo $title.$metadata; ?>
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
<div class="d-none d-md-block" style="background-color:#ffffff;">
    <div class="row">
        <div class="col text-center"><a href="index.php"><img src="assets/img/Vanita Logo.png" id="logoLarge"></a></div>
    </div>
</div>
<nav class="navbar navbar-light navbar-expand-md sticky-top bg-white" style="background-color:#319941;">
    <div class="container">
        <a class="navbar-brand" href="index.php"><img src="assets/img/Vanita Logo.png" id="logo" class="d-md-none d-lg-none d-xl-none" alt="logo"></a>
        <button class="navbar-toggler" data-toggle="collapse" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navcol-1">
            <ul class="nav navbar-nav mx-auto" style="color:rgb(139,160,200);">
                <li class="nav-item" role="presentation"><a class="nav-link text-uppercase active" href="categories.php">Products</a></li>
                <li class="nav-item" role="presentation"><a class="nav-link text-uppercase active" href="traders.php">Traders</a></li>
                <li class="nav-item" role="presentation"><a class="nav-link text-uppercase active" href="about_us.php">About Us</a></li>
                <li class="nav-item" role="presentation"><a class="nav-link text-uppercase active" href="contact_us.php">Contact Us</a></li>
                <li class="dropdown nav-item active"><a class="dropdown-toggle nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false" href="#">MY ACCOUNT</a>
                    <div class="dropdown-menu" role="menu"><?php
                        if(isset($_SESSION['user_id'])){
                            echo '  <a class="dropdown-item" role="presentation" href="customer_account.php">My Account</a>
                                    <a class="dropdown-item" role="presentation" href="process_files/customer_logout.php">Log Out</a>';
                        }else{
                            echo'
                            <a class="dropdown-item" role="presentation" href="customer_login.php">Login</a>
                            <a class="dropdown-item" role="presentation" href="customer_register.php">Register</a>
                            
                            ';
                        }


                        ?>

                    </div>
                </li>
                <li style="margin-top: -4px" class="nav-item" role="presentation"><a class="nav-link text-uppercase active" href="#" id="cart_btn">Cart<span class="fa-stack"><span class="fa fa-shopping-cart fa-stack-5x cart "></span><strong id="no_of_items" class="fa-stack-2x text-white" style="position:absolute;
            right:5%;
            top:-8%; font-size:50%;">1</strong></span></a></li>

            </ul><?php
                if(isset($_SESSION['user_firstName'])){
                   echo '<span class="navbar-text cart">Welcome, '.$_SESSION['user_firstName'].'</span>';
                }
            ?>

        </div>
    </div>
</nav>
<div class="row d-none" id="cookie_checker">
    <div class="col-sm-12 text-center  bg-danger">
        <p class="text-white">Cookies not enabled! Please enable cookies to get the full experince of our site. You can find out more about cookies <a href="https://cookiesandyou.com">here</a></p>
    </div>
</div>