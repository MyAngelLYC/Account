<?php
	$reservation=$_GET["reservation"];
  	$link=mysql_connect("localhost","root","123") or die("链接出错：".mysql_error());
  	mysql_select_db('Account');
	mysql_query("set names utf8");	
	mysql_query("update reservation set State='done' where Reservation='$reservation'"); 
	mysql_query("update account set State='done' where Reservation='$reservation'");	
	mysql_close($link);
	Header("Location: admin_reservation.php");
?>
