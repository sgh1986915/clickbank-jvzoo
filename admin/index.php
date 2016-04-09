<?php
include "../Constants.php";
include_once "../db.php";
include_once "../database.php";
include_once "../Settings.php";


if(isset($_SESSION['User'])){
	unset($_SESSION['User']);
}



$Settings = new Settings;

$Result = $Settings->get("AdminUser");
$secretrow = mysql_fetch_assoc($Result);
mysql_free_result($Result);

$ADMINUSERNAME=$secretrow['Value'];//print $ADMINUSERNAME;

$Result = $Settings->get("AdminPass");
$secretrow = mysql_fetch_assoc($Result);
mysql_free_result($Result);

$ADMINPASSWORD=$secretrow['Value'];//print $ADMINPASSWORD;


$UserName ="";$Password="";
if(isset($_POST['txtName'])){
	$UserName =   ($_POST['txtName']);
	
}
if(isset($_POST['txtPassword'])){
	$Password =   ($_POST['txtPassword']);
}
if(strlen($UserName) > 0 && strlen($Password) > 0){
	if($UserName==$ADMINUSERNAME && $Password==$ADMINPASSWORD){
		session_start();
		$_SESSION['User']=$UserName;
		Header("Location:translist.php");
		exit;
	}
}

?>
<!DOCTYPE html "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd" >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<meta http-equiv="content-type" content="text/html;charset=ISO-8859-1">

<link rel="stylesheet" href="../styles/extra_styles.css" type="text/css" media="screen">
<link href="../styles/print.css" rel="stylesheet" type="text/css" media="print" />

        <script language="javascript" src="../scripts/popup.js"  type="text/javascript"></script>
        <script language="javascript" src="../scripts/lib.js"  type="text/javascript"></script>
</head>
<body>
<div class="wrapper">
	
	<div class="clear"></div>
	<div class="float-wrapper">
		

  	</div>
		
	<div class="clear"></div>
				<form name="form1" action="index.php" method="post">
	<table border="0" cellspacing="3" cellpadding="3" width="100%">
	<tr>
	<td width="30%" align="right">
		UserName
		</td><td>
		<input type="text" name="txtName" id="txtName" size="35" maxlength="255" tabindex="1">
		</td></tr>
		<tr>
	<td width="30%" align="right">
		Password </td><td><input type="password" name="txtPassword" id="txtPassword" size="35" maxlength="255" tabindex="2">
		</td></tr>
		<tr>
	<td width="30%" align="right">&nbsp;</td><td>
		<input type="submit" name="btnSubmit" value="Login">
		</td></tr>
	</table>	
	</form>
	
	<div class="footer">
		<div class="spacer"></div>
	</div>
		</font><!--  End of Footer  -->
				
</div>


</body></html>