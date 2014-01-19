<?php
	include_once ('klase/framework.php');
	require'/var/www/Smarty-2.6.6/libs/Smarty.class.php';
	include_once ('recaptchalib.php');
	session_start();
	$smarty= new Smarty();
	
	$publickey="6Ld_rtASAAAAAJNlALkuPEmf2Tt7MrWPOWBoLFqS";
	$privatekey="6Ld_rtASAAAAAHr-9yTZ-qubT45qy81Do7aYT3WU";	

	if (isset($_POST['saljiReg']))
	{
		$ime = $_POST['ime'];
		$prezime = $_POST['prezime'];
		$email = $_POST['email'];
		$korIme = $_POST['korIme'];
		$lozinka = $_POST['lozinka'];
		$potvrLoz = $_POST['potvrLoz'];
		$dan = $_POST['dan'];
		$mjesec = $_POST['mjesec'];
		$godina = $_POST['godina'];
		$zivotopis = $_POST['zivotopis'];
		$mail = $_POST['mail'];
		
		if (empty($ime))
		{
			$greska = array('box'=>'style="border: 1pt solid #FF0000"', 'greska'=>'Unesite ime!');
			$smarty->assign("ime", $greska);
			$greske++;  
		}
		else
		{
			$vrijednost = array('vrijednost'=>$ime);
			$smarty->assign("ime",$vrijednost);
		}
		
		if (empty($prezime))
		{
			$greska = array('box'=>'style="border: 1pt solid #FF0000"', 'greska'=>'Unesite prezime!');
			$smarty->assign("prezime",$greska);
			$greske++;  
		}
		else
		{
			$vrijednost = array('vrijednost'=>$prezime);
			$smarty->assign("prezime",$vrijednost);
		}
		
		if (empty($email))
		{
			$greska = array('box'=>'style="border: 1pt solid #FF0000"', 'greska'=>'Unesite email!');
			$smarty->assign("email",$greska);
			$greske++; 
		}
		else
		{
			$vrijednost = array('vrijednost'=>$email);
			$smarty->assign("email",$vrijednost);
		}
		
		if (empty($korIme))
		{
			$greska = array('box'=>'style="border: 1pt solid #FF0000"', 'greska'=>'Unesite korisničko ime!');
			$smarty->assign("korIme", $greska);
			$greske++; 
		}
		else
		{
			$vrijednost = array('vrijednost'=>$korIme);
			$smarty->assign("korIme",$vrijednost);
		}
		
		if (empty($lozinka))
		{
			$greska = array('box'=>'style="border: 1pt solid #FF0000"', 'greska'=>'Unesite lozinku!');
			$smarty->assign("lozinka", $greska);
			$greske++; 
		}
		else
		{
			$vrijednost = array('vrijednost'=>$lozinka);
			$smarty->assign("lozinka",$vrijednost);
		}
		
		if(strlen(lozinka)<6)
		{
			$greska = array('box'=>'style="border: 1pt solid #FF0000"', 'greska'=>'Lozinka mora sadržavati najmanje 6 znakova!');
			$smarty->assign("lenLoz", $greska);
			$greske++; 
		}
		
		if (!preg_match("#.*^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*$#", $lozinka))
		{
			$greska = array('box'=>'style="border: 1pt solid #FF0000"', 'greska'=>'Lozinka mora sadržavati mala i velika slova, brojeve te specijalne znakove!');
			$smarty->assign("znakLoz", $greska);
			$greske++; 
		}
		
		if (empty($potvrLoz))
		{
			$greska = array('box'=>'style="border: 1pt solid #FF0000"', 'greska'=>'Potvrdite lozinku!');
			$smarty->assign("potvrLoz", $greska);
			$greske++; 
		}
		
		if ($lozinka !== $potvrLoz)
		{
			$greska = array('box'=>'style="border: 1pt solid #FF0000"', 'greska'=>'Lozinke se ne podudaraju!');
			$smarty->assign("lozEq", $greska);
			$greske++; 
		}

		if(empty($_FILES['avatar']['name']))
		{
			$greska = array('box'=>'style="border: 1pt solid #FF0000"', 'greska'=>'Obavezno postaviti sliku!');
			$smarty->assign("slika", $greska);
			$greske++; 
		}
		else
		{
			if (($_FILES['avatar']['type'] == "image/gif") || ($_FILES['avatar']['type'] == "image/jpeg") || ($_FILES['avatar']['type'] == "image/png" ))
			{
				$dir = "slike/avatari/$korIme/";
				if (!is_dir($dir))
				{
					 mkdir("slike/avatari/$korIme/", 0777);
				}
				
				$path = $dir . $_FILES['avatar']['name'];
				$copied = copy($_FILES['avatar']['tmp_name'], $path);
				if(!$copied)
				{
					$greska = array('box'=>'style="border: 1pt solid #FF0000"', 'greska'=>'Greška kod uploada!');
					$smarty->assign("slika", $greska);
					$greske++;
				}
				
				$max_upload_width = 40;
				$max_upload_height = 40;
				
				// if uploaded image was JPG/JPEG
				if($_FILES["avatar"]["type"] == "image/jpeg" || $_FILES["avatar"]["type"] == "image/pjpeg"){	
					$image_source = imagecreatefromjpeg($_FILES["avatar"]["tmp_name"]);
				}		
				// if uploaded image was GIF
				if($_FILES["avatar"]["type"] == "image/gif"){	
					$image_source = imagecreatefromgif($_FILES["avatar"]["tmp_name"]);
				}				
				// if uploaded image was PNG
				if($_FILES["avatar"]["type"] == "image/x-png"){
					$image_source = imagecreatefrompng($_FILES["avatar"]["tmp_name"]);
				}
				
				$dir = "slike/avatari/$korIme/thumb/";
				if (!is_dir($dir))
				{
					mkdir("slike/avatari/$korIme/thumb/", 0777);
				}
				$remote_file = "slike/avatari/$korIme/thumb/".$_FILES["avatar"]["name"];
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
				$thumbPath = "slike/avatari/$korIme/thumb/".$_FILES['avatar']['name'];
				move_uploaded_file($_FILES["avatar"]["tmp_name"], $thumbPath);
				
			}		
			else
			{
				$greska = array('box'=>'style="border: 1pt solid #FF0000"', 'greska'=>'Podržani formati: .gif .jpg .png');
				$smarty->assign("slika", $greska);
				$greske++;
			}
		}
		
		$conn = new DBConfig();
		$result = mysql_query("SELECT * FROM korisnik WHERE korisnicko_ime = '".$korIme."'");
		
		if (mysql_num_rows($result) == 1)
		{
			$greska = array('box'=>'style="border: 1pt solid #FF0000"', 'greska'=>'Korisničko ime zauzeto!');
			$smarty->assign("korImeZauzeto", $greska);
			$greske++; 
		}
		
		if ($_POST["recaptcha_response_field"])
		{
			
				$resp = recaptcha_check_answer ($privatekey,
												$_SERVER["REMOTE_ADDR"],
												$_POST["recaptcha_challenge_field"],
												$_POST["recaptcha_response_field"]);		
				if ($resp->is_valid)
				{	
				} 
				else
				{				
					$error = $resp->error;
					$errors['recaptcha'] = "Pokušajte ponovno!";
					$greske++;			
				}
		}
		else
		{
			$errors['recaptcha'] = "Pokušajte ponovno!";
		}
		$smarty->assign("recaptcha", recaptcha_get_html($publickey, $error));

		if(empty($mail))
		{
			$greska = array('box'=>'style="border: 1pt solid #FF0000"', 'greska'=>'Odaberite opciju!');
			$smarty->assign("mail", $greska);
			$greske++; 
		}
		else
		{
			$vrijednost = array('vrijednost'=>$mail);
			$smarty->assign("mail", $vrijednost);
		}
		
		if(!empty($mail))
		{
			if($mail == 'Da')
			{
				$obavijest = 1;
			}
			if($mail == 'Ne')
			{
				$obavijest = 0;
			}
		}
		
		if(empty($_POST['uvjeti']))
		{
			$greska = array('box'=>'style="border: 1pt solid #FF0000"', 'greska'=>'Morate prihvatiti uvjete korištenja!');
			$smarty->assign("uvjeti", $greska);
			$greske++; 
		}
		
		$datRod = $dan . "." . $mjesec . "." . $godina . ".";
		
		if($greske==0)
		{			
			$ime = mysql_real_escape_string($_POST['ime']);
			$prezime = mysql_real_escape_string($_POST['prezime']);
			$email = mysql_real_escape_string($_POST['email']);
			$korIme = mysql_real_escape_string($_POST['korIme']);
			$lozinka = mysql_real_escape_string($_POST['lozinka']);
			$potvrLoz = mysql_real_escape_string($_POST['potvrLoz']);
			$zivotopis = mysql_real_escape_string($_POST['zivotopis']);
			$mail = mysql_real_escape_string($_POST['mail']);
		
			$activCode = mt_rand() . mt_rand() . mt_rand() .mt_rand() . mt_rand();
			$created = date("Y-m-d H:i:s");
			$expires = date('Y-m-d H:i:s', strtotime($crated .'+1 day'));

			mysql_query("insert into korisnik (ime, prezime, e_mail, avatar, thumb, korisnicko_ime, lozinka, datRodenja, zivotopis, obavijest, aktivKod, aktivDatum) values ('$ime', '$prezime', '$email', '$path', '$thumbPath', '$korIme', '$lozinka', '$datRod', '$zivotopis', '$obavijest', '$activCode', '$expires')") or die(mysql_error());

			$conn::zatvori();
		
			$subject = "Aktivacijski kod za registraciju!";
			$message = "Postovanje, $ime!\nZa aktivaciju Vaseg racuna, molimo slijedite sljedeci link:\n http://arka.foi.hr/WebDiP/2011_projekti/WebDiP2011_122/datomala/aktivacija.php?$activCode\nAktivacijski link vrijedi 24h.";
			$headers = 'From: webmaster@webdip_122.foi' . "\r\n" . 'X-Mailer: datomala-webdip';
			mail($email, $subject, $message, $headers);
			
			$smarty->assign("poslano","Za aktivacju korisničkog računa slijedite upute dobivene e-mailom!");
			$smarty->assign("title", "Aktivacija");
			$smarty->display('aktivacija.tpl');
		}
		else
		{
			$smarty->assign("title", "Registracija");
			$smarty->display('datomala_reg.tpl');
		}
	}
?>