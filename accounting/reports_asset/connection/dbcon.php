<?php
try {
    $pdoConnect = new PDO("mysql:host=localhost;dbname=finance_dept","root","");

    $pdoConnect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
}
catch (PDOException $exc){
    echo $exc->getMessage();
}
?>