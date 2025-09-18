<?php

//Seorang guru IPA ingin mencetak daftar nilai siswa pada ujian Fisika. Data
//nilai yang dimiliki guru terdiri dari nama dan nilai ujian masing-masing siswa, yaitu Andi
//memperoleh 75, Budi memperoleh 88, Citra memperoleh 95, Dinda memperoleh 70, dan
//Farhan memperoleh 82. Guru tersebut ingin mengetahui siswa-siswa yang mendapatkan nilai
//di atas rata-rata kelas agar dapat diberikan penghargaan. Oleh karena itu, guru perlu
//menghitung rata-rata nilai dari seluruh siswa, kemudian mencetak daftar siswa yang memiliki
//nilai lebih tinggi dari rata-rata beserta nilai yang diperoleh.

$nilaiSiswa = [
    ['Andi', 75],
    ['Budi', 88],
    ['Citra', 95],
    ['Dinda', 70],
    ['Farhan', 82]
];

$totalNilai = 0;
$jumlahSiswa = count($nilaiSiswa);

foreach ($nilaiSiswa as $siswa) {
    $totalNilai += $siswa[1];
}

$rataRataKelas = $totalNilai / $jumlahSiswa;

echo "Rata-rata kelas: " . number_format($rataRataKelas, 2) . "<br>";

echo "Daftar siswa dengan nilai di atas rata-rata:<br>";

foreach ($nilaiSiswa as $siswa) {
    if ($siswa[1] > $rataRataKelas) {
        echo "Nama: {$siswa[0]}, Nilai: {$siswa[1]}<br>";
    }
}

?>
