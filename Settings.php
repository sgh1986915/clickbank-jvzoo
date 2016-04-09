<?

class Settings {
	

	function Update($Name,$Value) {
	    
		$Name = $this->SQLVarchar($Name);
		$Value = $this->SQLVarchar($Value);
		$Result = $this->get($Name);
	    	if($Result){
		    	if(mysql_num_rows($Result)==0){
			    	$this->Add($Name,$Value);
		    	}
	    	}
		$query =  "UPDATE  Settings SET Value='$Value' WHERE  Name='$Name'";
			
		//echo $query;
        //return true;
		$oDatabase = new database;
		$connection = $oDatabase->Connect();

	    if (!mysql_select_db($oDatabase->Name(), $connection))
    		$oDatabase->ShowError("Settings.Update");
	 
		if (!(@ mysql_query ($query, $connection)))
   			$oDatabase->ShowError("Settings.Update");
	}
	
	function Add($Name,$Value) {
	    
		$Name = $this->SQLVarchar($Name);
		$Value = $this->SQLVarchar($Value);
		
		$query =  "INSERT INTO  Settings(Value,Name) VALUES('$Value','$Name')";
			
		//echo $query;
        //return true;
		$oDatabase = new database;
		$connection = $oDatabase->Connect();

	    if (!mysql_select_db($oDatabase->Name(), $connection))
    		$oDatabase->ShowError("Settings.Add");
	 
		if (!(@ mysql_query ($query, $connection)))
   			$oDatabase->ShowError("Settings.Add");
	}
	
	
	function get($Name){
		$query = "SELECT S.*".
		        "  FROM Settings S   WHERE Name= '$Name'";
		        
		       
		//echo ($query);
		
		$oDatabase = new database;
		$connection = $oDatabase->Connect();

	    	if (!mysql_select_db($oDatabase->Name(), $connection))
    			$oDatabase->ShowError("Settings.get");
	 
		if (!($result = mysql_query ($query, $connection)))
   			$oDatabase->ShowError("Settings.get");
	   	return ($result);
	}
	
	function getAll(){
		$query = "SELECT S.*".
		        "  FROM Settings S ";
		        
		       
		//echo ($query);
		
		$oDatabase = new database;
		$connection = $oDatabase->Connect();

	    	if (!mysql_select_db($oDatabase->Name(), $connection))
    			$oDatabase->ShowError("Settings.get");
	 
		if (!($result = mysql_query ($query, $connection)))
   			$oDatabase->ShowError("Settings.get");
	   	return ($result);
	}
	
	
	
	function SQLVarchar($_pVartext){
		return $_pVartext;
		//return str_replace("'","''",$_pVartext) ;
	}
}	

?>