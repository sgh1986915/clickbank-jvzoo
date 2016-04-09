<?php
include "../Constants.php";
include_once "../db.php";
include "../clsPagination.php";
include "../Receipt.php";
include "../Settings.php";
include "../AllReceipt.php";
include_once "../database.php";
//include "checklogin.php";


$Synchronise = 0;
$errormessage="";
$message  ="";
$_OrderBy = "receipt_id";
if(isset($_GET['order'])){
	$_OrderBy = $_GET["order"];
}
if(empty($_OrderBy)){
    $_OrderBy = "receipt_id";
}
if(isset($_GET['sort'])){
	$_SortBy = $_GET["sort"];
}
$_sort="";
if(empty($_SortBy)){
    $_SortBy = " DESC";
    $_sort=2;
}elseif($_SortBy==1){
       $_SortBy = " Asc";
       $_sort=2;
}elseif($_SortBy==2){
    $_SortBy = " Desc";
    $_sort=1;
}

$action = "";
if(isset($_GET['action'])){
	$action = $_GET["action"];
}
$date1 = "";
$date2 = "";


if($action =="download"){
	$date1 = $_GET['date1'];
	    $date2 = $_GET['date2'];
	header("Content-type: application/csv");  
	header("Content-disposition: attachment; filename=Transactions.csv");
        print "Name" .",";
        print "Email" . ",";
        print "Date Registered";
        print "orderid";
        print "address";
        print "city";
        print "state";
        print "zipcode";
        print "country";
        print "phone";
        print "\n";
        
        $Receipt = new Receipt;
        $rsUsers = $Receipt->getRegistrationsSorted("FirstName","",0,0,"",$date1,$date2);
        if (mysql_affected_rows()){
	        while ($row=mysql_fetch_assoc($rsUsers)){
		        $RegistrationId=$row['RegisterId'];
		        //$Receipt->UpdateDownloaded($RegistrationId);
		        //print stripslashes($row['Name']).",";
		        print stripslashes($row['FirstName'])." ".stripslashes($row['LastName']).",";
		        print stripslashes($row['Email']).",";
		        print stripslashes($row['FormattedDate']).",";
		        print stripslashes($row['orderid']).",";
		        print stripslashes($row['address']).",";
		        print stripslashes($row['city']).",";
		        print stripslashes($row['state']).",";
		        print stripslashes($row['zipCode']).",";
		        print stripslashes($row['country']).",";
		        print stripslashes($row['phone']).",";
		        print "\n";
	        }
        }
        exit;
        
}


    $Receipt = new Receipt;
    $_DelCounter=0;
	$_pageaction ="";
    if(isset($_POST['pageaction'])){
	    if(!empty($_POST["pageaction"])){
		    $_pageaction =$_POST["pageaction"];
	    }
	}
    
    if ( $_pageaction=="DEL" && isset($_POST['btnDel'])){
	    $_items = $_POST["delEvent"];
	    if(!empty($_items)){
	        foreach($_items as $item){
		        $_DelCounter++;
		        $Deleted = $Receipt->Delete($item);
	        }
	        $message =$_DelCounter . " Items(s) deleted successfully ..";
	    }
    }
	
    $searchterm = "";
    
    if ( isset($_POST['btnSearch'])){
	    $date1 = $_POST['DPC_date1'];
	    $date2 = $_POST['DPC_date2'];
	    if(isset($_POST["chkPull"]) ){
		    PullFromClickbank();
	    }
    }
	$offset=0;
	$showlimit=50;
	$pagenumber=1;
	if(isset($_GET['offset'])){
		$offset=$_GET['offset'];
	}
	if(isset($_GET['pagenumber'])){
        $pagenumber=$_GET['pagenumber'];
    }

    function displayRegistrations(){
	    if (! isset($_POST['btnSearch'])){
		    return;
	    }
	    global $offset;
		global $showlimit;
		global $pagenumber;
		global $_OrderBy;global $_SortBy;global $date2; global $date1;
	    $totalnumrows=0;$rowsforpage=0;
    	$clsPagination = new clsPagination();
    	if($pagenumber > 1){
		    $offset=($pagenumber-1) *$showlimit;
	    }
        $Receipt = new AllReceipt;
        $rsUsers = $Receipt->getRegistrationsSorted($_OrderBy,$_SortBy,0,0,$date1,$date2);
        if($rsUsers){
            $totalnumrows=mysql_num_rows($rsUsers);
        }
        $rsUsers = $Receipt->getRegistrationsSorted($GLOBALS["_OrderBy"],$GLOBALS["_SortBy"],$offset,$showlimit,$date1,$date2);
        
        if (mysql_affected_rows()){
	        while ($row=mysql_fetch_assoc($rsUsers)){
		        $Name = stripslashes($row['FirstName']);
		        if(strlen($Name)==0){
			        $Name = "N/A";
		        }
		        print '<tr bgcolor="EDEDED"><td  height="30"  align="center" ><a href="javascript:popupvar(\'transdetail.php?id='. $row['receipt_id'].'\',\'Help\',\'top=150,left=300,width=460,height=480,scrollbars=yes,resizeable=yes\');">'. $Name. '</a></td>';
		        print '<td  align="center" align="center">'.stripslashes($row['Email']).'</td>';
		        print '<td  align="center" align="center">'.$row['FormattedDate'].'</td>';
		        print '<td  align="center" align="center">'.$row['orderid'].'</td>';
		        print '<td   align="center">&nbsp;';
   		        print '<input type="checkbox" name = "delEvent[]" value="'.$row["receipt_id"].'">';
		        print '</td></tr>';

	        }
	        print '<tr><td colspan="4" align="right">'.$clsPagination->getPaginationString($pagenumber, $totalnumrows, $showlimit, 3, "translist.php", "?pagenumber=").'</td></tr>';
        }
        mysql_free_result ($rsUsers);   
    }
    
    function PullFromClickbank(){
	    $devkey=""; $clerkey="";global $errormessage;global $date2; global $date1;
	    $Settings = new Settings;
	    $Result = $Settings->get("DevKey");
		$devkeyrow = mysql_fetch_assoc($Result);
		mysql_free_result($Result);
		
		$Result = $Settings->get("ClerkKey");
		$clerkkeyrow = mysql_fetch_assoc($Result);
		mysql_free_result($Result);
		
		if($devkeyrow){
			if(is_array($devkeyrow)) $devkey= $devkeyrow["Value"]; 
		}
		if($clerkkeyrow){
			if(is_array($clerkkeyrow)) $clerkey= $clerkkeyrow["Value"]; 
		}
		if(strlen($devkeyrow)==0 || strlen($clerkkeyrow)==0){
			$errormessage = "Please set developer key and API key in settings panel.";
			return;
		}
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://api.clickbank.com/rest/1.2/orders/list?startDate=".$date1."&endDate=".$date2);
		curl_setopt($ch, CURLOPT_HEADER, false); 
		curl_setopt($ch, CURLOPT_GET, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array("Accept: text/csv", "Authorization: ".$devkey.":".$clerkey));
		$result = curl_exec($ch);
		curl_close($ch);
		$AllReceipt = new AllReceipt();
		
		$Data = explode ("\n",$result); //print_r($Data);
		$i = 1;
		foreach($Data as $key => $val) {
			if(strlen($val)>0){
				if($i >1){
				$DataArray = explode (",",$val); 
				$ccustname=$DataArray[11]." ".$DataArray[12];
				$ccustemail=$DataArray[14];
				$ctransreceipt=$DataArray[1];
				$ctransaction=$DataArray[4];
				$ctranspaymentmethod=$DataArray[3];
				$ctransamount=$DataArray[6];
				$ctranspublisher=$DataArray[7];
				$cproditem=$DataArray[5];
				$ctransaffiliate=$DataArray[8];
				$cdate=$DataArray[0];
				$AllReceipt->FillFromReceipt($ctransreceipt);
				if($AllReceipt->receipt_id==0){
					$id = $AllReceipt->AddReceipt($ccustname,$ccustemail,$ctransreceipt,$ctransaction,$ctranspaymentmethod,$ctransamount,$ctranspublisher,$cproditem,$ctransaffiliate);			
					$AllReceipt->UpdateDate($id,$cdate);
				}
			}
				$i++;
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
<script type="text/javascript" src="datepickercontrol/datepickercontrol.js"></script>
<link type="text/css" rel="stylesheet" href="datepickercontrol/datepickercontrol.css">
	
		<script language="JavaScript">
		function DelEvent(objForm){
		    var bConfirm=true;
			if(isChecked(objForm)){
			    bConfirm=doConfirm()
				if(bConfirm){
					return true;
				}
			}else{
				alert("Please select a record to delete");
			}
			return false;
		}
        function isChecked(objForm){
    	
        	for(i=0;i< objForm.elements.length;i++){
        		if(objForm.elements[i].checked)
        			return true;
        	}
        	return false;
    	
        }
        
        </script>
	</head>
<body>

	
	<?include "searchtrans.tpl"?>
    

</body></html>