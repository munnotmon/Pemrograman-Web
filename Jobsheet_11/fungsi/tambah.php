<?php
session_start();
if (!empty($_SESSION['username'])) {
    require '../config/koneksi.php';
    require '../fungsi/pesan_kilat.php';
    // require '../fungsi/anti_injection.php'; // <-- 1. DIHAPUS, SUDAH TIDAK PERLU

    // --- BLOK TAMBAH JABATAN ---
    if (!empty($_GET['jabatan'])) {
        // 2. Ambil data mentah, tidak perlu 'antiInjection'
        $jabatan = $_POST['jabatan'];
        $keterangan = $_POST['keterangan'];

        // 3. Buat kueri pakai placeholder ($1, $2)
        $query = "INSERT INTO jabatan (jabatan, keterangan) VALUES ($1, $2)";

        // 4. Pakai pg_query_params() untuk eksekusi aman
        $result = pg_query_params($koneksi, $query, [$jabatan, $keterangan]);

        if ($result) {
            pesan('success', "Jabatan Baru Ditambahkan.");
        } else {
            pesan('danger', "Menambahkan Jabatan Gagal Karena: " . pg_last_error($koneksi));
        }
        header("Location: ../index.php?page=jabatan");

    // --- BLOK TAMBAH ANGGOTA ---
    } elseif (!empty($_GET['anggota'])) {
        // 2. Ambil semua data mentah
        $username = $_POST['username'];
        $password = $_POST['password'];
        $level = $_POST['level'];
        $jabatan_id = $_POST['jabatan']; // (Asumsi ini adalah jabatan_id)
        $nama = $_POST['nama'];
        $jenis_kelamin = $_POST['jenis_kelamin'];
        $alamat = $_POST['alamat'];
        $no_telp = $_POST['no_telp'];

        // Logika password Anda (ini sudah benar, tidak diubah)
        $salt = bin2hex(random_bytes(16));
        $combined_password = $salt . $password;
        $hashed_password = password_hash($combined_password, PASSWORD_BCRYPT);

        // 3. Kueri 1 (Insert user) pakai placeholder
        // (Catatan: Pastikan nama tabel Anda "users" atau "user")
        $query_user = "INSERT INTO \"user\" (username, password, salt, level) 
                       VALUES ($1, $2, $3, $4) 
                       RETURNING id";
        $params_user = [$username, $hashed_password, $salt, $level];
        
        // 4. Pakai pg_query_params()
        $result_user = pg_query_params($koneksi, $query_user, $params_user);

        if ($result_user) {
            // Berhasil insert user, ambil id-nya
            $row = pg_fetch_assoc($result_user);
            $last_id = $row['id']; // Ini adalah user_id yang baru

            // 3. Kueri 2 (Insert anggota) pakai placeholder
            $query_anggota = "INSERT INTO anggota (nama, jenis_kelamin, alamat, no_telp, user_id, jabatan_id) 
                              VALUES ($1, $2, $3, $4, $5, $6)";
            $params_anggota = [$nama, $jenis_kelamin, $alamat, $no_telp, $last_id, $jabatan_id];

            // 4. Pakai pg_query_params() lagi
            $result_anggota = pg_query_params($koneksi, $query_anggota, $params_anggota);

            if ($result_anggota) {
                pesan('success', "Anggota Baru Ditambahkan.");
            } else {
                pesan('warning', "Gagal Menambahkan Anggota (Data Login Dibuat): " . pg_last_error($koneksi));
            }
        } else {
            // Gagal saat insert data login (kueri 1)
            pesan('danger', "Gagal Menambahkan Data Login Anggota: " . pg_last_error($koneksi));
        }
        header("Location: ../index.php?page=anggota");
    }
} else {
    // Jika session username kosong, tendang ke login
    header("Location: ../login.php");
}
?>