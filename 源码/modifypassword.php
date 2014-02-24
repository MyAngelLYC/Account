<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php 
if($_COOKIE["usercheck"]!="login_success")
{	
	Header("Location: login.php");
}
else
{
	$userID = $_COOKIE["userID"];
	$username = $_COOKIE["username"];
	$userLevel = $_COOKIE["userLevel"];
	
	$modifyPassword = $_COOKIE["modifyPassword"];
	if(!strcmp($modifyPassword,"wrongPassword"))
	{
		echo "<script language=javascript>alert('原密码错误!');</script>";
		setcookie("modifyPassword","",time()+600); 
	}
	else if(!strcmp($modifyPassword,"nullPassword"))
	{
		echo "<script language=javascript>alert('设置密码不能为空!');</script>";
		setcookie("modifyPassword","",time()+600); 
	}
	else if(!strcmp($modifyPassword,"wrongConfirmPassword"))
	{
		echo "<script language=javascript>alert('设定密码与确认密码不一致!');</script>";
		setcookie("modifyPassword","",time()+600); 
	}
	else if(!strcmp($modifyPassword,"success"))
	{
		echo "<script language=javascript>alert('设置成功!');</script>";
		setcookie("modifyPassword","",time()+600); 
	}
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>课题组报销系统</title>
<style type="text/css">
.myBorder
{
	border-collapse:collapse;	
}
</style>
</head>

<body>
<table width="1024" border="0" align="center" cellspacing="0">
  <tr>
  	<td align="center" colspan="3"><font size="+6">欢迎使用课题组内部报销系统</font></td>
  </tr>
  <tr>
  	<td align="center" colspan="3">
    <HR style="FILTER: alpha(opacity=100,finishopacity=0,style=2)" width="100%" color=#987cb9 SIZE=10>
    </td>
  </tr>   
  <tr>
  	<td align="right"><?php echo "一卡通号：".$userID?></td>
    <td align="right" width="150"><?php echo "姓名：".$username?></td>
    
    <?php
		if(!strcmp($userLevel,"root"))
		{	
			echo "<td align='right' width='250'>";
			echo "<a href='admin_index.php'>管理</a>&nbsp;";
		}
		else
		{
			echo "<td align='right' width='200'>";
		}
	?>
    <a href="modifypassword.php">修改密码</a>&nbsp;
    <a href="logout.php">退出系统</a>
    </td>
  </tr>
  <tr>
  	<td align="center" colspan="3">
    <HR style="FILTER: alpha(opacity=100,finishopacity=0,style=3)" width="100%" color=#987cb9 SIZE=2>
    </td>
  </tr> 
  <tr>
  	<td width="1024" align="center" valign="middle" colspan="3">
      <table width="40%" border="5" class="myBorder" bordercolor="#C3DFFF" frame="box">
      	<form action="modifypassword_check.php" method="post">
        <tr bgcolor="#C3DFFF">
          <td align="center" colspan="2"><font size="+1">修改密码</font></td>          
        </tr>
        <tr bgcolor="#FFFEEC">
          <td align="right" width="40%">原始密码：</td>
          <td align="left"><input type="password" name="oldpassword"/></td>
        </tr> 
        <tr bgcolor="#FFFEEC">
          <td align="right" width="40%">新设密码：</td>
          <td align="left"><input type="password" name="newpassword"/></td>
        </tr>
        <tr bgcolor="#FFFEEC">
          <td align="right" width="40%">确认密码：</td>
          <td align="left"><input type="password" name="confirmpassword"/></td>
        </tr>
        <tr bgcolor="#FFFEEC">          
          <td align="center" colspan="2">
          <input type="button" value="取消" onclick="window.location.href='index.php'"/>
          &nbsp;<input type="submit" value="确定"/>
          </td>
        </tr>       
      </table>
      </form>
    </td>
  </tr>  
  <tr>
  	<td align="center" colspan="3">
    <HR style="FILTER: alpha(opacity=100,finishopacity=0,style=3)" width="100%" color=#987cb9 SIZE=2>
    </td>
  </tr>
 <tr>
  	<td width="1024" align="center" valign="middle" colspan="3">
    <font face="Arial, Verdana, Helvetica, sans-serif">Copyright © 
    <?php
	  echo date("Y");
	?>
    </font>
    </td>
  </tr>
  <tr>
    <td width="1024" align="center" valign="middle" colspan="3">
    <font face="Arial, Verdana, Helvetica, sans-serif">Powered by <b>
    <?php
	  $link=mysql_connect("localhost","root","123") or die("链接出错：".mysql_error());
	  mysql_select_db('Account');
	  mysql_query("set names utf8");	  
	  $result = mysql_query("select Keyvalue from system where Keyname='作者信息'");
	  $row = mysql_fetch_row($result);
	  echo $row[0];
	  mysql_close($link); 
	?>
    </b> @ NCRL</font>
    </td>
  </tr>
</table>

</body>
</html>
