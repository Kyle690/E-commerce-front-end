<?php
/**
 * Created by PhpStorm.
 * User: kyle
 * Date: 2018/07/02
 * Time: 8:42 PM
 */
include "inc/head.php";

if (empty($_SESSION['key']))
    $_SESSION['key'] = str_shuffle("ertfvsbaskfdsvbweorubsdfhakjhfsdkvjsdbfksg");
        //
        //bin2hex(random_bytes(32));

//create CSRF token
$csrf = hash_hmac('sha256', 'this is vanita Pasta', $_SESSION['key']);
$msg = '';
$div = '<div class="card" >
<form action="track_my_order.php" method="POST">
                    <div class="card-header">
                        <div class="card-title">
                            <h5>Track your order</h5>
                        </div>
                        <div><?php echo $msg ?></div>
                    </div>
                    <div class="card-body">
                        
                        <div class="form-group">
                            <label>Please enter your order number</label>
                            <p style="font-size: 10px">To track the order of your status.</p>
                            <input class="form-control" type="number" id="order_number" name="order_num" placeholder="Order Number">
                            <input type="hidden" name="csrf"  value="'.$csrf.'">
                        </div>
                    </div>
                    <div class="card-footer text-center">
                        <input class="btn-outline-primary btn" name="track_order" value="Track order status" type="submit">
                    </div>
                    </form>
                </div>';

if(isset($_POST['track_order'])){
    $csrf_check= mysqli_real_escape_string($con, $_POST['csrf']);
    $order_num = mysqli_real_escape_string($con, $_POST['order_num']);

    if($csrf_check == $csrf){

        $sql_check_order = "SELECT * FROM order_status WHERE order_num = '".$order_num."'";
        $result = $db->select($sql_check_order);
        if(sizeof($result) > 0 ){

            $status = $result[0]['status'];
            if($status == 'Received'){
                $date = $result[0]['date_created'];
                $status_checked = $status;
                $status_msg = "Your order has been ".$status_checked." on the ".$date.", we will attend to it as soon as possible.";
            }elseif ($status == 'processing'){
                $date = $result[0]['date_processed'];
                $status_checked = $status;
                $status_msg = "Your order has been processed on ".$date." and we are hard at work preparing something delicious, you will receive a notification when we are ready to deliver. ";
            }elseif($status == "delivering"){
                $date =$result[0]['date_delivery'];
                $status_msg = "Your order has been processed for delivery on ".$date.", one of our consultants will be in touch shortly.";
            }elseif($status == "delivered"){
                $date = $result[0]['date_delivered'];
                $status_msg = "Your order has been delivered on ".$date.", if you have any queries please "."<a href='contact_us.php'>contact us<a/>.";
            }elseif ($status == 'returned'){
                $sql_returned = "SELECT * FROM order_returned WHERE order_num = '".$order_num."'";
                $return_result = $db->select($sql_returned);
                if(sizeof($return_result)){
                    $date = $return_result['date_returned'];
                    $status_msg = "Your order was returned on ".$date.", if you have any queries please "."<a href='contact_us.php'>contact us<a/>.";

                }else{
                    $msg = "Error with the system!, please <a href='contact_us.php'>contact us<a/>.";
                }
            }

            $div = '<div class="card" >
                    <div class="card-header">
                        <div class="card-title">
                            <h5>Order Status</h5>
                        </div>
                        <div>'.$msg.'</div>
                    </div>
                    <div class="card-body">
                       <h5>Order Number: '.$order_num.'</h5> 
                       <p>'.$status_msg.'</p>
                    </div>
                    <div class="card-footer text-center">
                        <a class="btn btn-outline-primary" href="track_my_order.php">Try another Order Number</a>
                    </div>
                </div>';









        }else{
            $msg = "Order number does not exist!";
        }
    }
}

$msg_body = '<div class="card">
                    <div class="card-body text-danger">
                        <p>'.$msg.'</p>
                    </div>
                </div>';

if($msg != ''){
    $msg_dev_checked = $msg_body;
}else{
    $msg_dev_checked = '';
}



?>
    <title>Track my order | Vanita Pasta</title>
    <meta name="keywords" content="">
    <meta name="description" content="">



<?php

include "inc/head_2.php";
?>
<div class="c-portal">
    <div class="container">
        <div class="row">
            <div class="col-sm-3">

            </div>
            <div class="col-sm-6" style="padding-top: 40px; padding-bottom: 40px"  >

                <?php  echo $msg_dev_checked.$div ?>
            </div>
        </div>
    </div>
</div>




<?php
include "inc/footer.php";

?>
