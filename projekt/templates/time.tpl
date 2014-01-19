{include file="_header.tpl"}
	<div id="sadrzaj">
	<center>
		<a id="pomak" href="http://arka.foi.hr/PzaWeb/PzaWeb2004/config/vrijeme.html" target="_blank"> Pomak vremena </a>
		<h4>Stvarno vrijeme: {$smarty.now|date_format:"%d. %m. %Y. %H:%M:%S"}</h4>
        <h4>Sustavsko vrijeme: {$time|date_format:"%d. %m. %Y. %H:%M:%S"}</h4>
        <form method="post" action="time.php">
            <input id="getTime" type="submit" name="getTime" value="Preuzmi vrijeme"/>
        </form>
	</center>
	</div>
{include file="_footer.tpl"}
