<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
	function deldir($dir)
	{
	  //先删除目录下的文件：
	  $dh=opendir($dir);
	  while ($file=readdir($dh)) 
	  {
		if($file!="." && $file!="..") 
		{
		  $fullpath=$dir."/".$file;
		  if(!is_dir($fullpath)) unlink($fullpath);
		  else deldir($fullpath);
		}
	  }
	  closedir($dh);
	  //删除当前文件夹：
	  if(rmdir($dir)) return true;
	  else return false;
  	}
		
	function prepareFile($ID)
	{
		$projectID = $ID;
		//echo $projectID."<br>";			
		deldir("/var/www/Account/InvoiceImage/export/");
		deldir("/var/www/Account/InvoiceImage/zip/");
		mkdir("/var/www/Account/InvoiceImage/export/",0777);
		mkdir("/var/www/Account/InvoiceImage/zip/",0777);			
		$link=mysql_connect("localhost","root","123") or die("链接出错：".mysql_error());
		mysql_select_db('Account');
		mysql_query("set names utf8");
		$reservation_result=mysql_query("select * from reservation where Project='$projectID'");
		$reservation_count=mysql_num_rows($reservation_result);
		for($i=0;$i<$reservation_count;$i++)
		{
			$reservation_row=mysql_fetch_row($reservation_result);
			//echo $reservation_row[0]." ".$reservation_row[1]."<br>";				
			$catalog_result=mysql_query("select * from catalog");				
			$catalog_count=mysql_num_rows($catalog_result);				
			for($j=0;$j<$catalog_count;$j++)
			{
				$catalog_row=mysql_fetch_row($catalog_result);
				//echo $catalog_row[0]." ".$catalog_row[1]."<br>";					
				$account_result=mysql_query("select * from account where Reservation=".$reservation_row[0]." and Catalog=".$catalog_row[0]);
				$account_count=mysql_num_rows($account_result);
				if($account_count>0)
				{
					$dir = "/var/www/Account/InvoiceImage/export/".$catalog_row[1];
					if(!file_exists($dir)) mkdir($dir,0777);
					for($k=0;$k<$account_count;$k++)
					{
						$account_row=mysql_fetch_row($account_result);
						chdir("/var/www/Account");							
						$source = "/var/www/Account/".$account_row[10];							
						$dest = $dir."/".$account_row[4]."_".$account_row[0]."_".$account_row[1].".jpg";
						//echo $source." ".$dest."<br>";
						copy($source,$dest);
						chmod($dest,0777);
					}
				}
			}
		}
		mysql_close($link);
	}
	
	function zipFile($project)
	{
		$archive  = new ZipArchive();
		$archive->open("/var/www/Account/InvoiceImage/zip/".$project.".zip",ZipArchive::CREATE);
		$dir = dir("/var/www/Account/InvoiceImage/export/");
		while (($dirname = $dir->read()) !== false)
		{
		   if($dirname!="." && $dirname!="..")
		   {			   
			   $subDir = dir("/var/www/Account/InvoiceImage/export/".$dirname);
			   while (($dirname2 = $subDir->read()) !== false)
			   {
				   if($dirname2!="." && $dirname2!="..")
				   	$archive->addFile("/var/www/Account/InvoiceImage/export/".$dirname."/".$dirname2,iconv('UTF-8','GB2312',$dirname)."/".$dirname2);
			   }
		   }
		}
		$subDir->close();
		$dir->close();
		$archive->close();
	}
?>

<?php	
    $project=$_GET["projectID"];
	prepareFile($project);
	zipFile($project);
	Header("Location: InvoiceImage/zip/$project.zip");
?>