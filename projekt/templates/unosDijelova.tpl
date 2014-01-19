{include file="_header.tpl"}
	<div id='sadrzaj'>
		<form id='unosDijelova' enctype='multipart/form-data' action='unesiDio.php' method='post'>
			<table border='0'>
				<tr>
					<td><label for='auto'>Automobil:</label></td>
					<td>
						<select name='auto'>
							<option value="N/A">Odaberite vozilo</option>
							{section name=i loop=$cars} 
								<option value="{$cars[i].idautomobil}">{$cars[i].naziv} {$cars[i].model}</option>
							{/section}
						</select>
						<span id='ajaxResponse' class='greska'>
							{$automobil.greska}
						</span>
					</td>
				</tr>
				<tr>
					<td><label for='naziv'>Naziv:</label></td>
					<td>
						<input id='naziv' type='text' name='naziv' {$naziv.box} value='{$naziv.vrijednost}'/> 
						<span id='ajaxResponse' class='greska'>
							{$naziv.greska}
						</span>
					</td>
				</tr>
				<tr>
					<td><label for='opis'>Opis:</label></td>
					<td>
						<input id='opis' type='text' name='opis' {$opis.box} value='{$opis.vrijednost}'/> 
						<span id='ajaxResponse' class='greska'>{$opis.greska}</span>
					</td>
				</tr>
				<tr>
					<td><label for='cijena'>Cijena:</label></td>
					<td>
						<input id='cijena' type='text' name='cijena' {$cijena.box} value='{$cijena.vrijednost}'/> 
						<span id='ajaxResponse' class='greska'>{$cijena.greska}</span>
					</td>
				</tr>
				<tr>
					<td><label for='akcija'>Akcija:</label></td>
					<td>
						<input id='akcija' type='text' name='akcija' {$akcija.box} value='{$akcija.vrijednost}'/> 
						<span id='ajaxResponse' class='greska'>{$akcija.greska}</span>
					</td>
				</tr>
				<tr>
					<td><label for='slika'>Slika:</label></td>
					<td>
						<input id='slika' type='file' name='slika' {$slika.box}>
						<span id='ajaxResponse' class='greska'>{$slika.greska}</span>
					</td>
				</tr>
			</table>
			<p>
				<input id='unesiDio' type='submit' name='unesiDio' value='Unesi'/>
			</p>
			{$saved}
		</form>
	</div>
{include file="_footer.tpl"}