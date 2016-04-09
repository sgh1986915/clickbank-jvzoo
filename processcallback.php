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
	
	$sdebug="";
	if(isset($_REQUEST['debug'])){
		$sdebug = $_REQUEST['debug'];
	}
	
	populatevalues();
	emaildebugscript();
	if($sdebug=="true"){
		$hashmatch = 1;
	}else{
		$hashmatch = checkHashMatch();
	}
	if($hashmatch==1){
		processtransaction();
		
		print "1";
	}else{
		echo "sha match failed";
	}
	
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
	
	if(isset($_REQUEST['ccustname'])){
		$ccustname = $_REQUEST['ccustname'];
	}
	if(isset($_REQUEST['ccustemail'])){
	$ccustemail = $_REQUEST['ccustemail'];
	}
	if(isset($_REQUEST['ccustcc'])){
	$ccustcc = $_REQUEST['ccustcc'];
	}
	if(isset($_REQUEST['ccuststate'])){
	$ccuststate = $_REQUEST['ccuststate'];
	}
	if(isset($_REQUEST['ctransreceipt'])){
	$ctransreceipt = $_REQUEST['ctransreceipt'];
	}
	if(isset($_REQUEST['cproditem'])){
	$cproditem = $_REQUEST['cproditem'];
	}
	if(isset($_REQUEST['ctransaction'])){
	$ctransaction = $_REQUEST['ctransaction'];
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
	if(isset($_REQUEST['ctransamount'])){
	$ctransamount = $_REQUEST['ctransamount'];
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
	
	if( strlen(trim($PRODITEM))==0 || in_array($cproditem,$proditemarray)){
	
		if($ctransaction=="SALE" || $ctransaction=="BILL" || strtoupper($ctransaction)=="REBILL" ){
			$dupethis = $Receipt->LookupDetails($ccustemail,$ccustname);
			//if($cproditem=="3") 
			$dupethis=false;
			if(! $dupethis){
				$Receipt->AddReceipt($ccustname,$ccustemail,$ctransreceipt,$ctransaction,$ctranspaymentmethod,$ctransamount,$ctranspublisher,$cproditem);
				$Receipt->LogDetails("A new transaction was logged. The details are: CustName=".$ccustname.", CustEmail=".$ccustemail.", ctransaction=".$ctransaction.", ctransamount=".$ctransamount.", ctransreceipt=".$ctransreceipt);
			//mail('vijay.kuve@gmail.com', 'Callback processed for add receipt', "proditem=".$cproditem." receipt=".$ctransreceipt);
			}else{
				$Receipt->LogDetails("transaction was dupe. The details are: CustName=".$ccustname.", CustEmail=".$ccustemail.", ctransaction=".$ctransaction.", ctransamount=".$ctransamount.", ctransreceipt=".$ctransreceipt);
			}
			$AllReceipt->AddReceipt($ccustname,$ccustemail,$ctransreceipt,$ctransaction,$ctranspaymentmethod,$ctransamount,$ctranspublisher,$cproditem,$ctransaffiliate);
		}
		if($ctransaction=="CGBK" ||  $ctransaction=="INSF"){
			$Receipt->RemoveReceipt($ctransreceipt);
			$Receipt->LogDetails("A transaction was removed as a result of chargeback. The details are: CustName=".$ccustname.", CustEmail=".$ccustemail.", ctransaction=".$ctransaction.", ctransamount=".$ctransamount.", ctransreceipt=".$ctransreceipt);
			
		}
		if($ctransaction=="RFND" ){
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
