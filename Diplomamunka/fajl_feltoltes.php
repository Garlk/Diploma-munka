<?php
session_start();
// bevan e lépve
if (!isset($_SESSION['loggedin'])) {
    header('Location: index.php');
    exit;
}
include('php/fajl_feltoltes.ini.php') ?>
<!DOCTYPE html>
<html lang="hu" dir="ltr">
<head>
    <meta charset= "utf-8">
    <title> KM new company</title>
    <link rel="stylesheet" href="css/fajlfeltoltes.css">
    <link rel="stylesheet" href="cegadatok.js">

</head>
<body>

<div id="centercg">
    <form action="fajl_feltoltes.php" method="post" enctype="multipart/form-data">
        <label id="focimcegnev">
            Feltöltendő fájl adatai
        </label>
        <div id="tipus_valaszto">
            <div id="kilepesG">
                <input type="submit" name="kilepesG" value="Kilépés" >
            </div>

            <div id="feltolto_valaszto">
                <div class="fajl_valaszto">
                    <label>Válassza ki milyen fájlt szeretne feltölteni:</label>
                    <br>
                    <select id="fajltipus0"class="fajl_tipus" tabindex="50" name="fajltipus0" onchange="dukumentunvalaszto()">
                        <option id="1" value="1">Válassz fájl típust</option>
                        <option value="fajl_valaszto_szamla">Számla fájl</option>
                        <option value="fajl_valaszto_banki_szamlat">Bankokra vonatkozó fájl</option>
                        <option value="fajl_valaszto_egyebb">Egyéb dokumentum</option>
                    </select>
                </div>
                <!-- --------------------------------------- -->
                <div id="fajl_valaszto_szamla" style="display: none;">
                    <label>Kimenő/Bejövő számla:</label>
                    <br>
                    <select id="fajltipus1" class="fajl_tipus" tabindex="50" name="kiszvbesz">
                        <option value="Bszamla">Bejövő számla</option>
                        <option value="Kszamla">Kimenő számla</option>
                    </select>

                    <div id="szamla_kiallito" >
                        <label id="szamla_name">Számla kiállítója</label>
                        <br>
                        <label>Már felvitt számla kiállító:</label>
                        <input type="checkbox" id="azonositas" name="kiallitojelzo" value="mar_letezo_k" onclick="kialitocsek()">

                        <div id="uj_kiallitok" >
                            <input type="text" name="szamlaujkiallito" >
                            <br>
                        </div>
                        <div id="felvet_kiallitok" style="display: none;">
                            <label>Eddigi kiállítók:</label>
                            <select id="kiallitok" class="evek" tabindex="50" name="meglevo_kiallito">
                                 <?php
                                 if(isset($_SESSION['tarsasvallalkozas'])){
                                     $valalkozasneve = $_SESSION['tarsasvallalkozas'];
                                 }elseif(isset($_SESSION['egyenivallalkozas'])){
                                     $valalkozasneve = $_SESSION['egyenivallalkozas'];
                                 }elseif(isset($_SESSION['felhaszvallal'])){
                                     $valalkozasneve = $_SESSION['felhaszvallal'];
                                 }
                                $userCheck = "SELECT DISTINCT  `Fajl_kiallito_ceg` FROM `fajladatok` WHERE `Fajl_tulaj`='".$valalkozasneve."'";
                                $result = mysqli_query($db->dbConnect(), $userCheck);
                                if(mysqli_num_rows( mysqli_query( $db->dbConnect(), $userCheck ))) {
                                echo "<option value='Nincs_valasztva'>Válassz</option> ";
                                while ($row = mysqli_fetch_row($result)) {
                                echo "<option value='" . $row[0] . "'>" . $row[0] . "</option> ";
                                }
                                }else {
                                echo "<option value='Nincs_kiallito'>Új számla kiállító</option> ";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="datumvalaszto">
                        <label>Mikkora vonatkozik a dokumentum:</label>
                        <br>
                        <label>Év:</label>
                        <select class="ido_ev" class="evek" tabindex="50" name="datum_ev0">
                            <option value="2021">2021</option>
                            <option value="2022">2022</option>
                            <option value="2023">2023</option>
                        </select>
                        <label>Hónap:</label>
                        <select class="ido_ev" class="honapok" tabindex="50" name="datum_ho0">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                        </select>
                    </div>
                    <div class="filefeltoltes">
                        <label for="myfile">Válassz fájlt:</label>
                        <input type="file" name="szamlamyfile">
                    </div>
                </div>
                <!-- --------------------------------------- -->
                <div id="fajl_valaszto_banki_szamlat" style="display: none;">
                    <label>Banki számla/Számlatörténet:</label>
                    <br>
                    <select id="fajltipus1" class="fajl_tipus" tabindex="50" name="szamla_v_szamlator">
                        <option value="Bankszamla">Bankszámla</option>
                        <option value="Szamlatortenet">Számlatörténet</option>
                    </select>
                    <div class="datumvalaszto">
                        <label>Mikkora vonatkozik a dokumentum:</label>
                        <br>
                        <label>Év:</label>
                        <select class="ido_ev" class="evek" tabindex="50" name="datum_ev1">
                            <option value="21">2021</option>
                            <option value="22">2022</option>
                            <option value="23">2023</option>
                        </select>
                        <label>Hónap:</label>
                        <select class="ido_ev" class="honapok" tabindex="50" name="datum_ho1">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                        </select>
                    </div>
                    <div class="filefeltoltes">
                        <label for="myfile">Válassz fájlt:</label>
                        <input type="file" name="bankimyfile">
                    </div>
                </div>
                <!-- --------------------------------------- -->
                <div id="fajl_valaszto_egyebb" style="display: none;">
                    <label>Egyéb dokumentumok típusai:</label>
                    <br>
                    <select id="fajltipus2" class="fajl_tipus" tabindex="50" name="fajltipusegyeb">
                        <option value="Nav_ugyi">Nav-val kapcsolatos</option>
                        <option value="Munka_ugyi">Munkaügyi</option>
                        <option value="Egyeb">Hiányosság</option>
                    </select>
                    <br>

                    <div class="datumvalaszto">
                        <label>Mikkora vonatkozik a dokumentum:</label>
                        <br>
                        <label>Év:</label>
                        <select id="ido_ev" class="evek" tabindex="50" name="datum_ev2">
                            <option value="21">2021</option>
                            <option value="22">2022</option>
                            <option value="23">2023</option>
                        </select>
                        <label>Hónap:</label>
                        <select id="ido_ev" class="honapok" tabindex="50" name="datum_ho2">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                        </select>
                    </div>
                    <div class="filefeltoltes">
                        <label for="myfile">Válassz fájlt:</label>
                        <input type="file" name="egyebmyfile">
                    </div>
                </div>
                <!-- --------------------------------------- -->
            </div>

            <div id="mentesG">
                <input id="fajfeltotes"  type="submit" name="kepfeltotes" value="Fájl feltöltés" >

                <input id="visszalepes" type="submit" name="viszalepes" value="Vissza" >

            </div>
    </form>

    <script src="cegadadok.js"></script>
</div>

</body>
</html>

<!--




Számlák
mikkora vonatkotik           pipa
feltőltési idő adatbázis     pipa
Kiállító szerintfel kell veni egy kiállítót + meg kell jeleníteni utána

bankszamla
mikkora vonatkotik 			 pipa
feltőltési idő adatbázis	 pipa

egyebdok
milyen ügyi dokument		 pipa
mikkora vonatkotik 			 pipa
feltőltési idő adatbázis 	 pipa


https://stackoverflow.com/questions/18115916/how-to-display-content-depending-on-dropdown-menue-user-selection
-->