{include file="_header.tpl"}
	<div id='sadrzaj'>
		<form id='unosVozila' enctype='multipart/form-data' action='unesiVozilo.php' method='post'>
			<table border='0'>
				<tr>
					<td><label for='naziv'>Proizvođač:</label></td>
					<td>
						<input id='naziv' type='text' name='naziv' {$naziv.box} value='{$naziv.vrijednost}'/> 
						<span id='ajaxResponse' class='greska'>
							{$naziv.greska}
						</span>
					</td>
				</tr>
				<tr>
					<td><label for='model'>Model:</label></td>
					<td>
						<input id='model' type='text' name='model' {$model.box} value='{$model.vrijednost}'/> 
						<span id='ajaxResponse' class='greska'>{$model.greska}</span>
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
				<input id='unesiVozilo' type='submit' name='unesiVozilo' value='Unesi'/>
			</p>
			{$voziloPostoji}
			{$saved}
		</form>
	</div>
{include file="_footer.tpl"}