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
if(isset($_GET['product_id'])){
    $product_id = mysqli_real_escape_string($con, $_GET['product_id']);

    $sql_prod = "SELECT * FROM products WHERE id ='$product_id' AND status = 'enabled' ";
    $product = $db->select($sql_prod);
    if(sizeof($product)>0){
        $prod_title = $product[0]['title'];
        $prod_desc = $product[0]['description'];
        $prod_cooking = $product[0]['cooking'];
        $prod_storage = $product[0]['storage'];
        $prod_ingre = $product[0]['ingredients'];
        $prod_seo_title = $product[0]['seo_title'];
        $prod_seo_des = $product[0]['seo_description'];
        $main_img = $product[0]['main_img'];


        $img_2 = $product[0]['2nd_img'];
        $img_3 = $product[0]['3rd_img'];
        $img_4 = $product[0]['4th_img'];
        $img_5 = $product[0]['5th_img'];
        $prod_img_array = array($img_2, $img_3, $img_4, $img_5);




    }else{
        header("location: categories.php");
    }





}else{
    header("location: categories.php");
}

include "inc/head.php";



   $title ='<title>'.$prod_title.' | Products | Vanita Pasta </title>';
   $meta = '
    <meta name="description" content="'.$prod_seo_des.'">
    <meta name="keywords" content="'.$prod_seo_title.'">';
