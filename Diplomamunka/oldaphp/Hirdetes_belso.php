<?php
require "DataBase.php";

$db = new DataBase();

if (isset($_POST['ID'],$_POST['valasztot_termek_neve'])) {
	

    if ($db->dbConnect()) {
		$hirdetesB=$db->Hirdetes_belso("hirdetes", $_POST['ID'], $_POST['valasztot_termek_neve']);
        if ($hirdetesB) {
			$valasz = implode("|",$hirdetesB);
			
            echo $valasz;
        } else echo "le kérdezéses sikertelen";
    } else echo "Sikertelen adatbázis kapcsolodás";
} else echo "ID mező hianyzik";

?>