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
	$reservation = $_POST["reservation"];
	$project = $_POST["project"];
	$link=mysql_connect("localhost","root","123") or die("链接出错：".mysql_error());
	mysql_select_db('Account');
	mysql_query("set names utf8");
	$result=mysql_query("select * from reservation_confirm");
	$count=mysql_num_rows($result);
	mysql_close($link);	
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
          <td align="middle" colspan="5"><font size="+1">请核对预约信息</font></td>          
        </tr>
        <tr  bgcolor="#FFFEEC">
          <td align="center" colspan="5">                    
          	<table width="100%" border="1" class="myBorder" bordercolor="#C3DFFF">
            	<tr>
                	<td align="left" width="50%">预约单号：<?php echo $reservation; ?></td>
                    <td align="left" width="50%">报销项目号：<?php echo $project; ?></td>
                 </tr>
            </table>         
          </td>
        </tr> 
        <tr bgcolor="#FFFEEC">          
          <td align="center">票据类型</td>
          <td align="center">序列单号</td>
          <td align="center">申请人</td>
          <td align="center">附件数量</td>
          <td align="center">报销金额</td>
         </tr>         
          <?php
			 $number_total=0;
			 $money_total=0;
			 $link=mysql_connect("localhost","root","123") or die("链接出错：".mysql_error());
		  	 mysql_select_db('Account');
		     mysql_query("set names utf8");
			 $result_catalog = mysql_query("select name from catalog");
			 $count_catalog = mysql_num_rows($result_catalog);			
			 for($i=0;$i<$count_catalog;$i++)
			 {
				$number=0;
				$money=0;
				
				$row_catalog=mysql_fetch_row($result_catalog);
				
				$result_reservation=mysql_query("select accountID from reservation_confirm where catalog='".($i+1)."'");
				$count_reservation=mysql_num_rows($result_reservation);
				if(((int)$count_reservation)>0)
				{
				  for($j=0;$j<$count_reservation;$j++)
				  {
					$row_reservation=mysql_fetch_row($result_reservation);
					
					$result=mysql_query("select accountID,userID,count(*),sum(Money*100)/100 from account where accountID='$row_reservation[0]' and catalog='".($i+1)."' group by accountID order by accountID");
					$row=mysql_fetch_row($result);
					$result1=mysql_query("select Name from user where ID='$row[1]'");
					$row1=mysql_fetch_row($result1);
					echo "<tr>";				 
					echo "<td align='center'>$row_catalog[0]</td>";
					echo "<td align='center'>".$row[0]."</td>";
					echo "<td align='center'>".$row1[0]."</td>";
					echo "<td align='center'>".$row[2]."</td>";
					echo "<td align='center'>".$row[3]."</td>";
					$number+=$row[2];
					$money+=$row[3];
				  }
				  echo "<tr>";				 
				  echo "<td align='center'></td>";
				  echo "<td align='center'>总计</td>";
				  echo "<td align='center'></td>";
				  echo "<td align='center'>".$number."</td>";
				  echo "<td align='center'>".$money."</td>";		
				  echo "</tr>";
				  $number_total+=$number;
				  $money_total+=$money;
				  echo "<tr height='2' bgcolor='#C3DFFF'>";				 
				  echo "<td align='center' colspan='5'></td>";					
				  echo "</tr>";
				}				
			 }
			 
			 
			 echo "<tr>";
			 echo "<td align='center' colspan='3'>合计</td>";
			 echo "<td align='center'>".$number_total."</td>";
			 echo "<td align='center'>".$money_total."</td>";
			 echo "</tr>";			
			 mysql_close($link);			
		  ?>                  
        <tr>
          <td align="center" colspan="5">                    
          <input type="button" value="取消" onclick="window.location.href='admin_add_reservation.php'" />
          <input type="button" value="确认" onclick="window.location.href='admin_finish_reservation.php?reservation=<?php echo $reservation;?>&project=<?php echo $project;?>'" />         
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
