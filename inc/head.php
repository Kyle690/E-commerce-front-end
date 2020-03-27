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
?>



