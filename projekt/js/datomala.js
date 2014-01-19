function echo(objekt)
{
	console.log(objekt);
}
window.onload=function()
{
	var sPath = window.location.pathname;
	var sPage =  sPath.substring(sPath.lastIndexOf('/') + 1);
	var postojiSubmit = document.querySelectorAll("input[type=submit]");
	var log = document.getElementById("korisIme");
	if(log)
	{
		var form = log.form;
		for(i=0;i<form.elements.length;i++)
		{
			var el=form.elements[i];
			el.addEventListener('focus',over,true);
			el.addEventListener('blur',out,true);
		}
	}
	var reg = document.getElementById("ime");
	if(reg)
	{
		var form = reg.form;
		for(i=0;i<form.elements.length;i++)
		{
			var el=form.elements[i];
			el.addEventListener('focus',over,true);
			el.addEventListener('blur',out,true);
		}
	}
	
	if(postojiSubmit.length!=0)
	{
		var button = postojiSubmit[0];
		echo(button);
		
		var zapamti=document.getElementById('zapamti');
		if(zapamti)
		{
			button.addEventListener('click',checkLogin,true);
		}
		
		var button = postojiSubmit[1];
		echo(button);
		var potvrda=document.getElementById('ime');
		if(potvrda)
		{
			button.addEventListener('click',checkRegister,true);
		}
	}
	
	if (sPage == "automobili.php")
	{
		$.ajax({
			type: 'GET',
			url: 'carsPaging.php',
			dataType: 'xml',
			success: displayCarsXML,
			
		})
	} 
	
	if (sPage == "dijelovi.php")
	{
		$.ajax({
			type: 'GET',
			url: 'partsPaging.php',
			dataType: 'xml',
			success: displayPartsXML,
			
		})
	} 
	
	if (sPage == "konfiguracije.php")
	{
		$.ajax({
			type: 'GET',
			url: 'confPaging.php',
			dataType: 'xml',
			success: displayConfXML, //function(data){ console.log(data);},
									 //error: function(err) { console.log(err); }
			
		})
	} 
	if (sPage == "mojeKonfiguracije.php")
	{
		$.ajax({
			type: 'GET',
			url: 'myConfPaging.php',
			dataType: 'xml',
			success: displayMyConfXML, //function(data){ console.log(data);},
									   //error: function(err) { console.log(err); }
			
		})
	} 
	
	if (sPage == 'carDetails.php')
	{
		var url = document.location.href;
		var sUrl =  url.substring(url.lastIndexOf('=')+1);
		$(document).ready(function() {
			loadCarComments(sUrl);
		})
		if (sUrl.charAt(1) == "#")
		{
			sUrl = sUrl.slice(0,1);
		}
		else if (sUrl.charAt(2) == "#")
		{
			sUrl = sUrl.slice(0,2);
		}
		
		var input = $("#rateCarButton").click({param1: sUrl}, rateCar);
		var input2 =$("#getCarVotersNames").click({param1:sUrl},getCarVoters);
		var input3 = $("#postCarCommentButton").click({param1:sUrl},postCarComment);
		var input4 = $("#komentiraj").click(subCommentCar);
	}
	
	if (sPage == 'partDetails.php')
	{
		var url = document.location.href;
		var sUrl =  url.substring(url.lastIndexOf('=')+1);
		$(document).ready(function() {
			loadPartComments(sUrl);
		})
		if (sUrl.charAt(1) == "#")
		{
			sUrl = sUrl.slice(0,1);
		}
		else if (sUrl.charAt(2) == "#")
		{
			sUrl = sUrl.slice(0,2);
		}
		
		var input = $("#ratePartButton").click({param1: sUrl}, ratePart);
		var input2 =$("#getPartVotersNames").click({param1:sUrl},getPartVoters);
		var input3 = $("#postPartCommentButton").click({param1:sUrl},postPartComment);
		var input4 = $("#komentiraj").click(subCommentPart);
	}
	
	if (sPage == 'confDetails.php')
	{
		var url = document.location.href;
		var sUrl =  url.substring(url.lastIndexOf('=')+1);
		$(document).ready(function() {
			loadConfComments(sUrl);
		})
		if (sUrl.charAt(1) == "#")
		{
			sUrl = sUrl.slice(0,1);
		}
		else if (sUrl.charAt(2) == "#")
		{
			sUrl = sUrl.slice(0,2);
		}
		
		var input = $("#rateConfButton").click({param1: sUrl}, rateConf);
		var input2 =$("#getConfVotersNames").click({param1:sUrl},getConfVoters);
		var input3 = $("#postConfCommentButton").click({param1:sUrl},postConfComment);
		var input4 = $("#komentiraj").click(subCommentConf);
	}
	
	$(document).ready(function()
		{	
			var input5 = $('.lightbox_trigger').click(lightbox);
			
			$('#lightbox').live('click', function() 
			{
				$('#lightbox').hide();
			});
			$(document).keyup(function(e) {

				if (e.keyCode == 27) 
				{ 
					$('#lightbox').hide();
				} 
			});
				
		})
}

