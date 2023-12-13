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
        $this->adatbazis = 'mat_data';

    }
}

?>
