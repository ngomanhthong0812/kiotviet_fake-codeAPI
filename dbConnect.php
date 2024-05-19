<?php
$host = 'mysql8010.site4now.net';
$dbname = 'db_aa8e67_kiotvi';
$username = 'aa8e67_kiotvi';
$password = 'gaycoffee123';

try {

    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
} catch (PDOException $pe) {
    die("Could not connect to the database $dbname :" . $pe->getMessage());
}
