<?php
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


if(isset($_GET['categorie_id'])){
    $cat_id = mysqli_real_escape_string($con, $_GET['categorie_id']);
    $sql_category = "SELECT id, title, seo_description, seo_title FROM categories WHERE id = '$cat_id' AND status ='enabled'";

    $result = $db->select($sql_category);
    if(sizeof($result) == 1){
        $cat_title = $result[0]['title'];
        $seo_desciption = $result[0]['seo_description'];
        $seo_key_words = $result[0]['seo_title'];
        $sql_products_id = "SELECT * FROM category_products";
        $cat_prod = $db->select($sql_products_id);
        if(sizeof($cat_prod) > 0){
            $product_id_array = array();
            foreach ($cat_prod as $cat_products){
                $cat_prod_array = explode(',',$cat_products['category_id']);
                if(in_array($cat_id, $cat_prod_array)){
                    array_push($product_id_array, $cat_products['product_id']);
                }
            }


        }
    }
}else{

    $sql_products_select = "SELECT id FROM products WHERE status = 'enabled'";
    $product_id = $db->select($sql_products_select);
    $product_id_array = array();
    foreach ($product_id as $id){
        array_push($product_id_array, $id['id']);
    }
    //print_r($product_id_array);
        $cat_title='';
    /*
    $sql_cat_no_select = "SELECT id, title, seo_description, seo_title FROM categories ORDER BY RAND() LIMIT 1";
    $result_no_select = $db->select($sql_cat_no_select);
    $cat_title = $result_no_select[0]['title'];
    $seo_desciption = $result_no_select[0]['seo_description'];
    $seo_key_words = $result_no_select[0]['seo_title'];
    $sql_products_id = "SELECT * FROM category_products";
    $cat_prod = $db->select($sql_products_id);
    if(sizeof($cat_prod) > 0){
        $product_id_array = array();
        foreach ($cat_prod as $cat_products){
            $cat_prod_array = explode(',',$cat_products['category_id']);
            if(in_array($result_no_select[0]['id'], $cat_prod_array)){
                array_push($product_id_array, $cat_products['product_id']);
            }
        }


    }
*/


}

