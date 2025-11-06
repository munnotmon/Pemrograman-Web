<?php
// Memulai sesi
session_start();

// Memeriksa apakah sesi username tidak kosong
if (!empty($_SESSION['username'])) {
    // Memasukkan file koneksi database
    require '../config/koneksi.php';
    // Memasukkan file fungsi pesan kilat untuk menampilkan pesan
    require '../fungsi/pesan_kilat.php';
    // Memasukkan file fungsi anti injection untuk mencegah SQL injection
    require '../fungsi/anti_injection.php';

    // Pastikan variabel $koneksi adalah objek koneksi PostgreSQL yang valid
    if (!isset($koneksi) || !$koneksi) {
        pesan('danger', "Koneksi database PostgreSQL gagal.");
        // Redirect ke halaman utama jika koneksi gagal
        header("Location: ../index.php");
        die();
    }

    // Memeriksa apakah parameter id tidak kosong (untuk hapus jabatan)
    if (!empty($_GET['id']) && empty($_GET['anggota'])) {
        // Mengambil id jabatan dan mencegah SQL injection
        // CATATAN: Fungsi antiinjection() harus menggunakan pg_escape_string()
        $id = antiinjection($koneksi, $_GET['id']);

        // Query untuk menghapus data jabatan dari database
        $query = "DELETE FROM jabatan WHERE id = '$id'";

        // Menjalankan query menggunakan fungsi PostgreSQL
        if (pg_query($koneksi, $query)) {
            // Jika berhasil, tampilkan pesan sukses
            pesan('success', "Jabatan Telah Terhapus.");
        } else {
            // Jika gagal, tampilkan pesan error beserta pesan error dari PostgreSQL
            pesan('danger', "Jabatan Tidak Terhapus Karena: " . pg_last_error($koneksi));
        }
        
        // Redirect kembali ke halaman jabatan
        header("Location: ../index.php?page=jabatan");

    // Memeriksa apakah parameter anggota tidak kosong (untuk hapus anggota)
    } elseif (!empty($_GET['anggota'])) {
        
        // Memastikan parameter id ada untuk anggota yang akan dihapus
        if (empty($_GET['id'])) {
            pesan('danger', "ID Anggota tidak ditemukan.");
            header("Location: ../index.php?page=anggota");
            die();
        }

        // Mengambil id user dan mencegah SQL injection
        // ID yang dikirimkan adalah ID user (foreign key di tabel anggota)
        $id = antiinjection($koneksi, $_GET['id']);
        
        // Query untuk menghapus data user dari database
        // CATATAN: 'user' diapit kutip ganda karena reserved keyword di PostgreSQL.
        $query1 = "DELETE FROM \"user\" WHERE user_id = '$id'";
        
        // Menjalankan query pertama
        // Kita HAPUS USER DULU, anggapan user_id adalah primary key di user dan foreign key di anggota
        if (pg_query($koneksi, $query1)) {
            // Jika berhasil, lanjutkan dengan menghapus data anggota terkait
            // NOTE: Jika Anda menggunakan ON DELETE CASCADE pada desain database, query2 ini TIDAK PERLU.
            $query2 = "DELETE FROM anggota WHERE user_id = '$id'";
            
            // Menjalankan query kedua
            if (pg_query($koneksi, $query2)) {
                // Jika berhasil, tampilkan pesan sukses
                pesan('success', "Anggota Telah Terhapus.");
            } else {
                // Jika gagal, tampilkan pesan warning
                pesan('warning', "Data Login Terhapus Tetapi Data Anggota Tidak Terhapus Karena: " . pg_last_error($koneksi));
            }
        } else {
            // Jika gagal, tampilkan pesan error beserta pesan error dari PostgreSQL
            pesan('danger', "Anggota Tidak Terhapus Karena: " . pg_last_error($koneksi));
        }
        
        // Redirect kembali ke halaman anggota
        header("Location: ../index.php?page=anggota");
    }
}
?>