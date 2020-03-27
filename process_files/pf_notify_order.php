<?php
/**
 * Created by PhpStorm.
 * User: kyle
 * Date: 2018/07/08
 * Time: 11:52 AM
 */

require "payfast_common.inc";
include '../../admin/admin_dashboard/inc/functions.php';
secure_session_start();
include_once '../../admin/inc/database.php';
$db = new Database();

pflog( 'PayFast ITN call received' );

// Variable Initialization
$pfError = false;
$pfErrMsg = '';
$pfDone = false;
$pfData = array();
$pfHost = 'sandbox.payfast.co.za';
$pfOrderId = '';
$pfParamString = '';

// Check the header response
if( !$pfError && !$pfDone )
{
    header( 'HTTP/1.0 200 OK' );
    flush();
}

// Get data sent by PayFast
pflog( 'Get posted data' );

// Posted variables from ITN
$pfData = pfGetData();

pflog( 'PayFast Data: '. print_r( $pfData, true ) );

if( $pfData === false )
{
    $pfError = true;
    $pfErrMsg = PF_ERR_BAD_ACCESS;
}
// Strip any slashes in data
foreach( $pfData as $key => $val )
{
    $pfData[$key] = stripslashes( $val );
}

//// Verify security signature

if( !$pfError && !$pfDone )
{
    pflog( 'Verify security signature' );

    $pfPassPhrase = ''; // Set your passphrase here

    // If signature different, log for debugging
    if( !pfValidSignature( $pfData, $pfParamString, $pfPassPhrase ) )
    {
        $pfError = true;
        $pfErrMsg = PF_ERR_INVALID_SIGNATURE;
    }
}

//// Verify source IP (If not in debug mode)
if( !$pfError && !$pfDone && !PF_DEBUG )
{
    pflog( 'Verify source IP' );

    if( !pfValidIP( $_SERVER['REMOTE_ADDR'] ) )
    {
        $pfError = true;
        $pfErrMsg = PF_ERR_BAD_SOURCE_IP;
    }
}
//// Check Amounts
$dbAmount = $pfData['amount_gross'];

$amountCheck = pfAmountsEqual( $dbAmount, $pfData['amount_gross'] );

if ( !$amountCheck )
{
    $pfError = true;
    $pfErrMsg = PF_ERR_AMOUNT_MISMATCH;
}

if ( !$pfError )

    //// Check order status and update the order
    if( !$pfError && !$pfDone )
    {
        pflog( 'Check order status and update the order' );

        if ( $pfData['payment_status'] == 'COMPLETE' )
        {
            pflog( '- Complete' );
            // Update order as required
        }
    }

// Verify security code
if(!$pfError){
    //$data_security_array = array('merchant_id', 'name_first', 'name_last', 'email_address', 'm_payment_id' );

    $merchant_id = $pfData['merchant_id'];
    $name_first = $pfData['name_first'];
    $name_last = $pfData['name_last'];
    $email = $pfData['email_address'];
    $m_payment_id = $pfData['m_payment_id'];

    $data_array_test = array(
        'merchant_id'=> $merchant_id,
        'name_first' => $name_first,
        'name_last' => $name_last,
        'email'=>$email,
        'm_payment_id'=> $m_payment_id);

    pflog('Data Test array: '.print_r($data_array_test, true));
    $vantia_security = '';
    foreach( $data_array_test as $key => $val )
    {

        $vantia_security .= $key .'='. urlencode( trim( $val ) ) .'&';

    }

    $secure_string = substr( $vantia_security, 0, -1 );
    $create_check = hash_hmac('sha256', 'this is vanita Pasta', $secure_string);

    $secruity_passed = $pfData['custom_str1'];

    pflog('sent signature: '.$secruity_passed);
    pflog('created signature: '. $create_check);


    if($create_check == $secruity_passed){
        pflog("Custom Secruity Check:");
        pflog('Passed');

        // Insert pf data into db for record
        $order_num = $pfData['m_payment_id'];
        $pf_payment_id = $pfData['pf_payment_id'];
        $payment_status = $pfData['payment_status'];
        $amount = $pfData['amount_gross'];
        $fee = $pfData['amount_fee'];
        $net_amount = $pfData['amount_net'];
        $date = date("Y-m-d H-i-sa");

        $sql_insert_pf = "INSERT INTO pf_data (order_num, pf_payment_id, payment_status, amount, fee, net_amount, date_created) VALUES (?,?,?,?,?,?,?) ";
        if($stmt= $mysqli->prepare($sql_insert_pf)){
            $stmt->bind_param('sssddds',$order_num,$pf_payment_id, $payment_status, $amount, $fee, $net_amount, $date);

            if($stmt->execute()){
                $pf_data_inserted = TRUE;
            }else{
                // failer with the execute of stmt
               pflog('Error with updating pfdata: sql_error');
            }
        }else{
            // failure with preparing the statment
            pflog("Error with updating pfdata: Statment_error");
        }

        // update order_status
        if($pf_data_inserted){
            if($payment_status == 'COMPLETE'){
                $pay_status = 'paid_pf';
                $sql_update_order = "UPDATE orders SET payment_status=? WHERE order_num ='$order_num'";
                if($stmt= $mysqli->prepare($sql_update_order)){
                    $stmt->bind_param('s', $pay_status);

                    if($stmt->execute()){
                       pflog('payment Status update: true');
                       $status_updated = TRUE;
                    }else{
                        // failer with the execute of stmt
                        pflog('Error with updating pfdata: sql_error');
                    }
                }else{
                    // failure with preparing the statment
                    pflog("Error with updating pfdata: Statment_error");
                }


            }
        }

        if($status_updated){
            // send email

            include "pf_order_email.php";
            $email = new pf_order_email();

            $client = $email->send_client_email($order_num);
            pflog("Client Email response: ".$client);

            $admin = $email->send_admin_email($order_num);
            pflog("Admin Email response:".$admin);






        }

    }else{
        $pfError = true;
        $pfErrMsg = 'Error with signature check';
       // pflog($create_check);
    }




}






// If an error occurred
if( $pfError )
{
    pflog( 'Error occurred: '. $pfErrMsg );
}

