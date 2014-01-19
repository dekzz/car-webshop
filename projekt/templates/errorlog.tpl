{include file="_header.tpl"}
	<form id='logSearch' enctype='multipart/form-data' action='errorlog.php' method='post'>
		<input id='value' type='text' name='value' {$box} value='{$vrijednost}'/> 
		<input id='search' type='submit' name='search' value='Traži'/>
	</form>
	<div id="sadrzaj">
		{$log}
	</div>
{include file="_footer.tpl"}