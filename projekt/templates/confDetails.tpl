{include file="_header.tpl"}

<div id = 'sadrzaj'> 
	<div id = "conf">
		<ul>	
			<br/>
			{section name=i loop=$conf}
				{if (!empty($conf[i].path_thumb))}
					<div class = 'imageGallery'><a href = '{$conf[i].path_slika}' class = "lightbox_trigger"><img src = '{$conf[i].path_thumb}' width="200" height="120" alt = 'slika'/></a></div>
				{/if}
			{/section}
			<div>
			<li>Broj:
				<ul>
					<li>
						{section name=i loop=$conf}
							{if (isset($conf[i].idkonfiguracije))}{$conf[i].idkonfiguracije}{/if}
						{/section}
					</li>
				</ul>
			</li>
			<li>Naziv:
				<ul>
					<li>
						{section name=i loop=$conf}
							{if (isset($conf[i].naziv))}{$conf[i].naziv}{/if}
						{/section}
					</li>
				</ul>
			</li>
			<li>Kreator:
				<ul>
					<li>
						{section name=i loop=$korisnik}
							{if (isset($korisnik[i].korisnicko_ime))}{$korisnik[i].korisnicko_ime}{/if}
						{/section}
					</li>
				</ul>
			</li>
			</div>
			<div id = "partBody">
			<li>Automobil:
				{section name=i loop=$auto}
					{if (!empty($auto[i].path_thumb))}
						<div class = 'imageGallery'><a href = '{$auto[i].path_slika}' class = "lightbox_trigger"><img src = '{$auto[i].path_thumb}' width="100" height="60" alt = 'slika'/></a></div>
					{/if}
				{/section}
				<ul>
					<li>
						{section name=i loop=$auto}
							{if (isset($auto[i].naziv))}{$auto[i].naziv}{/if}
						{/section}
					</li>
				</ul>
				<ul>
					<li>
						{section name=i loop=$auto}
							{if (isset($auto[i].model))}{$auto[i].model}{/if}
						{/section}
					</li>
				</ul>
			</li>
			<li>Dijelovi:
				{section name=i loop=$dio}
					{if (!empty($dio[i].path_thumb))}
						<div class = 'imageGallery'><a href = '{$dio[i].path_slika}' class = "lightbox_trigger"><img src = '{$dio[i].path_thumb}' width="100" height="60" alt = 'slika'/></a></div>
					{/if}
				{/section}
				<ul>
					<li>
						{section name=i loop=$dio}
							{if (isset($dio[i].naziv))}{$dio[i].naziv}{/if}
						{/section}
					</li>
					<li>
						{section name=i loop=$dio}
							{if (isset($dio[i].opis))}{$dio[i].opis}{/if}
						{/section}
					</li>
				</ul>
			</li>
			{section name=i loop=$conf}
				{if (isset($conf[i].opis))}
					<li>Opis:
						<ul>
							<li>
								{$conf[i].opis}
							</li>
						</ul>
					</li>
				{/if}
			{/section}
			<li>Cijena:
				<ul>
					<li> 
						{if (isset($cijena))}{$cijena}{/if} kn
					</li>
				</ul>
			</li>
			{section name=i loop=$conf}
				<form enctype='multipart/form-data' action='addToCart.php?id={$conf[i].idkonfiguracije}' method='post'>
				<input type='hidden' name='naziv' value='{$conf[i].naziv}'/>
				<input type='hidden' name='opis' value='{$opis[i].opis}'/>
				<input type='hidden' name='cijena' value='{$cijena}'/>
				<input type='hidden' name='backURL' value='3'/>
				<input id='add' type='submit' name='add' value='Dodaj'/> {$addedToCart}
			</form>
			{/section}
			<li>Ocjena:
					<ul>
					<li>
						<select name = "confRate" id = "confRate">
							<option>1</option>
							<option>2</option>
							<option>3</option>
							<option>4</option>
							<option>5</option>
						</select>
					
							<button type = "button" id = "rateConfButton" >Ocijeni!</button>
							<button type = "button" id = "getConfVotersNames" >Pogledaj ocjene!</button>
							
					</li>
					{if (isset($prosjek))}
						<li>Prosjek:
							{$prosjek}
						</li>
					{/if}
					</ul>
				</li>
				<li>
				
				</li>
			</div>
			<div id = "userRate">
			</div>
			<div id = "commentAnConf">
			<span >Komentiraj: </span><br/>
			<textarea id = "confCommentText" cols="40" rows = "4"></textarea><br/>
			<button type = "button" id = "postConfCommentButton" class = "rateConfButton">Komentiraj</button>
			</div>
			<div id = "userComments">
			</div>
		</ul>
	</div>
</div>

{include file="_footer.tpl"}