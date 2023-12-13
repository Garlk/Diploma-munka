<?php
$idozito = $_SESSION['Belepet']['lejarati_ido'];
$start = $_SESSION['Belepet']['start'];
if((time()-$start)> $idozito){
    unset($_SESSION['Belepet']['start']);
    unset($_SESSION['Belepet']['lejarati_ido']);
    unset($_SESSION['Belepet']['neve']);
    unset($_SESSION['Belepet']['tipus']);
    unset($_SESSION['Belepet']);

    header('Location: index.php?status=error&msg=Aktivitás hiánya miatt az oldal kiléptette');
}else{
    $_SESSION['Belepet']['start']=time();
}
if($_SESSION['Belepet']['tipus']==2){

}

?>