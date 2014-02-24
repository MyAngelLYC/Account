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
	$ywRadio = $_POST[radio];
	if(!strcmp($ywRadio,"other"))
	{
		Header("Location: ywlist.php");
	}
	else
	{
	  $ywNumber = $_POST[number];
	  if(!strcmp($ywNumber,""))
	  {
		  setcookie("ywlist_error","number_empty",time()+600);
		  Header("Location: ywlist.php");
	  }	
	  else if(((int)$ywNumber)<=0)
	  {
		  setcookie("ywlist_error","number_error",time()+600);
		  Header("Location: ywlist.php");
	  }
	  $ywNumber = (int)$ywNumber;
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
  	<td align="center"><font size="+6">欢迎使用课题组内部报销系统</font></td>
  </tr>
  <tr>
  	<td align="center">
    <HR style="FILTER: alpha(opacity=100,finishopacity=0,style=2)" width="100%" color=#987cb9 SIZE=10>
    </td>
  </tr>   
  <tr>
  	<td align="center">
      <form action='confirm.php' method='post' enctype="multipart/form-data">
      <table width="80%" border="1" class="myBorder" bordercolor="#C3DFFF" frame="box">
        <tr>
          <td align="left"><?php echo "一卡通号：".$userID;?></td>
          <td align="left">
		  <?php 
		  	echo "姓名：".$username;
			if(!strcmp($userLevel,"root")) echo "(系统管理员)";
			else echo "(普通用户)";
		  ?></td>
        </tr>
        <tr>
          <td align="left"><?php echo "联系方式：".$userTele;?></td>
          <td align="left">
		  <?php 
		  echo "附件数量：<input type='text' size='5' name='number' value='".$ywNumber."' readonly/>";
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
      <table width="100%" border="5" class="myBorder" bordercolor="#C3DFFF" frame="box">
        <tr bgcolor="#C3DFFF">
          <td align="left" width="50%" colspan="6">请具体填写报销项目内容
          <?php
		  	if(!strcmp($ywRadio,"normal")) echo "(一般报销业务)";
			else echo "(差旅费报销业务)";
		  ?>
          </td>          
        </tr>
        <tr bgcolor="#FFFEEC">
          <td align="center">序号</td>
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
			$result = mysql_query("select name from catalog");
			$count = mysql_num_rows($result);
			$option = "";
			for($i=0;$i<$count;$i++)
			{
				$row=mysql_fetch_row($result);
				$option =$option."<option value='".($i+1)."'>$row[0]</option>";
			}			
			mysql_close($link); 
						
			for($i=0;$i<$ywNumber;$i++)
			{
				echo "<tr>";
				echo "<td align='center' width='10%'>".($i+1)."</td>";				
				echo "<td align='center' width='15%'><select name='catalog".($i+1)."'>$option</select></td>";
				echo "<td align='center' width='25%'><input type='text' size='20' name='detail".($i+1)."' /></td>";
				echo "<td align='center' width='15%'><input type='text' size='10' name='money".($i+1)."' /></td>";
				echo "<td align='center' width='20%'><input type='text' size='10' name='invoice".($i+1)."' /></td>";
				echo "<td align='center' width='15%'><input type='file' accept='image/*,application/pdf' name='file".($i+1)."'/></td>";
				echo "</tr>";
			}			
		?>        
        <tr>
          <td align="center" colspan="6">
          <input type="button" value="取消" onclick="window.location.href='ywlist.php'">
          &nbsp;&nbsp;<input type="submit" value="确定">           
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
</html>