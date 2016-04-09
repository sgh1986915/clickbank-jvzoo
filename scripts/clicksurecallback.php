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
	$ccustname = "";
	$ccustemail = "";
	$ccustcc = "";
	$ccuststate = "";
	$ctransreceipt = "";
	$cproditem = "";
	$ctransaction = "";
	$ctransaffiliate = "";
	$ctranspublisher = "";
	$cprodtype = "";
	$cprodtitle = "";
	$ctranspaymentmethod = "";
	$ctransamount = "";
	$caffitid = "";
	$cvendthru = "";
	$cbpop = "";
	$transactiondate="";
	$transactionStatus="";
	$LastName="";
	$address1="";
	$address2="";
	$city="";
	$state="";
	$zipCode="";
	$country="";
	$phone="";
	
	$sdebug="";
	if(isset($_REQUEST['debug'])){
		$sdebug = $_REQUEST['debug'];
	}
	
	populatevalues();
	//emaildebugscript();
	//if($sdebug=="true"){
	//	$hashmatch = 1;
	//}else{
	//	$hashmatch = checkHashMatch();
	//}
	//if($hashmatch==1){
		processtransaction();
		
		print "1";
	//}else{
	//	echo "sha match failed";
	//}
	
function populatevalues(){
	global $ccustname;
	global $ccustemail;
	global $ccustcc;
	global $ccuststate;
	global $ctransreceipt;
	global $cproditem;
	global $ctransaction;
	global $ctransaffiliate;
	global $ctranspublisher;
	global $cprodtype;
	global $cprodtitle;
	global $ctranspaymentmethod;
	global $ctransamount;
	global $caffitid;
	global $cvendthru;
	global $cbpop;
	global $PRODITEM;
	global $transactiondate;
	global $transactionStatus;
	global $LastName;
	global $address1;
	global $address2;
	global $city;
	global $state;
	global $zipCode;
	global $country;
	global $phone;
	
	if(isset($_REQUEST['firstName'])){
		$ccustname = $_REQUEST['firstName'];
	}
	if(isset($_REQUEST['email'])){
	$ccustemail = $_REQUEST['email'];
	}
	if(isset($_REQUEST['ccustcc'])){
	$ccustcc = $_REQUEST['ccustcc'];
	}
	if(isset($_REQUEST['ccuststate'])){
	$ccuststate = $_REQUEST['ccuststate'];
	}
	if(isset($_REQUEST['transactionID'])){
	$ctransreceipt = $_REQUEST['transactionID'];
	}
	if(isset($_REQUEST['identifier'])){
	$cproditem = $_REQUEST['identifier'];
	}
	if(isset($_REQUEST['transactionType'])){
	$ctransaction = $_REQUEST['transactionType'];
	}
	if(isset($_REQUEST['ctransaffiliate'])){
	$ctransaffiliate = $_REQUEST['ctransaffiliate'];
	}
	if(isset($_REQUEST['ctranspublisher'])){
	$ctranspublisher = $_REQUEST['ctranspublisher'];
	}
	if(isset($_REQUEST['cprodtype'])){
	$cprodtype = $_REQUEST['cprodtype'];
	}
	if(isset($_REQUEST['cprodtitle'])){
	$cprodtitle = $_REQUEST['cprodtitle'];
	}
	if(isset($_REQUEST['ctranspaymentmethod'])){
	$ctranspaymentmethod = $_REQUEST['ctranspaymentmethod'];
	}
	if(isset($_REQUEST['totalAmount'])){
	$ctransamount = $_REQUEST['totalAmount'];
	}
	if(isset($_REQUEST['caffitid'])){
	$caffitid = $_REQUEST['caffitid'];
	}
	if(isset($_REQUEST['cvendthru'])){
	$cvendthru = $_REQUEST['cvendthru'];
	}
	if(isset($_REQUEST['cverify'])){
	$cbpop = $_REQUEST['cverify'];
	}
	if(isset($_REQUEST['transactiondate'])){
		$transactiondate = $_REQUEST['transactiondate'];
	}
	if(isset($_REQUEST['transactionStatus'])){
	$transactionStatus = $_REQUEST['transactionStatus'];
	}
	if(isset($_REQUEST['lastName'])){
	 $LastName = $_REQUEST['lastName'];
	}
	if(isset($_REQUEST['address1'])){
	 $address1 = $_REQUEST['address1'];
	}
	if(isset($_REQUEST['address2'])){
	 $address2 = $_REQUEST['address2'];
	}
	if(isset($_REQUEST['city'])){
	 $city = $_REQUEST['city'];
	}
	if(isset($_REQUEST['state'])){
	 $state = $_REQUEST['state'];
	}
	if(isset($_REQUEST['zipCode'])){
	 $zipCode = $_REQUEST['zipCode'];
	}
	if(isset($_REQUEST['country'])){
	 $country = $_REQUEST['country'];
	}
	if(isset($_REQUEST['phone'])){
	 $phone = $_REQUEST['phone'];
	}
	
}

