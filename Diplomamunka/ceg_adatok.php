<?php
session_start();
// bevan e lépve
if (!isset($_SESSION['loggedin'])) {
    header('Location: index.php');
    exit;
}elseif($_SESSION['Belepet']['tipus']!=1){
    header('Location: index.php?status=error&msg=Aktivitás hiánya miatt az oldal kiléptette');
}
//echo $_SESSION['Belepet']['tipus']."   ".$_SESSION['name'];

include('php/teszt.ini.php');
include('php/ceg_adatok.ini.php'); ?>
<!DOCTYPE html>
<html lang="hu" dir="ltr">
<head>
    <meta charset="utf-8">
    <title> KM company info</title>
    <link rel="stylesheet" href="css/ceg_adatok.css">
    <link rel="stylesheet" href="ceg_adatok.js">


</head>
<body>

<div id="centercg">
        <label id="focimcegnev">
            Cégadatok
        </label>
        <form name="Cegform" method="post" action="ceg_adatok.php" onsubmit="return validateForm()">
        <div id="kilepesG">
            <input type="submit" name="kilepesG" value="Kilépés">
        </div>

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
                        <input id="adoszam"  class="irasoseng" type="text" value="<?php echo $Cegadoszam;?>" oninput="formatAdoszam(this)" name="adoszam" disabled>
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
                        <input class="irasoseng" type="text" value="<?php echo $Cegtelefonszam;?>" oninput="formatTelefonosElerhetoseg(this)"  name="telefonoselerhetoseg" disabled>
                    </div>
                    <script>
                        function formatTelefonosElerhetoseg(input) {
                            var value = input.value.replace(/\D/g, "");
                            var formattedValue = value.substring(0, 2) + " " + value.substring(2, 4) + " " + value.substring(4, 7)+ " " + value.substring(7, 11);
                            input.value = formattedValue;
                        }
                    </script>

                    <div class="ceg_adatok">
                        <label>Cég email címe</label>
                        <br>
                        <input class="irasoseng" type="text" value="<?php echo $Cegemail;?>" name="emailcim" disabled>
                    </div>

                </th>
                <th>
                    <div class="ceg_adatok">
                        <label>Cég bankszámlaszáma</label>
                        <br>
                        <input class="irasoseng" type="text" value="<?php echo $Cegbankszamla;?>" name="bankszamlaszam" oninput="formatBankszamlaszam(this)" disabled>
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
                </th>
            </tr>
        </table>
            <div id="mentesG">
                <input id="Mentesgomb" onclick="change()" type="button" name="adatokmentes" value="Adatok megváltoztatása">
                <br>
                <div>
                    <input id="fajfeltotes" type="submit" name="kepfeltotes" value="Fájl feltöltés">
                </div>
                <div id="cegtorlesG">
                    <input id="cegtorles" type="submit" name="cegtorles" value="Cég törlése">
                </div>
            </div>

        <script src="cegadadok.js"></script>
        </form>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var form = document.forms["Cegform"];
            form.addEventListener("keydown", function(event) {
                if (event.key === "Enter") {
                    event.preventDefault();
                }
            });
        });
    </script>

</div>

</body>
</html>