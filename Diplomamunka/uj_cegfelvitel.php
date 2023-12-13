<?php
session_start();
// bevan e lépve
if (!isset($_SESSION['loggedin'])) {
    header('Location: index.php');
    exit;
}
$cegneve="";
$cegjegyzekszam="";$telefonoselerhetoseg="";$emailcim="";$adoszam="";$felhasznalojelszava0="";
$bankszamlaszam="";$tevekenyseg="";$alakulasev="";$felhasznalojelszava1="";
$kapcsolattarto="";$ugyentizo="";$szekhely="";$ceg_felhanszalo="";
include('php/teszt.ini.php');
if($_SESSION['Belepet']['tipus']!=2){
    header('Location: index.php?status=error&msg=Aktivitás hiánya miatt az oldal kiléptette');
}
include('php/uj_cegfelvitel.ini.php')?>
<!DOCTYPE html>
<html lang="hu" dir="ltr">
<head>
    <meta charset= "utf-8">
    <title> KM company info</title>
    <link rel="stylesheet" href="css/ceg_adatok.css">

</head>
<body>

<div id="centercg">

        <label id="focimcegnev">
            Új cég adatai
        </label>
    <form method="post" action="uj_cegfelvitel.php">
        <div id="kilepesG">
            <input type="submit" name="kilepesG" value="Kilépés" >
        </div>
        </form>
    <form name="myForm" action="uj_cegfelvitel.php" method="post" onsubmit="return validateForm()">
        <table id="kitoltoresz">
            <tr>
                <th>
                    <div class="ceg_adatok">
                        <label>Cég neve</label>
                        <br>
                        <input id="cegneve" class="irasoseng" type="text" value="<?php echo $cegneve;?>" placeholder="Berényi .Kft" name="cegneve" >
                    </div>

                    <div class="ceg_adatok">
                        <label>Cégjegyzékszáma</label>
                        <br>
                        <input id="cegjegyzekszam" class="irasoseng" type="text" value="<?php echo $cegjegyzekszam;?>" placeholder="12-85-858585" name="cegjegyzekszam" oninput="formatCegjegyzekszam(this)">
                    </div>

                    <script>
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
                        <input  id="adoszam" class="irasoseng" type="text" value="<?php echo $adoszam;?>" placeholder="11111111-2-33" name="adoszam" oninput="formatAdoszam(this)" onkeydown="handleAdoszamKeyDown(event)">
                    </div>
                    <script>
                        function formatAdoszam(input) {
                            var value = input.value.replace(/\D/g, "");
                            if (value.length > 0) {
                                var formattedValue = value.substring(0, 8) + "-" + value.substring(8, 9) + "-" + value.substring(9, 11);
                                input.value = formattedValue;
                            } else {
                                input.value = "";
                            }

                        }
                    </script>
                    <div class="ceg_adatok">
                        <label>Cég székhelye</label>
                        <br>
                        <input id="szekhely" class="irasoseng" type="text" value="<?php echo $szekhely;?>" placeholder="Budapest" name="szekhely" >
                    </div>

                    <div class="ceg_adatok">
                        <label>Cég telefonos elérhetősége</label>
                        <br>
                        <input id="telefonoselerhetoseg" class="irasoseng" type="text" value="<?php echo $telefonoselerhetoseg;?>" placeholder="06 20 333 5555" name="telefonoselerhetoseg" oninput="formatTelefonosElerhetoseg(this)">
                    </div>

                    <script>
                        function formatTelefonosElerhetoseg(input) {
                            var value = input.value.replace(/\W/g, "");
                            if (value.length > 0) {
                                var formattedValue = value.substring(0, 2) + " " + value.substring(2, 4) + " " + value.substring(4, 7)+" " + value.substring(7,11);
                                input.value = formattedValue;
                            } else {
                                input.value = "";
                            }
                        }
                    </script>


                    <div class="ceg_adatok">
                        <label>Cég email címe</label>
                        <br>
                        <input id="emailcim" class="irasoseng" type="text" value="<?php echo $emailcim;?>" placeholder="Minta@minta.hu" name="emailcim" >
                    </div>
                    <div class="ceg_adatok">
                        <label>Cég felhasználóneve: *</label>
                        <br>
                        <input id="ceg_felhanszalo" class="irasoseng"  type="text" value="<?php echo $ceg_felhanszalo;?>" placeholder="Berényi" name="ceg_felhanszalo" >
                    </div>
                </th>
                <th>
                    <div class="ceg_adatok">
                        <label>Cég bankszámlaszáma</label>
                        <br>
                        <input  class="irasoseng" type="text" value="<?php echo $bankszamlaszam;?>" placeholder="12121212-23232323-45454545" name="bankszamlaszam" oninput="formatBankszamlaszam(this)">
                    </div>

                    <script>
                        function formatBankszamlaszam(input) {
                            var value = input.value.replace(/\D/g, "");
                            var formattedValue = value.substring(0, 8) + "-" + value.substring(8, 16) + "-" + value.substring(16, 24);
                            input.value = formattedValue;
                        }
                    </script>

                    <div class="ceg_adatok">
                        <label>Cég ügyvezetője</label>
                        <br>
                        <input id="ugyentizo" class="irasoseng" type="text" value="<?php echo $ugyentizo;?>" placeholder="Kis Illona" name="ugyentizo" >
                    </div>

                    <div class="ceg_adatok">
                        <label>Cég kapcsolattartója</label>
                        <br>
                        <input id="kapcsolattarto" class="irasoseng" type="text" value="<?php echo $kapcsolattarto;?>" placeholder="Nagy Imre" name="kapcsolattarto" >
                    </div>

                    <div class="ceg_adatok">
                        <label>Cég alkulási éve</label>
                        <br>
                        <input id="alakulasev" class="irasoseng" type="text" value="<?php echo $alakulasev;?>" placeholder="2018" name="alakulasev" >
                    </div>

                    <div class="ceg_adatok">
                        <label>Cég fő tevéknységi köre</label>
                        <br>
                        <input id="tevekenyseg" class="irasoseng" type="text" value="<?php echo $tevekenyseg;?>" placeholder="Építkezés" name="tevekenyseg" >
                    </div>


                    <div class="ceg_adatok">
                        <label>Cég típusa/megnevezése</label>
                        <br>
                        <select id="valalkozas" name="Tarsas_valalkkk"  >
                            <option value="">Válasz</option>
                            <option value="egyeni_val">Egyéni Vállalkozó</option>
                            <option value="tarsas_valBt">Betéti társaság</option>
                            <option value="tarsas_valKft">Korlátolt felelősségű társaság</option>
                        </select>
                    </div>

                    <div class="ceg_adatok">
                        <label>Felhasználó jelszava: *</label>
                        <br>
                        <input id="felhasznalojelszava0" class="irasoseng" name="felhasznalojelszava0" value="<?php echo $felhasznalojelszava0;?>" type="password" placeholder="Kfrlt643KT" >
                    </div>
                    <div class="ceg_adatok">
                        <label>Felhasználó jelszava újra: *</label>
                        <br>
                        <input id="felhasznalojelszava1" class="irasoseng" name="felhasznalojelszava1" value="<?php echo $felhasznalojelszava1;?>" type="password" placeholder="Kfrlt643KT" >
                    </div>
                </th>
            </tr>

        </table>
        <?php echo $error; ?>
            <div id="mentesG">
                <input id="Mentesgomb" type="submit" name="adatokmentes" value="Adatok mentése">
            </div>
            <div id="viszalepesG">
                <input id="visszalepes" type="submit" name="viszalepes" value="Vissza" >
            </div>
        </div>

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
    </script>




</body>
</html>