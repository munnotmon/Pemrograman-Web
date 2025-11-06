<?php
// Memulai sesi
session_start();

// Memeriksa apakah sesi username tidak kosong
if (!empty($_SESSION['username'])) {
    // Memasukkan file koneksi database
    require '../config/koneksi.php';
    // Memasukkan file fungsi pesan kilat untuk menampilkan pesan
    require '../fungsi/pesan_kilat.php';
    // File anti_injection.php tidak diperlukan lagi, kita gunakan prepared statements
    // require '../fungsi/anti_injection.php';

    // Pastikan variabel $koneksi adalah objek koneksi PostgreSQL yang valid
    if (!isset($koneksi) || !$koneksi) {
        pesan('danger', "Koneksi database PostgreSQL gagal.");
        header("Location: ../index.php"); // Redirect ke index utama
        die();
    }

    // --- LOGIKA TAMBAH JABATAN (BARU) ---
    if (!empty($_GET['jabatan'])) {
        $jabatan = $_POST['jabatan'];
        $keterangan = $_POST['keterangan'];

        // Gunakan prepared statements
        $query = "INSERT INTO jabatan (jabatan, keterangan) VALUES ($1, $2)";
        $params = [$jabatan, $keterangan];

        if (pg_query_params($koneksi, $query, $params)) {
            pesan('success', "Jabatan Baru Ditambahkan.");
        } else {
            pesan('danger', "Gagal Menambahkan Jabatan: " . pg_last_error($koneksi));
        }
        header("Location: ../index.php?page=jabatan");

    // --- LOGIKA TAMBAH ANGGOTA (DIMODIFIKASI JADI AMAN) ---
    } elseif (!empty($_GET['anggota'])) {
        
        // Ambil data mentah (TANPA antiinjection)
        $username = $_POST['username'];
        $password = $_POST['password'];
        $level = $_POST['level'];
        $jabatan = $_POST['jabatan'];
        $nama = $_POST['nama'];
        $jenis_kelamin = $_POST['jenis_kelamin'];
        $alamat = $_POST['alamat'];
        $no_telp = $_POST['no_telp'];

        // Membuat salt acak
        $salt = bin2hex(random_bytes(16));
        // Menggabungkan salt dengan password yang dimasukkan
        $combined_password = $salt . $password;
        // Mengenkripsi password menggunakan BCRYPT
        $hashed_password = password_hash($combined_password, PASSWORD_BCRYPT);
        
        // --- PROSES INSERT KE POSTGRESQL (Menggunakan Parameter) ---

        // Query 1: Insert ke tabel "user"
        $query1 = "INSERT INTO \"user\" (username, password, salt, level) 
                   VALUES ($1, $2, $3, $4) 
                   RETURNING user_id";
        $params1 = [$username, $hashed_password, $salt, $level];

        if ($result1 = pg_query_params($koneksi, $query1, $params1)) {
            // Jika berhasil, ambil ID user terakhir
            $row = pg_fetch_row($result1);
            $last_id = $row[0]; // user_id yang di-return

            // Query 2: Insert ke tabel anggota
            $query2 = "INSERT INTO anggota (nama, jenis_kelamin, alamat, no_telp, user_id, jabatan_id) 
                       VALUES ($1, $2, $3, $4, $5, $6)";
            $params2 = [$nama, $jenis_kelamin, $alamat, $no_telp, $last_id, $jabatan];

            // Menjalankan query kedua
            if (pg_query_params($koneksi, $query2, $params2)) {
                pesan('success', "Anggota Baru Ditambahkan.");
            } else {
                // Jika query 2 gagal
                pesan('warning', "Gagal Menambahkan Anggota (Data Login Tersimpan) Karena: " . pg_last_error($koneksi));
            }
        } else {
            // Jika query 1 gagal
            pesan('danger', "Gagal Menambahkan Data Login Karena: " . pg_last_error($koneksi));
        }
        
        // Redirect kembali ke halaman anggota
        header("Location: ../index.php?page=anggota");
    }
}
?>