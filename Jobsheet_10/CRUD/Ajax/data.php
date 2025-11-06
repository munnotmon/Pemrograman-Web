<?php
session_start();
include 'koneksi.php';

$no = 1;
$query = "SELECT * FROM anggota ORDER BY id DESC";
$sql = $db1->prepare($query);
$sql->execute();
$res1 = $sql->fetchAll(PDO::FETCH_ASSOC);
?>
<table id="example" class="table table-striped table-bordered" style="width:100%">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Jenis Kelamin</th>
            <th>Alamat</th>
            <th>No Telp</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php if (count($res1) > 0): ?>
            <?php foreach ($res1 as $row): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= htmlspecialchars($row['nama']) ?></td>
                    <td><?= $row['jenis_kelamin'] == 'L' ? 'Laki-Laki' : 'Perempuan' ?></td>
                    <td><?= htmlspecialchars($row['alamat']) ?></td>
                    <td><?= htmlspecialchars($row['no_telp']) ?></td>
                    <td>
                        <button id="<?= $row['id'] ?>" class="btn btn-success btn-sm edit_data">
                            <i class="fa fa-edit"></i> Edit
                        </button>
                        <button id="<?= $row['id'] ?>" class="btn btn-danger btn-sm hapus_data">
                            <i class="fa fa-trash"></i> Hapus
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="7" class="text-center">Tidak ada data ditemukan</td></tr>
        <?php endif; ?>
    </tbody>
</table>

