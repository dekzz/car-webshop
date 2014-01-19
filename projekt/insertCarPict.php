<?php

	include_once ('klase/framework.php');
	require'/var/www/Smarty-2.6.6/libs/Smarty.class.php';
	session_start();
	$smarty = new Smarty();
	
	$conn = new DBConfig();
	
	if (isset($_SESSION['user']))
	{
		$user = $_SESSION['user'];
	}
	else {
		header("location: login.php");
	}
		
	if (isset($_GET['id']))
	{
		$carId = $_GET['id'];
	}
	
	if($_FILES['carPict']['name'])
	{
		if (($_FILES['carPict']['type'] == "image/gif") || ($_FILES['carPict']['type'] == "image/jpeg") || ($_FILES['carPict']['type'] == "image/png" ))
		{
			$dir = "slike/automobilii/$carId/";
			if (!is_dir($dir))
			{
				 mkdir("slike/automobilii/$carId/", 0777);
			}
			
			$path = $dir . $_FILES['carPict']['name'];
			$copied = copy($_FILES['carPict']['tmp_name'], $path);
			if(!$copied)
			{
				$greska = array('box'=>'style="border: 1pt solid #FF0000"', 'greska'=>'Greška kod uploada!');
				$smarty->assign("slika", $greska);
				$greske++;
			}
			
			$max_upload_width = 40;
			$max_upload_height = 40;
			
			// if uploaded image was JPG/JPEG
			if($_FILES["carPict"]["type"] == "image/jpeg" || $_FILES["carPict"]["type"] == "image/pjpeg"){	
				$image_source = imagecreatefromjpeg($_FILES["carPict"]["tmp_name"]);
			}		
			// if uploaded image was GIF
			if($_FILES["carPict"]["type"] == "image/gif"){	
				$image_source = imagecreatefromgif($_FILES["carPict"]["tmp_name"]);
			}				
			// if uploaded image was PNG
			if($_FILES["carPict"]["type"] == "image/x-png"){
				$image_source = imagecreatefrompng($_FILES["carPict"]["tmp_name"]);
			}
			
			$dir = "slike/automobilii/$carId/thumb/";
			if (!is_dir($dir))
			{
				mkdir("slike/automobilii/$carId/thumb/", 0777);
			}
			$remote_file = "slike/automobilii/$carId/thumb/".$_FILES["carPict"]["name"];
			imagejpeg($image_source,$remote_file,100);
			//chmod($remote_file,0777);
			
			list($image_width, $image_height) = getimagesize($remote_file);
			
			if($image_width>$max_upload_width || $image_height >$max_upload_height){
				$proportions = $image_width/$image_height;
				
				if($image_width>$image_height)
				{
					$new_width = $max_upload_width;
					$new_height = round($max_upload_width/$proportions);
				}		
				else{
					$new_height = $max_upload_height;
					$new_width = round($max_upload_height*$proportions);
				}		
				
				$new_image = imagecreatetruecolor($new_width , $new_height);
				$image_source = imagecreatefromjpeg($remote_file);
				
				imagecopyresampled($new_image, $image_source, 0, 0, 0, 0, $new_width, $new_height, $image_width, $image_height);
				imagejpeg($new_image,$remote_file,100);
				
				imagedestroy($new_image);
			}
			imagedestroy($image_source);
			$thumbPath = "slike/automobilii/$carId/thumb/".$_FILES['carPict']['name'];
			move_uploaded_file($_FILES["carPict"]["tmp_name"], $thumbPath);
		}	
		$sql = mysql_query("INSERT INTO slika_automobil (automobil_idautomobil, path_slika, path_thumb)VALUES ('$carId','$path' ,'$thumbPath')");
	}
	header("Location:carDetails.php?id=".$carId."");
?>