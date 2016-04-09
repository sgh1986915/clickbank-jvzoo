<?php
include "Constants.php";
include_once "db.php";
include_once "database.php";
include_once "Settings.php";
include_once "Receipt.php";

if(isset($_SESSION['Download_Email'])){
	unset($_SESSION['Download_Email']);
}

$Settings = new Settings;
$Result = $Settings->get("DelHeaderCode");
$delheaderrow = mysql_fetch_assoc($Result);
mysql_free_result($Result);


$Result = $Settings->get("DelBodyCode");
$delbodyrow = mysql_fetch_assoc($Result);
mysql_free_result($Result);


$Email ="";
if(isset($_POST['txtEmail'])){
	$Email =   ($_POST['txtEmail']);
	
}

if(strlen($Email) > 0 ){
	$Receipt= new Receipt;
	$result = $Receipt->Lookup($Email);
	if (mysql_affected_rows()){
		$Row = mysql_fetch_assoc($Result);
		while ($Row=mysql_fetch_assoc($result)){
			session_start();
			$_SESSION['Download_Email']=$Row['Email'];
			Header("Location:downloadlinks.php");
			exit;
		}
		
		
	}
}


?>

<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' />
<title>Delivery</title>

<link href="default_css.css" rel='stylesheet' type='text/css' />

<style type="text/css" rel="stylesheet">
#container{width:600px; text-align:center}					
li {
	margin:5px 0 !important
}
.ol-list {
	font:normal 11pt/130% Verdana, Arial, Helvetica, sans-serif;
	margin:40px 0 60px
}
.ol-list h3 {
	padding-bottom:0;
	margin-bottom:0
}
.ul-list {
	margin:40px 0 60px
}
.ul-list li {
	font-size:11pt;
}

</style>


<body>
<div align="center">
<div id="container">
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td height="3" colspan="2" align="center"><hr size="1" noshade></td>
  </tr>
  <tr>
    <td colspan="2" align="center">
  <?php print $delheaderrow['Value'];?>
  </td>
  </tr>
  <tr>
  <td valign="top">
  	<table width="100%" border="0" cellspacing="0" cellpadding="10">
    <tr>
    <td>
    <form name="form1" action="delivery.php" method="post">
        <table width="100%" border="0" cellpadding="10" cellspacing="1" class="darkbox" align="center">
			<tr valign="top">
            <td bgcolor="#FFFFFF"  align="left">
			<p >
			Thank you for your purchase!<br/>
			Claim your download links on this page...		
			 </p>
			<p>
			Enter your "order email" as you see in your receipt to claim all your download links  on the next screen.
			</p>
        	<p>
        	<table width="100%" border="0" cellpadding="10" cellspacing="1">
        	<tr>
        	<td width="25%">
        	Order email
        	</td>
        	<td>
        	<input type="text" name="txtEmail" size="50">
        	</td>
        	</tr>
        	<tr>
        	<td></td>
        	<td>
        	<input type="submit" name="btnSubmit" value="Submit">
        	</td>
        	
        	</tr>
        	</table>
        	</p>
			
			</td>
          </tr>
        </table>
    </form>
 	</td>
    </tr>
    <tr>
    <td align="center">
    <?php print $delbodyrow['Value'];?>
    </td>
    </tr>
    </table>    </td>

  </tr>
</table>
</div>
</div>


</body>
</html>