        <table width="100%"  border="0" cellspacing="0" cellpadding="0">
        <tr>
        <td colspan="3" class="middlelayout">
        	<span class="error"><?=$message?>  </span>
        	<form name="form2" method="post" action="translist.php">
            <table cellpadding="5" cellspacing="1" class="standardTable">
            <tr>
            <td colspan="" align="left" class="standardTableHeader">Transaction List</td>
            <td>
			<input type="text" name="txtsearch" size="40">
			&nbsp;&nbsp;<input type="submit" name="btnSearch" value="Search">
			</td>
            </tr>
            </table>
            </form>
            <form name="form1" method="post" action="translist.php" onsubmit="javascript:return DelEvent(this);">
            <table cellpadding="5" cellspacing="1" class="standardTable">
            <tr>
            <td align="right">
			
				<input type="submit" name="btnDel" value="Delete Selected">
				&nbsp;&nbsp;<a href="translist.php?action=download"><strong>Download</strong></a>
				&nbsp;&nbsp;<a href="searchtranslist.php"><strong>Search</strong></a>
				&nbsp;&nbsp;<a href="productslist.php"><strong>Products</strong></a>
				&nbsp;<a href="javascript:popupvar('transdetailadd.php','Help','top=150,left=300,width=460,height=480,scrollbars=yes,resizeable=yes');">Add new record</a>
				&nbsp;<a href="javascript:popupvar('updatesettings.php','Help','top=150,left=300,width=460,height=480,scrollbars=yes,resizeable=yes');">Update settings</a>
				<!--&nbsp;<a href="javascript:popupvar('restoredatabase.php','Help','top=150,left=300,width=660,height=680,scrollbars=yes,resizeable=yes');">Restore database</a>-->
				&nbsp;<a href="javascript:popupvar('processCSV.php','CSV','top=150,left=300,width=660,height=680,scrollbars=yes,resizeable=yes');">Process CSV</a>
				&nbsp;<a href="index.php?action=logout">Logout</a>
			</td>
			
			</tr>				
			</table>
			
			<table cellpadding="5" cellspacing="1" class="standardTable">
            
            <tr align="center" valign="middle">
            <td width="20%" align="center"  class="standardTableHeader"><a href="translist.php?cont=<?=$_GET['cont']?>&order=FirstName&sort=<?=$_sort?>">Name</a></span></td>
            <td width="18%" align="center" class="standardTableHeader"><a href="translist.php?cont=<?=$_GET['cont']?>&order=Email&sort=<?=$_sort?>">Email</a></td>
            <td width="10%" align="center" class="standardTableHeader"><a href="translist.php?cont=<?=$_GET['cont']?>&order=DateAdded&sort=<?=$_sort?>">Date Added</a></td>
            <td width="8%" align="center" class="standardTableHeader"><a href="translist.php?cont=<?=$_GET['cont']?>&order=orderid&sort=<?=$_sort?>">orderid</a></td>
            <td width="12%" align="center" class="standardTableHeader">address1</td>
            <td width="10%" align="center" class="standardTableHeader">city</td>
            <td width="6%" align="center" class="standardTableHeader">zipcode</td>
            <td width="6%" align="center" class="standardTableHeader">phone</td>
            <td width="6%" align="center" class="standardTableHeader">country</td>
            <td width="4%" align="center" class="standardTableHeader">Select</td>
            </tr>
            <?displayRegistrations();?>
			</table>
		<input type=hidden name=pageaction value="DEL">		
			</td>
			</tr>
		    </table>    
		    </form>
        