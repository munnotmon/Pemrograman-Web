<?php
session_start();
include "db_connect.php"; // pastikan ini file koneksi

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']);

    // Ganti $connect jadi $conn
    $query = 'SELECT * FROM "users" WHERE username=$1 AND password=$2';
    $result = pg_query_params($conn, $query, array($username, $password));

    if (!$result) {
        die("❌ Query gagal: " . pg_last_error($conn));
    }

    $cek = pg_num_rows($result);

    if($cek > 0){
        $_SESSION['username'] = $username;
        $_SESSION['status'] = 'login';
        echo "✅ Anda berhasil login, silakan menuju <a href='homeSession.php'>Halaman Home</a>";
    } else {
        echo "❌ Username atau password salah, silakan <a href='sessionLoginForm.html'>Login lagi</a>";
    }
} else {
    echo "⚠️ Form belum diisi. <a href='sessionLoginForm.html'>Kembali</a>";
}
?>
