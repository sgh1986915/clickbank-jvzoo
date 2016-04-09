<?php
session_start();

include "Constants.php";
include_once "db.php";
include_once "database.php";
include_once "Settings.php";
include_once "Receipt.php";


$Email = "";
$CustomerName="";
if(isset($_SESSION['Download_Email'])){
	$Email = $_SESSION['Download_Email'];
}



if(strlen($Email) == 0 ){
	Header("Location:delivery.php");
	exit;
}

$Settings = new Settings;
$Result = $Settings->get("DownHeaderCode");
$downheaderrow = mysql_fetch_assoc($Result);
mysql_free_result($Result);


$Result = $Settings->get("DownBodyCode");
$downbodyrow = mysql_fetch_assoc($Result);
mysql_free_result($Result);


$Receipt= new Receipt;
	$result = $Receipt->Lookup($Email);
	if (mysql_affected_rows()){
		while ($Row=mysql_fetch_assoc($result)){
			$CustomerName = $Row['Name'];
		}
		
	}

	function ShowLinks(){
		global $Email;
		$Receipt = new Receipt;
		$result = $Receipt->GetDownloadLinks($Email);
		$counter=1;
		if (mysql_affected_rows()){
			while ($row=mysql_fetch_assoc($result)){
		        $Name = stripslashes($row['Name']);
		        if(strlen($Name)==0){
			        $Name = "N/A";
		        }
		        print '<tr bgcolor="EDEDED"><td align="center" >'. $counter.'</td>';
		        print '<td  align="center" >'.stripslashes($row['Name']).'</td>';
		        print '<td  align="center" ><a href="'.$row['URL'].'" target="_blank"><strong>Download Here</strong></td>';
		        print '</tr>';
				$counter++;
	        }
        }
        mysql_free_result ($result);  
		
	}

?>

<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' />
<title>Delivery</title>

<link href="default_css.css" rel='stylesheet' type='text/css' />

<style type="text/css" rel="stylesheet">
#container{width:850px; text-align:center}					
li {
	margin:5px 0 !important
}
.ol-list {
	font:normal 11pt/130% Verdana, Arial, Helvetica, sans-serif;
	margin:40px 0 60px
}
.ol-list h3 {
	padding-bottom:0;
	margin-bottom:0
}
.ul-list {
	margin:40px 0 60px
}
.ul-list li {
	font-size:11pt;
}

</style>


<body>
<div align="center">
<div id="container">
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td height="3" colspan="2" align="center"><hr size="1" noshade></td>
  </tr>
  <tr>
    <td colspan="2" align="center">
  <?php print $downheaderrow['Value'];?>
  </td>
  </tr>
  
  <tr>
  <td valign="top">
  	<table width="100%" border="0" cellspacing="0" cellpadding="10">
    <tr>
    <td>
    
        <table width="100%" border="0" cellpadding="10" cellspacing="1" class="darkbox" align="center">

         
          <tr valign="top">
            <td bgcolor="#FFFFFF"  align="left">
			<p >
			Welcome <strong><?php print $CustomerName;?> </strong><br/>
			You can download the products you ordered below.
			 </p>
			<p>
			<? print $Email?> has purchased the following items.
			</p>
        	<p>
        	<table width="100%" border="0" cellpadding="10" cellspacing="1">
        	<tr bgcolor="FF9966">
        	<td width="25%">
        	Item #
        	</td>
        	<td width="35%">
        	Product Name
        	</td>
        	<td>
        	Download link
        	</td>
        	</tr>
        	<?php ShowLinks();?>
        	</table>
        	</p>
			
			</td>
          </tr>
        </table>
        
 </td>
      </tr>
      <tr>
    <td align="center">
    <?php print $downbodyrow['Value'];?>
    </td>
    </tr>
    </table>    </td>

  </tr>
</table>
</div>
</div>


</body>
</html>