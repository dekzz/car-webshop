<?php
	include_once ('klase/framework.php');
	require'/var/www/Smarty-2.6.6/libs/Smarty.class.php';
	session_start();
	$smarty= new Smarty();

	if (isset($_POST['unesiKonf']))
	{
		$dio = $_POST['dio'];
		$naziv = $_POST['naziv'];
		$opis = $_POST['opis'];
		$slika = $_POST['slika'];
		$javno = $_POST['javno'];
		
		if (empty($dio))
		{
			$greska = array('box'=>'style="border: 1pt solid #FF0000"', 'greska'=>'Odaberite dio!');
			$smarty->assign("dio", $greska);
			$greske++;  
		}
		else
		{
			$vrijednost = array('vrijednost'=>$dio);
			$smarty->assign("dio",$vrijednost);
		}
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
		
		if (empty($opis))
		{
			$greska = array('box'=>'style="border: 1pt solid #FF0000"', 'greska'=>'Unesite opis!');
			$smarty->assign("opis",$greska);
			$greske++;  
		}
		else
		{
			$vrijednost = array('vrijednost'=>$opis);
			$smarty->assign("opis",$vrijednost);
		}
		
		if($_FILES["slika"]["error"]  == UPLOAD_ERR_OK)
		{
			if (($_FILES['slika']['type'] == "image/gif") || ($_FILES['slika']['type'] == "image/jpeg") || ($_FILES['slika']['type'] == "image/png" ))
			{
				$dir = "slike/konfiguracije/$naziv/$opis/";
				if (!is_dir($dir))
				{
					mkdir("slike/konfiguracije/$naziv/$opis/", 0777);
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
				
				$dir = "slike/konfiguracije/$naziv/$opis/thumb/";
				if (!is_dir($dir))
				{
					mkdir("slike/konfiguracije/$naziv/$opis/thumb/", 0777);
				}
				$remote_file = "slike/konfiguracije/$naziv/$opis/thumb/".$_FILES["slika"]["name"];
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
				$thumbPath = "slike/konfiguracije/$naziv/$opis/thumb/".$_FILES['slika']['name'];
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
			$conn = new DBConfig();
			
			$sql = mysql_query("SELECT automobil_idautomobil FROM dijelovi WHERE iddio = '$dio'");
			$partOf = mysql_fetch_array($sql);
			
			$korisnik = $_SESSION['user'];
			
			$kreator = mysql_real_escape_string($korisnik);
			$dio = mysql_real_escape_string($_POST['dio']);
			$partOf = mysql_real_escape_string($partOf[0]);
			$naziv = mysql_real_escape_string($_POST['naziv']);
			$opis = mysql_real_escape_string($_POST['opis']);
			
			if(!empty($path))
			{
				$path = mysql_real_escape_string($path);	
				$thumbPath = mysql_real_escape_string($thumbPath);
			
				if(isset($_POST['confID']))
				{
					$confID = $_POST['confID'];
					mysql_query("update konfiguracije set naziv='$naziv', automobil_idautomobil='$partOf', dijelovi_iddio='$dio', opis='$opis', javno='$javno', path_slika='$path', path_thumb='$thumbPath' where idkonfiguracije='$confID'") or die(mysql_error());
				}
				else
				{
					mysql_query("insert into konfiguracije (naziv, korisnik_idkorisnik, automobil_idautomobil, dijelovi_iddio, opis, javno, path_slika, path_thumb) values ('$naziv', '$kreator', '$partOf','$dio', '$opis', '$javno', '$path', '$thumbPath')") or die(mysql_error());
				}
			}
			else
			{
				if(isset($_POST['confID']))
				{
					$confID = $_POST['confID'];
					mysql_query("update konfiguracije set naziv='$naziv', automobil_idautomobil='$partOf', dijelovi_iddio='$dio', opis='$opis', javno='$javno' where idkonfiguracije='$confID'") or die(mysql_error());
				}
				else
				{
					mysql_query("insert into konfiguracije (naziv, korisnik_idkorisnik, automobil_idautomobil, dijelovi_iddio, opis, javno) values ('$naziv', '$kreator', '$partOf','$dio', '$opis', '$javno'") or die(mysql_error());
				}
			}
			$conn::zatvori();
			
			$_SESSION['saved'] = "Konfiguracija uspješno spremljena!";
			
			header('Location: unosKonfiguracija.php');
		}
		else
		{
			$smarty->assign("saved", "Dogodila se pogreška!");
			$smarty->assign("title", "Odabir automobila");
			$smarty->display('unosKonfiguracija.tpl');
		}
	}
?>