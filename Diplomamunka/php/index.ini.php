<?php

require "DataBase.php";
$db = new DataBase();
$error="";
$html=file_get_contents("belepes.html");


if (isset($_POST['belepesG'])) {

	if (isset($_POST['felhasznalonev']) && isset($_POST['jelszo'])) {
        if (empty($_POST['felhasznalonev'])) {
            echo "<script>alert('Felhasznaló név nem lehet üres')</script> ";
        } else {
            $nev = $_POST['felhasznalonev'];
            if (empty($_POST['jelszo'])) {
                echo "<script>alert('Jelszó nem lehet üres')</script> ";
            } else{
                $jelsszo = $_POST['jelszo'];
                if (!preg_match("/^(?=.*[!'@#$;,%^&*-]).{8,16}$/", $nev)) {
                    if ($db->dbConnect()) {
                        $login = $db->logIn("felhasznalok", $_POST['felhasznalonev'], $_POST['jelszo']);
                        if ($login) {
                            $idozito = 600;
                            $_SESSION['Hiba'] = "";
                            if ($login == 3) {
                                $_SESSION['loggedin'] = TRUE;
                                $_SESSION['name'] = $_POST['felhasznalonev'];
                                $_SESSION['jelszohas'] = "sikeresen belépet a felhasználó";
                                $jogkor = 3;
                                $_SESSION['udvozlet'] = $_POST['felhasznalonev'];
                                $_SESSION['Belepet'] = array("start" => time(), "lejarati_ido" => $idozito, "neve" => $_SESSION['name'], "tipus" => $jogkor);
                                header("refresh: 2; url = admin_regisztracios.php");
                            } elseif ($login == 2) {
                                $_SESSION['loggedin'] = TRUE;
                                $_SESSION['name'] = $_POST['felhasznalonev'];
                                $_SESSION['jelszohas'] = "sikeresen belépet a felhasználó";
                                $jogkor = 2;
                                $_SESSION['udvozlet'] = $_POST['felhasznalonev'];
                                $_SESSION['Belepet'] = array("start" => time(), "lejarati_ido" => $idozito, "neve" => $_SESSION['name'], "tipus" => $jogkor);
                                header("refresh: 2; url = ceg_valaszto.php");
                            } elseif ($login == 1) {
                                $_SESSION['loggedin'] = TRUE;
                                $_SESSION['name'] = $_POST['felhasznalonev'];
                                $jogkor = 1;
                                $_SESSION['udvozlet'] = $_POST['felhasznalonev'];
                                $_SESSION['Belepet'] = array("start" => time(), "lejarati_ido" => $idozito, "neve" => $_SESSION['name'], "tipus" => $jogkor);
                                header("refresh: 2; url = ceg_adatok.php");
                            }
                        } else echo "<script>alert('Hibás felhasználó név vagy jelszó')</script>";
                    } else echo "<script>alert('Adatbázis kapcsolódási hiba')</script>";
                } else echo "<script>alert('Hibásan adta meg a felhasználó nevet')</script> ";
            }
        }
    }else echo "<script>alert('Hiba történt')</script> ";
}

/*
 * (?=.*[!@#$%^&*-])
 *
 * if(!preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{8,12}$/', $password)) {
    echo 'the password does not meet the requirements!';
}
Between start -> ^
And end -> $
of the string there has to be at least one number -> (?=.*\d)
and at least one letter -> (?=.*[A-Za-z])
and it has to be a number, a letter or one of the following: !@#$% -> [0-9A-Za-z!@#$%]
and there have to be 8-12 characters -> {8,12}
 *
 * if (!preg_match("/^(?=.*[0-9]).{8,12}$/", $jelsszo)
 *
 */