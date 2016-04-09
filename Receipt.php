<?

class Receipt {
	
	var $FirstName="";							
	var $LastName="";							
	var $Email="";
	var $notificationtype="";
	var $orderid="";
	var $productid="";
	var $phone="";
	var $receipt_id=0;
	var $amount="";
	var $saledate="";
	var $address="";
	var $city="";
	var $state="";
	
	var $zipCode="";
	var $country="";
	
	function Receipt($ReceiptId=0){
		if($ReceiptId==0) return;
		$result = $this->get($ReceiptId);
		
		if(!$result) return;
		if (mysql_num_rows($result) != 0) {
			$dataRow = mysql_fetch_array($result, MYSQL_ASSOC);
			mysql_free_result ($result);
			$this->receipt_id=stripslashes($dataRow['receipt_id']);
			$this->FirstName=stripslashes($dataRow['FirstName']);
			$this->LastName=stripslashes($dataRow['LastName']);
			$this->Email=stripslashes($dataRow['Email']);
			$this->notificationtype=stripslashes($dataRow['notificationtype']);
			$this->orderid=stripslashes($dataRow['orderid']);
			$this->productid=stripslashes($dataRow['productid']);
			$this->phone=stripslashes($dataRow['phone']);
			$this->amount=stripslashes($dataRow['amount']);
			$this->saledate=stripslashes($dataRow['saledate']);
			$this->address=stripslashes($dataRow['address']);
			
			$this->city=stripslashes($dataRow['city']);
			$this->state=stripslashes($dataRow['state']);
			$this->zipCode=stripslashes($dataRow['zipCode']);
			$this->country=stripslashes($dataRow['country']);
			
		}
	}
	function AddReceipt($FirstName,							
	$LastName,							
	$Email,
	$notificationtype,
	$orderid,
	$productid,
	$phone,
	$amount,
	$saledate,
	$address,
	$city,
	$state,
	$zipCode,
	$country
	) {
	    
		$FirstName = $this->SQLVarchar($FirstName);
		$LastName = $this->SQLVarchar($LastName);
		$Email = $this->SQLVarchar($Email);
		$phone = $this->SQLVarchar($phone);
		$amount = $this->SQLVarchar($amount);
		$saledate = $this->SQLVarchar($saledate);
		$address = $this->SQLVarchar($address);
		$city = $this->SQLVarchar($city);
		$state = $this->SQLVarchar($state);
		$city = $this->SQLVarchar($city);
		$state = $this->SQLVarchar($state);
		$zipCode = $this->SQLVarchar($zipCode);
		$country = $this->SQLVarchar($country);
		
		
		
		$query =  "INSERT INTO receipts  (FirstName,							
	LastName,							
	Email,
	notificationtype,
	orderid,
	productid,
	phone,
	amount,
	saledate,
	address,
	city,
	state,
	zipCode,
	country,DateAdded) ".
		          " VALUES('$FirstName','$LastName','$Email','$notificationtype','$orderid','$productid','$phone','$amount','$saledate','$address','$city',	'$state','$zipCode',	'$country' ,now())";
			
		//echo $query;
        //return true;
		$oDatabase = new database;
		$connection = $oDatabase->Connect();

	    if (!mysql_select_db($oDatabase->Name(), $connection))
    		$oDatabase->ShowError("Receipt.AddReceipt");
	 
		if (!(@ mysql_query ($query, $connection)))
   			$oDatabase->ShowError("Receipt.AddReceipt");
			
