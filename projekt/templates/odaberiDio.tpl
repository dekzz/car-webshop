{include file="_header.tpl"}
	<div id='sadrzaj'>
		<form id='unosKonfiguracija' enctype='multipart/form-data' action='unesiKonf.php' method='post'>
			<table border='0'>
				<tr>
					<td></td>
					<td>
						<select name='dio'>
							<option value="N/A">Odaberite dio</option>
							{section name=i loop=$parts} 
								<option {if ($confPart == $parts[i].iddio)}selected='selected'{/if} value="{$parts[i].iddio}">{$parts[i].naziv} - {$parts[i].opis} ({$parts[i].cijena} kn)</option>
							{/section}
						</select>
						<span id='ajaxResponse' class='greska'>
							{$dio.greska}
						</span>
					</td>
				</tr>
				<tr></tr>
				<tr>
					<td><label for='naziv'>Naziv:</label></td>
					<td>
						<input id='naziv' type='text' name='naziv' {$naziv.box} value='{$confName}'/> 
						<span id='ajaxResponse' class='greska'>
							{$naziv.greska}
						</span>
					</td>
				</tr>
				<tr>
					<td><label for='opis'>Opis:</label></td>
					<td>
						<input id='opis' type='text' name='opis' {$opis.box} value='{$confDesc}'/> 
						<span id='ajaxResponse' class='greska'>{$opis.greska}</span>
					</td>
				</tr>
				<tr>
					<td><label for='slika'>Slika:</label></td>
					<td>
						<input id='slika' type='file' name='slika' {$slika.box}>
						<span id='ajaxResponse' class='greska'>{$slika.greska}</span>
					</td>
				</tr>
				<tr>
					<td><label for='javno'>Javno:</label></td>
					<td>
						<select name='javno'>
							<option {if ($conf.javno == 0)}selected='selected'{/if} value="0">Ne</option>
							<option {if ($conf.javno == 1)}selected='selected'{/if} value="1">Da</option>
						</select>
					</td>
				</tr>
			</table>
			<p>
				<input type='hidden' name='confID' value='{$confID}'/>
				<input id='unesiKonf' type='submit' name='unesiKonf' value='Spremi konfiguraciju'/>
			</p>
			{$saved}
		</form>
	</div>
{include file="_footer.tpl"}