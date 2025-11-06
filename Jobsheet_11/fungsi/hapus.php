<?php
// Memulai sesi
session_start();

// Memeriksa apakah sesi username tidak kosong
if (!empty($_SESSION['username'])) {
    // Memasukkan file koneksi database
    require '../config/koneksi.php';
    // Memasukkan file fungsi pesan kilat untuk menampilkan pesan
    require '../fungsi/pesan_kilat.php';
    // File anti_injection.php tidak diperlukan lagi
    // require '../fungsi/anti_injection.php';

    // Pastikan variabel $koneksi adalah objek koneksi PostgreSQL yang valid
    if (!isset($koneksi) || !$koneksi) {
        pesan('danger', "Koneksi database PostgreSQL gagal.");
        header("Location: ../index.php");
        die();
    }

    // Memeriksa apakah parameter id tidak kosong (untuk hapus jabatan)
    if (!empty($_GET['id']) && empty($_GET['anggota'])) {
        // Mengambil id jabatan
        $id = $_GET['id'];

        // Query untuk menghapus data jabatan (Gunakan $1)
        $query = "DELETE FROM jabatan WHERE id = $1";

        // Menjalankan query menggunakan pg_query_params
        if (pg_query_params($koneksi, $query, [$id])) {
            pesan('success', "Jabatan Telah Terhapus.");
        } else {
            pesan('danger', "Jabatan Tidak Terhapus Karena: " . pg_last_error($koneksi));
        }
        
        header("Location: ../index.php?page=jabatan");

    // Memeriksa apakah parameter anggota tidak kosong (untuk hapus anggota)
    } elseif (!empty($_GET['anggota'])) {
        
        if (empty($_GET['id'])) {
            pesan('danger', "ID Anggota tidak ditemukan.");
            header("Location: ../index.php?page=anggota");
            die();
        }

        // Mengambil id user
        $id = $_GET['id'];
        
        // Query untuk menghapus data user (Gunakan $1)
        $query1 = "DELETE FROM \"user\" WHERE user_id = $1";
        
        // Menjalankan query pertama
        if (pg_query_params($koneksi, $query1, [$id])) {
            
            // NOTE: Jika Anda menggunakan ON DELETE CASCADE, query2 tidak perlu.
            // Tapi jika tidak, kita hapus manual data anggota terkait.
            $query2 = "DELETE FROM anggota WHERE user_id = $1";
            
            if (pg_query_params($koneksi, $query2, [$id])) {
                pesan('success', "Anggota Telah Terhapus.");
            } else {
                pesan('warning', "Data Login Terhapus, Data Anggota Gagal Dihapus: " . pg_last_error($koneksi));
            }
        } else {
            pesan('danger', "Anggota Tidak Terhapus Karena: " . pg_last_error($koneksi));
        }
        
        header("Location: ../index.php?page=anggota");
    }
}
?>