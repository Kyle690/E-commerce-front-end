<?php

include "inc/head.php";

$title = "<title>Home | Vanita Pasta</title>";
$meta = '
<meta name="keywords" content="">
<meta name="description" content="">
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.3/cookieconsent.min.css" />
    <script src="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.3/cookieconsent.min.js"></script>
    <script>
        window.addEventListener("load", function(){
            window.cookieconsent.initialise({
                "palette": {
                    "popup": {
                        "background": "#edeff5",
                        "text": "#838391"
                    },
                    "button": {
                        "background": "#4b81e8"
                    }
                }
            })});
    </script>

';



include "inc/head_2.php";


$sql_display_products = "SELECT * FROM design_products";
$design_img = $db->select($sql_display_products);
$main_img_id = $design_img[0]['main_product_id'];
$product_1_id = $design_img[0]['1st_product'];
$product_2_id = $design_img[0]['2nd_product'];
$product_3_id = $design_img[0]['3rd_product'];


?>



    <div>
        <p id="error_messages" class="text-center text-danger"></p>
        <div class="carousel slide" data-ride="carousel" id="carousel-1" style="padding-top:0px;">
            <div class="carousel-inner" role="listbox">
                <div class="carousel-item"><img class="w-100 d-block">
                    <div class="jumbotron hero-nature carousel-hero">
                        <div style="background-color:rgba(0,0,0,0.25);">
                            <h2 class="hero-title" style="font-family:Amarante, cursive;background-color:rgba(0,0,0,0);">Providing South Africans&nbsp;</h2>
                            <h3 class="hero-subtitle" style="font-style:normal;font-weight:normal;background-color:rgba(0,0,0,0);">with a little taste of Italy</h3>
                        </div><br><br><br></div>
                </div>
                <div class="carousel-item">
                    <div class="jumbotron hero-photography carousel-hero">
                        <div style="background-color:rgba(0,0,0,0.25);">
                            <h2 class="hero-title" style="font-family:Amarante, cursive;background-color:rgba(0,0,0,0);">Providing South Africans&nbsp;</h2>
                            <h3 class="hero-subtitle" style="font-style:normal;font-weight:normal;background-color:rgba(0,0,0,0);">with a little taste of Italy</h3>
                        </div><br><br><br></div>
                </div>
                <div class="carousel-item active" style="height:100%;">
                    <div class="jumbotron hero-technology carousel-hero">
                        <div style="background-color:rgba(0,0,0,0.25);">
                            <h2 class="hero-title" style="font-family:Amarante, cursive;background-color:rgba(0,0,0,0);">Providing South Africans&nbsp;</h2>
                            <h3 class="hero-subtitle" style="font-style:normal;font-weight:normal;background-color:rgba(0,0,0,0);">with a little taste of Italy</h3>
                        </div><br><br><br>
                    </div>
                </div>
            </div>
            <div><a class="carousel-control-prev" href="#carousel-1" role="button" data-slide="prev"><i class="fa fa-chevron-left"></i><span class="sr-only">Previous</span></a><a class="carousel-control-next" href="#carousel-1" role="button" data-slide="next"><i class="fa fa-chevron-right"></i><span class="sr-only">Next</span></a></div>
            <ol
                class="carousel-indicators">
                <li data-target="#carousel-1" data-slide-to="0"></li>
                <li data-target="#carousel-1" data-slide-to="1"></li>
                <li data-target="#carousel-1" data-slide-to="2" class="active"></li>
                </ol>
        </div>
    </div>
    <div style="background-color:rgba(157,215,239,0);height:50%;">
        <div class="row" style="margin-right:0px;margin-left:0px;">
            <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 text-center" style="padding-top:0%;padding-bottom:0%;background-color:#009246;"><img src="assets/img/Vegeterian-Friendly-stamp.png"></div>
            <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 text-center" style="padding:0px;padding-top:0%;"><img src="assets/img/sa_farmers2.png" style="padding-top:18px;"></div>
            <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 text-center" style="padding-top:0%;background-color:#ce2b37;"><img src="assets/img/no_sugar_no_pres.png" style="padding-top:20px;"></div>
        </div>
    </div>
    <!-- Product Card -->
    <div class="parallax">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="text-white category" style="padding-top:23px;padding-bottom:34px;font-family:'Stardos Stencil', cursive;font-weight:normal;">Categories</h2>
                </div>
            </div>
            <div class="row">
                <div class="col">
                        <div class="text-center  "<?php
                        $sql_cat ="SELECT * FROM categories WHERE status = 'enabled'";
                        $categories = $db->select($sql_cat);
                        if(sizeof($categories)>0){
                            echo "<div class='container'>
                                    <div class='row'>";
                                for ($i=0; $i<4; $i++){
                                    echo "
                                    <div class='col-sm-6 col-md-3' style='padding-top: 2%; padding-bottom: 2%'>
                                        <div class='card'>
                                            <a href='categories.php?categorie_id=".$categories[$i]['id']."'>
                                                <img class='img-fluid card-img-top' src='img/category_img/".$categories[$i]['img_src']."'>
                                            </a>                                                      
                                            <div class='card-body'>                                                                                                                                                           
                                                <h5 style='font-family:Stardos Stencil, cursive '>".$categories[$i]['title']."</h5>                                                                                                                                                                
                                            </div>
                                        </div>
                                    </div>
                                    ";
                                }
                                echo "</div><div class='row offset-md-2'>";
                                if(sizeof($categories)>4){
                                    for($i=4; $i<7; $i++){
                                        echo "
                                    <div class='col-sm-6 col-md-3' style='padding-top: 2%; padding-bottom: 2%'>
                                        <div class='card'>
                                            <a href='categories.php?categorie_id=".$categories[$i]['id']."'>
                                                <img class='img-fluid card-img-top' src='img/category_img/".$categories[$i]['img_src']."'>
                                            </a>                                                      
                                            <div class='card-body'>                                                                                                                                                           
                                                <h5 style='font-family:Stardos Stencil, cursive '>".$categories[$i]['title']."</h5>                                                                                                                                                                
                                            </div>
                                        </div>
                                    </div>
                                    ";

                                    }
                                }









                          echo"</div></div>";

                        }





                        ?>


           		 </div>

	        <div class="container">
	            <div class="row">
	                <div class="col">
	                    <h2 class="text-white category" style="padding-top:47px;padding-bottom:27px;font-family:'Stardos Stencil', cursive;">Featured Products</h2>
	                </div>
	            </div>
	            <div class="row" style="margin-top:0px;padding-top:15px;padding-bottom:15px;">
	                <div class="col">
	                    <div class="card">
	                        <div class="card-body">
	                            <div class="row"><?php
                                    $main_prod_sql = "SELECT * FROM products WHERE id = '$main_img_id'";
                                    $main_prod = $db->select($main_prod_sql);
                                    if(sizeof($main_prod) == 1){
                                        echo '
                                        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6"><img class="img-fluid" src="img/product_img/'.$main_prod[0]['main_img'].'"></div>
                                        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 align-self-center product">
                                            <h3 data-aos="zoom-out-right" data-aos-delay="100" style="font-family: Stardos Stencil, cursive">'.$main_prod[0]['title'].'</h3>
                                            <p data-aos="zoom-out-left" data-aos-delay="100">'.$main_prod[0]['description'].'</p>
                                            <a class="btn btn-outline-primary btn-sm" role="button" href="product.php?product_id='.$main_prod[0]['id'].'" data-aos="zoom-out" data-aos-delay="200">View More</a>
                                        </div>                                                                                                                      
                                        ';
                                    }
                                    ?>


	                            </div>
	                            <hr style="padding-top:0px;padding-bottom:0px;">
	                            <div class="row" style="padding:10px;">

	                                <div class="col">
	                                    <div class="card-group"><?php
                                            if(isset($product_1_id)) {
                                                $sql_product_1 = "SELECT * FROM products WHERE id = '$product_1_id'";
                                                $product_1 = $db->select($sql_product_1);
                                                if (sizeof($product_1) == 1) {
                                                    echo '
                                               <div class="card" style="margin:20px;"><img class="img-fluid card-img-top w-100 d-block" src="img/product_img/' . $product_1[0]['main_img'] . '" style="max-height:200px;">
	                                            <div class="card-body">
                                                        <h4 class="card-title">' . $product_1[0]['title'] . '</h4>
                                                        <p class="card-text">' . $product_1[0]['description'] . '</p>
                                                        <a href="product.php?product_id=' . $product_1[0]['id'] . '"" class="btn btn-primary btn-sm">View More</a>
                                                       
                                                    </div>
                                                </div>
                                               
                                               ';
                                                }
                                            }
                                            if(isset($product_2_id)){
                                                $sql_product_2 = "SELECT * FROM products WHERE id = '$product_2_id'";
                                                $product_2 = $db->select($sql_product_2);
                                                if(sizeof($product_2)==1){
                                                    echo'
                                                    <div class="card" style="margin:20px;"><img class="img-fluid card-img-top w-100 d-block" src="img/product_img/' . $product_2[0]['main_img'] . '" style="max-height:200px;">
                                                        <div class="card-body">
                                                                <h4 class="card-title">' . $product_2[0]['title'] . '</h4>
                                                                <p class="card-text">' . $product_2[0]['description'] . '</p>
                                                                <a href="product.php?product_id='. $product_2[0]['id'].'"" class="btn btn-primary btn-sm">View More</a>
                                                               
                                                        </div>
                                                    </div>
                 
                                                    
                                                    ';
                                                }
                                            }
                                            if (isset($product_3_id)){
                                                $sql_product_3 ="SELECT * FROM products WHERE id = '$product_3_id'";
                                                $product_3 = $db->select($sql_product_3);
                                                if(sizeof($product_3)==1){
                                                    echo'
                                                    <div class="card" style="margin:20px;"><img class="img-fluid card-img-top w-100 d-block" src="img/product_img/' . $product_3[0]['main_img'] . '" style="max-height:200px;">
                                                        <div class="card-body">
                                                                <h4 class="card-title">' . $product_3[0]['title'] . '</h4>
                                                                <p class="card-text">' . $product_3[0]['description'] . '</p>
                                                                <a href="product.php?product_id='. $product_3[0]['id'].'"" class="btn btn-primary btn-sm">View More</a>
                                                               
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
	            </div>
	        </div>
    	</div>
    </div>
    </div>
    <div>
        <div class="row align-items-center" style="height:226px;">
            <div class="col-6 text-center">
                <h3 style="font-family:'Allerta Stencil', sans-serif;">DELIVERED</h3>
                <h5 style="font-family:'Allerta Stencil', sans-serif;">STRIAGHT TO YOUR DOOR</h5>
                <h6 style="font-family:'Allerta Stencil', sans-serif;">FOR YOUR CONVENIENCE</h6>
            </div>
            <div class="col-6"><img class="img-fluid" src="assets/img/vanita_delivery_2.png"></div>
        </div>
    </div>
    <!-- Newsletter block -->
    <div class="newsletter" style="height:100%;">
        <div class="row" style="padding-top:60px;padding-bottom:60px;">
            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 offset-0 text-center">
                <h3 class="d-inline category text-white" id="join_news">Join our Newsletter</h3>
            </div>
            <div class="col-sm-4 col-md-4 offset-sm-4 offset-md-4 text-center">
                <button type="button" data-toggle="modal" data-target="#news_sign_up" class="btn btn-primary">Sign Up</button>
            </div>
        </div>
    </div>
    <div class="testimonials-clean">
        <div class="container">
            <div class="intro">
                <h2 class="text-center">Testimonials </h2>
                <p class="text-center">Our customers love us! Read what they have to say below.&nbsp;</p>
            </div>
            <div class="row people" style="padding-bottom:150px;">
                <div class="col-md-6 col-lg-4 item">
                    <div class="box">
                        <p class="description">Vanita’s pastas are tasty and wholesome. They offer a person a time saving, healthy, affordable and unique alternative to standard store-bought pasta meals.They also offer delivery to your home, which is a great option for anyone
                            who has time-constraints and is unable to get to the shops.</p>
                    </div>
                    <div class="author"><i class="fas fa-smile d-inline-block"></i>
                        <h5 class="d-inline name">Lauren Conway</h5>
                        <p class="title">Sales Magnus Steel</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 item">
                    <div class="box">
                        <p class="description">I consider myself a very fussy food lover. Though I was hesitant of frozen food, Vanita Pasta's lasagne delivered mouth watering, homemade pasta and sauces that brought back memories of childhood. Everything I have tasted has only
                            proven to be very tasty, innovative and completely wholesome. Defintely coming back for more!</p>
                    </div>
                    <div class="author"><i class="fa fa-smile-o d-inline"></i>
                        <h5 class="d-inline-block name">Vicci Katsiginis</h5>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 item">
                    <div class="box">
                        <p class="description">Aliquam varius finibus est, et interdum justo suscipit. Vulputate quis leo in, vehicula rhoncus lacus. Praesent aliquam in tellus eu.</p>
                    </div>
                    <div class="author"><i class="fa fa-smile-o d-inline"></i>
                        <h5 class="name">Emily Clark</h5>
                        <p class="title">Owner of Creative Ltd.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="news_sign_up">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Newsletter Sign Up</h5>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" id="news_name" name="news_name" maxlength="40" placeholder="First Name">
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" class="form-control" id="newsletter_email" name="newsletter_email" placeholder="Email Address" aria-label="Recipient's username" aria-describedby="basic-addon2">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="news_letter_sign_btn" class="btn btn-sm btn-primary">Sign Up</button>
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </div>

        </div>
    </div>
<?php
include "inc/footer.php";

?>