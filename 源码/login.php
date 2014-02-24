<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
if(!isset($_COOKIE["from_usercheck"]))
{
	setcookie("from_usercheck","false",time()+600);
	$from_usercheck = "false";
}
else
{
	$from_usercheck = $_COOKIE["from_usercheck"];
	setcookie("from_usercheck","false",time()+600);
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>课题组报销系统</title>
</head>

<body>
<table width="100%" border="0" align="center">
  <tr align="center" valign="middle">
    <td><font size="+6">欢迎使用课题组内部报销系统</font></td>
  </tr>
  <tr align="center" valign="middle" height="50">
    <td>&nbsp;</td>
  </tr>
  <tr align="center" valign="middle">
    <td>
      <table width="400" border="0" align="center" cellspacing="0">
      <form action="usercheck.php" method="post">
      <tr>
        <td align="center" valign="middle" colspan="2">    
        <font face="Arial, Verdana, Helvetica, sans-serif" size="+1">用户登录</font>        
        </td>
      </tr>
  	  <tr>
        <td width="200" align="right" valign="middle">    
        <font face="Arial, Verdana, Helvetica, sans-serif">用户名：</font>
		</td>
		<td width="200" align="left" valign="middle"> 
        <input type="text" name="username" value="">
        </td>
      </tr>
      <tr>
        <td width="200" align="right" valign="middle">    
        <font face="Arial, Verdana, Helvetica, sans-serif">密码：</font>
		</td>
		<td width="200" align="left" valign="middle"> 
        <input type="password" name="password" value="">
        </td>
      </tr>  
      <tr>
        <td align="center" valign="middle" colspan="2">
        <input type="reset" value="重置">&nbsp;
        <input type="submit" value="确定">
        </td>
      </tr>	
      </form>
      <tr>
  		<td align="center" valign="middle" colspan="2">
    	<font face="Arial, Verdana, Helvetica, sans-serif">
		<?php
        if($from_usercheck=="true")
        {
          $cookie = $_COOKIE["usercheck"];
          if($cookie=="username_empty") echo "用户名不能为空！";
          else if($cookie=="password_empty") echo "密码不能为空！";
          else if($cookie=="nosuchuser") echo "该用户不存在！";
          else if($cookie=="password_error") echo "用户密码错误！";
          else if($cookie=="login_success") Header("Location: index.php"); 
        }
        ?>
        </font>
        </td>
      </tr>       
      </table>
    </td>
  </tr>
  <tr align="center" valign="middle" height="50">
    <td>&nbsp;</td>
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
