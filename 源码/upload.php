<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>课题组报销系统</title>
<style type="text/css">
.myBorder
{
	border-collapse:collapse;	
}
</style>
</head>

<body>
<?php
	$userID = $_COOKIE["userID"];
  	$accountID = date('Ym').$userID;
  	$link=mysql_connect("localhost","root","123") or die("链接出错：".mysql_error());
  	mysql_select_db('Account');
	mysql_query("set names utf8");
  	$result=mysql_query("select count(*) from confirm where accountID='$accountID'");
	$row=mysql_fetch_row($result);
	$count=$row[0];
	$result = mysql_query("select * from confirm where accountID='$accountID'");	  
	for($i=0;$i<$count;$i++)
	{
		$row=mysql_fetch_row($result);
		mysql_query("insert into account (accountID,subID,userID,Section,Date,Catalog,Detail,Money,Invoice,Image,ImageHost) VALUES('$row[0]','$row[1]','$row[2]','$row[3]','$row[4]','$row[5]','$row[6]','$row[7]','$row[8]','$row[9]','$row[10]')");		
	}
	mysql_query("delete from confirm where accountID='$accountID'");
	mysql_close($link);
	
	setcookie("upload_state","upload_success",time()+600);
	Header("Location: index.php");	
?>
</body>
</html>