function checkLogin(event)
{
	echo(event);
	
	var zapamti=document.getElementById('zapamti');
	var forma = zapamti.form;
	if(zapamti!=null)
	{
		var stare = document.querySelectorAll('span.greska');
		for(i = 0; i < stare.length; i++) 
		{
			stare[i].parentNode.removeChild(stare[i]);
		}
		for(i=0;i<=1;i++)
		{
			var element = forma.elements[i];
			if(element.value!="")
			{
				element.style.border="";
			}
			else
			{
				event.preventDefault();
				var greska = document.createElement('span');
				element.style.border="1pt solid #FF0000";
				greska.className='greska';
				if(i==0)
				{
					greska.innerHTML='Unesite korisničko ime!';
					echo('Unesite korisničko ime!');
				}
				else
				{
					greska.innerHTML='Unesite lozinku!';
					echo('Unesite lozinku!');
				}
				element.parentNode.appendChild(greska);
			}
		}
	}	
}

function checkRegister(event)
{
	echo(event);
	
	var potvrda=document.getElementById('ime');
	var forma = potvrda.form;
	if(potvrda!=null)
	{
		var stare = document.querySelectorAll('span.greska');
		for(i = 0; i < stare.length; i++)
		{
			stare[i].parentNode.removeChild(stare[i]);
		}
		for(i=0;i<=9;i++)
		{
			var element = forma.elements[i];
			if(element.value!="")
			{
				element.style.border="";
				var greska = document.createElement('span');
				greska.className='greska';
				
				if(i==0)
				{
					var znakovi = /^[A-ZČĆŠĐŽ]+[a-zčćšđž]*$/;
					if(!znakovi.test(element.value))
					{
						event.preventDefault();
						element.style.border="1pt solid #FF0000";
						greska.innerHTML='Ime mora započeti velikim slovom, te sadržavati samo znakove!';
						element.parentNode.appendChild(greska);
					}
				}
				else if(i==1)
				{
					var znakovi = /^[A-ZČĆŠĐŽ]+[a-zčćšđž]*$/;
					if(!znakovi.test(element.value))
					{
						event.preventDefault();
						element.style.border="1pt solid #FF0000";
						greska.innerHTML='Prezime mora započeti velikim slovom, te sadržavati samo znakove!';
						element.parentNode.appendChild(greska);
					}
				}
				else if(i==2)
				{
					var email = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
					if(!email.test(element.value))
					{
						event.preventDefault();
						element.style.border="1pt solid #FF0000";
						greska.innerHTML='Neispravan format e-maila!';
						element.parentNode.appendChild(greska);
					}
				}

				else if(i==4)
				{
					if(element.value.length<6)
					{
						event.preventDefault();
						element.style.border="1pt solid #FF0000";
						greska.innerHTML='Lozinka mora sadržavati najmanje 6 znakova!';
						element.parentNode.appendChild(greska);
					}
					var znakovi = new RegExp("^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*\\W).*$", "g");
					if(!znakovi.test(element.value))
					{
						event.preventDefault();
						element.style.border="1pt solid #FF0000";
						greska.innerHTML='Lozinka mora sadržavati mala, velika slova, brojeve i posebne znakove!';
						element.parentNode.appendChild(greska);
					}
				}
				else if(i==5)
				{
					if(element.value != forma.elements[4].value)
					{
						event.preventDefault();
						element.style.border="1pt solid #FF0000";
						greska.innerHTML='Lozinke se ne poklapaju!';
						element.parentNode.appendChild(greska);
					}
				}			
			}
			else
			{
				event.preventDefault();
				
				var greska = document.createElement('span');
				element.style.border="1pt solid #FF0000";
				greska.className='greska';
				if(i==0)
				{
					greska.innerHTML='Unesite ime!';
				}
				else if(i==1)
				{
					greska.innerHTML='Unesite prezime!';
				}
				else if(i==2)
				{
					greska.innerHTML='Unesite e-mail!';
				}
				else if(i==3)
				{
					greska.innerHTML='Unesite korisničko ime!';
				}
				else if(i==4)
				{
					greska.innerHTML='Unesite lozinku!';
				}
				else if(i==5)
				{
					greska.innerHTML='Unesite potvrdu lozinke!';
				}
				else if(i==6)
				{
					greska.innerHTML='Unesite datum rođena!';
				}
				else if(i==7)
				{
					greska.innerHTML='Odaberite sliku!';
				}
				element.parentNode.appendChild(greska);
			}
		}
		
		var uvjeti= document.getElementById('uvjeti');
		echo(uvjeti.checked);
		if(!uvjeti.checked)
		{
			event.preventDefault();
			var greska = document.createElement('span');
			greska.className='greska';
			greska.innerHTML='Morate prihvatiti uvjete korištenja!';
			uvjeti.parentNode.appendChild(greska);
		}
	}
}

