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
	$accountID = $_GET["accountID"];
	$link=mysql_connect("localhost","root","123") or die("链接出错：".mysql_error());
	mysql_select_db('Account');
	mysql_query("set names utf8");
	$result=mysql_query("select Section,Date,userID,State from account where accountID='$accountID'");
	$row=mysql_fetch_row($result);
	$Section=$row[0];
	$Date=$row[1];
	$userID2=$row[2];
	$state=$row[3];
	$result=mysql_query("select Name,Telephone from user where ID='$userID2'");
	$row=mysql_fetch_row($result);
	$username2=$row[0];
	$telephone2=$row[1];	
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
          <td align="middle">报销申请详情</td>          
        </tr>        
        <tr bgcolor="#FFFEEC">
          <td>
            <table width="100%" border="1" class="myBorder" bordercolor="#C3DFFF">
              <tr>
                <td>
				<?php 
					echo "序列单号：".$accountID;
					if(!strcmp($state,"unconfirm"))
						echo "(待审核)";
					else if(!strcmp($state,"confirm"))
						echo "(已审核)";
					else if(!strcmp($state,"finish"))
						echo "(已预约)"; 
					else echo "(已入账)";
				?>
                </td>
                <td><?php echo "报销阶段：".$Section;?></td>
                <td><?php echo "填写时间：".$Date;?></td>
              </tr>
              <tr>
                <td><?php echo "申请人：".$username2;?></td>
                <td><?php echo "一卡通号：".$userID2;?></td>
                <td><?php echo "联系方式：".$telephone2;?></td>
              </tr>
            </table>
          </td>
        </tr>
        <tr bgcolor="#FFFEEC">
          <td>
          <table width="100%" border="1" class="myBorder" bordercolor="#C3DFFF">
          <tr>
          	<td align="center">票据类型</td>
          	<td align="center">详细内容</td>
          	<td align="center">金额</td>
          	<td align="center">发票号码</td>
            <td align="center">扫描图片</td>
           </tr>
          <?php
		    $link=mysql_connect("localhost","root","123") or die("链接出错：".mysql_error());
  			mysql_select_db('Account');
			mysql_query("set names utf8");
			
			$result_catalog = mysql_query("select name from catalog");
			$count_catalog = mysql_num_rows($result_catalog);			
			for($i=0;$i<$count_catalog;$i++)
			{
				$row_catalog=mysql_fetch_row($result_catalog);
				$result=mysql_query("select count(*) from account where accountID='$accountID' and catalog='".($i+1)."'");
				$row=mysql_fetch_row($result);
				$count=$row[0];
				if(((int)$count)>0)
				{
					$result=mysql_query("select Detail,Money,Invoice,Image,ImageHost from account where accountID='$accountID' and catalog='".($i+1)."'");
					for($j=0;$j<$count;$j++)
					{
						$row=mysql_fetch_row($result);
						echo "<tr>";
						if($j==0) echo "<td align='center' rowspan='$count'>$row_catalog[0]</td>";
						echo "<td align='center'>".$row[0]."</td>";
						echo "<td align='center'>".$row[1]."</td>";
						echo "<td align='center'>".$row[2]."</td>";
						echo "<td align='center'>";
						if(!strcmp($row[3],"NULL"))
							echo "无</td>";
						else echo "<a target='_blank' href='".$row[4]."'>".$row[3]."</a></td>";
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
          <td align="center">                    
          <input type="button" value="返回" onclick="window.location.href='admin_account.php?listMode=<?php echo $listMode;?>'" />
          <?php		  	
			if(!strcmp($state,"unconfirm"))
			{
				echo "<input type='button' value='审核' onclick=\"window.location.href='admin_confirm_account.php?accountID=".$accountID."'\" />";
				echo "&nbsp;<input type='button' value='删除' onclick=\"window.location.href='admin_delete_account.php?accountID=".$accountID."&listMode=".$listMode."'\" />";
			}
			else if(!strcmp($state,"confirm"))
			{
				//echo "<input type='button' value='确认报销' onclick=\"window.location.href='admin_finish_account.php?accountID=".$accountID."'\" />&nbsp;";
				echo "<input type='button' value='删除' onclick=\"window.location.href='admin_delete_account.php?accountID=".$accountID."&listMode=".$listMode."'\" />";
			}
		  ?>
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
