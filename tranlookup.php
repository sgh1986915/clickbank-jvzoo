<?php
include "Constants.php";
include "db.php";
include "Receipt.php";
include_once "database.php";


$sEmail="";$smode="";
    $returnvalue="false";
if(isset($_GET['Email'])){
	$sEmail = $_GET["Email"];
}
if(isset($_GET['mode'])){
	$smode = $_GET["mode"];
}
if(strlen($sEmail)==0){
	print $returnvalue;
	exit;
}

$Receipt = new Receipt;
$Result = $Receipt->Lookup($sEmail);
if (mysql_affected_rows()){
	$Row = mysql_fetch_assoc($Result);
	if(is_array($Row)){
		$returnvalue="true";
		if($smode=="0"){
			$Receipt->UpdateRecurrent($sEmail);
		}
		if($smode=="1"){
			$Receipt->UpdateFirstTime($sEmail);
		}
	}
	mysql_free_result($Result);
}

print $returnvalue;
?>