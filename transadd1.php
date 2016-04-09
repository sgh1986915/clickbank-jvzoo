<?php
include "Constants.php";
include_once "db.php";
include_once "database.php";
include_once "Settings.php";
include_once "Receipt.php";
$Error ="";
if(isset($_POST['txtClick'])){
	$Receipt = new Receipt();
	$Pccustemail = $_POST['txtEmail'];
	$Pccustname = $_POST['txtName'];
	$Pctransreceipt = $_POST['txtClick'];
	if(strlen($Pccustemail) > 0 && strlen($Pccustname) > 0){
		$Receipt->FillFromReceipt($Pctransreceipt);
		
			$Id = $Receipt->AddReceipt($Pccustname,$Pccustemail,$Pctransreceipt,"","","","","");
			$Receipt->LogDetails("A new transaction was manually logged. The details are: Id=".$Id.",CustName=".$ccustname.", CustEmail=".$ccustemail.", ctransaction=, ctransamount=, ctransreceipt=".$ctransreceipt);
			Header("Location:registersuccess.php");
			exit;
		
	}
}
?>
<!DOCTYPE html "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd" >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<meta http-equiv="content-type" content="text/html;charset=ISO-8859-1">

<link rel="stylesheet" href="styles/extra_styles.css" type="text/css" media="screen">
<link href="styles/print.css" rel="stylesheet" type="text/css" media="print" />

        <script language="javascript" src="scripts/popup.js"  type="text/javascript"></script>
        <script language="javascript" src="scripts/lib.js"  type="text/javascript"></script>
        <script language="JavaScript">
		function Validate(objForm){
			
			
			if(objForm.txtName.value==""){
				objForm.txtName.focus();
				alert("Please enter a value for Name");
				return false;
			}
			if(objForm.txtClick.value==""){
				objForm.txtClick.focus();
				alert("Please enter a value for Clickbank transacction id");
				return false;
			}
		   if(objForm.txtEmail.value==""){
				objForm.txtEmail.focus();
				alert("Please enter a value for Email");
				return false;
			}
			return true;
		}
        
        </script>
</head>
<body>
<div class="wrapper">
	
	<div class="clear"></div>
	<div class="float-wrapper">
		

  	</div>
		
	<div class="clear"></div>
				<form name="form1" action="<?print $_SERVER['PHP_SELF'];?>" method="post" onsubmit="javascript:return Validate(this);">
				<?print $Error ;?>
	<table border="0" cellspacing="3" cellpadding="3" width="100%">
	<tr>
	<td width="30%" align="right">
		Name
		</td><td>
		<input type="text" name="txtName" id="txtName" size="35" maxlength="255" tabindex="1">
		</td></tr>
		<tr>
	<td width="30%" align="right">
		Clickbank transaction Id </td>
		<td><input type="text" name="txtClick" id="txtClick" size="35" maxlength="255" tabindex="2">
		</td></tr>
		<tr>
	<td width="30%" align="right">
		Email </td>
		<td><input type="text" name="txtEmail" id="txtEmail" size="35" maxlength="255" tabindex="3">
		</td></tr>
		<tr>
	<td width="30%" align="right">&nbsp;</td><td>
		<input type="submit" name="btnSubmit" value="Add">
		</td></tr>
	</table>	
	</form>
	
	<div class="footer">
		<div class="spacer"></div>
	</div>
		</font><!--  End of Footer  -->
				
</div>


</body></html>