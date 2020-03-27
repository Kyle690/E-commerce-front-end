<?php
/**
 * Created by PhpStorm.
 * User: kyle
 * Date: 2018/07/03
 * Time: 4:56 PM
 */
include '../../admin/admin_dashboard/inc/functions.php';
secure_session_start();
include_once '../../admin/inc/database.php';
$db = new Database();
$csrf = hash_hmac('sha256', 'this is vanita Pasta', $_SESSION['key']);

if(isset($_POST['csfr'])){

    if (hash_equals($csrf, $_POST['csfr'])) {

            $details_cust = $_POST['customer_details'];
            if(isset($details_cust)) {
                $date_created = date("Y-m-d H-i-s");
                $sql_check = "SELECT order_num FROM orders ORDER BY order_num DESC ";
                $result = $db->select($sql_check);
                if(sizeof($result) == 0){
                    $order_number = 100;
                }else{
                    $order_number = $result[0]['order_num'] + 1;
                }

                $customer_details_array = array();
                foreach ($_POST['customer_details'] as $details) {
                    $customer_details = mysqli_real_escape_string($con, $details);
                    array_push($customer_details_array, $customer_details);
                }
                $first_name = $customer_details_array[0];
                $last_name = $customer_details_array[1];
                $contact = $customer_details_array[2];
                $email = $customer_details_array[3];
                $delivery_instruction = $customer_details_array[4];

                if ($customer_details_array[5] == '') {
                    $customer_id = '';
                } else {
                    $customer_id = $customer_details_array[5];
                }
                if (isset($_POST['shipping_details'])) {
                    $ship_details_array = array();
                    foreach ($_POST['shipping_details'] as $ship_details) {
                        $ship_details_checked = mysqli_real_escape_string($con, $ship_details);
                        array_push($ship_details_array, $ship_details_checked);
                    }
                    $building = $ship_details_array[0];
                    $street = $ship_details_array[1];
                    $suburb = $ship_details_array[2];
                    $city = $ship_details_array[3];
                    $province = $ship_details_array[4];
                    $postal = $ship_details_array[6];
                    $ship_total = $ship_details_array[7];
                    $ship_method = $ship_details_array[8];
                } else {
                    exit(json_encode(array("status" => 0, "msg" => "Error with shipping_details")));
                }
                $payment_type ="PayFast";
                $payment_status = "Waiting Payment Payfast";
                // Create Order
                $sql_order = "INSERT INTO orders (customer_id,
                                          order_num,
                                          first_name,
                                          last_name,
                                          email,
                                          contact,
                                          building,
                                          street,
                                          suburb,
                                          city,
                                          province,
                                          postal,
                                          shipping_method,
                                          date_created,
                                          payment_method,
                                          payment_status,
                                          delivery_msg) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
                if($stmt= $mysqli->prepare($sql_order)){
                    $stmt->bind_param('sssssssssssssssss',
                        $customer_id,
                        $order_number,
                        $first_name,
                        $last_name,
                        $email,
                        $contact,
                        $building,
                        $street,
                        $suburb,
                        $city,
                        $province,
                        $postal,
                        $ship_method,
                        $date_created,
                        $payment_type,
                        $payment_status,
                        $delivery_instruction);

                    if($stmt->execute()){
                        $order_inserted = TRUE;
                    }else{
                        // failer with the execute of stmt
                        echo "error with executing sql of order".$mysqli->error;;
                    }
                }else{
                    // failure with preparing the statment
                    echo "error with preparing the statement";
                }
                // Get the last order id
                $sql_check_last_order_id = "SELECT id FROM orders ORDER BY id DESC ";
                $result_id = $db->select($sql_check_last_order_id);
                $order_id = $result_id[0]['id'];

                // Product Details Arrays
                $prod_id_array = array();
                if(sizeof($_POST['product_id'])>0){
                    foreach ($_POST['product_id'] as $prod_ids){
                        $prod_id = mysqli_real_escape_string($con, $prod_ids);
                        array_push($prod_id_array, $prod_id);
                    }
                }
                // Product Details Arrays
                $prod_id_array = array();
                if(sizeof($_POST['product_id'])>0){
                    foreach ($_POST['product_id'] as $prod_ids){
                        $prod_id = mysqli_real_escape_string($con, $prod_ids);
                        array_push($prod_id_array, $prod_id);
                    }
                }
                $prod_name_array = array();
                if(sizeof($_POST['product_name'])>0){
                    foreach ($_POST['product_name'] as $prod_names){
                        $prod_name = mysqli_real_escape_string($con, $prod_names);
                        array_push($prod_name_array, $prod_name);
                    }
                }
                $var_name_array = array();
                if(sizeof($_POST['variant_name'])>0){
                    foreach ($_POST['variant_name'] as $var_names){
                        $var_name = mysqli_real_escape_string($con, $var_names);
                        array_push($var_name_array, $var_name);
                    }
                }

                $var_id_array = array();
                if(sizeof($_POST['variant_id'])>0){
                    foreach ($_POST['variant_id'] as $var_ids){
                        $var_id = mysqli_real_escape_string($con, $var_ids);
                        array_push($var_id_array, $var_id);
                    }

                }

                $qty_array = array();
                if(sizeof($_POST['qty_'])>0){
                    foreach ($_POST['qty_'] as $qties){
                        $qty = mysqli_real_escape_string($con, $qties);
                        array_push($qty_array, $qty);
                    }
                }

                $varPrice_verified = array();
                $line_total_array = array();

                // Enter Products in to order of db
                if(sizeof($prod_id_array) > 0) {
                    if ($order_inserted) {


                        for ($i = 0; $i < sizeof($prod_id_array); $i++) {

                            $sql_get_var_price = "SELECT var_price FROM product_variants WHERE id = '$var_id_array[$i]'";
                            $var_price = $db->select($sql_get_var_price);
                            if (sizeof($var_price) == 1) {

                                array_push($varPrice_verified, $var_price[0]['var_price']);

                                $line_totals = $var_price[0]['var_price'] * $qty_array[$i];
                                array_push($line_total_array, $line_totals);
                            } else {
                                echo "Error with verifiying prices";
                                // delete order_details from db previously entered;
                                // return to home page
                            }

                            //echo $prod_id_array[$i].' '.$prod_name_array[$i].' '.$var_name_array[$i].' '.$var_id_array[$i].' '.$varPrice_verified[$i].' '.$line_total_array[$i].'<br>';
                            $sql_insert_product = "INSERT INTO order_product (order_id,
                                                                  order_number,
                                                                  product_id,
                                                                  product_name,
                                                                  variant_id,
                                                                  variant_name,
                                                                  price,
                                                                  qty,
                                                                  line_total) VALUES (?,?,?,?,?,?,?,?,?)";
                            if($stmt= $mysqli->prepare($sql_insert_product)){
                                $stmt->bind_param('iiisisdid', $order_id,
                                    $order_number,
                                    $prod_id_array[$i],
                                    $prod_name_array[$i],
                                    $var_id_array[$i],
                                    $var_name_array[$i],
                                    $varPrice_verified[$i],
                                    $qty_array[$i],
                                    $line_total_array[$i]);

                                if($stmt->execute()){
                                    $order_products_inserted = TRUE;
                                }else{
                                    // failer with the execute of stmt
                                    echo "error with executing sql ";
                                }
                            }else{
                                // failure with preparing the statment
                                echo "error with preparing the statement";
                            }


                        }
                    } else {
                        echo "Error with order inserted ";
                        // return to home page
                    }
                }

                // Order Totals
                //$ship_total = mysqli_real_escape_string($con, $_POST['ship_total']);
                $subTOtal_cal = array_sum($line_total_array);
                $final_total_cal = $subTOtal_cal + $ship_total;
                $tax_cal = $final_total_cal * 0.15;
                $tax = $tax_cal;
                $sub_total = $subTOtal_cal;
                $final_total =  $final_total_cal;

                // echo $sub_total." ".$final_total." ".$tax;

                if($order_products_inserted){
                    $sql_order_totals = "INSERT INTO order_totals (order_id, order_number, customer_id, subtotal, ship_total, tax ,final_total)VALUES(?,?,?,?,?,?,?)";
                    if($stmt= $mysqli->prepare($sql_order_totals)){
                        $stmt->bind_param('iiidddd', $order_id,$order_number, $customer_id, $sub_total, $ship_total,$tax,$final_total);


                        if($stmt->execute()){
                            $order_totals_inserted = TRUE;
                        }else{
                            // failer with the execute of stmt
                            echo "error with executing sql ".mysqli_error($mysqli);
                        }
                    }else{
                        // failure with preparing the statment
                        echo "error with preparing the statement";
                    }
                }
                // Order Status
                $channel = "online Store";

                if($order_totals_inserted){
                    $status = "Received";
                    $sql_status = "INSERT INTO order_status (order_id, order_num, status, date_created, channel)VALUES (?,?,?,?,?)";
                    if($stmt= $mysqli->prepare($sql_status)){
                        $stmt->bind_param('sssss', $order_id, $order_number, $status, $date_created, $channel);


                        if($stmt->execute()){
                            $totals_inserts = TRUE;
                        }else{
                            // failer with the execute of stmt
                            echo "error with executing sql ";
                        }
                    }else{
                        // failure with preparing the statement
                        echo "error with preparing the statement";
                    }
                }


                if($totals_inserts) {


                    for($i=0; $i<sizeof($prod_id_array); $i++) {
                        $sql_stock = "SELECT var_stock FROM product_variants WHERE id ='" . $var_id_array[$i] . "'";
                        $in_stock = $db->select($sql_stock);

                        $stock_left = floatval($in_stock[0]['var_stock']) - floatval($qty_array[$i]);
                        //echo $stock_left;
                        // $stock_updated = TRUE;
                        $sql_stock_left = "UPDATE product_variants SET var_stock=? WHERE id = '" . $var_id_array[$i] . "'";

                        if ($stmt = $mysqli->prepare($sql_stock_left)) {
                            $stmt->bind_param('s', $stock_left);


                            if ($stmt->execute()) {
                                $status_updated = TRUE;
                            } else {
                                // failer with the execute of stmt
                                exit(json_encode(array("status" => 0, "msg" => "error with updating stock")));
                            }
                        } else {
                            // failure with preparing the statment
                            exit(json_encode(array("status" => 0, "msg" => "error with statement of stock")));
                        }
                    }

                }






                if($status_updated) {
                    require "../../admin/admin_dashboard/inc/fpdf181/fpdf.php";
                    $pdf = new FPDF();
                    $pdf->AddPage();

                    $pdf->SetFont("Arial","B","20");
                    $pdf->SetFont('Arial','B',14);

//Cell(width , height , text , border , end line , [align] )
                    $logo = "../../admin/img/Vanita_Logo.png";
                    $pdf->Image($logo, 10,7,50,35 );
                    $pdf->Cell(60,5,"",0,0);
                    $pdf->Cell(70 ,5,'',0,0);
                    $pdf->Cell(59 ,5,'',0,1);//end of line

//set font to arial, regular, 12pt
                    $pdf->SetFont('Arial','',10);
                    $pdf->Cell(60,5,"",0,0);
                    $pdf->Cell(70 ,5,'Unit 10 Main Reef Park',0,0);
                    $pdf->SetFont('Arial','B',14);
                    $pdf->Cell(59 ,5,'Tax Invoice',0,1);//end of line


                    $pdf->SetFont('Arial','',10);
                    $pdf->Cell(60,5,"",0,0);
                    $pdf->Cell(70,5,'5 Main Reef Road',0,0);
                    $pdf->Cell(20 ,5,'Date:',1,0);
                    $pdf->Cell(39 ,5,$date_created ,1,1);

                    $pdf->Cell(60,5,"",0,0);
                    $pdf->Cell(70 ,5,'Dunswart',0,0);
                    $pdf->Cell(20 ,5,'Invoice #',1,0);
                    $pdf->Cell(39 ,5,$order_number,1,1);//end of line

                    $pdf->Cell(60,5,"",0,0);
                    $pdf->Cell(70 ,5,'Boksburg North',0,0);
                    $pdf->Cell(34 ,5,'',0,1);//end of line

                    $pdf->Cell(60,5,"",0,0);
                    $pdf->Cell(70 ,5,'Vat No: 4130279518',0,0);
                    $pdf->Cell(34 ,5,'',0,1);//end of line

                    $pdf->Cell(60,5,"",0,0);
                    $pdf->Cell(70 ,5,'Tel: 011 025 8033/ 072 719 6461',0,0);
                    $pdf->Cell(34 ,5,'',0,1);//end of line

                    $pdf->Cell(60,5,"",0,0);
                    $pdf->Cell(70 ,5,'Email: sales@vanitapasta.co.za',0,0);
                    $pdf->Cell(34 ,5,'',0,1);//end of line





                    $pdf->Cell(34 ,5,'',0,1);//end of line

//make a dummy empty cell as a vertical spacer
                    $pdf->Cell(189 ,10,'',0,1);//end of line

//billing address
                    $pdf->Cell(100 ,5,'',0,1);//end of line

//add dummy cell at beginning of each line for indentation
                    $pdf->Cell(10 ,5,'',0,0);
                    $pdf->Cell(90 ,5,$first_name." ".$last_name,0,1);
                    $pdf->Cell(10 ,5,'',0,0);
                    $pdf->Cell(90 ,5,$email,0,1);
                    $pdf->Cell(10 ,5,'',0,0);
                    $pdf->Cell(90 ,5,$contact,0,1);

                    $pdf->Cell(10 ,5,'',0,0);
                    $pdf->Cell(90 ,5,$building,0,1);

                    $pdf->Cell(10 ,5,'',0,0);
                    $pdf->Cell(90 ,5,$street,0,1);

                    $pdf->Cell(10 ,5,'',0,0);
                    $pdf->Cell(90 ,5,$suburb,0,1);

                    $pdf->Cell(10 ,5,'',0,0);
                    $pdf->Cell(90 ,5,$city,0,1);

                    $pdf->Cell(10 ,5,'',0,0);
                    $pdf->Cell(90 ,5,$province,0,1);

                    $pdf->Cell(10 ,5,'',0,0);
                    $pdf->Cell(90 ,5,$postal,0,1);

                    //make a dummy empty cell as a vertical spacer
                    $pdf->Cell(189 ,10,'',0,1);//end of line

                    //Invoice table Head
                    $pdf->SetFont('Arial','B',12);

                    $pdf->Cell(50 ,5,'Product Name',1,0, 'C');
                    $pdf->Cell(50 ,5,'Variant',1,0,'C');
                    $pdf->Cell(25,5,'Unit Price', 1,0, 'C');
                    $pdf->Cell(30,5,'Qty', 1,0, 'C');
                    $pdf->Cell(34 ,5,'Totals',1,1, 'C');//end of line

                    $pdf->SetFont('Arial','',10);
                    // Invoice Table body

                    for($i=0;$i<sizeof($prod_id_array);$i++){

                        $pdf->Cell(50 ,5,$prod_name_array[$i],1,0, 'L');
                        $pdf->Cell(50 ,5,$var_name_array[$i],1,0,'C');
                        $pdf->Cell(25,5,$varPrice_verified[$i], 1,0, 'R');
                        $pdf->Cell(30,5,$qty_array[$i], 1,0, 'C');
                        $pdf->Cell(34 ,5,number_format((float)$line_total_array[$i],2,',', ''),1,1, 'R');//end of line

                    }


                    $pdf->SetFont('Arial','',10);

                    //Invoice table footer
                    //summary
                    $pdf->Cell(125 ,5,'',0,0);
                    $pdf->Cell(30,5,'Subtotal',1,0,'R');
                    $pdf->Cell(34 ,5,'R '.$sub_total,1,1,'R');//end of line

                    $pdf->Cell(125 ,5,'',0,0);
                    $pdf->Cell(30 ,5,'Shipping Costs',1,0,'R');
                    $pdf->Cell(34 ,5,'R '.$ship_total,1,1,'R');//end of line

                    $pdf->Cell(125 ,5,'',0,0);
                    $pdf->Cell(30 ,5,'Tax Rate @ 15%',1,0,'R');
                    $pdf->Cell(34 ,5,'R '.$tax,1,1,'R');//end of line

                    $pdf->SetFont('Arial','B',12);
                    $pdf->Cell(125 ,5,'',0,0);
                    $pdf->Cell(30 ,5,'Total ',1,0,'R');
                    $pdf->Cell(34 ,5,'R '.$final_total,1,1,'R');//end of line

                    if($payment_type == "EFT"){
                        $pdf->Cell(189 ,15,'',0,1);//end of line


                        $pdf->SetFont('Arial','BI',10);
                        $pdf->Cell(130 ,5,'Banking Details',0,1,'L');// End of line
                        $pdf->SetFont('Arial','',10);

                        $pdf->Cell(130 ,5,'Bank Account Holder: Vanita`CC',0,1,'L');
                        $pdf->Cell(130 ,5,'Bank Name: Standard Bank',0,1,'L');

                        $pdf->Cell(130 ,5,'Bank Branch Code: 051001',0,1,'L');
                        $pdf->Cell(130 ,5,'Bank Acc No: 271820241',0,1,'L');
                    }
                    $pdf->Cell(189 ,15,'',0,1);//end of line
                    if($ship_method == "Shipping"){
                        $pdf->Cell(59 ,5,'Delivery method: Shipping',0,1, 'L');//end of line
                        $pdf->Cell(59 ,5,'Items will be delivered in 2-3 working days',0,1);//end of line
                        $pdf->Cell(59 ,5,'Delivery Instructions:'.$delivery_instruction,0,1);//end of line

                    }else{
                        $pdf->Cell(59 ,5,'Delivery method: Collect From Store',0,1, 'L');//end of line
                        $pdf->Cell(59 ,5,'Items will be ready to collect in 2-3 working days',0,1);//end of line
                    }

                    $pdf->Cell(189 ,15,'',0,1);//end of line
                    $pdf->Cell(189 ,15,'',0,1);//end of line



                    $pdf->SetFont('Arial','I',10);
                    $pdf->Cell(189 ,15,'Thank you for your business !',0,1, "C");//end of line
                    $pdf->Cell(189, 15, "Copyright Vanita Pasta 2018", 0,1, 'C');

                    $dir = "../../admin/admin_dashboard/orders/orders_pdf/";
                    $file_name = $order_number;
                    $format = '.pdf';


                    $pdf->Output("F",$dir.$file_name.$format);
                    $pdf_created = TRUE;


                    //exit(json_encode(array("status" => 0, "msg" => "error with the pdf")));
                }








                // Send client to payfast


                if($pdf_created == TRUE){

                    $sql_merchant_details = "SELECT * FROM payment_gateway";
                    $merchant_details = $db->select($sql_merchant_details);
                    if(sizeof($merchant_details)>0){
                        $merchant_id = $merchant_details[0]['merchant_id'];
                        $merchant_key = $merchant_details[0]['merchant_key'];

                    }else{
                        //echo "error with merchant details";
                        exit(json_encode(array("status" => 0, "msg" => "error with merchant details")));
                    }
                    //will be  (success)  vanitapasta.co.za/storefront/cart_payment_success.php
                    $return_url = " ";
                    // will be (notify) vanitapasta.co.za/storefront/cart_payment_notify.php
                    $notify_url = "";
                    // will be (cancel) vanitapasta.co.za/storefront/cart_payment_cancel.php
                    $cancel_url = "";


                    $data = array(
                        // Merchant details
                        'merchant_id' => $merchant_id,
                        'merchant_key' => $merchant_key,
                        'return_url' => 'http://www.admin.creativeplatform.co.za/storefront/cart_payment_success.php?order_number='.$order_number,
                        'cancel_url' => 'http://www.admin.creativeplatform.co.za/storefront/cart_payment_failed.php?order_number='.$order_number,
                        'notify_url' => 'http://www.admin.creativeplatform.co.za/storefront/process_files/pf_notify_order.php',
                        // Buyer details
                        'name_first' => $first_name,
                        'name_last'  => $last_name,
                        'email_address'=> $email,
                        'cell_number'=> $contact,
                        // Transaction details
                        'm_payment_id' => $order_number, //Unique payment ID to pass through to notify_url
                        // Amount needs to be in ZAR
                        // If multicurrency system its conversion has to be done before building this array

                        'amount' => number_format( sprintf( "%.2f", $final_total_cal ), 2, '.', '' ),
                        'item_name' => "Vanita Pasta Online Store order Number: ". $order_number,
                        'item_description' => 'Vanita Pasta order number: '.$order_number,
                        'custom_int1' => '', //custom integer to be passed through
                        'custom_str1' => ''


                    );


                    $merchant_id = $data['merchant_id'];
                    $name_first = $data['name_first'];
                    $name_last = $data['name_last'];
                    $email = $data['email_address'];
                    $m_payment_id = $data['m_payment_id'];

                    $data_array_test = array(
                        'merchant_id'=> $merchant_id,
                        'name_first' => $name_first,
                        'name_last' => $name_last,
                        'email'=>$email,
                        'm_payment_id'=>$m_payment_id);



                    $vantia_security = '';
                    foreach( $data_array_test as $key => $val )
                    {
                        /*if(in_array($key, $data_security_array) && $val != '')
                         {
                         }*/
                        $vantia_security .= $key .'='. urlencode( trim( $val ) ) .'&';
                    }

                    $secure_string = substr( $vantia_security, 0, -1 );


                    $data['custom_str1'] = hash_hmac('sha256', 'this is vanita Pasta', $secure_string);






                    $pfParamString = '';
                    foreach ( $data as $key => $val )
                    {
                        if ( $val !='' && $key != 'submit' && $key != 'passphrase' )
                        {
                            $pfParamString .= $key .'='. urlencode( stripslashes( trim( $val ) ) ) . '&';
                        }
                    }

                    // Remove the last '&' from the Parameter string
                    $pfParamString = substr( $pfParamString, 0, -1 );
                    // Add the passphrase

                    if (isset($data['passphrase']) )
                    {
                        $preSigString = $pfParamString.'&passphrase='.urlencode( $data['passphrase'] );
                    }
                    else
                    {
                        $preSigString = $pfParamString;
                    }

                    //$preSigString = $pfParamString;
                    $signature = md5( $preSigString );
                    //exit(json_encode(array("status" => 1, "msg" => $preSigString )));
                    $form_inputs = '';
                    foreach ( $data as $key => $val )
                    {
                        if ( !empty( $val ) && $key != 'submit' && $key != 'passphrase' )
                        {

                            $form_inputs .=' <input type="hidden" name="'.$key.'" value="'.$val.'"/>';

                        }

                    }

                    $form_inputs .='<input type="hidden" name="signature" value="'.$signature.'" />';


                     exit(json_encode(array("status" => 1, "msg" => $form_inputs, "order_num" => $order_number )));
                }


            }
            else{exit(json_encode(array("status" => 0, "msg" => "Error with customer_details")));}
    } else {
        exit(json_encode(array("status" => 0, "msg" => "Error with hash")));

    }

}else{
    exit(json_encode(array("status" => 0, "msg" => "post not working")));
}

