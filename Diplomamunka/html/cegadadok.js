
	var el = document.getElementById('Mentesgomb');
	
	el.addEventListener('click', function()
	{
    document.getElementById('Mentesgomb').value = "Adatok mentése";
	
	

	});

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
		document.getElementById("uzenet").innerHTML = "Jelszavak nem egyeznek!"
	  }
	  }
  

		var idik=["fajl_valaszto_szamla", "fajl_valaszto_banki_szamlat", "fajl_valaszto_egyebb",];
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
				    <label>Mikkora vonatkozik a dokumentum:</label>
			    <br>
			    <label for="vehicle1"> A feltőltés datuma megegyezik a vonatkozási dátummal.</label>
				<input type="checkbox" id="azonosdatum" name="datum_sima" value="azonos_datum" onclick="datumcsek()">
				<br>
				<input type="date" id="datumbeallito" dateFormat: "mm/yy">
				*/
	
	/*
	
	
	  var AdoszamEllen = function(){
	  var input = document.getElementsByName("adoszam") ;
		if(input.value.length = 10){
		    document.getElementsByName("adoszam").style.background-color = "Green";
			document.getElementById("hibauzenet").style.color = "Green";
			document.getElementById("hibauzenet").innerHTML = "Jó";
		}else{
			document.getElementsByName("adoszam").style.background-color = "Red";
			document.getElementById("hibauzenet").style.color = "Red";
			document.getElementById("hibauzenet").innerHTML = "Hiányos száms sór!";
		}
  }
  
  
  

	var el = document.getElementById('Mentesgomb');
	
	el.addEventListener('click', function()
	{
    document.getElementById('Mentesgomb').value = "Adatok mentése";
	
	

	});

	const element = document.getElementsByClassName('irasoseng');
	function change(){
	console.log(element)
    for(var i in element)
		{
			element[i].disabled = false;
			
		}
	}
	
		var ids=["student", "educator", "parent", "not-school", "publisher"];
	var dropDown = document.getElementById("roleSel");

	dropDown.onchange = function(){
    for(var x = 0; x < ids.length; x++){   
        document.getElementById(ids[x]).style.display="none";
    }    
    document.getElementById(this.value).style.display = "block";
	
	*/