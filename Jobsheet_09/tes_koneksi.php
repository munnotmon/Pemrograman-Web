<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = 'localhost';
$port = '5432';
$dbname = 'prakwebdb';
$user = 'postgres';
$pass = '12345678';

$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$pass");

if (!$conn) {
    die("❌ Koneksi gagal: " . pg_last_error());
} else {
    echo "✅ Koneksi PostgreSQL BERHASIL!";
}

pg_close($conn);
?>
