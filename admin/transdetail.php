<?php
include "../Constants.php";
include "../db.php";
include "../Receipt.php";
include_once "../database.php";
include "checklogin.php";




$receiptid = 0;
$formenctype="";
$message  ="";
    
if(isset($_GET['id'])){
	$receiptid = $_GET["id"];
}

$Receipt = new Receipt;
$Result = $Receipt->get($receiptid);
$Row = mysql_fetch_assoc($Result);
mysql_free_result($Result);


$action = "";
if(isset($_GET['action'])){
	$action = $_GET["action"];
}


    
    $_DelCounter=0;
	$_pageaction ="";
    if(isset($_POST['pageaction'])){
	    if(!empty($_POST["pageaction"])){
		    $_pageaction =$_POST["pageaction"];
	    }
	}
    
    if ( $_pageaction=="EDIT" ){
	    $Receipt->UpdateReceipt($receiptid,$_POST["Name"],$_POST["Email"],$_POST["ctransamount"],$_POST['productid']);
	    $Receipt->LogDetails("A transaction was updated in admin. The details are: CustName=".$_POST["Name"].", CustEmail=".$_POST["Email"]);
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
				alert("Please enter a value for Name");
				return false;
			}
			if(objForm.Email.value==""){
				objForm.Email.focus();
				alert("Please enter a value for Email");
				return false;
			}
			if(objForm.ctransreceipt.value==""){
				objForm.ctransreceipt.focus();
				alert("Please enter a value for ctransreceipt");
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
            <td colspan="" align="left" class="standardTableHeader">Transaction Detail</td>
            </tr>
            </table>
            <form name="form1" method="post" action="transdetail.php?id=<?print $_GET['id'];?>" onsubmit="javascript:return Validate(this);">
           
			
			<table cellpadding="5" cellspacing="1" class="standardTable">
            
            <tr align="center" valign="middle">
            <td width="30%" align=center  class="standardTableHeader">Customer Name</td>
            <td>
            <input type="text" name="Name" size="40" value="<?if(isset($_POST['Name'])){print $_POST['Name'];} else { print stripslashes($Row["FirstName"]);} ?>">
            </td>
            </tr>
            <tr align="center" valign="middle">
            <td align=center  class="standardTableHeader">Customer Email</td>
            <td>
            <input type="text" name="Email" size="40" value="<?if(isset($_POST['Email'])){print $_POST['Email'];} else { print stripslashes($Row["Email"]);} ?>">
            </td>
            </tr>
            <tr align="center" valign="middle">
            <td align=center  class="standardTableHeader">orderid</td>
            <td><? print stripslashes($Row["orderid"]); ?>
            </td>
            </tr>
            <tr align="center" valign="middle">
            <td align=center  class="standardTableHeader">productid</td>
            <td>
            <input type="text" name="productid" size="40" 
            value="<?if(isset($_POST['productid'])){print $_POST['productid'];} else { print stripslashes($Row["productid"]);} ?>">
            </td>
            </tr>
             <tr align="center" valign="middle">
            <td align=center  class="standardTableHeader">ctransamount</td>
            <td>
            <input type="text" name="ctransamount" size="40" 
            value="<?if(isset($_POST['ctransamount'])){print $_POST['ctransamount'];} else { print stripslashes($Row["amount"]);} ?>">
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