<?php
session_start();
// bevan e lépve

if (!isset($_SESSION['loggedin'])) {
    header('Location: index.php');
    exit;
}elseif($_SESSION['Belepet']['tipus']!=3){
    header('Location: index.php?status=error&msg=Aktivitás hiánya miatt az oldal kiléptette');
}

include('php/teszt.ini.php');

include('php/admin_regisztracio.ini.php');
?>
<!DOCTYPE html>
<html lang="hu" dir="ltr">
<head>
    <meta charset= "utf-8">
    <title> KM new company</title>
    <link rel="stylesheet" href="css/regiszt.css">
    <link rel="stylesheet" href="ceg_adatok.js">

</head>
<body>

<div id="centercg">

    <label id="focimcegnev">
        Admin regisztráció
    </label>


    <div id="popup" class="popup">
        <form  method="post" action="admin_regisztracios.php">
            <span onclick="closePopup(event)" class="close-button">&times;</span>
            <p>ellenőrző kód: <span id="randomNumber"></span></p>
            <input type="number" id="userInput">
            <button onclick="checkNumber(event)" name="ellenorzoTG">Ellenőrzés</button>
            <p id="result"></p>
        </form>
    </div>
    <form method="post" action="admin_regisztracios.php">
        <div id="kilepesG">
            <input type="submit" name="kilepesG" value="Kilépés" >
        </div>
    </form>
    <form id="kitoltoresz" onsubmit="return ellenorizJelszo();" method="post" action="admin_regisztracios.php">

        <input type="hidden" id="eredmeny" name="result" value="">
        <div id="ujfelhasznalo">
            <table>
                <tr class="rendeloiadatok">
                    <td class="rendelolabel">	<label >Felhasználó név: </label></td>
                    <td class="irasoseng">	<input  type="text" placeholder="AkftEnVagyok" name="felhasznalonev" ></td>
                </tr>
                <tr class="rendeloiadatok">
                    <td class="rendelolabel"> <label class="rendelolabel">Email cim: </label></td>
                    <td class="irasoseng"> <input class="irasoseng" type="text" placeholder="Berenyi@kft.hu" name="emailcim" ></td>
                </tr>
                <tr class="rendeloiadatok">
                    <td class="rendelolabel">  <label class="rendelolabel">Cég neve: </label></td>
                    <td class="irasoseng"> <input class="irasoseng" type="text" placeholder="Berényi Kft" name="rendelocegneve" ></td>
                </tr>
                <tr class="rendeloiadatok">
                    <td class="rendelolabel">  <label class="rendelolabel">Jelszava 1: </label></td>
                    <td class="irasoseng"> <input class="irasoseng" type="password" placeholder="Berény/i891" name="jelszava1" ></td>
                </tr>
                <tr class="rendeloiadatok">
                    <td class="rendelolabel">  <label class="rendelolabel">Jelszava 2: </label></td>
                    <td class="irasoseng">  <input class="irasoseng" type="password" placeholder="Berény/i891" name="jelszava2" ></td>
                </tr>
                <tr class="rendeloiadatok">
                    <?php echo $error; ?>
                    <td> <input id="regisztGomb" type="submit" name="regisztG" value="Regisztráció" ></td>
                </tr>
            </table>
        </div>
    </form>
    <script>
        function ellenorizJelszo() {
            var jelszo1 = document.querySelector('input[name="jelszava1"]').value;
            var jelszo2 = document.querySelector('input[name="jelszava2"]').value;
            var hibaUzenet = '';
            // Ellenőrizzük a jelszó hosszát
            if (jelszo1.length < 10) {
                hibaUzenet += 'A jelszónak legalább 10 karakter hosszúnak kell lennie.\n';
            }
            // Ellenőrizzük, hogy tartalmaz-e legalább egy kisbetűt
            if (!/[a-z]/.test(jelszo1)) {
                hibaUzenet += 'A jelszónak tartalmaznia kell legalább egy kisbetűt.\n';
            }
            // Ellenőrizzük, hogy tartalmaz-e legalább egy nagybetűt
            if (!/[A-Z]/.test(jelszo1)) {
                hibaUzenet += 'A jelszónak tartalmaznia kell legalább egy nagybetűt.\n';
            }
            // Ellenőrizzük, hogy a két jelszó megegyezik-e
            if (jelszo1 !== jelszo2) {
                hibaUzenet += 'A két jelszó nem egyezik meg.\n';
            }
            // Ha van hiba, megjelenítjük a hibaüzenetet

            if (!/[!@#$%^&*()_+\-=[\]{};':"\\|,.<>/?]/.test(jelszo1)) {
                hibaUzenet += 'A jelszónak tartalmaznia kell legalább egy speciális karaktert.\n';
            }
            if (hibaUzenet !== '') {
                alert(hibaUzenet);
                return false; // Megakadályozzuk az űrlap beküldését
            }

            return true; // Engedélyezzük az űrlap beküldését
        }
    </script>

    <!--   /****** Form 2 *******/  -->
    <form id="kitoltoresz1" method="post" action="admin_regisztracios.php">
        <div id="lista">
            <table>
                <tr id="listCim">
                    <!-- <td>ID</td> -->
                    <td>Cég neve:</td>
                    <td>Felhasznaló név</td>
                    <td colspan="3">Új jelszó</td>
                </tr>

                <?php
                $userCheck = "SELECT `ID`,`Felhasznalo_ceg`,`Felhasznalo_nev` FROM `felhasznalok` WHERE `Felhasznalo_letrehozo`='" . $_SESSION['name'] . "' ";
                $result = mysqli_query($db->dbConnect(), $userCheck);
                if (mysqli_num_rows(mysqli_query($db->dbConnect(), $userCheck))) {
                    while ($row = mysqli_fetch_row($result)) {
                        echo "
                    <tr class='Elemek'>
                        <!--<td></td> -->
                        <td>" . $row[1] . "</td>
                        <td>" . $row[2] . "</td>
                        <td><input type='password' placeholder='Új jelszó' name='ujjelszo" . $row[0] . "' ></td>
                        <td><input type='submit' value='Új jelszó beállitása' name='uj_jelszoG" . $row[0] . "'></td>
                        <td><input type='submit' value='Törlés' onclick='openPopup(event,'.$row[0].');' name='torlesadminG" . $row[0] . "'></td>
                    </tr>";

                        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                            // Ellenőrizd, hogy van-e eredmény a POST adatokban
                            if (isset($_POST['eredmeny'])) {
                                $eredmeny = $_POST['eredmeny'];

                                // Ellenőrizd, hogy a szám megadása sikeres volt
                                if ($eredmeny === 'Modosítás végre halytásra kerül') {
                                    echo "Siker";
                                }
                            }
                        }

                        if (isset($_POST['uj_jelszoG' . $row[0]])) {
                            if (isset($_POST['ujjelszo' . $row[0]], $row[2])) {
                                $Ujjelszohash = password_hash($_POST['ujjelszo' . $row[0]], PASSWORD_DEFAULT);
                                if ($db->dbConnect()) {
                                    $adminjelszo = $db->AdminJelszoModositas("falhasznalok", $row[0], $Ujjelszohash, $row[2]);
                                    /* tábla          ID            ujjelszo        felhasznalonev */
                                    if ($adminjelszo) {
                                        echo $adminjelszo;
                                        //header('Location: http://localhost/diploma2/admin_regisztraciosz.php');
                                    } else {
                                        echo "<script>alert('Hiba történt adat modosításkór')</script>";
                                        //echo $row[0]." ~ ". $_POST['ujjelszo'.$row[0]]." ~ ". $row[2] ." ~ "."sor elem" ."<br>";
                                    }
                                } else {
                                    echo "<script>alert('Adatbázis hiba')</script>";
                                }
                            } else {
                                $_SESSION['Hiba'] = "Üres az új jelszó mezők valamelyike";
                                echo "<script>alert('Üres az új jelszó mezők valamelyike')</script>";
                            }
                        }

                        if (isset($_POST['torlesadminG' . $row[0]])) {
                            if (isset($_POST['ujjelszo' . $row[0]], $row[2])) {
                                // Cég státuszának átállítása inaktívra
                            } else {
                                echo "<script>alert('Üres az új jelszó mező')</script>";
                            }
                        }
                    }
                } else {
                    echo "
                <tr class='Elemek'>
                    <td>Berényi Kft</td>
                    <td>AkftEnVagyok</td>
                    <td><input type='password' placeholder='Új jelszó' name='ujjelszo' ></td>
                    <td><input type='submit' value='Új jelszó beállitása' name='minta1'></td>
                    <td><input type='submit' value='Törlés' name='minta' ></td>
                </tr>";
                }
                ?>
            </table>
        </div>
    </form>
    <!-- ----------------- -->
</div>
<script>
    document.querySelectorAll('input[name^="uj_jelszoG"]').forEach(function(button) {
        button.addEventListener('click', function(event) {
            var index = this.name.match(/\d+/)[0];
            var jelszoInput = document.querySelector('input[name="ujjelszo' + index + '"]');
            var jelszo = jelszoInput.value;

            if (jelszo === '') {
                event.preventDefault();
                alert('Az új jelszó mező nem lehet üres.');
            }
        });
    });

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
            VegEredmeny = 'Modosítás végre halytásra kerül';
            document.getElementById('eredmeny').value = VegEredmeny;
            setTimeout(closePopup, 2000);
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
</body>
</html>