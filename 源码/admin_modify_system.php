<?php
	$Keyname = $_POST["key"];
	$Keyvalue = $_POST["value"];
	
  	$link=mysql_connect("localhost","root","123") or die("链接出错：".mysql_error());
  	mysql_select_db('Account');
	mysql_query("set names utf8");
	mysql_query("update system set Keyvalue='$Keyvalue' where Keyname='$Keyname'");	
	
	mysql_close($link);
	setcookie("modify_system","modify_success",time()+600);
	Header("Location: admin_system.php");	
?>
