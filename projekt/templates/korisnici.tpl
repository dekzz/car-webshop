{include file="_header.tpl"}
	<div id="sadrzaj">
		<table id='popis' border="1"> 
			<tr><td><b> Slika </b></td><td><b>Korisničko ime </b></td> <td><b> Ime </b> </td> <td> <b> Prezime <b> </td> <td> <b>Email </b></td></tr>
			{section name=i loop=$users}
			<tr>
				<td> <img src="{$users[i].thumb}" height='40' width='40' > </td>
				<td>{$users[i].korisnicko_ime}</td>
				<td>{$users[i].ime}</td> 
				<td>{$users[i].prezime}</td> 
				<td>{$users[i].e_mail}</td>
				{if ($tip) == 3}
					<td> <a href="userDetails.php?id={$users[i].idkorisnik}" > Detalji </td>
					<td> <a href="editUser.php?editID={$users[i].idkorisnik}" > Uredi </td>
					<td> <a href="deleteUser.php?deleteID={$users[i].idkorisnik}" > Obriši </td>
				{/if}
			</tr>
			{/section}
		</table>

		{if $nrPages > 2}			
			{if $page > 1}
			    <a href="?page=1">&lt;&lt;</a>		
			    <a href="?page={$page-1}">&lt;</a>
			{/if}
			{section name=p start=$first loop=$last step=1}
			    {if $smarty.section.p.index==$page}
					<span>{$smarty.section.p.index}</span>
			    {else}
					<a href="?page={$smarty.section.p.index}">{$smarty.section.p.index}</a>
			    {/if}
			{/section}
			{if $page < $nrPages-1}			
			    <a href="?page={$page+1}">&gt;</a>
			    <a href="?page={$nrPages-1}">&gt;&gt;</a>	
			{/if}
	    {/if}		
	</div>
{include file="_footer.tpl"}