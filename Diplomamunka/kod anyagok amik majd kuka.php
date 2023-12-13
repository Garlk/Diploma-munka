<?php

// Az alapmappa, ahol a fájlok el lesznek különítve
$uploadDir = 'uploads/';

// Ellenőrizzük, hogy a feltöltött fájl létezik-e és nem hiba történt-e
if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
    // Az eredeti fájlnév
    $originalFileName = $_FILES['file']['name'];

    // Az útvonal, ahova a fájlt szeretnénk feltölteni (elkülönítve mappákba)
    $targetDir = $uploadDir . generateUniqueDirectory() . '/';

    // Ellenőrizzük, hogy a célkönyvtár létezik-e, és ha nem, akkor létrehozzuk
    if (!file_exists($targetDir)) {
        mkdir($targetDir, 0755, true);
    }

    // Az útvonal és fájlnév, ahova a fájlt menteni szeretnénk
    $targetFilePath = $targetDir . $originalFileName;

    // Mozgatjuk a feltöltött fájlt az új helyre
    if (move_uploaded_file($_FILES['file']['tmp_name'], $targetFilePath)) {
        echo "A fájl sikeresen feltöltve: " . $targetFilePath;
    } else {
        echo "Hiba történt a fájl feltöltése során.";
    }
}

// Egyedi mappa nevet generál
function generateUniqueDirectory()
{
    $uniqueId = uniqid();
    return date('Y/m/') . $uniqueId;
}
//-----------------------------------------------------------------------------------------------

$uploadDir = 'uploads/';

if (isset($_FILES['file'])) {
    $fileCount = count($_FILES['file']['name']);

    for ($i = 0; $i < $fileCount; $i++) {
        $originalFileName = $_FILES['file']['name'][$i];
        $targetDir = $uploadDir . generateUniqueDirectory() . '/';
        $targetFilePath = $targetDir . $originalFileName;

        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0755, true);
        }

        if (move_uploaded_file($_FILES['file']['tmp_name'][$i], $targetFilePath)) {
            echo "A fájl sikeresen feltöltve: " . $targetFilePath . "<br>";
        } else {
            echo "Hiba történt a(z) " . $originalFileName . " fájl feltöltése során.<br>";
        }
    }
}

function generateUniqueDirectory()
{
    $uniqueId = uniqid();
    return date('Y/m/') . $uniqueId;
}

<script type="text/javascript">
  // JavaScript kód
</script>

<?php
// További PHP kód
?>

function openPopup() {
  var popup = document.getElementById('popup');
  var popupContent = document.getElementById('popup-content');

  // Hibaüzenetek
  var errorMessages = <?php echo json_encode($_SESSION['error_messages']); ?>;

  // Ellenőrizd, hogy van-e hibaüzenet
  if (errorMessages && errorMessages.length > 0) {
    var content = "";

    for (var i = 0; i < errorMessages.length; i++) {
      content += "<p>" + errorMessages[i] + "</p>";
    }

    popupContent.innerHTML = content;
    popup.style.display = "block";
  }
}

function closePopup() {
  var popup = document.getElementById('popup');
  popup.style.display = "none";
}
A fenti kódban a openPopup() függvényben a $_SESSION['error_messages'] változót hozzáférhetővé tesszük a Javascript kódban az echo függvénnyel. Az json_encode() függvény segítségével az error_messages tömb tartalmát JSON formátumban kódoljuk.

Ezután az errorMessages változóban tároljuk a PHP-ből érkező hibaüzeneteket. Ha az errorMessages tömb létezik és van tartalma, akkor a hibaüzeneteket beillesztjük a popup ablakba és megjelenítjük azt. Ha az errorMessages üres vagy nem létezik, akkor a popup ablak nem jelenik meg.

Fontos megjegyezni, hogy a fenti kód csak akkor működik helyesen, ha a PHP és a Javascript része egy PHP fájlban található. Ha a Javascript részt külön fájlban kívánod használni, akkor az adatátvitelt más módon kell megoldanod, például az AJAX technológia segítségével.
tartalom, javasolnám a következő megközelítést:

