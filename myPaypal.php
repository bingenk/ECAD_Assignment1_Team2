<?php

$PayPalMode  = 'sandbox';
$PayPalApiUsername  = 'sb-0hags26657120_api1.business.example.com';
$PayPalApiPassword 	= 'CMZ88ZBDWG6XGSZ8'; 		
$PayPalApiSignature = 'AGYVyZWqa4Oe.-gbVfF54kS0WjsiAw5skua5P46dST2tHx.6wlZDhOxP'; 		
$PayPalCurrencyCode  = 'SGD'; 
$PayPalReturnURL  	= 'http://localhost:8081/xampp/ECAD_Assignment1_Team2/orderConfirmation';                
$PayPalCancelURL 	= 'http://localhost:8081/xampp/ECAD_Assignment1_Team2/shoppingCart'; 

function PPHttpPost($methodName_, $nvpStr_, $PayPalApiUsername, $PayPalApiPassword, 
                    $PayPalApiSignature, $PayPalMode) {

	$API_UserName = urlencode($PayPalApiUsername);
	$API_Password = urlencode($PayPalApiPassword);
	$API_Signature = urlencode($PayPalApiSignature);
			
	if($PayPalMode=='sandbox'){
		$paypalmode = '.sandbox';
	}
	else {
		$paypalmode = '';
	}
	
	$API_Endpoint = "https://api-3t".$paypalmode.".paypal.com/nvp";
	$version = urlencode('109.0');
		
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $API_Endpoint);
	curl_setopt($ch, CURLOPT_VERBOSE, 1);			
			
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, 1);	
				
	$nvpreq = "METHOD=$methodName_&VERSION=$version";
	$nvpreq .= "&PWD=$API_Password&USER=$API_UserName&SIGNATURE=$API_Signature$nvpStr_";
			
	curl_setopt($ch, CURLOPT_POSTFIELDS, $nvpreq);
		
	$httpResponse = curl_exec($ch);
		
	if(!$httpResponse) {
		exit("$methodName_ failed: ".curl_error($ch).'('.curl_errno($ch).')');
	}
		
	$httpResponseAr = explode("&", $httpResponse);
		
	$httpParsedResponseAr = array();
	foreach ($httpResponseAr as $i => $value) {
		$tmpAr = explode("=", $value);
		if(sizeof($tmpAr) > 1) {
			$httpParsedResponseAr[$tmpAr[0]] = $tmpAr[1];
		}
	}
		
	if((sizeof($httpParsedResponseAr) == 0) || 
	   (!array_key_exists('ACK', $httpParsedResponseAr))) {
		exit("Invalid HTTP Response for POST request($nvpreq) to $API_Endpoint.");
	}
		
	return $httpParsedResponseAr;
}
?>