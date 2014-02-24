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
	$reset_password = $_COOKIE["reset_password"];
	if(!strcmp($userLevel,"user"))
		Header("Location: index.php");
	else if(!strcmp($reset_password,"success"))
	{
		setcookie("reset_password","",time()+600);
		echo "<script language=javascript>alert('重置密码成功!');</script>";
	}
	 	
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>课题组报销系统-管理页面</title>
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
    <td align='right' width='150'><a href='index.php'>返回</a>&nbsp;
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
      <table width="100%" border="1" class="myBorder" bordercolor="#C3DFFF" frame="box">
        <tr bgcolor="#C3DFFF">
          <td align="center"><a href="admin_user.php">用户管理</a></td>
          <td align="center"><a href="admin_account.php">申请管理</a></td>
          <td align="center"><a href="admin_system.php">系统管理</a></td>
          <td align="center"><a href="admin_statistics.php">账目统计</a></td>
          <td align="center"><a href="admin_reservation.php">预约管理</a></td>
          <td align="center"><a href="admin_project.php">项目导出</a></td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
  	<td align="center" colspan="3">
    <HR style="FILTER: alpha(opacity=100,finishopacity=0,style=3)" width="100%" color=#987cb9 SIZE=2>
    </td>
  </tr>
  <tr>
  	<td width="1024" align="center" valign="middle" colspan="3">
      <table width="80%" border="1" class="myBorder" bordercolor="#C3DFFF" frame="box">
        <tr bgcolor="#C3DFFF">
          <td align="center" colspan="6"><font size="+1">用户列表</font></td>
        </tr>
        <tr bgcolor="#FFFEEC">
          <td align="center">序号</td>
          <td align="center">一卡通</td>
          <td align="center">姓名</td>
          <td align="center">联系方式</td>
          <td align="center">用户等级</td>
          <td align="center">相关操作</td>
        </tr>
        <?php
		  $link=mysql_connect("localhost","root","123") or die("链接出错：".mysql_error());
		  mysql_select_db('Account');
		  mysql_query("set names utf8");
		  $result=mysql_query("select * from user order by Level,ID");
		  $count=mysql_num_rows($result);
		  for($i=0;$i<$count;$i++)
		  {
			  $row=mysql_fetch_row($result);
			  echo "<tr>";
			  echo "<td align='center'>".($i+1)."</td>";
			  echo "<td align='center'>".$row[0]."</td>";
			  echo "<td align='center'>".$row[1]."</td>";
			  echo "<td align='center'>".$row[4]."</td>";
			  if(!strcmp($row[3],"root"))
			  	echo "<td align='center'>系统管理员</td>";
			  else echo "<td align='center'>普通用户</td>";
			  echo "<td align='center'><a href='admin_delete_user.php?ID=".$row[0]."'>删除</a>&nbsp;<a href='admin_reset_password.php?ID=".$row[0]."'>重置密码</a></td>";
			  echo "</tr>";
		  }
		?>
        <form action="admin_add_user.php" method="post">
        <tr>
          <td align="center">*</td>
          <td align="center"><input type="text" size="9" width="9" name="ID" /></td>
          <td align="center"><input type="text" size="5" width="5" name="name" /></td>
          <td align="center"><input type="text" size="11" width="11" name="telephone" /></td>
          <td align="center">
          <select name="level" >
          	<option value="user" selected="selected">普通用户</option>
            <option value="root">系统管理员</option>
          </select>
          </td>
          <td align="center"><input type="reset" value="重置" />&nbsp;
          <input type="submit" value="添加" /></td>
        </tr>
        </form>
      </table>
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
