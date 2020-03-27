<?php
/**
 * Created by PhpStorm.
 * User: kyle
 * Date: 2018/06/25
 * Time: 7:31 PM
 */?>

<footer>
    <div class="row text-white">
        <div class="col-sm-12 col-md-3 col-lg-3 col-xl-3 text-white">
            <h5>INFORMATION</h5>
            <ul class="list-unstyled">
                <li style="margin-top:10px;"><a href="privacy_policy.html" class="text-white">Privacy Terms</a></li>
                <li style="margin-top:10px;"><a href="Terms_of_use.html" class="text-white" style="padding-top:0px;">Terms of use</a></li>
                <li style="margin-top:10px;"><a href="shipping_terms.html" class="text-white">Shipping</a></li>
                <li style="margin-top:10px;"><a href="returns.html" class="text-white">Returns</a></li>
            </ul>
        </div>
        <div class="col-sm-12 col-md-3 col-lg-3 col-xl-3 text-white">
            <h5>CUSTOMER DETAILS</h5>
            <ul class="list-unstyled">
                <li style="margin-top:10px;"><a href="track_my_order.php" id="#" class="text-white">Track My Order</a></li>
                <?php if(isset($_SESSION['user_id'])){
                    echo '
                        <li style="margin-top:10px;"><a href="customer_account.php" class="text-white">My Account</a></li>
                        <li style="margin-top:10px;"><a href="customer_logout.php" class="text-white">Log Out</a></li>';
                }else{
                    echo '<li style="margin-top:10px;"><a href="customer_login.php" class="text-white">Login</a></li>';
                } ?>

            </ul>
        </div>
        <div class="col-sm-12 col-md-3 col-lg-3 col-xl-3 text-white">
            <h5>COMPANY DETAILS</h5><p>
                <?php echo $address."<br>".$street."<br>".$suburb."<br>".$city."<br>" ?>
                Gauteng<br>
                South Africa</p>

                <p>
                    <span><i class='fa fa-envelope'></i>  info@vanitapasta.co.za</span><br>
                    <span><i class='fa fa-phone'></i>  <?php echo $contact ?></span>
                </p>

        </div>
        <div class="col-sm-12 col-md-3 col-lg-3 col-xl-3">
            <h5>GET SOCIAL</h5>
            <div>
                <a href="<?php echo $facebook ?>" style="background-color:rgba(255,255,255,0);"><i class="typcn typcn-social-facebook-circular" style="color:rgb(255,255,255);font-size:40px;"></i></a>
                <a href="<?php echo $instagram?>" style="background-color:rgba(255,255,255,0);"><i class="typcn typcn-social-instagram" style="color:rgb(255,255,255);font-size:40px;"></i></a>
                <a href="<?php echo $google_plus?>" style="background-color:rgba(255,255,255,0);"><i class="typcn typcn-social-google-plus-circular" style="color:rgb(255,255,255);font-size:40px;"></i></a>
                <a href="<?php echo $youtube?>" style="background-color:rgba(255,255,255,0);"><i class="typcn typcn-social-youtube" style="color:rgb(255,255,255);font-size:40px;"></i></a>
            </div><br>
            <a href="https://www.payfast.co.za"><img class="img-fluid" src="img/secure-payments.png"></a>

        </div>
    </div>
    <div class="row">
        <div class="col text-center"><span><i class="fa fa-copyright"></i>Vanita Pasta 2018</span></div>
    </div>
</footer>
<div class="modal fade" role="dialog" tabindex="-1" id="cart">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">SHOPPING CART</h5><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button></div>
            <div class="modal-body">
                <form action="" method="">
                    <div class="table-responsive" id="cart_table">
                        <table class="table table-sm">
                            <thead>
                            <tr>
                                <th colspan="2" >Product Name</th>
                                <th >Variant</th>
                                <th class="text-right">Unit Price</th>
                                <th class="text-center" width="15%">Qty</th>
                                <th class="text-right" >Totals</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody id="cartOutPut">


                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="5" class="text-right">Subtotal (<span class="no_of_items_2"></span> items) </td>
                                <td align="right"><span class="subtotal"></span></td>
                            </tr>
                            

                            </tfoot>
                        </table>
                    </div>
                </form>
                <p class="text-muted text-right">Shipping and taxes will be calculated at checkout.</p>
            </div>
            <div class="modal-footer">
                <div>
                    <button class="btn btn-outline-secondary" type="button" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary d-none" type="submit" id="checkOutdiv">Proceed to checkout</button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" role="dialog" tabindex="-1" id="order_update">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Get an Update on your order</h4><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button></div>
            <div class="modal-body">
                <h6 class="text-muted">Simply enter your order no below and see how where your order is.</h6>
                <form method="post"><input class="form-control form-control" type="text"></form>
            </div>
            <div class="modal-footer"><button class="btn btn-primary" type="button" name="order_status">Submit</button>
                <button class="btn btn-light" type="button" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/bs-animation.js"></script>
