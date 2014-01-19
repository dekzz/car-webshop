<?php
	include_once ('klase/framework.php');
	require'/var/www/Smarty-2.6.6/libs/Smarty.class.php';
	session_start();
	$smarty= new Smarty();

	if (isset($_POST['unesiDio']))
	{
		$automobil = $_POST['auto'];
		$naziv = $_POST['naziv'];
		$opis = $_POST['opis'];
		$cijena = $_POST['cijena'];
		$akcija = $_POST['akcija'];
		
		if (empty($automobil))
		{
			$greska = array('box'=>'style="border: 1pt solid #FF0000"', 'greska'=>'Odaberite automobil!');
			$smarty->assign("automobil", $greska);
			$greske++;  
		}
		else
		{
			$vrijednost = array('vrijednost'=>$automobil);
			$smarty->assign("automobil",$vrijednost);
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
		$result = mysql_query("SELECT * FROM dijelovi WHERE naziv = '$naziv'");
		$conn::zatvori();
		
		if (mysql_num_rows($result) == 1)
		{
			$greska = array('box'=>'style="border: 1pt solid #FF0000"', 'greska'=>'Dio već postoji!');
			$smarty->assign("naziv", $greska);
			$greske++; 
		}
		
		if(empty($_FILES['slika']['name']))
		{
			$greska = array('box'=>'style="border: 1pt solid #FF0000"', 'greska'=>'Obavezno postaviti sliku!');
			$smarty->assign("slika", $greska);
			$greske++; 
		}
		else
		{
			if (($_FILES['slika']['type'] == "image/gif") || ($_FILES['slika']['type'] == "image/jpeg") || ($_FILES['slika']['type'] == "image/png" ))
			{
				$dir = "slike/dijelovi/$naziv/";
				if (!is_dir($dir))
				{
					mkdir("slike/dijelovi/$naziv/", 0777);
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
				
				$dir = "slike/dijelovi/$naziv/thumb/";
				if (!is_dir($dir))
				{
					mkdir("slike/dijelovi/$naziv/thumb/", 0777);
				}
				$remote_file = "slike/dijelovi/$naziv/thumb/".$_FILES["slika"]["name"];
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
				$thumbPath = "slike/dijelovi/$naziv/thumb/".$_FILES['slika']['name'];
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
			$automobil = mysql_real_escape_string($_POST['auto']);
			$naziv = mysql_real_escape_string($_POST['naziv']);
			$opis = mysql_real_escape_string($_POST['opis']);
			$cijena = mysql_real_escape_string($_POST['cijena']);
			
			mysql_query("insert into dijelovi (automobil_idautomobil, naziv, opis, cijena, akcija, path_slika, path_thumb) values ('$automobil', '$naziv', '$opis', '$cijena', '$akcija', '$path', '$thumbPath')") or die(mysql_error());
			$conn::zatvori();
			
			$_SESSION['saved'] = "Uspješno unesen dio!";
			header('Location: unosDijelova.php');
		}
		else
		{
			$smarty->assign("title", "Unos dijelova");
			$smarty->display('unosDijelova.tpl');
		}
	}
?>