	   	return (mysql_insert_id());
	}
	function UpdateReceipt($Id,$Name,$Email,$amount,$productid) {
	    
		$Name = $this->SQLVarchar($Name);
		$Email = $this->SQLVarchar($Email);
		$productid = $this->SQLVarchar($productid);
		$query =  "UPDATE  receipts SET FirstName='$Name',Email='$Email',amount='$amount',productid='$productid' WHERE  receipt_id=$Id";

			
		//echo $query;
        //return true;
		$oDatabase = new database;
		$connection = $oDatabase->Connect();

	    if (!mysql_select_db($oDatabase->Name(), $connection))
    		$oDatabase->ShowError("Receipt.UpdateReceipt");
	 
		if (!(@ mysql_query ($query, $connection)))
   			$oDatabase->ShowError("Receipt.UpdateReceipt");
			
	   	
	}
	
	function RemoveReceipt($ReceiptId) {
		
		
		$query =  "DELETE FROM  receipts  WHERE  orderid = '$ReceiptId'";
				  
		$oDatabase = new database;
		$connection = $oDatabase->Connect();
		//echo $query;			
	 	if (!mysql_select_db($oDatabase->Name(), $connection))
    			$oDatabase->ShowError("Receipt.RemoveReceipt");
	 
		if (!(@ mysql_query ($query, $connection)))
   			$oDatabase->ShowError("Receipt.RemoveReceipt");
	   	return (true);
	}
	function RemoveEmail($Email) {
		
		
		$query =  "DELETE FROM  receipts  WHERE  Email = '$Email'";
				  
		$oDatabase = new database;
		$connection = $oDatabase->Connect();
		//echo $query;			
	 	if (!mysql_select_db($oDatabase->Name(), $connection))
    			$oDatabase->ShowError("Receipt.RemoveEmail");
	 
		if (!(@ mysql_query ($query, $connection)))
   			$oDatabase->ShowError("Receipt.RemoveEmail");
	   	return (true);
	}
	function Delete($ReceiptId) {
		
		
		$query =  "DELETE FROM  receipts  WHERE  receipt_id = '$ReceiptId'";
				  
		$oDatabase = new database;
		$connection = $oDatabase->Connect();
		//echo $query;			
	 	if (!mysql_select_db($oDatabase->Name(), $connection))
    			$oDatabase->ShowError("Receipt.Delete");
	 
		if (!(@ mysql_query ($query, $connection)))
   			$oDatabase->ShowError("Receipt.Delete");
	   	return (true);
	}
	function getRegistrationsSorted($orderby,$sortby,$offset,$limit,$searchterm){
		$wherequery="";
		$searchterm = $this->SQLVarchar($searchterm);
        if(strlen($searchterm)>0){
	        $wherequery=" WHERE (R.FirstName LIKE '%$searchterm%' OR R.Email LIKE '%$searchterm%' OR R.orderid LIKE '%$searchterm%' OR R.productid LIKE '%$searchterm%')";
        }
		$query = "SELECT R.*,DATE_FORMAT(R.DateAdded,'%d-%m-%Y %k:%i:%S') as FormattedDate".
		        "  FROM receipts R   ". 
		        $wherequery ." Order By $orderby $sortby";
		        if($limit > 0){
			  		$query.=' LIMIT '.$offset.','.$limit;      
		        }

		
		//echo ($query);
		
		$oDatabase = new database;
		$connection = $oDatabase->Connect();

	    	if (!mysql_select_db($oDatabase->Name(), $connection))
    			$oDatabase->ShowError("receipts.getRegistrationsSorted");
	 
		if (!($result = mysql_query ($query, $connection)))
   			$oDatabase->ShowError("receipts.getRegistrationsSorted");
	   	return ($result);
	}
	function get($Id){
		
        
		$query = "SELECT R.*,DATE_FORMAT(R.DateAdded,'%d-%m-%Y %k:%i:%S') as FormattedDate".
		        "  FROM receipts R   WHERE receipt_id= $Id";
		        
		       

		
		//echo ($query);
		
		$oDatabase = new database;
		$connection = $oDatabase->Connect();

	    	if (!mysql_select_db($oDatabase->Name(), $connection))
    			$oDatabase->ShowError("receipts.getRegistrationsSorted");
	 
		if (!($result = mysql_query ($query, $connection)))
   			$oDatabase->ShowError("receipts.getRegistrationsSorted");
	   	return ($result);
	}
	function Lookup($Email){
		
        $Email = $this->SQLVarchar($Email);
		$query = "SELECT R.*".
		        "  FROM receipts R   WHERE Email= '$Email'";
	
		//echo ($query);
		
		$oDatabase = new database;
		$connection = $oDatabase->Connect();

	    	if (!mysql_select_db($oDatabase->Name(), $connection))
    			$oDatabase->ShowError("receipts.Lookup");
	 
		if (!($result = mysql_query ($query, $connection)))
   			$oDatabase->ShowError("receipts.Lookup");
	   	return ($result);
	}
	function LookupDetails($Email,$Name){
		
        $Email = $this->SQLVarchar($Email);
        $Name = $this->SQLVarchar($Name);
        
		$query = "SELECT R.*".
		        "  FROM receipts R   WHERE Email= '$Email' AND Name='$Name'";
	
		//echo ($query);
		
		$oDatabase = new database;
		$connection = $oDatabase->Connect();

	    	if (!mysql_select_db($oDatabase->Name(), $connection))
    			$oDatabase->ShowError("receipts.LookupDetails");
	 
		if (!($result = mysql_query ($query, $connection)))
   			$oDatabase->ShowError("receipts.LookupDetails");
	   	return mysql_num_rows($result) > 0 ;
	}
	function LookupDetails1($Email,$Name,$cproditem){
		
        $Email = $this->SQLVarchar($Email);
        $Name = $this->SQLVarchar($Name);
        
		$query = "SELECT R.*".
		        "  FROM receipts R   WHERE Email= '$Email' AND Name='$Name' AND cproditem='$cproditem'";
	
		//echo ($query);
		
		$oDatabase = new database;
		$connection = $oDatabase->Connect();

	    	if (!mysql_select_db($oDatabase->Name(), $connection))
    			$oDatabase->ShowError("receipts.LookupDetails");
	 
		if (!($result = mysql_query ($query, $connection)))
   			$oDatabase->ShowError("receipts.LookupDetails");
	   	return mysql_num_rows($result) > 0 ;
	}
	function LookupDetails2($Email,$cproditem){
		
        $Email = $this->SQLVarchar($Email);
        
        
		$query = "SELECT R.*".
		        "  FROM receipts R   WHERE Email= '$Email'  AND productid='$cproditem'";
	
		//echo ($query);
		
		$oDatabase = new database;
		$connection = $oDatabase->Connect();

	    	if (!mysql_select_db($oDatabase->Name(), $connection))
    			$oDatabase->ShowError("receipts.LookupDetails");
	 
		if (!($result = mysql_query ($query, $connection)))
   			$oDatabase->ShowError("receipts.LookupDetails");
	   	return mysql_num_rows($result) > 0 ;
	}
	function LogDetails($Logdesc){
			$Logdesc = $this->SQLVarchar($Logdesc);
		$query =  "INSERT INTO logs  (logdesc,logdate) ".
		          " VALUES('$Logdesc',now())";
		$oDatabase = new database;
		$connection = $oDatabase->Connect();

	    if (!mysql_select_db($oDatabase->Name(), $connection))
    		$oDatabase->ShowError("Receipt.LogDetails");
	 
		if (!(@ mysql_query ($query, $connection)))
   			$oDatabase->ShowError("Receipt.LogDetails");
			
	   	
	}
	
	function SQLVarchar($_pVartext){
		return str_replace("'","''",$_pVartext) ;
	}
	function UpdateFirstTime($Email) {
		$Email = $this->SQLVarchar($Email);
		$query =  "UPDATE  receipts SET FirstTimeActivation=FirstTimeActivation+1,RecurrentVerification=RecurrentVerification+1 WHERE  Email='$Email'";
		$oDatabase = new database;
		$connection = $oDatabase->Connect();

	    if (!mysql_select_db($oDatabase->Name(), $connection))
    		$oDatabase->ShowError("Receipt.UpdateFirstTime");
	 
		if (!(@ mysql_query ($query, $connection)))
   			$oDatabase->ShowError("Receipt.UpdateFirstTime");
	}
	function UpdateRecurrent($Email) {
		$Email = $this->SQLVarchar($Email);
		$query =  "UPDATE  receipts SET RecurrentVerification=RecurrentVerification+1 WHERE  Email='$Email'";
		$oDatabase = new database;
		$connection = $oDatabase->Connect();

	    if (!mysql_select_db($oDatabase->Name(), $connection))
    		$oDatabase->ShowError("Receipt.UpdateRecurrent");
	 
		if (!(@ mysql_query ($query, $connection)))
   			$oDatabase->ShowError("Receipt.UpdateRecurrent");
	}
	function FillFromReceipt($ReceiptId) {
		$ReceiptId = addslashes($ReceiptId);
		if(strlen($ReceiptId)==0) return;
		$query =  "SELECT *  FROM  receipts  WHERE  ctransreceipt = '$ReceiptId'";
				  
		$oDatabase = new database;
		$connection = $oDatabase->Connect();
		//echo $query;			
	 	if (!mysql_select_db($oDatabase->Name(), $connection))
    			$oDatabase->ShowError("Receipt.FillFromReceipt");
	 
		if (!($result = mysql_query ($query, $connection)))
   			$oDatabase->ShowError("receipts.FillFromReceipt");
	   	if(!$result) return;
		if (mysql_num_rows($result) != 0) {
			$dataRow = mysql_fetch_array($result, MYSQL_ASSOC);
			mysql_free_result ($result);
			$this->receipt_id=stripslashes($dataRow['receipt_id']);
			$this->Name=stripslashes($dataRow['Name']);
			$this->Email=stripslashes($dataRow['Email']);
			$this->ctransreceipt=stripslashes($dataRow['ctransreceipt']);
			$this->ctransaction=stripslashes($dataRow['ctransaction']);
			$this->ctranspaymentmethod=stripslashes($dataRow['ctranspaymentmethod']);
			$this->ctransamount=stripslashes($dataRow['ctransamount']);
			$this->ctranspublisher=stripslashes($dataRow['ctranspublisher']);
			$this->cproditem=stripslashes($dataRow['cproditem']);
			$this->FolderName=stripslashes($dataRow['FolderName']);
		}
	}
	
	function GetDownloadLinks($Email){
		
        $Email = $this->SQLVarchar($Email);
        
        
		$query = "SELECT P.*".
		        "  FROM Product P INNER JOIN receipts R  ON P.ItemNumber=R.productid WHERE R.Email= '$Email'";
	
		//echo ($query);
		
		$oDatabase = new database;
		$connection = $oDatabase->Connect();

	    	if (!mysql_select_db($oDatabase->Name(), $connection))
    			$oDatabase->ShowError("receipts.GetDownloadLinks");
	 
		if (!($result = mysql_query ($query, $connection)))
   			$oDatabase->ShowError("receipts.GetDownloadLinks");
	   	return $result ;
	}
	function getRefunds($orderby){
		$query = "SELECT R.*,DATE_FORMAT(R.DateAdded,'%d-%m-%Y %k:%i:%S') as FormattedDate".
		        "  FROM receipts_del R   ". 
		        $query .=" Order By $orderby";
		        
		//echo ($query);
		
		$oDatabase = new database;
		$connection = $oDatabase->Connect();

	    	if (!mysql_select_db($oDatabase->Name(), $connection))
    			$oDatabase->ShowError("receipts.getRefunds");
	 
		if (!($result = mysql_query ($query, $connection)))
   			$oDatabase->ShowError("receipts.getRefunds");
	   	return ($result);
	}
	function AddReceiptDel($FirstName,							
	$LastName,							
	$Email,
	$notificationtype,
	$orderid,
	$productid,
	$phone,
	$amount,
	$saledate,
	$address,
	$city,
	$state,
	$zipCode,
	$country
	) {
	    
		$FirstName = $this->SQLVarchar($FirstName);
		$LastName = $this->SQLVarchar($LastName);
		$Email = $this->SQLVarchar($Email);
		$phone = $this->SQLVarchar($phone);
		$amount = $this->SQLVarchar($amount);
		$saledate = $this->SQLVarchar($saledate);
		$address = $this->SQLVarchar($address);
		$city = $this->SQLVarchar($city);
		$state = $this->SQLVarchar($state);
		$city = $this->SQLVarchar($city);
		$state = $this->SQLVarchar($state);
		$zipCode = $this->SQLVarchar($zipCode);
		$country = $this->SQLVarchar($country);
		
		
		
		$query =  "INSERT INTO receipts_del  (FirstName,							
	LastName,							
	Email,
	notificationtype,
	orderid,
	productid,
	phone,
	amount,
	saledate,
	address,
	city,
	state,
	zipCode,
	country,DateAdded) ".
		          " VALUES('$FirstName','$LastName','$Email','$notificationtype','$orderid','$productid','$phone','$amount','$saledate','$address','$city',	'$state','$zipCode',	'$country' ,now())";
			
		//echo $query;
        //return true;
		$oDatabase = new database;
		$connection = $oDatabase->Connect();

	    if (!mysql_select_db($oDatabase->Name(), $connection))
    		$oDatabase->ShowError("Receipt.AddReceiptDel");
	 
		if (!(@ mysql_query ($query, $connection)))
   			$oDatabase->ShowError("Receipt.AddReceiptDel");
			
	   	return (mysql_insert_id());
	}
}	

?>