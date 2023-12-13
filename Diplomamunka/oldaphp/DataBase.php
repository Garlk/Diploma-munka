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
	//$teszter=1;
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
		mysqli_query($this->connect,"SET NAMES 'utf8'");
        return $this->connect;
    }

    function prepareData($data)
    {
        return mysqli_real_escape_string($this->connect, stripslashes(htmlspecialchars($data)));
    }
	
	function logIn($table, $usernev, $jelszo)
	{
		
        $usernev = $this->prepareData($usernev);
        $jelszo = $this->prepareData($jelszo);
        $this->sql = "select * from " . $table . " where Felhasznalo_nev = '" .$usernev. "'";
        $result = mysqli_query($this->connect, $this->sql);
        $row = mysqli_fetch_assoc($result);
        if (mysqli_num_rows($result) == 1) {
            $dbusernev = $row['Felhasznalo_nev'];
            $dbjelszo = $row['Jelszo'];
			$dbID = $row['ID'];
            if ($dbusernev == $usernev && password_verify($jelszo, $dbjelszo)) {
                //$teszter = $jelszo;
				//$ID =$dbID;
				$login = $dbID;
				//echo "52 $dbusernev if";
			} else $login = false;
			//var_dump(password_verify($jelszo,$dbjelszo));
        } else $login = false;
		return $login;
    }

    function Regisztracio($table, $teljesnev, $email, $usernev, $jelszo, $szul_ido)
    {
        $teljesnev = $this->prepareData($teljesnev);
        $usernev = $this->prepareData($usernev);
        $jelszo = $this->prepareData($jelszo);
        $email = $this->prepareData($email);
		$szul_ido = $this->prepareData($szul_ido);
		
		$szul_ido_tomb = explode("/",$szul_ido);
		if(count($szul_ido_tomb) == 3 ){
			
			if(!checkdate( $szul_ido_tomb[1], $szul_ido_tomb[2], $szul_ido_tomb[0]) || $szul_ido_tomb[0] > date("Y")){
				//nem stimmel a dátum
				echo "HIBA: A születési dátum hibás";
				return false;
			}
			
		}else{
			//túl rövid
			echo "HIBA: A születési dátum túl rövid";
			return false;
		}
		
		if( mb_strlen($jelszo) < 6 ){
			echo "HIBA: A jelszó legalább 6 karakter kell legyen";
			return false;
		}
        $jelszo = password_hash($jelszo, PASSWORD_DEFAULT);
		
		
		/* check if user exists */
		$userCheck = "SELECT 1 FROM " . $table . " WHERE Email = '{$email}' OR Felhasznalo_nev = '{$usernev}' ";
		if( mysqli_num_rows( mysqli_query( $this->connect, $userCheck ) ) ){
			echo "Foglalt felhasználónév / email";
			return false;
		}

        $this->sql =
            "INSERT INTO " . $table . " (Teljes_nev , Felhasznalo_nev, Jelszo, Email, Szul_ido) VALUES ('" . $teljesnev . "','" . $usernev . "','" . $jelszo . "','" . $email . "','" . $szul_ido . "')";
        if (mysqli_query($this->connect, $this->sql)) {
		
            return true;
        } else 
		echo mysqli_error($this->connect);	
		return false;
    }
	
	function Felhasznalo_profil($table,$ID)
	{
		$ID = $this->prepareData($ID);
		$this->sql = "SELECT Felhasznalo_nev , Teljes_nev , Email , Kontakt_email , Telefonszam , Szul_ido , Reg_ido , Vallalkozas_neve , Leiras , Megbizhatosag   FROM " .$table . " WHERE ID = '".$ID."' ";
        $result = mysqli_query($this->connect, $this->sql);
		if (mysqli_num_rows($result)) {
			$row = mysqli_fetch_assoc($result);
            return $row;
        } else {
			echo mysqli_error($this->connect);	
			return false;
		}
	}

	function Felhasznalo_profil_modositas($table,$ID,$teljes_nev,$reg_fajta,$szul_ido,$email,$kontakt_email,$telefonszam,$valalkozas_nev,$leiras)
	{
		$reg_fajta = $this->prepareData($reg_fajta);
		$teljes_nev = $this->prepareData($teljes_nev);
        $telefonszam = $this->prepareData($telefonszam);
        $valalkozas_nev = $this->prepareData($valalkozas_nev);
		$leiras = $this->prepareData($leiras);
		$kontakt_email = $this->prepareData($kontakt_email);
        $email = $this->prepareData($email);
		$szul_ido = $this->prepareData($szul_ido);
		$ID = $this->prepareData($ID);
		$table = $this->prepareData($table);
		
		$this->sql = "UPDATE felhasznalo SET Email='".$email."',Teljes_nev='". $teljes_nev ."',Reg_fajta='". $reg_fajta ."',Kontakt_email='".$kontakt_email."',Telefonszam='".$telefonszam ."',Vallalkozas_neve='".$valalkozas_nev."'	,Leiras='".$leiras."',Szul_ido='".$szul_ido."'WHERE ID ='".$ID."'";
		
		//echo $this->sql;
		
        $result = mysqli_query($this->connect, $this->sql);
		if (mysqli_affected_rows($this->connect)>0) {
            return true;
        } else {
			echo mysqli_error($this->connect);	
			return false;
		}
	}
	
    function Jelszo_csere($table,$ID,$ujelszo,$rjelszo)
    {
        $ujelszo=$this->prepareData($ujelszo);
        $rjelszo = $this->prepareData($rjelszo);
		$ID = $this->prepareData($ID);
		$table=$this->prepareData($table);
		
		$this->sql ="SELECT * FROM ".$table." WHERE ID=".$ID." ";
		$result = mysqli_query($this->connect, $this->sql);
		
		$row = mysqli_fetch_assoc($result);
        if (mysqli_num_rows($result) == 1) {
			
			$dbjelszo = $row['Jelszo'];
			if (password_verify($rjelszo, $dbjelszo)) 
			{
                
					$jelszo2 = password_hash($ujelszo, PASSWORD_DEFAULT);
					$this->sql ="UPDATE ". $table ." SET Jelszo = '".$jelszo2."' WHERE ID=".$ID." ";
					$result = mysqli_query($this->connect, $this->sql);
						if (mysqli_affected_rows($this->connect) > 0) {
							
							echo"Jelszo valtoztatas vegbement uj jelszava";
							return true;
						}else{
							echo "hiba 2";
							echo mysqli_error($this->connect);	
							return false;
						}
				
			} else {
				echo mysqli_error($this->connect);
				//echo $rjelszo."  ".$dbjelszo;
				return false;
			}
        } else 
			return false;
	}

	
	function Hirdetes_feltoltes($table,$ID,$Termek_neve,$Mennyiseg,$Hirdetes_vege,$Termek_ara,$Kep,$Termek_leiras,$Fizetesi_lehetoseg,$Iranyito_szam,$Telepules_neve,$Utca,$Haz_szam,$Mettol_veheto_at,$Meddig_veheto_at)
	{
		$ID = $this->prepareData($ID);
		$table=$this->prepareData($table);
		$Termek_neve=$this->prepareData($Termek_neve);
        $Hirdetes_vege = $this->prepareData($Hirdetes_vege);
		$Termek_leiras=$this->prepareData($Termek_leiras);
        $Termek_ara = $this->prepareData($Termek_ara);
		$Fizetesi_lehetoseg=$this->prepareData($Fizetesi_lehetoseg);
		$Mennyiseg=$this->prepareData($Mennyiseg);

        $Iranyito_szam = $this->prepareData($Iranyito_szam);
		$Telepules_neve=$this->prepareData($Telepules_neve);
        $Utca = $this->prepareData($Utca);
		$Haz_szam=$this->prepareData($Haz_szam);
        $Mettol_veheto_at = $this->prepareData($Mettol_veheto_at);
		$Meddig_veheto_at=$this->prepareData($Meddig_veheto_at);
		
		//Sql00
		
		$this->sql = "INSERT INTO `eladoi_helyek`( `Iranyito_szam`, `Telepules`, `Utca`, `Haz_szam`, `Nyitas`, `Zaras`) 
		VALUES ('$Iranyito_szam','$Telepules_neve','$Utca','$Haz_szam','$Mettol_veheto_at','$Meddig_veheto_at')";
		mysqli_query($this->connect, $this->sql);
		
		$eid = mysqli_insert_id($this->connect);

		//Sql01
		
		$this->sql = "INSERT INTO `hirdetes`(`Elado_ID`, `Elado_helyek_ID`, `Termek_neve`, `Menyiseg`, `Ajan_veg`, `Ar`, `Kep`, `Hleiras`, `Fizetesi_mod`) 
		VALUES ('$ID',".$eid.",'$Termek_neve','$Mennyiseg','$Hirdetes_vege','$Termek_ara',
		'". mysqli_real_escape_string($this->connect,$Kep)."','$Termek_leiras','$Fizetesi_lehetoseg')";
        
		
		
		//$result = mysqli_query($this->connect, $this->sql);
        if (mysqli_query($this->connect, $this->sql)) 
		{
            return true;
        } else 
			echo mysqli_error($this->connect);	
			return false;
	}

	

	Function Hirdetesek($table,$ID)
	{
		$ID = $this->prepareData($ID);
		
		$this->sql = "SELECT `ID`, `Termek_neve`, `Ar`, `Kep`, `Hleiras` FROM `hirdetes`  ";
        $result = mysqli_query($this->connect, $this->sql);
		if (mysqli_num_rows($result)) {
			$tomb=[];
			while ($row = mysqli_fetch_assoc($result)) {
				$tomb[]="{$row['Termek_neve']};{$row['Ar']};{$row['Hleiras']};{$row['Kep']}";
				// EOL = \r vagy \r\n
			}
			echo implode("|",$tomb);
			return true;
			
        } else {
			echo mysqli_error($this->connect);	
			return false;
		}
	}
	Function Sajat_irdetesek($table,$ID)
	{
		$ID = $this->prepareData($ID);
		
		$this->sql = "SELECT `ID`, `Termek_neve`, `Ar`, `Kep`, `Hleiras` FROM `hirdetes` WHERE Elado_ID = '".ID."'  ";
        $result = mysqli_query($this->connect, $this->sql);
		if (mysqli_num_rows($result)) {
			$tomb=[];
			while ($row = mysqli_fetch_assoc($result)) {
				$tomb[]="{$row['Termek_neve']};{$row['Ar']};{$row['Hleiras']};{$row['Kep']}";
				// EOL = \r vagy \r\n
			}
			echo implode("|",$tomb);
			return true;
			
        } else {
			echo mysqli_error($this->connect);	
			return false;
		}
	}
	
	
	//-------------------------------------------------------------------
		function Hirdetes_belso($table,$ID,$valasztot_termek_neve)
	{
		$ID = $this->prepareData($ID);
		$valasztot_termek_neve = $this->prepareData($valasztot_termek_neve);
		

		
		$this->sql = " SELECT  `Termek_neve`, `Menyiseg`, `Ajan_veg`, `Ar`, `Kep`, `Hleiras`, `Fizetesi_mod`, `Iranyito_szam`, `Telepules`, `Utca`, `Haz_szam`, `Nyitas`,`Zaras`
		FROM hirdetes
		LEFT JOIN eladoi_helyek
		ON hirdetes.Elado_helyek_ID = eladoi_helyek.ID
		WHERE Elado_ID = '".$ID."' and Termek_neve = '".$valasztot_termek_neve."' ";
		

		
        $result = mysqli_query($this->connect, $this->sql);
		if (mysqli_num_rows($result)) {
			$row = mysqli_fetch_assoc($result);
			//echo $result;
            return $row;
        } else {
			echo mysqli_error($this->connect);	
			echo"hiba lett"; 
			return false;
		}
		
	}
		Function Sajat_hirdetesek($table,$ID)
	{
		$ID = $this->prepareData($ID);
		
		$this->sql = "SELECT `ID`, `Termek_neve`, `Ar`, `Kep`, `Hleiras` FROM `hirdetes` WHERE Elado_ID = '".$ID."'  ";
        $result = mysqli_query($this->connect, $this->sql);
		if (mysqli_num_rows($result)) {
			$tomb=[];
			while ($row = mysqli_fetch_assoc($result)) {
				$tomb[]="{$row['Termek_neve']};{$row['Ar']};{$row['Hleiras']};{$row['Kep']}";
				// EOL = \r vagy \r\n
			}
			echo implode("|",$tomb);
			return true;
			
        } else {
			echo mysqli_error($this->connect);	
			return false;
		}
	}
	function Hirdetes_torles($table,$ID,$valasztot_termek_neve)
	{
		$ID = $this->prepareData($ID);
		$table=$this->prepareData($table);
		$valasztot_termek_neve=$this->prepareData($valasztot_termek_neve);
		
		//Sql00
		
		$this->sqll ="SELECT  Elado_helyek_ID
						FROM hirdetes
						LEFT JOIN eladoi_helyek
						ON hirdetes.Elado_helyek_ID = eladoi_helyek.ID
						WHERE Elado_ID = '".$ID."' and Termek_neve = '".$valasztot_termek_neve."'"; 
		$eladoidja = mysqli_query($this->connect,$this->sqll);
		$rowid = mysqli_fetch_assoc($eladoidja);
		
		$this->sql = "DELETE FROM `eladoi_helyek` WHERE ID='".$rowid['Elado_helyek_ID']."'";
		
		$result=mysqli_query($this->connect, $this->sql);
		$eid = mysqli_insert_id($this->connect);

		$this->sqlll = "DELETE FROM `hirdetes` WHERE Elado_ID='".$ID."' and Termek_neve = '".$valasztot_termek_neve."'";
		//echo $this->sqlll;
		//exit;
        $result2=mysqli_query($this->connect, $this->sqlll);
		
		
		//$result = mysqli_query($this->connect, $this->sql);
        if (mysqli_affected_rows($this->connect) > 0)
		{
		return true;
		} else 
		{
		echo mysqli_error($this->connect);	
			return false;
		}
	}
	
	function Sajat_hirdetes_modositas($table,$ID,$Termek_neve,$Mennyiseg,$Hirdetes_vege,$Termek_ara,$Kep,$Termek_leiras,$Fizetesi_lehetoseg,$Iranyito_szam,$Telepules_neve,$Utca,$Haz_szam,$Mettol_veheto_at,$Meddig_veheto_at,$valasztot_termek_neve)
	{
		$ID = $this->prepareData($ID);
		$table=$this->prepareData($table);
		$Termek_neve=$this->prepareData($Termek_neve);
        $Hirdetes_vege = $this->prepareData($Hirdetes_vege);
		$Termek_leiras=$this->prepareData($Termek_leiras);
        $Termek_ara = $this->prepareData($Termek_ara);
		$Fizetesi_lehetoseg=$this->prepareData($Fizetesi_lehetoseg);
		$Mennyiseg=$this->prepareData($Mennyiseg);

        $Iranyito_szam = $this->prepareData($Iranyito_szam);
		$Telepules_neve=$this->prepareData($Telepules_neve);
        $Utca = $this->prepareData($Utca);
		$Haz_szam=$this->prepareData($Haz_szam);
        $Mettol_veheto_at = $this->prepareData($Mettol_veheto_at);
		$Meddig_veheto_at=$this->prepareData($Meddig_veheto_at);
		$valasztot_termek_neve=$this->prepareData($valasztot_termek_neve);
		
		//Sql00
		
		$this->sqll ="SELECT  Elado_helyek_ID
						FROM hirdetes
						LEFT JOIN eladoi_helyek
						ON hirdetes.Elado_helyek_ID = eladoi_helyek.ID
						WHERE Elado_ID = '".$ID."' and Termek_neve = '".$valasztot_termek_neve."'"; 
		$eladoidja = mysqli_query($this->connect,$this->sqll);
		$rowid = mysqli_fetch_assoc($eladoidja);
		
		$this->sql = "UPDATE `eladoi_helyek` SET `Iranyito_szam`='".$Iranyito_szam."',`Telepules`='".$Telepules_neve."',`Utca`='".$Utca."',`Haz_szam`='".$Haz_szam."',
		`Nyitas`='".$Mettol_veheto_at."',
		`Zaras`='".$Meddig_veheto_at."' 
		WHERE ID='".$rowid['Elado_helyek_ID']."'";
		
		$result=mysqli_query($this->connect, $this->sql);
		$eid = mysqli_insert_id($this->connect);

		//Sql01
		
		$this->sqlll = "UPDATE `hirdetes` SET `Termek_neve`='".$Termek_neve."',`Menyiseg`='".$Mennyiseg."',`Ajan_veg`='".$Hirdetes_vege."',`Ar`='".$Termek_ara."',`Kep`='". mysqli_real_escape_string($this->connect,$Kep)."',`Hleiras`='".$Termek_leiras."',`Fizetesi_mod`='".$Fizetesi_lehetoseg."' WHERE Elado_ID='".$ID."'";
		
        $result2=mysqli_query($this->connect, $this->sqlll);
		
		
		//$result = mysqli_query($this->connect, $this->sql);
        if (mysqli_affected_rows($this->connect) > 0)
		{

			return true;
			echo"Sikeres hirdetes modositas";

        } else 
		
		echo mysqli_error($this->connect);	
			return false;
	}

}


?>
