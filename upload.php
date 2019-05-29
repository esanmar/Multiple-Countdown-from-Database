<?php


if ($_FILES["uploaded"]["error"] > 0)
{
	echo "Error: " . $_FILES["uploaded"]["error"] . "<br>";
}
else
{
	
	$file_name1=$_FILES["uploaded"]["name"];
	$file_name="/\/\Srvpw02/\c$/\Inetpub/\wwwroot/\".$file_name1;

	echo "Upload: " . $file_name1 . "<br>";
	echo "Type: " . $_FILES["uploaded"]["type"] . "<br>";
	echo "Size: " . ($_FILES["uploaded"]["size"] / 1024) . " kB<br>";
	move_uploaded_file($_FILES["uploaded"]["tmp_name"],
	$file_name . $_FILES["uploaded"]["name"]);	 

	echo "Stored in: " . $_FILES["uploaded"]["tmp_name"];


}

include 'importcsvtomysql.php';
  
?>