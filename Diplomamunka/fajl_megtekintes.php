<?php
session_start();
// bevan e lépve

if (!isset($_SESSION['loggedin'])) {
header('Location: index.php');
exit;
}
include('php/fajl_megtekintes.ini.php')
?>
<!DOCTYPE html>
<html lang="hu" dir="ltr">
<head>
<meta charset= "utf-8"> 
<title> KM new company</title>
<link rel="stylesheet" href="css/fajfeltoltes.css">
<link rel="stylesheet" href="ceg_adatok.js">

</head>
<body>

<div id="centercg">


		<label id="focimcegnev">
		<?php
        if(isset($_SESSION['tarsasvallalkozas'])){
            $valalkozasneve = $_SESSION['tarsasvallalkozas'];
        }elseif(isset($_SESSION['egyenivallalkozas'])){
            $valalkozasneve = $_SESSION['egyenivallalkozas'];
        }elseif(isset($_SESSION['felhaszvallal'])){
            $valalkozasneve = $_SESSION['felhaszvallal'];
        }
        echo" $valalkozasneve "?>Cég feltőltött fájljai
		</label>
        <form action="fajl_megtekintes.php" method="post">
		<div id="kilepesG">
			<input type="submit" name="kilepesG" value="Kilépés" >
		</div>

		<table id="kitoltoresz">
		<tr>
		<th id="tabcim"><h1>Feltöltött fájlok</h1></th>
		</tr>
		<tr class="fajlcim">
		<th class="fajlcimek">Fájl neve</th>
		<th class="fajlcimek">Fájl típusa</th>
		<th class="fajlcimek">Fájl csoport</th>
		<th class="fajlcimek">Kiállító</th>
		<th class="fajlcimek">Vonatkozási időszak</th>
		<th class="fajlcimek">Feltöltési ideje</th>
		<th class="fajlcimek"></th>
		<th class="fajlcimek"></th>
		</tr>

            <?php

            $userCheck = "SELECT `ID`,`Fajl_nev`,`Fajl_egyeb_tipusok`,`Fajl_tipusa`,`Fajl_kiallito_ceg`,`Fajl_ervenyes_ho`,`Fajl_ervenyes_ev`,`Fajl_feltoltesi_ido`,`Fajl_helye`,`Fajl_szerverneve` FROM `fajladatok` WHERE `Fajl_tulaj`='".$valalkozasneve."' ";
            $result = mysqli_query($db->dbConnect(), $userCheck);
            if(mysqli_num_rows( mysqli_query( $db->dbConnect(), $userCheck ))) {
                while ($row = mysqli_fetch_row($result)) {

                    echo"
                             <tr class='fajlok'>
                            <td class='fajlnev'>".$row[0].".".$row[1]." </td>
                            <td class='kiterjesztes'>".$row[2]." </td>
                            <td class='fajlcsoport'>".$row[3]." </td>
                            <td class='kiallito'>".$row[4]." </td>
                            <td class='vonatkozasi_ido'>".$row[6]."/".$row[5]." </td>
                            <td class='feltoltesi_ido'>".$row[7]." </td>
                            <td class='LetoltesG'><input  type='submit'  name='letoltesG".$row[0]."' value='Letöltés'></td>
                            <td class='TorlesG'><input  type='submit' name='torlesG".$row[0]."' value='Törlés'></td>
                            </tr>";
                    $cegid=$row[0];
                    if(isset($_POST['torlesG'.$row[0]])){
                        if ($db->dbConnect()) {
                            if ($db->Fajlok_torles("cegadatok", $cegid,$valalkozasneve,$row[8],$row[9],$row[1]));{
                                header('Location: http://localhost/diploma2/fajl_megtekintes.php');
                            }
                        }
                    }
                    if(isset($_POST['letoltesG'.$row[0]])){

                        //  $file = urldecode($_REQUEST["file"]);//  Decode URL-encoded string


                                if ($db->dbConnect()) {
                                    $filename = $row[9];



                                    $filepath = ("php/fileupload/".$valalkozasneve."/"). $filename;

                                    if (!empty($filename) && file_exists($filepath)) {
                                        /*
                                                                        header("Cache-Control: public");
                                                                        header("Content-Description: File Transfer");
                                                                        header("Content-Disposition: attachment; filename=$filename");
                                                                        header("Content-Type: application/$fileActualExt");
                                                                        header("Content-Transfer-Encoding: binary");
                                        */
                                        header('Content-Description: File Transfer');
                                        header('Content-Type: application/octet-stream');
                                        header('Content-Disposition: attachment; filename="' .basename($filepath). '"');
                                        header('Content-Transfer-Encoding: binary');
                                        header('Expires: 0');
                                        header('Cache-Control: must-revalidate');
                                        header('Pragma: public');
                                        header('Content-Length: '.filesize($filepath));
                                        ob_clean();
                                        flush(); // Flush system output buffer
                                        ob_end_flush();
                                        readfile($filepath);
                                        header('Location: http://localhost/diploma2/fajl_megtekintes.php');
                                        die();


                                    } else {
                                        http_response_code(404);
                                        die();
                                    }
                                }


                    }

                }
            }else {
                echo"
                                       <tr class='fajlok'>
                                        <td class='fajlnev'> Nincs még fájl feltöltve</td>
                                        <td class='kiterjesztes'> </td>
                                        <td class='fajlcsoport'></td>
                                        <td class='kiallito'> </td>
                                        <td class='vonatkozasi_ido'> </td>
                                        <td class='feltoltesi_ido'> </td>
                                       <td class='LetoltesG'></td>
                                      <td class='TorlesG'></td>
                                        </tr>";
            }
            ?>
		</table>
        </form>


		<form id="fajlfetoltes" method="post">
		<h2>Fájl feltöltés</h2>
		<br>
		<input id="fajlfeltoltes" type="submit" name="fajl_feltoltesG" value="fájl feltöltés">
            <div id="viszalepesG">
                <input id="visszalepes" type="submit" name="viszalepes" value="Vissza" >
            </div>
		</form>
		<script src="cegadadok.js"></script>

</div>

</body>
</html>