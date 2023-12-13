<?php
require "DataBase.php";
$db = new DataBase();

if(isset($_SESSION['tarsasvallalkozas'])){
    $valalkozasneve = $_SESSION['tarsasvallalkozas'];
}elseif(isset($_SESSION['egyenivallalkozas'])){
    $valalkozasneve = $_SESSION['egyenivallalkozas'];
}elseif(isset($_SESSION['felhaszvallal'])){
    $valalkozasneve = $_SESSION['felhaszvallal'];
}


if(isset($_POST['fajl_feltoltesG'])){
    //$_SESSION['ceg_neve']=$eredeticegneve;
    header('Location: http://localhost/diploma2/fajl_feltoltes.php');
}

if(isset($_POST['kilepesG'])) {
    session_start();
    session_unset();
    session_destroy();
// Redirect to the login page:
    header('Location: index.php');}

if(isset($_POST['viszalepes'])) {

    header('Location: valasztott_ceg_adatok.php');}

?>