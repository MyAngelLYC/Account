<?php
	$accountID=$_GET["accountID"];
  	$link=mysql_connect("localhost","root","123") or die("链接出错：".mysql_error());
  	mysql_select_db('Account');
	mysql_query("set names utf8");
	$result=mysql_query("select Section,userID from account where accountID='$accountID'");
	$row=mysql_fetch_row($result);
	$Section=$row[0];
	$userID=$row[1];
	
	$result_catalog = mysql_query("select name from catalog");
	$count_catalog = mysql_num_rows($result_catalog);			
	for($i=0;$i<$count_catalog;$i++)
	{
		$row_catalog=mysql_fetch_row($result_catalog);
		$result=mysql_query("select ImageHost from account where accountID='$accountID' and catalog='".($i+1)."'");
		$count=mysql_num_rows($result);
		if(((int)$count)>0)
		{
			$subindex=0;
			for($j=0;$j<$count;$j++)
			{
				$row=mysql_fetch_row($result);
				if(strcmp($row[0],"NULL"))
				{
					$subindex++;
					chdir("/var/www/Account/InvoiceImage/confirm");
					if(!file_exists($Section)) mkdir($Section,0777);
					chdir($Section);
					if(!file_exists($userID)) mkdir($userID,0777);
					chdir($userID);				
					chdir("/var/www/Account");
					$ImageHost="InvoiceImage/confirm/".$Section."/".$userID."/".$row_catalog[0].$subindex.".".pathinfo($row[0],PATHINFO_EXTENSION);
					copy($row[0],$ImageHost);
					unlink($row[0]);
					mysql_query("update account set Image='".$row_catalog[0].$subindex.".".pathinfo($row[0],PATHINFO_EXTENSION)."',ImageHost='$ImageHost' where accountID='$accountID' and catalog='".($i+1)."' and ImageHost='$row[0]'");	
				}
			}
		}
	}
//	rmdir("/var/www/Account/InvoiceImage/unconfirm/".$Section."/".$userID);
	
	mysql_query("update account set State='confirm' where accountID='$accountID'"); 	
	mysql_close($link);
	Header("Location: admin_account.php?listMode=all");
?>
