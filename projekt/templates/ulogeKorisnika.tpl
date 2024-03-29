{include file="_header.tpl"}
	<div id='sadrzaj'>
		<ul>
			<li>
				<b>NEREGISTRIRANI KORISNIK</b> je korisnik koji nema korisnički račun na sustavu. Članom sustava može postati u
				slučaju registracije na sustav, bilo putem OpenID računa (Google, Facebook i drugi sustavi koji podržavaju OID) ili
				putem ugrađenog sustava za registraciju korisnika. Korisnik se smatra registriranim tek nakon aktivacije računa putem
				aktivacijske poruke elektroničke pošte (link za aktivaciju vrijedi 24 sata). Neregistrirani korisnik ima mogućnost uvida u
				modele automobila i moguču dodatnu opremu sa cijenama te pregled galerije različitih modela automobila
			</li>
			<br/>
			<li>
				<b>REGISTRIRANI KORISNIK</b> je korisnik koji ima kreiran i aktiviran korisnički račun. U slučaju tri neuspješne prijave na
				sustav (za redom), korisniku se zaključava pristup sustavu; u tom slučaju se aktiviranje korisničkog računa obavlja od
				strane administratora sustava. U slučaju uspješne prijave na sustav, kreira se korisnička sesija koja traje ili do isteka
				vremena podešenog od strane servera ili do odjave korisnika sa sustava.
				Registrirani korisnik ima sva prava kao i neregistrirani korisnik plus mogućnost kreiranja, spremanja i pregledavanja
				svojih željenih konfiguracija automobila – odabir željenog motora, snage, boje te dodatne opreme prema želji.
				Odabrane stavke se spremaju u košaricu i korisnik može pregledavati sadržaj košarice, vidjeti iznos po stavkama,
				ukupni iznos te brisati suvišne elemente, nakon potvrde narudžba se prosljeđuje. Korisnik takoder može objaviti neke
				svoje konfiguracije kao javne koje onda drugi korisnici vide u njegovom profilu te ih mogu ocjenjivati i komentirati.
				Korisnik se može pretplatiti na e-mail vijesti o novim tipovima automobila ili posebnim akcijama i pogodnostima
			</li>	
			<br/>
			<li>
				<b>VODITELJ TRGOVINE</b> ima sve ovlasti kao i registrirani korisnik uz mogućnost kreiranja tipova automobila, motora,
				dodatne opreme, nekih predefiniranih linija koje imaju određenu dodatnu opremu (comfort, sport i sl.) te određivanja
				cijena svih elemenata uz dodavanje slika za pojedini dio i gotovu konfiguraciju. Voditelj trgovine može pregledavati sve
				naručene modele te im mijenjati status – npr potvrđeno, u proizvodnji, na putu i sl. Korisnicima se šalju e-mail poruke
				sa promjenama statusa njihovih narudžbi. Voditelj takoder može kreirati posebne vremenski ograničene akcije na
				odredene modele ili dijelove opreme (npr. besplatne zimske gume)
			</li>
			<br/>
			<li>
				<b>ADMINISTRATOR SUSTAVA</b> ima sva prava kao i voditelj trgovine uz ovlasti upravljanja korisničkim podacima
				svakog korisnika, uvida u statistiku rada sustava, uvid u statistiku pojedinog korisnika (sve prijave, status korisničkog
				računa), blokiranja korisničkih računa u slučaju povrede pravila korištenja (pritužba drugih korisnika, vulgarni
				komentari i tome slično), zamrzavanje korištenja računa na određeno vrijeme (X sati, X dana,...), deaktiviranje
				korisničkih računa u slučaju treće opomene, kreiranje trgovina, postavljanje voditelja. Osim toga, on ima mogućnost
				upravljanja "sustavskim vremenom" radi simuliranja protoka vremena na projektnoj aplikaciji
			</li>
		</ul>
	</div>
{include file="_footer.tpl"}