<?php
require "DataBase.php";

$db = new DataBase();

if (isset($_POST['ID'])&&($_POST['valasztot_termek_neve'])) {
	
    if ($db->dbConnect()) {
		
        if ($db->Hirdetes_torles("hirdetes", $_POST['ID'], $_POST['valasztot_termek_neve'])) {
			
			
            echo "Sikeres hirdetes torles";
        } else echo "le kérdezés";
    } else echo "Sikertelen adatbázis kapcsolodás";
} else echo "ID mező hianyzik";

?>