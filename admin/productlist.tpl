        <table width="100%"  border="0" cellspacing="0" cellpadding="0">
        <tr>
        <td colspan="3" class="middlelayout">
        	<span class="error"><?=$message?>  </span>
        	<form name="form2" method="post" action="translist.php">
            <table cellpadding="5" cellspacing="1" class="standardTable">
            <tr>
            <td colspan="" align="left" class="standardTableHeader">Product List</td>
            </tr>
            </table>
            </form>
            <form name="form1" method="post" action="productslist.php" onsubmit="javascript:return DelEvent(this);">
            <table cellpadding="5" cellspacing="1" class="standardTable">
            <tr>
            <td align="right">
			
				<input type="submit" name="btnDel" value="Delete Selected">
				&nbsp;&nbsp;<a href="productslist.php?action=download"><strong>Download</strong></a>
				&nbsp;<a href="javascript:popupvar('productdetail.php','Add','top=150,left=300,width=460,height=480,scrollbars=yes,resizeable=yes');">Add new product</a>
				&nbsp;<a href="javascript:popupvar('updatedeliverysettings.php','Delcust','top=150,left=300,width=460,height=480,scrollbars=yes,resizeable=yes');">Delivery page customisation</a>
				&nbsp;&nbsp;<a href="translist.php"><strong>Admin Panel</strong></a>
				&nbsp;<a href="index.php?action=logout">Logout</a>
			</td>
			
			</tr>				
			</table>
			
			<table cellpadding="5" cellspacing="1" class="standardTable">
            
            <tr align="center" valign="middle">
            <td width="30%" align=center  class="standardTableHeader"><a href="productslist.php?cont=<?=$_GET['cont']?>&order=Name&sort=<?=$_sort?>">Name</a></span></td>
            <td width="20%" align="center" class="standardTableHeader"><a href="productslist.php?cont=<?=$_GET['cont']?>&order=ItemNumber&sort=<?=$_sort?>">Item number</a></td>
            <td width="15%" align="center" class="standardTableHeader"><a href="productslist.php?cont=<?=$_GET['cont']?>&order=URL&sort=<?=$_sort?>">Download URL</a></td>
            

            <td width="10%" align="center" class="standardTableHeader">Delete</td>
            </tr>
            <?displayAll();?>
			</table>
		<input type=hidden name=pageaction value="DEL">		
			</td>
			</tr>
		    </table>    
		    </form>
        