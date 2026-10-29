<?php
$host = 'sql200.byethost31.com';
$dbname = 'b31_43306810_moviemarker';
$user = 'b31_43306810';
$pass = 'Zild@09090808';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Sorry, we could not connect to the server. Please try again later.');
}
