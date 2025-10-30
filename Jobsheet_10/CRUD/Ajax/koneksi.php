<?php
define('HOST', 'localhost');
define('USER', 'postgres');
define('PASS', '12345678'); // ganti sesuai password PostgreSQL kamu
define('DB1', 'prakwebdb');

try {
    $db1 = new PDO("pgsql:host=". HOST . ";dbname=". DB1, USER, PASS);
    $db1->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi database gagal: ". $e->getMessage());
}
?>