<?php
require "DataBase.php";

$db = new DataBase();

if (isset($_POST['ID']) && isset($_POST['ujelszo'])&& isset($_POST['rjelszo'])) {
    if ($db->dbConnect()) {
		$Jelszo_csere = $db->Jelszo_csere("felhasznalo", $_POST['ID'], $_POST['ujelszo'], $_POST['rjelszo']);
        if ($Jelszo_csere) {
            
		} else echo "Hibas jelszo lett megadva";
    } else echo "Hiba: Adatbaziassal valo kapcsolatban hiba lepet fel";
} else echo "Minden mezot kitoltese kotelezo";
?>