<?php
	$reservation=$_GET["reservation"];
	$project=$_GET["project"];
	$date=date("Y-m-d");
  	$link=mysql_connect("localhost","root","123") or die("链接出错：".mysql_error());
  	mysql_select_db('Account');
	mysql_query("set names utf8");	
	mysql_query("insert into reservation (Reservation,Project,Date) values('$reservation','$project','$date')");
	
	$result=mysql_query("select * from reservation_confirm");
	$count=mysql_num_rows($result);
	for($i=0;$i<$count;$i++)
	{
		$row=mysql_fetch_row($result);
		mysql_query("update account set State='finish',Reservation='$reservation' where accountID='$row[0]' and Catalog='$row[1]'");
	}
	mysql_query("delete from reservation_confirm");
	mysql_close($link);
	setcookie("add_reservation","success",time()+600);
	Header("Location: admin_reservation.php");
?>
