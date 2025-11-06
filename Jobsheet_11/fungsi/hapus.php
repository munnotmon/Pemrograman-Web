<?php
session_start();

if (!empty($_SESSION['username'])) {
    require '../config/koneksi.php';
    require '../fungsi/pesan_kilat.php';
    // require '../fungsi/anti_injection.php'; // <-- 1. DIHAPUS

    // --- BLOK HAPUS JABATAN ---
    if (!empty($_GET['jabatan'])) {
        // 2. Ambil data mentah, tidak perlu 'antiInjection'
        $id = $_GET['id'];

        // 3. Buat kueri pakai placeholder ($1)
        $query = "DELETE FROM jabatan WHERE id = $1";
        
        // 4. Pakai pg_query_params() untuk eksekusi aman
        $result = pg_query_params($koneksi, $query, [$id]);

        if ($result) {
            pesan('success', "Jabatan Telah Terhapus.");
        } else {
            pesan('danger', "Jabatan Tidak Terhapus Karena: " . pg_last_error($koneksi));
        }
        header("Location: ../index.php?page=jabatan");

    // --- BLOK HAPUS ANGGOTA ---
    } elseif (!empty($_GET['anggota'])) {
        // 2. Ambil data mentah (ini adalah user_id)
        $id = $_GET['id'];

        // 3. Kueri 1 (Hapus anggota) pakai placeholder
        // Ini harus jalan duluan sebelum hapus data login-nya
        $query_anggota = "DELETE FROM anggota WHERE user_id = $1";
        
        // 4. Pakai pg_query_params()
        $result_anggota = pg_query_params($koneksi, $query_anggota, [$id]);
        
        if ($result_anggota) {
            // 3. Kueri 2 (Hapus user) pakai placeholder
            $query_user = "DELETE FROM \"users\" WHERE id = $1";
            
            // 4. Pakai pg_query_params() lagi
            $result_user = pg_query_params($koneksi, $query_user, [$id]);

            if ($result_user) {
                pesan('success', "Anggota Telah Terhapus.");
            } else {
                // (Pesan error Anda sebelumnya sedikit membingungkan, saya perbaiki logikanya)
                pesan('warning', "Data Anggota Terhapus, Tapi Gagal Hapus Data Login: " . pg_last_error($koneksi));
            }
        } else {
            pesan('danger', "Data Anggota Gagal Dihapus (Data Login Aman): " . pg_last_error($koneksi));
        }
        header("Location: ../index.php?page=anggota");
    }
} else {
    // Jika session username kosong, tendang ke login
    header("Location: ../login.php");
}
?>