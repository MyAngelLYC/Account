<?php
	$userID = $_POST["ID"];
	$name = $_POST["name"];
	$telephone = $_POST["telephone"];
	$level = $_POST["level"];
	
  	$link=mysql_connect("localhost","root","123") or die("链接出错：".mysql_error());
  	mysql_select_db('Account');
	mysql_query("set names utf8");
	$result=mysql_query("select * from user where ID='$userID'");	
	$count=mysql_num_rows($result);	
	if(((int)$count)<=0)
	{
		$password = md5($userID);
		mysql_query("insert into user(ID,Name,Password,Level,Telephone) values('$userID','$name','$password','$level','$telephone')");
	}
	mysql_close($link);
	Header("Location: admin_user.php");	
?>
