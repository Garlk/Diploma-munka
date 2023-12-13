<?php
require "DataBase.php";
$db = new DataBase();


$error="";
if (isset($_POST['regisztG'])) {
	 $email = $_POST['emailcim'];
	 $username = $_POST['felhasznalonev'];
	 $jelszava1 =  $_POST['jelszava1'];
	 $jelszava2 =  $_POST['jelszava2'];
		if( mb_strlen($jelszava1) < 6 ){
			$error= "HIBA: A jelszó legalább 6 karakter kell legyen | ";
			return false;
		}
		if($jelszava1 != $jelszava2){
			$error= "HIBA: A két jelszónak egyeznie kell | ";
			return false;
		}
        
		/* check if user exists */
		$userCheck = "SELECT 1 FROM felhasznalok  WHERE Felhasznalo_email  = '".$email."' OR Felhasznalo_nev = '".$username."' ";
		if( mysqli_num_rows( mysqli_query( $db->dbConnect(), $userCheck ) ) ){
			$error= "Foglalt felhasználónév / email | ";
			return false;
		}
	
	if (isset($_POST['felhasznalonev']) && isset($_POST['emailcim']) && isset($_POST['rendelocegneve']) && isset($_POST['jelszava1'])&& isset($_POST['jelszava2'])) {
		if ($db->dbConnect()) {
			if ($db->FARegisztracio("felhasznalok", $_POST['felhasznalonev'], $_POST['emailcim'], $_POST['rendelocegneve'], $_POST['jelszava1'], $_POST['jelszava2'])) {
				$error= "Sikeres Regisztracio";
			} else $error= " Sikertelen regisztracio";
		} else $error= "Sikertelen adatbázis kapcsolodás";
	} else $error= "Minden mező kitőltése kötelező";
}
?>
