<?php
	$userID = $_GET["ID"];
  	$link=mysql_connect("localhost","root","123") or die("链接出错：".mysql_error());
  	mysql_select_db('Account');
	mysql_query("set names utf8");
	mysql_query("delete from user where ID='$userID'");  	
	mysql_close($link);
	Header("Location: admin_user.php");
?>
