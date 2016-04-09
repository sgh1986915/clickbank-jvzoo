<?php
class DB{
	var $username = "";
	var $password ="";
	var $hostname = "";
	var $databaseName = "";



	function DB(){
	    $this->setDBParams();
	}   
     
	function setDBParams(){
		$this->username = DBUSERNAME;
	    $this->password =DBPASSWORD;
	    $this->hostname = DBHOST;
	    $this->databaseName = DBDATABASE;
	}
	
	
	function get_dbusername(){
	    
	    return $this->username;
	}
	function get_dbpassword(){
	    
	    return $this->password;
	}
	function get_dbhostname(){
	    
	    return $this->hostname;
	}
	function get_dbdataname(){
	    
	    return $this->databaseName;
	}
}
?>