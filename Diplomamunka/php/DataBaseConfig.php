<?php

class DataBaseConfig
{
    public $szervernev;
    public $usernev;
    public $jelszo;
    public $adatbazis;
	public function __construct()
    {
        $this->szervernev = 'localhost';
        $this->usernev = 'Mester01';
        $this->jelszo = '123456';
        $this->adatbazis = 'matszerv_fajlmegoszto_data';
	}
/*
    public function __construct()
    {

        $this->szervernev = '185.51.188.55';
        $this->usernev = 'matszerv_Mester01';
        $this->jelszo = '159753Zsolt357951';
        $this->adatbazis = 'matszerv_fajlmegoszto_data';

    }
    //Kapcsolódási gond estére
    $pdo = new PDO("mysql:host=".DBHOST.";dbname=".DBNAME, DBUSER, DBPASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Ha kapcsolódási gond van le álít és ki írja a hibát
    catch( PDOException $exception ) {
    echo "Connection error :" . $exception->getMessage();
}
     // If there is an error with the connection, stop the script and display the error.
    catch( PDOException $exception ) {
    echo "Connection error :" . $exception->getMessage();


További tehendőim

Admin jelszavának modosítás
    Le kell ellenőrizni hogy helyesen működik e a felhasználóknál
        update el kell hogy müködjün

A cégek által felvett felhasználóknak új jelszót tudjon megadni a felhasználó
    Ez az all cégeknek legyen lehetséges
        Ez egy Update el fogom megoldani

Cégek törlése
    inaktívá tenni a felhasználót az allata lévő felhasználókall együtt
        új mező felvétele az adatbázisban a cégek és a felhasználóktáblánál

    minden szinten meg kell írni a cég törését

Új ellenőrzést bele kell tenni
    időzítősen ellenőrizni hogy be van e lépve a felhasználó
       kiléptettni hogy ha egy ideig nem volt aktivitás az oldalon



*/
}

?>
