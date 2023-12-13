<?php
require "DataBase.php";

$db = new DataBase();
if (isset($_POST['felhasznalonev']) && isset($_POST['jelszo'])) {
    if ($db->dbConnect()) {
		$login = $db->logIn("felhasznalo", $_POST['felhasznalonev'], $_POST['jelszo']);
        if ($login) {
            
			echo $login;
		} else echo "K3";
    } else echo "K2";
} else echo "K1";
?>