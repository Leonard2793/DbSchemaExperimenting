<?php

/* Verbindung zur Datenbank */
$server = 'localhost'; // 3307 = MariaDB, 3306 oder keine Angabe = MySQL
$user = 'root';
$pwd = 'root';

try 
{
    $con = new PDO("mysql:host=$server", $user, $pwd);

    // Exception-Handling für PDO muss explizit eingeschaltet werden:
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} 
catch(Exception $e) 
{
    echo 'Error - Verbindung: '.$e->getCode().': '.$e->getMessage().'<br>';
}   