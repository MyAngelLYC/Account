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
	$listMode = $_GET["listMode"];
	if(!strcmp($listMode,""))
		$listMode="all";	
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
          <td align="center" colspan="7"><font size="+1">报销申请列表</font>
          <select onchange="
          if(this.options[this.selectedIndex].value=='all') window.location.href='admin_account.php?listMode=all';
          else if(this.options[this.selectedIndex].value=='unconfirm') window.location.href='admin_account.php?listMode=unconfirm';
          else if(this.options[this.selectedIndex].value=='confirm') window.location.href='admin_account.php?listMode=confirm';
          else if(this.options[this.selectedIndex].value=='finish') window.location.href='admin_account.php?listMode=finish';
          else if(this.options[this.selectedIndex].value=='done') window.location.href='admin_account.php?listMode=done'; ">
          <option value="all" <?php if(!strcmp($listMode,"all")) echo "selected='selected'";?> >查看全部</option>
          <option value="unconfirm" <?php if(!strcmp($listMode,"unconfirm")) echo "selected='selected'";?> >待审核</option>
          <option value="confirm" <?php if(!strcmp($listMode,"confirm")) echo "selected='selected'";?> >已审核</option>
          <option value="finish" <?php if(!strcmp($listMode,"finish")) echo "selected='selected'";?> >已预约</option>
          <option value="done" <?php if(!strcmp($listMode,"done")) echo "selected='selected'";?> >已入账</option>
          </select>
          </td>
        </tr>
        <tr bgcolor="#FFFEEC">
          <td align="center">序列单号</td>
          <td align="center">申请人</td>
          <td align="center">报销阶段</td>
          <td align="center">附件数量</td>
          <td align="center">报销金额</td>
          <td align="center">当前状态</td>
          <td align="center">相关操作</td>
        </tr>
        <?php
		  $link=mysql_connect("localhost","root","123") or die("链接出错：".mysql_error());
		  mysql_select_db('Account');
		  mysql_query("set names utf8");
		  		
		  if(!strcmp($listMode,"all"))
		  {
			$result=mysql_query("select DISTINCT(accountID) from account order by accountID desc");
			$count=mysql_num_rows($result);
			if(((int)$count)>0)
			{
				for($i=0;$i<$count;$i++)
				{
				  $row=mysql_fetch_row($result);
				  $accountID=$row[0];
				  $result1=mysql_query("select userID,Section,count(*),sum(Money*100)/100,State from account where accountID='$accountID'");
				  $row1=mysql_fetch_row($result1);
				  $result1=mysql_query("select Name from user where ID='$row1[0]'");
				  $row2=mysql_fetch_row($result1);
				  echo "<tr>";				 
				  echo "<td align='center'>".$accountID."</td>";
				  echo "<td align='center'>".$row2[0]."</td>";
				  echo "<td align='center'>".$row1[1]."</td>";
				  echo "<td align='center'>".$row1[2]."</td>";
				  echo "<td align='center'>".$row1[3]."</td>";
				  if(!strcmp($row1[4],"unconfirm")) echo "<td align='center'>待审核</td>";
				  else if(!strcmp($row1[4],"confirm")) echo "<td align='center'>已审核</td>";
				  else if(!strcmp($row1[4],"finish")) echo "<td align='center'>已预约</td>";
				  else if(!strcmp($row1[4],"done")) echo "<td align='center'>已入账</td>";
				  echo "<td align='center'><a href='admin_detail.php?listMode=all&accountID=".$accountID."'>查看</a></td>";
				  echo "</tr>";				
				}				
			}
		  }
		  else if(!strcmp($listMode,"finish"))
		  {
			$result=mysql_query("select DISTINCT(accountID) from account where State='finish' order by accountID desc");
			$count=mysql_num_rows($result);
			if(((int)$count)>0)
			{
				for($i=0;$i<$count;$i++)
				{
				  $row=mysql_fetch_row($result);
				  $accountID=$row[0];
				  $result1=mysql_query("select userID,Section,count(*),sum(Money*100)/100 from account where accountID='$accountID'");
				  $row1=mysql_fetch_row($result1);
				  $result1=mysql_query("select Name from user where ID='$row1[0]'");
				  $row2=mysql_fetch_row($result1);
				  echo "<tr>";				 
				  echo "<td align='center'>".$accountID."</td>";
				  echo "<td align='center'>".$row2[0]."</td>";
				  echo "<td align='center'>".$row1[1]."</td>";
				  echo "<td align='center'>".$row1[2]."</td>";
				  echo "<td align='center'>".$row1[3]."</td>";
				  echo "<td align='center'>已预约</td>";				  
				  echo "<td align='center'><a href='admin_detail.php?listMode=finish&accountID=".$accountID."'>查看</a></td>";
				  echo "</tr>";				
				}				
			}
		  }
		  else if(!strcmp($listMode,"confirm"))
		  {
			$result=mysql_query("select DISTINCT(accountID) from account where State='confirm' order by accountID desc");
			$count=mysql_num_rows($result);
			if(((int)$count)>0)
			{
				for($i=0;$i<$count;$i++)
				{
				  $row=mysql_fetch_row($result);
				  $accountID=$row[0];
				  $result1=mysql_query("select userID,Section,count(*),sum(Money*100)/100 from account where accountID='$accountID'");
				  $row1=mysql_fetch_row($result1);
				  $result1=mysql_query("select Name from user where ID='$row1[0]'");
				  $row2=mysql_fetch_row($result1);
				  echo "<tr>";				 
				  echo "<td align='center'>".$accountID."</td>";
				  echo "<td align='center'>".$row2[0]."</td>";
				  echo "<td align='center'>".$row1[1]."</td>";
				  echo "<td align='center'>".$row1[2]."</td>";
				  echo "<td align='center'>".$row1[3]."</td>";
				  echo "<td align='center'>已审核</td>";				  
				  echo "<td align='center'><a href='admin_detail.php?listMode=confirm&accountID=".$accountID."'>查看</a></td>";
				  echo "</tr>";				
				}				
			}
		  }
		  else if(!strcmp($listMode,"unconfirm"))
		  {
			$result=mysql_query("select DISTINCT(accountID) from account where State='unconfirm' order by accountID desc");
			$count=mysql_num_rows($result);
			if(((int)$count)>0)
			{
				for($i=0;$i<$count;$i++)
				{
				  $row=mysql_fetch_row($result);
				  $accountID=$row[0];
				  $result1=mysql_query("select userID,Section,count(*),sum(Money*100)/100 from account where accountID='$accountID'");
				  $row1=mysql_fetch_row($result1);
				  $result1=mysql_query("select Name from user where ID='$row1[0]'");
				  $row2=mysql_fetch_row($result1);
				  echo "<tr>";				 
				  echo "<td align='center'>".$accountID."</td>";
				  echo "<td align='center'>".$row2[0]."</td>";
				  echo "<td align='center'>".$row1[1]."</td>";
				  echo "<td align='center'>".$row1[2]."</td>";
				  echo "<td align='center'>".$row1[3]."</td>";
				  echo "<td align='center'>待审核</td>";				  
				  echo "<td align='center'><a href='admin_detail.php?listMode=unconfirm&accountID=".$accountID."'>查看</a></td>";
				  echo "</tr>";				
				}				
			}			
		  }
		  else if(!strcmp($listMode,"done"))
		  {
			$result=mysql_query("select DISTINCT(accountID) from account where State='done' order by accountID desc");
			$count=mysql_num_rows($result);
			if(((int)$count)>0)
			{
				for($i=0;$i<$count;$i++)
				{
				  $row=mysql_fetch_row($result);
				  $accountID=$row[0];
				  $result1=mysql_query("select userID,Section,count(*),sum(Money*100)/100 from account where accountID='$accountID'");
				  $row1=mysql_fetch_row($result1);
				  $result1=mysql_query("select Name from user where ID='$row1[0]'");
				  $row2=mysql_fetch_row($result1);
				  echo "<tr>";				 
				  echo "<td align='center'>".$accountID."</td>";
				  echo "<td align='center'>".$row2[0]."</td>";
				  echo "<td align='center'>".$row1[1]."</td>";
				  echo "<td align='center'>".$row1[2]."</td>";
				  echo "<td align='center'>".$row1[3]."</td>";
				  echo "<td align='center'>已入账</td>";				  
				  echo "<td align='center'><a href='admin_detail.php?listMode=done&accountID=".$accountID."'>查看</a></td>";
				  echo "</tr>";				
				}				
			}			
		  }
		  mysql_close($link);
		?>
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
