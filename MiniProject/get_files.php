<?php
$metadataFile = "metadata.json";

if (!file_exists($metadataFile)) {
    echo json_encode([]);
    exit;
}

$data = json_decode(file_get_contents($metadataFile), true);
echo json_encode($data);
?>
