<?php
include "inc/head.php";

// Delete canceled order
if(isset($_GET['order_number'])){
$ordernum = mysqli_real_escape_string($con, $_GET['order_number']);
//delete order from orders
$sql_orders = "DELETE FROM orders WHERE order_num='$ordernum'";

if($con->query($sql_orders) === TRUE){
    $delete_from_orders = TRUE;
    }else{
    exit(json_encode(array("status" => 0, "msg" => "Cant delete from order")));
    }
    //delete order from order products
    if($delete_from_orders){
    $sql_order_product = "DELETE FROM order_product WHERE order_number = '$ordernum'";
    if($con->query($sql_order_product) === TRUE){
    $deleted_from_order_product = TRUE;
    }else{
    exit(json_encode(array("status" => 0, "msg" => "Cant delete from order products")));
    }
    }
    //delete order from order totals
    if($deleted_from_order_product){
    $sql_order_totals = "DELETE FROM order_totals WHERE order_number = '$ordernum'";
    if($con->query($sql_order_totals) === TRUE){
    $deleted_from_order_total = TRUE;
    }else{
    exit(json_encode(array("status" => 0, "msg" => "Cant delete from order total")));
    }
    }

    // delete order from order status
    if($deleted_from_order_total){
    $sql_delete_status = "DELETE FROM order_status WHERE order_num = '$ordernum' ";
    if($con->query($sql_delete_status) === TRUE){
    $msg = 'Your order has been canceled or an error has occurred, please try again if you wish to place an order with us.';
    }else{
    exit(json_encode(array("status" => 0, "msg" => "Cant delete from order status")));
    }
    }
}
$title = "<title>Order Canceled | Vanita Pasta</title>";
$meta = '';
include "inc/head_2.php";
?>
<div>
    <div class="row">
        <div class="col-sm-10 col-md-10 col-lg-10 col-xl-10 offset-1">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a><span>Cart</span></a></li>
                <li class="breadcrumb-item"><a><span>Shipping</span></a></li>
                <li class="breadcrumb-item"><a><span>Summary</span></a></li>
                <li class="breadcrumb-item"><a><span class="text-danger">Payment Canceled</span></a></li>
            </ol><br><br>
        </div>
    </div>
    <div class="row" style="padding-top: 5%; padding-bottom: 10%">
        <div class="col-sm-12 col-md-6 offset-md-3 text-center">
            <h5>Your order has been canceled or an error has occurred, you can continue shopping <a href="index.php">here</a></h5><br>
            <h5>We hope to see you soon.</h5>
            <h5>Regards The Vanita Pasta Team</h5>
        </div><br><br>
    </div>
<?php include "inc/footer.php";

