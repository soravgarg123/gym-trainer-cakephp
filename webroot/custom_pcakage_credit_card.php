<?php
    error_reporting(0);
    $data = $_GET;
    $cardsplit = str_split($data['card_no']);
    $ssl_customer_code = $cardsplit[12].$cardsplit[13].$cardsplit[14].$cardsplit[15];
    $ssl_invoice_number = time();
    $ssl_transaction_type = "ccsale";
    $ssl_cvv2cvc2_indicator = 1;
    $country = "USA";
    $fields = array(
        "ssl_merchant_id" => "741388",
        "ssl_user_id" => "websales",
        "ssl_pin" => "663660",
        "ssl_transaction_type" => urlencode($ssl_transaction_type),
        "ssl_show_form" => "false",
        "ssl_cvv2cvc2_indicator" => urlencode($ssl_cvv2cvc2_indicator), //0=Bypassed; 1=present; 2=Illegible; 9=Not Present.
        "ssl_salestax" => "0", 
        "ssl_result_format" => "ASCII",
        "ssl_test_mode" => "false",
        "ssl_receipt_apprvl_method" => "redg", 
        // "ssl_receipt_link_url" => "https://virtualtrainr.com/trainees/customCreditCardResponse",
        // "ssl_error_url" => "https://virtualtrainr.com/customCreditCardError",
        "ssl_receipt_link_url" => "http://localhost/fitness/trainees/customCreditCardResponse",
        "ssl_error_url" => "http://localhost/fitness/trainees/customCreditCardError",
        "ssl_invoice_number" => urlencode($ssl_invoice_number),
        "ssl_customer_code" => urlencode($ssl_customer_code),
        "ssl_country" => urlencode($country),
        "ssl_card_number" => urlencode($data['card_no']),
        "ssl_exp_date" => urlencode($data['expiry_date']),
        "ssl_cvv2cvc2" => urlencode($data['card_cvv']),
        "ssl_amount" => urlencode($data['total_amt'])
    );
    $url = "https://www.myvirtualmerchant.com/VirtualMerchant/process.do";
    $fields_string = '';
    foreach($fields as $key=>$value) { $fields_string .=$key.'='.$value.'&'; }
    rtrim($fields_string, "&");
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    $result = curl_exec($ch);
    curl_close($ch);
 ?>


