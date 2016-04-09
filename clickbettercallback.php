<?php
include_once "Constants.php";
include_once "db.php";
include_once "database.php";
include_once "Receipt.php";
include_once "AllReceipt.php";
include_once "Settings.php";


$Settings = new Settings;

$Result = $Settings->get("Secret");
$secretrow = mysql_fetch_assoc($Result);
mysql_free_result($Result);

$Result = $Settings->get("Proditem");
$proditemrow = mysql_fetch_assoc($Result);
mysql_free_result($Result);

$Result = $Settings->get("CancelProditem");
$cancelproditemrow = mysql_fetch_assoc($Result);
mysql_free_result($Result);


$SECRETKEY=$secretrow['Value'];

$PRODITEM = $proditemrow['Value'];

$CANCELPRODITEM = $cancelproditemrow['Value'];

	$key=$SECRETKEY;
	$FirstName="";							
	$LastName="";							
	$Email="";
	$notificationtype="";
	$orderid="";
	$productid="";
	$phone="";
	$receipt_id=0;
	$amount="";
	$saledate="";
	$address="";
	$city="";
	$state="";
	
	$zipCode="";
	$country="";
	$sdebug="";
	if(isset($_REQUEST['debug'])){
		$sdebug = $_REQUEST['debug'];
	}
	
	populatevalues();
	emaildebugscript();
		processtransaction();
		
		print "1";
	
function populatevalues(){
	global $FirstName;							
	global $LastName;							
	global $Email;
	global $notificationtype;
	global $orderid;
	global $productid;
	global $phone;
	global $receipt_id;
	global $amount;
	global $saledate;
	global $address;
	global $city;
	global $state;
	
	global $zipCode;
	global $country;
	if(isset($_POST['firstName'])){
		$FirstName = $_POST['firstName'];
	}
	if(isset($_POST['lastName'])){
	$LastName = $_POST['lastName'];
	}
	if(isset($_POST['customeremail'])){
	$Email = $_POST['customeremail'];
	}
	if(isset($_POST['orderid'])){
	$orderid = $_POST['orderid'];
	}
	
	if(isset($_POST['type'])){
	$notificationtype = $_POST['type'];
	}
	if(isset($_POST['productid'])){
	$productid = $_POST['productid'];
	}
	if(isset($_POST['phone'])){
	$phone = $_POST['phone'];
	}
	if(isset($_POST['amount'])){
	$amount = $_POST['amount'];
	}
	if(isset($_POST['saledate'])){
	$saledate = $_POST['saledate'];
	}
	if(isset($_POST['address'])){
	$address = $_POST['address'];
	}
	if(isset($_POST['city'])){
	$city = $_POST['city'];
	}
	if(isset($_POST['state'])){
	$state = $_POST['state'];
	}
	if(isset($_POST['zipcode'])){
	$zipCode = $_POST['zipcode'];
	}
	if(isset($_POST['country'])){
	$country = $_POST['country'];
	}
	
}

function processtransaction(){
	global $FirstName;							
	global $LastName;							
	global $Email;
	global $notificationtype;
	global $orderid;
	global $productid;
	global $phone;
	global $receipt_id;
	global $amount;
	global $saledate;
	global $address;
	global $city;
	global $state;
	
	global $zipCode;
	global $country;
	
	global $PRODITEM;
	global $CANCELPRODITEM;
	
	$Receipt = new Receipt();
	$AllReceipt = new AllReceipt();
	$currentdate = date("m-d-Y");
	$proditemarray = array();
	$cancelproditemarray = array();
	if( strlen(trim($PRODITEM))>0 ){
		$proditemarray = explode(",",$PRODITEM);
	}
	
	if( strlen(trim($CANCELPRODITEM))>0 ){
		$cancelproditemarray = explode(",",$CANCELPRODITEM);
	}
	//TODO: uncomment if you want to use this
	$PRODITEM="";
	if( strlen(trim($PRODITEM))==0 || in_array($cproditem,$proditemarray)){
	
		if(strtoupper($notificationtype)=="SALE" || strtoupper($notificationtype)=="BILL" || strtoupper($notificationtype)=="REBILL"  || strtoupper($notificationtype)=="AUTH"){
				
				$Receipt->AddReceipt($FirstName,$LastName,$Email,$notificationtype,$orderid,$productid,$phone,$amount,$saledate,$address,$city,	$state,		$zipCode,	$country  );
				$Receipt->LogDetails("A new transaction was logged. The details are: CustName=".$FirstName.", CustEmail=".$Email.", ctransaction=".$orderid.", ctransamount=".$amount);
			$AllReceipt->AddReceipt($FirstName,$LastName,$Email,$notificationtype,$orderid,$productid,$phone,$amount,$saledate,$address,$city,	$state,		$zipCode,	$country );
		}
		if(strtoupper($notificationtype)=="CGBK" ||  strtoupper($notificationtype)=="INSF"){
			$Receipt->RemoveReceipt($orderid);
			$Receipt->LogDetails("A transaction was removed as a result of chargeback. The details are: CustName=".$FirstName.", CustEmail=".$Email.",  ctransreceipt=".$orderid);
			
		}
		if(strtoupper($notificationtype)=="REFUND" ){
			$Receipt->RemoveEmail($Email);
			$Receipt->AddReceiptDel($FirstName,$LastName,$Email,$notificationtype,$orderid,$productid,$phone,$amount,$saledate,$address,$city,	$state,	$zipCode,	$country  );
			$Receipt->LogDetails("All transactions were removed as a result of refund. The details are: CustName=".$FirstName.", CustEmail=".$Email.",  ctransreceipt=".$orderid);
			
		}
		if( $notificationtype=="CANCEL-REBILL" ){
			if( strlen(trim($CANCELPRODITEM))>0 && in_array($cproditem,$cancelproditemarray)){
				$Receipt->RemoveReceipt($orderid);
				$Receipt->LogDetails("A transaction was removed as a result of refund. The details are: CustName=".$ccustname.", CustEmail=".$ccustemail.", ctransaction=".$ctransaction.", ctransamount=".$ctransamount.", ctransreceipt=".$ctransreceipt);
			}
		}
		$Receipt->LogDetails("DEBUG transaction.The details are: CustName=".$FirstName.", CustEmail=".$Email." ctransreceipt=".$orderid.",crpoditem=".$productid);
	}
}

function emaildebugscript(){
	$reqvals="";
	foreach ( $_REQUEST as $init_key => $init_value ) {
		$reqvals.=$init_key ."=".  $init_value ."\n";
	}
	global $ccustemail;
	global $ctransaction;
	$Receipt = new Receipt();
	$Receipt->LogDetails("LOGGING.The details are:  CustEmail=".$ccustemail.", ctransaction=".$ctransaction);
	//print $reqvals;
	mail('vijay.kuve@gmail.com', 'Callback processed on pmverify', $reqvals);
}


	
	
?>
