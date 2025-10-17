<!DOCTYPE html>
<html>
<head>
    <title>Form HTML Aman</title>
</head>
<body>
    <h2>Form HTML Aman</h2>

    <form method="post" action="">
        <label for="nama">Masukkan Nama:</label>
        <input type="text" name="nama" id="nama" required><br><br>

        <label for="email">Masukkan Email:</label>
        <input type="email" name="email" id="email" required><br><br>

        <input type="submit" value="Kirim">
    </form>

    <?php
    // Proses data setelah form dikirim
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Langkah 2: Amankan input nama
        $input = $_POST['nama'];
        $input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');

        // Amankan dan validasi input email
        $email = $_POST['email'];
        $email = htmlspecialchars($email, ENT_QUOTES, 'UTF-8');

        echo "<h3>Hasil Input:</h3>";
        echo "Nama Anda: " . $input . "<br>";

        // Validasi email
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "Email Anda: " . $email;
        } else {
            echo "Email tidak valid.";
        }
    }   
    ?>
</body>
</html>
