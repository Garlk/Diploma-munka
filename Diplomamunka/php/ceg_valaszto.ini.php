<?php

require "DataBase.php";
$db = new DataBase();


if (isset($_POST['ujcegG'])) {
    header('Location: http://localhost/diploma2/uj_cegfelvitel.php'); /*Fadnim felhasznalo*/
}

$k = "Nincs_ceg";
if (isset($_POST['egyenivallalG'])) {

        $nev = $_POST['egyenivallal'];
        if ($k != $nev) {
            $_SESSION['egyenivallalkozas'] = $_POST['egyenivallal'];

            header('Location: http://localhost/diploma2/valasztott_ceg_adatok.php');
        } else {
            $_SESSION['hiba'] = "<span style='color:red;'>nem választott ki céget </span>";
        }

}

if (isset($_POST['tarsvallalG'])) {

        $nev = $_POST['tarsvallal'];
        if ($k != $nev) {
            $_SESSION['tarsasvallalkozas'] = $_POST['tarsvallal'];
            header('Location: http://localhost/diploma2/valasztott_ceg_adatok.php');
        } else {
            $_SESSION['hiba'] = "<span style='color:red;'>nem választott ki céget </span>";
        }

}
if(isset($_POST['kilepesG'])) {
    unset($_SESSION['Belepet']['tipus']);
    session_destroy();
    header('Location: index.php');
}

?>