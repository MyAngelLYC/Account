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
    <td align="right" width="100"><a href="index.php">返回首页</a></td>
  </tr>
  <tr>
  	<td align="center" colspan="3">
    <HR style="FILTER: alpha(opacity=100,finishopacity=0,style=3)" width="100%" color=#987cb9 SIZE=2>
    </td>
  </tr>  
  <tr>
    <td width="1024" align="center" valign="middle" colspan="3">
      <table width="90%" border="1" align="center" cellspacing="0" class="myBorder" bordercolor="#C3DFFF" frame="box">
      <tr bgcolor="#C3DFFF">      
        <td align="center" valign="middle" colspan="4"><font size="+2"><a name="0">课题组报销系统用户手册</a></font></td>  
      </tr>    
      <ul>
      <tr bgcolor="#FFFEEC">        	
          <td align="center" width="25%"><li><a href="#1">系统说明</a></li></td>
          <td align="center" width="25%"><li><a href="#2">报销范围</a></li></td>
          <td align="center" width="25%"><li><a href="#3">报销材料</a></li></td>
          <td align="center" width="25%"><li><a href="#4">发票扫描</a></li></td>
      </tr>
      <tr bgcolor="#FFFEEC">        	
          <td align="center" width="25%"><li><a href="#5">网上申请</a></li></td>
          <td align="center" width="25%"><li><a href="#6">修改密码</a></li></td>
          <td align="center" width="25%"><li><a href="#7">错误报告</a></li></td>
          <td align="center" width="25%"></td>
      </tr>
      </ul>
      <tr>
        <td align="center" colspan="4">
        	<table border="0" width="100%" cellpadding="0" cellspacing="5">
            <tr><td><font size="+3"><a name="1">一、系统说明</a></font></td></tr>
			<tr><td><font size="+1">&nbsp;&nbsp;&nbsp;&nbsp;为响应姜老师号召，加强课题组报销业务的管理，方便老师和同学进行自助报销申请，并简化报销业务管理，特开发本课题组报销系统。
            此用户手册针对该系统使用和报销业务相关规范进行说明。大家在使用过程中如有任何问题可以联系管理员姜明老师，或者联系作者刘亦辰，非常感谢您为本系统的发展和完善做出的贡献。
            联系作者可通过以下方式，QQ：523110826，MSN：ycliu1989@hotmail.com，email：<a href="mailto:ycliu0930@gmail.com">ycliu0930@gmail.com</a>。</font></td></tr>
            
            <tr height="20"><td></td></tr>
            
            <tr><td><font size="+3"><a name="2">二、报销范围</a></font></td></tr>
            <tr><td><font size="+1">&nbsp;&nbsp;&nbsp;&nbsp;目前，实验室报销的范围包括设备、材料（含邮费）、加工、文献、燃料、学生酬金、教工劳务、会议费、专家咨询费、国内差旅、国际差旅、办公用品。</font></td></tr>
            
            <tr height="20"><td></td></tr>
            
            <tr><td><font size="+3"><a name="3">三、报销材料</a></font></td></tr>
            <tr><td><font size="+1">&nbsp;&nbsp;&nbsp;&nbsp;进行报销登记需要正规的税务发票。申请报销须在所有要报销的发票右上角签名，如图3.1所示。</font></td></tr>
            <tr><td align="center"><img src="image/图3.1.jpg" width="800" /></td></tr>
            <tr><td align="center"><font size="+1">图3.1 发票签字示例</font></td></tr>
            <tr><td><font size="+1">&nbsp;&nbsp;&nbsp;&nbsp;对于邮费发票，除了需要签名之外，需要写明邮寄运送的是什么东西，如图3.2所示。</font></td></tr>
            <tr><td align="center"><img src="image/图3.2.png" height="600" /></td></tr>
            <tr><td align="center"><font size="+1">图3.2 邮费发票签字示例</font></td></tr>
            <tr><td><font size="+1">&nbsp;&nbsp;&nbsp;&nbsp;对于材料费，如发票项目不够清楚的，也需补充说明，如图3.3所示。</font></td></tr>
            <tr><td align="center"><img src="image/图3.3.png" width="800" /></td></tr>
            <tr><td align="center"><font size="+1">图3.3 材料发票补充说明示例</font></td></tr>
            
            <tr height="20"><td></td></tr>
            
            <tr><td><font size="+3"><a name="4">四、发票扫描</a></font></td></tr>
            <tr><td><font size="+1">&nbsp;&nbsp;&nbsp;&nbsp;所有申请报销的发票都需要在报销之前，将签过字的发票扫描成电子版并上传存档。实验室使用的扫描仪
            是Canon LiDE 110，可到A1214房间借用，如果自行使用其他扫描设备亦可，操作方式与如下说明类似。关于扫描仪使用说明如下：</font></td></tr>
            <tr><td><font size="+1">&nbsp;&nbsp;&nbsp;&nbsp;1、	将扫描仪USB电缆连接电脑USB口，出现“正在安装设备驱动”提示，稍等片刻安装成功。</font></td></tr>
            <tr><td><font size="+1">&nbsp;&nbsp;&nbsp;&nbsp;2、	将发票正面向下放置在扫描仪上，扫描仪右下角的箭头标志为扫描原点，即扫描出的图片的最左上角。可同时放置多张发票一起扫描，各发票中间稍留间隔，扫描仪可自动将各张发票扫描导入到单独的文件中。注意，发票摆放不要超过扫描仪上横向和纵向标识的A4标志。放置发票完成后，轻轻盖上扫描仪盖板。</font></td></tr>
            <tr><td><font size="+1">&nbsp;&nbsp;&nbsp;&nbsp;3、	点击开始菜单，选择“设备和打印机”。在弹出窗口中，选择“CanoScan”。</font></td></tr>
            <tr><td align="center"><img src="image/图4.1.jpg" height="600" /></td></tr> 
            <tr><td align="center"><img src="image/图4.2.png" width="800" /></td></tr> 
            <tr><td><font size="+1">&nbsp;&nbsp;&nbsp;&nbsp;4、	在弹出的扫描窗口中，进行如下配置。一定要勾选左下角的“预览或将图像扫描为单独的文件”。</font></td></tr>
            <tr><td align="center"><img src="image/图4.3.jpg" width="800" /></td></tr> 
            <tr><td><font size="+1">&nbsp;&nbsp;&nbsp;&nbsp;5、	点击预览按钮，可看到发票扫描图像以及扫描仪自动区分多张发票画出的虚线方框。</font></td></tr>
            <tr><td align="center"><img src="image/图4.4.png" width="800" /></td></tr> 
            <tr><td><font size="+1">&nbsp;&nbsp;&nbsp;&nbsp;6、	点击扫描，扫描仪开始进行扫描，然后弹出窗口，输入文件标识（生成文件名的一部分），点击导入，然后依次导入刚才扫描到的两张发票图片。</font></td></tr>
            <tr><td align="center"><img src="image/图4.5.png" width="800" /></td></tr> 
            <tr><td><font size="+1">&nbsp;&nbsp;&nbsp;&nbsp;7、	导入完成后会打开一个文件夹，其中就是本次扫描导入的发票图片。同时，它也标明了该文件在电脑上的位置。</font></td></tr>
            <tr><td align="center"><img src="image/图4.6.png" width="800" /></td></tr>
            
            <tr height="20"><td></td></tr>
             
            <tr><td><font size="+3"><a name="5">五、网上申请报销</a></font></td></tr>
            <tr><td><font size="+1">&nbsp;&nbsp;&nbsp;&nbsp;将申请报销的发票签字并扫描之后，需要在网上填写报销申请。填写申请登录http://121.248.55.231.</font></td></tr>
            <tr><td><font size="+1">&nbsp;&nbsp;&nbsp;&nbsp;1、	登录，本课题组成员应都有个人报销申请帐号，帐号名和初始密码都是自己的一卡通号。</font></td></tr>
            <tr><td align="center"><img src="image/图5.1.jpg" width="800" /></td></tr> 
            <tr><td><font size="+1">&nbsp;&nbsp;&nbsp;&nbsp;2、	登录后进入主页面，点击申请报销。</font></td></tr>
            <tr><td align="center"><img src="image/图5.2.jpg" width="800" /></td></tr>  
            <tr><td><font size="+1">&nbsp;&nbsp;&nbsp;&nbsp;3、	在业务类型中选择“一般报销业务”，附件数量当中填写要报销的发票数量。然后点击确定。</font></td></tr>
            <tr><td align="center"><img src="image/图5.3.jpg" width="800" /></td></tr>  
            <tr><td><font size="+1">&nbsp;&nbsp;&nbsp;&nbsp;4、	选择发票类型、填入发票详细内容、金额和发票号码，并选择相应的扫描图片文件，确认无误之后点击确定。上传文件格式支持常用图片
            格式和PDF文档格式。单张发票可采用扫描的图片格式，若发票还配有合同、清单、录用证明等附件时，请将所有相关材料制作成一个PDF文档上传。</font></td></tr>
            <tr><td align="center"><img src="image/图5.4.jpg" width="800" /></td></tr>  
            <tr><td><font size="+1">&nbsp;&nbsp;&nbsp;&nbsp;5、	进入报销申请确认页面，核对相应填写信息，点击图片名称可查看上传图片是否正确。核对无误之后点击确定，保存成功。</font></td></tr>
            <tr><td align="center"><img src="image/图5.5.jpg" width="800" /></td></tr>  
            <tr><td><font size="+1">&nbsp;&nbsp;&nbsp;&nbsp;6、	在经过上述步骤之后，报销申请便完成。在首页可以查看到，如图所示。每人每月可以进行一次报销申请，申请后状态查询报销申请详情，如果有误，可以点击删除，然后重新申请。</font></td></tr>
            <tr><td align="center"><img src="image/图5.6.jpg" width="800" /></td></tr>  
            <tr><td><font size="+1">&nbsp;&nbsp;&nbsp;&nbsp;7、	每月的月底，管理员会审核所有用户的报销申请，审核通过后便不可以再进行任何修改，状态也变为已审核，如图所示。</font></td></tr>
            <tr><td align="center"><img src="image/图5.7.jpg" width="800" /></td></tr>  
            <tr><td><font size="+1">&nbsp;&nbsp;&nbsp;&nbsp;8、	审核通过后的报销申请，管理员会统一进行网上预约报销，该报销申请的状态也将变为“已预约”。报销到账后，管理员会进行确认，报销申请也会更改为“已入账”。至此，报销完成。下个月可以继续进行报销申请。</font></td></tr>
            <tr><td align="center"><img src="image/图5.8.jpg" width="800" /></td></tr> 
            
            <tr height="20"><td></td></tr>
            
            <tr><td><font size="+3"><a name="6">六、修改密码</a></font></td></tr>
            <tr><td><font size="+1">&nbsp;&nbsp;&nbsp;&nbsp;进入系统后在右上角有修改密码链接，点击进入修改密码。输入原密码、新设密码和确认密码即可。如果遗忘密码，可联系管理员将密码恢复至初始密码。</font></td></tr>
            <tr><td align="center"><img src="image/图6.1.jpg" width="800" /></td></tr>
            
            <tr height="20"><td></td></tr>
             
            <tr><td><font size="+3"><a name="7">七、错误报告</a></font></td></tr>
            <tr><td><font size="+1">&nbsp;&nbsp;&nbsp;&nbsp;如果您在使用过程中有任何疑问或者遇到任何错误，请联系管理员姜明老师或者作者刘亦辰，感谢您的支持。</font></td></tr>
            
            <tr height="20"><td></td></tr>
            
            <tr><td align="center"><font size="+1"><a href="#0">回到顶部</a></font></td></tr>
            
            </table>            
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
