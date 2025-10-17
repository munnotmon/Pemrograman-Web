<?php
$targetDirectory = "uploads/";
$maxFileSize = 5 * 1024 * 1024; // 5 MB
$allowedExtensions = ["jpg", "jpeg", "png", "gif", "pdf", "doc", "docx", "txt"];
$metadataFile = "metadata.json";

//memastikan direktori ada
if (!file_exists($targetDirectory)) {
    mkdir($targetDirectory, 0777, true);
}

//memastikan file metadata ada
if (!file_exists($metadataFile)) {
    file_put_contents($metadataFile, "[]");
}

if (isset($_FILES["file"]) && isset($_POST["description"])) {
    $file_name = basename($_FILES["file"]["name"]);

    // Hilangkan karakter aneh/emoji agar aman di sistem file
    $file_name = preg_replace('/[^A-Za-z0-9_\-\.]/', '_', $file_name);

    $file_tmp = $_FILES["file"]["tmp_name"];
    $file_size = $_FILES["file"]["size"];
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    $description = trim($_POST["description"]);
    $targetFile = $targetDirectory . $file_name;

    // Validasi ekstensi
    if (!in_array($file_ext, $allowedExtensions)) {
        echo json_encode(["status" => "error", "msg" => "Jenis file tidak valid."]);
        exit;
    }

    // Validasi ukuran
    if ($file_size > $maxFileSize) {
        echo json_encode(["status" => "error", "msg" => "Ukuran file maksimal 5MB."]);
        exit;
    }

    // Proses upload file
    if (move_uploaded_file($file_tmp, $targetFile)) {
        $data = json_decode(file_get_contents($metadataFile), true);
        $data[] = [
            "name" => $file_name,
            "description" => $description,
            "date" => date("d-m-Y H:i:s")
        ];
        file_put_contents($metadataFile, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        echo json_encode(["status" => "success", "msg" => "File berhasil diunggah!"]);
    } else {
        echo json_encode(["status" => "error", "msg" => "Gagal mengunggah file. Coba lagi."]);
    }
} else {
    echo json_encode(["status" => "error", "msg" => "Data tidak lengkap."]);
}
?>
