<?php
$host = 'sql309.infinityfree.com';         // or your remote DB host
$db   = 'if0_39038783_bm_manager'; // your database name
$user = 'if0_39038783';              // your DB username (default for XAMPP is 'root')
$pass = 'VQeVbshDgezYW';                  // your DB password (default for XAMPP is usually empty)
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
