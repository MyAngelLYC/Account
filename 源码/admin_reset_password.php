<?php
	$userID = $_GET["ID"];
  	$link=mysql_connect("localhost","root","123") or die("链接出错：".mysql_error());
  	mysql_select_db('Account');
	mysql_query("set names utf8");
	$password=md5($userID);
	mysql_query("update user set Password='$password' where ID='$userID'");  	
	mysql_close($link);
	setcookie("reset_password","success",time()+600);
	Header("Location: admin_user.php");
?>
