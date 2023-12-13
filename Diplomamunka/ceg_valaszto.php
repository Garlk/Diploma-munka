<?php
session_start();

// bevan e lépve
if (!isset($_SESSION['loggedin'])) {
    header('Location: index.php');
    exit;
}elseif($_SESSION['Belepet']['tipus']!=2){
    header('Location: index.php?status=error&msg=Aktivitás hiánya miatt az oldal kiléptette');
}

//echo $_SESSION['Belepet']['tipus']."   ".$_SESSION['name'];
include('php/teszt.ini.php');
unset($_SESSION['tarsasvallalkozas'],$_SESSION['egyenivallalkozas'],$_SESSION['hiba']);

include('php/ceg_valaszto.ini.php')
 ?>
<!DOCTYPE html>
<html lang="hu" dir="ltr">
<head>
<meta charset= "utf-8"> 
<title> KM compny selection</title>
<link rel="stylesheet" href="css/cegvcss.css">
</head>
<body>
 
<div id="center">
		<div id="kgombok">
			<form action="ceg_valaszto.php" method="post">
				<input name="kilepesG" type="submit" value="Kilépés">
			</form>
		</div>

		<div id="ucgombok">
			<form action="ceg_valaszto.php" method="post">
                <?php
                if(isset($_SESSION['hiba'])){
                    ?>
                    <div  id="alert" role="alert">
                        <strong style='color':red;>Hiba:<?php echo $_SESSION['hiba'];?> </strong>
                    </div>
                    <?php
                    unset($_SESSION['hiba']);
                }else{
                    echo"<b>Új cég</b>";
                }
                ?>

                <br>
                <input type="submit" name="ujcegG" value="Cég felvétele">

			</form>
		</div>
		
		<table id="ceg_valaszto">
		<tr>
		<th>
			<div class="vgombok"> 
				<form action="ceg_valaszto.php" method="post">
					<label>Egyéni vállalkozók</label>
					<select name="egyenivallal" class="Tars_valalk">

					<?php
						$userCheck = "SELECT `Ceg_cegnev` FROM `cegadatok` WHERE Ceg_tipusa = 'egyeni_val' and `Ceg_letrehozo` = '" .$_SESSION['name']."' ";
						$result = mysqli_query($db->dbConnect(), $userCheck);
                    if(mysqli_num_rows( mysqli_query( $db->dbConnect(), $userCheck ))) {
                        echo "<option value='Nincs_ceg'>Válasz</option> ";
                        while ($row = mysqli_fetch_row($result)) {
                            echo "<option value='" . $row[0] . "'>" . $row[0] . "</option> ";
                        }
                    }else {
                        echo "<option value='Nincs_ceg'>nincs cég</option> ";
                    }

					?>
					</select>

					<input type="submit" name="egyenivallalG" value="Cég választása">
		        </form>
				
				
				
			</div>
			</th>
			<th>
			<div class="vgombok">

				<form action="ceg_valaszto.php" method="post">
					<label>Társas vállalkozások</label>
					<select name="tarsvallal" class="Tars_valalk"  >
					<?php
					$userCheck = "SELECT `Ceg_cegnev` FROM `cegadatok` WHERE (Ceg_tipusa = 'tarsas_valKft' or Ceg_tipusa = 'tarsas_valBt') and `Ceg_letrehozo` = '".$_SESSION['name']."'  ";
					$result = mysqli_query($db->dbConnect(), $userCheck);
                    if(mysqli_num_rows( mysqli_query( $db->dbConnect(), $userCheck ))) {
                       echo "<option value='Nincs_ceg'>Válasz</option> ";
                       while($row = mysqli_fetch_row($result)) {
                           echo "<option value='" . $row[0] . "'>" . $row[0] . "</option> ";
                       }
                    }else {
                        echo "<option value='Nincs_ceg'>nincs cég</option> ";
                    }
				   ?>
					</select>

					<input type="submit" name="tarsvallalG" value="Cég választása">

				</form>
				<th>
			</div>
		</tr>
		</table>

		
 </div>

</body>
</html>