<?php
require "DataBase.php";

$db = new DataBase();

if (isset($_POST['ID'])) {
	
    if ($db->dbConnect()) {
		
        if ($db->Felhasznalo_profil("felhasznalo", $_POST['ID'])) {
			$valasz = implode("|",$db->Felhasznalo_profil("felhasznalo", $_POST['ID']));
			
            echo $valasz;
        } else echo "le kérdezéses sikertelen";
    } else echo "Sikertelen adatbázis kapcsolodás";
} else echo "ID mező hianyzik";

?>
