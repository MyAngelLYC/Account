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
          <td align="left" width="50%">请选择报销业务类型</td>
          <td align="right" width="50%"><a href="howto.php"><font size="-1">报销须知</font></a></td>
        </tr>
        <form action="fillform.php" method="post" name="form1">
        <tr bgcolor="#FFFEEC">
          <td colspan="2">
          <input type="radio" checked="checked" name="radio" value="normal"/>一般报销业务
          </td>
        </tr>
        <tr bgcolor="#FFFEEC">
          <td colspan="2"><input type="radio" name="radio" value="other"/>其他报销业务(尚未开放)
          </td>
        </tr>
        <tr bgcolor="#C3DFFF">
          <td colspan="2">附件数量：<input name="number" type="text" />
          </td>
        </tr>
        <tr>
          <td align="center" colspan="2">
          <input type="button" value="取消" onclick="window.location.href='index.php'" />
          &nbsp;&nbsp;<input type="submit" value="确定" />
          </td>
        </tr>
        </form>
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
<?php
	$ywlist_error = $_COOKIE["ywlist_error"];
	if(!strcmp($ywlist_error,"number_empty"))
	{
		 echo "<script language=javascript>alert('附件数量不能为空!');</script>";
		 setcookie("ywlist_error","",time()+600);
	}	
	else if(!strcmp($ywlist_error,"number_error"))
	{
		 echo "<script language=javascript>alert('附件数量须为正数!');</script>";
		 setcookie("ywlist_error","",time()+600);
	}
?>
</html>