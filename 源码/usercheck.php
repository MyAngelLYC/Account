<?php
  $username = $_POST[username];
  $password = $_POST[password];
  $password = md5($password);
  if($username=="")  setcookie("usercheck","username_empty",time()+600);
  else if($password=="")  setcookie("usercheck","password_empty",time()+600);  
  else
  {
	  $link=mysql_connect("localhost","root","123") or die("链接出错：".mysql_error());
	  mysql_select_db('Account');
	  mysql_query("set names utf8");	  
	  $result = mysql_query("select * from user where ID='".$username."'");
	  $row=mysql_fetch_row($result);
	  if($row[0]!=$username) setcookie("usercheck","nosuchuser",time()+600);
	  else if($row[2]==$password)
	  {
	  	setcookie("usercheck","login_success",time()+3600);
		setcookie("userID",$username,time()+3600);
	  	setcookie("username",$row[1],time()+3600);
		setcookie("userLevel",$row[3],time()+3600);
		setcookie("userTele",$row[4],time()+3600);
	  }
	  else setcookie("usercheck","password_error",time()+600);	  
      mysql_free_result($result);
      mysql_close($link);
  }	

  setcookie("from_usercheck","true",time()+600);
  Header("Location: index.php");  
?>
