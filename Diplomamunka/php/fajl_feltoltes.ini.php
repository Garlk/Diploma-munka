<?php
require "DataBase.php";
$db = new DataBase();


if(isset($_POST['kepfeltotes'])) {


    if (!empty($_FILES['szamlamyfile']['name'])) {
        if (isset($_POST['kiszvbesz']) || isset($_POST['datum_ev0']) || isset($_POST['datum_ho0'])) {


            $meglevo_kiallito =$_POST['meglevo_kiallito'];
            $uj_kiallito =$_POST['szamlaujkiallito'];
            $szamla_ki_v_be =$_POST['kiszvbesz'];


            if(isset($_POST['kiallitojelzo'])){
                    $kiallito = $meglevo_kiallito;
                }else{
                    $kiallito = $uj_kiallito;
                }


            $datum_ev = $_POST['datum_ev0'];/**/
            $datum_ho = $_POST['datum_ho0'];/**/

            $file = $_FILES['szamlamyfile'];
            $fileTmpName = $_FILES['szamlamyfile']['tmp_name'];
            $fileSize = $_FILES['szamlamyfile']['size'];
            $fileName = $_FILES['szamlamyfile']['name'];

            $fileError = $_FILES['szamlamyfile']['error'];
            $filetype = $_FILES['szamlamyfile']['type'];

            $engedelyet = array('jpg', 'jpeg', 'png', 'pdf');
            if(isset($_SESSION['tarsasvallalkozas'])){
                $valalkozasneve = $_SESSION['tarsasvallalkozas'];
            }elseif(isset($_SESSION['egyenivallalkozas'])){
                $valalkozasneve = $_SESSION['egyenivallalkozas'];
            }elseif(isset($_SESSION['felhaszvallal'])){
                $valalkozasneve = $_SESSION['felhaszvallal'];
            }

            $fileExt = explode('.', $fileName);
            $fileActualExt = strtolower(end($fileExt));

            $engedelyet = array('jpg', 'jpeg', 'png', 'pdf');

            if (in_array($fileActualExt, $engedelyet)) {
                if ($fileError === 0) {
                    if ($fileSize < 150000) {
                        $minta="/^(?=.*[!@#$%^&*-])$/";
                        if (preg_match($minta, $fileName)){
                            echo"<script>alert('fájl neve tiltott extra karaktert tartalmaz')</script>";
                            exit();
                        }else {
                            $folderPath = "php/fileupload/".$valalkozasneve."/";
                            $permissions = 0755;
                            $recursive = true;

                            if (!file_exists($folderPath)) {
                                mkdir($folderPath, $permissions, $recursive);
                                echo "A mappa sikeresen létrejött!"."<br>".$folderPath;
                            } else {
                                echo "A mappa már létezik!";
                            }

                            $fileNamNew = uniqid('', true) . "." . $fileActualExt;
                            $fileCelHelye = $folderPath . $fileNamNew;

                        }

                        if (isset($fileName) && isset($datum_ho) && isset($datum_ev) && isset($szamla_ki_v_be) &&
                            isset($_SESSION['name']) && isset($valalkozasneve) && isset($fileCelHelye) && isset($fileNamNew)) {
                            if ($db->dbConnect()) {

                                $nevcsere = str_replace(' ', '-', $fileName); // Replaces all spaces with hyphens.
                                $nevcsere = preg_replace('/[^A-Za-z0-9\-]/', '', $nevcsere); // Removes special chars.

                                if ($db->Fajlok_feltoltese_szamla("fajladatok", $nevcsere, $datum_ho, $datum_ev, $szamla_ki_v_be,
                                    $_SESSION['name'], $valalkozasneve, $fileCelHelye, $fileNamNew, $kiallito)) {

                                    move_uploaded_file($fileTmpName, $fileCelHelye);

                                     header('Location: http://localhost/diploma2/fajl_megtekintes.php?uploadsikeres');
                                }
                            }
                        }

                    } else {
                        echo "A feltőltendő fájl túl nagy";
                    }
                } else {
                    echo "feltőltés közben hiba történt";
                }
            } else {
                echo "nem engedélyezett fájl tipust próbált feltőlteni" . $fileActualExt;
            }
        } else {
            echo "mezők nincsenek kitőltve";
        }
    }else
    {
        echo "Nem választott ki fájlt amit feltöltene";
    }
    /*--*-*-*-*-*-*-*-*-*-*-*-*banki számlák*-*-*-*-*-*-*-*-*-*-*-*--*/
    if (!empty($_FILES['bankimyfile']['name'])) {
        if (isset($_POST['bankszamla']) || isset($_POST['datum_ev1']) || isset($_POST['datum_ho1'])) {

            $szamla_v_szamlator = $_POST['szamla_v_szamlator'];/**/

            $datum_ev = $_POST['datum_ev1'];/**/
            $datum_ho = $_POST['datum_ho1'];/**/

            $file = $_FILES['bankimyfile'];
            $fileName = $_FILES['bankimyfile']['name'];

            $fileTmpName = $_FILES['bankimyfile']['tmp_name'];
            $fileSize = $_FILES['bankimyfile']['size'];
            $fileError = $_FILES['bankimyfile']['error'];
            $filetype = $_FILES['bankimyfile']['type'];

            $engedelyet = array('jpg', 'jpeg', 'png', 'pdf');
            if(isset($_SESSION['tarsasvallalkozas'])){
                $valalkozasneve = $_SESSION['tarsasvallalkozas'];
            }elseif(isset($_SESSION['egyenivallalkozas'])){
                $valalkozasneve = $_SESSION['egyenivallalkozas'];
            }elseif(isset($_SESSION['felhaszvallal'])){
                $valalkozasneve = $_SESSION['felhaszvallal'];
            }
            $fileExt = explode('.', $fileName);


            $fileActualExt = strtolower(end($fileExt));
            $engedelyet = array('jpg', 'jpeg', 'png', 'pdf');
            if (in_array($fileActualExt, $engedelyet)) {
                if ($fileError === 0) {
                    if ($fileSize < 150000) {
                        if (preg_match("/^(?=.*[!@'#$|;,%^&*-])$/", $fileName)) {
                            echo "<script>alert('fájl neve tiltott extra karaktert tartalmaz')</script>"; /*nem műkdöik */
                        }else {


                            $folderPath = "php/fileupload/".$valalkozasneve."/";
                            $permissions = 0755;
                            $recursive = true;

                            if (!file_exists($folderPath)) {
                                mkdir($folderPath, $permissions, $recursive);
                                echo "A mappa sikeresen létrejött!"."<br>".$folderPath;
                            } else {
                                echo "A mappa már létezik!";
                            }

                            $fileNamNew = uniqid('', true) . "." . $fileActualExt;
                            $fileCelHelye = $folderPath . $fileNamNew;

                        }
                        header('Location: http://localhost/diploma2/fajl_feltoltes.php?uploadsikeres');
                        if (isset($fileName) && isset($datum_ho) && isset($datum_ev) && isset($szamla_v_szamlator) &&
                            isset($_SESSION['name']) && isset($valalkozasneve) && isset($fileCelHelye) && isset($fileNamNew)) {
                            if ($db->dbConnect()) {

                                $nevcsere = str_replace(' ', '-', $fileName); // Replaces all spaces with hyphens.
                                $nevcsere = preg_replace('/[^A-Za-z0-9\-]/', '', $nevcsere); // Removes special chars.
                                if ($db->Fajlok_feltoltese_bank("fajladatok", $nevcsere, $datum_ho, $datum_ev, $szamla_v_szamlator,
                                    $_SESSION['name'], $valalkozasneve, $fileCelHelye, $fileNamNew)) {

                                    move_uploaded_file($fileTmpName, $fileCelHelye);
                                    header('Location: http://localhost/diploma2/fajl_megtekintes.php?uploadsikeres');
                                }
                            }
                        }
                    } else {
                        echo "A feltőltendő fájl túl nagy";
                    }
                } else {
                    echo "feltőltés közben hiba történt";
                }
            } else {
                echo "nem engedélyezett fájl tipust próbált feltőlteni" . $fileActualExt;
            }
            //}else{
            //   echo "mezők nincsenek kitőltve";
            // }
        }
    }
    /*--*-*-*-*-*-*-*-*-*-*-*egyéb fájlok-*-*-*-*-*-*-*-*-*-*-*-*-*--*/
    if (!empty($_FILES['egyebmyfile']['name'])) {
            //echo mysqli_error($db->dbConnect());
         if (isset($_POST['fajltipus']) || isset($_POST['datum_ev2']) || isset($_POST['datum_ho2'])) {


        $fajltipus_Egyebe = $_POST['fajltipusegyeb'];/**/


        $datum_ev = $_POST['datum_ev2'];/**/
        $datum_ho = $_POST['datum_ho2'];/**/

        $file = $_FILES['egyebmyfile'];

        $fileTmpName = $_FILES['egyebmyfile']['tmp_name'];
        $fileSize = $_FILES['egyebmyfile']['size'];
        $fileName = $_FILES['egyebmyfile']['name'];

        $fileError = $_FILES['egyebmyfile']['error'];
        $filetype = $_FILES['egyebmyfile']['type'];

        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));

        $engedelyet = array('jpg', 'jpeg', 'png', 'pdf');
             if(isset($_SESSION['tarsasvallalkozas'])){
                 $valalkozasneve = $_SESSION['tarsasvallalkozas'];
             }elseif(isset($_SESSION['egyenivallalkozas'])){
                 $valalkozasneve = $_SESSION['egyenivallalkozas'];
             }elseif(isset($_SESSION['felhaszvallal'])){
                 $valalkozasneve = $_SESSION['felhaszvallal'];
             }
        if (in_array($fileActualExt, $engedelyet)) {
            if ($fileError === 0) {
                if ($fileSize < 150000) {
                    if (preg_match("/^(?=.*[!@'#$|;,%^&*-])$/", $fileName)){
                        echo"<script>alert('fájl neve tiltott extra karaktert tartalmaz')</script>";
                    }else {
                        $folderPath = "php/fileupload/".$valalkozasneve."/";
                        $permissions = 0755;
                        $recursive = true;

                        if (!file_exists($folderPath)) {
                            mkdir($folderPath, $permissions, $recursive);
                            echo "A mappa sikeresen létrejött!"."<br>".$folderPath;
                        } else {
                            echo "A mappa már létezik!";
                        }

                        $fileNamNew = uniqid('', true) . "." . $fileActualExt;
                        $fileCelHelye = $folderPath . $fileNamNew;
                    }
                    if (isset($fileName) && isset($datum_ho) && isset($datum_ev) && isset($fajltipus_Egyebe) &&
                        isset($_SESSION['name']) && isset($valalkozasneve) && isset($fileCelHelye) && isset($fileNamNew)) {
                        if ($db->dbConnect()) {

                            $nevcsere = str_replace(' ', '-', $fileName); // Replaces all spaces with hyphens.
                            $nevcsere = preg_replace("/[\/\&;%,#\$]/", "_",  $nevcsere); // Removes special chars.
                            if ($db->Fajlok_feltoltese_egyeb("fajladatok", $nevcsere, $datum_ho, $datum_ev, $fajltipus_Egyebe,
                                $_SESSION['name'], $valalkozasneve, $fileCelHelye, $fileNamNew)) {

                                move_uploaded_file($fileTmpName, $fileCelHelye);
                                header('Location: http://localhost/diploma2/fajl_megtekintes.php?uploadsikeres');
                            }
                        }
                    }
                } else {
                    echo "A feltőltendő fájl túl nagy";
                }
            } else {
                echo "feltőltés közben hiba történt";
              }
        } else {
            echo "nem engedélyezett fájl tipust próbált feltőlteni" . $fileActualExt;
        }
        } else {
            echo "mezők nincsenek kitőltve";
        }
    }
}
if(isset($_POST['kilepesG'])) {
    session_start();
    session_unset();
    session_destroy();
// Redirect to the login page:
    header('Location: index.php');}
if(isset($_POST['viszalepes'])) {
    header('Location: fajl_megtekintes.php');
}

?>