
	if (document.getElementById('Mentesgomb') !== null){
		var el = document.getElementById('Mentesgomb');
		el.addEventListener('click', function teszt(eve)
		{
		document.getElementById('Mentesgomb').value = "Adatok mentése";

		el.setAttribute("name","adatokmentes");
			el.type="submit";
			eve.stopPropagation();
			eve.preventDefault();
			el.removeEventListener("click",teszt )
		});

	}
	const element = document.getElementsByClassName('irasoseng');

	function change(){
	console.log(element)
    for(var i in element)
		{
			element[i].disabled = false;
		}
	}
	
	
	function kialitocsek() {
	  var checkBox = document.getElementById("azonositas");
	  var nemujkiallito = document.getElementById("felvet_kiallitok");
	  var ujkiallito = document.getElementById("uj_kiallitok");
	  if (checkBox.checked == true){
		nemujkiallito.style.display = "block";
		ujkiallito.style.display = "none";
	  } else {
		 nemujkiallito.style.display="none";
		 ujkiallito.style.display = "block";
	  }
	}
	
	
	var JelszoEllen = function() {
	  if (document.getElementById("felhaszjesz0").value == document.getElementById("felhaszjesz1").value)
	  {	  
		document.getElementById("uzenet").style.color = "Green";
		document.getElementById("uzenet").innerHTML = "Jelszavak egyezik"
	  }
	  else
	  {
		document.getElementById("uzenet").style.color = "Red";
		document.getElementById("uzenet").innerHTML = "Jelszavak nem egyeznek!";
	  }
	  }


		var idik=["fajl_valaszto_szamla", "fajl_valaszto_banki_szamlat", "fajl_valaszto_egyebb"];
		var selectva = document.getElementById("fajltipus0");

		selectva.dukumentunvalaszto = function(){
			if(selectva!= "1"){
			for(var x = 0; x < idik.length; x++){   
			document.getElementById(idik[x]).style.display="none";
			}    
			document.getElementById(this.value).style.display = "block";
		}else
			{
			
			}
		}


/*
		var fnf = document.getElementById("cegjegyzek");
		fnf.addEventListener('keyup', function(evt){
			var n = parseInt(this.value.replace(/\D/-,''),10)
			fnf.value = n.toLocaleString();
		}, false);
*/