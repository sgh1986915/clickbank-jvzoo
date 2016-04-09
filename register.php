<?
include "Constants.php";
include_once "db.php";
include_once "database.php";
include_once "Settings.php";
include_once "Receipt.php";

if(isset($_POST['ctransaction'])){
	$Receipt = new Receipt();
	$Pccustemail = $_POST['ccustemail'];
	$Pccustname = $_POST['ccustname'];
	$Pctransreceipt = $_POST['ctransreceipt'];
	if(strlen($Pccustemail) > 0 && strlen($Pccustname) > 0){
	if(! $Receipt->LookupDetails($Pccustemail,$Pccustname)){
		$Receipt->AddReceipt($Pccustname,$Pccustemail,$Pctransreceipt,$_POST['ctransaction'],"","","","");
		$Receipt->LogDetails("A new transaction was manually logged. The details are: CustName=".$ccustname.", CustEmail=".$ccustemail.", ctransaction=".$ctransaction.", ctransamount=".$ctransamount.", ctransreceipt=".$ctransreceipt);
		//mail('vijay.kuve@gmail.com', 'Callback processed for add receipt', "proditem=".$cproditem." receipt=".$ctransreceipt);
		Header("Location:registersuccess.php");
		exit;
	}
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
			
			if(objForm.ccustemail.value==""){
				objForm.ccustemail.focus();
				alert("Please enter a value for Email");
				return false;
			}
			if(objForm.ccustname.value==""){
				objForm.ccustname.focus();
				alert("Please enter a value for Name");
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


<form action="register.php" method="post" name="form1"  onsubmit="javascript:return Validate(this);">
<table border="0" cellspacing="3" cellpadding="3" width="100%">
	<tr>
	<td width="30%" align="right">
Name <font color="red">*</font></td><td>
<input type="text" name="ccustname" value="" size="45">
</td></tr>
<tr>
	<td width="30%" align="right">
Email <font color="red">*</font></td><td>
<input type="text" name="ccustemail" value=""  size="45">
</td></tr>
<tr>
	<td width="30%" align="right">
Clickbank Receipt ID</td><td>
<input type="text" name="ctransreceipt" value=""  size="45">
</td></tr>

<input type="hidden" name="ctransaction" value="MANUAL">
<tr>
	<td colspan="2" align="center">
<input type="submit" name="submit" value="Submit">
</td></tr>
</table>	

</form>
<div class="footer">
		<div class="spacer"></div>
	</div>
		</font><!--  End of Footer  -->
				
</div>


</body></html>