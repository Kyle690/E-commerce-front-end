<?php
/**
 * Created by PhpStorm.
 * User: kyle
 * Date: 2018/06/29
 * Time: 12:05 PM
 */
include_once '../../admin/inc/database.php';
$db = new Database();
if(isset($_POST['email'])) {
    $firstName = mysqli_real_escape_string($con, $_POST['first_name']);
    $user_id = mysqli_real_escape_string($con,$_POST['user_id']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $sql_check = "SELECT email from customer_details WHERE email = '$email'";
    $result = $db->select($sql_check);
    if(sizeof($result) != 1){
        exit(json_encode(array("status" => 1, "msg" => 'Email can be used')));
    }else{
        $sql_compare = "SELECT email FROM customer_details WHERE id='$user_id'";
        $compare = $db->select($sql_compare);
        if($compare[0]['email'] == $email){
            exit(json_encode(array("status" => 1, "msg" => 'Email can be used')));
        }
        exit(json_encode(array("status" => 0, "msg" => 'Cannot use that email!')));
    }
}
if(isset($_POST['c_Update_email'])){
    $user_id = mysqli_real_escape_string($con, $_POST['user_id']);
    $first_name = mysqli_real_escape_string($con, $_POST['c_Update_firstName']);
    $last_name = mysqli_real_escape_string($con, $_POST['c_Update_lastName']);
    $email = mysqli_real_escape_string($con, $_POST['c_Update_email']);
    $contactNum = mysqli_real_escape_string($con, $_POST['c_Update_contactNum']);
    if(isset($_POST['marketing'])){
        $accept_marketing = 'yes';
    }else{
        $accept_marketing = 'no';
    }
    if(isset($_POST['newsletter'])){
        $accept_newsletter = 'yes';
    }else{
        $accept_newsletter = 'no';}

    $building = mysqli_real_escape_string($con, $_POST['c_s_Update_building']);
    $street = mysqli_real_escape_string($con, $_POST['c_s_Update_Street']);
    $suburb = mysqli_real_escape_string($con, $_POST['c_s_Update_suburb']);
    $city = mysqli_real_escape_string($con, $_POST['c_s_Update_city']);
    $province = 'Gauteng';
    $postal = mysqli_real_escape_string($con, $_POST['postal_code']);

    $sql_update_details = "UPDATE customer_details SET first_name=?, last_name=?, email=?, contact_num=?,marketing=?, newsletter=? WHERE id ='$user_id'";
    if($stmt = $mysqli->prepare($sql_update_details)){
        $stmt->bind_param('ssssss',$first_name, $last_name, $email, $contactNum , $accept_marketing, $accept_newsletter );

        if($stmt->execute()){
            $details_updated = TRUE;
        }else{
            // failer with the execute of stmt
            exit(json_encode(array("status" => 0, "msg" => 'error with execute of details')));
        }
    }else{
        // failure with preparing the statment
        exit(json_encode(array("status" => 0, "msg" => 'error with 1st stmt')));
    }if($details_updated){
        $sql_check_shipping  = "SELECT customer_id FROM customer_shipping_details WHERE customer_id ='$user_id'";
        $check_shipping = $db->select($sql_check_shipping);
        if(sizeof($check_shipping)==1){
            $sql_update_shipping = "UPDATE customer_shipping_details SET building_name=?, street=?,  suburb=?, city=?, province=?, postal_code=? WHERE customer_id ='$user_id' ";
            if($stmt = $mysqli->prepare($sql_update_shipping)){
                $stmt->bind_param('ssssss',$building, $street, $suburb, $city, $province, $postal );

                if($stmt->execute()){
                    header("Location: ../customer_account.php");
                }else{
                    // failer with the execute of stmt
                    exit(json_encode(array("status" => 0, "msg" => 'error with execute of shipping')));
                }
            }else{
                // failure with preparing the statment
                exit(json_encode(array("status" => 0, "msg" => 'error with 2nd stmt')));
            }
        }else{
            $sql_update_shipping_new = "INSERT INTO customer_shipping_details (building_name, street,  suburb, city, province, postal_code, customer_id) VALUES (?,?,?,?,?,?,?)";
            if($stmt = $mysqli->prepare($sql_update_shipping_new)){
                $stmt->bind_param('sssssss',$building, $street, $suburb, $city, $province, $postal, $user_id );

                if($stmt->execute()){
                    header("Location: ../customer_account.php");
                }else{
                    // failer with the execute of stmt
                    exit(json_encode(array("status" => 0, "msg" => 'error with execute of shipping')));
                }
            }else{
                // failure with preparing the statment
                exit(json_encode(array("status" => 0, "msg" => 'error with 2nd stmt')));
            }
        }




    }


}
