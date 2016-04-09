<?php
class database{
	
	var $Name;
	
	function Connect()
		{

		$DB = new DB;
   	    if ($connection = @ mysql_connect($DB->get_dbhostname(), 
                                       $DB->get_dbusername(), 
                                       $DB->get_dbpassword()))
			return $connection;
		else
			die("Error in \"Database.Connect\" ". mysql_errno() . " : " . mysql_error());
		}
		
	
				
	function Name(){
		$DB = new DB;
		$this->Name = $DB->get_dbdataname();
		return ($this->Name);
	}
	
	function ShowError($source)
	   {
      	die("Error in ".$source. " " . mysql_errno() . " : " . mysql_error());
   	   }
	   
}	

?>