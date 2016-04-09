<?php
include "../Constants.php";
include "../db.php";
include "../Settings.php";
include_once "../database.php";
include "checklogin.php";

function getBackup(){
	$contents="";
	$folder = dirname(__FILE__)."/backup";
	$file = "sqlbackup.sql";
	
	if (file_exists($folder."/".$file)) {
                $handle = fopen ($folder."/".$file, "r");
                $contents = fread ($handle, filesize ($folder."/".$file));
                
                fclose ($handle);    
        }
        
        return $contents;
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
            <td colspan="" align="left" class="standardTableHeader">Restore Database</td>
            </tr>
            </table>
            <form name="form1" method="post" action="restoredatabase.php">
           
			
			<table cellpadding="5" cellspacing="1" class="standardTable">
            
            <tr align="center" valign="middle">
            <td width="30%" align=center  class="standardTableHeader">SQl to restore DB</td>
            <td>
            <textarea  name="Secret" rows="40" cols="60">
            value="<?print getBackup();  ?></textarea>
            </td>
            </tr>
           
            
			</table>
		<input type=hidden name=pageaction value="EDIT">		
			</td>
			</tr>
		    </table>    
		    </form>
        
    

</body></html>