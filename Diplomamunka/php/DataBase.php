<?php
require "DataBaseConfig.php";

class DataBase
{
	public $connect;
	public $data;
	private $sql;
	protected $szervernev;
	protected $usernev;
	protected $jelszo;
	protected $adatbazis;
	public $teszter;

	public function __construct()
	{
		$this->connect = null;
		$this->data = null;
		$this->sql = null;
		$dbc = new DataBaseConfig();
		$this->szervernev = $dbc->szervernev;
		$this->usernev = $dbc->usernev;
		$this->jelszo = $dbc->jelszo;
		$this->adatbazis = $dbc->adatbazis;
	}

	function dbConnect()
	{
		$this->connect = mysqli_connect($this->szervernev, $this->usernev, $this->jelszo, $this->adatbazis);
		mysqli_query($this->connect, "SET NAMES 'utf8'");
		return $this->connect;
	}

	function prepareData($data)
	{
		return mysqli_real_escape_string($this->connect, stripslashes(htmlspecialchars($data)));
	}

	/**-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*Azonositó function*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*--**/

	function Azonosito($Belepet_felhasz,$Azonosítando_cegnev){

		$Belepet_felhasz = $this->prepareData($Belepet_felhasz);
		$Azonosítando_cegnev = $this->prepareData($Azonosítando_cegnev);

		$this->sql="select Felhasznalo_reg_fajta from felhasznalok where Felhasznalo_nev = '" . $Belepet_felhasz . "'";
		$result = mysqli_query($this->connect, $this->sql);
		$row = mysqli_fetch_assoc($result);

		$this->sql1="select Felhasznalo_reg_fajta from felhasznalok where Felhasznalo_nev = '" . $Belepet_felhasz . "'";
		$result1 = mysqli_query($this->connect, $this->sql1);
		$felhasztipus = mysqli_fetch_assoc($result1);

		$jogkor = $felhasztipus['Felhasznalo_reg_fajta'];

		if($jogkor=1){

			$this->sql="SELECT  `Felhasznalo_jelszo`
						FROM felhasznalok 
						INNER JOIN cegadatok
						ON felhasznalok.Felhasznalo_nev  = cegadatok.Ceg_letrehozo
						WHERE cegadatok.Ceg_cegnev ='".$Azonosítando_cegnev."'";
			$result = mysqli_query($this->connect, $this->sql);
			$parjelszo = mysqli_fetch_assoc($result);

			$jelszo1=$parjelszo['Felhasznalo_jelszo'];



		}elseif ($jogkor=2){

			$this->sql="SELECT  `Felhasznalo_jelszo`
						FROM felhasznalok 
						INNER JOIN cegadatok
						ON felhasznalok.Felhasznalo_nev  = cegadatok.Ceg_letrehozo
						WHERE cegadatok.Ceg_cegnev ='".$Azonosítando_cegnev."'";
			$result = mysqli_query($this->connect, $this->sql);
			$row = mysqli_fetch_assoc($result);

			$row['Felhasznalo_jelszo'];
			$this->sql="select Felhasznalo_jelszo from " . $table . " where Felhasznalo_nev = '" . $Azonosítando_par . "' and  	Felhasznalo_reg_fajta = '".$jogkor."'";
			$result = mysqli_query($this->connect, $this->sql);
			$row = mysqli_fetch_assoc($result);

		}

	}

	/**-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*Belépés*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*--**/
	function logIn($table, $usernev, $jelszo)
	{

		$usernev = $this->prepareData($usernev);
		$jelszo = $this->prepareData($jelszo);
		$this->sql = "select * from " . $table . " where Felhasznalo_nev = '" . $usernev . "'";
		$result = mysqli_query($this->connect, $this->sql);
		$row = mysqli_fetch_assoc($result);
		if (mysqli_num_rows($result) == 1) {
			$dbusernev = $row['Felhasznalo_nev'];
			$dbjelszo = $row['Felhasznalo_jelszo'];
			$regfajta = $row['Felhasznalo_reg_fajta'];
			if ($dbusernev == $usernev && password_verify($jelszo, $dbjelszo)) {
				$login = $regfajta;
			} else $login = false;
		} else $login = false;
		return $login;
	}

	/**-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*Admin regisztráció*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*--**/
	function FARegisztracio($table, $felhasznalonev, $emailcim, $rendelocegneve, $jelszava1, $regfelhasznalonev)
	{

		$regiszt_date = date('Y-m-d H:i:s');
		$felhasznalonev = $this->prepareData($felhasznalonev);
		$emailcim = $this->prepareData($emailcim);
		$rendelocegneve = $this->prepareData($rendelocegneve);
		//$jelszava1 = $this->prepareData($jelszava1);
		$regfelhasznalonev = $this->prepareData($regfelhasznalonev);

		//$jelszava1 = password_hash($jelszava1, PASSWORD_DEFAULT);

		$regfajta = 2;
		$this->sql =
			"INSERT INTO " . $table . " ( Felhasznalo_email, Felhasznalo_jelszo, Felhasznalo_nev, Felhasznalo_reg_ido, Felhasznalo_reg_fajta, `Felhasznalo_ceg`, `Felhasznalo_letrehozo`) 
             				VALUES ('" . $emailcim . "','" . $jelszava1 . "','" . $felhasznalonev . "','" . $regiszt_date . "','" . $regfajta . "','" . $rendelocegneve . "','" . $regfelhasznalonev . "')";
		if (mysqli_query($this->connect, $this->sql)) {

			return true;
		} else
			echo mysqli_error($this->connect);
		return false;
	}

