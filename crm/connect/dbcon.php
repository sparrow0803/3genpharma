<?php
try {
    $pdoConnect=new PDO("mysql:host=localhost;dbname=crm","root","");
    $pdoConnect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $exc){
    echo $exc->getMessage();
}
?>