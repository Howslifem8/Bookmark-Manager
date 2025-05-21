<?php
$host = 'sql309.infinityfree.com';         // DB host
$db   = 'if0_39038783_bm_manager'; // database name
$user = 'if0_39038783';              // DB username (default for XAMPP is 'root')
$pass = 'VQeVbshDgezYW';                  // DB password 
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,  // throw exceptions on errors
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,        // return rows as associative arrays
    PDO::ATTR_EMULATE_PREPARES   => false,                   // use native prepared statements
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    die('Database connection failed: ' . $e->getMessage());
}
?>
