<?php
	include_once ('klase/framework.php');
	require'/var/www/Smarty-2.6.6/libs/Smarty.class.php';
	session_start();
	$smarty= new Smarty();

	if (isset($_POST['edit']))
	{
		$naziv = $_POST['naziv'];
		$model = $_POST['model'];
		$cijena = $_POST['cijena'];
		$akcija = $_POST['akcija'];
		
		if (empty($naziv))
		{
			$greska = array('box'=>'style="border: 1pt solid #FF0000"', 'greska'=>'Unesite ime proizvođača!');
			$smarty->assign("naziv", $greska);
			$greske++;  
		}
		else
		{
			$vrijednost = array('vrijednost'=>$naziv);
			$smarty->assign("naziv",$vrijednost);
		}
		
		if (empty($model))
		{
			$greska = array('box'=>'style="border: 1pt solid #FF0000"', 'greska'=>'Unesite model!');
			$smarty->assign("model",$greska);
			$greske++;  
		}
		else
		{
			$vrijednost = array('vrijednost'=>$model);
			$smarty->assign("model",$vrijednost);
		}
		
		if (empty($cijena))
		{
			$greska = array('box'=>'style="border: 1pt solid #FF0000"', 'greska'=>'Unesite cijenu!');
			$smarty->assign("cijena",$greska);
			$greske++; 
		}
		else
		{
			$vrijednost = array('vrijednost'=>$cijena);
			$smarty->assign("cijena",$vrijednost);
		}
		
		$conn = new DBConfig();
		$result = mysql_query("SELECT idautomobil FROM automobil WHERE naziv = '$naziv' and model = '$model'");
		$car = mysql_fetch_array($result);
		$carID = $car[0];
		
		if($_FILES["slika"]["error"]  == UPLOAD_ERR_OK)
		{
			if (($_FILES['slika']['type'] == "image/gif") || ($_FILES['slika']['type'] == "image/jpeg") || ($_FILES['slika']['type'] == "image/png" ))
			{
				$dir = "slike/automobili/$naziv/$model/";
				if (!is_dir($dir))
				{
					mkdir("slike/automobili/$naziv/$model/", 0777);
				}
				
				$path = $dir . $_FILES['slika']['name'];
				$copied = copy($_FILES['slika']['tmp_name'], $path);
				if(!$copied)
				{
					$greska = array('box'=>'style="border: 1pt solid #FF0000"', 'greska'=>'Greška kod uploada!');
					$smarty->assign("slika", $greska);
					$greske++;
				}
				
				$max_upload_width = 40;
				$max_upload_height = 40;
				
				// if uploaded image was JPG/JPEG
				if($_FILES["slika"]["type"] == "image/jpeg" || $_FILES["slika"]["type"] == "image/pjpeg"){	
					$image_source = imagecreatefromjpeg($_FILES["slika"]["tmp_name"]);
				}		
				// if uploaded image was GIF
				if($_FILES["slika"]["type"] == "image/gif"){	
					$image_source = imagecreatefromgif($_FILES["slika"]["tmp_name"]);
				}				
				// if uploaded image was PNG
				if($_FILES["slika"]["type"] == "image/x-png"){
					$image_source = imagecreatefrompng($_FILES["slika"]["tmp_name"]);
				}
				
				$dir = "slike/automobili/$naziv/$model/thumb/";
				if (!is_dir($dir))
				{
					mkdir("slike/automobili/$naziv/$model/thumb/", 0777);
				}
				$remote_file = "slike/automobili/$naziv/$model/thumb/".$_FILES["slika"]["name"];
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
				$thumbPath = "slike/automobili/$naziv/$model/thumb/".$_FILES['slika']['name'];
				move_uploaded_file($_FILES["slika"]["tmp_name"], $thumbPath);
				
			}		
			else
			{
				$greska = array('box'=>'style="border: 1pt solid #FF0000"', 'greska'=>'Podržani formati: .gif .jpg .png');
				$smarty->assign("slika", $greska);
				$greske++;
			}
		}
		
		if($greske==0)
		{			
			$naziv = mysql_real_escape_string($_POST['naziv']);
			$model = mysql_real_escape_string($_POST['model']);
			$cijena = mysql_real_escape_string($_POST['cijena']);
			
			if(!empty($path))
			{
				$path = mysql_real_escape_string($path);	
				$thumbPath = mysql_real_escape_string($thumbPath);

				mysql_query("update automobil set naziv='$naziv', model='$model', cijena='$cijena', akcija='$akcija', path_slika='$path', path_thumb='$thumbPath' where idautomobil='$carID'") or die(mysql_error());
			}
			else
			{
				mysql_query("update automobil set naziv='$naziv', model='$model', cijena='$cijena', akcija='$akcija' where idautomobil='$carID'") or die(mysql_error());
			}
			$conn::zatvori();
			
			header('Location: automobili.php');
		}
		else
		{
			$smarty->assign("title", "Uređivanje");
			$smarty->display('editCar.tpl');
		}
	}
?>