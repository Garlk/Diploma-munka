<?php
$userCheck = "SELECT `ID`,`Felhasznalo_ceg`,`Felhasznalo_nev` FROM `felhasznalok` WHERE `Felhasznalo_letrehozo`='".$_SESSION['name']."' ";
$result = mysqli_query($db->dbConnect(), $userCheck);
if(mysqli_num_rows( mysqli_query( $db->dbConnect(), $userCheck ))) {
    while ($row = mysqli_fetch_row($result)) {
        echo "
                             		<tr class='Elemek'>
                             		<!--<td></td> -->
                                    <td>" . $row[1] . "</td>
                                    <td>" . $row[2] . "</td>
                                    <td><input type='password' placeholder='Új jelszó' name='ujjelszo".$row[0]."' ></td>
                                    <td><input type='submit' value='Új jelszó beállitása'  name='uj_jelszoG".$row[0]. "'></td>
                                    <td><input type='submit' value='Törlés' name='torlesadminG".$row[0]."'></td>
                                    </tr>";

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Ellenőrizd, hogy van-e eredmény a POST adatokban
            if (isset($_POST['eredmeny'])) {
                $eredmeny = $_POST['eredmeny'];

                // Ellenőrizd, hogy a szám megadása sikeres volt
                if (eredmeny === 'Modosítás végre halytásra kerül') {
                    echo "Siker";
                }
            }
        }


        $megerosito=0;
        if (isset($_POST['uj_jelszogG'.$row[0]])) {
            echo "elet küldve";
            if (($_POST['uj_jelszogG'.$row[0]])=== ""){
                echo "<script>alert('Hjelszó nem lehet üres')</script> ";
            }

            if (isset($_POST['ujjelszo' . $row[0]], $row[2])) {
                $Ujjelszohash = password_hash($_POST['ujjelszo' . $row[0]], PASSWORD_DEFAULT);
                if ($db->dbConnect()) {
                    $adminjelszo = $db->AdminJelszoModositas("falhasznalok", $row[0], $Ujjelszohash, $row[2] );
                    /*tábla          ID            ujjelszo        felhasznalonev */
                    if ($adminjelszo) {
                        echo $adminjelszo;
                        //header('Location: http://localhost/diploma2/admin_regisztraciosz.php');
                    } else {
                        echo "<script>alert('Hiba történt adat modosításkór')</script> ";
                        //echo $row[0]." ~ ". $_POST['ujjelszo'.$row[0]]." ~ ". $row[2] ." ~ "."sor elem" ."<br>";
                    }
                } else {
                    echo "<script>alert('Adatbázis hiba')</script> ";
                }
            } else {
                $_SESSION['Hiba']="Üres az új jelszó mezők valamelyike";
                echo "<script>alert('Üres az új jelszó mezők valamelyike ')</script> ";
            }
        }

        if (isset($_POST['torlesadminG' . $row[0]])) {
            if (isset($_POST['ujjelszo' . $row[0]], $row[2])) {
//CSak a cég státuszát kell át állítani inaktívra
            } else {
                echo "<script>alert('Üres az új jelszó mező ')</script> ";
            }
        }
    }
}else {
    echo"
		            <tr class='Elemek'>
					<td>Berényi Kft</td>
					<td>AkftEnVagyok</td>
					<td><input type='password' placeholder='Új jelszó' name='ujjelszo' ></td>
					<td><input type='submit' value='Új jelszó beállitása' name='minta1'></td>
                    <td><input type='submit' value='Törlés' name='minta' ></td>
					</tr>";
}
?>