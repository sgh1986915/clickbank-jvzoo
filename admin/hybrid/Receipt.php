<?

class Receipt {
	
	var $Name="";							
	var $Email="";
	var $ctransreceipt="";
	var $ctransaction="";
	var $ctranspaymentmethod="";
	var $ctransamount="";
	var $receipt_id=0;
	var $ctranspublisher="";
	var $cproditem="";
	var $FolderName="";
	function Receipt($ReceiptId=0){
		if($ReceiptId==0) return;
		$result = $this->get($ReceiptId);
		
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
	function AddReceipt($Name,$Email,$ctransreceipt,$ctransaction,$ctranspaymentmethod,$ctransamount,$ctranspublisher,$cproditem) {
	    
		$Name = $this->SQLVarchar($Name);
		$Email = $this->SQLVarchar($Email);
		$ctransreceipt = $this->SQLVarchar($ctransreceipt);
		$ctransaction = $this->SQLVarchar($ctransaction);
		$cproditem = $this->SQLVarchar($cproditem);
		
		
		$query =  "INSERT INTO receipts  (Name,Email,ctransreceipt,ctransaction,ctranspaymentmethod,ctransamount,ctranspublisher,DateAdded,cproditem) ".
		          " VALUES('$Name','$Email','$ctransreceipt','$ctransaction','$ctranspaymentmethod','$ctransamount','$ctranspublisher',now(),'$cproditem')";
			
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
	function UpdateReceipt($Id,$Name,$Email,$ctransreceipt,$ctransaction,$ctranspaymentmethod,$ctransamount,$ctranspublisher,$cproditem) {
	    
		$Name = $this->SQLVarchar($Name);
		$Email = $this->SQLVarchar($Email);
		$ctransreceipt = $this->SQLVarchar($ctransreceipt);
		$ctransaction = $this->SQLVarchar($ctransaction);
		$cproditem = $this->SQLVarchar($cproditem);
		$query =  "UPDATE  receipts SET Name='$Name',Email='$Email',ctransreceipt='$ctransreceipt',ctransaction='$ctransaction',ctranspaymentmethod='$ctranspaymentmethod',ctransamount='$ctransamount',ctranspublisher='$ctranspublisher',cproditem='$cproditem' WHERE  receipt_id=$Id";

			
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
		
		$oDatabase = new database;
		$connection = $oDatabase->Connect();
		if (!mysql_select_db($oDatabase->Name(), $connection))
    			$oDatabase->ShowError("Receipt.RemoveReceipt");
    			
    	
    			
		$query =  "INSERT INTO receipts_del(Name,Email,ctransreceipt,ctransaction,ctranspaymentmethod,ctransamount,ctranspublisher,cproditem,FolderName,DateAdded)";
		$query.=" SELECT Name,Email,ctransreceipt,ctransaction,ctranspaymentmethod,ctransamount,ctranspublisher,cproditem,FolderName,now() FROM  receipts  WHERE  ctransreceipt = '$ReceiptId'";
		mysql_query ($query, $connection);
		
		$query =  "DELETE FROM  receipts  WHERE  ctransreceipt = '$ReceiptId'";
		//echo $query;			
	 	
	 
		if (!(@ mysql_query ($query, $connection)))
   			$oDatabase->ShowError("Receipt.RemoveReceipt");
	   	return (true);
	}
	function RemoveEmail($Email) {
		$oDatabase = new database;
		$connection = $oDatabase->Connect();
		
	 	if (!mysql_select_db($oDatabase->Name(), $connection))
    			$oDatabase->ShowError("Receipt.RemoveEmail");
	 
    			
		$query =  "INSERT INTO receipts_del(Name,Email,ctransreceipt,ctransaction,ctranspaymentmethod,ctransamount,ctranspublisher,cproditem,FolderName,DateAdded)";
		$query.=" SELECT Name,Email,ctransreceipt,ctransaction,ctranspaymentmethod,ctransamount,ctranspublisher,cproditem,FolderName,now() FROM  receipts  WHERE  Email = '$Email'";
		mysql_query ($query, $connection);
		
		
		$query =  "DELETE FROM  receipts  WHERE  Email = '$Email'";
				  
		
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
	        $wherequery=" WHERE (R.Name LIKE '%$searchterm%' OR R.Email LIKE '%$searchterm%' OR R.ctransreceipt LIKE '%$searchterm%' OR R.cproditem LIKE '%$searchterm%')";
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
}	

?>