function checkUser()
{
	$.ajax({
		type: "GET",
		url: "userCheck.php",
		data: 
		{
			"korIme": $("#korIme").val()
		},
		success: function(result)
		{
			console.log(result);
			if(result != 0)
			{
				var greska = document.createElement('span');
				greska.className='greska';
				var korIme=document.getElementById('korIme');
				var forma = korIme.form;
				var element = forma.elements[3];
				element.style.border="1pt solid #FF0000";
				greska.innerHTML='Korisničko ime zauzeto!';
				element.parentNode.appendChild(greska);
			}
			else
			{
				echo('Korisničko ime u redu!');
			}
		}
    });
	
}
$("#korIme").focusout(function()
{
	console.log("AJAX provjera korisničkog imena");
	checkUser();
});

var list = new Array();
list = $("#popis");
for(i=0; i<list.length; i++)
{
	if(list[i] != null)
	{
		var row = document.getElementsByTagName('tr');
		for(j=0;j<row.length;j++)
		{
			row[j].addEventListener('mouseover',overRow,true);
			row[j].addEventListener('mouseout',outRow,true);
		}
	}
}

/*
var list = new Array();
list = $("#automobiliList");
if(list[0] != null)
{
	var row = document.getElementsByTagName('tr');
	for(i=0;i<row.length;i++)
	{
		row[i].addEventListener('mouseover',overRow,true);
		row[i].addEventListener('mouseout',outRow,true);
	}
}

var list = new Array();
list = $("#dijeloviList");
if(list[0] != null)
{
	var row = document.getElementsByTagName('tr');
	for(i=0;i<row.length;i++)
	{
		row[i].addEventListener('mouseover',overRow,true);
		row[i].addEventListener('mouseout',outRow,true);
	}
}
*/

