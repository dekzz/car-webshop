<?php
	include_once ('klase/framework.php');
	$pomak=0;
	function setTime()
	{
		$conn = new DBConfig();
		$url = "http://arka.foi.hr/PzaWeb/PzaWeb2004/config/pomak.xml";
		
		$fp = fopen($url,'r');
		$xml_string = fread($fp, 10000);
		fclose($fp); 
		$domdoc = new DOMDocument;
		$domdoc->loadXML($xml_string);
		      
		$params = $domdoc->getElementsByTagName('pomak');
		$sati = 0;
			
		foreach ($params as $param) {
			$attributes = $param->attributes;
			foreach ($attributes as $attr => $val) {
			    if($attr == "brojSati") {
			    $sati = $val->value;
				}
		    }
		}	
		mysql_query("UPDATE vrijeme SET pomak='$sati'");
		$conn::zatvori();
	}
	
	function getTime()
	{
		$conn = new DBConfig();
		$rs=mysql_query("select pomak from vrijeme;");
		while($row=mysql_fetch_array($rs)){
			$offset=$row['pomak'];
		}
		return $offset*60*60 + time();
		$conn::zatvori();
	}
?>