<?php include '../admin/admin_dashboard/inc/functions.php';
secure_session_start();

include_once '../admin/inc/database.php';
$db = new Database();
$sql_shopDetails = "SELECT * FROM store_details";
$store_details = $db->select($sql_shopDetails);
$address = $store_details[0]['address'];
$street = $store_details[0]['street'];
$suburb = $store_details[0]['suburb'];
$city = $store_details[0]['city'];
$contact = $store_details[0]['contact_num'];

$sql_social  = "SELECT * FROM social_links ";
$social_links = $db->select($sql_social);
$facebook = $social_links[0]['facebook'];
$instagram = $social_links[0]['instagram'];
$google_plus = $social_links[0]['google_plus'];
$youtube = $social_links[0]['youtube'];
?>
<!DOCTYPE html>
<html>
<head>
<title>Check Out | Vanita Pasta</title>
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

<body><br>
    <div class="" style="background-color:#ffffff;">
        <div class="row">
            <div class="col-sm-12 text-center">
                <a href="index.php"><img src="assets/img/Vanita Logo.png" id="logoLarge"></a>
            </div>
        </div>
    </div><br><br>
    <div>
        <div class="row">
            <div class="col-sm-10 col-md-10 col-lg-10 col-xl-10 offset-1">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a><span>Cart</span></a></li>
                    <li class="breadcrumb-item"><a><span class="text-primary">Customer Infomation</span></a></li>
                    <li class="breadcrumb-item"><a><span class="text-muted">Shipping</span></a></li>
                    <li class="breadcrumb-item"><a><span class="text-muted">Payment</span></a></li>
                </ol>
            </div>
        </div>
        <div></div>
    </div>
    <div>
        <div class="container">
            <div>
                <table class="table table-sm">
                    <thead>
                    <tr>
                        <th colspan="2" >Product Name</th>
                        <th >Variant</th>
                        <th class="text-right">Unit Price</th>
                        <th class="text-center" width="15%">Qty</th>
                        <th class="text-right" >Totals</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody id="cartOutPut">

                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="5" class="text-right">Subtotal (<span class="no_of_items_2"></span> items) </td>
                        <td align="right"><span class="subtotal"></span></td>
                    </tr>
                    <tr>
                        <td colspan="5" class="text-right">Tax @ 15% (included)</td>
                        <td align="right"><span class="tax_check"></span></td>
                    </tr>
                    <tr>
                        <td colspan="5" class="text-right"><b>Total</b></td>
                        <td align="right"><span class="Cart_total_check"></span></td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <div class="row" style="background-color:rgba(213,215,215,0.31);">
        <div class="col text-center" style="background-color:rgba(204,204,204,0.46);padding-top:5%;">
            <div class="row" style="background-color:rgba(255,255,255,0);">
                <div class="col-sm-6 align-self-center"><a href="index.php" style="margin-top:0px;">&lt; Return to Store</a></div>
                <div class="col-sm-6 text-center"><a class="btn btn-primary btn-lg" id="checkOutBtn" role="button" href="cart_shipping.php">Proceed to Shipping</a></div>
            </div><br><br>

        </div>
    </div>
<?php include "inc/footer.php"?>