function displayCarsXML(xml)
{	
	var tablica = $('<table id = "automobili" class="popis">');
	tablica.append("<td> Proizvođač </td><td> Model </td><td> Cijena </td><td> Slika </td>");
	
	$(xml).find("car").each(function(){
		if($(this).find("tip").text() > 1)
		{
			tablica.append("<tr><ul><li><td>" + $(this).find("naziv").text() + "</td></li><td>" + $(this).find("model").text() + "</td><td>" + $(this).find("cijena").text() + "</td><td> <img src=" + $(this).find("thumb").text() + " height='40' width='40'> </td><td><a href = 'carDetails.php?id=" + $(this).find("rb").text() + "'>Detalji</a></td><td><a href = 'editCar.php?editID=" + $(this).find("rb").text() + "'>Uredi</a></td><td><a href = 'deleteCar.php?deleteID=" + $(this).find("rb").text() + "'>Obriši</a></td></tr>");
		}
		else if ($(this).find("tip").text() == 1)
		{
			tablica.append("<tr><ul><li><td>" + $(this).find("naziv").text() + "</td></li><td>" + $(this).find("model").text() + "</td><td>" + $(this).find("cijena").text() + "</td><td> <img src=" + $(this).find("thumb").text() + " height='40' width='40'> </td><td><a href = 'carDetails.php?id=" + $(this).find("rb").text() + "'>Detalji</a></td></tr>");
		}
		else
		{
			tablica.append("<tr><ul><li><td>" + $(this).find("naziv").text() + "</td></li><td>" + $(this).find("model").text() + "</td><td>" + $(this).find("cijena").text() + "</td><td> <img src=" + $(this).find("thumb").text() + " height='40' width='40'> </td></tr>");
		}
		});

	$('#pagingCars').append(tablica);


	$('#pagingCars').append("<div class='pager'><a href='#' alt='Previous' class='prevPage'> << </a><span class='currentPage'>&nbsp;</span>/<span class='totalPages'>&nbsp;</span><a href='#' alt='Next' class='nextPage'> >> </a></div>");
	$('#automobili').paginateTable({ rowsPerPage: 10 });
	$('#pagingCars').show('blind', 1000);
}

function displayPartsXML(xml)
{	
	var tablica = $('<table id = "dijelovi" class="popis">');
	tablica.append("<td> Naziv dijela </td><td> Dio za </td><td> Opis </td><td> Cijena </td><td> Slika </td>");
	
	$(xml).find("part").each(function(){
		if($(this).find("tip").text() > 1)
		{
			tablica.append("<tr><ul><li><td>" + $(this).find("naziv").text() + "</td></li><td>" + $(this).find("dioza").text() + "</td><td>" + $(this).find("opis").text() + "</td><td>" + $(this).find("cijena").text() + "</td><td> <img src=" + $(this).find("thumb").text() + " height='40' width='40'> </td><td><a href = 'partDetails.php?id=" +$(this).find("rb").text() + "'>Detalji</a></td><td><a href = 'editPart.php?editID=" + $(this).find("rb").text() + "'>Uredi</a></td><td><a href = 'deletePart.php?deleteID=" + $(this).find("rb").text() + "'>Obriši</a></td></tr>");
		}
		else if ($(this).find("tip").text() == 1)
		{
			tablica.append("<tr><ul><li><td>" + $(this).find("naziv").text() + "</td></li><td>" + $(this).find("dioza").text() + "</td><td>" + $(this).find("opis").text() + "</td><td>" + $(this).find("cijena").text() + "</td><td> <img src=" + $(this).find("thumb").text() + " height='40' width='40'> </td><td><a href = 'partDetails.php?id=" +$(this).find("rb").text() + "'>Detalji</a></td></tr>");
		}
		else
		{
			tablica.append("<tr><ul><li><td>" + $(this).find("naziv").text() + "</td></li><td>" + $(this).find("dioza").text() + "</td><td>" + $(this).find("opis").text() + "</td><td>" + $(this).find("cijena").text() + "</td><td> <img src=" + $(this).find("thumb").text() + " height='40' width='40'> </td></tr>");
		}
		});
		
	$('#pagingParts').append(tablica);
	
	$('#pagingParts').append("<div class='pager'><a href='#' alt='Previous' class='prevPage'> << </a><span class='currentPage'>&nbsp;</span>/<span class='totalPages'>&nbsp;</span><a href='#' alt='Next' class='nextPage'> >> </a></div>");
	$('#dijelovi').paginateTable({ rowsPerPage: 10 });
	$('#pagingParts').show('blind', 1000);
}

