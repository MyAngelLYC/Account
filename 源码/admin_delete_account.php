<?php
	$accountID=$_GET["accountID"];
	$listMode=$_GET["listMode"];
  	$link=mysql_connect("localhost","root","123") or die("链接出错：".mysql_error());
  	mysql_select_db('Account');
	mysql_query("set names utf8");
	$result=mysql_query("select ImageHost from account where accountID='$accountID'");
	$count=mysql_num_rows($result);
	for($i=0;$i<$count;$i++)
	{
		$row=mysql_fetch_row($result);
		if(strcmp($row[0],"NULL"))
			unlink($row[0]);
	}	
	mysql_query("delete from account where accountID='$accountID'");  	
	mysql_close($link);
	Header("Location: admin_account.php?listMode=".$listMode);
?>
