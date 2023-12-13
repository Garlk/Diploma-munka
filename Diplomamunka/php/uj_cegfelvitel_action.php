<?php
require "DataBase.php";
$db = new DataBase();

$error="";
if (isset($_POST['regisztG'])) {
    $cegneve= $_POST['cegneve'];/**/
    $cegjegyzekszam = $_POST['cegjegyzekszam'];/**/
    $szekhely =  $_POST['szekhely'];/**/
    $telefonoselerhetoseg =  $_POST['telefonoselerhetoseg'];/**/
    $emailcim =  $_POST['emailcim']; /**/
    $adoszam =  $_POST['adoszam'];/**/
    $bankszamlaszam =  $_POST['bankszamlaszam'];/**/
    $ugyentizo =  $_POST['ugyentizo'];/**/
    $kapcsolattarto =  $_POST['kapcsolattarto'];/**/
    $alakulasev =  $_POST['alakulasev'];
    $tevekenyseg =  $_POST['tevekenyseg'];/**/
    $tipusmegnevezes =  $_POST['tipusmegnevezes'];/**/
    $felhasznalojelszava1 =  $_POST['felhasznalojelszava1'];/**/
    $felhasznalojelszava1 =  $_POST['felhasznalojelszava1'];/**/

    $felhasznalonev =  $_SESSION['$felhasznalonev'];

    if( mb_strlen($felhasznalojelszava1) < 6 ){
        $error= "HIBA: A jelszó legalább 6 karakter kell legyen | ";
        return false;
    }
    if($felhasznalojelszava1 != $felhasznalojelszava1){
        $error= "HIBA: A két jelszónak egyeznie kell | ";
        return false;
    }

    /* check if user exists */
    $userCheck = "SELECT 1 FROM cegadatok  WHERE Ceg_cegnev  = '".$cegneve."' OR Ceg_cegjegyzek_szam  = '".$cegjegyzekszam."' OR Ceg_adoszam  = '".$adoszam."' ";
    if( mysqli_num_rows( mysqli_query( $db->dbConnect(), $userCheck ) ) ){
        $error= "A cég név már szerepel a rendszerben <br> cég jegyzekszám <br> adoszam már szerepel az adatbázisban ";
        return false;
    }

    if (isset($_POST['cegneve']) && isset($_POST['cegjegyzekszam']) && isset($_POST['szekhely']) && isset($_POST['telefonoselerhetoseg']) &&
        isset($_POST['adoszam'])&& isset($_POST['bankszamlaszam'])&& isset($_POST['ugyentizo'])&& isset($_POST['kapcsolattarto'])&& isset($_POST['alakulasev'])&&
        isset($_POST['tevekenyseg'])&& isset($_POST['tipusmegnevezes'])&& isset($_POST['felhasznalojelszava1'])&& isset($_POST['emailcim'])) {
        if ($db->dbConnect()) {
            if ($db->RegisztracioAdmin("Ceg_cegnev", isset($_POST['cegneve']) && isset($_POST['cegjegyzekszam']) && isset($_POST['szekhely']) && isset($_POST['telefonoselerhetoseg']) &&
                isset($_POST['adoszam'])&& isset($_POST['bankszamlaszam'])&& isset($_POST['ugyentizo'])&& isset($_POST['kapcsolattarto'])&& isset($_POST['alakulasev'])&&
                isset($_POST['tevekenyseg'])&& isset($_POST['tipusmegnevezes'])&& isset($_POST['felhasznalojelszava1'])&& isset($_POST['emailcim'])&& isset($_POST['felhasznalonev']))) {

                header('Location: http://localhost/diploma2/ceg_valaszto.php');

                echo "Sikeres regisztráció";
            } else $error= " Sikertelen regisztracio";
        } else $error= "Sikertelen adatbázis kapcsolodás";
    } else $error= "Minden mező kitőltése kötelező";
}
?>