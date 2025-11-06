<?php
// Konfigurasi koneksi PostgreSQL
$host = "localhost";
$port = "5432";
$dbname = "prakwebdb";
$user = "postgres";
$password = "12345678";

// String koneksi
$koneksi = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

// Cek koneksi
if (!$koneksi) {
    // Menggunakan pg_last_error() untuk detail error
    die("Koneksi database gagal: " . pg_last_error());
}
?>