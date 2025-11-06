<?php
session_start();

if (!empty($_SESSION['username'])) {
    require '../config/koneksi.php';
    require '../fungsi/pesan_kilat.php';
    // require '../fungsi/anti_injection.php'; // <-- 1. DIHAPUS

    // --- BLOK EDIT JABATAN ---
    if (!empty($_GET['jabatan'])) {
        // 2. Ambil data mentah, tidak perlu 'antiInjection'
        $id = $_POST['id'];
        $jabatan = $_POST['jabatan'];
        $keterangan = $_POST['keterangan'];
        
        // 3. Buat kueri pakai placeholder ($1, $2, $3)
        $query = "UPDATE jabatan SET jabatan = $1, keterangan = $2 WHERE id = $3";
        
        // 4. Pakai pg_query_params()
        // Urutan array harus sama dengan urutan placeholder: $1=$jabatan, $2=$keterangan, $3=$id
        $result = pg_query_params($koneksi, $query, [$jabatan, $keterangan, $id]);

        if ($result) {
            pesan('success', "Jabatan Telah Diubah.");
        } else {
            pesan('danger', "Mengubah Jabatan Gagal Karena: " . pg_last_error($koneksi));
        }
        header("Location: ../index.php?page=jabatan");

    // --- BLOK EDIT ANGGOTA ---
    } elseif (!empty($_GET['anggota'])) {
        // 2. Ambil semua data mentah
        $user_id = $_POST['id']; // Ini adalah user_id
        $nama = $_POST['nama'];
        $jabatan_id = $_POST['jabatan']; // (Asumsi ini adalah jabatan_id)
        $jenis_kelamin = $_POST['jenis_kelamin'];
        $alamat = $_POST['alamat'];
        $no_telp = $_POST['no_telp'];
        $username = $_POST['username'];

        // 3. Kueri 1 (Update anggota) pakai placeholder
        $query_anggota = "UPDATE anggota SET nama = $1,
                            jenis_kelamin = $2,
                            alamat = $3,
                            no_telp = $4,
                            jabatan_id = $5
                          WHERE user_id = $6";
        // 4. Siapkan array parameternya
        $params_anggota = [$nama, $jenis_kelamin, $alamat, $no_telp, $jabatan_id, $user_id];
        
        // 4. Eksekusi kueri anggota
        $result_anggota = pg_query_params($koneksi, $query_anggota, $params_anggota);

        if ($result_anggota) {
            // Cek apakah user juga ganti password
            if (!empty($_POST['password'])) {
                // --- JIKA PASSWORD DIUBAH ---
                $password = $_POST['password'];
                $salt = bin2hex(random_bytes(16));
                $combined_password = $salt . $password;
                $hashed_password = password_hash($combined_password, PASSWORD_BCRYPT);

                // 3. Kueri 2 (Update user + password baru)
                // (Catatan: Pastikan nama tabel Anda "users" atau "user")
                $query_user = "UPDATE \"users\" SET username = $1, password = $2, salt = $3 WHERE id = $4";
                $params_user = [$username, $hashed_password, $salt, $user_id];
                
                // 4. Eksekusi kueri user
                $result_user = pg_query_params($koneksi, $query_user, $params_user);

                if ($result_user) {
                    pesan('success', "Anggota Telah Diubah (Password Diperbarui).");
                } else {
                    pesan('warning', "Data Anggota Berhasil Diubah, Tetapi Password Gagal Diubah Karena: " . pg_last_error($koneksi));
                }
            } else {
                // --- JIKA PASSWORD TIDAK DIUBAH (hanya username) ---
                
                // 3. Kueri 2 (Update user, tanpa password)
                // (Saya perbaiki nama tabel Anda dari "user" menjadi "users" agar konsisten)
                $query_user = "UPDATE \"users\" SET username = $1 WHERE id = $2";
                $params_user = [$username, $user_id];

                // 4. Eksekusi kueri user
                $result_user = pg_query_params($koneksi, $query_user, $params_user);

                if ($result_user) {
                    pesan('success', "Anggota Telah Diubah.");
                } else {
                    pesan('warning', "Data Anggota Berhasil Diubah, Tetapi Username Gagal Diubah Karena: " . pg_last_error($koneksi));
                }
            }
        } else {
            pesan('danger', "Mengubah Data Anggota Gagal Karena: " . pg_last_error($koneksi));
        }
        header("Location: ../index.php?page=anggota");
    }
} else {
    // Jika session username kosong, tendang ke login
    header("Location: ../login.php");
}
?>