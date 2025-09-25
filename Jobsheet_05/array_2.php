<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Mahasiswa</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #fff;
            margin: 40px;
        }
        h2 {
            color: #c94f7c;
            margin-bottom: 20px;
            font-size: 24px;
        }
        table {
            border-collapse: collapse;
            border-spacing: 0;
            width: 100%;
            border: 1px solid #000; 
            border-radius: 10px;    
            overflow: hidden;
        }
        th {
            text-align: center; 
            background-color: #f8b6cc; 
            color: #000;
            padding: 16px;
            border: 1px solid #000;
        }
        td {
            text-align: left;
            padding: 16px;
            border: 1px solid #000;
        }
        tr:nth-child(even) {
            background-color: #fde6ef; 
        }
        tr:nth-child(odd) td {
            background-color: #fff; 
        }
        tr:hover td {
            background-color: #f9d1e4; 
        }
    </style>
</head>
<body>

<h2>Data Mahasiswa</h2>

<?php
$Mahasiswa = [
    'nama' => 'Maulida Aprina Putri',
    'domisili' => 'Palangka Raya',
    'jenis_kelamin' => 'Perempuan'
];
?>

<table>
    <tr>
        <th>Field</th>
        <th>Data</th>
    </tr>
    <tr>
        <td>Nama</td>
        <td><?php echo $Mahasiswa['nama']; ?></td>
    </tr>
    <tr>
        <td>Domisili</td>
        <td><?php echo $Mahasiswa['domisili']; ?></td>
    </tr>
    <tr>
        <td>Jenis Kelamin</td>
        <td><?php echo $Mahasiswa['jenis_kelamin']; ?></td>
    </tr>
</table>

</body>
</html>