HTML kód:

html

<button onclick="openPopup()">Hibaüzenet megjelenítése</button>

<div id="popup" class="popup">
  <span onclick="closePopup()" class="close-button">&times;</span>
  <div id="popup-content"></div>
</div>

CSS kód:

css

.popup {
  display: none;
  position: fixed;
  z-index: 9999;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
}

.popup-content {
  background-color: #fff;
  max-width: 400px;
  margin: 50px auto;
  padding: 20px;
  border-radius: 5px;
  text-align: center;
}

.close-button {
  position: absolute;
  top: 10px;
  right: 10px;
  font-size: 20px;
  cursor: pointer;
}

Javascript kód:

javascript

function openPopup() {
  var popup = document.getElementById('popup');
  var popupContent = document.getElementById('popup-content');

  // Hibaüzenetek
  var errorMessages = ["Hibaüzenet 1", "Hibaüzenet 2", "Hibaüzenet 3"];

  // Hibaüzenetek megjelenítése a popup ablakban
  if (errorMessages.length > 0) {
    var content = "";

    for (var i = 0; i < errorMessages.length; i++) {
      content += "<p>" + errorMessages[i] + "</p>";
    }

    popupContent.innerHTML = content;
    popup.style.display = "block";
  }
}

function closePopup() {
  var popup = document.getElementById('popup');
  popup.style.display = "none";
}

A fenti kódban egy gombra kattintva megjelenik a popup ablak, ha vannak hibaüzenetek (errorMessages tömbben vannak tárolva). A popup ablakban az összes hibaüzenet megjelenik, vagyis a tömb elemeit beillesztjük a popup-content div-be. Ha a hibaüzenetek üresek, akkor a popup ablak nem jelenik meg.

A "Hibaüzenet megjelenítése" gombra kattintva a openPopup() függvény fut le, ami beállítja a popup tartalmát és megjeleníti a popup ablakot. A "Bezárás" ikonra kattintva pedig a closePopup() függvény fut le, ami elrejti a popup ablakot.

A CSS kód segítségével megadhatod a popup ablak megjelenését, a háttérszínt, a méreteket és a stílust.



<?php
function deleteDirectory($dir) {
    if (!is_dir($dir)) {
        throw new InvalidArgumentException("$dir nem egy mappa.");
    }

    $files = array_diff(scandir($dir), array('.', '..'));

    foreach ($files as $file) {
        $path = $dir . '/' . $file;
        if (is_dir($path)) {
            deleteDirectory($path);
        } else {
            unlink($path);
        }
    }

    rmdir($dir);
}

// Mappa törlése név alapján
$targetDir = '/elérési/útvonal/a/mappához';
deleteDirectory($targetDir);



