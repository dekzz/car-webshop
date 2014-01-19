<?php
	include_once ('klase/framework.php');
	
	$korIme = $_GET['korIme'];
	$response = "";
	$conn = new DBConfig();
	
	$result = mysql_query("SELECT korisnicko_ime FROM korisnik WHERE korisnicko_ime= '" . $korIme . "';");

	if(mysql_num_rows($result)>0)
	{
		$response = "<username>" . $korIme . "</username>";
		echo $response;
	}
	else
	{
		echo "0";
	}
		
	$conn::zatvori();
?>