function displayConfXML(xml)
{	
	var tablica = $('<table id = "konfiguracije" class="popis">');
	tablica.append("<td> Oznaka </td><td> Naziv </td><td> Kupac </td><td> Automobil </td><td> Dio </td><td> Cijena </td><td> Slika </td>");
	$(xml).find("conf").each(function(){
		if($(this).find("tip").text() > 1)
		{
			tablica.append("<tr><ul><li><td>" + $(this).find("rb").text() + "</td></li><td>" + $(this).find("naziv").text() + "</td><td>" + $(this).find("kupac").text() + "</td><td>" + $(this).find("automobil").text() + "</td><td>" + $(this).find("dio").text() + "</td><td>" + $(this).find("cijena").text() + "</td><td> <img src=" + $(this).find("thumb").text() + " height='40' width='40'> </td><td><a href = 'confDetails.php?id=" +$(this).find("rb").text() + "'>Detalji</a></td><td><a href = 'editConf.php?editID=" + $(this).find("rb").text() + "'>Uredi</a></td><td><a href = 'deleteConf.php?deleteID=" + $(this).find("rb").text() + "'>Obriši</a></td></tr>");
		}
		else
		{
			if($(this).find("javno").text() == 1)
			{
				tablica.append("<tr><ul><li><td>" + $(this).find("rb").text() + "</td></li><td>" + $(this).find("naziv").text() + "</td><td>" + $(this).find("kupac").text() + "</td><td>" + $(this).find("automobil").text() + "</td><td>" + $(this).find("dio").text() + "</td><td>" + $(this).find("cijena").text() + "</td><td> <img src=" + $(this).find("thumb").text() + " height='40' width='40'> </td><td><a href = 'confDetails.php?id=" +$(this).find("rb").text() + "'>Detalji</a></td></tr>");
			}
		}
		});

	$('#pagingConfs').append(tablica);

	$('#pagingConfs').append("<div class='pager'><a href='#' alt='Previous' class='prevPage'> << </a><span class='currentPage'>&nbsp;</span>/<span class='totalPages'>&nbsp;</span><a href='#' alt='Next' class='nextPage'> >> </a></div>");
	$('#konfiguracije').paginateTable({ rowsPerPage: 10 });
	$('#pagingConfs').show('blind', 1000);
}

function displayMyConfXML(xml)
{	
	var tablica = $('<table id = "konfiguracije" class="popis">');
	tablica.append("<td> Oznaka </td><td> Naziv </td><td> Kupac </td><td> Automobil </td><td> Dio </td><td> Cijena </td><td> Slika </td>");
	$(xml).find("conf").each(function(){
		tablica.append("<tr><ul><li><td>" + $(this).find("rb").text() + "</td></li><td>" + $(this).find("naziv").text() + "</td><td>" + $(this).find("kupac").text() + "</td><td>" + $(this).find("automobil").text() + "</td><td>" + $(this).find("dio").text() + "</td><td>" + $(this).find("cijena").text() + "</td><td> <img src=" + $(this).find("thumb").text() + " height='40' width='40'> </td><td><a href = 'confDetails.php?id=" +$(this).find("rb").text() + "'>Detalji</a></td><td><a href = 'editMyConf.php?editID=" + $(this).find("rb").text() + "'>Uredi</a></td><td><a href = 'deleteConf.php?deleteID=" + $(this).find("rb").text() + "'>Obriši</a></td></tr>");
		});

	$('#pagingConfs').append(tablica);

	$('#pagingConfs').append("<div class='pager'><a href='#' alt='Previous' class='prevPage'> << </a><span class='currentPage'>&nbsp;</span>/<span class='totalPages'>&nbsp;</span><a href='#' alt='Next' class='nextPage'> >> </a></div>");
	$('#konfiguracije').paginateTable({ rowsPerPage: 10 });
	$('#pagingConfs').show('blind', 1000);
}

