<?php
  $userID = $_COOKIE["userID"];
  $oldpassword = md5($_POST[oldpassword]);
  $newpassword = $_POST[newpassword];
  $newpassword_md5 = md5($newpassword);
  $confirmpassword = md5($_POST[confirmpassword]);
  
  $link=mysql_connect("localhost","root","123") or die("链接出错：".mysql_error());
  mysql_select_db('Account');
  mysql_query("set names utf8");	  
  $result = mysql_query("select Password from user where ID='$userID'");
  $row=mysql_fetch_row($result);
  if($row[0]!=$oldpassword) setcookie("modifyPassword","wrongPassword",time()+600);
  else if($newpassword=="") setcookie("modifyPassword","nullPassword",time()+600);
  else if($newpassword_md5!=$confirmpassword) setcookie("modifyPassword","wrongConfirmPassword",time()+600);
  else
  {
	  setcookie("modifyPassword","success",time()+600);
	  mysql_query("update user set Password='$confirmpassword' where ID='$userID'");
  } 
  mysql_free_result($result);
  mysql_close($link);
  
  Header("Location: modifypassword.php"); 
?>
