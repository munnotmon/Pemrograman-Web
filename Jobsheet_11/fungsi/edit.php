<?php
session_start();
// Memeriksa apakah sesi username tidak kosong
if (!empty($_SESSION['username'])) {
    // Memasukkan file koneksi.php untuk menghubungkan ke database
    require '../config/koneksi.php';
    // Memasukkan file pesan_kilat.php yang berisi fungsi untuk menampilkan pesan kilat
    require '../fungsi/pesan_kilat.php';
    // anti_injection.php TELAH DIHAPUS - KITA TIDAK MEMBUTUHKANNYA LAGI

    // Pastikan variabel $koneksi adalah objek koneksi PostgreSQL yang valid
    if (!isset($koneksi) || !$koneksi) {
        pesan('danger', "Koneksi database PostgreSQL gagal.");
        header("Location: ../index.php");
        die();
    }

    // Memeriksa apakah terdapat parameter jabatan dalam URL
    if (!empty($_GET['jabatan'])) {
        // --- Ambil data mentah (tanpa 'anti-injection') ---
        $id = $_POST['id'];
        $jabatan = $_POST['jabatan'];
        $keterangan = $_POST['keterangan'];
        
        // --- Gunakan Prepared Statements ---
        // $1, $2, $3 adalah "placeholder" yang aman
        $query = "UPDATE jabatan SET jabatan = $1, keterangan = $2 WHERE id = $3";
        // Masukkan data ke dalam array, urutan harus sesuai dengan $1, $2, $3
        $params = [$jabatan, $keterangan, $id];
        
        // Menjalankan query dengan pg_query_params()
        if (pg_query_params($koneksi, $query, $params)) {
            pesan('success', "Jabatan Telah Diubah.");
        } else {
            pesan('danger', "Mengubah Jabatan Karena: " . pg_last_error($koneksi));
        }
        header("Location: ../index.php?page=jabatan");

    // Memeriksa apakah terdapat parameter anggota dalam URL
    } elseif (!empty($_GET['anggota'])) {
        // --- Ambil data mentah (tanpa 'anti-injection') ---
        $user_id = $_POST['id'];
        $nama = $_POST['nama'];
        $jabatan = $_POST['jabatan'];
        $jenis_kelamin = $_POST['jenis_kelamin'];
        $alamat = $_POST['alamat'];
        $no_telp = $_POST['no_telp'];
        $username = $_POST['username'];
        
        // --- Gunakan Prepared Statements untuk query anggota ---
        $query_anggota = "UPDATE anggota SET nama = $1, jenis_kelamin = $2, alamat = $3, no_telp = $4, jabatan_id = $5 WHERE user_id = $6";
        $params_anggota = [$nama, $jenis_kelamin, $alamat, $no_telp, $jabatan, $user_id];
        
        if (pg_query_params($koneksi, $query_anggota, $params_anggota)) {
            // Memeriksa apakah password kosong atau tidak
            if (!empty($_POST['password'])) {
                // Proses hash password (ini sudah aman)
                $password = $_POST['password'];
                $salt = bin2hex(random_bytes(16));
                $combined_password = $salt . $password;
                $hashed_password = password_hash($combined_password, PASSWORD_BCRYPT);
                
                // Query untuk update user DENGAN password
                $query_user = "UPDATE \"user\" SET username = $1, password = $2, salt = $3 WHERE user_id = $4";
                $params_user = [$username, $hashed_password, $salt, $user_id];
                
                if (pg_query_params($koneksi, $query_user, $params_user)) {
                    pesan('success', "Anggota Telah Diubah.");
                } else {
                    pesan('warning', "Data Anggota Berhasil Diubah, Tetapi Password Gagal Diubah Karena: " . pg_last_error($koneksi));
                }
            } else {
                // Jika password kosong, hanya mengupdate username
                // Query untuk update user TANPA password
                $query_user = "UPDATE \"user\" SET username = $1 WHERE user_id = $2";
                $params_user = [$username, $user_id];
                
                if (pg_query_params($koneksi, $query_user, $params_user)) {
                    pesan('success', "Anggota Telah Diubah.");
                } else {
                    pesan('warning', "Data Anggota Berhasil Diubah, Tetapi Username Gagal Diubah Karena: " . pg_last_error($koneksi));
                }
            }
        } else {
            pesan('danger', "Mengubah Anggota Karena: " . pg_last_error($koneksi));
        }
        header("Location: ../index.php?page=anggota");
    }
}
?>