<script src="assets/js/cart_func.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.1.1/aos.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.8.2/js/lightbox.min.js"></script>
<script src="assets/js/Paralax-Hero-Banner.js"></script>
<script src="assets/js/store.js"></script>
<script type="text/javascript">
    var shopcart = [];
    $(document).ready(function(){

        cookies_enabled();

        function cookies_enabled (){
            var cookieEnabled = (navigator.cookieEnabled) ? true : false;
            if(cookieEnabled){
                $("#cookie_checker").addClass('d-none');
            }else{
                $("#cookie_checker").removeClass('d-none');
            }

        }




        $(".var_select").on("change", function(){

            var variant_name = $(this).val();
            var variant_price =  $("option:selected", this).data("price");
            var stockcode = $("option:selected", this).data("stockcode");
            var var_id = $("option:selected", this).data("varid");

            // Update data in button info // (Change to div card rather than tr)
            $(this).closest('.card').find(".productItem").attr({"data-variant":variant_name, "data-price":variant_price, "data-skucode":stockcode, "data-variant_id": var_id });
            // change display amount
            $(this).closest(".card").find(".display_price").text(variant_price);


        });

        outputCart();

        // Remove items from cart
        $('#cartOutPut').on("click", ".remove-item",function(){

            var itemToDelete = $(".remove-item").index(this);


            //$(this).closest(".row").find("input").data(itemToDelete).remove();

            shopcart.splice(itemToDelete,1);

            sessionStorage["sc"]=JSON.stringify(shopcart);

            outputCart();
            if(shopcart == ''){
                $("#checkOutdiv").addClass("d-none");
                $("#checkOutBtn").addClass("d-none");
                $("#no_items").removeClass("d-none");
            }

        });
        // Add items to cart
        $(".productItem").click(function(e){
            e.preventDefault();
            $('<div class="text-success">Product added.</div>').insertBefore(this).delay(2000).fadeOut();
            var iteminfo = $(this.dataset)[0];
            iteminfo.qty = 1;
            var iteminCart = false;

            // for each product, checking if item is in cart, if so then update the qty.
            $.each(shopcart, function(index, value){
                //console.log(index+ " "+ value.id);
                if(value.id == iteminfo.id && value.variant_id == iteminfo.variant_id){
                    value.qty = parseInt(value.qty) + parseInt(iteminfo.qty);
                    iteminCart = true;

                    $("#qty").data(index).val(value.qty);




                }
            });
            // if item is not in the cart, adds item to cart
            if(!iteminCart){
                shopcart.push(iteminfo);
                $("#checkOutdiv").removeClass("d-none");

            }
            sessionStorage['sc'] = JSON.stringify(shopcart);
            outputCart();

        });
        // output cart function
        function outputCart(){
            if(sessionStorage['sc'] != null){
                shopcart = JSON.parse(sessionStorage['sc'].toString());
                //console.log(sessionStorage['sc']);
                $("#checkOutdiv").removeClass("d-none");
                $("#no_items").addClass("d-none");
            }
            var holderHTML = "";
            var total = 0;
            var itemCount = 0;
            var tax = 0.15;
            var final_total = 0;
            var taxCal = 0;

            $.each(shopcart, function(index, value){
                //console.log(value);
                var sTotal = value.qty * value.price;
                var a = (index+1);
                total += sTotal ;
                itemCount += parseInt(value.qty);
                final_total = total;
                taxCal = total * tax;

                holderHTML = holderHTML+"<tr><td><img width='50px' height='50px' src='img/product_img/"+value.img+"'></td><input type='hidden'  name='product_id[]' value='"+value.id+"'>" + "<td><input type='hidden' name='product_name[]' value='"+value.name+"'>"+ value.name+"</td><td><input type='hidden' name='variant_id[]' value='"+value.variant_id+"'><input type='hidden' name='variant_name[]' value='"+value.variant+"'>"+value.variant+"</td><td align='right'><input type='hidden' name='unit_price[]' value='"+value.price+"'>"+formatMoney(value.price)+"</td><td class='text-center'><input type='number' class='form-control dynamicQty' data-variant='"+value.variant+"' data-id='"+value.id+"' name='qty_[]' value='"+value.qty+"'></td><td align='right'><input type='hidden' name='line_total[]' value='"+sTotal+"'>"+ formatMoney(sTotal)+"</td><td class='text-center'><span class='btn btn-danger btn-sm remove-item'><i class='fa fa-close'></i></span></td>";


            });



            $("#cartOutPut").html(holderHTML);
            $(".subtotal").html(formatMoney(total));
            //$(".Cart_total").html(formatMoney(final_total));
            //
            $("#no_of_items").text(itemCount);
            $(".no_of_items_2").html(itemCount);
            $(".tax_check").html(formatMoney(taxCal));
            $(".Cart_total_check").html(formatMoney(final_total));
           // $(".tax").html(formatMoney(taxCal));
            update_data();
        }
        // Money formatting
        function formatMoney(n){
            return "R " + (n/1).toFixed(2);
        }


        // Update the totals
        function update_data (){
            var subtotal = $(".subtotal").text();
            var shipping_cost = $("#shipping_cost").val();

            if(shipping_cost == ''){
                shipping_cost = 0;
            }
            var tax = 0.15;
            var final_total = parseFloat(subtotal) + parseFloat(shipping_cost);
            var tax_amount = (final_total * tax).toFixed(2);
            $(".Cart_total").html(formatMoney(final_total));
            $(".tax").html(formatMoney(tax_amount));

            $("#subtotal").val(subtotal);
            $("#ship_total").val(shipping_cost);
            $("#tax").val(tax_amount);
            $("#final_total").val(final_total);


        }

        // Update Quantities
        $('#cartOutPut').on("change keyup",".dynamicQty", function(){
            var iteminfo = $(this.dataset)[0];

            var iteminCart = false;

            var updatedQty = $(this).val();

            // for each product, checking if item is in cart, if so then update the qty.
            $.each(shopcart, function(index, value){

                if(value.id == iteminfo.id && value.variant == iteminfo.variant){
                    shopcart[index].qty = updatedQty;
                    iteminCart = true;

                }
            });
            sessionStorage["sc"]=JSON.stringify(shopcart);

            outputCart();


        });







    });
</script>
<script src='https://www.google.com/recaptcha/api.js'></script>
</body>

</html>
