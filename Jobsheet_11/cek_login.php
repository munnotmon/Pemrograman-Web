<?php
// Memulai atau melanjutkan sesi jika belum dimulai
if (session_status() == PHP_SESSION_NONE)
    session_start();

// Memuat file koneksi ke database
include 'config/koneksi.php';
include 'fungsi/pesan_kilat.php';

// Fungsi anti_injection tidak lagi diperlukan jika menggunakan prepared statements
// include 'fungsi/anti_injection.php'; 

// Pastikan variabel $koneksi adalah objek koneksi PostgreSQL yang valid
if (!isset($koneksi) || !$koneksi) {
    pesan('danger', "Koneksi database PostgreSQL gagal.");
    header("location:login.php");
    die();
}

// Mendapatkan nilai dari input username dan password
$username = $_POST['username'];
$password = $_POST['password'];

// Membuat query untuk mendapatkan informasi pengguna (Gunakan $1 sebagai placeholder)
$query = "SELECT username, level, salt, password as hashed_password FROM \"user\" WHERE username=$1";

// Eksekusi query menggunakan pg_query_params untuk keamanan
$result = pg_query_params($koneksi, $query, [$username]);

// Memeriksa apakah query berhasil
if (!$result) {
    pesan('danger', "Query database gagal: " . pg_last_error($koneksi));
    header("location:login.php");
    die();
}

// Mengambil baris hasil query
$row = pg_fetch_assoc($result);

// (Koneksi bisa ditutup nanti di akhir skrip jika diperlukan)
// pg_close($koneksi); 

$salt = $row['salt'] ?? null;
$hashed_password = $row['hashed_password'] ?? null;

// Memeriksa apakah salt dan hashed password tidak null (username ditemukan)
if ($salt !== null && $hashed_password !== null) {
    $combined_password = $salt . $password;
    
    if (password_verify($combined_password, $hashed_password)) {
        $_SESSION['username'] = $row['username'];
        $_SESSION['level'] = $row['level'];
        header("location:index.php");
    } else {
        pesan('danger', "Login gagal. Password Anda Salah.");
        header("location:login.php");
    }
} else {
    pesan('warning', "Username tidak ditemukan.");
    header("location:login.php");
}

die();
?>