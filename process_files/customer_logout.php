<?php
/**
 * Created by PhpStorm.
 * User: kyle
 * Date: 2018/06/29
 * Time: 1:20 PM
 */
include_once ("../../admin/admin_dashboard/inc/functions.php");
secure_session_start();

if( isset( $_SESSION ['user_id'])){
    session_destroy();
    header("location: ../index.php");
}else{
    header("location:../index.php");
    //echo "error with cookie";
}