function postCarComment(event)
{
	id = event.data.param1;
	var z = $("#carCommentText").val();
	var x = "commentCarPosting.php?id="+ id;
	$.ajax({
			type: 'POST',
			url: x,
			dataType: 'text',
			data:'txt='+z,
			success: loadCarComments(id),
			error:function (xhr, ajaxOptions, thrownError){
                    alert(xhr.status);
                    alert(thrownError);
                }    
		})
}
function subCommentCar(id)
{
	$('p[name='+id +']').parent().append("<textarea id = 'subCommentTxt' rows='3' cols = '35'></textarea>"); 
	var x = $('p[name='+id +']').parent().append("<button type = 'button' id = 'subCommentBtn'>Komentiraj</button>").click({param1 : id},submitSubCommentCar); 
	var inp = $("#subCommentBtn").click({param1 : id},submitSubCommentCar); 
}
function submitSubCommentCar(event)
{	
	var url = document.location.href;
	var sUrl =  url.substring(url.lastIndexOf('=')+1);
	$(document).ready(function() {
		loadCarComments(sUrl);
	})
	if (sUrl.charAt(1) == "#")
	{
		sUrl = sUrl.slice(0,1);
	}
	else if (sUrl.charAt(2) == "#")
	{
		sUrl = sUrl.slice(0,2);
	}
	id = event.data.param1;
	alert(sUrl);
	var x = "commentsCarXML.php?id="+ id +"&car="+sUrl;
	z = $("#subCommentCarText").val();
	alert(z);
	$.ajax({
			type: 'POST',
			url: x,
			dataType: 'txt',
			data:'txt='+z,
			success: alert("a"),
			error:function (xhr, ajaxOptions, thrownError){

                }    
		})
}
function loadCarComments(id)
{
	var x = "commentsCarXML.php?id="+ id;
	$.ajax({
			type: 'GET',
			url: x,
			dataType: 'xml',
			success: showComments,
			error:function (xhr, ajaxOptions, thrownError){
                    alert(xhr.status);
                    alert(thrownError);
                }    
		})
}

function postPartComment(event)
{
	id = event.data.param1;
	var z = $("#partCommentText").val();
	var x = "commentPartPosting.php?id="+ id;
	$.ajax({
			type: 'POST',
			url: x,
			dataType: 'text',
			data:'txt='+z,
			success: loadPartComments(id),
			error:function (xhr, ajaxOptions, thrownError){
                    alert(xhr.status);
                    alert(thrownError);
                }    
		})
}
function subCommentPart(id)
{
	$('p[name='+id +']').parent().append("<textarea id = 'subCommentTxt' rows='3' cols = '35'></textarea>"); 
	var x = $('p[name='+id +']').parent().append("<button type = 'button' id = 'subCommentBtn'>Komentiraj</button>").click({param1 : id},submitSubCommentPart); 
	var inp = $("#subCommentBtn").click({param1 : id},submitSubCommentPart); 
}
function submitSubCommentPart(event)
{	
	var url = document.location.href;
	var sUrl =  url.substring(url.lastIndexOf('=')+1);
	$(document).ready(function() {
		loadPartComments(sUrl);
	})
	if (sUrl.charAt(1) == "#")
	{
		sUrl = sUrl.slice(0,1);
	}
	else if (sUrl.charAt(2) == "#")
	{
		sUrl = sUrl.slice(0,2);
	}
	id = event.data.param1;
	alert(sUrl);
	var x = "commentsPartXML.php?id="+ id +"&part="+sUrl;
	z = $("#subCommentText").val();
	$.ajax({
			type: 'POST',
			url: x,
			dataType: 'txt',
			data:'txt='+z,
			success: alert("a"),
			error:function (xhr, ajaxOptions, thrownError){
 
                }    
		})
}
function loadPartComments(id)
{
	var x = "commentsPartXML.php?id="+ id;
	$.ajax({
			type: 'GET',
			url: x,
			dataType: 'xml',
			success: showComments,
			error:function (xhr, ajaxOptions, thrownError){
                    alert(xhr.status);
                    alert(thrownError);
                }    
		})
}

