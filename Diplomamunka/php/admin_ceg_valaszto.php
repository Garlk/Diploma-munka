<?php
require "DataBase.php";
$db = new DataBase();
$result = "";
$egyenivallalG = $_POST['egyenivallalG'];
$tarsvallalG = $_POST['tarsvallalG'];


if (isset($_POST['ujcegG'])) {
    header('Location: http://localhost/diploma2/regisztracios.php'); /*Fadnim felhasznalo*/
}

if (isset($_POST['egyenivallalG'])) {

    $userCheck = "SELECT `Ceg_cegnev` FROM `cegadatok` WHERE Ceg_tipusa = 'egyeni_val' ";
    $result = mysqli_query($db->dbConnect(), $userCheck);
}

if (isset($_POST['tarsvallalG'])) {

    $userCheck = "SELECT `Ceg_cegnev` FROM `cegadatok` WHERE Ceg_tipusa = 'egyeni_val' ";
    $result = mysqli_query($db->dbConnect(), $userCheck);
}





/*
        $userCheck = "SELECT `Ceg_cegnev` FROM `cegadatok` WHERE Ceg_tipusa = 'egyeni_val' ";
        $result = mysqli_query($db->dbConnect(), $userCheck);

       while($row = mysqli_fetch_row($result)) {
           echo "<option value='" . $row[0] . "'>" . $row[0] . "</option> ";
       }
*/
?>