include "inc/head.php";


  $title = ' <title>'.$cat_title.' | Vanita Pasta | Categories</title>';
  $meta = '<meta name="keywords" content="'.$seo_key_words.'">
           <meta name="description" content="'.$seo_desciption.'">';


 include "inc/head_2.php"?>
    <div>
        <div class="row">
            <div class="col-10 offset-1">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a><span>Home</span></a></li>
                    <li class="breadcrumb-item"><a><span>Products</span></a></li>
                    <li class="breadcrumb-item"><a><span><?php echo $cat_title ?></span></a></li>
                </ol>
            </div>
        </div>
    </div>
    <div class="parallax">
        <div class="container" style="margin-top:0px;margin-bottom:0px;height:100%;">
            <div class="row" style="padding-top:5px;padding-bottom:10px;">
                <div class="col-lg-3 col-xl-3 offset-0">
                    <h4 class="text-uppercase text-center text-white d-sm-none d-lg-block d-xl-block d-none" style="padding-top:10px;font-family:'Stardos Stencil', cursive;">Categories</h4>
                    <div class="dropdown d-md-block d-lg-none d-xl-none d-sm-block"><button class="btn btn-light btn-block dropdown-toggle" data-toggle="dropdown" aria-expanded="false" type="button">Categories&nbsp;</button>
                        <div class="dropdown-menu" role="menu"><?php

                            $sql_cats = "SELECT * FROM categories WHERE status ='enabled'";
                            $cat_display = $db->select($sql_cats);
                            if(sizeof($cat_display)>0){
                                foreach ($cat_display as $cat_mobile){
                                    echo'
                                     <a class="dropdown-item" role="presentation" href="categories.php?categorie_id='.$cat_mobile['id'].'">'.$cat_mobile['title'].'</a>
                                    
                                    ';
                                }
                            }
                            ?>
                        </div>
                    </div>
                    <ul class="nav nav-tabs flex-column nav-fill d-sm-none d-lg-block d-none">
                        <?php

                        if(sizeof($cat_display)>0){
                            foreach ($cat_display as $category){
                                echo '
                                <li class="nav-item"><a class="nav-link active category_btn" href="categories.php?categorie_id='.$category['id'].'" data-bs-hover-animate="pulse">'.$category['title'].'</a></li>        
                               
                                ';
                            }
                        }

                        ?>

                    </ul>
                </div>
                <div class="col-sm-12 col-md-12 col-lg-9 col-xl-9 offset-0">
                    <div class="row" style="margin-top:0px;padding-top:15px;"><?php
                            if(isset($product_id_array)) {
                                if(sizeof($product_id_array)>0) {
                                    foreach ($product_id_array as $product_id) {
                                        $sql_products = "SELECT * FROM products WHERE id = '$product_id' AND status = 'enabled'";
                                        $product_details = $db->select($sql_products);
                                        if(sizeof($product_details)>0){

                                            echo '
                                        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6" style="padding-top:5px;padding-bottom:5px;">
                                            <div class="card" style="padding:0px;margin:10px;">
                                                <img class="img-fluid card-img" src="img/product_img/' . $product_details[0]['main_img'] . '">
                                                <div class="card-body">
                                                    <div class="text-center"></div>
                                                    <h4 class="card-title" style="font-family:Stardos Stencil, cursive ">' . $product_details[0]['title'] . '</h4>
                                                    <p class="card-text" style="margin-bottom:0px;">' . $product_details[0]['description'] . '</p>
                                                    <div class="form-group" style="padding-top:4%;">
                                                        <label><strong>Select Variant</strong></label>
                                                        <select  class="form-control var_select" style="padding-bottom:30px;">
                                                            ';

                                            $sql_varaints = "SELECT * FROM product_variants WHERE product_id = '" . $product_details[0]['id'] . "'";
                                            $variant = $db->select($sql_varaints);
                                            $first_price = $variant[0]['var_price'];
                                            $first_name = $variant[0]['var_name'];
                                            $first_sku = $variant[0]['var_sku_code'];
                                            $first_id = $variant[0]['id'];
                                            foreach ($variant as $var_info) {
                                                echo '
                                                                <option data-price="'.$var_info['var_price'].'" data-stockCode = "'.$var_info['var_sku_code'].'" data-varid = "'.$var_info['id'].'" data-varName = "'.$var_info['var_name'].'">'.$var_info['var_name'].'</option>
                                                                
                                                                ';
                                            }




                                        echo '</select>
                                                    </div>
                                                    <h6 class="text-right text-muted card-subtitle mb-2" style="margin-top:15px;">R <span class="display_price">'.$first_price.'</span></h6>
                                                        <a class="card-link" href="product.php?product_id=' . $product_details[0]['id'] . '" style="padding-bottom:0px;margin-bottom:0px;">View Product Details</a>
                                                        <button class="btn btn-primary btn-sm float-right productItem " type="button" data-img="'.$product_details[0]['main_img'].'"  data-price="'.$first_price.'" data-variant="'.$first_name.'" data-skucode ="'.$first_sku.'" data-id="'.$product_details[0]['id'].'" data-variant_id ="'.$first_id.'" data-name="'.$product_details[0]['title'].'">Add to Cart</button>
                                                    </div>
                                            </div>
                                        </div>
                                    
                                    
                                    
                                    
                                    ';}

                                    }


                                } else {
                                    echo "
                                        <div class='col-sm-12'>
                                            <div class='card'>
                                                    <div class='card-body text-center'>
                                                        <p>There are no products in this category.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        ";
                                }
                            }
                        ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div style="background-color:rgba(157,215,239,0);height:50%;">
        <div class="row justify-content-center align-items-stretch" style="margin-right:0px;margin-left:0px;">
            <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 text-center" style="background-color:#009246;">
                <img src="assets/img/Vegeterian-Friendly-stamp.png"></div>
            <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 text-center" style="background-color:#ffffff;"><img src="assets/img/sa_farmers2.png" style="padding:11px;"></div>
            <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 text-center" style="background-color:#ce2b37;"><img src="assets/img/no_sugar_no_pres.png" style="padding-top:15px;"></div>
        </div>
    </div>
    <div class="social-icons">
        <div class="col">
            <h3 class="category" style="padding-bottom:0px;">Get Social&nbsp;</h3>
        </div>
        <a href="<?php echo $google_plus ?>"><i class="icon ion-social-googleplus-outline" style="background-color:rgba(98,173,197,0);color:#e41104;"></i></a>
        <a href="<?php echo $facebook ?>"><i class="icon ion-social-facebook" style="color:rgb(59,89,152);"></i></a>
        <a href="<?php echo $instagram ?>"><i class="icon ion-social-instagram"></i></a>
        <a href="<?php echo $youtube ?>"><i class="icon ion-social-youtube" style="color:rgb(211,79,70);"></i></a>
    </div>

<?php
include "inc/footer.php"?>