function postConfComment(event)
{
	id = event.data.param1;
	var z = $("#confCommentText").val();
	var x = "commentConfPosting.php?id="+ id;
	$.ajax({
			type: 'POST',
			url: x,
			dataType: 'text',
			data:'txt='+z,
			success: loadConfComments(id),
			error:function (xhr, ajaxOptions, thrownError){
                    alert(xhr.status);
                    alert(thrownError);
                }    
		})
}
function subCommentConf(id)
{
	$('p[name='+id +']').parent().append("<textarea id = 'subCommentTxt' rows='3' cols = '35'></textarea>"); 
	var x = $('p[name='+id +']').parent().append("<button type = 'button' id = 'subCommentBtn'>Komentiraj</button>").click({param1 : id},submitSubCommentConf); 
	var inp = $("#subCommentBtn").click({param1 : id},submitSubCommentPart); 
}
function submitSubCommentConf(event)
{	
	var url = document.location.href;
	var sUrl =  url.substring(url.lastIndexOf('=')+1);
	$(document).ready(function() {
		loadConfComments(sUrl);
	})
	if (sUrl.charAt(1) == "#")
	{
		sUrl = sUrl.slice(0,1);
	}
	else if (sUrl.charAt(2) == "#")
	{
		sUrl = sUrl.slice(0,2);
	}
	id = event.data.param1;
	alert(sUrl);
	var x = "commentConfXML.php?id="+ id +"&conf="+sUrl;
	z = $("#subCommentText").val();
	alert(z);
	$.ajax({
			type: 'POST',
			url: x,
			dataType: 'txt',
			data:'txt='+z,
			success: alert("a"),
			error:function (xhr, ajaxOptions, thrownError){
 
                }    
		})
}
function loadConfComments(id)
{
	var x = "commentConfXML.php?id="+ id;
	$.ajax({
			type: 'GET',
			url: x,
			dataType: 'xml',
			success: showComments,
			error:function (xhr, ajaxOptions, thrownError){
                    alert(xhr.status);
                    alert(thrownError);
                }    
		})
}

function showComments(xml)
{
	$('#userComments').html('');
	var tablica = $('<table id = "table">');
	tablica.append("<span> Komentari </span>");
	$(xml).find("comment").each(function(){	
	tablica.append("<tr colspan = '2'><td id= 'rateUsername'><p>" + $(this).find("username").text() + "</p></td></tr><tr colspan='2'><td id='rateRate'><p>"+ $(this).find("text").text() + "<br/></p></td></tr>");
	
	tablica.append("<tr colspan = '2'><td><p id = 'subCommentParagraph'name = '"+ $(this).find("id").text() + "' onclick='subComment(" + $(this).find("id").text() + ");'>Komentiraj</p></td></tr>");
	tablica.append("<tr colspan='2'><td><hr></td></tr>");
	});
	$('#userComments').append(tablica);
	$('#userComments').append(tablica);

	$('#userComments').append("<div class='pager'><a href='#' alt='Previous' class='prevPage'>Prev</a><span class='currentPage'>&nbsp;</span> of <span class='totalPages'>&nbsp;</span><a href='#' alt='Next' class='nextPage'>Next</a></div>");
	$('#table').paginateTable({ rowsPerPage: 6});
	
	$('#userComments').show('blink', 1000);
}

