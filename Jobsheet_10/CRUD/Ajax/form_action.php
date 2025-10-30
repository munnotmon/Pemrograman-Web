<?php
session_start();
include 'koneksi.php';
include 'csrf.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama']);
    $jenis_kelamin = trim($_POST['jenis_kelamin']);
    $alamat = trim($_POST['alamat']);
    $no_telp = trim($_POST['no_telp']);
    $id = isset($_POST['id']) ? $_POST['id'] : '';

    if ($nama == '' || $jenis_kelamin == '' || $alamat == '' || $no_telp == '') {
        echo json_encode(['error' => 'Semua kolom wajib diisi!']);
        exit;
    }

    try {
        if ($id == '') {
            // INSERT
            $query = "INSERT INTO anggota (nama, jenis_kelamin, alamat, no_telp) VALUES (:nama, :jenis_kelamin, :alamat, :no_telp)";
        } else {
            // UPDATE
            $query = "UPDATE anggota SET nama=:nama, jenis_kelamin=:jenis_kelamin, alamat=:alamat, no_telp=:no_telp WHERE id=:id";
        }

        $sql = $db1->prepare($query);
        $sql->bindParam(':nama', $nama);
        $sql->bindParam(':jenis_kelamin', $jenis_kelamin);
        $sql->bindParam(':alamat', $alamat);
        $sql->bindParam(':no_telp', $no_telp);
        if ($id != '') $sql->bindParam(':id', $id);
        $sql->execute();

        echo json_encode(['success' => 'Data berhasil disimpan!']);
    } catch (PDOException $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
}
?>
