<?php

//Seorang guru Bahasa Inggris ingin menghitung total nilai ujian dari 12 siswa di kelasnya. 
//Untuk membuat penilaian lebih adil, guru memutuskan untuk mengabaikan dua nilai tertinggi 
//dan dua nilai terendah dari daftar nilai yang ada. Setelah itu, guru akan
//menghitung total nilai dari sisa siswa untuk digunakan dalam menentukan rata-rata kelas.
//Nilai yang diperoleh 12 siswa tersebut adalah: 80, 95, 67, 72, 88, 91, 76, 84, 69, 93, 78, dan 85.

$nilaiSiswa = [80, 95, 67, 72, 88, 91, 76, 84, 69, 93, 78, 85];

$max1 = $max2 = $nilaiSiswa[0];
$min1 = $min2 = $nilaiSiswa[0];

       
foreach ($nilaiSiswa as $nilai) {
        
if ($nilai > $max1) {
    $max2 = $max1;
    $max1 = $nilai;
} elseif ($nilai > $max2) {
    $max2 = $nilai;
}

if ($nilai < $min1) {
    $min2 = $min1;
    $min1 = $nilai;
} elseif ($nilai < $min2) {
    $min2 = $nilai;
}
 }
        
$totalNilai = 0;
    
foreach ($nilaiSiswa as $nilai) {
    if ($nilai != $max1 && $nilai != $max2 && $nilai != $min1 && $nilai != $min2) {
        $totalNilai += $nilai;
    }
}

echo "<p>Total nilai yang digunakan (setelah mengabaikan dua nilai tertinggi dan dua nilai terendah) adalah: $totalNilai</p>";

?>