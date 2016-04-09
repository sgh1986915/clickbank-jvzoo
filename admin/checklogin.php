<?
session_start();

if (empty($_SESSION["User"])){
	header ("Location:index.php?failure=1");
	exit;	
}
else{
    	$UserId = $_SESSION["User"];
    	if($UserId!=ADMINUSER){
	    	//header ("Location:index.php?failure=1");
			//exit;	
    	}
	}
?>
