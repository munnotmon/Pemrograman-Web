<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Upload & Daftar File</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h2>Upload File</h2>
    <form id="upload-form" enctype="multipart/form-data">
        <label for="file">Pilih File:</label>
        <input type="file" name="file" id="file" required>

        <label for="description">Deskripsi:</label>
        <input type="text" name="description" id="description" required>

        <button type="submit">Unggah</button>
    </form>

    <p id="status"></p>

    <hr>
    <h3>Daftar File</h3>

    <div id="file-list">
        <table>
            <thead>
                <tr>
                    <th>Nama File</th>
                    <th>Deskripsi</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="script.js"></script>
</body>
</html>
