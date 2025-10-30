<?php
include "koneksi.php";

// Mendapatkan nilai aksi dari URL (GET)
$aksi = $_GET['aksi'];

// Mendapatkan data dari formulir (POST)
// Variabel ini akan digunakan oleh logika 'tambah' dan 'ubah'
$nama = $_POST['nama'];
$jenis_kelamin = $_POST['jenis_kelamin'];
$alamat = $_POST['alamat'];
$no_telp = $_POST['no_telp'];

// --- BLOK KONDISIONAL UTAMA UNTUK MENANGANI SEMUA AKSI (CRUD) ---

if ($aksi == 'tambah') {
    $query = "INSERT INTO anggota (nama, jenis_kelamin, alamat, no_telp) VALUES ('$nama', '$jenis_kelamin', '$alamat', '$no_telp')";

    if (pg_query($koneksi, $query)) {
        header("Location: index.php");
        exit();
    } else {
        echo "Gagal menambahkan data: " . pg_last_error($koneksi);
    }
}

elseif ($aksi == 'ubah') {
    // Ambil ID dari POST
    if (isset($_POST['id'])) {
        $id = $_POST['id'];
    } else {
        echo "ID untuk aksi ubah tidak valid (missing POST['id']).";
        // Lanjutkan ke penutupan koneksi
    }

    $query = "UPDATE anggota SET nama = '$nama', jenis_kelamin = '$jenis_kelamin', alamat = '$alamat', no_telp = '$no_telp' WHERE id = '$id'";

    if (pg_query($koneksi, $query)) {
        header("Location: index.php");
        exit();
    } else {
        echo "Gagal mengubah data: " . pg_last_error($koneksi);
    }
} 

elseif ($aksi == 'hapus') {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        
        $query = "DELETE FROM anggota WHERE id = $id";
        
        if (pg_query($koneksi, $query)) {
            header("Location: index.php");
            exit();
        } else {
            echo "Gagal menghapus data: " . pg_last_error($koneksi);
        }
    } else {
        echo "ID untuk aksi hapus tidak valid (missing GET['id']).";
    }
} 

else {
    echo "Aksi tidak valid.";
}
pg_close($koneksi);
?>