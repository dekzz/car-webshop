<?php
	include_once ('klase/framework.php');
	require'/var/www/Smarty-2.6.6/libs/Smarty.class.php';
	session_start();
	$smarty= new Smarty();

	if (isset($_POST['edit']))
	{
		$ime = $_POST['edIme'];
		$prezime = $_POST['edPrezime'];
		$korIme = $_POST['korIme'];
		$email = $_POST['edEmail'];
		$lozinka = $_POST['edPass'];
		$zivotopis = $_POST['zivotopis'];
		$status = $_POST['edStatus'];
		$tip = $_POST['edType'];	
		
		if (!empty($ime))
		{
			$smarty->assign("$logedIDfirstName",$ime);
		}	
		
		if (!empty($prezime))
		{
			$smarty->assign("$logedIDlastName",$prezime);
		}

		if (!empty($email))
		{
			$smarty->assign("$logedIDemail",$email);
		}
		
		if (!empty($status))
		{
			$smarty->assign("$logedIDstatus",$status);
		}
		
		if (!empty($tip))
		{
			$smarty->assign("$logedIDtype",$tip);
		}

		if (!empty($lozinka))
		{
			$smarty->assign("$logedIDpassword",$lozinka);
		}
		
		if(strlen(lozinka)<6)
		{
			$greska = array('box'=>'style="border: 1pt solid #FF0000"', 'greska'=>'Lozinka mora sadržavati najmanje 6 znakova!');
			$smarty->assign("lenLoz", $greska);
			$greske++; 
		}
		
		if (!preg_match("/^.*(?=^.{6,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/", $lozinka))
		{
			$greska = array('box'=>'style="border: 1pt solid #FF0000"', 'greska'=>'Lozinka mora sadržavati mala i velika slova, brojeve te specijalne znakove!');
			$smarty->assign("znakLoz", $greska);
			$greske++; 
		}
		
		if($_FILES["slika"]["error"]  == UPLOAD_ERR_OK)
		{
			if (($_FILES['slika']['type'] == "image/gif") || ($_FILES['slika']['type'] == "image/jpeg") || ($_FILES['slika']['type'] == "image/png" ))
			{
				$dir = "slike/avatari/$korIme/";
				if (!is_dir($dir))
				{
					 mkdir("slike/avatari/$korIme/", 0777);
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
				
				$dir = "slike/avatari/$korIme/thumb/";
				if (!is_dir($dir))
				{
					mkdir("slike/avatari/$korIme/thumb/", 0777);
				}
				$remote_file = "slike/avatari/$korIme/thumb/".$_FILES["slika"]["name"];
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
				$thumbPath = "slike/avatari/$korIme/thumb/".$_FILES['slika']['name'];
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
			
			$ime = mysql_real_escape_string($ime);
			$prezime = mysql_real_escape_string($prezime);
			$email = mysql_real_escape_string($email);
			$lozinka = mysql_real_escape_string($lozinka);
			$zivotopis = mysql_real_escape_string($zivotopis);
			$status = mysql_real_escape_string($status);
			$tip = mysql_real_escape_string($tip);
			
			if(!empty($path))
			{
				$path = mysql_real_escape_string($path);	
				$thumbPath = mysql_real_escape_string($thumbPath);
				
				mysql_query("update korisnik set ime='$ime', prezime='$prezime', e_mail='$email', lozinka='$lozinka', status_korisnika_idstatus='$status', tip_korisnika_idtip='$tip', zivotopis='$zivotopis', avatar='$path', thumb='$thumbPath' where korisnicko_ime='$korIme' ") or die(mysql_error());
			}
			else
			{
				mysql_query("update korisnik set ime='$ime', prezime='$prezime', e_mail='$email', lozinka='$lozinka', status_korisnika_idstatus='$status', tip_korisnika_idtip='$tip', zivotopis='$zivotopis' where korisnicko_ime='$korIme' ") or die(mysql_error());
			}
			
			$conn::zatvori();
			
			header('Location: korisnici.php');
			//$smarty->assign("title", "Početna");
			//$smarty->display('datomala.tpl');
		}
		else
		{
			$smarty->assign("title", "Uređivanje");
			$smarty->display('editUser.tpl');
		}
	}
?>