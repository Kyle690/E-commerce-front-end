<?php
/**
 * Created by PhpStorm.
 * User: kyle
 * Date: 2018/06/25
 * Time: 9:46 PM
 */
include_once '../../admin/inc/database.php';
$db = new Database();
if(isset($_POST['email'])){
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $newsletter = 'yes';

    $sql_check_email = "SELECT email from customer_details WHERE email ='$email'";
    $email_check = $db->select($sql_check_email);
    if(sizeof($email_check)==0){

        $sql_insert = "INSERT INTO customer_details (first_name, email, newsletter) VALUES (?,?,?)";
        if($stmt= $mysqli->prepare($sql_insert)){
            $stmt->bind_param('sss', $name, $email, $newsletter);

            if($stmt->execute()){
                exit(json_encode(array("status" => 1, "msg" => 'Customer loaded successfully!')));
            }else{
                // failer with the execute of stmt
                echo "error with executing sql ";
            }
        }else{
            // failure with preparing the statment
            echo "error with preparing the statement";
        }





    }else{
        exit(json_encode(array("status" => 0, "msg" => 'Email already exists!')));
    }

}