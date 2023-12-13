<?php
require "DataBase.php";
$db = new DataBase();
if (isset($_POST['ID']) && isset($_POST['Termek_neve']) && isset($_POST['Elerheto_mennyiseg0']) && isset($_POST['Meddigerhetoel'])&& isset($_POST['Termek_ara'])
		&& isset($_POST['KepKod'])&& isset($_POST['Termek_leiras'])&& isset($_POST['Fizetesi_mod'])&& isset($_POST['Iranyitoszam0'])&& isset($_POST['Telepules_neve'])&& isset($_POST['Utca0'])
		&& isset($_POST['Hazszam0'])&& isset($_POST['Mikortol0'])&& isset($_POST['Meddig'])) {
    if ($db->dbConnect()) {
        if ($db->Hirdetes_feltoltes("hirdetes", $_POST['ID'], $_POST['Termek_neve'], $_POST['Elerheto_mennyiseg0'], $_POST['Meddigerhetoel'], $_POST['Termek_ara']
								, $_POST['KepKod'], $_POST['Termek_leiras'], $_POST['Fizetesi_mod'], $_POST['Iranyitoszam0'], $_POST['Telepules_neve'], $_POST['Utca0'], $_POST['Hazszam0']
								, $_POST['Mikortol0'], $_POST['Meddig'])) {
            echo "Sikeres hirdetes feltoltes";
        } else echo " Sikertelen hirdetes feltoltes";
    } else echo "Sikertelen adatbazis kapcsolodas";
} else echo "Minden mezo kitoltese koteleze";
?>