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
        header("Location: ../index.php?page=anggota");
        die();
    }

    // Memeriksa apakah parameter anggota tidak kosong
    if (!empty($_GET['anggota'])) {
        // Mengambil data yang diperlukan dari form tambah anggota dan mencegah SQL injection
        // CATATAN: Fungsi antiinjection() harus menggunakan pg_escape_string()
        $username = antiinjection($koneksi, $_POST['username']);
        $password = antiinjection($koneksi, $_POST['password']);
        $level = antiinjection($koneksi, $_POST['level']);
        $jabatan = antiinjection($koneksi, $_POST['jabatan']);
        $nama = antiinjection($koneksi, $_POST['nama']);
        $jenis_kelamin = antiinjection($koneksi, $_POST['jenis_kelamin']);
        $alamat = antiinjection($koneksi, $_POST['alamat']);
        $no_telp = antiinjection($koneksi, $_POST['no_telp']);

        // Membuat salt acak
        $salt = bin2hex(random_bytes(16));
        // Menggabungkan salt dengan password yang dimasukkan
        $combined_password = $salt . $password;
        // Mengenkripsi password menggunakan BCRYPT
        $hashed_password = password_hash($combined_password, PASSWORD_BCRYPT);
        
        // --- PROSES INSERT KE POSTGRESQL ---

        // Query untuk memasukkan data user ke database dengan klausa RETURNING
        // CATATAN: 'user' diapit kutip ganda karena merupakan reserved keyword di PostgreSQL.
        // Asumsi kolom primary key user adalah user_id.
        $query1 = "INSERT INTO \"user\" (username, password, salt, level) 
                   VALUES ('$username', '$hashed_password', '$salt', '$level') 
                   RETURNING user_id";

        // Menjalankan query pertama
        if ($result1 = pg_query($koneksi, $query1)) {
            // Jika berhasil memasukkan data user, ambil ID user terakhir yang dimasukkan
            $row = pg_fetch_row($result1);
            $last_id = $row[0]; // user_id yang di-return ada di indeks 0

            // Query untuk memasukkan data anggota ke database
            $query2 = "INSERT INTO anggota (nama, jenis_kelamin, alamat, no_telp, user_id, jabatan_id) 
                       VALUES ('$nama', '$jenis_kelamin', '$alamat', '$no_telp', '$last_id', '$jabatan')";

            // Menjalankan query kedua
            if (pg_query($koneksi, $query2)) {
                // Jika berhasil, tampilkan pesan sukses
                pesan('success', "Anggota Baru Ditambahkan.");
            } else {
                // Jika gagal, tampilkan pesan warning (menggunakan pg_last_error)
                pesan('warning', "Gagal Menambahkan Anggota Tetapi Data Login Tersimpan Karena: " . pg_last_error($koneksi));
            }
        } else {
            // Jika gagal, tampilkan pesan error beserta pesan error dari PostgreSQL
            pesan('danger', "Gagal Menambahkan Anggota Karena: " . pg_last_error($koneksi));
        }
        
        // Redirect kembali ke halaman anggota
        header("Location: ../index.php?page=anggota");
    }
}
?>