<?php

require "DataBase.php";
$db = new DataBase();


$userCheck = "SELECT `cegadatok`.`ID`,`Ceg_cegnev`, `Ceg_tipusa`, `Ceg_cegjegyzek_szam`, `Ceg_adoszam`, `Ceg_szekhely`, `Ceg_telefonsz`, `Ceg_email`,
       `Ceg_bankszamla_szam`, `Ceg_alakulasi_ev`, `Ceg_ugyvezeto`, `Ceg_kapcsolattarto`, `Ceg_tevekenyseg`
       FROM cegadatok 
       INNER JOIN felhasznalok
		ON cegadatok.Ceg_cegnev  = felhasznalok.Felhasznalo_ceg
       WHERE felhasznalok.Felhasznalo_nev = '" . $_SESSION['name'] . "'";
$result = mysqli_query($db->dbConnect(), $userCheck);
$row = $result->fetch_array(MYSQLI_ASSOC);
$eID=$row['ID'];

$eredeticegneve = $row['Ceg_cegnev'];
$eredeticegneve_minta = $row['Ceg_cegnev'];
$Cegtipusa = $row['Ceg_tipusa'];
$Cegjegyzek = $row['Ceg_cegjegyzek_szam'];
$Cegjegyzek_minta = $row['Ceg_cegjegyzek_szam'];
$Cegadoszam = $row['Ceg_adoszam'];
$Cegadoszam_minta = $row['Ceg_adoszam'];
$Cegszekhely = $row['Ceg_szekhely'];
$Cegtelefonszam = $row['Ceg_telefonsz'];
$Cegemail = $row['Ceg_email'];
$Cegbankszamla = $row['Ceg_bankszamla_szam'];
$Cegalakulasa = $row['Ceg_alakulasi_ev'];
$Cegugyveezeto = $row['Ceg_ugyvezeto'];
$Cegkapcsolattarto = $row['Ceg_kapcsolattarto'];
$Cegtevekenysege = $row['Ceg_tevekenyseg'];

