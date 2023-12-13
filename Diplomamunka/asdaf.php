<?php
<div class="rendeloiadatok">
                        <div class="rendelolabel">	<label >Felhasználó név: </label></div>
                    <div class="irasoseng">	<input  type="text" placeholder="AkftEnVagyok" name="felhasznalonev" ></div>
					</div>
					<div class="rendeloiadatok">
						<label class="rendelolabel">Email cim: </label>
						<input class="irasoseng" type="text" placeholder="Berenyi@kft.hu" name="emailcim" >
					</div>
					<div class="rendeloiadatok">
						<label class="rendelolabel">Cég neve: </label>
						<input class="irasoseng" type="text" placeholder="Berényi Kft" name="rendelocegneve" >
					</div>
					<div class="rendeloiadatok">
						<label class="rendelolabel">Jelszava 1: </label>
						<input class="irasoseng" type="password" placeholder="Berényi" name="jelszava1" >
					</div>
					<div class="rendeloiadatok">
						<label class="rendelolabel">Jelszava 2: </label>
						<input class="irasoseng" type="password" placeholder="Berényi" name="jelszava2" >
					</div>
					<div class="rendeloiadatok">
						<?php echo $error; ?>
						<input id="regisztGomb" type="submit" name="regisztG" value="Regisztráció" >
					</div>