Function checkHashMatch(){
	global $ccustname;
	global $ccustemail;
	global $ccustcc ;
	global $ccuststate;
	global $ctransreceipt;
	global $cproditem;
	global $ctransaction;
	global $ctransaffiliate;
	global $ctranspublisher;
	global $cprodtype;
	global $cprodtitle;
	global $ctranspaymentmethod;
	global $ctransamount;
	global $caffitid;
	global $cvendthru;
	global $cbpop;
	global $key;
	global $PRODITEM;
	$xxpop = sha1("$ccustname|$ccustemail|$ccustcc|$ccuststate|$ctransreceipt|$cproditem|$ctransaction|"
		."$ctransaffiliate|$ctranspublisher|$cprodtype|$cprodtitle|$ctranspaymentmethod|$ctransamount|$caffitid|$cvendthru|$key");


    $xxpop=strtoupper(substr($xxpop,0,8));

    if ($cbpop==$xxpop){
	     return 1;
	     }
	else{ 
		return 0;
		}
}

function processtransaction(){
	global $ccustname;
	global $ccustemail;
	global $ccustcc ;
	global $ccuststate;
	global $ctransreceipt;
	global $cproditem;
	global $ctransaction;
	global $ctransaffiliate;
	global $ctranspublisher;
	global $cprodtype;
	global $cprodtitle;
	global $ctranspaymentmethod;
	global $ctransamount;
	global $caffitid;
	global $cvendthru;
	global $cbpop;
	global $PRODITEM;
	global $CANCELPRODITEM;
	global $transactiondate;
	global $transactionStatus;
	global $LastName;
	global $address1;
	global $address2;
	global $city;
	global $state;
	global $zipCode;
	global $country;
	global $phone;
	
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
	$PRODITEM="";
	if( strlen(trim($PRODITEM))==0 || in_array($cproditem,$proditemarray)){
	
		if(strtoupper($ctransaction)=="SALE" || strtoupper($ctransaction)=="BILL" || strtoupper($ctransaction)=="REBILL"  || strtoupper($ctransaction)=="AUTH"){
			//$dupethis = $Receipt->LookupDetails($ccustemail,$ccustname);
			//if($cproditem=="3") 
			//$dupethis=false;
			//if(! $dupethis){
				$Receipt->AddReceipt($ccustname,$ccustemail,$ctransreceipt,$ctransaction,$ctranspaymentmethod,$ctransamount,$ctranspublisher,$cproditem,$transactiondate,	$transactionStatus,	$LastName,	$address1,	$address2,	$city,	$state,	$zipCode,	$country,	$phone );
				$Receipt->LogDetails("A new transaction was logged. The details are: CustName=".$ccustname.", CustEmail=".$ccustemail.", ctransaction=".$ctransaction.", ctransamount=".$ctransamount.", ctransreceipt=".$ctransreceipt);
			//mail('vijay.kuve@gmail.com', 'Callback processed for add receipt', "proditem=".$cproditem." receipt=".$ctransreceipt);
			//}else{
			//	$Receipt->LogDetails("transaction was dupe. The details are: CustName=".$ccustname.", CustEmail=".$ccustemail.", ctransaction=".$ctransaction.", ctransamount=".$ctransamount.", ctransreceipt=".$ctransreceipt);
			//}
			$AllReceipt->AddReceipt($ccustname,$ccustemail,$ctransreceipt,$ctransaction,$ctranspaymentmethod,$ctransamount,$ctranspublisher,$cproditem,$ctransaffiliate);
		}
		if(strtoupper($ctransaction)=="CGBK" ||  strtoupper($ctransaction)=="INSF"){
			$Receipt->RemoveReceipt($ctransreceipt);
			$Receipt->LogDetails("A transaction was removed as a result of chargeback. The details are: CustName=".$ccustname.", CustEmail=".$ccustemail.", ctransaction=".$ctransaction.", ctransamount=".$ctransamount.", ctransreceipt=".$ctransreceipt);
			
		}
		if(strtoupper($ctransaction)=="REFUND" ){
			$Receipt->RemoveEmail($ccustemail);
			$Receipt->LogDetails("All transactions were removed as a result of refund. The details are: CustName=".$ccustname.", CustEmail=".$ccustemail.", ctransaction=".$ctransaction.", ctransamount=".$ctransamount.", ctransreceipt=".$ctransreceipt);
			
		}
		if( $ctransaction=="CANCEL-REBILL" ){
			if( strlen(trim($CANCELPRODITEM))>0 && in_array($cproditem,$cancelproditemarray)){
				$Receipt->RemoveReceipt($ctransreceipt);
				$Receipt->LogDetails("A transaction was removed as a result of refund. The details are: CustName=".$ccustname.", CustEmail=".$ccustemail.", ctransaction=".$ctransaction.", ctransamount=".$ctransamount.", ctransreceipt=".$ctransreceipt);
			}
		}
		$Receipt->LogDetails("DEBUG transaction.The details are: CustName=".$ccustname.", CustEmail=".$ccustemail.", ctransaction=".$ctransaction.", ctransreceipt=".$ctransreceipt.",crpoditem=".$cproditem);
	}
}

function emaildebugscript(){
	$reqvals="";
	foreach ( $_REQUEST as $init_key => $init_value ) {
		$reqvals.=$init_key ."=".  $init_value ."\n";
	}
	//print $reqvals;
	//mail('vijay.kuve@gmail.com', 'Callback processed on pmverify', $reqvals);
}


	
	
?>
