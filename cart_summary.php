<?php
include '../admin/admin_dashboard/inc/functions.php';
secure_session_start();
include_once '../admin/inc/database.php';
$db = new Database();

if (empty($_SESSION['key']))
    $_SESSION['key'] = str_shuffle("986asdscbfyanslasdk*786986as57876039201-102394");
        // php 7 onlybin2hex(random_bytes(32));

//create CSRF token
$csrf = hash_hmac('sha256', 'this is vanita Pasta', $_SESSION['key']);





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
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Summary | Vanita Pasta</title>
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
            <div class="col text-center">
                <a href="index.php"><img src="assets/img/Vanita Logo.png" id="logoLarge"></a>

            </div>
        </div>
    </div>
    <div>
        <div class="row">
            <div class="col-sm-10 col-md-10 col-lg-10 col-xl-10 offset-1">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a><span>Cart</span></a></li>
                    <li class="breadcrumb-item"><a><span>Shipping</span></a></li>
                    <li class="breadcrumb-item"><a><span class="text-primary">Summary</span></a></li>
                    <li class="breadcrumb-item"><a><span class="text-muted">Payment</span></a></li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col" style="padding:3%;">
                <div class="container">
                    <div class="card">
                        <div class="card-body">

                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th colspan="2" class="text-center">Product</th>
                                            <th>Variant</th>
                                            <th>Unit Price</th>
                                            <th>Qty</th>
                                            <th class="text-right">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody id="cartOutPut">

                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <td colspan="5" class="text-right" >Subtotal (<span class="no_of_items_2"></span> items) </td>
                                        <td align="right"><span class="subtotal"></span></td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" class="text-right">Shipping</td>
                                        <td align="right"><span class="shipping_costs"></span></td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" class="text-right">Tax @ 15% (included)</td>
                                        <td align="right"><span class="tax"></span></td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" class="text-right"><b>Total</b></td>
                                        <td align="right"><span class="Cart_total"></span></td>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div>
                                <div id="contactDetails" >

                                </div>

                                <div class="float-left" id='Address'>

                                </div>
                                <div class="float-right">
                                    <h6>Special Delivery Instructions:</h6>
                                    <p id="special_instructions"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <form id="first_form" method="POST" action="#">
            <div class="col-sm-12"  >
                <input type="hidden" name="csrf" id="csrf" value="<?php echo $csrf ?>">
            </div>
        </form>
        <form id="pf_form" method="POST" action="https://sandbox.payfast.co.za/eng/process">
            <div id="pf_form_data">

            </div>
        </form>

    </div>
    <div class="row" style="background-color:rgba(213,215,215,0.31);">
        <div class="col text-center" style="background-color:rgba(204,204,204,0.46);padding-top:5%;">
            <div class="row" style="background-color:rgba(255,255,255,0);">
                <div class="col-sm-6 align-self-center">
                    <a href="cart_shipping.php" role="button" style="margin-top:0px;">&lt; Return to Shipping</a>
                </div>
                <div class="col-sm-6 text-center">
                    <button type="button" id="check_out" class="btn btn-primary btn-lg" name="cart_submit">Check Out</button>
                </div>

            </div><br><br>

        </div>
    </div>
    <footer>
        <div class="row text-white">
            <div class="col-sm-12 col-md-3 col-lg-3 col-xl-3 text-white">
                <h5>INFORMATION</h5>
                <ul class="list-unstyled">
                    <li style="margin-top:10px;"><a href="privacy_policy.html" class="text-white">Privacy Terms</a></li>
                    <li style="margin-top:10px;"><a href="Terms_of_use.html" class="text-white" style="padding-top:0px;">Terms of use</a></li>
                    <li style="margin-top:10px;"><a href="shipping_terms.html" class="text-white">Shipping</a></li>
                    <li style="margin-top:10px;"><a href="returns.html" class="text-white">Returns</a></li>
                </ul>
            </div>
            <div class="col-sm-12 col-md-3 col-lg-3 col-xl-3 text-white">
                <h5>CUSTOMER DETAILS</h5>
                <ul class="list-unstyled">

                    <li style="margin-top:10px;"><a href="#" id="order_update_btn" class="text-white">Track My Order</a></li>
                    <?php if(isset($_SESSION['user_id'])){
                        echo '<li style="margin-top:10px;"><a href="customer_account.php" class="text-white">My Account</a></li>
                              <li style="margin-top:10px;"><a href="customer_logout.php" class="text-white">Log Out</a></li>';
                    }else{
                        echo '<li style="margin-top:10px;"><a href="customer_login.php" class="text-white">Login</a></li>';
                    } ?>

                </ul>
            </div>
            <div class="col-sm-12 col-md-3 col-lg-3 col-xl-3 text-white">
                <h5>COMPANY</h5><p>
                    <?php echo $address."<br>".$street."<br>".$suburb."<br>".$city."<br>" ?>
                    Gauteng<br>
                    South Africa</p><br>

            </div>
            <div class="col-sm-12 col-md-3 col-lg-3 col-xl-3">
                <h5>GET SOCIAL</h5>
                <div>
                    <a href="<?php echo $facebook ?>" style="background-color:rgba(255,255,255,0);"><i class="typcn typcn-social-facebook-circular" style="color:rgb(255,255,255);font-size:40px;"></i></a>
                    <a href="<?php echo $instagram?>" style="background-color:rgba(255,255,255,0);"><i class="typcn typcn-social-instagram" style="color:rgb(255,255,255);font-size:40px;"></i></a>
                    <a href="<?php echo $google_plus?>" style="background-color:rgba(255,255,255,0);"><i class="typcn typcn-social-google-plus-circular" style="color:rgb(255,255,255);font-size:40px;"></i></a>
                    <a href="<?php echo $youtube?>" style="background-color:rgba(255,255,255,0);"><i class="typcn typcn-social-youtube" style="color:rgb(255,255,255);font-size:40px;"></i></a>
                </div><br>
                <h5>CONTACT US</h5>
                <p>
                    <span><i class='fa fa-envelope'></i>  info@vanitapasta.co.za</span><br>
                    <span><i class='fa fa-phone'></i>  <?php echo $contact ?></span>
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col text-center"><span><i class="fa fa-copyright"></i>Vanita Pasta 2018</span></div>
        </div>
    </footer>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/bs-animation.js"></script>
    <script src="assets/js/cart_func.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.1.1/aos.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.8.2/js/lightbox.min.js"></script>
    <script src="assets/js/Paralax-Hero-Banner.js"></script>
    <script src="assets/js/store.js"></script>
    <script type="text/javascript">
        var shopcart = [];
        $(document).ready(function(){
            customer_details = JSON.parse(sessionStorage['customer_details'].toString());
            customerToHTML();
            function customerToHTML(){
                var firstName = customer_details[0];
                var lastName = customer_details[1];
                var contactNum = customer_details[2];
                var email = customer_details[3];
                var specialIntrutctions = customer_details[4];
                var customer_id = customer_details[5];


                customer_detail = "<p>"+firstName+" "+lastName+"<br>"+contactNum+"<br>"+email+"</p>";
                $("#contactDetails").html(customer_detail);
                $("#special_instructions").text(specialIntrutctions);


            }

            shipping_details = JSON.parse(sessionStorage['shipping_details'].toString());
            shippingToHTML();

            function shippingToHTML(){
                var shippingInfoHtml = "";
                var building = shipping_details[0]
                var address = shipping_details[1];
                var suburb = shipping_details[2];
                var city = shipping_details[3];
                var province = shipping_details[4];
                var country = shipping_details[5];
                var postal = shipping_details[6];
                var shippingCosts = parseInt(shipping_details[7]);
                var shipping_method = shipping_details[8];
                shippingInfoHtml = "<p>"+building+"<br>"+address+"<br>"+suburb+"<br>"+city+"<br>"+province+"<br>"+country+"<br>"+postal+"<br>Shipping Method: "+shipping_method+"</p>";
                $("#Address").html(shippingInfoHtml);



            }

            outputCart();

            function outputCart(){
                if(sessionStorage['sc'] != null){
                    shopcart = JSON.parse(sessionStorage['sc'].toString());


                }
                var cart_input ='';

                var holderHTML = "";
                var total = 0;
                var itemCount = 0;
                var tax = 0.15;
                var final_total = 0;
                var taxCal = 0;
                var shippingCosts = parseInt(shipping_details[7]);
                $.each(shopcart, function(index, value){

                    var sTotal = value.qty * value.price;
                    var a = (index+1);
                    total += sTotal ;
                    itemCount += parseInt(value.qty);
                    final_total = total + shippingCosts;
                    taxCal = final_total * tax;


                    holderHTML = holderHTML+'<tr><td><img width="50px" height="50px" src="img/product_img/'+value.img+'"></td><td><input type="hidden" name="item_name_'+a+'" value="'+value.name+'"( '+value.variant+')">'+ value.name+'</td><td>'+value.variant+'</td><td><input type=hidden name=amount_'+a+' value="'+formatMoneyWOR(value.price)+'">'+formatMoney(value.price)+'</td><td>'+value.qty+'<input type="hidden" class="form-control dynamicQty" data-variant="'+value.variant+'" data-id="'+value.id+'" name="quantity_'+a+'" value="'+value.qty+'"></td><td align="right">'+ formatMoney(sTotal)+"</td>";


                });
                //holderHTML += "<div>"+formatMoney(total)+"</div>";
                $(".shipping_costs").html(format_money(shippingCosts));
                $("#cartOutPut").html(holderHTML);
                $(".subtotal").html(formatMoney(total));
                $(".Cart_total").html(format_money(final_total));
                $(".no_of_items_2").html(itemCount);
                $(".tax").html(format_money(taxCal));







                $("#cart_inputs").html(cart_input);

            }
            function formatMoney(n){
                return "R " + (n/1).toFixed(2);
            }
            function formatMoneyWOR (n){
                return (n/100).toFixed(2);
            }
            function format_money(n) {
                return "R " + (n/1).toFixed(2);
            }

            $("#check_out").click(function () {
                var csfr = $("#csrf").val();
                customer_details = JSON.parse(sessionStorage['customer_details'].toString());

                shipping_details = JSON.parse(sessionStorage['shipping_details'].toString());

                shopcart = JSON.parse(sessionStorage['sc'].toString());
                var product_id = []
                var product_name =[];
                var variant_id = [];
                var variant_name =[];
                var qty_ = [];

                $.each(shopcart,function (index, value){
                    product_id.push(value.id);
                    product_name.push(value.name);
                    qty_.push(value.qty);
                    variant_id.push(value.variant_id);
                    variant_name.push(value.variant);
                });
                csfr_test = true;
                if(csfr_test){

                    //alert(customer_details+shipping_details+shopcart);
                    $.ajax({
                        url: "process_files/order_create.php",
                        method: "POST",
                        dataType: "json",
                        data: {csfr: csfr, customer_details: customer_details, shipping_details:shipping_details, product_id:product_id, product_name:product_name, qty_:qty_, variant_id: variant_id, variant_name:variant_name },
                        success: function (response) {
                            if (response.status == 0) {
                                alert(response.msg);
                                alert(response);
                            } else if (response.status == 1) {
                               $("#pf_form_data").html(response.msg);

                               $("#pf_form").submit();
                                if (sessionStorage['order_num'] = !null) {
                                    localStorage.removeItem(order_num);

                                }

                                var order_num = response.order_num;
                                sessionStorage['order_num'] = JSON.stringify(order_num);
                                //$("#pf_form_data").html(response.msg);





                                //







                            }
                        }

                    });



                }else{
                    alert("Error, please reload the page");
                }




            });

        })
</script>
</body>

</html>