	/**-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*Cég/felhasznalo regisztráció*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*--**/
	function RegisztracioAdmin($table, $cegneve, $cegjegyzekszam, $szekhely, $telefonoselerhetoseg, $adoszam, $bankszamlaszam, $ugyentizo,
							   $kapcsolattarto, $alakulasev, $tevekenyseg, $tipusmegnevezes, $emailcim, $felhasznalonev, $ceg_felhanszalo, $felhasznalojelszava1)
	{


		$cegneve = $this->prepareData($cegneve);
		$cegjegyzekszam = $this->prepareData($cegjegyzekszam);
		$szekhely = $this->prepareData($szekhely);
		$telefonoselerhetoseg = $this->prepareData($telefonoselerhetoseg);
		$adoszam = $this->prepareData($adoszam);
		$bankszamlaszam = $this->prepareData($bankszamlaszam);
		$ugyentizo = $this->prepareData($ugyentizo);
		$kapcsolattarto = $this->prepareData($kapcsolattarto);
		$alakulasev = $this->prepareData($alakulasev);
		$tevekenyseg = $this->prepareData($tevekenyseg);
		$tipusmegnevezes = $this->prepareData($tipusmegnevezes);

		$felhasznalonev = $this->prepareData($felhasznalonev);

		$emailcim = $this->prepareData($emailcim);
		$ceg_felhanszalo = $this->prepareData($ceg_felhanszalo);
		$felhasznalojelszava1 = $this->prepareData($felhasznalojelszava1);
		$regfajta = 1;

		$regiszt_date = date('Y-m-d H:i:s');

		$felhasznalojelszava1 = password_hash($felhasznalojelszava1, PASSWORD_DEFAULT);

		$this->sql =
			"INSERT INTO `felhasznalok` (`Felhasznalo_email`, `Felhasznalo_jelszo`, `Felhasznalo_nev`, `Felhasznalo_reg_ido`,`Felhasznalo_reg_fajta`, `Felhasznalo_ceg`, `Felhasznalo_letrehozo`) 			 
			VALUES ('" . $emailcim . "','" . $felhasznalojelszava1 . "','" . $ceg_felhanszalo . "','" . $regiszt_date . "','" . $regfajta . "','" . $cegneve . "','" . $felhasznalonev . "')";
		if (mysqli_query($this->connect, $this->sql)) {
		echo  $tipusmegnevezes;
			$this->sql1 =
				"INSERT INTO " . $table . " (`Ceg_cegnev`, `Ceg_tipusa`, `Ceg_cegjegyzek_szam`, `Ceg_adoszam`, `Ceg_szekhely`, `Ceg_telefonsz`, `Ceg_email`, 
			`Ceg_bankszamla_szam`, `Ceg_alakulasi_ev`, `Ceg_ugyvezeto`, `Ceg_kapcsolattarto`, `Ceg_tevekenyseg`, `Ceg_letrehozo`) 
			 
			VALUES ('" . $cegneve . "','" . $tipusmegnevezes . "','" . $cegjegyzekszam . "','" . $adoszam . "','" . $szekhely . "','" . $telefonoselerhetoseg . "','" . $emailcim . "',
			'" . $bankszamlaszam . "','" . $alakulasev . "','" . $ugyentizo . "','" . $kapcsolattarto . "','" . $tevekenyseg . "','" . $felhasznalonev . "')";
			if (mysqli_query($this->connect, $this->sql1)) {

				return true;
			} else
				echo mysqli_error($this->connect);
			return false;

		} else
			echo mysqli_error($this->connect);
		return false;
	}

	/**--*-*-*-*-*-*-*-*-*-*-*-*-*-*Cég adat modosítás*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*--**/
	function Ceg_adatok_modosítas($table, $Ceg_regi_neve, $Ceg_neve, $Ceg_tipus, $Ceg_jegyzekszam, $Ceg_adoszam, $Ceg_szekhely, $Ceg_telefonsz, $Ceg_felhasznalo_ujelszava,
								  $Ceg_email, $Ceg_bankszamlaszam, $Ceg_alakulasiev, $Ceg_ugyintezo, $Ceg_kapcsolattarto, $Ceg_tevekenyseg,
								  $Ceg_felhasznalo, $jelszomodositasjelzo, $belepetfelhasznalo,$cegid)
	{
		$table = $this->prepareData($table);
		$cegid = $this->prepareData($cegid);

		//$Ceg_felhasznalo_ujelszava = $this->prepareData($Ceg_felhasznalo_ujelszava);


		$ceg_ujneve = $this->prepareData($Ceg_neve);
		$ceg_regi_neve = $this->prepareData($Ceg_regi_neve);

		$ceg_tipusa = $this->prepareData($Ceg_tipus);
		$ceg_jegyzekszam = $this->prepareData($Ceg_jegyzekszam);
		$ceg_adoszam = $this->prepareData($Ceg_adoszam);
		$ceg_szekhely = $this->prepareData($Ceg_szekhely);
		$ceg_telefonsz = $this->prepareData($Ceg_telefonsz);
		$ceg_email = $this->prepareData($Ceg_email);
		$ceg_bankszamlaszam = $this->prepareData($Ceg_bankszamlaszam);
		$ceg_alakulasiev = $this->prepareData($Ceg_alakulasiev);
		$ceg_ugyintezo = $this->prepareData($Ceg_ugyintezo);
		$ceg_kapcsolattarto = $this->prepareData($Ceg_kapcsolattarto);
		$ceg_tevekenyseg = $this->prepareData($Ceg_tevekenyseg);

		$jelszomodositasjelzo; /*jelszó modosítas lehetséges*/

		$ceg_felhasznalo = $this->prepareData($Ceg_felhasznalo); /* bármilyen cég adat update */
		/* felhasznalo jelszo át állítás*/


		/***************** Céges adatok Update *********************/

		/******Céges neve******/
		if ($ceg_ujneve != "nincs_valt") {

			$this->sql = "UPDATE `fajladatok` SET `Fajl_tulaj`='" . $ceg_ujneve . "' WHERE `Fajl_tulaj` = '" . $ceg_regi_neve . "'";
			mysqli_query($this->dbConnect(), $this->sql);
			$this->sql = "UPDATE `cegadatok` SET `Ceg_cegnev`='" . $ceg_ujneve . "' WHERE `Ceg_cegnev`='" . $ceg_regi_neve . "'";
			mysqli_query($this->dbConnect(), $this->sql);
			$this->sql = "UPDATE `felhasznalok` SET `Felhasznalo_ceg`='" . $ceg_ujneve . "' WHERE `Felhasznalo_ceg`='" . $ceg_regi_neve . "'";
			//echo $this->sql ;
			mysqli_query($this->dbConnect(), $this->sql);
		} else {
			$ceg_ujneve = $ceg_regi_neve;
		}
		/****** Céges jegyzéki száma ******/
		if ($ceg_jegyzekszam != "nincs_valt") {
			$this->sql = "UPDATE `cegadatok` SET `Ceg_cegjegyzek_szam`='" . $ceg_jegyzekszam . "' WHERE `ID` = '" . $cegid . "'";
			mysqli_query($this->dbConnect(), $this->sql);
		}
		/****** Céges adószáma ******/
		if ($ceg_adoszam != "nincs_valt") {
			$this->sql = "UPDATE `cegadatok` SET `Ceg_adoszam`='" . $ceg_adoszam . "' WHERE `ID` = '" . $cegid . "'";
			mysqli_query($this->dbConnect(), $this->sql);
		}
/*
		$this->sql0 = "UPDATE felhasznalok SET Felhasznalo_ceg='" . $ceg_ujneve . "' WHERE Felhasznalo_nev = '" . $ceg_felhasznalo . "' ";
		if (mysqli_query($this->connect, $this->sql)) {
		} else {
			echo mysqli_error($this->connect);
		}
*/
		/****** Felhasználó saját felelőségére bízott adatok ellenőrzése még szükséges lehet  ******/

		/****** Felhasználó saját felelőségére bízott adatok ******/
		$this->sql = "UPDATE `cegadatok` SET `Ceg_tipusa`= '" . $ceg_tipusa . "',
												`Ceg_szekhely`='" . $ceg_szekhely . "',
												`Ceg_telefonsz`='" . $ceg_telefonsz . "',
												`Ceg_email`='" . $ceg_email . "',
												`Ceg_bankszamla_szam`='" . $ceg_bankszamlaszam . "',
												`Ceg_alakulasi_ev`='" . $ceg_alakulasiev . "',
												`Ceg_ugyvezeto`='" . $ceg_ugyintezo . "',
												`Ceg_kapcsolattarto`='" . $ceg_kapcsolattarto . "',
												`Ceg_tevekenyseg`='" . $ceg_tevekenyseg . "' 
												WHERE `ID`='" . $cegid . "'";
		mysqli_query($this->connect, $this->sql);
		$result = mysqli_query($this->connect, $this->sql);
		if (mysqli_affected_rows($this->connect) > 0) {
			return true;
		} else {
			echo mysqli_error($this->connect);
		}

		/*****************Jelszó modosítás *********************/
		if($jelszomodositasjelzo == "1" and $belepetfelhasznalo=="sikeresen belépet a felhasználó"){
			$this->sql = "UPDATE felhasznalok SET Felhasznalo_jelszo='" . $Ceg_felhasznalo_ujelszava . "' WHERE Felhasznalo_nev = '" . $ceg_felhasznalo . "' ";
			mysqli_query($this->dbConnect(), $this->sql);

		}else {
			echo "";
		}
		return true;
	}
	/***************** Céges adatok Update *********************/

	function Ceg_adatok_modosítas_alap($table, $Ceg_regi_neve, $Ceg_neve, $Ceg_tipus, $Ceg_jegyzekszam, $Ceg_adoszam, $Ceg_szekhely, $Ceg_telefonsz,
								  $Ceg_email, $Ceg_bankszamlaszam, $Ceg_alakulasiev, $Ceg_ugyintezo, $Ceg_kapcsolattarto, $Ceg_tevekenyseg,
								  $Ceg_felhasznalo,$cegid)
	{
		$table = $this->prepareData($table);
		$cegid = $this->prepareData($cegid);

		//$Ceg_felhasznalo_ujelszava = $this->prepareData($Ceg_felhasznalo_ujelszava);


		$ceg_ujneve = $this->prepareData($Ceg_neve);
		$ceg_regi_neve = $this->prepareData($Ceg_regi_neve);

		$ceg_tipusa = $this->prepareData($Ceg_tipus);
		$ceg_jegyzekszam = $this->prepareData($Ceg_jegyzekszam);
		$ceg_adoszam = $this->prepareData($Ceg_adoszam);
		$ceg_szekhely = $this->prepareData($Ceg_szekhely);
		$ceg_telefonsz = $this->prepareData($Ceg_telefonsz);
		$ceg_email = $this->prepareData($Ceg_email);
		$ceg_bankszamlaszam = $this->prepareData($Ceg_bankszamlaszam);
		$ceg_alakulasiev = $this->prepareData($Ceg_alakulasiev);
		$ceg_ugyintezo = $this->prepareData($Ceg_ugyintezo);
		$ceg_kapcsolattarto = $this->prepareData($Ceg_kapcsolattarto);
		$ceg_tevekenyseg = $this->prepareData($Ceg_tevekenyseg);



		$ceg_felhasznalo = $this->prepareData($Ceg_felhasznalo); /* bármilyen cég adat update */



		/***************** Céges adatok Update *********************/

		/******Céges neve******/
		if ($ceg_ujneve != "nincs_valt") {

			$this->sql = "UPDATE `fajladatok` SET `Fajl_tulaj`='" . $ceg_ujneve . "' WHERE `Fajl_tulaj` = '" . $ceg_regi_neve . "'";
			mysqli_query($this->dbConnect(), $this->sql);
			$this->sql = "UPDATE `cegadatok` SET `Ceg_cegnev`='" . $ceg_ujneve . "' WHERE `Ceg_cegnev`='" . $ceg_regi_neve . "'";
			mysqli_query($this->dbConnect(), $this->sql);
			$this->sql = "UPDATE `felhasznalok` SET `Felhasznalo_ceg`='" . $ceg_ujneve . "' WHERE `Felhasznalo_ceg`='" . $ceg_regi_neve . "'";
			//echo $this->sql ;
			mysqli_query($this->dbConnect(), $this->sql);
		} else {
			$ceg_ujneve = $ceg_regi_neve;
		}
		/****** Céges jegyzéki száma ******/
		if ($ceg_jegyzekszam != "nincs_valt") {
			$this->sql = "UPDATE `cegadatok` SET `Ceg_cegjegyzek_szam`='" . $ceg_jegyzekszam . "' WHERE `ID` = '" . $cegid . "'";
			mysqli_query($this->dbConnect(), $this->sql);
		}
		/****** Céges adószáma ******/
		if ($ceg_adoszam != "nincs_valt") {
			$this->sql = "UPDATE `cegadatok` SET `Ceg_adoszam`='" . $ceg_adoszam . "' WHERE `ID` = '" . $cegid . "'";
			mysqli_query($this->dbConnect(), $this->sql);
		}

		/****** Felhasználó saját felelőségére bízott adatok ******/
		$this->sql = "UPDATE `cegadatok` SET `Ceg_tipusa`= '" . $ceg_tipusa . "',
												`Ceg_szekhely`='" . $ceg_szekhely . "',
												`Ceg_telefonsz`='" . $ceg_telefonsz . "',
												`Ceg_email`='" . $ceg_email . "',
												`Ceg_bankszamla_szam`='" . $ceg_bankszamlaszam . "',
												`Ceg_alakulasi_ev`='" . $ceg_alakulasiev . "',
												`Ceg_ugyvezeto`='" . $ceg_ugyintezo . "',
												`Ceg_kapcsolattarto`='" . $ceg_kapcsolattarto . "',
												`Ceg_tevekenyseg`='" . $ceg_tevekenyseg . "' 
												WHERE `ID`='" . $cegid . "'";
		//mysqli_query($this->connect, $this->sql);
		$result = mysqli_query($this->connect, $this->sql);
		if (mysqli_affected_rows($this->connect) > 0) {
			return true;
		} else {
			echo mysqli_error($this->connect);
		}
		return true;
	}

	/****** 1 szintű felhasználó adatai ************************************************************************************************************************************/
	function Ceg_adatok_modosítas_egysz($Ceg_neve, $Ceg_tipus, $Ceg_jegyzekszam,$Ceg_adoszam,$Ceg_regi_neve,
										$Ceg_szekhely, $Ceg_telefonsz, $Ceg_email, $Ceg_bankszamlaszam, $Ceg_alakulasiev, $Ceg_ugyintezo,
										$Ceg_kapcsolattarto, $Ceg_tevekenyseg,$cegid)
	{
		$cegid = $this->prepareData($cegid);

		$ceg_ujneve = $this->prepareData($Ceg_neve);
		$ceg_regi_neve = $this->prepareData($Ceg_regi_neve);

		$ceg_tipusa = $this->prepareData($Ceg_tipus);
		$ceg_jegyzekszam = $this->prepareData($Ceg_jegyzekszam);
		$ceg_adoszam = $this->prepareData($Ceg_adoszam);
		$ceg_szekhely = $this->prepareData($Ceg_szekhely);
		$ceg_telefonsz = $this->prepareData($Ceg_telefonsz);
		$ceg_email = $this->prepareData($Ceg_email);
		$ceg_bankszamlaszam = $this->prepareData($Ceg_bankszamlaszam);
		$ceg_alakulasiev = $this->prepareData($Ceg_alakulasiev);
		$ceg_ugyintezo = $this->prepareData($Ceg_ugyintezo);
		$ceg_kapcsolattarto = $this->prepareData($Ceg_kapcsolattarto);
		$ceg_tevekenyseg = $this->prepareData($Ceg_tevekenyseg);

		/******Céges neve******/
		if ($ceg_ujneve != "nincs_valt") {

			$this->sql = "UPDATE `fajladatok` SET `Fajl_tulaj`='" . $ceg_ujneve . "' WHERE `Fajl_tulaj` = '" . $ceg_regi_neve . "'";
			mysqli_query($this->dbConnect(), $this->sql);
			$this->sql = "UPDATE `cegadatok` SET `Ceg_cegnev`='" . $ceg_ujneve . "' WHERE `Ceg_cegnev`='" . $ceg_regi_neve . "'";
			mysqli_query($this->dbConnect(), $this->sql);
			$this->sql = "UPDATE `felhasznalok` SET `Felhasznalo_ceg`='" . $ceg_ujneve . "' WHERE `Felhasznalo_ceg`='" . $ceg_regi_neve . "'";
			//echo $this->sql ;
			mysqli_query($this->dbConnect(), $this->sql);
		} else {
			$ceg_ujneve = $ceg_regi_neve;
		}
		/****** Céges jegyzéki száma ******/
		if ($ceg_jegyzekszam != "nincs_valt") {
			$this->sql = "UPDATE `cegadatok` SET `Ceg_cegjegyzek_szam`='" . $ceg_jegyzekszam . "' WHERE `ID` = '" . $cegid . "'";
			mysqli_query($this->dbConnect(), $this->sql);
		}
		/****** Céges adószáma ******/
		if ($ceg_adoszam != "nincs_valt") {
			$this->sql = "UPDATE `cegadatok` SET `Ceg_adoszam`='" . $ceg_adoszam . "' WHERE `ID` = '" . $cegid . "'";
			mysqli_query($this->dbConnect(), $this->sql);
		}

		/****** Felhasználó saját felelőségére bízott adatok ******/
		$this->sql = "UPDATE `cegadatok` SET `Ceg_tipusa`= '" . $ceg_tipusa . "',
												`Ceg_szekhely`='" . $ceg_szekhely . "',
												`Ceg_telefonsz`='" . $ceg_telefonsz . "',
												`Ceg_email`='" . $ceg_email . "',
												`Ceg_bankszamla_szam`='" . $ceg_bankszamlaszam . "',
												`Ceg_alakulasi_ev`='" . $ceg_alakulasiev . "',
												`Ceg_ugyvezeto`='" . $ceg_ugyintezo . "',
												`Ceg_kapcsolattarto`='" . $ceg_kapcsolattarto . "',
												`Ceg_tevekenyseg`='" . $ceg_tevekenyseg . "' 
												WHERE `ID`='" . $cegid . "'";
		//mysqli_query($this->connect, $this->sql);
		$result = mysqli_query($this->connect, $this->sql);
		if (mysqli_affected_rows($this->connect) > 0) {
			return true;
		} else {
			echo mysqli_error($this->connect);
		}
		return true;
	}

	/**--*-*-*-*-*-*-*-*-*-*-*-*-*-*Fájl feltöltés*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*--************************************************************************************************/
	function Fajlok_feltoltese_egyeb($table, $Fajlneve, $Fajlervenyes_ho, $Fajlervenyes_ev, $Fajl_tipus, $Feltoltofelhasznalo,
									 $Fajl_cegestulaja, $Fajl_szerverhelye, $Fajl_szerverneve)
	{

		$Fajl_kategoria = "egyeb";
		$Fajl_tipus_ellenor = $this->prepareData($Fajl_tipus);
		$Fajlervenyes_ev = $this->prepareData($Fajlervenyes_ev);
		$Fajlervenyes_ho = $this->prepareData($Fajlervenyes_ho);
		$Fajlneve = $this->prepareData($Fajlneve);
		$Fajl_szerverneve = $this->prepareData($Fajl_szerverneve);
		$Fajl_szerverhelye = $this->prepareData($Fajl_szerverhelye);
		$regiszt_date = date('Y-m-d');
		$Fajl_kiallito = "nincs";

		if ($Fajl_tipus_ellenor = "Nav_ugyi") {
			$Fajl_tipus = "NAV ügyintézés";
		} elseif ($Fajl_tipus_ellenor = "Munka_ugyi") {
			$Fajl_tipus = "Munka ügyintézés";
		} elseif ($Fajl_tipus_ellenor = "Egyeb") {
			$Fajl_tipus = "Hiányosság";
		} else {
			echo "hiba történt";
			exit();
		}
		$this->sql = "INSERT INTO `fajladatok`( `Fajl_nev`, `Fajl_feltoltesi_ido`, `Fajl_ervenyes_ho`, `Fajl_ervenyes_ev`, `Fajl_kiallito_ceg`, `Fajl_tipusa`,
                         `Fajl_egyeb_tipusok`, `Fajl_tulaj`, `Fajl_feltolto`,  `Fajl_helye`, `Fajl_szerverneve`) 
					VALUES ('$Fajlneve','" . $regiszt_date . "','" . $Fajlervenyes_ho . "','" . $Fajlervenyes_ev . "','" . $Fajl_kiallito . "','" . $Fajl_kategoria . "','" . $Fajl_tipus . "',
					'" . $Fajl_cegestulaja . "','" . $Feltoltofelhasznalo . "','" . $Fajl_szerverhelye . "','" . $Fajl_szerverneve . "')";
		//mysqli_query($this->connect, $this->sql);
		if (mysqli_query($this->connect, $this->sql)) {

			return true;
		} else
			echo mysqli_error($this->connect);
		return false;
	}

	function Fajlok_feltoltese_bank($table, $Fajlneve, $Fajlervenyes_ho, $Fajlervenyes_ev, $Fajl_tipus, $Feltoltofelhasznalo, $Fajl_cegestulaja, $Fajl_szerverhelye, $Fajl_szerverneve)
	{

		$Feltoltofelhasznalo = $this->prepareData($Feltoltofelhasznalo);

		$Fajl_kategoria = "bank";
		$Fajl_tipus_ellenor = $this->prepareData($Fajl_tipus);
		$Fajlervenyes_ev = $this->prepareData($Fajlervenyes_ev);
		$Fajlervenyes_ho = $this->prepareData($Fajlervenyes_ho);
		$Fajlneve = $this->prepareData($Fajlneve);
		$Fajl_szerverneve = $this->prepareData($Fajl_szerverneve);
		$Fajl_szerverhelye = $this->prepareData($Fajl_szerverhelye);
		$regiszt_date = date('Y-m-d');
		$Fajl_kiallito = "nincs";

		if ($Fajl_tipus_ellenor = "Bankszamla") {
			$Fajl_tipus = "Bankszámla";
		} elseif ($Fajl_tipus_ellenor = "Szamlatortenet") {
			$Fajl_tipus = "Számlatörténet";
		} else {
			echo "hiba történt";
			exit();
		}

		$this->sql = "INSERT INTO `fajladatok`( `Fajl_nev`, `Fajl_feltoltesi_ido`, `Fajl_ervenyes_ho`, `Fajl_ervenyes_ev`, `Fajl_kiallito_ceg`, `Fajl_tipusa`,
                         `Fajl_egyeb_tipusok`, `Fajl_tulaj`, `Fajl_feltolto`,  `Fajl_helye`, `Fajl_szerverneve`) 
					VALUES ('$Fajlneve','" . $regiszt_date . "','" . $Fajlervenyes_ho . "','" . $Fajlervenyes_ev . "','" . $Fajl_kiallito . "','" . $Fajl_kategoria . "','" . $Fajl_tipus . "',
					'" . $Fajl_cegestulaja . "','" . $Feltoltofelhasznalo . "','" . $Fajl_szerverhelye . "','" . $Fajl_szerverneve . "')";
		if (mysqli_query($this->connect, $this->sql)) {
			return true;
		} else
			echo mysqli_error($this->connect);
		return false;
	}

	function Fajlok_feltoltese_szamla($table, $Fajlneve, $Fajlervenyes_ho, $Fajlervenyes_ev, $Fajl_tipus, $Feltoltofelhasznalo, $Fajl_cegestulaja, $Fajl_szerverhelye, $Fajl_szerverneve, $Fajl_kiallitoja)
	{

		$Feltoltofelhasznalo = $this->prepareData($Feltoltofelhasznalo);

		$Fajl_kategoria = "szamla";
		$Fajl_kiallitoja = $this->prepareData($Fajl_kiallitoja);
		$Fajl_tipus_ellenor = $this->prepareData($Fajl_tipus);
		$Fajlervenyes_ev = $this->prepareData($Fajlervenyes_ev);
		$Fajlervenyes_ho = $this->prepareData($Fajlervenyes_ho);
		$Fajlneve = $this->prepareData($Fajlneve);
		$Fajl_szerverneve = $this->prepareData($Fajl_szerverneve);
		$Fajl_szerverhelye = $this->prepareData($Fajl_szerverhelye);
		$regiszt_date = date('Y-m-d');

		if ($Fajl_tipus_ellenor = "Bszamla") {
			$Fajl_tipus = "Bejövő számla";
		} elseif ($Fajl_tipus_ellenor = "Kszamla") {
			$Fajl_tipus = "Kimenő számla";
		} else {
			echo "hiba történt";
			exit();
		}

		$this->sql = "INSERT INTO `fajladatok`( `Fajl_nev`, `Fajl_feltoltesi_ido`, `Fajl_ervenyes_ho`, `Fajl_ervenyes_ev`, `Fajl_kiallito_ceg`, `Fajl_tipusa`,
                         `Fajl_egyeb_tipusok`, `Fajl_tulaj`, `Fajl_feltolto`, `Fajl_helye`, `Fajl_szerverneve`) 
					VALUES ('$Fajlneve','" . $regiszt_date . "','" . $Fajlervenyes_ho . "','" . $Fajlervenyes_ev . "','" . $Fajl_kiallitoja . "','" . $Fajl_kategoria . "','" . $Fajl_tipus . "',
					'" . $Fajl_cegestulaja . "','" . $Feltoltofelhasznalo . "','" . $Fajl_szerverhelye . "','" . $Fajl_szerverneve . "')";
		if (mysqli_query($this->connect, $this->sql)) {
			return true;
		} else
			echo mysqli_error($this->connect);
		return false;
	}

	/**--*-*-*-*-*-*-*-*-*-*-*-*-*-*Fájl törlés*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*--**/

	function Fajlok_torles($table, $ID, $cegtulaj, $kepszerverhelye, $kepszerverneve, $fneve)
	{
		//$jelszo_csek = $this->prepareData($fjelszava);

		$fajl_eredetineve = $this->prepareData($fneve);
		$id = $this->prepareData($ID);

		$kepszerverhelye = $this->prepareData($kepszerverhelye);
		$kepszerverneve = $this->prepareData($kepszerverneve);

		$Fajl_cegestulaja = $this->prepareData($cegtulaj);

			$file_name = $kepszerverneve; // file name from front end
			$location_with_image_name = ("php/fileupload/".$Fajl_cegestulaja."/" ). $file_name;
			//echo ("fileupload/".$file_name);
			if (file_exists($location_with_image_name)) {

				$this->sql1 = "DELETE FROM `fajladatok` WHERE  ID ='" . $id . "'";
				//$result = mysqli_query($this->connect, $this->sql1);
				if (mysqli_query($this->connect, $this->sql1)) {
					//echo " | delete success from database ";
					$delete = unlink($location_with_image_name);

					if ($delete) {
						//sikeres törlés történt";
					} else {
						echo "sikertelen volt a fájl törlése";
					}

					return true;

				} else {
					echo mysqli_error($this->connect);
					echo " database delete not success";
					return false;
				}

			} else {
				echo "A fájl már létezik";
			}
		//}
		/*else {
			echo "jelszo hiba0   $kozosjelszo";


		}
*/
	}


	/**--*-*-*-*-*-*-*-*-*-*-*-*-*-*-*Fájl letöltés*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*--**/

	function Fajlok_letoltes($table, $Ceg_neve0, $Ceg_neve1, $jelszo)
	{
		$ceg_eredetineve = $this->prepareData($Ceg_neve0);
		$ceg_ujneve = $this->prepareData($Ceg_neve1);
		$jelszo = $this->prepareData($jelszo);

	}

	/**--*-*-*-*-*-*-*-*-*-*-*-*-*-*-*Admin jelszo modosítas*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*--**/
	function AdminJelszoModositas($table, $ID, $ujelszo, $felhasznalonev)
	{
		$ID = $this->prepareData($ID);

		$table = $this->prepareData($table);
		$felhasznalonev = $this->prepareData($felhasznalonev);

		$this->sql1 = "UPDATE `felhasznalok` SET Felhasznalo_jelszo='" . $ujelszo . "' WHERE ID='" . $ID . "' ";
		mysqli_query($this->connect, $this->sql1);
		if (mysqli_affected_rows($this->connect) > 0) {
			return true; //$siker = $i . "fájl jelszo változás történ uj jelszó adatbázisban" . $jelszohash;
		} else {
			echo mysqli_error($this->connect);
			return true; // $siker = "Hiba a functionban";
		}
	}



	/**--*-*-*-*-*-*-*-*-*-*-*-*-*-*-*Cég/fájl törlés*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*--**/
	function CegFajlTorles($cegnevevaltozo) {
		$mappaUtvonal= 'php/fileupload/' . $cegnevevaltozo."/";
		if (!is_dir($mappaUtvonal)) {
			throw new InvalidArgumentException("$mappaUtvonal nem egy mappa.");
		}

		$files = array_diff(scandir($mappaUtvonal), array('.', '..'));

		foreach ($files as $file) {
			$fajlUtvonal = $mappaUtvonal . '/' . $file;
			if (is_dir($fajlUtvonal)) {
				CegFajlTorles($fajlUtvonal);
			} else {
				unlink($fajlUtvonal);
			}
		}

		rmdir($mappaUtvonal);
	}

