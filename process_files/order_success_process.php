<?php
/**
 * Created by PhpStorm.
 * User: kyle
 * Date: 2018/07/08
 * Time: 10:34 AM
 */
include '../../admin/admin_dashboard/inc/functions.php';
secure_session_start();
include_once '../../admin/inc/database.php';
$db = new Database();


if(isset($_POST['order_num'])){
    $orderNum = mysqli_real_escape_string($con, $_POST['order_num']);


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
                   
                    <button class="btn btn-outline-info btn-sm " onclick="window.open(href="orders_pdf/'.$orderNum.'.pdf")">Open Invoice</button>
                    <a href="orders_pdf/'.$orderNum.'.pdf" download  class="btn btn-outline-primary btn-sm ">Download Invoice</a>

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
        exit(json_encode(array("status" => 1, "msg" => $out_put)));















    }else{
        exit(json_encode(array("status" => 0, "msg" => 'Error with order Number' )));
    }
}else{
    // Error with order contact us
    exit(json_encode(array("status" => 0, "msg" => 'Error with form' )));
}