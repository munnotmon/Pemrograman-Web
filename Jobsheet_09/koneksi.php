<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// --- KONFIGURASI KONEKSI POSTGRESQL ---
$host = 'localhost';
$port = '5432';
$dbname = 'prakwebdb';
$user = 'postgres';
$pass = '12345678';

// Membuat koneksi
$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$pass");
if (!$conn) {
    die('Koneksi gagal: ' . pg_last_error());
}

// Set encoding UTF8
pg_set_client_encoding($conn, 'UTF8');

// Ambil data dari tabel user
$sql = 'SELECT "id", "username", "password" FROM "users" ORDER BY "id"';
$result = pg_query($conn, $sql);
if (!$result) {
    die('Query gagal: ' . pg_last_error($conn));
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar User</title>
</head>
<body>
<h1>Daftar User</h1>
<table border="1" cellpadding="10" cellspacing="0">
    <tr>
        <th>id</th>
        <th>username</th>
        <th>password</th>
        <th>aksi</th>
    </tr>

    <?php while ($row = pg_fetch_assoc($result)): ?>
    <tr>
        <td><?= htmlspecialchars($row["id"], ENT_QUOTES, 'UTF-8'); ?></td>
        <td><?= htmlspecialchars($row["username"], ENT_QUOTES, 'UTF-8'); ?></td>
        <td><?= htmlspecialchars($row["password"], ENT_QUOTES, 'UTF-8'); ?></td>
        <td>
            <a href="edit.php?id=<?= urlencode($row['id']); ?>">Edit</a> |
            <a href="hapus.php?id=<?= urlencode($row['id']); ?>" onclick="return confirm('Yakin ingin hapus data ini?');">Hapus</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

<?php
// Bebaskan hasil & tutup koneksi
pg_free_result($result);
pg_close($conn);
?>
</body>
</html>