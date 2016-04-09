<?php

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.clickbank.com/rest/1.2/orders/list?startDate=2011-01-01&endDate=2011-02-28");
curl_setopt($ch, CURLOPT_HEADER, false); 
curl_setopt($ch, CURLOPT_GET, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array("Accept: text/csv", "Authorization: DEV-9184A2E27E52F71558069C0013AD7D6078FF:API-926EE03FB2C0927B2BF99E0D1C8FDDE83161"));
$result = curl_exec($ch);
curl_close($ch);
//print "HERE".$result;
//print $result;
$Data = explode ("\n",$result); //print_r($Data);
foreach($Data as $key => $val) {
	if(strlen($val)>0){
		$DataArray = explode (",",$val); //print_r($Data);
		
	}
}
?>
