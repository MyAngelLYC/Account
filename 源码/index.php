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
	$uploadState = $_COOKIE["upload_state"];
	if(!strcmp($uploadState,"upload_success"))
	{
		echo "<script language=javascript>alert('保存成功!');</script>";
		setcookie("upload_state","",time()+600); 
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
      <table width="80%" border="5" class="myBorder" bordercolor="#C3DFFF" frame="box">
        <tr bgcolor="#C3DFFF">
          <td align="left" colspan="6">当前报销申请</td>
          <td align="right">
          <?php
		  	$accountID = date('Ym').$userID;
			$link=mysql_connect("localhost","root","123") or die("链接出错：".mysql_error());
			mysql_select_db('Account');
			mysql_query("set names utf8");
			$result=mysql_query("select count(*) from account where accountID='$accountID'");
			$row=mysql_fetch_row($result);
			$count=$row[0];
			if(((int)$count)<=0)
				echo "<a href='ywlist.php'><font size='-1'>申请报销</font></a>";
		  ?>
          </td>	
        </tr>
        <tr bgcolor="#FFFEEC">
          <td align="center">序列单号</td>
          <td align="center">报销阶段</td>
          <td align="center">填写时间</td>
          <td align="center">附件数量</td>
          <td align="center">报销金额</td>
          <td align="center">当前状态</td>
          <td align="center">相关操作</td>
        </tr>
        <tr>
        <?php
		  $result=mysql_query("select count(*) from account where accountID='$accountID' and State='unconfirm'");
		  $row=mysql_fetch_row($result);
		  $count=$row[0];		  
		  if(((int)$count)>0)
		  {	
		  	  $result=mysql_query("select Section,Date,sum(Money*100)/100 from account where accountID='$accountID' and State='unconfirm'");		  
			  $row=mysql_fetch_row($result);
			  echo "<td align='center'>".$accountID."</td>";
			  echo "<td align='center'>".$row[0]."</td>";
			  echo "<td align='center'>".$row[1]."</td>";
			  echo "<td align='center'>".$count."</td>";
			  echo "<td align='center'>".$row[2]."</td>";
			  echo "<td align='center'>待审核</td>";
			  echo "<td align='center'><a href='detail.php'>查看</a>&nbsp;&nbsp;<a href='delete.php'>删除</a></td>";
		  }
		?>  
        </tr>
      </table>
    </td>
  </tr>
  <tr>
  	<td height="50" colspan="3">
    </td>
  </tr>
  <tr>
  	<td width="1024" align="center" valign="middle" colspan="3">
      <table width="80%" border="5" class="myBorder" bordercolor="#C3DFFF" frame="box">
        <tr bgcolor="#C3DFFF">
          <td align="left" colspan="7">历史报销记录</td>          
        </tr>
        <tr bgcolor="#FFFEEC">
          <td align="center">序列单号</td>
          <td align="center">报销阶段</td>
          <td align="center">填写时间</td>
          <td align="center">附件数量</td>
          <td align="center">报销金额</td>
          <td align="center">当前状态</td>
          <td align="center">相关操作</td>
        </tr>
        <?php
		  $result=mysql_query("select DISTINCT(accountID) from account where userID='$userID' and State!='unconfirm' order by accountID desc");
		  $count=mysql_num_rows($result);
		  if(((int)$count)>0)
		  {
			  for($i=0;$i<$count;$i++)
			  {
				$row=mysql_fetch_row($result);
				$accountID=$row[0];
				$result1=mysql_query("select Section,Date,count(*),sum(Money*100)/100,State from account where accountID='$accountID'");
				$row1=mysql_fetch_row($result1);
				echo "<tr>";
				echo "<td align='center'>".$accountID."</td>";
				echo "<td align='center'>".$row1[0]."</td>";
				echo "<td align='center'>".$row1[1]."</td>";
				echo "<td align='center'>".$row1[2]."</td>";
				echo "<td align='center'>".$row1[3]."</td>";
				if(!strcmp($row1[4],"confirm")) echo "<td align='center'>已审核</td>";
				else if(!strcmp($row1[4],"finish")) echo "<td align='center'>已预约</td>";
				else if(!strcmp($row1[4],"done")) echo "<td align='center'>已入帐</td>";
				echo "<td align='center'>无</td>";
				echo "</tr>";				
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
