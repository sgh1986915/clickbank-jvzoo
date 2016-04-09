<?php
error_reporting(E_ALL);
//ini_set('display_errors', '1');
include "../Constants.php";
include "../db.php";
include "../Product.php";
include_once "../database.php";
include "checklogin.php";





$ProductId = 0;
$message  ="";


$Product = new Product;


if(isset($_GET['id'])){
	$ProductId = intval($_GET['id']);
	$Product = new Product($ProductId);
}    
    
    $_pageaction ="";
    if(isset($_POST['pageaction'])){
	    if(!empty($_POST["pageaction"])){
		    $_pageaction =$_POST["pageaction"];
	    }
	}
    
    if ( $_pageaction=="EDIT" ){
	    if($ProductId >0){
	    	$Product->Update($ProductId,$_POST["Name"],$_POST["ItemNumber"],$_POST["URL"]);
	    	
    	}else{
	    	$Product->Add($_POST["Name"],$_POST["ItemNumber"],$_POST["URL"]);
    	}
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
			
			if(objForm.Name.value==""){
				objForm.Name.focus();
				alert("Please enter a value for Product Name");
				return false;
			}
			if(objForm.ItemNumber.value==""){
				objForm.ItemNumber.focus();
				alert("Please enter a value for Item number");
				return false;
			}
			if(objForm.URL.value==""){
				objForm.URL.focus();
				alert("Please enter a value for download URL");
				return false;
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
            <td colspan="" align="left" class="standardTableHeader">Product Detail</td>
            </tr>
            </table>
            <form name="form1" method="post" action="productdetail.php<?if (isset($_GET['id'])) print '?id='.$_GET['id'];?>" onsubmit="javascript:return Validate(this);">
    		<table cellpadding="5" cellspacing="1" class="standardTable">
            
            <tr align="center" valign="middle">
            <td width="30%" align=center  class="standardTableHeader">Product Name</td>
            <td>
            <input type="text" name="Name" size="40" value="<?if(isset($_POST['Name'])){print $_POST['Name'];}else{print $Product->Name;}  ?>">
            </td>
            </tr>
            <tr align="center" valign="middle">
            <td align=center  class="standardTableHeader">Item number</td>
            <td>
            <input type="text" name="ItemNumber" size="40" value="<?if(isset($_POST['ItemNumber'])){print $_POST['ItemNumber'];}else {print $Product->ItemNumber;}  ?>">
            </td>
            </tr>
            <tr align="center" valign="middle">
            <td align=center  class="standardTableHeader">Download URL</td>
            <td><? print stripslashes($Row["ctransreceipt"]); ?>
            <input type="text" name="URL"  size="40" 
            value="<?if(isset($_POST['URL'])){print $_POST['URL'];} else {print $Product->URL;}  ?>">
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