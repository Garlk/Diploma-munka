<?php
require "DataBase.php";
$db = new DataBase();
$result="";
$_SESSION['Hiba'] = "";
if(isset($_SESSION['egyenivallalkozas'])){

	$userCheck = "SELECT `Felhasznalo_nev` FROM `felhasznalok` WHERE `Felhasznalo_ceg`= '".$_SESSION['egyenivallalkozas']."'";
	$result=mysqli_query( $db->dbConnect(), $userCheck);
	$row= $result -> fetch_array(MYSQLI_ASSOC);

	$Cegfelhasznalonev=$row['Felhasznalo_nev'];

	$userCheck = "SELECT  `ID`, `Ceg_cegnev`, `Ceg_tipusa`, `Ceg_cegjegyzek_szam`, `Ceg_adoszam`, `Ceg_szekhely`, `Ceg_telefonsz`, `Ceg_email`,
       `Ceg_bankszamla_szam`, `Ceg_alakulasi_ev`, `Ceg_ugyvezeto`, `Ceg_kapcsolattarto`, `Ceg_tevekenyseg`FROM `cegadatok` WHERE `Ceg_cegnev` = '".$_SESSION['egyenivallalkozas']."'";
	$result=mysqli_query( $db->dbConnect(), $userCheck);
	$row = $result -> fetch_array(MYSQLI_ASSOC);

	$eID=$row['ID'];

	$eredeticegneve=$row['Ceg_cegnev'];

	$Cegtipusa=$row['Ceg_tipusa'];
	$Cegjegyzek=$row['Ceg_cegjegyzek_szam'];
	$Cegadoszam=$row['Ceg_adoszam'];
	$Cegszekhely=$row['Ceg_szekhely'];
	$Cegtelefonszam=$row['Ceg_telefonsz'];
	$Cegemail=$row['Ceg_email'];
	$Cegbankszamla=$row['Ceg_bankszamla_szam'];
	$Cegalakulasa=$row['Ceg_alakulasi_ev'];
	$Cegugyveezeto=$row['Ceg_ugyvezeto'];
	$Cegkapcsolattarto=$row['Ceg_kapcsolattarto'];
	$Cegtevekenysege=$row['Ceg_tevekenyseg'];

	}
	elseif(isset($_SESSION['tarsasvallalkozas'])){

		$userCheck = "SELECT `Felhasznalo_nev` FROM `felhasznalok` WHERE `Felhasznalo_ceg`= '".$_SESSION['tarsasvallalkozas']."'";
		$result=mysqli_query( $db->dbConnect(), $userCheck);
		$row= $result -> fetch_array(MYSQLI_ASSOC);

		$Cegfelhasznalonev=$row['Felhasznalo_nev'];

			$userCheck1 = "SELECT `ID`,`Ceg_cegnev`, `Ceg_tipusa`, `Ceg_cegjegyzek_szam`, `Ceg_adoszam`, `Ceg_szekhely`, `Ceg_telefonsz`, `Ceg_email`,
       		`Ceg_bankszamla_szam`, `Ceg_alakulasi_ev`, `Ceg_ugyvezeto`, `Ceg_kapcsolattarto`, `Ceg_tevekenyseg` FROM `cegadatok` WHERE `Ceg_cegnev` = '".$_SESSION['tarsasvallalkozas']."'";
			$result = mysqli_query($db->dbConnect(), $userCheck1);
			$row1 = $result->fetch_array(MYSQLI_ASSOC);

			$eID=$row1['ID'];

			$eredeticegneve = $row1['Ceg_cegnev'];

			$Cegtipusa = $row1['Ceg_tipusa'];
			$Cegjegyzek = $row1['Ceg_cegjegyzek_szam'];
			$Cegadoszam = $row1['Ceg_adoszam'];
			$Cegszekhely = $row1['Ceg_szekhely'];
			$Cegtelefonszam = $row1['Ceg_telefonsz'];
			$Cegemail = $row1['Ceg_email'];
			$Cegbankszamla = $row1['Ceg_bankszamla_szam'];
			$Cegalakulasa = $row1['Ceg_alakulasi_ev'];
			$Cegugyveezeto = $row1['Ceg_ugyvezeto'];
			$Cegkapcsolattarto = $row1['Ceg_kapcsolattarto'];
			$Cegtevekenysege = $row1['Ceg_tevekenyseg'];


	}
		if(isset($_POST['adatokmentes'])) {

			$felhasznalojelszava0="";
			$cegnev=$_POST['cegneve'];
			$cegjegyzekszam = $_POST['cegjegyzekszam'];/**/
			$telefonoselerhetoseg = $_POST['telefonoselerhetoseg'];/**/
			$emailcim = $_POST['emailcim']; /**/
			$adoszam = $_POST['adoszam'];/**/
			$bankszamlaszam = $_POST['bankszamlaszam'];/**/
			$tevekenyseg = $_POST['tevekenyseg'];
			$tipusmegnevezes = $_POST['Tarsas_valalk'];/* át kell alakítani választó selectre*/
			$alakulasev = $_POST['alakulasev'];
			$kapcsolattarto = $_POST['kapcsolattarto'];
			$ugyentizo = $_POST['ugyentizo'];
			$szekhely = $_POST['szekhely'];

			$jelszo0=$_POST['felhasznalojelszava0'];
			$jelszo1=$_POST['felhasznalojelszava0'];

			if (filter_var($emailcim, FILTER_VALIDATE_EMAIL)) { /*email cím validitás ellenőrzés*/
				if (12 >= strlen($cegjegyzekszam) && strlen($cegjegyzekszam) >= 10) {  /*Cégjegyzék hossz ellenőrzés 10 + kettő "-" 12*/
					if (13 >= strlen($adoszam) && 11 <= strlen($adoszam)) {  /*Adószám hossz ellenőrzés 11 + kettő "-" 13*/
						/*****************Cég név ellenőrzés*********************/
						$cegCheck = "SELECT `ID`,`Ceg_cegnev` FROM `cegadatok` WHERE `Ceg_cegnev`= '" . $_POST['cegneve'] . "' ";
						if ($eredeticegneve == $_POST['cegneve']) {
							$cegnev = "nincs_valt";
						} elseif (empty($_POST['cegneve'])) {
							$_SESSION['hiba'] = "A cég név üres nem lehet";

						} elseif (mysqli_num_rows(mysqli_query($db->dbConnect(), $cegCheck))) {
							$_SESSION['hiba'] = "<span style='color:red;'>Az új cég név már szerepel az adatbázisban</span>";

						} else {
							$cegnev = $_POST['cegneve'];
						}

						/*****************Cégjegyzék ellenőrzés *********************/
						$cegjegyzekCheck = "SELECT  `Ceg_cegjegyzek_szam` FROM `cegadatok` WHERE Ceg_cegjegyzek_szam='" . $_POST['cegjegyzekszam'] . "'";
						if ($Cegjegyzek == $_POST['cegjegyzekszam']) {
							$cegjegyzek = "nincs_valt";
						} elseif (empty($_POST['cegneve'])) {
							$_SESSION['hiba'] = "Cégjegyzék üres nem lehet";

						} elseif (mysqli_num_rows(mysqli_query($db->dbConnect(), $cegjegyzekCheck))) {
							$_SESSION['hiba'] = "Foglalt cégjegyzékszám, már szerepel az adatbáziban";

						} else {
							$cegjegyzek = $_POST['cegjegyzekszam'];
						}

						/*****************Adószám ellenörzés *********************/
						$adoszamCheck = "SELECT  `Ceg_adoszam` FROM `cegadatok` WHERE Ceg_adoszam='" . $_POST['adoszam'] . "'";
						if ($Cegadoszam == $_POST['adoszam']) {
							$adoszam = "nincs_valt";
						} elseif (empty($_POST['cegneve'])) {
							$_SESSION['hiba'] = "Adószám üres nem lehet";

						} elseif (mysqli_num_rows(mysqli_query($db->dbConnect(), $adoszamCheck))) {
							$_SESSION['hiba'] = "Foglalt Adószám, már szerepel az adatbáziban";

						} else {
							$adoszam = $_POST['adoszam'];
						}

						/*****************Jelszó ellenörzés *********************/
						if (!empty($jelszo0) || !empty($jelszo1)) {
							if ($jelszo0 == $jelszo1) {
								$felhasznalojelszava0 = password_hash($jelszo0, PASSWORD_DEFAULT);
								/** jelszó modosítás szükséges e ?**/
								$jelszomodosítas = 1;
							} else {

								$_SESSION['Hiba'] = "<span style='color:red;'>A két jelszónak egyeznie kell  </span> ";
							}
						} else {
							$jelszomodosítas = 404;
							$felhasznalojelszava0 = 404;
						}

						if (isset($eredeticegneve) && isset($cegnev) && isset($_POST['Tarsas_valalk']) && isset($cegjegyzek) && isset($adoszam)&& isset($felhasznalojelszava0)
							&& isset($_POST['szekhely']) && isset($_POST['telefonoselerhetoseg']) && isset($_POST['emailcim']) && isset($_POST['bankszamlaszam'])
							&& isset($_POST['alakulasev']) && isset($_POST['ugyentizo']) && isset($_POST['kapcsolattarto']) && isset($_POST['tevekenyseg'])
							&& isset($Cegfelhasznalonev) && isset($eID)) {
							//echo $felhasznalojelszava0."   |";
							if ($db->dbConnect()) {
								//echo " | 153 | ".$eredeticegneve." | ".$cegnev." |";
								if ($db->Ceg_adatok_modosítas("cegadatok", $eredeticegneve,
									$cegnev, $_POST['Tarsas_valalk'],
									$cegjegyzek, $adoszam,
									$_POST['szekhely'], $_POST['telefonoselerhetoseg'],$felhasznalojelszava0,
									$_POST['emailcim'],	$_POST['bankszamlaszam'], $_POST['alakulasev'],
									$_POST['ugyentizo'], $_POST['kapcsolattarto'],
									$_POST['tevekenyseg'], $Cegfelhasznalonev,$jelszomodosítas,$_SESSION['jelszohas']
									,$eID)) {

									header('Location: http://localhost/diploma2/valasztott_ceg_adatok.php');

								} else $_SESSION['Hiba'] = " Sikertelen modosítás";


							} else {
								$_SESSION['Hiba'] = "Sikertelen adatbázis kapcsolodássdsdsd";

							}
						} else {
							$_SESSION['Hiba'] = "Hianyos adatok";

						}
					} else {
						$_SESSION['Hiba'] = "<span style='color:red;'>Az dószám szám nem lehet több mint 13 vagy kevesebb mint 11</span>";

					}
				} else {
					$_SESSION['Hiba'] = "<span style='color:red;'>A cégjegyzék szám nem lehet több mint 12 vagy kevesebb mint 10</span>";

				}
			} else {
				$_SESSION['Hiba'] = "<span style='color:red;'>Nem valós emailcíme lett megadva</span>";

			}
		}

		if(isset($_POST['kepfeltotes'])){
			//$_SESSION['ceg_neve']=$eredeticegneve;
			header('Location: http://localhost/diploma2/fajl_megtekintes.php');
		}

		if(isset($_POST['cegtorles'])){




			if (isset($Cegfelhasznalonev) ) {
				if ($db->dbConnect()) {
					// cég nevét kell át adni
					if ($db->Ceg_admin_torlese( $eredeticegneve)) {

						header('Location: http://localhost/diploma2/ceg_valaszto.php');

					} else{ $_SESSION['Hiba'] = " A törlés sikertelen volt";}
				} else { $_SESSION['Hiba'] = "Sikertelen adatbázis kapcsolodássdsdsd";}
			} else { $_SESSION['Hiba'] = "Hianyos adatok"; }
		}

		if(isset($_POST['kilepesG'])) {
			session_destroy();
			unset($_SESSION['Belepet']['tipus']);
			header('Location: index.php');
		}

		if(isset($_POST['viszalepes'])) {
			header('Location: ceg_valaszto.php');
		}


?>

