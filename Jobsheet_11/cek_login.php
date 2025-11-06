<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include "config/koneksi.php";
include "fungsi/pesan_kilat.php";
// include "fungsi/anti_injection.php"; // <--- DIHAPUS

// Ambil langsung dari POST, tidak perlu 'antiinjection'
$username = $_POST['username'];
$password = $_POST['password'];

/* * Query diubah pakai $1 sebagai placeholder.
 * Nama tabel "user" (pakai kutip ganda) atau "users" (tergantung nama tabel bos).
 * Saya pakai "user" sesuai query create tabel kita sebelumnya.
 */
$query = "SELECT username, level, salt, password AS hashed_password FROM \"user\" WHERE username = $1";

/* * INI BAGIAN PENTING:
 * Pakai pg_query_params()
 * Ini otomatis mengamankan variabel $username. 100% aman dari SQL Injection.
 */
$result = pg_query_params($koneksi, $query, [$username]);
$row = pg_fetch_assoc($result);
pg_close($koneksi);

// Cek null pakai "==" atau "!==" (pastikan konsisten)
$salt = $row['salt'];
$hashed_password = $row['hashed_password'];

if ($salt !== null && $hashed_password !== null) {
    $combined_password = $salt . $password;

    if (password_verify($combined_password, $hashed_password)) {
        $_SESSION['username'] = $row['username'];
        $_SESSION['level'] = $row['level'];
        header("Location: index.php");
    } else {
        pesan('danger', "Login gagal. Password Anda Salah.");
        header("Location: login.php");
    }
} else {
    pesan('warning', "Username tidak ditemukan.");
    header("Location: login.php");
}
?>