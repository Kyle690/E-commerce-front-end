<?php
include "inc/head.php";



if(isset( $_SESSION['user_id'])){

 $sql_customer = "SELECT * FROM customer_details WHERE id ='".$_SESSION['user_id']."'";
 $customer_details = $db->select($sql_customer);
 if(sizeof($customer_details) ==1){
     $first_name = $customer_details[0]['first_name'];
     $last_name = $customer_details[0]['last_name'];
     $contact_number = $customer_details[0]['contact_num'];
     $email = $customer_details[0]['email'];
     $marketing_status = $customer_details[0]['marketing'];
     $newsletter_status = $customer_details[0]['newsletter'];

     $sql_shipping = "SELECT * FROM customer_shipping_details WHERE customer_id = '".$_SESSION['user_id']."'";
     $shipping_details = $db->select($sql_shipping);
     if(sizeof($shipping_details)==1){
         $building_name = $shipping_details[0]['building_name'];
         $street = $shipping_details[0]['street'];
         $suburb = $shipping_details[0]['suburb'];
         $city = $shipping_details[0]['city'];
         $province = $shipping_details[0]['province'];
         $postal = $shipping_details[0]['postal_code'];

     }else{
         $building_name = '';
         $street ='';
         $suburb = '';
         $city = '';
         $province = '';
         $postal = '';
     }

 }



}else{
    //echo $_SESSION['user_id'];
    header("location: customer_login.php");
}
$title = ' <title>Account | Vanita Store</title>';
$meta = '<meta title="description" content="Customer account details." >';

include "inc/head_2.php";
?>
    <div class="c-portal">
        <div class="container">
            <div class="row">
                <div class="col" style="padding-top:20px;">
                    <h1 class="text-center text-white" style="padding-top:22px;padding-bottom:22px;background-color:rgba(0,0,0,0.22);">Welcome back <?php echo $first_name ?></h1>
                </div>
            </div>
            <div class="row" style="padding-bottom:15px;">
                <div class="col-sm-12 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Details</h4>
                            <p>
                                <span><?php echo $first_name." ".$last_name; ?></span><br>
                                <span><?php echo $contact_number ?></span><br>
                                <span><?php echo $email ?></span><br>
                                <span>Accept marketing: <b><?php echo $marketing_status ?></b></span><br>
                                <span>Newsletter signed up: <b><?php echo $newsletter_status ?></b></span>

                            </p>
                            <a class="btn btn-primary" role="button" href="customer_details.php">Update Details</a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Shipping Details</h4>
                            <p>
                                <span><?php echo $building_name ?></span><br>
                                <span><?php echo $street ?></span><br>
                                <span><?php echo $suburb ?></span><br>
                                <span><?php echo $city ?></span><br>
                                <span><?php echo $province ?></span><br>
                                <span>South Africa</span><br>
                                <span><?php echo $postal ?></span><br></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" style="padding-bottom:10px;margin-bottom:0px;margin-top:10px;">
                <div class="col" style="padding-right:15px;padding-left:15px;">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">My Orders</h4>
                            <div class="table-responsive">
                                <table class="table table-hover table-sm">
                                    <thead>
                                        <tr>
                                            <th width="10%">Order No</th>
                                            <th width="20%">Date</th>
                                            <th width="20%">Invoice</th>
                                            <th width="30%">Fullfilment Status</th>
                                            <th width="20%">Value</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        $sql_order = "SELECT id, order_num, date_created FROM orders WHERE customer_id ='".$_SESSION['user_id']."' ORDER BY date_created DESC";
                                        $orders = $db->select($sql_order);
                                        if(sizeof($orders)>0) {


                                            foreach ($orders as $order_details) {
                                                $sql_status = "SELECT status FROM order_status WHERE order_id ='{$order_details['id']}' ";
                                                $order_status = $db->select($sql_status);
                                                $order_ful_status = $order_status[0]['status'];
                                                $sql_total = "SELECT final_total FROM order_totals WHERE order_id ='{$order_details['id']}' ";
                                                $order_total = $db->select($sql_total);

                                                echo "
                                            <tr>
                                                <td>{$order_details['order_num']}</td>
                                                <td>{$order_details['date_created']}</td>
                                                <td> <a href='../admin/admin_dashboard/orders/orders_pdf/{$order_details['order_num']}.pdf' download  class=\"btn btn-outline-primary btn-sm \">Download Invoice</a></td>
                                                ";
                                                if ($order_ful_status == 'delivered') {
                                                    echo "<td><span class='badge badge-success'>{$order_ful_status}</span></td>";
                                                }
                                                if ($order_ful_status == 'delivering') {
                                                    echo "<td><span class='badge badge-warning'>{$order_ful_status}</span></td>";
                                                }
                                                if ($order_ful_status == 'processing') {
                                                    echo "<td><span class='badge badge-primary'>{$order_ful_status}</span></td>";
                                                }
                                                if ($order_ful_status == 'Received') {
                                                    echo "<td><span class='badge badge-secondary'>{$order_ful_status}</span></td>";
                                                }


                                                echo "    
                                                <td align='right'>R {$order_total[0]['final_total']}</td>
                                            </tr>
                                            ";


                                            }
                                        }else{
                                            echo "<tr><td colspan='5' class='text-center'>You have not placed any orders yet! <a href='categories.php'>View Products</a></td></tr>";
                                        }
                                    ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
<?php include "inc/footer.php"?>