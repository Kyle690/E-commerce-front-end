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

$sql_shipping = "SELECT * FROM shipping_details";
$shipping_store = $db->select($sql_shipping);
$cost_per_km  = $shipping_store[0]['cost_per_km'];
$free_ship = $shipping_store[0]['free_ship'];
$max_dist = $shipping_store[0]['max_dist'];

$first_name = '';
$last_name = '';
$contact_number = '';
$email = '';
$customer_id = '';

if(isset($_SESSION['user_id'])){
  $sql_cust_details = "SELECT * FROM customer_details WHERE id = '".$_SESSION['user_id']."'";
  $cust_details = $db->select($sql_cust_details);
  if(sizeof($cust_details)==1){
      $first_name = $cust_details[0]['first_name'];
      $last_name = $cust_details[0]['last_name'];
      $contact_number = $cust_details[0]['contact_num'];
      $email = $cust_details[0]['email'];

      $customer_id = $_SESSION['user_id'];

      $sql_cust_shipping ="SELECT * FROM customer_shipping_details WHERE customer_id = '".$_SESSION['user_id']."'";
      $shipping_details = $db->select($sql_cust_shipping);
      if(sizeof($shipping_details)==1){
          $building_name_c = $shipping_details[0]['building_name'];
          $street_c = $shipping_details[0]['street'];
          $suburb_c = $shipping_details[0]['suburb'];
          $city_c = $shipping_details[0]['city'];
          $province_c = $shipping_details[0]['province'];
          $postal_c = $shipping_details[0]['postal_code'];

      }else{
          $building_name_c = '';
          $street_c = '';
          $suburb_c = '';
          $city_c = '';
          $province_c = '';
          $postal_c = '';
      }
  }else{
      $first_name = '';
      $last_name = '';
      $contact_number = '';
      $email = '';
      $customer_id = ' ';

  }




}else{
    $first_name = '';
    $last_name = '';
    $contact_number = '';
    $email = '';
    $customer_id = ' ';
    $building_name_c = '';
    $street_c = '';
    $suburb_c = '';
    $city_c = '';
    $province_c = '';
    $postal_c = '';
    $customer_id = ' ';
}

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shipping | Vanita Pasta</title>
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
    <div class="" style="background-color:#ffffff;">
        <div class="row">
            <div class="col text-center"><a href="index.php"><img src="assets/img/Vanita Logo.png" id="logoLarge"></a></div>
        </div>
    </div>
    <div>
        <div class="row">
            <div class="col-sm-10 col-md-10 col-lg-10 col-xl-10 offset-1">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a><span>Cart</span></a></li>
                    <li class="breadcrumb-item"><a><span class="text-primary">Shipping</span></a></li>
                    <li class="breadcrumb-item"><a><span class="text-muted">Summary</span></a></li>
                    <li class="breadcrumb-item"><a><span class="text-muted">Payment</span></a></li>
                </ol>
            </div>
        </div>
        <div>
            <form>
                <div class="container">
                    <div class="form-row">
                        <div class="col-sm-12 col-md-6 offset-0" style="padding-top:10px;">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Contact Information</h4>
                                    <div class="form-row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <input class="form-control" type="text" id="firstName" value="<?php echo $first_name ?>" placeholder="First Name">
                                                <div class="invalid-feedback" id="firstName_feedback"></div>
                                            </div>

                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <input class="form-control" type="text" id="lastName" value="<?php echo $last_name ?>" placeholder="Last Name">
                                                <div class="invalid-feedback" id="lastName_feedback"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col">
                                            <div class="form-group"><input class="form-control" type="text" id="contactNumber" value="<?php echo $contact_number ?>" placeholder="Contact Number"></div>
                                            <div class="form-group">
                                                <input class="form-control" type="text" id="email" value="<?php echo $email ?>" placeholder="Email">
                                                <div class="invalid-feedback" id="email_feedback"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 offset-0" style="padding-top:10px;">
                            <div class="card">
                                <div class="card-body">
                                    <div>
                                        <h4 class="float-left">Shipping Details</h4>
                                        <div class="form-check float-right">
                                            <input class="form-check-input" type="checkbox" id="collect_from_store">
                                            <label class="form-check-label" for="formCheck-2">Collect from factory</label>
                                        </div>
                                    </div>
                                    <div id="shipping_details_input">
                                        <div class="form-group">
                                            <input class="form-control" type="text" id="building" value="<?php echo $building_name_c ?>" placeholder="Appartment, Suite, Building Name etc..">

                                        </div>
                                        <div class="form-group">
                                            <input class="form-control" type="text"  id="address" value="<?php echo $street_c ?>" placeholder="Street Address">
                                            <div class="invalid-feedback" id="address_feedback"></div>
                                        </div>
                                        <div class="form-group"><input class="form-control" id="suburb" type="text" value="<?php echo $suburb_c ?>" placeholder="Suburb"></div>
                                        <div class="form-group">
                                            <input class="form-control" type="text" id="city" value="<?php echo $city_c ?>" placeholder="City">
                                            <div class="invalid-feedback" id="city_feedback"></div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-sm-4">
                                                <div class="form-group"><select disabled="" class="form-control"><option value="" id="province" selected="">Gauteng</option></select></div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group"><select disabled="" class="form-control"><option value="South Africa" selected="">South Africa</option><option value="13">This is item 2</option><option value="14">This is item 3</option></select></div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group"><input class="form-control" type="text" id="postal" value="<?php echo $postal_c ?>" placeholder="Postal Code"></div>
                                            </div>
                                        </div>
                                        <p style="font-size:12px;">* Please not we currently do not deliver outside of the gauteng region, if you would like to make other arrangements please&nbsp;<a href="contact_us.php">contact us.</a></p>

                                        <textarea class="form-control" rows="3" id="specialInstructions" placeholder="Special Delivery instructions (optional)..."></textarea>
                                    </div><br>
                                    <button type="button" class="btn btn-primary  btn-sm" id="get_results">Update Shipping info</button>
                                    <div style="padding-top:40px;">

                                        <h5 class="d-inline-block" style="margin-bottom:0px;">Shipping Cost:&nbsp;</h5>
                                        <p class="d-inline-block">R&nbsp;</p>
                                        <p class="d-inline" id="shipping_cost"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="row" style="background-color:rgba(213,215,215,0.31);">
        <div class="col text-center" style="background-color:rgba(204,204,204,0.46);padding-top:5%;">
            <div class="row" style="background-color:rgba(255,255,255,0);">
                <div class="col-sm-6 align-self-center"><a href="cart_checkout.php" style="margin-top:0px;">&lt; Return to Cart</a></div>
                <div class="col-sm-6 text-center">
                    <button type="button" class="btn btn-primary btn-lg" id="Confirm_shipping" role="button">Proceed to Summary</button></div>
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

    <div class="modal fade" role="dialog" tabindex="-1" id="order_update">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Get an Update on your order</h4><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button></div>
                <div class="modal-body">
                    <h6 class="text-muted">Simply enter your order no below and see how where your order is.</h6>
                    <form method="post"><input class="form-control form-control" type="text"></form>
                </div>
                <div class="modal-footer"><button class="btn btn-primary" type="button"  name="order_status">Submit</button>
                    <button class="btn btn-light" type="button" data-dismiss="modal">Close</button>
                </div>
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
    <script>
        var shipping_details = [];
        $(document).ready(function() {

            $("#collect_from_store").change(function () {

                if($("#collect_from_store").is(":checked")){
                    $("#shipping_cost").text(0);

                    var shipping_method = "Collect"
                    load_shipping_session (0 , shipping_method);
                }else{
                    $("#shipping_cost").text(' ');
                }

            });

            function validate_cust_details() {
                var firstName = $("#firstName").val();
                var lastName = $("#lastName").val();
                var contactNumber = $("#contactNumber").val();
                var email = $("#email").val();
                var specialInstructions = $("#specialInstructions").val();
                var firstNameValid = false;
                var lastNameValid = false;
                var contactNumberValid = false;
                var emailValid = false;
                var customer_id = '<?php echo $customer_id ?>';

                if (firstName == '') {
                    $("#firstName").addClass("is-invalid");
                    $("#firstName_feedback").text("Please enter your name!");
                } else {
                    $("#firstName").removeClass("is-invalid");
                    firstNameValid = true

                }
                if (lastName == '') {
                    $('#lastName').addClass("is-invalid");
                    $("#lastName_feedback").text("Please enter your last name!");
                } else {
                    $("#lastName").removeClass("is-invalid");
                    lastNameValid = true
                }

                if (lastNameValid == true && firstNameValid == true) {
                    if (sessionStorage['customer_details'] = !null) {
                        localStorage.removeItem(customer_details);

                    }
                    var customer_details = [firstName, lastName, contactNumber, email, specialInstructions, customer_id];
                    sessionStorage['customer_details'] = JSON.stringify(customer_details);
                }
            }

            $(function () {

                $('#get_results').click(function (e) {
                    e.preventDefault();

                    validate_cust_details();


                    // street validation
                    var streetAddress = $("#address").val();
                    var suburb = $("#suburb").val();
                    var city = $("#city").val();
                    var province = $("#province").val();
                    var country = $("#country").val();

                    validate_address();

                    function validate_address() {
                        addressValid = false;
                        cityValid = false;
                        if ((streetAddress == '')) {
                            $("#address").addClass("is-invalid");
                            $("#address_feedback").text("Please enter your address!");


                        } else {
                            $("#address").removeClass("is-invalid");
                            addressValid = true;

                        }
                        if ((city == '')) {
                            $("#city").addClass("is-invalid");
                            $("#city_feedback").text("Please enter your city!");
                        } else {
                            $("#city").removeClass("is-invalid");
                            cityValid = true;
                        }


                    }

                    if (cityValid && addressValid) {
                        var destination = streetAddress + ', ' + suburb + ', ' + city + ', ' + country;


                        // calculates the distance
                        var origin = 'reef industrial park, dunswart, boksburg, south africa'
                        var destination = destination;

                        var service = new google.maps.DistanceMatrixService();
                        service.getDistanceMatrix(
                            {
                                origins: [origin],
                                destinations: [destination,],
                                travelMode: google.maps.TravelMode.DRIVING,
                                unitSystem: google.maps.UnitSystem.METRIC,
                                avoidHighways: false,
                                avoidTolls: false,
                            }, callback);

                        function callback(response, status) {
                            if (status == 'OK') {
                                var origins = response.originAddresses;
                                var destinations = response.destinationAddresses;

                                for (var i = 0; i < origins.length; i++) {
                                    var results = response.rows[i].elements;
                                    for (var j = 0; j < results.length; j++) {
                                        var element = results[j];
                                        var distance = element.distance.text;
                                        var distance_val = element.distance.value;
                                        var distance_in_km = distance_val / 1000;
                                    }

                                    // Shipping cost calculator
                                    var shipping_cal = false;

                                    if($("#collect_from_store").is(":checked")) {
                                        $("#shipping_cost").text(0);
                                    }else {

                                        if (distance_in_km <= <?php echo $free_ship ?>) {
                                            var shipping_final_cost = 0;
                                            $("#shipping_cost").text(0);
                                            shipping_cal = true;

                                        } else {
                                            if (distance_in_km < <?php echo $max_dist ?>) {
                                                var cost_per_kilo = <?php echo $cost_per_km ?>;
                                                var distance_less_free_shipping = distance_in_km - 5;
                                                var shipping_final_cost = Math.floor(distance_less_free_shipping * cost_per_kilo);
                                                $("#shipping_cost").text(shipping_final_cost);

                                                shipping_cal = true;
                                            } else {
                                                alert("Sorry we do not ship to your area yet, please contact us or collect from store.")
                                            }

                                        }
                                    }


                                }
                                var shipping_method = 'Shipping';
                                load_shipping_session(shipping_final_cost, shipping_method);

                            }
                        }


                        //console.log(sessionStorage);
                    }


                });


            });

            function load_shipping_session (shipping_cost, ship_method){
                //alert("Shipping function");
                var shipping_value = $("#shipping_cost").text();
                validate_cust_details();
                if ( shipping_value != ' ') {

                    if (sessionStorage['shipping_details'] = !null) {
                        localStorage.removeItem(shipping_details);

                    }

                    // street validation
                    var building = $("#building").val();
                    var streetAddress = $("#address").val();
                    var suburb = $("#suburb").val();
                    var city = $("#city").val();
                    var province = 'Gauteng';
                    var country = 'South Africa';
                    var postal = $("#postal").val();
                    var shipping_method = ship_method;

                    var shipping_details = [building, streetAddress, suburb, city, province, country, postal, shipping_cost, shipping_method];
                    sessionStorage['shipping_details'] = JSON.stringify(shipping_details);

                }
            }

            $("#Confirm_shipping").click(function () {
                if($("#shipping_cost").text() == ''){
                    alert("Please update shipping details!");
                }else{
                    window.location.href="cart_summary.php";
                }
            })


        });

    </script>
    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAPwjkdQEg9eLknV7RPE-6I6lsoZkIyk8c">




    </script>
    </body>

    </html>