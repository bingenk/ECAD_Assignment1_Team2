<?php

function PPHttpPost($methodName_, $nvpStr_, $PayPalApiUsername, $PayPalApiPassword, 
                    $PayPalApiSignature, $PayPalMode) {

	$mode = 'sandbox';
	$username = 'sb-47utoi26655415_api1.business.example.com';
	$password 	= 'LBMMVUE59JHSA2ZT'; 		
	$signature = 'ACG-17lDLyRJmfHnqEisXTxHB5O4AKwZhFrwOrR2JwDNRhre0imvPT-4'; 		
	$currencyCode = 'SGD'; 
	$returnURL 	= '';                
	$cancelURL 	= ''; 

    $APIUserName = urlencode($username);
	$APIPassword = urlencode($password);
	$APISignature = urlencode($signature);
			
	if($mode=='sandbox'){
		$mode = '.sandbox';
	}
	else {
		$mode = '';
	}
	
	$API_Endpoint = "https://api-3t".$mode.".paypal.com/nvp";
	$version = urlencode('109.0');
			
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $API_Endpoint);
	curl_setopt($ch, CURLOPT_VERBOSE, 1);			
			
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, 1);	
			
	$nvpreq = "METHOD=$methodName_&VERSION=$version";
	$nvpreq .= "&PWD=$APIPassword&USER=$APIUserName&SIGNATURE=$APISignature$nvpStr_";
			
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