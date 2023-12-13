<?php
require "DataBase.php";
$db = new DataBase();
$result = "";


        $userCheck = "SELECT `Ceg_cegnev` FROM `cegadatok` WHERE Ceg_tipusa = 'egyeni_val' ";
        $result = mysqli_query($db->dbConnect(), $userCheck);
        for ($i = 0; $i < $result.length; $i++)
            {
            echo "<option value='ceg".$i."'>".$result[i]."</option>";
            }


if(isset($_SESSION['user']['loggedin_time']) and isset($_SESSION['user']['id'])){
    if(((time() - $_SESSION['user']['loggedin_time']) > $session_duration)){
        return true;
    }


    $userCheck = "SELECT `Ceg_cegnev`  FROM `cegadatok` WHERE Ceg_tipusa = 'tarsas_val' ";
		$result = mysqli_query($db->dbConnect(), $userCheck )

?>