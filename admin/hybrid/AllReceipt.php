<?

class AllReceipt {
	
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
	var $ctransaffiliate="";
	function AllReceipt($ReceiptId=0){
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
			$this->ctransaffiliate = stripslashes($dataRow['ctransaffiliate']);
		}
	}
	function AddReceipt($Name,$Email,$ctransreceipt,$ctransaction,$ctranspaymentmethod,$ctransamount,$ctranspublisher,$cproditem,$ctransaffiliate) {
	    
		$Name = $this->SQLVarchar($Name);
		$Email = $this->SQLVarchar($Email);
		$ctransreceipt = $this->SQLVarchar($ctransreceipt);
		$ctransaction = $this->SQLVarchar($ctransaction);
		$cproditem = $this->SQLVarchar($cproditem);
		$ctransaffiliate = $this->SQLVarchar($ctransaffiliate);
		
		$query =  "INSERT INTO allreceipts  (Name,Email,ctransreceipt,ctransaction,ctranspaymentmethod,ctransamount,ctranspublisher,DateAdded,cproditem,ctransaffiliate) ".
		          " VALUES('$Name','$Email','$ctransreceipt','$ctransaction','$ctranspaymentmethod','$ctransamount','$ctranspublisher',now(),'$cproditem','$ctransaffiliate')";
			
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
		$query =  "UPDATE  allreceipts SET Name='$Name',Email='$Email',ctransreceipt='$ctransreceipt',ctransaction='$ctransaction',ctranspaymentmethod='$ctranspaymentmethod',ctransamount='$ctransamount',ctranspublisher='$ctranspublisher',cproditem='$cproditem' WHERE  receipt_id=$Id";

			
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
		
		
		$query =  "DELETE FROM  allreceipts  WHERE  ctransreceipt = '$ReceiptId'";
				  
		$oDatabase = new database;
		$connection = $oDatabase->Connect();
		//echo $query;			
	 	if (!mysql_select_db($oDatabase->Name(), $connection))
    			$oDatabase->ShowError("Receipt.RemoveReceipt");
	 
		if (!(@ mysql_query ($query, $connection)))
   			$oDatabase->ShowError("Receipt.RemoveReceipt");
	   	return (true);
	}
	function Delete($ReceiptId) {
		
		
		$query =  "DELETE FROM  allreceipts  WHERE  receipt_id = '$ReceiptId'";
				  
		$oDatabase = new database;
		$connection = $oDatabase->Connect();
		//echo $query;			
	 	if (!mysql_select_db($oDatabase->Name(), $connection))
    			$oDatabase->ShowError("Receipt.Delete");
	 
		if (!(@ mysql_query ($query, $connection)))
   			$oDatabase->ShowError("Receipt.Delete");
	   	return (true);
	}
	function getRegistrationsSorted($orderby,$sortby,$offset,$limit,$date1, $date2){
		$wherequery="";
		
        if(strlen($date1)>0 && strlen($date2)>0){
	        $wherequery=" WHERE (R.DateAdded BETWEEN '$date1' AND '$date2')";
        }
		$query = "SELECT R.*,DATE_FORMAT(R.DateAdded,'%d-%m-%Y %k:%i:%S') as FormattedDate".
		        "  FROM allreceipts R   ". 
		        $wherequery ." Order By $orderby $sortby";
		        if($limit > 0){
			  		$query.=' LIMIT '.$offset.','.$limit;      
		        }

		
		//echo ($query);
		
		$oDatabase = new database;
		$connection = $oDatabase->Connect();

	    	if (!mysql_select_db($oDatabase->Name(), $connection))
    			$oDatabase->ShowError("allreceipts.getRegistrationsSorted");
	 
		if (!($result = mysql_query ($query, $connection)))
   			$oDatabase->ShowError("allreceipts.getRegistrationsSorted");
	   	return ($result);
	}
	function get($Id){
		
        
		$query = "SELECT R.*,DATE_FORMAT(R.DateAdded,'%d-%m-%Y %k:%i:%S') as FormattedDate".
		        "  FROM allreceipts R   WHERE receipt_id= $Id";
		        
		       

		
		//echo ($query);
		
		$oDatabase = new database;
		$connection = $oDatabase->Connect();

	    	if (!mysql_select_db($oDatabase->Name(), $connection))
    			$oDatabase->ShowError("allreceipts.getRegistrationsSorted");
	 
		if (!($result = mysql_query ($query, $connection)))
   			$oDatabase->ShowError("allreceipts.getRegistrationsSorted");
	   	return ($result);
	}
	function Lookup($Email){
		
        $Email = $this->SQLVarchar($Email);
		$query = "SELECT R.*".
		        "  FROM allreceipts R   WHERE Email= '$Email'";
	
		//echo ($query);
		
		$oDatabase = new database;
		$connection = $oDatabase->Connect();

	    	if (!mysql_select_db($oDatabase->Name(), $connection))
    			$oDatabase->ShowError("allreceipts.Lookup");
	 
		if (!($result = mysql_query ($query, $connection)))
   			$oDatabase->ShowError("allreceipts.Lookup");
	   	return ($result);
	}
	function LookupDetails($Email,$Name){
		
        $Email = $this->SQLVarchar($Email);
        $Name = $this->SQLVarchar($Name);
        
		$query = "SELECT R.*".
		        "  FROM allreceipts R   WHERE Email= '$Email' AND Name='$Name'";
	
		//echo ($query);
		
		$oDatabase = new database;
		$connection = $oDatabase->Connect();

	    	if (!mysql_select_db($oDatabase->Name(), $connection))
    			$oDatabase->ShowError("allreceipts.LookupDetails");
	 
		if (!($result = mysql_query ($query, $connection)))
   			$oDatabase->ShowError("allreceipts.LookupDetails");
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
		$query =  "UPDATE  allreceipts SET FirstTimeActivation=FirstTimeActivation+1,RecurrentVerification=RecurrentVerification+1 WHERE  Email='$Email'";
		$oDatabase = new database;
		$connection = $oDatabase->Connect();

	    if (!mysql_select_db($oDatabase->Name(), $connection))
    		$oDatabase->ShowError("Receipt.UpdateFirstTime");
	 
		if (!(@ mysql_query ($query, $connection)))
   			$oDatabase->ShowError("Receipt.UpdateFirstTime");
	}
	function UpdateRecurrent($Email) {
		$Email = $this->SQLVarchar($Email);
		$query =  "UPDATE  allreceipts SET RecurrentVerification=RecurrentVerification+1 WHERE  Email='$Email'";
		$oDatabase = new database;
		$connection = $oDatabase->Connect();

	    if (!mysql_select_db($oDatabase->Name(), $connection))
    		$oDatabase->ShowError("Receipt.UpdateRecurrent");
	 
		if (!(@ mysql_query ($query, $connection)))
   			$oDatabase->ShowError("Receipt.UpdateRecurrent");
	}
	function UpdateDate($Id,$date) {
	    
		$query =  "UPDATE  allreceipts SET DateAdded='$date' WHERE  receipt_id=$Id";

			
		//echo $query;
        //return true;
		$oDatabase = new database;
		$connection = $oDatabase->Connect();

	    if (!mysql_select_db($oDatabase->Name(), $connection))
    		$oDatabase->ShowError("Receipt.UpdateDate");
	 
		if (!(@ mysql_query ($query, $connection)))
   			$oDatabase->ShowError("Receipt.UpdateDate");
			
	   	
	}
	function FillFromReceipt($ReceiptId) {
		$ReceiptId = addslashes($ReceiptId);
		if(strlen($ReceiptId)==0) return;
		$query =  "SELECT *  FROM  allreceipts  WHERE  ctransreceipt = '$ReceiptId'";
				  
		$oDatabase = new database;
		$connection = $oDatabase->Connect();
		//echo $query;			
	 	if (!mysql_select_db($oDatabase->Name(), $connection))
    			$oDatabase->ShowError("Receipt.FillFromReceipt");
	 
		if (!($result = mysql_query ($query, $connection)))
   			$oDatabase->ShowError("allreceipts.FillFromReceipt");
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