if (isset($_POST['adatokmentes'])) {

    $cegnev = $_POST['cegneve'];
    $cegjegyzekszam = $_POST['cegjegyzekszam'];/**/
    $telefonoselerhetoseg = $_POST['telefonoselerhetoseg'];/**/
    $emailcim = $_POST['emailcim']; /**/
    $adoszam = $_POST['adoszam'];/**/
    $bankszamlaszam = $_POST['bankszamlaszam'];/**/
    $tevekenyseg = $_POST['tevekenyseg'];
    $tipusmegnevezes = $_POST['Tarsas_valalk'];/* át kell alakítani választó selectre*/
    $alakulasev = $_POST['alakulasev'];
    $kapcsolattarto = $_POST['kapcsolattarto'];
    $ugyentizo = $_POST['ugyentizo'];
    $szekhely = $_POST['szekhely'];



    if (filter_var($emailcim, FILTER_VALIDATE_EMAIL)) { /*email cím validitás ellenőrzés*/
        if (12 >= strlen($cegjegyzekszam) && strlen($cegjegyzekszam) >= 10) {  /*Cégjegyzék hossz ellenőrzés 10 + kettő "-" 12*/
            if (13 >= strlen($adoszam) && 11 <= strlen($adoszam)) {  /*Adószám hossz ellenőrzés 11 + kettő "-" 13*/
                /*****************Cég név ellenőrzés*********************/
                $cegCheck = "SELECT `ID`,`Ceg_cegnev` FROM `cegadatok` WHERE `Ceg_cegnev`= '" . $_POST['cegneve'] . "' ";
                if ($eredeticegneve == $_POST['cegneve']) {
                    $cegnev = "nincs_valt";
                } elseif (empty($_POST['cegneve'])) {
                    $_SESSION['hiba'] = "A cég név üres nem lehet";

                } elseif (mysqli_num_rows(mysqli_query($db->dbConnect(), $cegCheck))) {
                    $_SESSION['hiba'] = "<span style='color:red;'>Az új cég név már szerepel az adatbázisban</span>";

                } else {
                    $cegnev = $_POST['cegneve'];
                }

                /*****************Cégjegyzék ellenőrzés *********************/
                $cegjegyzekCheck = "SELECT  `Ceg_cegjegyzek_szam` FROM `cegadatok` WHERE Ceg_cegjegyzek_szam='" . $_POST['cegjegyzekszam'] . "'";
                if ($Cegjegyzek == $_POST['cegjegyzekszam']) {
                    $cegjegyzek = "nincs_valt";
                } elseif (empty($_POST['cegneve'])) {
                    $_SESSION['hiba'] = "Cégjegyzék üres nem lehet";

                } elseif (mysqli_num_rows(mysqli_query($db->dbConnect(), $cegjegyzekCheck))) {
                    $_SESSION['hiba'] = "Foglalt cégjegyzékszám, már szerepel az adatbáziban";

                } else {
                    $cegjegyzek = $_POST['cegjegyzekszam'];
                }

                /*****************Adószám ellenörzés *********************/
                $adoszamCheck = "SELECT  `Ceg_adoszam` FROM `cegadatok` WHERE Ceg_adoszam='" . $_POST['adoszam'] . "'";
                if ($Cegadoszam == $_POST['adoszam']) {
                    $adoszam = "nincs_valt";
                } elseif (empty($_POST['cegneve'])) {
                    $_SESSION['hiba'] = "Adószám üres nem lehet";

                } elseif (mysqli_num_rows(mysqli_query($db->dbConnect(), $adoszamCheck))) {
                    $_SESSION['hiba'] = "Foglalt Adószám, már szerepel az adatbáziban";

                } else {
                    $adoszam = $_POST['adoszam'];
                }
                //$cegnev,$cegjegyzekszam,$telefonoselerhetoseg,$emailcim,$adoszam,$bankszamlaszam,$tevekenyseg,$tipusmegnevezes,$alakulasev,$kapcsolattarto,$ugyentizo,$szekhely
                if (isset($cegnev) && isset($tipusmegnevezes) && isset($cegjegyzekszam) && isset($adoszam) &&
                    isset($szekhely) && isset($telefonoselerhetoseg) && isset($emailcim) && isset($bankszamlaszam) &&
                    isset($alakulasev) && isset($ugyentizo) && isset($kapcsolattarto) && isset($tevekenyseg)) {

                    if ($db->dbConnect()) {

                        if ($db->Ceg_adatok_modosítas_egysz( $cegnev,
                            $tipusmegnevezes, $cegjegyzekszam,$adoszam,$eredeticegneve_minta,
                            $szekhely, $telefonoselerhetoseg, $emailcim,
                            $bankszamlaszam, $alakulasev, $ugyentizo,
                            $kapcsolattarto, $tevekenyseg,$eID)) {

                            $userCheck = "SELECT `cegadatok`.`ID`,`Ceg_cegnev`, `Ceg_tipusa`, `Ceg_cegjegyzek_szam`, `Ceg_adoszam`, `Ceg_szekhely`, `Ceg_telefonsz`, `Ceg_email`,
       `Ceg_bankszamla_szam`, `Ceg_alakulasi_ev`, `Ceg_ugyvezeto`, `Ceg_kapcsolattarto`, `Ceg_tevekenyseg`
       FROM cegadatok 
       INNER JOIN felhasznalok
		ON cegadatok.Ceg_cegnev  = felhasznalok.Felhasznalo_ceg
       WHERE felhasznalok.Felhasznalo_nev = '" . $_SESSION['name'] . "'";
                            $result = mysqli_query($db->dbConnect(), $userCheck);
                            $row = $result->fetch_array(MYSQLI_ASSOC);
                            $eID=$row['ID'];

                            $eredeticegneve = $row['Ceg_cegnev'];
                            $eredeticegneve_minta = $row['Ceg_cegnev'];
                            $Cegtipusa = $row['Ceg_tipusa'];
                            $Cegjegyzek = $row['Ceg_cegjegyzek_szam'];
                            $Cegjegyzek_minta = $row['Ceg_cegjegyzek_szam'];
                            $Cegadoszam = $row['Ceg_adoszam'];
                            $Cegadoszam_minta = $row['Ceg_adoszam'];
                            $Cegszekhely = $row['Ceg_szekhely'];
                            $Cegtelefonszam = $row['Ceg_telefonsz'];
                            $Cegemail = $row['Ceg_email'];
                            $Cegbankszamla = $row['Ceg_bankszamla_szam'];
                            $Cegalakulasa = $row['Ceg_alakulasi_ev'];
                            $Cegugyveezeto = $row['Ceg_ugyvezeto'];
                            $Cegkapcsolattarto = $row['Ceg_kapcsolattarto'];
                            $Cegtevekenysege = $row['Ceg_tevekenyseg'];

                            header('Location: http://localhost/diploma2/ceg_adatok.php');

                        } else $_SESSION['hiba'] = " Sikertelen modosítás";

                    } else {
                        $_SESSION['hiba'] = "Sikertelen adatbázis kapcsolodás";

                    }
                } else {
                    $_SESSION['hiba'] = "Hianyos adatok";
                }
            } else {
                $_SESSION['hiba'] = "<span style='color:red;'>Az dószám szám nem lehet több mint 13 vagy kevesebb mint 11</span>";

            }
        } else {
            $_SESSION['hiba'] = "<span style='color:red;'>A cégjegyzék szám nem lehet több mint 12 vagy kevesebb mint 10</span>";

        }
    } else {
        $_SESSION['hiba'] = "<span style='color:red;'>Nem valós emailcíme lett megadva</span>";

    }
}


if (isset($_POST['kepfeltotes'])) {
    $_SESSION['felhaszvallal'] = $eredeticegneve;

    header('Location: http://localhost/diploma2/fajl_megtekintes.php');

}

if (isset($_POST['kilepesG'])) {
    session_destroy();
    unset($_SESSION['Belepet']['tipus']);
    header('Location: http://localhost/diploma2/index.php');
}
