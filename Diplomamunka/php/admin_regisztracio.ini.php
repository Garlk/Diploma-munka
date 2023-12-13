<?php
require "DataBase.php";
$db = new DataBase();


$error="";
if (isset($_POST['regisztG'])) {
	$email = $_POST['emailcim'];
	$username = $_POST['felhasznalonev'];
	$jelszava1 = $_POST['jelszava1'];
	$jelszava2 = $_POST['jelszava2'];


	if (mb_strlen($jelszava1) < 8) {
		$error = "HIBA: A jelszó legalább 8 karakter kell legyen | ";
		return false;
	}
	if ($jelszava1 != $jelszava2) {
		$error = "HIBA: A két jelszónak egyeznie kell | ";
		return false;
	}
	if (!preg_match("/^(?=.*[!'@#$;,%^&*-]).{8,16}$/",$username)) {
		/* check if user exists */
		$userCheck = "SELECT 1 FROM felhasznalok  WHERE Felhasznalo_email  = '" . $email . "' OR Felhasznalo_nev = '" . $username . "' ";
		if (mysqli_num_rows(mysqli_query($db->dbConnect(), $userCheck))) {
			$error = "Foglalt felhasználónév fomrailag nem helyes ";
			return false;
		}
	}
	$jelszava1 = password_hash($_POST['jelszava1'], PASSWORD_DEFAULT);
		if (isset($_POST['felhasznalonev']) && isset($_POST['emailcim']) && isset($_POST['rendelocegneve']) && isset($jelszava1) && isset($_SESSION['name'])) {
			if ($db->dbConnect()) {
				if ($db->FARegisztracio("felhasznalok", $_POST['felhasznalonev'], $_POST['emailcim'], $_POST['rendelocegneve'], $jelszava1, $_SESSION['name'])) {
					$error = "Sikeres Regisztracio";
				} else $error = " Sikertelen regisztracio";
			} else $error = "Sikertelen adatbázis kapcsolodás";
		} else $error = "Minden mező kitőltése kötelező";
	}

	$userCheck = "SELECT `ID`,`Felhasznalo_ceg`,`Felhasznalo_nev` FROM `felhasznalok` WHERE `Felhasznalo_letrehozo`='".$_SESSION['name']."' ";
	$result = mysqli_query($db->dbConnect(), $userCheck);
	if(mysqli_num_rows( mysqli_query( $db->dbConnect(), $userCheck ))) {
		while ($row = mysqli_fetch_row($result)) {

			if (isset($_POST['torlesadminG' . $row[0]])) {

				if ($db->dbConnect()) {

					if ($db->Admintorles($row[2])) ;
					{
						header("refresh: 3; url = admin_regisztracios.php");
						//echo "Sikeres volt a torles";
					}
				}
			}
		}
	}

if(isset($_POST['kilepesG'])) {
	session_destroy();
// Redirect to the login page:
	header('Location: index.php');
}


?>
