<?php
if (isset($_POST["submit"])) {
    $targetDirectory = "uploads/";
    $targetFile = $targetDirectory . basename($_FILES["fileToUpload"]["name"]);
    $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    $allowedExtensions = array("jpg", "jpeg", "png", "gif");
    $maxFileSize = 5 * 1024 * 1024;

    // validasi tipe dan ukuran file
    if (in_array($fileType, $allowedExtensions) && $_FILES["fileToUpload"]["size"] <= $maxFileSize) {

        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFile)) {
            echo "File berhasil diunggah.<br>";

            // ====== LANGKAH 5: Membuat thumbnail ======
            $thumbnailWidth = 200; // lebar tetap 200px

            // Ambil ukuran asli gambar
            list($width, $height) = getimagesize($targetFile);

            // Hitung tinggi baru agar proporsinya tetap
            $thumbnailHeight = ($height / $width) * $thumbnailWidth;

            // Buat gambar baru untuk thumbnail
            $thumbnail = imagecreatetruecolor($thumbnailWidth, $thumbnailHeight);

            // Baca gambar sesuai tipe file
            switch ($fileType) {
                case 'jpg':
                case 'jpeg':
                    $source = imagecreatefromjpeg($targetFile);
                    break;
                case 'png':
                    $source = imagecreatefrompng($targetFile);
                    break;
                case 'gif':
                    $source = imagecreatefromgif($targetFile);
                    break;
                default:
                    echo "Tipe gambar tidak didukung untuk thumbnail.";
                    exit;
            }

            // Resize gambar
            imagecopyresampled($thumbnail, $source, 0, 0, 0, 0, $thumbnailWidth, $thumbnailHeight, $width, $height);

            // Simpan thumbnail dengan nama baru
            $thumbnailFile = $targetDirectory . "thumb_" . basename($_FILES["fileToUpload"]["name"]);
            imagejpeg($thumbnail, $thumbnailFile);

            echo "Thumbnail berhasil dibuat: <a href='$thumbnailFile'>$thumbnailFile</a>";

            // Bersihkan memori
            imagedestroy($thumbnail);
            imagedestroy($source);

        } else {
            echo "Gagal mengunggah file.";
        }

    } else {
        echo "File tidak valid atau melebihi ukuran maksimum yang diizinkan.";
    }
}
?>