function getCarVoters(event)
{
	id = event.data.param1;
	var x = "votersCarXML.php?id="+id;
	$.ajax({
			type: 'GET',
			url: x,
			dataType: 'xml',
			success: showVoters,
			error:function (xhr, ajaxOptions, thrownError){
                    alert(xhr.status);
                    alert(thrownError);
                }    
		})
}
function getPartVoters(event)
{
	id = event.data.param1;
	var x = "votersPartXML.php?id="+id;
	$.ajax({
			type: 'GET',
			url: x,
			dataType: 'xml',
			success: showVoters,
			error:function (xhr, ajaxOptions, thrownError){
                    alert(xhr.status);
                    alert(thrownError);
                }    
		})
}
function getConfVoters(event)
{
	id = event.data.param1;
	var x = "votersConfXML.php?id="+id;
	$.ajax({
			type: 'GET',
			url: x,
			dataType: 'xml',
			success: showVoters,
			error:function (xhr, ajaxOptions, thrownError){
                    alert(xhr.status);
                    alert(thrownError);
                }    
		})
}
function showVoters(xml)
{
	$('#userRate').html('');
	var tablica = $('<table id = "table" >');
	tablica.append("<td> Korisničko ime </td><td> Ocjena </td></td>");
	$(xml).find("ocjena").each(function(){	
	tablica.append("<tr><ul><li><td id= 'rateUsername'>" + $(this).find("username").text() + "</td></li><td id='rateRate'>"+ $(this).find("rate").text() + "</td></tr>");
	});
	$('#userRate').append(tablica);
	$('#userRate').append(tablica);

	$('#userRate').append("<div class='pager'><a href='#' alt='Previous' class='prevPage'>Prev</a><span class='currentPage'>&nbsp;</span> of <span class='totalPages'>&nbsp;</span><a href='#' alt='Next' class='nextPage'>Next</a></div>");
	$('#table').paginateTable({ rowsPerPage: 1 });
	
	$('#userRate').show('blind', 2000);
}

function rateCar(event)
{
	id = event.data.param1;
	var rateCar = $("#carRate").val();
	var x = 'rateCar.php?id='+ id + '&rate=' + rateCar;
	
	$.ajax({
			type: 'GET',
			url: x,
			dataType: 'xml',
			success: rate,
			error:function (xhr, ajaxOptions, thrownError){
                    
                }    
		})
}
function ratePart(event)
{
	id = event.data.param1;
	var ratePart = $("#partRate").val();
	var x = 'ratePart.php?id='+ id + '&rate=' + ratePart;
	
	$.ajax({
			type: 'GET',
			url: x,
			dataType: 'xml',
			success: rate,
			error:function (xhr, ajaxOptions, thrownError){
                    
                }    
		})
}

function rateConf(event)
{
	id = event.data.param1;
	var rateConf = $("#confRate").val();
	var x = 'rateConf.php?id='+ id + '&rate=' + rateConf;
	
	$.ajax({
			type: 'GET',
			url: x,
			dataType: 'xml',
			success: rate,
			error:function (xhr, ajaxOptions, thrownError){
                    
                }    
		})
}
function rate()
{
	//finish up
}

function lightbox(event) {
 
        //prevent default action (hyperlink)
        event.preventDefault();
 
        //Get clicked link href
        var image_href = $(this).attr("href");
 		//alert(image_href);
        /*
        If the lightbox window HTML already exists in document,
        change the img src to to match the href of whatever link was clicked
 
        If the lightbox window HTML doesn't exists, create it and insert it.
        (This will only happen the first time around)
        */
 
        if ($('#lightbox').length > 0) 
        { // #lightbox exists
 
            //place href as img src value
            $('#content').html('<img src="' + image_href + '" />');
 
            //show lightbox window - you could use .show('fast') for a transition
            $('#lightbox').show();
        }
 
        else 
        { //#lightbox does not exist - create and insert (runs 1st time only)
 
            //create HTML markup for lightbox window
            var lightbox =
            '<div id="lightbox">' +
                '<p>Click to close</p>' +
                '<div id="content">' + //insert clicked link's href into img src
                    '<img src="' + image_href +'" />' +
                '</div>' +
            '</div>';
 
            //insert lightbox HTML into page
            $('body').append(lightbox);
        }
   
} 


function over()
{
	this.setAttribute('style','background-color: #E0E0E0');
}
function out()
{
	this.setAttribute('style','background-color: ""');
}
function overRow()
{
	this.setAttribute('style','background-color: #525C65');
}
function outRow()
{
	this.setAttribute('style','background-color: ""');
}