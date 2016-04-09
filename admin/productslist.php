<?php
include "../Constants.php";
include_once "../db.php";
include "../clsPagination.php";
include "../Settings.php";
include "../Product.php";
include_once "../database.php";
include "checklogin.php";


$errormessage="";
$message  ="";
$_OrderBy = "Name";
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
	header("Content-disposition: attachment; filename=Products.csv");
        print "Name,";
        print "Item number,";
        print "Download URL";
        print "\n";
        
        $Product = new Product;
        $result = $Product->getAll("Name","");
        if (mysql_affected_rows()){
	        while ($row=mysql_fetch_assoc($result)){
		        print stripslashes($row['Name']).",";
		        print stripslashes($row['ItemNumber']).",";
		        print stripslashes($row['URL']);
		        print "\n";
	        }
        }
        exit;
        
}


    $Product = new Product;
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
		        $Deleted = $Product->Remove($item);
	        }
	        $message =$_DelCounter . " Items(s) deleted successfully ..";
	    }
    }
	
    function displayAll(){
	    global $_OrderBy;global $_SortBy;;
	    $Product = new Product;
        $result = $Product->getAll($_OrderBy,$_SortBy);
        if($result){
            $totalnumrows=mysql_num_rows($result);
        }
        if (mysql_affected_rows()){
	        while ($row=mysql_fetch_assoc($result)){
		        $Name = stripslashes($row['Name']);
		        if(strlen($Name)==0){
			        $Name = "N/A";
		        }
		        print '<tr bgcolor="EDEDED"><td  height="30"  align="center" ><a href="javascript:popupvar(\'productdetail.php?id='. $row['ProductId'].'\',\'Help\',\'top=150,left=300,width=460,height=480,scrollbars=yes,resizeable=yes\');">'. $Name. '</a></td>';
		        print '<td  align="center" align="center">'.stripslashes($row['ItemNumber']).'</td>';
		        print '<td  align="center" align="center">'.$row['URL'].'</td>';
		        print '<td   align="center">&nbsp;';
   		        print '<input type="checkbox" name = "delEvent[]" value="'.$row["ProductId"].'">';
		        print '</td></tr>';

	        }
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

	
	<?include "productlist.tpl"?>
    

</body></html>