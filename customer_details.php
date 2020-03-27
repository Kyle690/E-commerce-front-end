<?php include "inc/head.php";

if(isset($_SESSION['user_id'])){
    $sql_customer_details = "SELECT * FROM customer_details WHERE id = '".$_SESSION['user_id']."'";
    $c_details = $db->select($sql_customer_details);
    $first_name = $c_details[0]['first_name'];
    $last_name = $c_details[0]['last_name'];
    $contact_num = $c_details[0]['contact_num'];
    $email = $c_details[0]['email'];
    $marketing = $c_details[0]['marketing'];
    $newsletter = $c_details[0]['newsletter'];

    if($marketing == 'yes'){
        $marketing_status = 'checked';
    }else{
        $marketing_status = '';
    }
    if($newsletter == 'yes'){
        $newsletter_status = 'checked';
    }else{
        $newsletter_status='';
    }

    $sql_shipping = "SELECT * FROM customer_shipping_details WHERE customer_id = '".$_SESSION['user_id']."'";
    $shipping_details = $db->select($sql_shipping);
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
    header("location: customer_login.php ");
}

$title = '<title>Customer Details | Vanita Pasta</title>';
$meta = '<meta name="description" content="Update your details here.">';

 include "inc/head_2.php";
?>
    <div class="c-portal" style="height:100%;">
        <div class="container c-portal">
            <form method="post" id="Update_cust_details" action="process_files/customer_details_update.php">


            <div class="row">

                    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6" style="padding-top:20px;">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="text-muted card-title">Person Details</h4>

                                    <div class="form-row">
                                        <div class="col">
                                            <div class="form-group">
                                                <label>First Name</label>
                                                <input class="form-control" type="text" name="c_Update_firstName" value="<?php echo $first_name ?>" required="" placeholder="John">
                                            </div>
                                            <div class="form-group">
                                                <label>Last Name</label>
                                                <input class="form-control" type="text" name="c_Update_lastName"  value="<?php echo $last_name ?>" required="" placeholder="Smith">
                                            </div>
                                            <div class="form-group">
                                                <label>Contact Number</label>
                                                <input class="form-control" type="tel" name="c_Update_contactNum"  value="<?php echo $contact_num ?>" required="" placeholder="073 123 4567">
                                            </div>
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input class="form-control" type="email" id="c_Update_email" name="c_Update_email"  value="<?php echo $email ?>" required="" placeholder="johnsmith@me.com">
                                            </div>
                                            <div class="form-group">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" <?php echo $marketing_status ?> name="marketing" id="formCheck-1">
                                                    <label class="form-check-label" for="formCheck-1">Accept marketing</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" <?php echo $newsletter_status ?> name="newsletter" id="formCheck-2">
                                                    <label class="form-check-label" for="formCheck-2">Receive newsletter</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6" style="padding-top:20px;">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="text-muted card-title">Shipping details</h4>
                                <form>
                                    <div class="form-group">
                                        <label>Unit number &amp; Complex Name</label>
                                        <input class="form-control" type="text" name="c_s_Update_building"  value="<?php echo $building_name_c ?>" placeholder="Complex Name" id="ship_complex">
                                    </div>
                                    <div class="form-group">
                                        <label>Street address</label>
                                        <input class="form-control" type="text" name="c_s_Update_Street"  value="<?php echo $street_c ?>" required="" placeholder="Street" id="ship_street">
                                    </div>
                                    <div class="form-group">
                                        <label>Suburb</label>
                                        <input class="form-control" type="text" name="c_s_Update_suburb"  value="<?php echo $suburb_c ?>" required="" placeholder="Suburb" id="ship_suburb">
                                    </div>
                                    <div class="form-group">
                                        <label>City</label>
                                        <input class="form-control" type="text" name="c_s_Update_city"   value="<?php echo $city_c ?>" required="" placeholder="City" id="ship_city">
                                    </div>
                                    <div class="form-group">
                                        <label>Province</label>
                                        <select class="form-control" name="c_s_Update_province"  disabled="" required="" id="ship_province">
                                            <option value="" selected="">Gauteng</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Country</label>
                                        <select class="form-control form-control" name="c_s_Update_country" disabled="" required="" id="ship_country">
                                            <option value="">South Africa</option>
                                        </select>
                                        <p style="font-size:11px;">We are only able to ship with in Gauteng, South Africa at this time.</p>
                                    </div>
                                    <div class="form-group">
                                        <label>Postal Code</label>
                                        <input class="form-control" name="postal_code"  value="<?php echo $postal_c ?>" maxlength="4" placeholder="Postal Code" required="">
                                        <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']?>">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

            </div>
            <div class="row" style="padding:10px;padding-right:25%;padding-left:25%;">
                <div class="col">
                    <button class="btn btn-primary btn-block" id="update_details" data-username ="<?php echo $_SESSION['user_firstName']?>" data-user="<?php echo $_SESSION['user_id']?>" type="button">Update</button>
                </div>
            </div>
            </form>
        </div>
    </div>
<?php
include "inc/footer.php";

?>