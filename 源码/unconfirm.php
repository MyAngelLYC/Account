<?php
  $userID = $_COOKIE["userID"];
  $accountID = date('Ym').$userID;
  $link=mysql_connect("localhost","root","123") or die("链接出错：".mysql_error());
  mysql_select_db('Account');
  mysql_query("set names utf8");  
  $result=mysql_query("select count(*) from confirm where accountID='$accountID'");
  $row=mysql_fetch_row($result);
  $count=$row[0];
  $result=mysql_query("select ImageHost from confirm where accountID='$accountID'");
  for($i=0;$i<$count;$i++)
  {	 
  	$row=mysql_fetch_row($result);
  	unlink($row[0]); 
  }
  mysql_query("delete from confirm where accountID='$accountID'");
  mysql_close($link);
  Header("Location: index.php");  
?>
