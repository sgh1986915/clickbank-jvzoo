<?php
include "../Constants.php";
include "../db.php";
include "../Settings.php";
include_once "../database.php";
include "checklogin.php";



$message  ="";
    

$Settings = new Settings;



$Result = $Settings->get("DelHeaderCode");
$delheaderrow = mysql_fetch_assoc($Result);
mysql_free_result($Result);


$Result = $Settings->get("DelBodyCode");
$delbodyrow = mysql_fetch_assoc($Result);
mysql_free_result($Result);


$Result = $Settings->get("DownHeaderCode");
$downheaderrow = mysql_fetch_assoc($Result);
mysql_free_result($Result);


$Result = $Settings->get("DownBodyCode");
$downbodyrow = mysql_fetch_assoc($Result);
mysql_free_result($Result);


   
	$_pageaction ="";
    if(isset($_POST['pageaction'])){
	    if(!empty($_POST["pageaction"])){
		    $_pageaction =$_POST["pageaction"];
	    }
	}
    
    if ( $_pageaction=="EDIT" ){
	    
	    	$Settings->Update("DelHeaderCode",$_POST["txtDelheader"]);
	    	$Settings->Update("DelBodyCode",$_POST["txtDelBody"]);
	    	$Settings->Update("DownHeaderCode",$_POST["txtDownheader"]);
	    	$Settings->Update("DownBodyCode",$_POST["txtDownBody"]);
	    	
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
            <form name="form1" method="post" action="updatedeliverysettings.php" onsubmit="javascript:return Validate(this);">
           
			
			<table cellpadding="5" cellspacing="1" class="standardTable">
            <tr align="center" valign="middle">
            <td colspan="2" align=center  class="standardTableHeader">Delivery.php</td>
            </tr>
            
            
            <tr align="center" valign="middle">
            <td width="30%" align=center  class="standardTableHeader">Header area code</td>
            <td>
            <textarea  name="txtDelheader" rows="5" cols="50"><?if(isset($_POST['txtDelheader'])){print $_POST['txtDelheader'];}else{print $delheaderrow['Value'];}  ?></textarea>
            </td>
            </tr>
            <tr align="center" valign="middle">
            <td align=center  class="standardTableHeader">Body area code</td>
            <td>
            <textarea  name="txtDelBody" rows="5" cols="50"><?if(isset($_POST['txtDelBody'])){print $_POST['txtDelBody'];}else{print $delbodyrow['Value'];}  ?></textarea>
            </td>
            </tr>
            <tr align="center" valign="middle">
            <td colspan="2" align=center  class="standardTableHeader">Download links.php</td>
            </tr>
            
            <tr align="center" valign="middle">
            <td width="30%" align=center  class="standardTableHeader">Header area code</td>
            <td>
            <textarea  name="txtDownheader" rows="5" cols="50"><?if(isset($_POST['txtDownheader'])){print $_POST['txtDownheader'];}else{print $downheaderrow['Value'];}  ?></textarea>
            </td>
            </tr>
            <tr align="center" valign="middle">
            <td align=center  class="standardTableHeader">Body area code</td>
            <td>
            <textarea  name="txtDownBody" rows="5" cols="50"><?if(isset($_POST['txtDownBody'])){print $_POST['txtDownBody'];}else{print $downbodyrow['Value'];}  ?></textarea>
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