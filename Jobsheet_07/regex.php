<!DOCTYPE html>
<html>
<head>
    <title>Regex PHP</title>
</head>
<body>
    <h2>Regular Expression</h2>

    <?php
    // Pola pertama: mencocokkan huruf kecil
    $pattern = '/[a-z]/'; // Cocokkan huruf kecil
    $text = 'This is a Sample Text.';

    if (preg_match($pattern, $text)) {
        echo "<p><b>Hasil 1:</b> Huruf kecil ditemukan!</p>";
    } else {
        echo "<p><b>Hasil 1:</b> Tidak ada huruf kecil!</p>";
    }

    // Pola kedua: mencocokkan satu atau lebih digit angka
    $pattern = '/[0-9]+/'; // Cocokkan satu atau lebih digit
    $text = 'There are 123 apples.';

    if (preg_match($pattern, $text, $matches)) {
        echo "<p><b>Hasil 2:</b> Cocokkan angka: " . $matches[0] . "</p>";
    } else {
        echo "<p><b>Hasil 2:</b> Tidak ada yang cocok!</p>";
    }

    // Pola ketiga: mengganti kata "apple" dengan "banana"
    $pattern = '/apple/';
    $replacement = 'banana';
    $text = 'I like apple pie.';

    $new_text = preg_replace($pattern, $replacement, $text);
    echo "<p><b>Hasil 3:</b> Setelah penggantian teks: " . $new_text . "</p>";

    // Pola keempat: mencocokkan "god", "good", "goooood", dll.
    $pattern = '/go*d/'; // Cocokkan "god", "good", "goooood", dll.
    $text = 'god is good.';

    if (preg_match($pattern, $text, $matches)) {
        echo "<p><b>Hasil 4:</b> Cocokkan kata: " . $matches[0] . "</p>";
    } else {
        echo "<p><b>Hasil 4:</b> Tidak ada yang cocok!</p>";
    }

    // Pola kelima: mencocokkan "gd" atau "god"
    $pattern = '/go?d/'; // Cocokkan "gd" atau "god"
    $text = 'gd is god.';

    if (preg_match($pattern, $text, $matches)) {
        echo "<p><b>Hasil 5:</b> Cocokkan kata: " . $matches[0] . "</p>";
    } else {
        echo "<p><b>Hasil 5:</b> Tidak ada yang cocok!</p>";
    }

    // Pola keenam: mencocokkan "good", "goood", atau "goooood"
    $pattern = '/go{2,4}d/'; // Cocokkan "good", "goood", atau "goooood"
    $text = 'god is good and goooood.';

    if (preg_match($pattern, $text, $matches)) {
        echo "<p><b>Hasil 6:</b> Cocokkan kata: " . $matches[0] . "</p>";
    } else {
        echo "<p><b>Hasil 6:</b> Tidak ada yang cocok!</p>";
    }
    ?>   
</body>
</html>