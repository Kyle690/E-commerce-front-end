<?php
/**
 * Created by PhpStorm.
 * User: kyle
 * Date: 2018/07/08
 * Time: 12:37 PM
 */

class pf_order_email
{
    function send_client_email ($orderNum){

        $db = new Database();

        $sql_get_order_details = "SELECT  * FROM orders WHERE order_num = '$orderNum'";
        $order_detail = $db->select($sql_get_order_details);

        $first_name = $order_detail[0]['first_name'];
        $last_name = $order_detail[0]['last_name'];
        $email = $order_detail[0]['email'];
        $contact = $order_detail[0]['contact'];
        $building = $order_detail[0]['building'];
        $street = $order_detail[0]['street'];
        $suburb = $order_detail[0]['suburb'];
        $city = $order_detail[0]['city'];
        $province = $order_detail[0]['province'];
        $postal = $order_detail[0]['postal'];
        $shipping_method = $order_detail[0]['shipping_method'];
        $delivery_msg = $order_detail[0]['delivery_msg'];
        $date_created = $order_detail[0]['date_created'];


        $sql_social  = "SELECT * FROM social_links ";
        $social_links = $db->select($sql_social);
        $facebook = $social_links[0]['facebook'];
        $instagram = $social_links[0]['instagram'];
        $google_plus = $social_links[0]['google_plus'];
        $youtube = $social_links[0]['youtube'];

        $out_put ='';
        $out_put .='<table class="mcnCodeBlock" border="0" cellpadding="0" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th colspan="2" class="text-center">Product</th>
                            <th>Variant</th>
                            <th>Unit Price</th>
                            <th>Qty</th>
                            <th class="text-right">Total</th>
                        </tr>
                        </thead>
                        <tbody>
                            ';

                                $sql_products = "SELECT * FROM order_product WHERE order_number = '".$orderNum."'";
                                $products = $db->select($sql_products);
                                if(sizeof($products)>0){
                                    foreach ($products as $product_details){
                                        $sql_prodImg = "SELECT main_img FROM products WHERE id = '".$product_details['product_id']."'";
                                        $main_img = $db->select($sql_prodImg);
                                        $out_put .='<tr>
                                                <td><img width="50px" height="50px" src="http://www.vanitapasta/storefront/img/product_img/'.$main_img[0]["main_img"].'"></td>
                                                <td>'.$product_details['product_name'].'</td>
                                                <td>'.$product_details['variant_name'].'</td>
                                                <td>R '.number_format($product_details['price'], 2, ',',',').'</td>
                                                <td>'.$product_details['qty'].'</td>
                                                <td align="right">R '.number_format($product_details['line_total'],2, ',',',').'</td>
                                            </tr>';
                                    }
                                }
                                $sql_totals = "SELECT * FROM order_totals WHERE order_number = '".$orderNum."'";
                                $totals = $db->select($sql_totals);


                                $out_put.= '
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="5" class="text-right" >Subtotal (<span class="no_of_items_2"></span> items) </td>
                                    <td align="right"><span>R '.number_format($totals[0]['subtotal'],2, ',', ',').'</span></td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="text-right">Shipping</td>
                                    <td align="right"><span>R '.number_format($totals[0]['ship_total'],2, ',', ',').'</span></td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="text-right">Tax @ 15% (included)</td>
                                    <td align="right"><span >R '.number_format($totals[0]['tax'],2, ',', ',').'</span></td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="text-right"><b>Total</b></td>
                                    <td align="right"><span>R '.number_format($totals[0]['final_total'],2, ',', ',').'</span></td>
                                </tr>
                                </tfoot>
                          

                            </table>';


        include "../../admin/src/plugins/PHPMailer/PHPMailerAutoload.php";
        $html = '';
        $html .='
<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
	<head>
		
		<meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Vanita Pasta | Order Confirmation:'.$orderNum.'</title>
        
    <style type="text/css">
		p{
			margin:10px 0;
			padding:0;
		}
		table{
			border-collapse:collapse;
		}
		h1,h2,h3,h4,h5,h6{
			display:block;
			margin:0;
			padding:0;
		}
		img,a img{
			border:0;
			height:auto;
			outline:none;
			text-decoration:none;
		}
		body,#bodyTable,#bodyCell{
			height:100%;
			margin:0;
			padding:0;
			width:100%;
		}
		.mcnPreviewText{
			display:none !important;
		}
		#outlook a{
			padding:0;
		}
		img{
			-ms-interpolation-mode:bicubic;
		}
		table{
			mso-table-lspace:0pt;
			mso-table-rspace:0pt;
		}
		.ReadMsgBody{
			width:100%;
		}
		.ExternalClass{
			width:100%;
		}
		p,a,li,td,blockquote{
			mso-line-height-rule:exactly;
		}
		a[href^=tel],a[href^=sms]{
			color:inherit;
			cursor:default;
			text-decoration:none;
		}
		p,a,li,td,body,table,blockquote{
			-ms-text-size-adjust:100%;
			-webkit-text-size-adjust:100%;
		}
		.ExternalClass,.ExternalClass p,.ExternalClass td,.ExternalClass div,.ExternalClass span,.ExternalClass font{
			line-height:100%;
		}
		a[x-apple-data-detectors]{
			color:inherit !important;
			text-decoration:none !important;
			font-size:inherit !important;
			font-family:inherit !important;
			font-weight:inherit !important;
			line-height:inherit !important;
		}
		#bodyCell{
			padding:10px;
		}
		.templateContainer{
			max-width:600px !important;
		}
		a.mcnButton{
			display:block;
		}
		.mcnImage,.mcnRetinaImage{
			vertical-align:bottom;
		}
		.mcnTextContent{
			word-break:break-word;
		}
		.mcnTextContent img{
			height:auto !important;
		}
		.mcnDividerBlock{
			table-layout:fixed !important;
		}
	/*
	@tab Page
	@section Background Style
	@tip Set the background color and top border for your email. You may want to choose colors that match your company\'s branding.
	*/
		body,#bodyTable{
			/*@editable*/background-color:#ddedff;
		}
	/*
	@tab Page
	@section Background Style
	@tip Set the background color and top border for your email. You may want to choose colors that match your company\'s branding.
	*/
		#bodyCell{
			/*@editable*/border-top:0;
		}
	/*
	@tab Page
	@section Email Border
	@tip Set the border for your email.
	*/
		.templateContainer{
			/*@editable*/border:0;
		}
	/*
	@tab Page
	@section Heading 1
	@tip Set the styling for all first-level headings in your emails. These should be the largest of your headings.
	@style heading 1
	*/
		h1{
			/*@editable*/color:#202020;
			/*@editable*/font-family:Helvetica;
			/*@editable*/font-size:26px;
			/*@editable*/font-style:normal;
			/*@editable*/font-weight:bold;
			/*@editable*/line-height:125%;
			/*@editable*/letter-spacing:normal;
			/*@editable*/text-align:left;
		}
	/*
	@tab Page
	@section Heading 2
	@tip Set the styling for all second-level headings in your emails.
	@style heading 2
	*/
		h2{
			/*@editable*/color:#202020;
			/*@editable*/font-family:Helvetica;
			/*@editable*/font-size:22px;
			/*@editable*/font-style:normal;
			/*@editable*/font-weight:bold;
			/*@editable*/line-height:125%;
			/*@editable*/letter-spacing:normal;
			/*@editable*/text-align:left;
		}
	/*
	@tab Page
	@section Heading 3
	@tip Set the styling for all third-level headings in your emails.
	@style heading 3
	*/
		h3{
			/*@editable*/color:#202020;
			/*@editable*/font-family:Helvetica;
			/*@editable*/font-size:20px;
			/*@editable*/font-style:normal;
			/*@editable*/font-weight:bold;
			/*@editable*/line-height:125%;
			/*@editable*/letter-spacing:normal;
			/*@editable*/text-align:left;
		}
	/*
	@tab Page
	@section Heading 4
	@tip Set the styling for all fourth-level headings in your emails. These should be the smallest of your headings.
	@style heading 4
	*/
		h4{
			/*@editable*/color:#202020;
			/*@editable*/font-family:Helvetica;
			/*@editable*/font-size:18px;
			/*@editable*/font-style:normal;
			/*@editable*/font-weight:bold;
			/*@editable*/line-height:125%;
			/*@editable*/letter-spacing:normal;
			/*@editable*/text-align:left;
		}
	/*
	@tab Preheader
	@section Preheader Style
	@tip Set the background color and borders for your email\'s preheader area.
	*/
		#templatePreheader{
			/*@editable*/background-color:#4b74cc;
			/*@editable*/background-image:none;
			/*@editable*/background-repeat:no-repeat;
			/*@editable*/background-position:center;
			/*@editable*/background-size:cover;
			/*@editable*/border-top:0;
			/*@editable*/border-bottom:0;
			/*@editable*/padding-top:9px;
			/*@editable*/padding-bottom:9px;
		}
	/*
	@tab Preheader
	@section Preheader Text
	@tip Set the styling for your email\'s preheader text. Choose a size and color that is easy to read.
	*/
		#templatePreheader .mcnTextContent,#templatePreheader .mcnTextContent p{
			/*@editable*/color:#656565;
			/*@editable*/font-family:Helvetica;
			/*@editable*/font-size:12px;
			/*@editable*/line-height:150%;
			/*@editable*/text-align:left;
		}
	/*
	@tab Preheader
	@section Preheader Link
	@tip Set the styling for your email\'s preheader links. Choose a color that helps them stand out from your text.
	*/
		#templatePreheader .mcnTextContent a,#templatePreheader .mcnTextContent p a{
			/*@editable*/color:#ffffff;
			/*@editable*/font-weight:normal;
			/*@editable*/text-decoration:underline;
		}
	/*
	@tab Header
	@section Header Style
	@tip Set the background color and borders for your email\'s header area.
	*/
		#templateHeader{
			/*@editable*/background-color:#ffffff;
			/*@editable*/background-image:none;
			/*@editable*/background-repeat:no-repeat;
			/*@editable*/background-position:center;
			/*@editable*/background-size:cover;
			/*@editable*/border-top:0;
			/*@editable*/border-bottom:0;
			/*@editable*/padding-top:9px;
			/*@editable*/padding-bottom:0;
		}
	/*
	@tab Header
	@section Header Text
	@tip Set the styling for your email\'s header text. Choose a size and color that is easy to read.
	*/
		#templateHeader .mcnTextContent,#templateHeader .mcnTextContent p{
			/*@editable*/color:#202020;
			/*@editable*/font-family:Helvetica;
			/*@editable*/font-size:16px;
			/*@editable*/line-height:150%;
			/*@editable*/text-align:left;
		}
	/*
	@tab Header
	@section Header Link
	@tip Set the styling for your email\'s header links. Choose a color that helps them stand out from your text.
	*/
		#templateHeader .mcnTextContent a,#templateHeader .mcnTextContent p a{
			/*@editable*/color:#2BAADF;
			/*@editable*/font-weight:normal;
			/*@editable*/text-decoration:underline;
		}
	/*
	@tab Body
	@section Body Style
	@tip Set the background color and borders for your email\'s body area.
	*/
		#templateBody{
			/*@editable*/background-color:#fffdfd;
			/*@editable*/background-image:none;
			/*@editable*/background-repeat:no-repeat;
			/*@editable*/background-position:center;
			/*@editable*/background-size:cover;
			/*@editable*/border-top:0;
			/*@editable*/border-bottom:2px solid #EAEAEA;
			/*@editable*/padding-top:0;
			/*@editable*/padding-bottom:9px;
		}
	/*
	@tab Body
	@section Body Text
	@tip Set the styling for your email\'s body text. Choose a size and color that is easy to read.
	*/
		#templateBody .mcnTextContent,#templateBody .mcnTextContent p{
			/*@editable*/color:#202020;
			/*@editable*/font-family:\'Helvetica Neue\', Helvetica, Arial, Verdana, sans-serif;
			/*@editable*/font-size:16px;
			/*@editable*/line-height:150%;
			/*@editable*/text-align:left;
		}
	/*
	@tab Body
	@section Body Link
	@tip Set the styling for your email\'s body links. Choose a color that helps them stand out from your text.
	*/
		#templateBody .mcnTextContent a,#templateBody .mcnTextContent p a{
			/*@editable*/color:#2BAADF;
			/*@editable*/font-weight:normal;
			/*@editable*/text-decoration:underline;
		}
	/*
	@tab Footer
	@section Footer Style
	@tip Set the background color and borders for your email\'s footer area.
	*/
		#templateFooter{
			/*@editable*/background-color:#4b74cc;
			/*@editable*/background-image:none;
			/*@editable*/background-repeat:no-repeat;
			/*@editable*/background-position:center;
			/*@editable*/background-size:cover;
			/*@editable*/border-top:0;
			/*@editable*/border-bottom:0;
			/*@editable*/padding-top:9px;
			/*@editable*/padding-bottom:9px;
		}
	/*
	@tab Footer
	@section Footer Text
	@tip Set the styling for your email\'s footer text. Choose a size and color that is easy to read.
	*/
		#templateFooter .mcnTextContent,#templateFooter .mcnTextContent p{
			/*@editable*/color:#656565;
			/*@editable*/font-family:Helvetica;
			/*@editable*/font-size:12px;
			/*@editable*/line-height:150%;
			/*@editable*/text-align:center;
		}
	/*
	@tab Footer
	@section Footer Link
	@tip Set the styling for your email\'s footer links. Choose a color that helps them stand out from your text.
	*/
		#templateFooter .mcnTextContent a,#templateFooter .mcnTextContent p a{
			/*@editable*/color:#ffffff;
			/*@editable*/font-weight:normal;
			/*@editable*/text-decoration:underline;
		}
	@media only screen and (min-width:768px){
		.templateContainer{
			width:600px !important;
		}

}	@media only screen and (max-width: 480px){
		body,table,td,p,a,li,blockquote{
			-webkit-text-size-adjust:none !important;
		}

}	@media only screen and (max-width: 480px){
		body{
			width:100% !important;
			min-width:100% !important;
		}

}	@media only screen and (max-width: 480px){
		#bodyCell{
			padding-top:10px !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnRetinaImage{
			max-width:100% !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnImage{
			width:100% !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnCartContainer,.mcnCaptionTopContent,.mcnRecContentContainer,.mcnCaptionBottomContent,.mcnTextContentContainer,.mcnBoxedTextContentContainer,.mcnImageGroupContentContainer,.mcnCaptionLeftTextContentContainer,.mcnCaptionRightTextContentContainer,.mcnCaptionLeftImageContentContainer,.mcnCaptionRightImageContentContainer,.mcnImageCardLeftTextContentContainer,.mcnImageCardRightTextContentContainer,.mcnImageCardLeftImageContentContainer,.mcnImageCardRightImageContentContainer{
			max-width:100% !important;
			width:100% !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnBoxedTextContentContainer{
			min-width:100% !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnImageGroupContent{
			padding:9px !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnCaptionLeftContentOuter .mcnTextContent,.mcnCaptionRightContentOuter .mcnTextContent{
			padding-top:9px !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnImageCardTopImageContent,.mcnCaptionBottomContent:last-child .mcnCaptionBottomImageContent,.mcnCaptionBlockInner .mcnCaptionTopContent:last-child .mcnTextContent{
			padding-top:18px !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnImageCardBottomImageContent{
			padding-bottom:9px !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnImageGroupBlockInner{
			padding-top:0 !important;
			padding-bottom:0 !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnImageGroupBlockOuter{
			padding-top:9px !important;
			padding-bottom:9px !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnTextContent,.mcnBoxedTextContentColumn{
			padding-right:18px !important;
			padding-left:18px !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnImageCardLeftImageContent,.mcnImageCardRightImageContent{
			padding-right:18px !important;
			padding-bottom:0 !important;
			padding-left:18px !important;
		}

}	@media only screen and (max-width: 480px){
		.mcpreview-image-uploader{
			display:none !important;
			width:100% !important;
		}

}	@media only screen and (max-width: 480px){
	/*
	@tab Mobile Styles
	@section Heading 1
	@tip Make the first-level headings larger in size for better readability on small screens.
	*/
		h1{
			/*@editable*/font-size:22px !important;
			/*@editable*/line-height:125% !important;
		}

}	@media only screen and (max-width: 480px){
	/*
	@tab Mobile Styles
	@section Heading 2
	@tip Make the second-level headings larger in size for better readability on small screens.
	*/
		h2{
			/*@editable*/font-size:20px !important;
			/*@editable*/line-height:125% !important;
		}

}	@media only screen and (max-width: 480px){
	/*
	@tab Mobile Styles
	@section Heading 3
	@tip Make the third-level headings larger in size for better readability on small screens.
	*/
		h3{
			/*@editable*/font-size:18px !important;
			/*@editable*/line-height:125% !important;
		}

}	@media only screen and (max-width: 480px){
	/*
	@tab Mobile Styles
	@section Heading 4
	@tip Make the fourth-level headings larger in size for better readability on small screens.
	*/
		h4{
			/*@editable*/font-size:16px !important;
			/*@editable*/line-height:150% !important;
		}

}	@media only screen and (max-width: 480px){
	/*
	@tab Mobile Styles
	@section Boxed Text
	@tip Make the boxed text larger in size for better readability on small screens. We recommend a font size of at least 16px.
	*/
		.mcnBoxedTextContentContainer .mcnTextContent,.mcnBoxedTextContentContainer .mcnTextContent p{
			/*@editable*/font-size:14px !important;
			/*@editable*/line-height:150% !important;
		}

}	@media only screen and (max-width: 480px){
	/*
	@tab Mobile Styles
	@section Preheader Visibility
	@tip Set the visibility of the email\'s preheader on small screens. You can hide it to save space.
	*/
		#templatePreheader{
			/*@editable*/display:block !important;
		}

}	@media only screen and (max-width: 480px){
	/*
	@tab Mobile Styles
	@section Preheader Text
	@tip Make the preheader text larger in size for better readability on small screens.
	*/
		#templatePreheader .mcnTextContent,#templatePreheader .mcnTextContent p{
			/*@editable*/font-size:14px !important;
			/*@editable*/line-height:150% !important;
		}

}	@media only screen and (max-width: 480px){
	/*
	@tab Mobile Styles
	@section Header Text
	@tip Make the header text larger in size for better readability on small screens.
	*/
		#templateHeader .mcnTextContent,#templateHeader .mcnTextContent p{
			/*@editable*/font-size:16px !important;
			/*@editable*/line-height:150% !important;
		}

}	@media only screen and (max-width: 480px){
	/*
	@tab Mobile Styles
	@section Body Text
	@tip Make the body text larger in size for better readability on small screens. We recommend a font size of at least 16px.
	*/
		#templateBody .mcnTextContent,#templateBody .mcnTextContent p{
			/*@editable*/font-size:16px !important;
			/*@editable*/line-height:150% !important;
		}

}	@media only screen and (max-width: 480px){
	/*
	@tab Mobile Styles
	@section Footer Text
	@tip Make the footer content text larger in size for better readability on small screens.
	*/
		#templateFooter .mcnTextContent,#templateFooter .mcnTextContent p{
			/*@editable*/font-size:14px !important;
			/*@editable*/line-height:150% !important;
		}

}</style></head>
    <body>
		
		<span class="mcnPreviewText" style="display:none; font-size:0px; line-height:0px; max-height:0px; max-width:0px; opacity:0; overflow:hidden; visibility:hidden; mso-hide:all;">To ensure delivery to your inbox please add info@vanitapasta.co.za to your contact lists.</span><!--<![endif]-->
		
        <center>
            <table align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="bodyTable">
                <tr>
                    <td align="center" valign="top" id="bodyCell">
                       
                        <table border="0" cellpadding="0" cellspacing="0" width="100%" class="templateContainer">
                            <tr>
                                <td valign="top" id="templatePreheader"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%;">
                        <tbody class="mcnTextBlockOuter">
                            <tr>
                                <td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">
                                    
                                    <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:100%; min-width:100%;" width="100%" class="mcnTextContentContainer">
                                        <tbody><tr>
                                            
                                            <td valign="top" class="mcnTextContent" style="padding: 0px 18px 9px;color: #FFFFFF;text-align: center;">
                                            
                                                <div style="text-align: right;"><a href="http://www.vanitapasta.co.za" target="_blank">View Shop</a></div>
                    
                                            </td>
                                        </tr>
                                    </tbody></table>
                                    
                                </td>
                            </tr>
                        </tbody>
</table></td>
                            </tr>
                            <tr>
                                <td valign="top" id="templateHeader"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnImageBlock" style="min-width:100%;">
                            <tbody class="mcnImageBlockOuter">
                                    <tr>
                                        <td valign="top" style="padding:9px" class="mcnImageBlockInner">
                                            <table align="left" width="100%" border="0" cellpadding="0" cellspacing="0" class="mcnImageContentContainer" style="min-width:100%;">
                                                <tbody><tr>
                                                    <td class="mcnImageContent" valign="top" style="padding-right: 9px; padding-left: 9px; padding-top: 0; padding-bottom: 0; text-align:center;">
                                                        
                                                            <a href="http://www.vanitapasta.co.za" title="" class="" target="_blank">
                                                                <img align="center" alt="" src="https://gallery.mailchimp.com/71958c77348006aa7cbbd4469/images/4ce34200-4166-44c0-8675-ea5cc2489f41.png" width="200" style="max-width:200px; padding-bottom: 0; display: inline !important; vertical-align: bottom;" class="mcnImage">
                                                            </a>
                                                        
                                                    </td>
                                                </tr>
                                            </tbody></table>
                                        </td>
                                    </tr>
                            </tbody>
                        </table></td>
                            </tr>
                            <tr>
                                <td valign="top" id="templateBody"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%;">
    <tbody class="mcnTextBlockOuter">
        <tr>
            <td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">
              	
                <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:300px;" width="100%" class="mcnTextContentContainer">
                    <tbody><tr>
                        
                        <td valign="top" class="mcnTextContent" style="padding: 0px 18px 9px;color: #222222;">
                        
                            <h1>Order Confirmation</h1>

                        </td>
                    </tr>
                </tbody></table>
				
                <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:300px;" width="100%" class="mcnTextContentContainer">
                    <tbody><tr>
                        
                        <td valign="top" class="mcnTextContent" style="padding: 0px 18px 9px;color: #222222;">
                        
                            <div style="text-align: right;">Order Number: '.$orderNum.'<br>
                                                            Ordered on : '.$date_created.'</div>
                
                                        </td>
                                    </tr>
                                </tbody></table>
                                
                            </td>
                        </tr>
                    </tbody>
                </table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%;">
    <tbody class="mcnTextBlockOuter">
        <tr>
            <td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">
              	
				
                        <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:100%; min-width:100%;" width="100%" class="mcnTextContentContainer">
                            <tbody><tr>
                                
                                <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:18px; padding-bottom:9px; padding-left:18px;">
                                
                                    Hi '.$first_name.',
                                    <br>
                                    Thank you for ordering from Vanita Pasta.<br>
                                    This email confirms your order with us. <br>You can expect delivery of your order within 2-3 working days<br>
                                    We will keep you up to date via email on your order status, alternatively, check your order status <a href="http://www.vanitapasta.co.za" target="_blank">here</a> on our website.
                                </td>
                            </tr>
                        </tbody></table>
                        
                    </td>
                </tr>
            </tbody>
                </table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnDividerBlock" style="min-width:100%;">
                    <tbody class="mcnDividerBlockOuter">
                        <tr>
                            <td class="mcnDividerBlockInner" style="min-width: 100%; padding: 18px;">
                                <table class="mcnDividerContent" border="0" cellpadding="0" cellspacing="0" width="100%" style="min-width: 100%;border-top-width: 2px;border-top-style: solid;border-top-color: #EAEAEA;">
                                    <tbody><tr>
                                        <td>
                                            <span></span>
                                        </td>
                                    </tr>
                                </tbody></table>
                
                            </td>
                        </tr>
                    </tbody>
                    </table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%;">
                        <tbody class="mcnTextBlockOuter">
                            <tr>
                                <td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">
                                    
                                    <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:100%; min-width:100%;" width="100%" class="mcnTextContentContainer">
                                        <tbody><tr>
                                            
                                            <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:18px; padding-bottom:9px; padding-left:18px;">
                                            
                                                <strong>Order Details</strong>
                                            </td>
                                        </tr>
                                    </tbody></table>
                                    
                                </td>
                            </tr>
                        </tbody>
                    </table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%;">
                        <tbody class="mcnTextBlockOuter">
        <tr>
            <td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">
              	
                <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:300px;" width="100%" class="mcnTextContentContainer">
                    <tbody><tr>
                        
                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-left:18px; padding-bottom:9px; padding-right:18px;">
                        
                            '.$first_name.' '.$last_name.'<br>
                            '.$email.'<br>
                            '.$contact.'<br>
                            Delivery Method: '.$shipping_method.'<br>
                            Special Delivery Instructions: '.$delivery_msg.'
                        </td>
                    </tr>
                </tbody></table>
				
                <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:300px;" width="100%" class="mcnTextContentContainer">
                    <tbody><tr>
                        
                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-left:18px; padding-bottom:9px; padding-right:18px;">
                        
                            <div style="text-align: justify;"><b>Shipped Address:</b><br>
                            '.$building.'<br>
                            '.$street.'<br>
                            '.$suburb.'<br>
                            '.$city.'<br>
                            '.$province.'<br>
                            '.$postal.'</div>

                        </td>
                    </tr>
                </tbody></table>
				
            </td>
        </tr>
                    </tbody>
                </table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnDividerBlock" style="min-width:100%;">
                    <tbody class="mcnDividerBlockOuter">
                        <tr>
                            <td class="mcnDividerBlockInner" style="min-width: 100%; padding: 18px;">
                                <table class="mcnDividerContent" border="0" cellpadding="0" cellspacing="0" width="100%" style="min-width: 100%;border-top-width: 2px;border-top-style: solid;border-top-color: #EAEAEA;">
                                    <tbody><tr>
                                        <td>
                                            <span></span>
                                        </td>
                                    </tr>
                                </tbody></table>
                
                            </td>
                        </tr>
                    </tbody>
                </table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnCodeBlock">
                    <tbody class="mcnTextBlockOuter">
                        <tr>
                            <td valign="top" class="mcnTextBlockInner">
                                <div class="mcnTextContent">
                <table width="90%">
                <tbody>'.$out_put;

        $html .='
                
                
                </tbody>
                </table>
                </div>
                            </td>
                        </tr>
                    </tbody>
                </table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnCodeBlock">
                    <tbody class="mcnTextBlockOuter">
                        <tr>
                            <td valign="top" class="mcnTextBlockInner">
                                <div class="mcnTextContent"><br>
                <hr>
               
                    
                
                </div>
                            </td>
                        </tr>
                    </tbody>
                </table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnDividerBlock" style="min-width:100%;">
                    <tbody class="mcnDividerBlockOuter">
                        <tr>
                            <td class="mcnDividerBlockInner" style="min-width: 100%; padding: 18px;">
                                <table class="mcnDividerContent" border="0" cellpadding="0" cellspacing="0" width="100%" style="min-width: 100%;border-top-width: 2px;border-top-style: solid;border-top-color: #EAEAEA;">
                                    <tbody><tr>
                                        <td>
                                            <span></span>
                                        </td>
                                    </tr>
                                </tbody></table>
                
                            </td>
                        </tr>
                    </tbody>
                </table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%;">
                    <tbody class="mcnTextBlockOuter">
                        <tr>
                            <td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">
                                
                                <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:100%; min-width:100%;" width="100%" class="mcnTextContentContainer">
                                    <tbody><tr>
                                        
                                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:18px; padding-bottom:9px; padding-left:18px;">
                                        
                                            <div style="text-align: center;"><span style="font-size:12px">Thank you for shopping with us.<br>
                The Vanita Pasta team</span></div>
                
                                        </td>
                                    </tr>
                                </tbody></table>
                                
                            </td>
                        </tr>
                    </tbody>
                </table></td>
                                            </tr>
                                            <tr>
                                                <td valign="top" id="templateFooter"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%;">
                    <tbody class="mcnTextBlockOuter">
                        <tr>
                            <td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">
                              
                                <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:100%; min-width:100%;" width="100%" class="mcnTextContentContainer">
                                    <tbody><tr>
                                        
                                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:18px; padding-bottom:9px; padding-left:18px;">
                                        
                                            <span style="color:#FFFFFF"><span style="caret-color: #000000;">For any queries email us at info@vanitapasta.co.za or call us on&nbsp;</span>&nbsp;011 025 8033</span>
                
                <p id="u3127-11"><span style="color:#FFFFFF">5 Main Reef Rd, Boksburg North, Gauteng, South Africa</span></p>
                
                                        </td>
                                    </tr>
                                </tbody></table>
                                
                            </td>
                        </tr>
                    </tbody>
                </table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnFollowBlock" style="min-width:100%;">
                    <tbody class="mcnFollowBlockOuter">
                        <tr>
                            <td align="center" valign="top" style="padding:9px" class="mcnFollowBlockInner">
                                <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnFollowContentContainer" style="min-width:100%;">
                    <tbody><tr>
                        <td align="center" style="padding-left:9px;padding-right:9px;">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="min-width:100%;" class="mcnFollowContent">
                                <tbody><tr>
                                    <td align="center" valign="top" style="padding-top:9px; padding-right:9px; padding-left:9px;">
                                        <table align="center" border="0" cellpadding="0" cellspacing="0">
                                            <tbody><tr>
                                                <td align="center" valign="top">
                                                    
                                                        
                                                        
                                                            <table align="left" border="0" cellpadding="0" cellspacing="0" style="display:inline;">
                                                                <tbody><tr>
                                                                    <td valign="top" style="padding-right:10px; padding-bottom:9px;" class="mcnFollowContentItemContainer">
                                                                        <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnFollowContentItem">
                                                                            <tbody><tr>
                                                                                <td align="left" valign="middle" style="padding-top:5px; padding-right:10px; padding-bottom:5px; padding-left:9px;">
                                                                                    <table align="left" border="0" cellpadding="0" cellspacing="0" width="">
                                                                                        <tbody><tr>
                                                                                            
                                                                                                <td align="center" valign="middle" width="24" class="mcnFollowIconContent">
                                                                                                    <a href="'.$facebook.'" target="_blank"><img src="https://cdn-images.mailchimp.com/icons/social-block-v2/outline-light-facebook-48.png" style="display:block;" height="24" width="24" class=""></a>
                                                                                                </td>
                                                                                            
                                                                                            
                                                                                        </tr>
                                                                                    </tbody></table>
                                                                                </td>
                                                                            </tr>
                                                                        </tbody></table>
                                                                    </td>
                                                                </tr>
                                                            </tbody></table>
                                                        
                                                       
                                                        
                                                        
                                                            <table align="left" border="0" cellpadding="0" cellspacing="0" style="display:inline;">
                                                                <tbody><tr>
                                                                    <td valign="top" style="padding-right:10px; padding-bottom:9px;" class="mcnFollowContentItemContainer">
                                                                        <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnFollowContentItem">
                                                                            <tbody><tr>
                                                                                <td align="left" valign="middle" style="padding-top:5px; padding-right:10px; padding-bottom:5px; padding-left:9px;">
                                                                                    <table align="left" border="0" cellpadding="0" cellspacing="0" width="">
                                                                                        <tbody><tr>
                                                                                            
                                                                                                <td align="center" valign="middle" width="24" class="mcnFollowIconContent">
                                                                                                    <a href="'.$instagram.'" target="_blank"><img src="https://cdn-images.mailchimp.com/icons/social-block-v2/outline-light-instagram-48.png" style="display:block;" height="24" width="24" class=""></a>
                                                                                                </td>
                                                                                            
                                                                                            
                                                                                        </tr>
                                                                                    </tbody></table>
                                                                                </td>
                                                                            </tr>
                                                                        </tbody></table>
                                                                    </td>
                                                                </tr>
                                                            </tbody></table>
                                                        
                                                      
                                                        
                                                            <table align="left" border="0" cellpadding="0" cellspacing="0" style="display:inline;">
                                                                <tbody><tr>
                                                                    <td valign="top" style="padding-right:10px; padding-bottom:9px;" class="mcnFollowContentItemContainer">
                                                                        <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnFollowContentItem">
                                                                            <tbody><tr>
                                                                                <td align="left" valign="middle" style="padding-top:5px; padding-right:10px; padding-bottom:5px; padding-left:9px;">
                                                                                    <table align="left" border="0" cellpadding="0" cellspacing="0" width="">
                                                                                        <tbody><tr>
                                                                                            
                                                                                                <td align="center" valign="middle" width="24" class="mcnFollowIconContent">
                                                                                                    <a href="'.$youtube.'" target="_blank"><img src="https://cdn-images.mailchimp.com/icons/social-block-v2/outline-light-youtube-48.png" style="display:block;" height="24" width="24" class=""></a>
                                                                                                </td>
                                                                                            
                                                                                            
                                                                                        </tr>
                                                                                    </tbody></table>
                                                                                </td>
                                                                            </tr>
                                                                        </tbody></table>
                                                                    </td>
                                                                </tr>
                                                            </tbody></table>
                                                        
                                                            <table align="left" border="0" cellpadding="0" cellspacing="0" style="display:inline;">
                                                                <tbody><tr>
                                                                    <td valign="top" style="padding-right:0; padding-bottom:9px;" class="mcnFollowContentItemContainer">
                                                                        <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnFollowContentItem">
                                                                            <tbody><tr>
                                                                                <td align="left" valign="middle" style="padding-top:5px; padding-right:10px; padding-bottom:5px; padding-left:9px;">
                                                                                    <table align="left" border="0" cellpadding="0" cellspacing="0" width="">
                                                                                        <tbody><tr>
                                                                                            
                                                                                                <td align="center" valign="middle" width="24" class="mcnFollowIconContent">
                                                                                                    <a href="'.$google_plus.'" target="_blank"><img src="https://cdn-images.mailchimp.com/icons/social-block-v2/outline-light-googleplus-48.png" style="display:block;" height="24" width="24" class=""></a>
                                                                                                </td>
                                                                                            
                                                                                            
                                                                                        </tr>
                                                                                    </tbody></table>
                                                                                </td>
                                                                            </tr>
                                                                        </tbody></table>
                                                                    </td>
                                                                </tr>
                                                            </tbody></table>
                                                   
                                                </td>
                                            </tr>
                                        </tbody></table>
                                    </td>
                                </tr>
                            </tbody></table>
                        </td>
                    </tr>
                </tbody></table>
                
                            </td>
                        </tr>
                    </tbody>
                </table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnDividerBlock" style="min-width:100%;">
                    <tbody class="mcnDividerBlockOuter">
                        <tr>
                            <td class="mcnDividerBlockInner" style="min-width: 100%; padding: 10px 18px 25px;">
                                <table class="mcnDividerContent" border="0" cellpadding="0" cellspacing="0" width="100%" style="min-width: 100%;border-top-width: 2px;border-top-style: solid;border-top-color: #EEEEEE;">
                                    <tbody><tr>
                                        <td>
                                            <span></span>
                                        </td>
                                    </tr>
                                </tbody></table>
                
                            </td>
                        </tr>
                    </tbody>
                </table></td>
                                            </tr>
                                        </table>
                                        
                                    </td>
                                </tr>
                            </table>
                        </center>
                    </body>
</html>
';


        require_once '../../admin/src/plugins/PHPMailer/src/Exception.php';
        require_once '../../admin/src/plugins/PHPMailer/src/PHPMailer.php';
        require_once '../../admin/src/plugins/PHPMailer/src/SMTP.php';

        $mail = new PHPMailer\PHPMailer\PHPMailer();



        $mail->isSMTP();
        $mail->Host = "timmy.aserv.co.za";
        $mail->SMTPSecure = "ssl";
        $mail->Port = 465;
        $mail->SMTPAuth = true;
        $mail->Username = 'no_reply@creativeplatform.co.za';
        $mail->Password = 'Noselicks101';
        $mail->isHTML(true);
        // Sent from address
        $mail->setFrom('no_reply@creativeplatform.co.za');
        $mail->addAddress(' djmwinter@gmail.com');
        $mail->Subject = 'Vanita Pasta | Order Number: '.$orderNum;
        $mail->Body = "$html";

        if ($mail->send()){
            $msg = "Your email has been sent, thank you!";
            return $msg;
        }

        else
            $msg = "Email Not sent :".$mail->ErrorInfo;
            return $msg;






    }


    function send_admin_email ($order_number){

        $db = new Database();


        $out_put ='';
        $out_put .='<table class="mcnCodeBlock" border="0" cellpadding="0" cellspacing="0" width="100%" >
                        <thead>
                        <tr>
                            <th colspan="2" class="text-center">Product</th>
                            <th>Variant</th>
                            <th>Unit Price</th>
                            <th>Qty</th>
                            <th class="text-right">Total</th>
                        </tr>
                        </thead>
                        <tbody>
                            ';

        $sql_products = "SELECT * FROM order_product WHERE order_number = '".$order_number."'";
        $products = $db->select($sql_products);
        if(sizeof($products)>0){
            foreach ($products as $product_details){
                $sql_prodImg = "SELECT main_img FROM products WHERE id = '".$product_details['product_id']."'";
                $main_img = $db->select($sql_prodImg);
                $out_put .='<tr>
                                                <td><img width="50px" height="50px" src="http://www.vanitapasta/storefront/img/product_img/'.$main_img[0]["main_img"].'"></td>
                                                <td>'.$product_details['product_name'].'</td>
                                                <td>'.$product_details['variant_name'].'</td>
                                                <td>R '.number_format($product_details['price'], 2, ',',',').'</td>
                                                <td>'.$product_details['qty'].'</td>
                                                <td align="right">R '.number_format($product_details['line_total'],2, ',',',').'</td>
                                            </tr>';
            }
        }
        $sql_totals = "SELECT * FROM order_totals WHERE order_number = '".$order_number."'";
        $totals = $db->select($sql_totals);


        $out_put.= '
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="5" class="text-right" >Subtotal (<span class="no_of_items_2"></span> items) </td>
                                    <td align="right"><span>R '.number_format($totals[0]['subtotal'],2, ',', ',').'</span></td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="text-right">Shipping</td>
                                    <td align="right"><span>R '.number_format($totals[0]['ship_total'],2, ',', ',').'</span></td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="text-right">Tax @ 15% (included)</td>
                                    <td align="right"><span >R '.number_format($totals[0]['tax'],2, ',', ',').'</span></td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="text-right"><b>Total</b></td>
                                    <td align="right"><span>R '.number_format($totals[0]['final_total'],2, ',', ',').'</span></td>
                                </tr>
                                </tfoot>
                          

                            </table>';


        $admin_sql = "SELECT * FROM admin_user";
        $admin_details = $db->select($admin_sql);
        
        
        require_once '../../admin/src/plugins/PHPMailer/src/Exception.php';
            require_once '../../admin/src/plugins/PHPMailer/src/PHPMailer.php';
            require_once '../../admin/src/plugins/PHPMailer/src/SMTP.php';
        

        foreach ($admin_details as $admins){
            $admin_email =  '';
            $admin_email .= '
                    <!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
	<head>
		
		<meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<title>New Order</title>
        
    <style type="text/css">
		p{
			margin:10px 0;
			padding:0;
		}
		table{
			border-collapse:collapse;
		}
		h1,h2,h3,h4,h5,h6{
			display:block;
			margin:0;
			padding:0;
		}
		img,a img{
			border:0;
			height:auto;
			outline:none;
			text-decoration:none;
		}
		body,#bodyTable,#bodyCell{
			height:100%;
			margin:0;
			padding:0;
			width:100%;
		}
		.mcnPreviewText{
			display:none !important;
		}
		#outlook a{
			padding:0;
		}
		img{
			-ms-interpolation-mode:bicubic;
		}
		table{
			mso-table-lspace:0pt;
			mso-table-rspace:0pt;
		}
		.ReadMsgBody{
			width:100%;
		}
		.ExternalClass{
			width:100%;
		}
		p,a,li,td,blockquote{
			mso-line-height-rule:exactly;
		}
		a[href^=tel],a[href^=sms]{
			color:inherit;
			cursor:default;
			text-decoration:none;
		}
		p,a,li,td,body,table,blockquote{
			-ms-text-size-adjust:100%;
			-webkit-text-size-adjust:100%;
		}
		.ExternalClass,.ExternalClass p,.ExternalClass td,.ExternalClass div,.ExternalClass span,.ExternalClass font{
			line-height:100%;
		}
		a[x-apple-data-detectors]{
			color:inherit !important;
			text-decoration:none !important;
			font-size:inherit !important;
			font-family:inherit !important;
			font-weight:inherit !important;
			line-height:inherit !important;
		}
		#bodyCell{
			padding:10px;
		}
		.templateContainer{
			max-width:600px !important;
		}
		a.mcnButton{
			display:block;
		}
		.mcnImage,.mcnRetinaImage{
			vertical-align:bottom;
		}
		.mcnTextContent{
			word-break:break-word;
		}
		.mcnTextContent img{
			height:auto !important;
		}
		.mcnDividerBlock{
			table-layout:fixed !important;
		}
	/*
	@tab Page
	@section Background Style
	@tip Set the background color and top border for your email. You may want to choose colors that match your company\'s branding.
	*/
		body,#bodyTable{
			/*@editable*/background-color:#FAFAFA;
		}
	/*
	@tab Page
	@section Background Style
	@tip Set the background color and top border for your email. You may want to choose colors that match your company\'s branding.
	*/
		#bodyCell{
			/*@editable*/border-top:0;
		}
	/*
	@tab Page
	@section Email Border
	@tip Set the border for your email.
	*/
		.templateContainer{
			/*@editable*/border:0;
		}
	/*
	@tab Page
	@section Heading 1
	@tip Set the styling for all first-level headings in your emails. These should be the largest of your headings.
	@style heading 1
	*/
		h1{
			/*@editable*/color:#202020;
			/*@editable*/font-family:Helvetica;
			/*@editable*/font-size:26px;
			/*@editable*/font-style:normal;
			/*@editable*/font-weight:bold;
			/*@editable*/line-height:125%;
			/*@editable*/letter-spacing:normal;
			/*@editable*/text-align:left;
		}
	/*
	@tab Page
	@section Heading 2
	@tip Set the styling for all second-level headings in your emails.
	@style heading 2
	*/
		h2{
			/*@editable*/color:#202020;
			/*@editable*/font-family:Helvetica;
			/*@editable*/font-size:22px;
			/*@editable*/font-style:normal;
			/*@editable*/font-weight:bold;
			/*@editable*/line-height:125%;
			/*@editable*/letter-spacing:normal;
			/*@editable*/text-align:left;
		}
	/*
	@tab Page
	@section Heading 3
	@tip Set the styling for all third-level headings in your emails.
	@style heading 3
	*/
		h3{
			/*@editable*/color:#202020;
			/*@editable*/font-family:Helvetica;
			/*@editable*/font-size:20px;
			/*@editable*/font-style:normal;
			/*@editable*/font-weight:bold;
			/*@editable*/line-height:125%;
			/*@editable*/letter-spacing:normal;
			/*@editable*/text-align:left;
		}
	/*
	@tab Page
	@section Heading 4
	@tip Set the styling for all fourth-level headings in your emails. These should be the smallest of your headings.
	@style heading 4
	*/
		h4{
			/*@editable*/color:#202020;
			/*@editable*/font-family:Helvetica;
			/*@editable*/font-size:18px;
			/*@editable*/font-style:normal;
			/*@editable*/font-weight:bold;
			/*@editable*/line-height:125%;
			/*@editable*/letter-spacing:normal;
			/*@editable*/text-align:left;
		}
	/*
	@tab Preheader
	@section Preheader Style
	@tip Set the background color and borders for your email\'s preheader area.
	*/
		#templatePreheader{
			/*@editable*/background-color:#3182d8;
			/*@editable*/background-image:none;
			/*@editable*/background-repeat:no-repeat;
			/*@editable*/background-position:center;
			/*@editable*/background-size:cover;
			/*@editable*/border-top:0;
			/*@editable*/border-bottom:0;
			/*@editable*/padding-top:9px;
			/*@editable*/padding-bottom:9px;
		}
	/*
	@tab Preheader
	@section Preheader Text
	@tip Set the styling for your email\'s preheader text. Choose a size and color that is easy to read.
	*/
		#templatePreheader .mcnTextContent,#templatePreheader .mcnTextContent p{
			/*@editable*/color:#656565;
			/*@editable*/font-family:Helvetica;
			/*@editable*/font-size:12px;
			/*@editable*/line-height:150%;
			/*@editable*/text-align:left;
		}
	/*
	@tab Preheader
	@section Preheader Link
	@tip Set the styling for your email\'s preheader links. Choose a color that helps them stand out from your text.
	*/
		#templatePreheader .mcnTextContent a,#templatePreheader .mcnTextContent p a{
			/*@editable*/color:#656565;
			/*@editable*/font-weight:normal;
			/*@editable*/text-decoration:underline;
		}
	/*
	@tab Header
	@section Header Style
	@tip Set the background color and borders for your email\'s header area.
	*/
		#templateHeader{
			/*@editable*/background-color:#FFFFFF;
			/*@editable*/background-image:none;
			/*@editable*/background-repeat:no-repeat;
			/*@editable*/background-position:center;
			/*@editable*/background-size:cover;
			/*@editable*/border-top:0;
			/*@editable*/border-bottom:0;
			/*@editable*/padding-top:9px;
			/*@editable*/padding-bottom:0;
		}
	/*
	@tab Header
	@section Header Text
	@tip Set the styling for your email\'s header text. Choose a size and color that is easy to read.
	*/
		#templateHeader .mcnTextContent,#templateHeader .mcnTextContent p{
			/*@editable*/color:#202020;
			/*@editable*/font-family:Helvetica;
			/*@editable*/font-size:16px;
			/*@editable*/line-height:150%;
			/*@editable*/text-align:left;
		}
	/*
	@tab Header
	@section Header Link
	@tip Set the styling for your email\'s header links. Choose a color that helps them stand out from your text.
	*/
		#templateHeader .mcnTextContent a,#templateHeader .mcnTextContent p a{
			/*@editable*/color:#2BAADF;
			/*@editable*/font-weight:normal;
			/*@editable*/text-decoration:underline;
		}
	/*
	@tab Body
	@section Body Style
	@tip Set the background color and borders for your email\'s body area.
	*/
		#templateBody{
			/*@editable*/background-color:#FFFFFF;
			/*@editable*/background-image:none;
			/*@editable*/background-repeat:no-repeat;
			/*@editable*/background-position:center;
			/*@editable*/background-size:cover;
			/*@editable*/border-top:0;
			/*@editable*/border-bottom:2px solid #EAEAEA;
			/*@editable*/padding-top:0;
			/*@editable*/padding-bottom:9px;
		}
	/*
	@tab Body
	@section Body Text
	@tip Set the styling for your email\'s body text. Choose a size and color that is easy to read.
	*/
		#templateBody .mcnTextContent,#templateBody .mcnTextContent p{
			/*@editable*/color:#202020;
			/*@editable*/font-family:Helvetica;
			/*@editable*/font-size:16px;
			/*@editable*/line-height:150%;
			/*@editable*/text-align:left;
		}
	/*
	@tab Body
	@section Body Link
	@tip Set the styling for your email\'s body links. Choose a color that helps them stand out from your text.
	*/
		#templateBody .mcnTextContent a,#templateBody .mcnTextContent p a{
			/*@editable*/color:#2BAADF;
			/*@editable*/font-weight:normal;
			/*@editable*/text-decoration:underline;
		}
	/*
	@tab Footer
	@section Footer Style
	@tip Set the background color and borders for your email\'s footer area.
	*/
		#templateFooter{
			/*@editable*/background-color:#FAFAFA;
			/*@editable*/background-image:none;
			/*@editable*/background-repeat:no-repeat;
			/*@editable*/background-position:center;
			/*@editable*/background-size:cover;
			/*@editable*/border-top:0;
			/*@editable*/border-bottom:0;
			/*@editable*/padding-top:9px;
			/*@editable*/padding-bottom:9px;
		}
	/*
	@tab Footer
	@section Footer Text
	@tip Set the styling for your email\'s footer text. Choose a size and color that is easy to read.
	*/
		#templateFooter .mcnTextContent,#templateFooter .mcnTextContent p{
			/*@editable*/color:#656565;
			/*@editable*/font-family:Helvetica;
			/*@editable*/font-size:12px;
			/*@editable*/line-height:150%;
			/*@editable*/text-align:center;
		}
	/*
	@tab Footer
	@section Footer Link
	@tip Set the styling for your email\'s footer links. Choose a color that helps them stand out from your text.
	*/
		#templateFooter .mcnTextContent a,#templateFooter .mcnTextContent p a{
			/*@editable*/color:#656565;
			/*@editable*/font-weight:normal;
			/*@editable*/text-decoration:underline;
		}
	@media only screen and (min-width:768px){
		.templateContainer{
			width:600px !important;
		}

}	@media only screen and (max-width: 480px){
		body,table,td,p,a,li,blockquote{
			-webkit-text-size-adjust:none !important;
		}

}	@media only screen and (max-width: 480px){
		body{
			width:100% !important;
			min-width:100% !important;
		}

}	@media only screen and (max-width: 480px){
		#bodyCell{
			padding-top:10px !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnRetinaImage{
			max-width:100% !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnImage{
			width:100% !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnCartContainer,.mcnCaptionTopContent,.mcnRecContentContainer,.mcnCaptionBottomContent,.mcnTextContentContainer,.mcnBoxedTextContentContainer,.mcnImageGroupContentContainer,.mcnCaptionLeftTextContentContainer,.mcnCaptionRightTextContentContainer,.mcnCaptionLeftImageContentContainer,.mcnCaptionRightImageContentContainer,.mcnImageCardLeftTextContentContainer,.mcnImageCardRightTextContentContainer,.mcnImageCardLeftImageContentContainer,.mcnImageCardRightImageContentContainer{
			max-width:100% !important;
			width:100% !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnBoxedTextContentContainer{
			min-width:100% !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnImageGroupContent{
			padding:9px !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnCaptionLeftContentOuter .mcnTextContent,.mcnCaptionRightContentOuter .mcnTextContent{
			padding-top:9px !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnImageCardTopImageContent,.mcnCaptionBottomContent:last-child .mcnCaptionBottomImageContent,.mcnCaptionBlockInner .mcnCaptionTopContent:last-child .mcnTextContent{
			padding-top:18px !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnImageCardBottomImageContent{
			padding-bottom:9px !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnImageGroupBlockInner{
			padding-top:0 !important;
			padding-bottom:0 !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnImageGroupBlockOuter{
			padding-top:9px !important;
			padding-bottom:9px !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnTextContent,.mcnBoxedTextContentColumn{
			padding-right:18px !important;
			padding-left:18px !important;
		}

}	@media only screen and (max-width: 480px){
		.mcnImageCardLeftImageContent,.mcnImageCardRightImageContent{
			padding-right:18px !important;
			padding-bottom:0 !important;
			padding-left:18px !important;
		}

}	@media only screen and (max-width: 480px){
		.mcpreview-image-uploader{
			display:none !important;
			width:100% !important;
		}

}	@media only screen and (max-width: 480px){
	/*
	@tab Mobile Styles
	@section Heading 1
	@tip Make the first-level headings larger in size for better readability on small screens.
	*/
		h1{
			/*@editable*/font-size:22px !important;
			/*@editable*/line-height:125% !important;
		}

}	@media only screen and (max-width: 480px){
	/*
	@tab Mobile Styles
	@section Heading 2
	@tip Make the second-level headings larger in size for better readability on small screens.
	*/
		h2{
			/*@editable*/font-size:20px !important;
			/*@editable*/line-height:125% !important;
		}

}	@media only screen and (max-width: 480px){
	/*
	@tab Mobile Styles
	@section Heading 3
	@tip Make the third-level headings larger in size for better readability on small screens.
	*/
		h3{
			/*@editable*/font-size:18px !important;
			/*@editable*/line-height:125% !important;
		}

}	@media only screen and (max-width: 480px){
	/*
	@tab Mobile Styles
	@section Heading 4
	@tip Make the fourth-level headings larger in size for better readability on small screens.
	*/
		h4{
			/*@editable*/font-size:16px !important;
			/*@editable*/line-height:150% !important;
		}

}	@media only screen and (max-width: 480px){
	/*
	@tab Mobile Styles
	@section Boxed Text
	@tip Make the boxed text larger in size for better readability on small screens. We recommend a font size of at least 16px.
	*/
		.mcnBoxedTextContentContainer .mcnTextContent,.mcnBoxedTextContentContainer .mcnTextContent p{
			/*@editable*/font-size:14px !important;
			/*@editable*/line-height:150% !important;
		}

}	@media only screen and (max-width: 480px){
	/*
	@tab Mobile Styles
	@section Preheader Visibility
	@tip Set the visibility of the email\'s preheader on small screens. You can hide it to save space.
	*/
		#templatePreheader{
			/*@editable*/display:block !important;
		}

}	@media only screen and (max-width: 480px){
	/*
	@tab Mobile Styles
	@section Preheader Text
	@tip Make the preheader text larger in size for better readability on small screens.
	*/
		#templatePreheader .mcnTextContent,#templatePreheader .mcnTextContent p{
			/*@editable*/font-size:14px !important;
			/*@editable*/line-height:150% !important;
		}

}	@media only screen and (max-width: 480px){
	/*
	@tab Mobile Styles
	@section Header Text
	@tip Make the header text larger in size for better readability on small screens.
	*/
		#templateHeader .mcnTextContent,#templateHeader .mcnTextContent p{
			/*@editable*/font-size:16px !important;
			/*@editable*/line-height:150% !important;
		}

}	@media only screen and (max-width: 480px){
	/*
	@tab Mobile Styles
	@section Body Text
	@tip Make the body text larger in size for better readability on small screens. We recommend a font size of at least 16px.
	*/
		#templateBody .mcnTextContent,#templateBody .mcnTextContent p{
			/*@editable*/font-size:16px !important;
			/*@editable*/line-height:150% !important;
		}

}	@media only screen and (max-width: 480px){
	/*
	@tab Mobile Styles
	@section Footer Text
	@tip Make the footer content text larger in size for better readability on small screens.
	*/
		#templateFooter .mcnTextContent,#templateFooter .mcnTextContent p{
			/*@editable*/font-size:14px !important;
			/*@editable*/line-height:150% !important;
		}

}</style></head>
    <body>
		<!--*|IF:MC_PREVIEW_TEXT|*-->
		<!--[if !gte mso 9]>--><span class="mcnPreviewText" style="display:none; font-size:0px; line-height:0px; max-height:0px; max-width:0px; opacity:0; overflow:hidden; visibility:hidden; mso-hide:all;">To ensure delivery to your inbox please add info@vanitapasta.co.za to your contact lists</span><!--<![endif]-->
		<!--*|END:IF|*-->
        <center>
            <table align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="bodyTable">
                <tr>
                    <td align="center" valign="top" id="bodyCell">
                        
                        <table border="0" cellpadding="0" cellspacing="0" width="100%" class="templateContainer">
                            <tr>
                                <td valign="top" id="templatePreheader"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%;">
    <tbody class="mcnTextBlockOuter">
        <tr>
            <td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">
              	<!--[if mso]>
				<table align="left" border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100%;">
				<tr>
				<![endif]-->
			    
				<!--[if mso]>
				<td valign="top" width="600" style="width:600px;">
				<![endif]-->
                <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:100%; min-width:100%;" width="100%" class="mcnTextContentContainer">
                    <tbody><tr>
                        
                        <td valign="top" class="mcnTextContent" style="padding: 0px 18px 9px;color: #FFFFFF;text-align: center;">
                        
                            Vanita Pasta | Admin Panel&nbsp;
                        </td>
                    </tr>
                </tbody></table>
				
            </td>
        </tr>
    </tbody>
</table></td>
                            </tr>
                            <tr>
                                <td valign="top" id="templateHeader"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnImageBlock" style="min-width:100%;">
    <tbody class="mcnImageBlockOuter">
            <tr>
                <td valign="top" style="padding:9px" class="mcnImageBlockInner">
                    <table align="left" width="100%" border="0" cellpadding="0" cellspacing="0" class="mcnImageContentContainer" style="min-width:100%;">
                        <tbody><tr>
                            <td class="mcnImageContent" valign="top" style="padding-right: 9px; padding-left: 9px; padding-top: 0; padding-bottom: 0; text-align:center;">
                                
                                    
                                        <img align="center" alt="" src="https://gallery.mailchimp.com/71958c77348006aa7cbbd4469/images/4ce34200-4166-44c0-8675-ea5cc2489f41.png" width="200" style="max-width:200px; padding-bottom: 0; display: inline !important; vertical-align: bottom;" class="mcnImage">
                                    
                                
                            </td>
                        </tr>
                    </tbody></table>
                </td>
            </tr>
    </tbody>
</table></td>
                            </tr>
                            <tr>
                                <td valign="top" id="templateBody"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%;">
    <tbody class="mcnTextBlockOuter">
        <tr>
            <td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">
              	
                <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:100%; min-width:100%;" width="100%" class="mcnTextContentContainer">
                    <tbody><tr>
                        
                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:18px; padding-bottom:9px; padding-left:18px;">
                        
                            <h1>Good Day '.$admins['firstName'].'</h1>

<p>Good News, you have a new order to attend to.<br>
<br>
To view and update this order <a href="http://www.vanitapasta.co.za" target="_blank">log in</a>.<br>
<br>
&nbsp;</p>

                        </td>
                    </tr>
                </tbody></table>
				
            </td>
        </tr>
    </tbody>
</table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%;">
    <tbody class="mcnTextBlockOuter">
        <tr>
            <td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">
              	
                <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:300px;" width="100%" class="mcnTextContentContainer">
                    <tbody><tr>
                        
                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-left:18px; padding-bottom:9px; padding-right:18px;">
                        
                            <div style="text-align: left;"><span style="font-size:20px"><strong>Order Details</strong></span></div>

                        </td>
                    </tr>
                </tbody></table>
				<!--[if mso]>
				</td>
				<![endif]-->
                
				<!--[if mso]>
				<td valign="top" width="300" style="width:300px;">
				<![endif]-->
                <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:300px;" width="100%" class="mcnTextContentContainer">
                    <tbody><tr>
                        
                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-left:18px; padding-bottom:9px; padding-right:18px;">
                        
                            <div style="text-align: right;">Order Number: '.$order_number.'<br>
								Date: '.$date_created.'</div>

                        </td>
                    </tr>
                </tbody></table>
				
            </td>
        </tr>
    </tbody>
</table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnDividerBlock" style="min-width:100%;">
    <tbody class="mcnDividerBlockOuter">
        <tr>
            <td class="mcnDividerBlockInner" style="min-width: 100%; padding: 18px;">
                <table class="mcnDividerContent" border="0" cellpadding="0" cellspacing="0" width="100%" style="min-width: 100%;border-top-width: 2px;border-top-style: solid;border-top-color: #EAEAEA;">
                    <tbody><tr>
                        <td>
                            <span></span>
                        </td>
                    </tr>
                </tbody></table>
<!--            
-->
            </td>
        </tr>
    </tbody>
</table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnCodeBlock">
    <tbody class="mcnTextBlockOuter">
        <tr>
            <td valign="top" class="mcnTextBlockInner">
                <div class="mcnTextContent">


' .$out_put.'



</div>
            </td>
        </tr>
    </tbody>
</table></td>
                            </tr>
                            <tr>
                                <td valign="top" id="templateFooter"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%;">
    <tbody class="mcnTextBlockOuter">
        <tr>
            <td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">
              	
			
                <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:100%; min-width:100%;" width="100%" class="mcnTextContentContainer">
                    <tbody><tr>
                        
                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:18px; padding-bottom:9px; padding-left:18px;">
                        
                            <em>Copyright © Vanita Pasta, All rights reserved.</em><br>
<br>
<br>
<br>
<br>
<br>
&nbsp;
                        </td>
                    </tr>
                </tbody></table>
				
            </td>
        </tr>
    </tbody>
</table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnDividerBlock" style="min-width:100%;">
    <tbody class="mcnDividerBlockOuter">
        <tr>
            <td class="mcnDividerBlockInner" style="min-width: 100%; padding: 10px 18px 25px;">
                <table class="mcnDividerContent" border="0" cellpadding="0" cellspacing="0" width="100%" style="min-width: 100%;border-top-width: 2px;border-top-style: solid;border-top-color: #EEEEEE;">
                    <tbody><tr>
                        <td>
                            <span></span>
                        </td>
                    </tr>
                </tbody></table>
          
               
            </td>
        </tr>
    </tbody>
</table></td>
                            </tr>
                        </table>
						
                    </td>
                </tr>
            </table>
        </center>
    </body>
</html>

                    
                    
                    
                    
                    
                    ';

            

            $mail = new PHPMailer\PHPMailer\PHPMailer();
            $mail->isSMTP();
            $mail->Host = "timmy.aserv.co.za";
            $mail->SMTPSecure = "ssl";
            $mail->Port = 465;
            $mail->SMTPAuth = true;
            $mail->Username = 'no_reply@creativeplatform.co.za';
            $mail->Password = 'Noselicks101';
            $mail->isHTML(true);
            // Sent from address
            $mail->setFrom('no_reply@creativeplatform.co.za');
            $mail->addAddress($admins["email"]);
            $mail->Subject = 'Vanita Pasta | Order Number: '.$order_number;
            $mail->Body = "$admin_email";

            if ($mail->send()){
                $msg = "Your admin email has been sent, thank you!";
                //return $msg;

            }

            else
                $msg = "Error with admin email:".$mail->ErrorInfo;
            //return $msg;





        }





    }









}