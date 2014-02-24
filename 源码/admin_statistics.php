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
	$section = $_GET["section"];
	if(!strcmp($section,""))
	{
		$section=date("Y.m");
		Header("Location: admin_statistics.php?section=".$section);
	}
	$listMode = $_GET["listMode"];
	if(!strcmp($listMode,"")) $listMode="catalog";
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
<script type="text/javascript">
function onSelectChange(section)
{
	var str="admin_statistics.php?section="+section+"&listMode=<?php echo $listMode; ?>"; 
	window.location.href=str;
}
function onRadioChange(listMode)
{
	var str="admin_statistics.php?section=<?php echo $section; ?>"+"&listMode="+listMode; 
	window.location.href=str;
}
</script>
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
      <table width="80%" border="2" class="myBorder" bordercolor="#C3DFFF" frame="box">
        <tr bgcolor="#C3DFFF">
          <td align="center" colspan="6"><font size="+1">账目统计列表</font>
          <select onchange="onSelectChange(this.options[this.selectedIndex].value)">
          <?php
		  	$link=mysql_connect("localhost","root","123") or die("链接出错：".mysql_error());
		  	mysql_select_db('Account');
		    mysql_query("set names utf8");
			$result=mysql_query("select Keyvalue from system where Keyname='系统起始时间'");
			$row=mysql_fetch_row($result);
			$date=str_replace("-","",$row[0]);
			$date=str_split($date,4);
			$year_old=(int)$date[0];
			$month_old=(int)$date[1];
			$year_now=(int)date('Y');
			$month_now=(int)date('m');
			if($year_old<$year_now)
			  for($i=$year_old;$i<$year_now;$i++)
			  {
				  for($j=$month_old;$j<=12;$j++)
				  {
					  if($j<10)
					  {
						echo "<option value='".$i.".0".$j."' ";
						if(!strcmp($section,$i.".0".$j)) echo "selected='selected'";
						echo ">".$i."-0".$j."</option>";
					  }
					  else
					  {
						echo "<option value='".$i.".".$j."' ";
						if(!strcmp($section,$i.".".$j)) echo "selected='selected'";
						echo ">".$i."-".$j."</option>";
					  }
				  }
			  }
			for($j=1;$j<=$month_now;$j++)
			{
				if($j<10)
				{
				  echo "<option value='".$year_now.".0".$j."' ";
				  if(!strcmp($section,$year_now.".0".$j)) echo "selected='selected'";
				  echo ">".$year_now."-0".$j."</option>";
				}
				else
				{
				  echo "<option value='".$year_now.".".$j."' ";
				  if(!strcmp($section,$year_now.".".$j)) echo "selected='selected'";
				  echo ">".$year_now."-".$j."</option>";
				}
			} 
		  ?>          
          </select>
          <input type="radio" name="listMode" onclick="onRadioChange(this.value)" value="catalog" <?php if(!strcmp($listMode,"catalog")) echo "checked='checked'"; ?>/>按票据类型
          <input type="radio" name="listMode" onclick="onRadioChange(this.value)" value="user" <?php if(!strcmp($listMode,"user")) echo "checked='checked'"; ?>/>按申请人
          </td>
        </tr>
        <tr bgcolor="#FFFEEC">
          <td align="center"><?php if(!strcmp($listMode,"catalog")) echo "票据类型"; else echo "序列单号"; ?></td>
          <td align="center"><?php if(!strcmp($listMode,"catalog")) echo "序列单号"; else echo "申请人"; ?></td>
          <td align="center"><?php if(!strcmp($listMode,"catalog")) echo "申请人"; else echo "填写时间"; ?></td>
          <td align="center">附件数量</td>
          <td align="center">报销金额</td>
          <td align="center">当前状态</td>
        </tr>
        <?php
		  if(!strcmp($listMode,"catalog"))
		  {
			 $number_total=0;
			 $money_total=0;
			 $link=mysql_connect("localhost","root","123") or die("链接出错：".mysql_error());
		  	 mysql_select_db('Account');
		     mysql_query("set names utf8");
			 $result_catalog = mysql_query("select name from catalog");
			 $count_catalog = mysql_num_rows($result_catalog);			
			 for($i=0;$i<$count_catalog;$i++)
			 {
				$row_catalog=mysql_fetch_row($result_catalog);
				
				$result=mysql_query("select accountID,userID,count(*),sum(Money*100)/100,State from account where Section='$section' and catalog='".($i+1)."' group by accountID order by accountID");
				$count=mysql_num_rows($result);
				if(((int)$count)>0)
				{
					echo "<tr height='2' bgcolor='#C3DFFF'>";				 
					echo "<td align='center' colspan='6'></td>";					
					echo "</tr>";
					$number=0;
					$money=0;
					for($j=0;$j<$count;$j++)
					{
						$row=mysql_fetch_row($result);
						$result1=mysql_query("select Name from user where ID='$row[1]'");
				  		$row1=mysql_fetch_row($result1);
						echo "<tr>";				 
						echo "<td align='center'>$row_catalog[0]</td>";
						echo "<td align='center'>".$row[0]."</td>";
						echo "<td align='center'>".$row1[0]."</td>";
						echo "<td align='center'>".$row[2]."</td>";
						echo "<td align='center'>".$row[3]."</td>";
						if(!strcmp($row[4],"unconfirm")) echo "<td align='center'>待审核</td>";
						else if(!strcmp($row[4],"confirm")) echo "<td align='center'>已审核</td>";
						else if(!strcmp($row[4],"finish")) echo "<td align='center'>已预约</td>";
						else if(!strcmp($row[4],"done")) echo "<td align='center'>已入账</td>";					
						echo "</tr>";
						$number+=$row[2];
						$money+=$row[3];
					}
					echo "<tr>";				 
					echo "<td align='center'></td>";
					echo "<td align='center'>总计</td>";
					echo "<td align='center'></td>";
					echo "<td align='center'>".$number."</td>";
					echo "<td align='center'>".$money."</td>";
					echo "<td align='center'></td>";					
					echo "</tr>";
					$number_total+=$number;
					$money_total+=$money;
				}
			 }
			 echo "<tr height='2' bgcolor='#C3DFFF'>";				 
			 echo "<td align='center' colspan='6'></td>";					
			 echo "</tr>";
			 
			 echo "<tr>";
			 echo "<td align='center' colspan='3'>合计</td>";
			 echo "<td align='center'>".$number_total."</td>";
			 echo "<td align='center'>".$money_total."</td>";
			 echo "<td align='center'></td>";					
			 echo "</tr>";			
			 mysql_close($link);
		  }
		  else
		  {
			  $number_total=0;
			  $money_total=0;
			  $link=mysql_connect("localhost","root","123") or die("链接出错：".mysql_error());
		  	  mysql_select_db('Account');
		      mysql_query("set names utf8");
			  $result=mysql_query("select accountID,userID,Date,count(*),sum(Money*100)/100,State from account where Section='$section' group by accountID order by accountID");
			  $count=mysql_num_rows($result);
			  if(((int)$count)>0)
			  {
				  for($i=0;$i<$count;$i++)
				  {
					  $row=mysql_fetch_row($result);
					  $result1=mysql_query("select Name from user where ID='$row[1]'");
					  $row1=mysql_fetch_row($result1);
					  echo "<tr>";
					  echo "<td align='center'>".$row[0]."</td>";
					  echo "<td align='center'>".$row1[0]."</td>";
					  echo "<td align='center'>".$row[2]."</td>";
					  echo "<td align='center'>".$row[3]."</td>";
					  echo "<td align='center'>".$row[4]."</td>";
					  if(!strcmp($row[5],"unconfirm")) echo "<td align='center'>待审核</td>";
					  else if(!strcmp($row[5],"confirm")) echo "<td align='center'>已审核</td>";
					  else if(!strcmp($row[5],"finish")) echo "<td align='center'>已预约</td>";
					  else if(!strcmp($row[5],"done")) echo "<td align='center'>已入账</td>";					
					  echo "</tr>";
					  $number_total+=$row[3];
					  $money_total+=$row[4];
				  }
				  echo "<tr height='2' bgcolor='#C3DFFF'>";				 
			 	  echo "<td align='center' colspan='6'></td>";					
			 	  echo "</tr>";
			 
				  echo "<tr>";
				  echo "<td align='center' colspan='3'>合计</td>";
				  echo "<td align='center'>".$number_total."</td>";
				  echo "<td align='center'>".$money_total."</td>";
				  echo "<td align='center'></td>";					
				  echo "</tr>";
			  }
			  mysql_close($link);
		  }
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
