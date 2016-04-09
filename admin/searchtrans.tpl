        <table width="100%"  border="0" cellspacing="0" cellpadding="0">
        <tr>
        <td colspan="3" class="middlelayout">
        	<span class="error"><?=$message?>  </span>
        	<form name="form2" method="post" action="searchtranslist.php">
            <table cellpadding="5" cellspacing="1" class="standardTable">
            <tr>
            <td colspan="" align="left" class="standardTableHeader">Search Transactions</td>
            <td>
            <input type="text" name="DPC_date1" id="DPC_date1_YYYY-MM-DD" size="10" value="<?print $date1?>" datepicker_format="YYYY-MM-DD"> to 
            <input type="text" name="DPC_date2" id="DPC_date2_YYYY-MM-DD" size="10" value="<?print $date2?>" datepicker_format="YYYY-MM-DD">
            <br><br>&nbsp;<input type="checkbox" name="chkPull"> Download from Clickbank
            &nbsp;&nbsp;&nbsp;<input type="submit" name="btnSearch" value="Search">
            </td>
            </tr>
            </table>
            </form>
            <form name="form1" method="post" action="searchtranslist.php" onsubmit="javascript:return DelEvent(this);">
            <table cellpadding="5" cellspacing="1" class="standardTable">
            <tr>
            <td align="right">
			
				
				&nbsp;&nbsp;<a href="searchtranslist.php?action=download&date1=<?print $date1;?>&date2=<?print $date2;?>"><strong>Download</strong></a>
				&nbsp;<a href="translist.php">Home</a>
				&nbsp;<a href="index.php?action=logout">Logout</a>
			</td>
			
			</tr>				
			</table>
			<?print $errormessage;?>
			<table cellpadding="5" cellspacing="1" class="standardTable">
            
            <tr align="center" valign="middle">
            <td width="30%" align=center  class="standardTableHeader"><a href="translist.php?cont=<?=$_GET['cont']?>&order=FirstName&sort=<?=$_sort?>">Name</a></span></td>
            <td width="20%" align="center" class="standardTableHeader"><a href="translist.php?cont=<?=$_GET['cont']?>&order=Email&sort=<?=$_sort?>">Email</a></td>
            <td width="15%" align="center" class="standardTableHeader"><a href="translist.php?cont=<?=$_GET['cont']?>&order=DateAdded&sort=<?=$_sort?>">Date Added</a></td>
            <td width="15%" align="center" class="standardTableHeader"><a href="translist.php?cont=<?=$_GET['cont']?>&order=orderid&sort=<?=$_sort?>">orderid</a></td>
            <td width="10%" align="center" class="standardTableHeader">Select</td>
            </tr>
            <?displayRegistrations();?>
			</table>
		<input type="hidden" name="pageaction" value="DEL">		
			</td>
			</tr>
		    </table> 
		    <input type="hidden" id="DPC_TODAY_TEXT" value="today">
<input type="hidden" id="DPC_BUTTON_TITLE" value="Open calendar...">
<input type="hidden" id="DPC_MONTH_NAMES" value="['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December']">
<input type="hidden" id="DPC_DAY_NAMES" value="['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat']">
   
		    </form>
        