// Mappa törlése név alapján
//$targetDir = '/elérési/útvonal/a/mappához';
//$fileCelHelye = 'php/fileupload/' . $cegnevevaltozo."/";
//deleteDirectory($targetDir);

	/**--*-*-*-*-*-*-*-*-*-*-*-*-*-*-*Cég törlés*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*--**/
	function Ceg_admin_torlese($Cegneve)
	{
		function CegFajlTorles($cegnevevaltozo) {
			$mappaUtvonal= 'php/fileupload/' . $cegnevevaltozo."/";
			if (!is_dir($mappaUtvonal)) {

			}else{
				$files = array_diff(scandir($mappaUtvonal), array('.', '..'));

				foreach ($files as $file) {
					$fajlUtvonal = $mappaUtvonal . '/' . $file;
					if (is_dir($fajlUtvonal)) {
						CegFajlTorles($fajlUtvonal);
					} else {
						unlink($fajlUtvonal);
					}
				}

				rmdir($mappaUtvonal);
			}
		}

		$cegfelhasznalo = "DELETE FROM `felhasznalok` WHERE Felhasznalo_ceg = '" .$Cegneve . "'";
		$result = mysqli_query($this->dbConnect(), $cegfelhasznalo);
		if ($result === false) {
			$error = mysqli_error($this->dbConnect());
			echo "SQL hiba történt: " . $error;
		} else {
		}

		$cegfajlok = "DELETE FROM `fajladatok` WHERE Fajl_tulaj = '" . $Cegneve . "'";
		$result = mysqli_query($this->dbConnect(), $cegfajlok);
		if ($result === false) {
			$error = mysqli_error($this->dbConnect());
			echo "SQL hiba történt: " . $error;
		} else {
		}

		$ceg = "DELETE FROM `cegadatok` WHERE Ceg_cegnev = '" . $Cegneve . "'";
		$result = mysqli_query($this->dbConnect(), $ceg);
		if ($result === false) {
			$error = mysqli_error($this->dbConnect());
			echo "SQL hiba történt: " . $error;
		} else {
		}

		CegFajlTorles($Cegneve);
		return true;
	}

	/**--*-*-*-*-*-*-*-*-*-*-*-*-*-*-*Admin törles*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*--**/

	function Admintorles($felhasznalonev)
	{
		function CegFajlTorles($cegnevevaltozo) {
			$mappaUtvonal= 'php/fileupload/' . $cegnevevaltozo."/";
			if (!is_dir($mappaUtvonal)) {
				//throw new InvalidArgumentException("$mappaUtvonal nem egy mappa.");
			}else{
				$files = array_diff(scandir($mappaUtvonal), array('.', '..'));

				foreach ($files as $file) {
					$fajlUtvonal = $mappaUtvonal . '/' . $file;
					if (is_dir($fajlUtvonal)) {
						CegFajlTorles($fajlUtvonal);
					} else {
						unlink($fajlUtvonal);
					}
				}
				rmdir($mappaUtvonal);
			}

		}

		$felhasznalonev = $this->prepareData($felhasznalonev);

		$userCheck = "SELECT `Ceg_cegnev` FROM `cegadatok` WHERE `Ceg_letrehozo`='".$felhasznalonev."' ";
		$result = mysqli_query($this->dbConnect(), $userCheck);
		if(mysqli_num_rows($result)) {
			while ($row = mysqli_fetch_row($result)) {
				$Hiba="";
				$cegfelhasznalo = "DELETE FROM `felhasznalok` WHERE Felhasznalo_ceg = '" . $row[0] . "'";
				$result1 = mysqli_query($this->dbConnect(), $cegfelhasznalo);
				if ($result1 === false) {
					$error = mysqli_error($this->dbConnect());
					$Hiba= "SQL hiba történt0: " . $error;
				}

				$cegfajlok = "DELETE FROM `fajladatok` WHERE Fajl_tulaj = '" . $row[0] . "'";
				$result1 = mysqli_query($this->dbConnect(), $cegfajlok);
				if ($result1 === false) {
					$error = mysqli_error($this->dbConnect());
					$Hiba= "SQL hiba történt1: " . $error;
				}

				$ceg = "DELETE FROM `cegadatok` WHERE Ceg_cegnev = '" . $row[0] . "'";
				$result1 = mysqli_query($this->dbConnect(), $ceg);
				if ($result1 === false) {
					$error = mysqli_error($this->dbConnect());
					$Hiba= "SQL hiba történt2: " . $error;
				}

				$mappaUtvonal= 'php/fileupload/'.$row[0];
				if (!is_dir($mappaUtvonal)) {
					//throw new InvalidArgumentException("$mappaUtvonal nem egy mappa.");
				}else {

					$files = array_diff(scandir($mappaUtvonal), array('.', '..'));

					foreach ($files as $file) {
						$fajlUtvonal = $mappaUtvonal . '/' . $file;
						if (is_dir($fajlUtvonal)) {
							CegFajlTorles($fajlUtvonal);
						} else {
							unlink($fajlUtvonal);
						}
					}

					rmdir($mappaUtvonal);
					//CegFajlTorles($row[0]);
				}
			}
		}
		$AdminFelhasznTor = "DELETE FROM `felhasznalok` WHERE Felhasznalo_nev = '" . $felhasznalonev . "'";
		$result = mysqli_query($this->dbConnect(), $AdminFelhasznTor);
		if ($result === false) {
			$error = mysqli_error($this->dbConnect());
			$Hiba= "SQL hiba történt: " . $error;
		} else {

		}
	}
	/**--*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*--**/

}


?>
