<?php
	$id = $_GET["id"];
	$name = $_POST["name"];
	$project = $_POST["project"];
	if(!strcmp($id,"add"))
	{
		$link=mysql_connect("localhost","root","123") or die("链接出错：".mysql_error());
		mysql_select_db('Account');
		mysql_query("set names utf8");
		$result = mysql_query("select * from catalog");
		$count=mysql_num_rows($result)+1;
		mysql_query("insert into catalog (id,name,project) values('$count','$name','$project')");
		mysql_close($link);
	}
	else
	{
		$link=mysql_connect("localhost","root","123") or die("链接出错：".mysql_error());
		mysql_select_db('Account');
		mysql_query("set names utf8");
		mysql_query("update catalog set name='$name',project='$project' where id='$id'");
		mysql_close($link);
	}
  	
	setcookie("modify_system","modify_success",time()+600);
	Header("Location: admin_system.php");	
?>
