<?php

include "inc/head.php";

$out_put ='';
if(isset($_GET['order_number'])){
    $orderNum = mysqli_real_escape_string($con, $_GET['order_number']);


    $sql_order = "SELECT * FROM orders WHERE order_num = '".$orderNum."'";
    $order_detail = $db->select($sql_order);
    if(sizeof($order_detail)==1){
        $first_name = $order_detail[0]['first_name'];
        $last_name = $order_detail[0]['last_name'];
        $email = $order_detail[0]['email'];
        $contact = $order_detail[0]['contact'];
        $building = $order_detail[0]['building'];
        $street = $order_detail[0]['street'];
        $suburb = $order_detail[0]['suburb'];
        $city = $order_detail[0]['city'];
        $province = $order_detail[0]['province'];
        $postal = $order_detail[0]['postal'];
        $shipping_method = $order_detail[0]['shipping_method'];
        $delivery_msg = $order_detail[0]['delivery_msg'];


        $out_put =' ';



        $out_put .= '
            <div class="row">
                <div class="col-sm-10 col-md-10 col-lg-10 col-xl-10 offset-1">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a><span>Cart</span></a></li>
                        <li class="breadcrumb-item"><a><span>Shipping</span></a></li>
                        <li class="breadcrumb-item"><a><span>Summary</span></a></li>
                        <li class="breadcrumb-item"><a><span class="text-success">Payment Success</span></a></li>
                    </ol>
                </div>
            </div>
            <div class="row">
        <div class="col-sm-10 col-md-10 col-lg-10 col-xl-10 offset-1">
            <div class="card">
                <div class="card-header text-center">
                    <h5>Thank you for your purchase, below are your order details.</h5>
                   
                    
                    <a href="../admin/admin_dashboard/orders/orders_pdf/'.$orderNum.'.pdf" download  class="btn btn-outline-primary btn-sm ">Download Invoice</a>

                </div>
                <div class="card-body">
                    <div>
                        <h5>Order Details:</h5>
                        <div class="float-left">
                            <p><b>Customer Details:</b></p>
                            <p>
                                <span>Name: '.$first_name.' '.$last_name.' </span><br>
                                <span>Email: '.$email.'</span><br>
                                <span>Contact Number: '.$contact .'</span><br>
                            </p><br>
                            <p><b>Delivery Instructions:</b></p>
                            <p>'.$delivery_msg .'</p>
                        </div>

                        <div class="float-right">
                            <p><b>Shipping Details:</b></p>
                            <p>
                                <span>Shipping Method: <?php echo $shipping_method ?></span><br>
                                <span>'.$building.'</span><br>
                                <span>'.$street .'</span><br>
                                <span>'.$suburb.'</span><br>
                                <span>'.$city .'</span><br>
                                <span>'.$province .'</span><br>
                                <span>'.$postal.'</span><br>

                            </p>
                        </div>
                    </div>
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
                        <tbody>
                            ';

        $sql_products = "SELECT * FROM order_product WHERE order_number = '".$orderNum."'";
        $products = $db->select($sql_products);
        if(sizeof($products)>0){
            foreach ($products as $product_details){
                $sql_prodImg = "SELECT main_img FROM products WHERE id = '".$product_details['product_id']."'";
                $main_img = $db->select($sql_prodImg);
                $out_put .='<tr>
                                                <td><img width="50px" height="50px" src="img/product_img/'.$main_img[0]["main_img"].'"></td>
                                                <td>'.$product_details['product_name'].'</td>
                                                <td>'.$product_details['variant_name'].'</td>
                                                <td>R '.number_format($product_details['price'], 2, ',',',').'</td>
                                                <td>'.$product_details['qty'].'</td>
                                                <td align="right">R '.number_format($product_details['line_total'],2, ',',',').'</td>
                                            </tr>';
            }
        }
        $sql_totals = "SELECT * FROM order_totals WHERE order_number = '".$orderNum."'";
        $totals = $db->select($sql_totals);


        $out_put.= '
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="5" class="text-right" >Subtotal (<span class="no_of_items_2"></span> items) </td>
                                    <td align="right"><span>R '.number_format($totals[0]['subtotal'],2, ',', ',').'</span></td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="text-right">Shipping</td>
                                    <td align="right"><span>R '.number_format($totals[0]['ship_total'],2, ',', ',').'</span></td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="text-right">Tax @ 15% (included)</td>
                                    <td align="right"><span >R '.number_format($totals[0]['tax'],2, ',', ',').'</span></td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="text-right"><b>Total</b></td>
                                    <td align="right"><span>R '.number_format($totals[0]['final_total'],2, ',', ',').'</span></td>
                                </tr>
                                </tfoot>
                          

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        
        ';
       // exit(json_encode(array("status" => 1, "msg" => $out_put)));















    }else{
        echo 'Error with order Number';
        // exit(json_encode(array("status" => 0, "msg" => 'Error with order Number' )));
    }
}else{
    // Error with order contact us
   // exit(json_encode(array("status" => 0, "msg" => 'Error with form' )));
    echo 'Error with form' ;
}













