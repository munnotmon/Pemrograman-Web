<?php
include 'koneksi.php';

if (isset($_POST['id'])) {
    $id = $_POST['id'];

    try {
        $stmt = $db1->prepare("DELETE FROM anggota WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        echo json_encode(['success' => 'Data berhasil dihapus!']);
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Gagal menghapus data: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'ID tidak ditemukan!']);
}
?>
