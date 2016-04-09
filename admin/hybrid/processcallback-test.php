<?php
include_once "Constants.php";
include_once "db.php";
include_once "database.php";
include_once "Receipt.php";
include_once "Settings.php";

	

		//BackupDatabase();
		$Settings = new Settings;
$Receipt = new Receipt();
$Result = $Settings->get("Secret");
$secretrow = mysql_fetch_assoc($Result);
mysql_free_result($Result);

$Result = $Settings->get("Proditem");
$proditemrow = mysql_fetch_assoc($Result);
mysql_free_result($Result);

$Result = $Settings->get("CancelProditem");
$cancelproditemrow = mysql_fetch_assoc($Result);
mysql_free_result($Result);

$CANCELPRODITEM = $cancelproditemrow['Value'];

if( strlen(trim($CANCELPRODITEM))>0 ){
		$cancelproditemarray = explode(",",$CANCELPRODITEM);
	}
	$ctransaction="CANCEL-REBILL";
	$cproditem="1";
	$ctransreceipt="12345";
	if( $ctransaction=="CANCEL-REBILL" ){
			if( strlen(trim($CANCELPRODITEM))>0 && in_array($cproditem,$cancelproditemarray)){
				$Receipt->RemoveReceipt($ctransreceipt);print "removing".$ctransreceipt;
			}
		}
		

	
?>
