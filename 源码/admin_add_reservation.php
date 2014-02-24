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
	if(!strcmp($add_reservation,"empty"))
	{
		echo "<script language=javascript>alert('未选择要预约的项目!');</script>";
		setcookie("add_reservation","",time()+600); 
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
      <table width="80%" border="5" class="myBorder" bordercolor="#C3DFFF" frame="box">
        <tr bgcolor="#C3DFFF">
          <td align="middle" colspan="6"><font size="+1">请勾选要进行预约的项目</font></td>          
        </tr> 
        <tr bgcolor="#FFFEEC">
          <td align="center">选择</td>
          <td align="center">票据类型</td>
          <td align="center">序列单号</td>
          <td align="center">申请人</td>
          <td align="center">附件数量</td>
          <td align="center">报销金额</td>
         </tr>
         <form action="admin_fill_reservation.php" method="post">
          <?php
			 $link=mysql_connect("localhost","root","123") or die("链接出错：".mysql_error());
		  	 mysql_select_db('Account');
		     mysql_query("set names utf8");
			 $result_catalog = mysql_query("select name from catalog");
			 $count_catalog = mysql_num_rows($result_catalog);			
			 for($i=0;$i<$count_catalog;$i++)
			 {
				$row_catalog=mysql_fetch_row($result_catalog);
				
				$result=mysql_query("select accountID,userID,count(*),sum(Money*100)/100 from account where State='confirm' and catalog='".($i+1)."' group by accountID order by accountID");
				$count=mysql_num_rows($result);
				if(((int)$count)>0)
				{
					for($j=0;$j<$count;$j++)
					{
						$row=mysql_fetch_row($result);
						$result1=mysql_query("select Name from user where ID='$row[1]'");
				  		$row1=mysql_fetch_row($result1);
						echo "<tr>";
						echo "<td align='center'><input type='checkbox' name='chosen[]' value='".$row[0].($i+1)."'/></td>";				 
						echo "<td align='center'>$row_catalog[0]</td>";
						echo "<td align='center'>".$row[0]."</td>";
						echo "<td align='center'>".$row1[0]."</td>";
						echo "<td align='center'>".$row[2]."</td>";
						echo "<td align='center'>".$row[3]."</td>";
					}					
				}
			 }			 		
			 mysql_close($link);			
		  ?>
                  
        <tr>
          <td align="center" colspan="6">                    
          <input type="button" value="返回" onclick="window.location.href='admin_reservation.php'" />
          <input type="submit" value="确认" />          
          </td>
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