include "inc/head_2.php"; ?>
    <div>
        <div class="row">
            <div class="col-10 offset-1">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a><span>Home</span></a></li>
                    <li class="breadcrumb-item"><a><span>Products</span></a></li>
                    <li class="breadcrumb-item"><a><span><?php echo $prod_title ?></span></a></li>
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

                            $sql_cats = "SELECT * FROM categories";
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
                    <div class="row" style="margin-top:0px;padding-top:15px;">
                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <div class="row">
                                                <div class="col-sm-6 text-center" >
                                                    <a href="img/product_img/<?php echo $main_img ?>" data-lightbox="photos">
                                                        <img class="img-fluid" src="img/product_img/<?php echo $main_img ?>"></a>

                                                    <div class="container text-center my-3">
                                                        <div class="photo-gallery">
                                                            <div class="container">
                                                                <div class="row photos"><?php
                                                                    foreach ($prod_img_array as $img_details){
                                                                        if($img_details != ''){


                                                                        echo '
                                                                        <div class="col-sm-6 col-md-3 item">
                                                                           <div class="card">
                                                                                <div class="card-img">                                                                              
                                                                               <a href="img/product_img/'.$img_details.'" data-lightbox="photos">
                                                                                <img class="" width="100px" height="100px"  src="img/product_img/'.$img_details.'"></a>
                                                                           
                                                                                </div>
                                                                            </div>
                                                                         </div>
                                                                        ';}
                                                                    }


                                                                    ?>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                                    <h1 style="padding-bottom:0px;padding-top:10%;"><?php echo $prod_title ?></h1>
                                                    <p><?php echo $prod_desc ?></p>
                                                    <div class="form-group" style="padding-top:4%;">
                                                        <label><strong>Select Size</strong></label>
                                                        <select name="product_variant" required="" class="form-control var_select" style="padding-bottom:30px;">
                                                            <?php
                                                            $sql_varaints = "SELECT * FROM product_variants WHERE product_id = '" . $product_id . "'";
                                                            $variant = $db->select($sql_varaints);
                                                            $first_price = $variant[0]['var_price'];
                                                            $first_name = $variant[0]['var_name'];
                                                            $first_sku = $variant[0]['var_sku_code'];
                                                            $first_id = $variant[0]['id'];
                                                            foreach ($variant as $var_info) {
                                                                echo '
                                                                <option data-price='.$var_info['var_price'].' data-stockCode = '.$var_info['var_sku_code'].' data-varid = '.$var_info['id'].' data-varName = '.$var_info['var_name'].'>' . $var_info['var_name'] . '</option>
                                                                
                                                                ';
                                                            }



                                                            ?>
                                                        </select>
                                                    </div>
                                                    <h4 style="padding-top:5%;">R <span class="display_price"><?php echo $first_price?></span></h4>
                                                    <button class="btn btn-primary btn-sm float-right productItem " type="button" data-img="<?php echo $main_img ; ?>" data-price='<?php echo $first_price ?>' data-variant='<?php echo $first_name ?>' data-skucode ='<?php echo$first_sku?>' data-id='<?php echo $product_id?>' data-variant_id ='<?php echo $first_id?>' data-name='<?php echo $prod_title ?>'>Add to Cart</button>
                                                    <p style="padding-top:20px; font-size: 10px"><strong>WARNING:</strong> This product may contain traces of nuts.</p>
                                                </div>

                                        </div>
                                        <div class="col-sm-12" style="padding-bottom:15px;">
                                            <div style="padding-top:5%;">
                                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                              <li class="nav-item">
                                                <a class="nav-link active" id="ingredients-tab" data-toggle="tab" href="#ingredients" role="tab" aria-controls="ingredients" aria-selected="true">Ingredients</a>
                                              </li>
                                              <li class="nav-item">
                                                <a class="nav-link" id="cooking-tab" data-toggle="tab" href="#cooking" role="tab" aria-controls="cooking" aria-selected="false">Cooking Instructions</a>
                                              </li>
                                                <li class="nav-item">
                                                <a class="nav-link" id="storage-tab" data-toggle="tab" href="#storage" role="tab" aria-controls="storage" aria-selected="false">Storage Instructions</a>
                                              </li>
                                            </ul>
                                            <div class="tab-content" id="myTabContent">
                                              <div class="tab-pane fade show active" id="ingredients" role="tabpanel" aria-labelledby="ingredients-tab">
                                                  <p>
                                                     <?php echo $prod_ingre ?>
                                                  </p>
                                              </div>
                                                <div class="tab-pane fade" id="cooking" role="tabpanel" aria-labelledby="cooking-tab">
                                                    <p><?php echo $prod_cooking ?></p>
                                                </div>
                                                <div class="tab-pane fade" id="storage" role="tabpanel" aria-labelledby="storage-tab">
                                                    <p><?php echo $prod_storage ?></p>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                </div>
            <div class="row" style="padding-top:10px;padding-bottom:10px;">
                <div class="col">
                    <h3 class="text-white" style="font-family:'Sirin Stencil', cursive;">WE ALSO RECOMMEND</h3>
                    <div class="row"><?php
                        $sql_random_products = "SELECT * FROM products WHERE status='enabled' ORDER BY RAND() LIMIT 3";
                        $random_prod = $db->select($sql_random_products);
                        if(sizeof($random_prod)>0){
                            foreach ($random_prod as $prod_details){
                                echo'
                                    <div class="col-sm-4">
                                        <div class="card">
                                            <img class="img-fluid card-img" src="img/product_img/'.$prod_details['main_img'].'">
                                            <div class="card-body">
                                            
                                                <h4 class="card-title">'.$prod_details['title'].'</h4>
                                                <p class="card-text">'.$prod_details['description'].'</p>
                                                <a href="product.php?product_id=' .$prod_details['id']. '" class="btn btn-primary float-right" >View Product</a>
                                             </div>  
                                        </div>
                                    </div>
                                
                                ';
                            }
                        }




                        ?>



                    </div>
                </div>
            </div>
            </div>
    </div>
    </div>
    <div style="background-color:rgba(157,215,239,0);height:50%;">
        <div class="row justify-content-center align-items-stretch" style="margin-right:0px;margin-left:0px;">
            <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 text-center" style="background-color:#009246;"><img src="assets/img/Vegeterian-Friendly-stamp.png"></div>
            <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 text-center"><img src="assets/img/sa_farmers2.png" style="padding:11px;"></div>
            <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 text-center" style="background-color:#ce2b37;"><img src="assets/img/no_sugar_no_pres.png" style="padding-top:15px;"></div>
        </div>
    </div>
    <div class="social-icons">
        <div class="col">
            <h3 class="category" style="padding-bottom:0px;">Get Social&nbsp;</h3>
        </div>
        <a href="<?php echo $google_plus?>"><i class="icon ion-social-googleplus-outline" style="background-color:rgba(98,173,197,0);color:#e41104;"></i></a>
        <a href="<?php echo $facebook ?>"><i class="icon ion-social-facebook" style="color:rgb(59,89,152);"></i></a>
        <a href="<?php echo $instagram?>"><i class="icon ion-social-instagram"></i></a>
        <a href="<?php echo $youtube?>"><i class="icon ion-social-youtube" style="color:rgb(211,79,70);"></i></a>
    </div>

<?php include 'inc/footer.php'?>