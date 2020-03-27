$(document).ready(function(){
    //Category open on new page
    $(".category_btn").click(function(){
        var cat_name = $(this).text();
        $('#category_name').text(cat_name);
    });
    // View product modal
    $(".view_product_btn").click(function(){
        var product_name = $(this).data(name);
        $("#view_product_modal").modal('show');
    });
    // Check order status
    $("#order_update_btn").click(function(){
        $("#order_update").modal('show');
    });

    // Open cart modal
    $('#cart_btn').click(function(){
        $('#cart').modal('show');
    });
    //Procced to cart function
    $('#checkOutdiv').click(function(){
        window.open('cart_checkout.php');
    });

    $("#news_letter_sign_btn").click(function () {
        var sign_up_email = $("#newsletter_email").val();
        var sign_up_name = $("#news_name").val();
        var reg =  /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
        var name_pattern = /[A-Za-z]/;
        var name_valid = false;

        if( reg.test(sign_up_email) == false ){
            alert("Please enter a valid email address!")
        }else if( sign_up_email = ''){
            alert("Please check your Email!");
        }else{
            var sign_up_email_checked = $("#newsletter_email").val();
            if(name_pattern.test(sign_up_name)== false){
                alert("Please enter a valid name!")
            }else if (sign_up_name = ''){
                alert("Please check your Name!");
            }else{
                name_valid = true;
                var sign_up_name_checked = $("#news_name").val();
            }
        }



        if(name_valid == true){

            $.ajax({
                url:'process_files/news_letter_process.php',
                method: 'POST',
                dataType: 'json',
                data:{ name: sign_up_name_checked, email: sign_up_email_checked},
                success: function (response) {
                    if (response.status == 1){
                        alert(response.msg);
                        $("#news_sign_up").modal("hide");
                    } else{
                        alert(response.msg);
                    }

                }
            })
        }



    });

    $("#update_details").click(function () {
        var user_id = $(this).data("user");
        var session_name = $(this).data("username");
        var email = $("#c_Update_email").val();
        var reg =  /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
        var email_valid = true;
        if(reg.test(email) == false){
            alert("Please enter a valid email!");
            email_valid = false;
        }else{
            if(email_valid == true){

                $.ajax({
                    url:'process_files/customer_details_update.php',
                    method: 'POST',
                    dataType: 'json',
                    data:{ user_id: user_id, first_name: session_name ,email: email},
                    success: function (response) {
                        if (response.status == 1){
                            $("#Update_cust_details").submit();

                        } else{
                            alert(response.msg);
                        }

                    }
                })
            }

        }
    })

    


    

    
        
        
        
    
    
});