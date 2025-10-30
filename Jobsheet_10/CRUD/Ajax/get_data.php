<?php
include 'koneksi.php';

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $query = "SELECT * FROM anggota WHERE id=:id";
    $sql = $db1->prepare($query);
    $sql->bindParam(':id', $id);
    $sql->execute();
    $data = $sql->fetch(PDO::FETCH_ASSOC);
    echo json_encode($data);
}
?>
