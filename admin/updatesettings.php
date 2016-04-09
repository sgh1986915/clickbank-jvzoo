<?php
include "../Constants.php";
include "../db.php";
include "../Settings.php";
include_once "../database.php";
include "checklogin.php";



$message  ="";
    

$Settings = new Settings;



$Result = $Settings->get("Secret");
$secretrow = mysql_fetch_assoc($Result);
mysql_free_result($Result);


$Result = $Settings->get("AdminUser");
$adminuserrow = mysql_fetch_assoc($Result);
mysql_free_result($Result);


$Result = $Settings->get("AdminPass");
$adminpassrow = mysql_fetch_assoc($Result);
mysql_free_result($Result);


$Result = $Settings->get("Proditem");
$proditemrow = mysql_fetch_assoc($Result);
mysql_free_result($Result);


$Result = $Settings->get("CancelProditem");
$cancelproditemrow = mysql_fetch_assoc($Result);
mysql_free_result($Result);

$Result = $Settings->get("DevKey");
$devkeyrow = mysql_fetch_assoc($Result);
mysql_free_result($Result);

$Result = $Settings->get("ClerkKey");
$clerkkeyrow = mysql_fetch_assoc($Result);
mysql_free_result($Result);
    
   
	$_pageaction ="";
    if(isset($_POST['pageaction'])){
	    if(!empty($_POST["pageaction"])){
		    $_pageaction =$_POST["pageaction"];
	    }
	}
    
    if ( $_pageaction=="EDIT" ){
	    
	    	$Settings->Update("Secret",$_POST["Secret"]);
	    	$Settings->Update("AdminUser",$_POST["adminusername"]);
	    	$Settings->Update("AdminPass",$_POST["adminpassword"]);
	    	$Settings->Update("Proditem",$_POST["proditem"]);
	    	$Settings->Update("CancelProditem",$_POST["cancelproditem"]);
	    	$Settings->Update("DevKey",$_POST["txtDevKey"]);
	    	$Settings->Update("ClerkKey",$_POST["txtAPIKey"]);
	    Header("Location:success.htm");
		exit;
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


	
		<script language="JavaScript">
		function Validate(objForm){
			
			if(objForm.Secret.value==""){
				objForm.Secret.focus();
				alert("Please enter a value for Secret");
				return false;
			}
			if(objForm.adminusername.value==""){
				objForm.adminusername.focus();
				alert("Please enter a value for admin username");
				return false;
			}
			if(objForm.adminpassword.value==""){
				objForm.adminpassword.focus();
				alert("Please enter a value for admin password");
				return false;
			}
			if(objForm.proditem.value!=""){
				/*if(isNaN(objForm.proditem.value)){
					alert("Please enter a numerical value for prod item");
					return false;
				}
				var proditem = parseInt(objForm.proditem.value);
				if(proditem <=0 || proditem > 100){
					alert("Please enter a value between 1 and 100 for prod item");
					return false;
				}*/
			}
			
		   
			return true;
		}
        
        </script>
	</head>
<body>

	
	 <table width="100%"  border="0" cellspacing="0" cellpadding="0">
        <tr>
        <td colspan="3" class="middlelayout">
        	<span class="error"><?=$message?>  </span>
            <table cellpadding="5" cellspacing="1" class="standardTable">
            <tr>
            <td colspan="" align="left" class="standardTableHeader">Settings</td>
            </tr>
            </table>
            <form name="form1" method="post" action="updatesettings.php" onsubmit="javascript:return Validate(this);">
           
			
			<table cellpadding="5" cellspacing="1" class="standardTable">
            
            <tr align="center" valign="middle">
            <td width="30%" align=center  class="standardTableHeader">Secret</td>
            <td>
            <input type="text" name="Secret" size="40" 
            value="<?if(isset($_POST['Secret'])){print $_POST['Secret'];}else{print $secretrow['Value'];}  ?>">
            </td>
            </tr>
            <tr align="center" valign="middle">
            <td align=center  class="standardTableHeader">Admin username</td>
            <td>
            <input type="text" name="adminusername" size="40" 
            value="<?if(isset($_POST['adminusername'])){print $_POST['adminusername'];}else{print $adminuserrow['Value'];}  ?>">
            </td>
            </tr>
            <tr align="center" valign="middle">
            <td align=center  class="standardTableHeader">Admin password</td>
            <td>
          <input type="text" name="adminpassword" size="40" 
          value="<?if(isset($_POST['adminpassword'])){print $_POST['adminpassword'];}else{print $adminpassrow['Value'];}  ?>">
            </td>
            </tr>
            <tr align="center" valign="middle">
            <td align=center  class="standardTableHeader">Prod Item to log in the database<br>
            (if you leave this empty all transactions are logged. For multiple prod item enter them as comma delimited.)
            </td>
            <td>
          <input type="text" name="proditem" size="40" 
          value="<?if(isset($_POST['proditem'])){print $_POST['proditem'];}else{print $proditemrow['Value'];}  ?>">
            </td>
            </tr>
            
            <tr align="center" valign="middle">
            <td align=center  class="standardTableHeader">Prod Items for which clickbank IPN records are deleted from database for cancel<br>
            (if you leave this empty no cancel records are deleted. If you enter a prod item, then for
            that prod item the "Cancel" records will be deleted.
            For multiple prod item enter them as comma delimited.)
            </td>
            <td>
          <input type="text" name="cancelproditem" size="40" 
          value="<?if(isset($_POST['cancelproditem'])){print $_POST['cancelproditem'];}else{print $cancelproditemrow['Value'];}  ?>">
            </td>
            </tr>
              <tr align="center" valign="middle">
            <td align=center  class="standardTableHeader">Developer Key<br>
            
            </td>
            <td>
          <input type="text" name="txtDevKey" size="40" 
          value="<?if(isset($_POST['txtDevKey'])){print $_POST['txtDevKey'];}else{print $devkeyrow['Value'];}  ?>">
            </td>
            </tr>
             <tr align="center" valign="middle">
            <td align=center  class="standardTableHeader">API Clerk Key<br>
            
            </td>
            <td>
          <input type="text" name="txtAPIKey" size="40" 
          value="<?if(isset($_POST['txtAPIKey'])){print $_POST['txtAPIKey'];}else{print $clerkkeyrow['Value'];}  ?>">
            </td>
            </tr>
            <tr align="left">
            <td colspan="2" align="left">
            <input type="submit" name=Save value="Save changes" class="submit">   
            &nbsp;&nbsp;&nbsp;  <input type="button" name=Cancel value="Cancel" class="submit" onclick="javascript:window.close()">  
            
            </td>
            </tr>
			</table>
		<input type=hidden name=pageaction value="EDIT">		
			</td>
			</tr>
		    </table>    
		    </form>
        
    

</body></html>