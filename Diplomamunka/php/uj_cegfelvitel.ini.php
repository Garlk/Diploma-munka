<?php

require "DataBase.php";
$db = new DataBase();

$error="";
$cegneve="";
$cegjegyzekszam = "";
$telefonoselerhetoseg = "";
$emailcim = "";
$adoszam = "";
$bankszamlaszam = "";
$tevekenyseg = "";
$tipusmegnevezes = "";
$alakulasev = "";
$kapcsolattarto = "";
$ugyentizo = "";
$szekhely = "";

if (isset($_POST['adatokmentes'])) {
    $cegneve = $_POST['cegneve'];/**/
    $cegjegyzekszam = $_POST['cegjegyzekszam'];/**/
    $telefonoselerhetoseg = $_POST['telefonoselerhetoseg'];/**/
    $emailcim = $_POST['emailcim']; /**/
    $adoszam = $_POST['adoszam'];/**/
    $bankszamlaszam = $_POST['bankszamlaszam'];/**/
    $tevekenyseg = $_POST['tevekenyseg'];
    $tipusmegnevezes = $_POST['Tarsas_valalkkk'];/* át kell alakítani választó selectre*/
    $alakulasev = $_POST['alakulasev'];
    $kapcsolattarto = $_POST['kapcsolattarto'];
    $ugyentizo = $_POST['ugyentizo'];
    $szekhely = $_POST['szekhely'];

    $felhasznalojelszava0 = $_POST['felhasznalojelszava0'];/**/
    $felhasznalojelszava1 = $_POST['felhasznalojelszava1'];/**/
    $ceg_felhanszalo = $_POST['ceg_felhanszalo'];

    if($cegneve !== "" && $cegjegyzekszam !== "" && $telefonoselerhetoseg !== "" &&
        $emailcim !== "" && $adoszam !== "" && $bankszamlaszam !== "" &&
        $tevekenyseg !== "" && $tipusmegnevezes !== "" && $alakulasev !== "" &&
        $kapcsolattarto !== "" && $ugyentizo !== "" && $szekhely !== "" &&
        $ceg_felhanszalo !== "" )
        {
            $error = "<span style='color:red;'>Minden mezőt ki kell tőlteni</span>";
        }

     if (mb_strlen($felhasznalojelszava1) < 8) {
            $error = "<span style='color:red;'>HIBA: A jelszó legalább 8 karakter kell legyen  </span>";
        } else {
            if ($felhasznalojelszava1 != $felhasznalojelszava0) {
                $error = "<span style='color:red;'>HIBA: A két jelszónak egyeznie kell  </span> ";
            } else {
                if (!preg_match("/^(?=.*[!@'#$|;,%^&*-]).{8,}$/", $ceg_felhanszalo)) { /*felhasználónév hossz ellenőrzés*/
                    if(filter_var($emailcim, FILTER_VALIDATE_EMAIL)) { /*email cím validitás ellenőrzés*/
                        $cegjegyzekszamTeszt = preg_replace("/-/", "", $cegjegyzekszam);
                        if(preg_match("/^\d{10}$/", $cegjegyzekszamTeszt)) {  /*Cégjegyzék hossz ellenőrzés*/
                            $adoszamteszt = preg_replace("/-/", "", $adoszam);
                            if(preg_match("/^\d{11}$/", $adoszamteszt)) {  /*Adószám hossz ellenőrzés*/
                                if(!empty($_POST['Tarsas_valalkkk'])) {
                                    //$selected = $_POST['Tarsas_valalkkk'];

                                $userCheck = "SELECT 1 FROM cegadatok  WHERE Ceg_cegnev  = '" . $cegneve . "'";
                                if (mysqli_num_rows(mysqli_query($db->dbConnect(), $userCheck))) {  /* felhasználó adatbázis ellenőrzés */
                                    $error = "<span style='color:red;'>A cég név már szerepel a rendszerben </span>";

                                } else {
                                    $userCheck = "SELECT 1 FROM cegadatok  WHERE Ceg_cegjegyzek_szam  = '" . $cegjegyzekszam . "' ";
                                    if (mysqli_num_rows(mysqli_query($db->dbConnect(), $userCheck))) {
                                        $error = "<span style='color:red;'> Cég jegyzekszám szerepel az adatbázisban</span>";

                                    } else {
                                        $userCheck = "SELECT 1 FROM cegadatok  WHERE  Ceg_adoszam  = '" . $adoszam . "' ";
                                        if (mysqli_num_rows(mysqli_query($db->dbConnect(), $userCheck))) {
                                            $error = "<span style='color:red;'>Adoszám már szerepel az adatbázisban </span>";

                                        } else {
                                            if (isset($_POST['cegneve']) && isset($_POST['cegjegyzekszam']) && isset($_POST['szekhely']) && isset($_POST['telefonoselerhetoseg']) &&
                                                isset($_POST['adoszam']) && isset($_POST['bankszamlaszam']) && isset($_POST['ugyentizo']) && isset($_POST['kapcsolattarto']) && isset($_POST['alakulasev']) &&
                                                isset($_POST['tevekenyseg']) && isset($_POST['Tarsas_valalkkk']) && isset($_POST['emailcim']) && isset($_SESSION['name']) &&
                                                isset($_POST['ceg_felhanszalo']) && isset($_POST['felhasznalojelszava1'])) {
                                                if ($db->dbConnect()) {
                                                    
                                                    if ($db->RegisztracioAdmin("cegadatok", $cegneve, $cegjegyzekszam, $szekhely, $telefonoselerhetoseg,
                                                                              $adoszam, $bankszamlaszam, $ugyentizo, $kapcsolattarto, $alakulasev,
                                                                              $tevekenyseg, $tipusmegnevezes, $emailcim, $_SESSION['name'], $ceg_felhanszalo,
                                                                              $felhasznalojelszava1)) {
                                                        $error = "<span style='color:red;'>Sikeres regisztráció vissza íránytunk a cég választó oldalra</span>";
                                                       header("refresh: 3; url = ceg_valaszto.php");

                                                    } else $error = "<span style='color:red;'> Sikertelen regisztracio</span>";
                                               } else $error = "<span style='color:red;'> Sikertelen adatbázis kapcsolodás</span>";
                                            } else $error = "<span style='color:red;'>Minden mező kitőltése kötelező</span>";

                                        }
                                    }
                                }
                            } else {
                                $error = "<span style='color:red;'>Válasz Vállalkozási tipust.</span>";
                            }
                            }else{
                                $error = "<span style='color:red;'>Hibásan lett megadva az adószám szám</span>";
                            }
                        }else{
                            $error = "<span style='color:red;'>Hibásan lett megadva az cégjegyzék szám</span>";
                        }
                    }else {
                        $error = "<span style='color:red;'>Nem valós emailcíme lett megadva</span>";
                    }
                }else{
                    $error = "<span style='color:red;'>A felhasználónév tiltott karaktert tartalmaz</span>";
                }
            }
        }
}
if(isset($_POST['kilepesG'])) {
    session_destroy();
// Redirect to the login page:
    header('Location: index.php');
}
if(isset($_POST['viszalepes'])) {
    header('Location: ceg_valaszto.php');
}
?>