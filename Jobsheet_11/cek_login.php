<?php
// Memulai atau melanjutkan sesi jika belum dimulai
if (session_status() == PHP_SESSION_NONE)
    session_start();

// Memuat file koneksi ke database (HARUS SUDAH BERUBAH KE POSTGRESQL) dan fungsi pesan kilat
include 'config/koneksi.php';
include 'fungsi/pesan_kilat.php';

// Memuat fungsi anti_injection untuk mencegah serangan SQL injection
// CATATAN: Fungsi ini harus dimodifikasi agar menggunakan fungsi ESCAPING POSTGRESQL (misal: pg_escape_string)
include 'fungsi/anti_injection.php';

// Pastikan variabel $koneksi adalah objek koneksi PostgreSQL yang valid
if (!isset($koneksi) || !$koneksi) {
    // Tangani error koneksi jika diperlukan
    pesan('danger', "Koneksi database PostgreSQL gagal.");
    header("location:login.php");
    die();
}

// Mendapatkan nilai dari input username dan password, dan mencegah SQL injection
// antiinjection() diasumsikan telah diubah untuk menggunakan fungsi escaping PostgreSQL
$username = antiinjection($koneksi, $_POST['username']);
$password = antiinjection($koneksi, $_POST['password']);

// Membuat query untuk mendapatkan informasi pengguna dari database
// CATATAN: Nama kolom 'password' diubah menjadi 'hashed_password' pada SELECT statement
// agar konsisten dengan sintaks alias, tapi di database tetap 'password'.
$query = "SELECT username, level, salt, password as hashed_password FROM \"user\" WHERE username='$username'";

// Eksekusi query menggunakan fungsi PostgreSQL
// pg_query_params LEBIH DISARANKAN untuk keamanan (prepared statement)
$result = pg_query($koneksi, $query);

// Memeriksa apakah query berhasil
if (!$result) {
    pesan('danger', "Query database gagal.");
    header("location:login.php");
    die();
}

// Mengambil baris hasil query
$row = pg_fetch_assoc($result);

// Menutup koneksi
// pg_close($koneksi); // Lebih baik koneksi ditutup di akhir skrip atau saat tidak diperlukan lagi

// Mendapatkan salt dan hashed password dari hasil query
// Jika $row tidak ditemukan, $salt dan $hashed_password akan menjadi null
$salt = $row['salt'] ?? null;
$hashed_password = $row['hashed_password'] ?? null;

// Memeriksa apakah salt dan hashed password tidak null (username ditemukan)
if ($salt !== null && $hashed_password !== null) {
    // Menggabungkan salt dengan password yang dimasukkan pengguna
    $combined_password = $salt . $password;
    // Memeriksa apakah password yang dimasukkan sesuai dengan hashed password dalam database
    if (password_verify($combined_password, $hashed_password)) {
        // Jika password benar, menyimpan username dan level pengguna dalam sesi
        $_SESSION['username'] = $row['username'];
        $_SESSION['level'] = $row['level'];
        // Mengarahkan pengguna ke halaman utama (index.php)
        header("location:index.php");
    } else {
        // Jika password salah, menampilkan pesan kesalahan dan mengarahkan kembali ke halaman login
        pesan('danger', "Login gagal. Password Anda Salah.");
        header("location:login.php");
    }
} else {
    // Jika username tidak ditemukan dalam database, menampilkan pesan kesalahan dan mengarahkan kembali ke halaman login
    pesan('warning', "Username tidak ditemukan.");
    header("location:login.php");
}

// Menutup koneksi (opsional, tergantung manajemen koneksi Anda)
// pg_close($koneksi);

// Menghentikan eksekusi kode selanjutnya
die();
?>