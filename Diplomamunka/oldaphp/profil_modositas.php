<?php
require "DataBase.php";

$db = new DataBase();

if (isset($_POST['ID']) && isset($_POST['Teljes_nev'])&& isset($_POST['Reg_faja'])
	&& isset($_POST['Szul_ido']) && isset($_POST['P_email']) && isset($_POST['K_email']) 
	&& isset($_POST['B_telefon']) && isset($_POST['B_vallalkozas_neve']) &&isset($_POST['B_leiras'])) {

    if ($db->dbConnect()) {
        if ($db->Felhasznalo_profil_modositas("felhasznalo", $_POST['ID'],
		$_POST['Teljes_nev'], $_POST['Reg_faja'], $_POST['Szul_ido'], $_POST['P_email'],$_POST['K_email'], 
		$_POST['B_telefon'],$_POST['B_vallalkozas_neve'],$_POST['B_leiras'])){
			
             echo "Modositasok sikeresek voltak";
			 
        } else echo " Sikertelen adat frisites";
    } else echo "Sikertelen adatbázis kapcsolodás";
} else echo "Mező nem maradthat üresen";
?>