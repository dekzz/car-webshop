<?php
	class DBConfig {
		public function __construct() {
			global $server, $user, $password, $database;
			mysql_connect($server, $user, $password) or die(mysql_error());
			mysql_select_db($database) or die(mysql_error());
			mysql_query("set names utf8");
		}
		
		public function upit($sql) {
			global $debug;
			if ($debug) echo $sql;
			$rs = mysql_query($sql) or die (mysql_error());		
			return $rs;
		}
		
		public function zatvori() {
			mysql_close();
		}	
	}
?>