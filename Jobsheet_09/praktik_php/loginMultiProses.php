<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// koneksi ke PostgreSQL
include "db_connect.php"; // pastikan file ini berisi variabel $conn hasil pg_connect()

$username = $_POST['username'] ?? '';
$password = md5($_POST['password'] ?? '');

if (empty($username) || empty($password)) {
    die("Harap isi username dan password terlebih dahulu!");
}

// Query untuk cari user
$query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
$result = pg_query($conn, $query);

if (!$result) {
    die("Query gagal: " . pg_last_error($conn));
}

$row = pg_fetch_assoc($result);

if ($row) {
    if ($row['level'] == 1) {
        echo "<h3>Anda berhasil login sebagai <b>Admin</b>.</h3>";
        echo "<a href='homeAdmin.html'>Halaman HOME Admin</a>";
    } elseif ($row['level'] == 2) {
        echo "<h3>Anda berhasil login sebagai <b>Guest</b>.</h3>";
        echo "<a href='homeGuest.html'>Halaman HOME Guest</a>";
    } else {
        echo "<h3>Level pengguna tidak dikenali!</h3>";
    }
} else {
    echo "<h3>Login gagal! Username atau password salah.</h3>";
    echo "<a href='loginForm.html'>Coba lagi</a>";
}

pg_free_result($result);
pg_close($conn);
?>