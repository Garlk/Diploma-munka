<?php
session_start();
// bevan e lépve
if (!isset($_SESSION['loggedin'])) {
    header('Location: index.php');
    exit;
}
if($_SESSION['Belepet']['tipus']!=2){
    header('Location: index.php?status=error&msg=Aktivitás hiánya miatt az oldal kiléptette');
}

unset($_SESSION['hiba'],$_SESSION['ceg_neve']);
include('php/teszt.ini.php');

include('php/valasztott_ceg_adatok.ini.php') ?>
<!DOCTYPE html>
<html lang="hu" dir="ltr">
<head>
<meta charset= "utf-8"> 
<title> KM company info</title>
<link rel="stylesheet" href="css/ceg_adatok.css">
<link rel="stylesheet" href="ceg_adatok.js">
</head>
<body>

<div id="centercg">
	<form action="valasztott_ceg_adatok.php" method="post">
		<label id="focimcegnev">
            <?php
            if(isset($_SESSION['hiba'])){
                ?>
                <div  id="alert" role="alert">
                    <strong style='color':red;>Hiba:<?php echo $_SESSION['hiba'];?> </strong>
                </div>
                <?php
                unset($_SESSION['hiba']);
            }else{

                echo $eredeticegneve." cégadatok";
            }
            ?>

		</label>

		<div id="kilepesG">
			<input type="submit" name="kilepesG" value="Kilépés" >
		</div>
        </form>
        <form name="myForm" method="post" action="valasztott_ceg_adatok.php" onsubmit="return validateForm()" >
		<table id="kitoltoresz">
		<tr>
		<th>
			<div class="ceg_adatok">
				<label>Cég neve</label>
				<br>
				<input class="irasoseng" type="text" value="<?php echo $eredeticegneve;?>" name="cegneve" disabled>
			</div>

			<div class="ceg_adatok">
				<label>Cégjegyzékszám</label>
				<br>
				<input id="cegjegyzek" class="irasoseng" type="text" value="<?php echo $Cegjegyzek;?>" name="cegjegyzekszam" oninput="formatCegjegyzekszam(this)" disabled>
			</div>
            <script>
                window.addEventListener('DOMContentLoaded', function() {
                    formatCegjegyzekszam(document.querySelector('input[name="cegjegyzekszam"]'));
                });

                function formatCegjegyzekszam(input) {
                    var value = input.value.replace(/\W/g, "");
                    if (value.length > 0) {
                        var formattedValue = value.substring(0, 2) + "-" + value.substring(2, 4) + "-" + value.substring(4, 10);
                        input.value = formattedValue;
                    } else {
                        input.value = "";
                    }
                }
            </script>

			<div class="ceg_adatok">
				<label>Cég adószáma</label>
				<br>
				<input id="adoszam"  class="irasoseng" type="text" value="<?php echo $Cegadoszam;?>" name="adoszam" placeholder="11111111-2-33"  oninput="formatAdoszam(this)" onkeydown="handleAdoszamKeyDown(event)" disabled>
			</div>
            <script>
                window.addEventListener('DOMContentLoaded', function() {
                    formatAdoszam(document.querySelector('input[name="adoszam"]'));
                });

                function formatAdoszam(input) {
                    var value = input.value.replace(/\D/g, "");
                    if (value.length > 0) {
                        var formattedValue = value.substring(0, 8) + "-" + value.substring(8, 9) + "-" + value.substring(9, 11);
                        input.value = formattedValue;
                    } else {
                        input.value = "";
                    }
                    function handleAdoszamKeyDown(event) {
                        if (event.key === "Backspace" || event.key === "Delete") {
                            event.preventDefault();
                            var input = event.target;
                            var caretPosition = input.selectionStart;
                            var value = input.value.replace(/\D/g, "");
                            var newValue = value.substring(0, caretPosition) + value.substring(caretPosition + 1);
                            var formattedValue = newValue.substring(0, 8) + "-" + newValue.substring(8, 9) + "-" + newValue.substring(9, 11);
                            input.value = formattedValue;
                            input.setSelectionRange(caretPosition - 1, caretPosition - 1);
                        }
                    }
                }
            </script>
			<div class="ceg_adatok">
				<label>Cég székhelye</label>
				<br>
				<input class="irasoseng" type="text" value="<?php echo $Cegszekhely;?>" name="szekhely" disabled>
			</div>

			<div class="ceg_adatok">
				<label>Cég telefonos elérhetősége </label>
				<br>
				<input class="irasoseng" type="text" value="<?php echo $Cegtelefonszam;?>" name="telefonoselerhetoseg" oninput="formatTelefonosElerhetoseg(this)"  disabled>
			</div>
            <script>
                window.addEventListener('DOMContentLoaded', function() {
                    formatTelefonosElerhetoseg(document.querySelector('input[name="telefonoselerhetoseg"]'));
                });

                function formatTelefonosElerhetoseg(input) {
                    var value = input.value.replace(/\D/g, "");
                    var formattedValue = value.replace(/(\d{2})(\d{2})(\d{3})(\d{4})/, "$1 $2 $3 $4");
                    input.value = formattedValue.substring(0, 11);
                }
            </script>

			<div class="ceg_adatok">
				<label>Cég email címe</label>
				<br>
				<input class="irasoseng" type="text" value="<?php echo $Cegemail;?>" name="emailcim" disabled>
			</div>
			<div class="ceg_adatok">
				<label>Cég felhasználó neve: *</label>
				<br>
				<input class="valtozatlan" name="Felhasznalonev" type="text" value="<?php echo $Cegfelhasznalonev;?>" name="Felhasznalonev" disabled>
			</div>
            <div class="ceg_adatok">
                <label><?php echo $_SESSION['Hiba']?></label>
            </div>
		</th>
		<th>
			<div class="ceg_adatok">
				<label>Cég bankszámlaszáma</label>
				<br>
				<input class="irasoseng" type="text" value="<?php echo $Cegbankszamla;?>" name="bankszamlaszam" oninput="formatBankszamlaszam(this)" disabled>
			</div>
            <script>
                window.addEventListener('DOMContentLoaded', function() {
                    formatBankszamlaszam(document.querySelector('input[name="bankszamlaszam"]'));
                });
                function formatBankszamlaszam(input) {
                    var value = input.value.replace(/\D/g, "");
                    var formattedValue = value.substring(0, 8) + "-" + value.substring(8, 16) + "-" + value.substring(16, 24);
                    input.value = formattedValue;
                }
            </script>

			<div class="ceg_adatok">
				<label>Cég ügyvezetője</label>
				<br>
				<input class="irasoseng" type="text" value="<?php echo $Cegugyveezeto;?>" name="ugyentizo" disabled>
			</div>

			<div class="ceg_adatok">
				<label>Cég kapcsolattartója</label>
				<br>
				<input class="irasoseng" type="text" value="<?php echo $Cegkapcsolattarto;?>" name="kapcsolattarto" disabled>
			</div>

			<div class="ceg_adatok">
				<label>Cég alkulási éve</label>
				<br>
				<input class="irasoseng" type="text" value="<?php echo $Cegalakulasa;?>" name="alakulasev" disabled>
			</div>

			<div class="ceg_adatok">
				<label>Cég fő tevékenységi köre</label>
				<br>
				<input class="irasoseng" type="text" value="<?php echo $Cegtevekenysege;?>" name="tevekenyseg" disabled>
			</div>

			<div class="ceg_adatok">
				<label>Cég típusa/megnevezése</label>
				<br>
                <select name="Tarsas_valalk" id="valalkozas" >
                    <?php
                    if ($Cegtipusa == "tarsas_valKft") {
                        echo "<option value='" . $Cegtipusa . "'>Korlátolt felelősségű társaság</option>";
                    } elseif ($Cegtipusa == "tarsas_valBt") {
                        echo "<option value='" . $Cegtipusa . "'>Betéti társaság</option>";
                    } elseif ($Cegtipusa == "egyeni_val") {
                        echo "<option value='" . $Cegtipusa . "'>Egyéni Vállalkozó</option>";
                    }
                    if ($Cegtipusa!="egyeni_val"){
                        echo"<option value='egyeni_val'>Egyéni Vállalkozó</option>";
                    }if($Cegtipusa!="tarsas_valBt"){
                        echo"<option value='tarsas_valBt'>Betéti társaság</option>";
                    }if ($Cegtipusa!="tarsas_valKft"){
                        echo"<option value='tarsas_valKft'>Korlátolt felelősségű társaság</option>";
                    }
                    ?>
                </select>
            </div>
			<div class="ceg_adatok">
				<label>Felhasználó jelszava: *</label>
				<br>
				<input class="irasoseng" name="felhasznalojelszava0" type="password" placeholder="új jeleszó megadása"  disabled>
			</div>
			<div class="ceg_adatok">
				<label>Felhasználó jelszava újra: *</label>
				<br>
				<input class="irasoseng" name="felhasznalojelszava1" type="password" placeholder="új jelszó megadása" disabled>
			</div>
		</th>
		</tr>
		</table>

		<div id="mentesG">
			<input id="Mentesgomb" onclick="change()" type="button" name="adatokmentes" value="Adatok megváltoztatása" >
			<br>
			<input id="fajfeltotes" type="submit" name="kepfeltotes" value="Feltöltött fájlok" >

            <div id="cegtorlesG">
                 <input id="cegtorles" type="submit" onclick="openPopup(event)" name="cegtorles" value="Cég törlése" >
            </div>

            <div id="viszalepesG">
                <input id="visszalepes" type="submit" name="viszalepes" value="Vissza" >
            </div>
		</div>
     	</form>
    <div id="popup" class="popup">
        <form id="popupform" method="post" action="valasztott_ceg_adatok.php">
            <span onclick="closePopup(event)" class="close-button">&times;</span>
            <p>ellenőrző kód: <span id="randomNumber"></span></p>
            <input type="number" id="userInput">
            <input type="hidden" name="cegtorles">
            <button id="elleng" onclick="checkNumber(event)" name="ellenorzoTG" value="1">Ellenőrzés</button>
            <p id="result"></p>
        </form>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var form = document.forms["myForm"];
            form.addEventListener("keydown", function(event) {
                if (event.key === "Enter") {
                    event.preventDefault();
                }
            });
        });

    function validateForm() {
        var cegneve = document.getElementById('cegneve').value;
        var cegjegyzekszam = document.getElementById('cegjegyzekszam').value;
        var adoszam = document.getElementById('adoszam').value;
        var szekhely = document.getElementById('szekhely').value;
        var telefonoselerhetoseg = document.getElementById('telefonoselerhetoseg').value;
        var emailcim = document.getElementById('emailcim').value;
        var bankszamlaszam = document.getElementById('bankszamlaszam').value;
        var ugyentizo = document.getElementById('ugyentizo').value;
        var kapcsolattarto = document.getElementById('kapcsolattarto').value;
        var alakulasev = document.getElementById('alakulasev').value;
        var tevekenyseg = document.getElementById('tevekenyseg').value;
        var tarsas_valalk = document.getElementById('valalkozas').value;

        if (
            cegneve === "" || cegjegyzekszam === "" || adoszam === "" ||
            szekhely === "" || telefonoselerhetoseg === "" || emailcim === "" ||
            bankszamlaszam === "" || ugyentizo === "" || kapcsolattarto === "" ||
            alakulasev === "" || tevekenyseg === "" || tarsas_valalk === "" ) {
            alert("Minden mező kitöltése kötelező!");
            return false; // Megakadályozza a form elküldését
        }
    }

        document.addEventListener("keydown", function(event) {
            if (event.key === "Enter") {

                event.preventDefault();
            }
        });

        var popup = document.getElementById('popup');

        function openPopup(event) {
            event.preventDefault();

            var randomNumber = Math.floor(Math.random() * 10000000) + 1;
            document.getElementById('randomNumber').innerText = randomNumber;
            document.getElementById('userInput').value = '';
            document.getElementById('result').innerText = '';
            popup.style.display = 'block';
        }

        function closePopup(event) {
            event.preventDefault();
            popup.style.display = 'none';
        }

        function checkNumber(event) {
            event.preventDefault();

            var randomNumber = document.getElementById('randomNumber').innerText;
            var userInput = document.getElementById('userInput').value;

            var VegEredmeny = '';

            // Ellenőrizze, hogy a felhasználó által megadott érték helyes-e
            if (userInput === randomNumber) {
                document.getElementById('result').innerText = 'Modosítás végre halytásra kerül';
                VegEredmeny = 'Modosítás végre2342342 halytásra kerül';
                document.getElementById("popupform").submit();
                console.log(document.getElementById("popupform"))
            } else {
                document.getElementById('result').innerText = 'Helytelen válasz!';
                VegEredmeny= 'Helytelen válasz!';
                var newRandomNumber = Math.floor(Math.random() * 10000000) + 1;
                document.getElementById('randomNumber').innerText = newRandomNumber;

                // Törölje az előző felhasználói inputot
                document.getElementById('userInput').value = '';

                // Késleltetve törölje az eredményt
                setTimeout(function() {
                    document.getElementById('result').innerText = '';
                }, 2000);

                // Ne zárja be azonnal a popup ablakot, várjon rövid ideig
                setTimeout(closePopup, 2000);
            }
            document.getElementById('eredmeny').value = resultMessage;
        }

    </script>
    <script src="cegadadok.js"></script>
</div>

</body>
</html>