?>
    <title>Payment Success | Vanita Pasta</title>
    <meta name="keywords" content="">
    <meta name="description" content="">


<?php

include "inc/head_2.php";
?>
<div id="order_success"><?php
    echo $out_put ?>
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
                <li style="margin-top:10px;"><a href="customer_account.php" class="text-white">My Account</a></li>
                <li style="margin-top:10px;"><a href="track_my_order.php" id="#" class="text-white">Track My Order</a></li>
                <?php if(isset($_SESSION['user_id'])){
                    echo '<li style="margin-top:10px;"><a href="customer_logout.php" class="text-white">Log Out</a></li>';
                }else{
                    echo '<li style="margin-top:10px;"><a href="customer_login.php" class="text-white">Login</a></li>';
                } ?>

            </ul>
        </div>
        <div class="col-sm-12 col-md-3 col-lg-3 col-xl-3 text-white">
            <h5>COMPANY DETAILS</h5><p>
                <?php echo $address."<br>".$street."<br>".$suburb."<br>".$city."<br>" ?>
                Gauteng<br>
                South Africa</p>

            <p>
                <span><i class='fa fa-envelope'></i>  info@vanitapasta.co.za</span><br>
                <span><i class='fa fa-phone'></i>  <?php echo $contact ?></span>
            </p>

        </div>
        <div class="col-sm-12 col-md-3 col-lg-3 col-xl-3">
            <h5>GET SOCIAL</h5>
            <div>
                <a href="<?php echo $facebook ?>" style="background-color:rgba(255,255,255,0);"><i class="typcn typcn-social-facebook-circular" style="color:rgb(255,255,255);font-size:40px;"></i></a>
                <a href="<?php echo $instagram?>" style="background-color:rgba(255,255,255,0);"><i class="typcn typcn-social-instagram" style="color:rgb(255,255,255);font-size:40px;"></i></a>
                <a href="<?php echo $google_plus?>" style="background-color:rgba(255,255,255,0);"><i class="typcn typcn-social-google-plus-circular" style="color:rgb(255,255,255);font-size:40px;"></i></a>
                <a href="<?php echo $youtube?>" style="background-color:rgba(255,255,255,0);"><i class="typcn typcn-social-youtube" style="color:rgb(255,255,255);font-size:40px;"></i></a>
            </div><br>
            <a href="https://www.payfast.co.za"><img class="img-fluid" src="img/secure-payments.png"></a>

        </div>
    </div>
    <div class="row">
        <div class="col text-center"><span><i class="fa fa-copyright"></i>Vanita Pasta 2018</span></div>
    </div>
</footer>
<div class="modal fade" role="dialog" tabindex="-1" id="cart">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">SHOPPING CART</h5><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button></div>
            <div class="modal-body">
                <form action="" method="">
                    <div class="table-responsive" id="cart_table">
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


                            </tfoot>
                        </table>
                    </div>
                </form>
                <p class="text-muted text-right">Shipping and taxes will be calculated at checkout.</p>
            </div>
            <div class="modal-footer">
                <div>
                    <button class="btn btn-outline-secondary" type="button" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary d-none" type="submit" id="checkOutdiv">Proceed to checkout</button>
                </div>
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
<script type="text/javascript">

    $(document).ready(function(){

        //Load_order();
         function Load_order (){
                    //alert("func working");
                 if (sessionStorage['order_num'] == null) {
                    // window.location.href = "index.php";

                 }else{
                    order_num_array = JSON.parse(sessionStorage['order_num'].toString());
                    if(order_num_array != ''){

                        // need to write ajax to pull the order from db
                        $.ajax({
                            url: "process_files/order_success_process.php",
                            method: "POST",
                            dataType: "json",
                            data: {order_num: order_num_array },
                            success: function (response) {
                                if (response.status == 0) {
                                    alert(response.msg);
                                    //window.location.href = "index.php";
                                } else if (response.status == 1) {
                                    $("#order_success").html(response.msg);


                                //clear_cart();




                                }
                            }

                        });


                    }

                 }


             }

        clear_cart();



        function clear_cart(){

            sessionStorage.clear();

            $("#no_of_items").text(0);
        }





    });
</script>
<script src='https://www.google.com/recaptcha/api.js'></script>
</body>

</html>
