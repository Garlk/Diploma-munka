<?php

session_start();
 include('php/index.ini.php');

?>
<!DOCTYPE html>
<html lang="hu" dir="ltr">
<head>
<meta charset= "utf-8"> 
<title> KM Login</title>

<link rel="stylesheet" href="css/cssfile.css">
</head>
<body>
	<div id="belepes_profil">
		<form action="index.php" method="post">
			 
			<div id="belepes_logo">

                <?php
                if(isset($_SESSION['udvozlet'])){
                    ?>
                    <div  id="alert" role="alert">
                        <strong style='color':red;>Sikeres belépés <?php echo $_SESSION['udvozlet'];?> </strong>
                    </div>
                    <?php
                    unset($_SESSION['udvozlet']);
                }else{
                    echo"<b>Bejelentkezés</b>";
                }
                ?>
			</div>

			<div id="center">
				<div class="beviteli_mezok" >
					<input type="text"  name="felhasznalonev" required>
					<span></span>
					<label>Felhasználónév</label>
				</div>
					
				<div class="beviteli_mezok" >
					<input  type="password" name="jelszo" required>
					<span></span>
					<label>Jelszó</label>
				</div>
				<div id="belepes_gomb">
				<input  type="submit" name="belepesG" value="Belépés">
                <br>

				</div>

		</form> 
				<br>
				<div id="login_checkbox">
				<label>
				<input id="adat_megtartas" type="checkbox" checked="checked" name="remember"> Bejelentkezve marad
				</label>
				</div>
			</div>

		</div>
</body>
</html>