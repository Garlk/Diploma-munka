<?php
require "DataBase.php";
$db = new DataBase();
if (isset($_POST['teljesnev']) && isset($_POST['email']) && isset($_POST['felhasznalonev']) && isset($_POST['jelszo'])&& isset($_POST['szul_ido'])) {
    if ($db->dbConnect()) {
        if ($db->Regisztracio("felhasznalo", $_POST['teljesnev'], $_POST['email'], $_POST['felhasznalonev'], $_POST['jelszo'], $_POST['szul_ido'])) {
            echo "Sikeres Regisztracio";
        } else echo " Sikertelen regisztracio";
    } else echo "Sikertelen adatbázis kapcsolodás";
} else echo "Minden mező kitőltése kötelező";
?>
