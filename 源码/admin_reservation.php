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
	if(!strcmp($userLevel,"user"))
		Header("Location: index.php");
	$add_reservation=$_COOKIE["add_reservation"];
	if(!strcmp($add_reservation,"success"))
	{
		setcookie("add_reservation","",time()+600);
		echo "<script language=javascript>alert('新增预约成功!');</script>";
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
          <td align="center" colspan="7"><font size="+1">预约管理</font></td>
        </tr>
        <tr bgcolor="#FFFEEC">
          <td align="center">预约单号</td>
          <td align="center">报销项目号</td>
          <td align="center">预约日期</td>
          <td align="center">附件数量</td>
          <td align="center">报销金额</td>
          <td align="center">当前状态</td>
          <td align="center">相关操作</td>
        </tr>
        <?php
			$link=mysql_connect("localhost","root","123") or die("链接出错：".mysql_error());
		  	mysql_select_db('Account');
		    mysql_query("set names utf8");
			$result=mysql_query("select * from reservation");
			$count=mysql_num_rows($result);
			if(((int)$count)>0)
			{
				for($i=0;$i<$count;$i++)
				{
					$row=mysql_fetch_row($result);
					$result2=mysql_query("select count(*),sum(Money*100)/100 from account where Reservation='$row[0]'");
					$row2=mysql_fetch_row($result2);
					echo "<tr>";
					echo "<td align='center'>$row[0]</td>";
					echo "<td align='center'>$row[1]</td>";
					echo "<td align='center'>$row[2]</td>";
					echo "<td align='center'>$row2[0]</td>";
					echo "<td align='center'>$row2[1]</td>";
					if(!strcmp($row[3],"reserving"))
						echo "<td align='center'>预约中</td>";
					else echo "<td align='center'>已入帐</td>";
					echo "<td align='center'><a href='admin_reservation_detail.php?reservation=".$row[0]."'>查看</a></td>";
					echo "</tr>";					
				}
			}
		?>
        <tr>
          <td align="center" colspan="7">                    
          <input type="button" value="新增预约" onclick="window.location.href='admin_add_reservation.php'" />          
          </td>
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
