<?php
include "../Constants.php";
include_once "../db.php";
include "../clsPagination.php";
include "../Receipt.php";
include_once "../database.php";
include "checklogin.php";




$Synchronise = 0;
$formenctype="";
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

if($action =="download"){
	header("Content-type: application/csv");  
	header("Content-disposition: attachment; filename=registration.csv");
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
        $rsUsers = $Receipt->getRegistrationsSorted("FirstName","",0,0,"");
        if (mysql_affected_rows()){
	        while ($row=mysql_fetch_assoc($rsUsers)){
		        $RegistrationId=$row['RegisterId'];
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
if($action =="downloadrfnds"){
	header("Content-type: application/csv");  
	header("Content-disposition: attachment; filename=refundedtransaction.csv");
		print "Name" .",";
        print "Email" . ",";
        print "Date Refunded". ",";
        print "orderid". ",";
        print "\n";
        
        $Receipt = new Receipt;
        $rsUsers = $Receipt->getRefunds("Name");
        if (mysql_affected_rows()){
	        while ($row=mysql_fetch_assoc($rsUsers)){
		        print stripslashes($row['FirstName'])." ".stripslashes($row['LastName']).",";
		        print stripslashes($row['Email']).",";
		        print stripslashes($row['FormattedDate']).",";
		        print stripslashes($row['orderid']).",";
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
	    $searchterm = $_POST['txtsearch'];
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
	    global $offset;
		global $showlimit;
		global $pagenumber;
	global $_OrderBy;global $_SortBy;global $searchterm;
	    $totalnumrows=0;$rowsforpage=0;
    	$clsPagination = new clsPagination();
    	if($pagenumber > 1){
		    $offset=($pagenumber-1) *$showlimit;
	    }
        $Receipt = new Receipt;
        $rsUsers = $Receipt->getRegistrationsSorted($_OrderBy,$_SortBy,0,0,$searchterm);
        if($rsUsers){
            $totalnumrows=mysql_num_rows($rsUsers);
        }
        $rsUsers = $Receipt->getRegistrationsSorted($GLOBALS["_OrderBy"],$GLOBALS["_SortBy"],$offset,$showlimit,$searchterm);
        
        if (mysql_affected_rows()){
	        while ($row=mysql_fetch_assoc($rsUsers)){
		        $Name = stripslashes($row['FirstName']);
		        if(strlen($Name)==0){
			        $Name = "N/A";
		        }
		        print '<tr bgcolor="EDEDED"><td  height="30"  align="left" ><a href="javascript:popupvar(\'transdetail.php?id='. $row['receipt_id'].'\',\'Help\',\'top=150,left=300,width=460,height=480,scrollbars=yes,resizeable=yes\');">'. $Name. ' ' . stripslashes($row['LastName']). '</a></td>';
		        print '<td  align="left" align="center">'.stripslashes($row['Email']).'</td>';
		        print '<td  align="left" align="center">'.$row['FormattedDate'].'</td>';
		        print '<td  align="left" align="center">'.$row['orderid'].'</td>';
		        print '<td  align="left" align="center">'.$row['address'].'</td>';
		        print '<td  align="left" align="center">'.$row['city'].'</td>';
		        print '<td  align="left" align="center">'.$row['zipCode'].'</td>';
		        print '<td  align="left" align="center">'.$row['phone'].'</td>';
		        print '<td  align="left" align="center">'.$row['country'].'</td>';
		        print '<td   align="center">&nbsp;';
   		        print '<input type="checkbox" name = "delEvent[]" value="'.$row["receipt_id"].'">';
		        print '</td></tr>';

	        }
	        print '<tr><td colspan="4" align="right">'.$clsPagination->getPaginationString($pagenumber, $totalnumrows, $showlimit, 3, "translist.php", "?pagenumber=").'</td></tr>';
        }
        mysql_free_result ($rsUsers);   
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

	
	<?include "manageregistrations.tpl"?>
    

</body></html>