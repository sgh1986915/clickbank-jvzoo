<?

class Product {
	var $ProductId=0;
	var $Name="";							
	var $ItemNumber="";
	var $URL="";
	function Product($ProductId=0){
		if($ProductId==0) return;
		$result = $this->get($ProductId);
		
		if(!$result) return;
		if (mysql_num_rows($result) != 0) {
			$dataRow = mysql_fetch_array($result, MYSQL_ASSOC);
			mysql_free_result ($result);
			$this->ProductId=stripslashes($dataRow['ProductId']);
			$this->Name=stripslashes($dataRow['Name']);
			$this->ItemNumber=stripslashes($dataRow['ItemNumber']);
			$this->URL=stripslashes($dataRow['URL']);
			
		}
	}
	function Add($Name,$ItemNumber,$URL) {
	    
		$Name = $this->SQLVarchar($Name);
		$ItemNumber = $this->SQLVarchar($ItemNumber);
		$URL = $this->SQLVarchar($URL);
		
		$query =  "INSERT INTO Product  (Name,ItemNumber,URL,DateAdded) ".
		          " VALUES('$Name','$ItemNumber','$URL',now())";
			
		//echo $query;
        //return true;
		$oDatabase = new database;
		$connection = $oDatabase->Connect();

	    if (!mysql_select_db($oDatabase->Name(), $connection))
    		$oDatabase->ShowError("Product.Add");
	 
		if (!(@ mysql_query ($query, $connection)))
   			$oDatabase->ShowError("Product.Add");
			
	   	return (mysql_insert_id());
	}
	function Update($Id,$Name,$ItemNumber,$URL) {
	    
		$Name = $this->SQLVarchar($Name);
		$ItemNumber = $this->SQLVarchar($ItemNumber);
		$URL = $this->SQLVarchar($URL);
		$query =  "UPDATE  Product SET Name='$Name',ItemNumber='$ItemNumber',URL='$URL' WHERE  ProductId=$Id";

			
		//echo $query;
        //return true;
		$oDatabase = new database;
		$connection = $oDatabase->Connect();

	    if (!mysql_select_db($oDatabase->Name(), $connection))
    		$oDatabase->ShowError("Product.Update");
	 
		if (!(@ mysql_query ($query, $connection)))
   			$oDatabase->ShowError("Product.Update");
			
	   	
	}
	
	function Remove($ProductId) {
		
		
		$query =  "DELETE FROM  Product  WHERE  ProductId = '$ProductId'";
				  
		$oDatabase = new database;
		$connection = $oDatabase->Connect();
		//echo $query;			
	 	if (!mysql_select_db($oDatabase->Name(), $connection))
    			$oDatabase->ShowError("Product.RemoveProduct");
	 
		if (!(@ mysql_query ($query, $connection)))
   			$oDatabase->ShowError("Product.RemoveProduct");
	   	return (true);
	}
	function get($Id){
		$query = "SELECT * ".
		        "  FROM Product R   WHERE ProductId= $Id";
		//echo ($query);
		
		$oDatabase = new database;
		$connection = $oDatabase->Connect();

	    	if (!mysql_select_db($oDatabase->Name(), $connection))
    			$oDatabase->ShowError("Products.get");
	 
		if (!($result = mysql_query ($query, $connection)))
   			$oDatabase->ShowError("Products.get");
	   	return ($result);
	}
	function getAll($orderby,$sortby){
		if(strlen($orderby)==0) $orderby=" Name ";
		$query = "SELECT * ".
		        "  FROM Product R  ";
		        $query.= " Order By $orderby $sortby";
		//echo ($query);
		
		$oDatabase = new database;
		$connection = $oDatabase->Connect();

	    	if (!mysql_select_db($oDatabase->Name(), $connection))
    			$oDatabase->ShowError("Products.getAll");
	 
		if (!($result = mysql_query ($query, $connection)))
   			$oDatabase->ShowError("Products.getAll");
	   	return ($result);
	}
	
	function SQLVarchar($_pVartext){
		return str_replace("'","''",$_pVartext) ;
	}
	
}	

?>