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
	$userTele = $_COOKIE["userTele"];
	
	$count=$_POST[number];
	$accountID=date('Ym').$userID;
	$Section=date('Y.m');
	$link=mysql_connect("localhost","root","123") or die("链接出错：".mysql_error());
	mysql_select_db('Account');
	mysql_query("set names utf8");
	$result=mysql_query("select Date from account where accountID='$accountID' and State='unconfirm'");
	$row=mysql_fetch_row($result);
	$Date=$row[0];
	mysql_close($link);		
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
  	<td align="center"><font size="+6">欢迎使用课题组内部报销系统</font></td>
  </tr>
  <tr>
  	<td align="center">
    <HR style="FILTER: alpha(opacity=100,finishopacity=0,style=2)" width="100%" color=#987cb9 SIZE=10>
    </td>
  </tr>   
  <tr>
  	<td align="center">
      <table width="80%" border="1" class="myBorder" bordercolor="#C3DFFF" frame="box">
        <tr>
          <td align="left"><?php echo "一卡通号：".$userID;?></td>
          <td align="left"><?php echo "姓名：".$username;?></td>
        </tr>
        <tr>
          <td align="left"><?php echo "联系方式：".$userTele;?></td>
          <td align="left">
		  <?php
		  	echo "用户等级：";
			if(!strcmp($userLevel,"root")) echo "系统管理员";
			else echo "普通用户";
		  ?>
          </td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
  	<td align="center" height="20"></td>
  </tr> 
  <tr>
  	<td width="1024" align="center" valign="middle">
      <table width="80%" border="5" class="myBorder" bordercolor="#C3DFFF" frame="box">
        <tr bgcolor="#C3DFFF">
          <td align="middle">报销申请详情</td>          
        </tr>
        
        <tr bgcolor="#FFFEEC">
          <td>
            <table width="100%" border="0">
              <tr>
                <td><?php echo "序列单号：".$accountID;?></td>
                <td><?php echo "报销阶段：".$Section;?></td>
                <td><?php echo "填写时间：".$Date;?></td>
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
          
          <input type="button" value="返回" onclick="window.location.href='index.php'" />
          
          </td>
        </tr>
        
      </table>
    </td>
  </tr>
  <tr>
  	<td height="20">
    </td>
  </tr>
  
  <tr>
  	<td align="center">
    <HR style="FILTER: alpha(opacity=100,finishopacity=0,style=3)" width="100%" color=#987cb9 SIZE=2>
    </td>
  </tr>
  <tr>
  	<td width="1024" align="center" valign="middle">
    <font face="Arial, Verdana, Helvetica, sans-serif">Copyright © 
    <?php
	  echo date("Y");
	?>
    </font>
    </td>
  </tr>
  <tr>
    <td width="1024" align="center" valign="middle">
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