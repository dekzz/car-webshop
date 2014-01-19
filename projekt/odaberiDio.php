<?php
	include_once ('klase/framework.php');
	require'/var/www/Smarty-2.6.6/libs/Smarty.class.php';
	session_start();
	$smarty= new Smarty();
	
	if (!isset($_SESSION['user']))
	{
		$smarty->assign("restrict","Za unos konfiguracija se potrebno prijaviti!");
		$smarty->assign("title", "Početna");
		$smarty->display('datomala.tpl');
	}
	
	if(isset($_SESSION['user']))
	{
		if (isset($_POST['odaberiDio']))
		{
			$autoID = $_POST['auto'];
			
			if (empty($autoID))
			{
				$greska = array('box'=>'style="border: 1pt solid #FF0000"', 'greska'=>'Odaberite automobil!');
				$smarty->assign("auto", $greska);
				$smarty->assign("title", "Odabir automobila");
				$smarty->display("unosKonfiguracija.tpl");  
			}
			else
			{
				$vrijednost = array('vrijednost'=>$automobil);
				$smarty->assign("auto",$vrijednost);
			
				$conn = new DBConfig();
				$result = mysql_query("SELECT * FROM dijelovi where automobil_idautomobil='$autoID'");
				while ($row = mysql_fetch_assoc($result))
				{
				   $parts[] = $row;
				}

				if(isset($_SESSION['saved']))
				{
					$smarty->assign("saved", $_SESSION['saved']);
					unset($_SESSION['saved']);
				}
				
				if(isset($_POST['confID']))
				{
					$confID = $_POST['confID'];
					$smarty->assign("confID", $confID);
				}
				
				$sql = mysql_query("SELECT * FROM konfiguracije WHERE idkonfiguracije='$confID'") or die(mysql_error());
				$conf = mysql_fetch_array($sql);
				
				$confName = $conf[1];
				$confPart = $conf[5];
				$confDesc = $conf[6];
					
				$smarty->assign("confName", $confName);
				$smarty->assign("confPart", $confPart);
				$smarty->assign("confDesc", $confDesc);
				$smarty->assign("parts", $parts);
				$smarty->assign("title", "Odabir dijelova");
				$smarty->display("odaberiDio.tpl");
			}
		}
	}
?>