/**Admin törlési részből ki vet kód**/


		$userCheck = "SELECT fajladatok.Fajl_szerverneve, fajladatok.Fajl_helye
						FROM fajladatok
						INNER JOIN cegadatok
						ON cegadatok.Ceg_cegnev  = fajladatok.Fajl_tulaj
						WHERE cegadatok.Ceg_letrehozo='" . $felhasznalonev . "' "; /*fájl helyek törlése*/
		$result = mysqli_query($this->dbConnect(), $userCheck);
		if (mysqli_num_rows(mysqli_query($this->dbConnect(), $userCheck))) {
			while ($row = mysqli_fetch_row($result)) {

				$file_name = $row[0];
				$location_with_image_name = $row[1];
				if (file_exists($location_with_image_name)) {
					$delete = unlink($location_with_image_name);
					if ($delete) {
						//echo "delete success";
					} else {
						//echo "delete not success";
					}
				}
			}
		}
		$userCheck = "SELECT `Ceg_cegnev` FROM `cegadatok` WHERE `Ceg_letrehozo`'" . $felhasznalonev . "' ";
		$result = mysqli_query($this->dbConnect(), $userCheck);
		if (mysqli_num_rows(mysqli_query($this->dbConnect(), $userCheck))) {   /*fajl adatok törlése*/
			while ($row = mysqli_fetch_row($result)) {

				$this->sql = "DELETE FROM `fajladatok` WHERE `Fajl_tulaj`='" . $row[0] . "'";
				mysqli_query($this->connect, $this->sql);
				if (mysqli_affected_rows($this->connect) > 0) {
					return true;
				} else {
					echo mysqli_error($this->connect);
					return false;
				}
			}
		}
		$userCheck = "SELECT `Felhasznalo_ceg` FROM `felhasznalok` WHERE `Felhasznalo_letrehozo`='" . $felhasznalonev . "' ";
		$result = mysqli_query($this->dbConnect(), $userCheck);
		if (mysqli_num_rows(mysqli_query($this->dbConnect(), $userCheck))) {            /*felhasználó cégek+ cégek törlése*/
			while ($row = mysqli_fetch_row($result)) {
				$this->sql1 = "DELETE FROM  `felhasznalok` WHERE ` Felhasznalo_ceg  ` ='" . $row[0] . "'";
				mysqli_query($this->connect, $this->sql1);
				if (mysqli_affected_rows($this->connect) > 0) {
					return true;
				} else {
					echo mysqli_error($this->connect);
					return false;
				}
				$this->sql = "DELETE FROM  `cegadatok` WHERE ` Ceg_letrehozo ` ='" . $row[0] . "'";
				mysqli_query($this->connect, $this->sql);
				if (mysqli_affected_rows($this->connect) > 0) {
					return true;
				} else {
					echo mysqli_error($this->connect);
					return false;
				}
			}
		}
		$this->sql2 = "DELETE FROM `felhasznalok` WHERE  `Felhasznalo_nev`= '" . $felhasznalonev . "'";  /*Admin tölése*/
		mysqli_query($this->connect, $this->sql2);
		if (mysqli_affected_rows($this->connect) > 0) {
			return true;
		} else {
			echo mysqli_error($this->connect);
			return false;
		}

        Az alábbiakban bemutatok néhány példát a MySQL injection elleni védelemre a korábban megadott változók esetén. Az adatbázisból történő adatlekérdezéseknél az alábbi technikákat használhatod:

    Prepared Statements (Előkészített utasítások): A prepared statementek lehetővé teszik a lekérdezések paraméterezését, így a felhasználói bemenetet biztonságosan beillesztheted a lekérdezésbe.

php

$stmt = $db->prepare("SELECT * FROM tablename WHERE column1 = ? AND column2 = ?");
$stmt->bind_param("ss", $variable1, $variable2);
$stmt->execute();

    Escape String (Karakterek átalakítása): Az mysqli_real_escape_string függvénnyel megelőzheted a speciális karakterek (pl. idézőjelek) értelmezését.

php

$cegneve = mysqli_real_escape_string($db->dbConnect(), $cegneve);

    Input Validáció: Ellenőrizd és szűrd le a felhasználói bemenetet az elvárt formátum szerint. Például, ha egy adatnak számnak kell lennie, használj számvizsgálatot, vagy ha egy adatnak email címnek kell lennie, használj email cím ellenőrzést.

php

if (is_numeric($cegjegyzekszam)) {
    // Megfelelő formátumú cégjegyzékszám
} else {
    // Érvénytelen formátumú cégjegyzékszám
}

if (filter_var($emailcim, FILTER_VALIDATE_EMAIL)) {
    // Érvényes email cím
} else {
    // Érvénytelen email cím
}

Fontos megjegyezni, hogy ezek csak néhány példa az SQL injection elleni védelemre. Mindig legyen gondosan ellenőrizd és szűrd le a felhasználói bemenetet, valamint használj más védelmi mechanizmusokat, például jogosultságkezelést és adatbázis konfigurációs beállításokat a biztonságosabb alkalmazás fejlesztése érdekében.

