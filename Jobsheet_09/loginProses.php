<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Pastikan koneksi berhasil diload
require_once "koneksi.php";

if (!$conn) {
    die(" Koneksi database belum terbentuk.");
}

// Ambil data dari form
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';
$password_md5 = md5($password);

// Query untuk cek login
$query = "SELECT * FROM users WHERE username = '$username' AND password = '$password_md5'";
$result = pg_query($conn, $query);

if (!$result) {
    die(" Query gagal: " . pg_last_error($conn));
}

$cek = pg_num_rows($result);

if ($cek > 0) {
    echo "<h3>Anda berhasil login!</h3>";
    echo "Silakan menuju <a href='homeAdmin.php'>Halaman HOME</a>";
} else {
    echo "<h3> Login gagal!</h3>";
    echo "Silakan <a href='loginForm.php'>coba lagi</a>";
}

pg_free_result($result);
pg_close($conn);
?>
