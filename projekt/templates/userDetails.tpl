{include file="_header.tpl"}

<div id = 'sadrzaj'> 
	{section name=i loop=$user}
	<form enctype='multipart/form-data' action='editUser.php?editID={$user[i].idkorisnik}' method='post'>
			<div id = "user">
				<ul>	
					<br/>
					{if (!empty($user[i].thumb))}
						<div class = 'imageGallery'><a href = '{$user[i].avatar}' class = "lightbox_trigger"><img src = '{$user[i].thumb}' width="40" height="40" alt = 'slika'/></a></div>
					{/if}
					<div>
					<li>ID korisnika:
						<ul>
							<li>
								{if (isset($user[i].idkorisnik))}{$user[i].idkorisnik}{/if}
							</li>
						</ul>
					</li>
					</div>
					<li>Korisničko ime:
						<ul>
							<li>
								{if (isset($user[i].korisnicko_ime))}{$user[i].korisnicko_ime}{/if}
							</li>	
						</ul>
					</li>
					<li>Ime i prezime:
						<ul>
							<li> 
								{if (isset($user[i].ime))}{$user[i].ime}{/if} {if (isset($user[i].prezime))}{$user[i].prezime}{/if}
							</li>
						</ul>
					</li>
					<li>Email:
						<ul>
							<li> 
								{if (isset($user[i].e_mail))}{$user[i].e_mail}{/if}
							</li>
						</ul>
					</li>
					{if (!empty($user[i].datRodjenja))}
					<li>Datum rođenja:
						<ul>
							<li> 
								{$user[i].datRodjenja}
							</li>
						</ul>
					</li>
					{/if}
					{if (!empty($user[i].zivotopis))}
					<li>Životopis:
						<ul>
							<li> 
								{$user[i].zivotopis}
							</li>
						</ul>
					</li>
					{/if}
					<li>Neuspjele prijave:
						<ul>
							<li>
								{if (isset($user[i].neuspjesna_prijava))}{$user[i].neuspjesna_prijava}{/if}
							</li>	
						</ul>
					</li>
					{if (isset($user[i].blokiran_do))}
					<li>Blokiran do:
						<ul>
							<li> 
								{$user[i].blokiran_do}
							</li>
						</ul>
					</li>
					{/if}
				</ul>
			</div>
		{/section}
		<p>
			<input id='edit' type='submit' name='edit' value='Uredi'/>
		</p>
	</form>
</div>

{include file="_footer.tpl"}