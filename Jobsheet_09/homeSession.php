<?php
session_start();
if (!isset($_SESSION['status']) || $_SESSION['status'] != 'login') {
    header("Location: sessionLoginForm.html");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Home</title>
</head>
<body>
<h1>Selamat datang, <?= htmlspecialchars($_SESSION['username']); ?>!</h1>
<a href="sessionLogout.php">Logout</a>
</body>
</html>
