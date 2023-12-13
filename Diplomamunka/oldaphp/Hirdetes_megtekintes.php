<?php
require "DataBase.php";

$db = new DataBase();

if (isset($_POST['ID'])) {
	
    if ($db->dbConnect()) {
		
        if ($db->Hirdetesek("hirdetes", $_POST['ID'])) {
			//$valasz = ($db->Hirdetesek("hirdetes", $_POST['ID']));
			
            //echo $valasz;
        } else echo "le kérdezés";
    } else echo "Sikertelen adatbázis kapcsolodás";
} else echo "ID mező hianyzik";

?>