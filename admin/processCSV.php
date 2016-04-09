<?php
include "../Constants.php";
include "../db.php";
include "../Receipt.php";
include_once "../database.php";
include "checklogin.php";


error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);
ini_set("display_errors", 1); 
ini_set('max_execution_time', 30000); //300 seconds = 5 minutes
$Receipt = new Receipt;
$message="";
	$_pageaction ="";
    if(isset($_POST['pageaction'])){
	    if(!empty($_POST["pageaction"])){
		    $_pageaction =$_POST["pageaction"];
	    }
	}
    
    if ( $_pageaction=="UPLOAD"){
	    if (is_uploaded_file($_FILES['file']['tmp_name'])){
  			$row=0;
  			if (($handle = fopen($_FILES['file']['tmp_name'], "r")) !== FALSE) {
			    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
			        $num = count($data);
			        //echo "<p> $num fields in line $row: <br /></p>\n";
			        $row++;
			        if($num >=2){
				        $first=$data[0];
						$LastName=$data[1];
				        $email=$data[2];
				        $orderid=$data[3];
				        $productid=$data[4];
				        $ctransamount=$data[5];
				        $transactiondate=$data[6];
				        	$address=$data[7];
				        	$city=$data[8];
				        	$state=$data[9];
				        	$zipCode=$data[10];
				        	$country=$data[11];
				        	$phone=$data[12];
				        
				        if($email!="[email]"){
					        if(! $Receipt->LookupDetails2($email,$productid)){
						    	$Receipt->AddReceipt($first,$LastName,$email,'SALE',$orderid,$productid,$phone,$ctransamount,$transactiondate,$address,$city,	$state,	$zipCode,	$country );
						    	$Receipt->LogDetails("A transaction was added in admin via CSV. The details are: CustName=".$first.", CustEmail=".$email);
						    	print $email ." was added to the database "."<br>";
					    	}
					        
			        	}
			        }
			        
			    }
			    fclose($handle);
			}
	 
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

	
	 <table width="100%"  border="0" cellspacing="0" cellpadding="0">
        <tr>
        <td colspan="3" class="middlelayout">
        	<span class="error"><?=$message?>  </span>
            <table cellpadding="5" cellspacing="1" class="standardTable">
            <tr>
            <td colspan="" align="left" class="standardTableHeader">Upload CSV</td>
            </tr>
            </table>

        	<form name="form1" method="post" action="processCSV.php" enctype="multipart/form-data" onsubmit="javascript:return Validate();">
            <table cellpadding="5" cellspacing="1" class="standardTable">
             
            <tr align="center" valign="middle">
            <td width="30%" align=center  ><label for="file">Filename:</label></td>
			<td align="left"><input type="file" name="file" id="file" /></td>
			</tr>
			<tr align="center" valign="middle">
			<td width="30%" align=center  >&nbsp;</td>
			<td align="left">
			<input type="submit" name="submit" value="Submit" />
			</td>
            </tr>
            
			</table>
		<input type="hidden" name="pageaction" value="UPLOAD">		
			</td>
			</tr>
		    </table>    
		    </form>
        
    

</body></html>