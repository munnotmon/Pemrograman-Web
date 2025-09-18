<?php

//koversi nilai numerik
$nilaiNumerik = 92;

if ($nilaiNumerik >= 90 && $nilaiNumerik <= 100) {
    echo "Nilai Huruf: A";
} elseif ($nilaiNumerik >= 80 && $nilaiNumerik < 90) {
    echo "Nilai Huruf: B";
} elseif ($nilaiNumerik >= 70 && $nilaiNumerik < 80) {
    echo "Nilai Huruf: C";
} elseif ($nilaiNumerik < 70) {
    echo "Nilai Huruf: D";
}

echo "<br>";
echo "<br>";

//perulangan while
$jarakSaatIni = 0;
$jarakTarget = 500;
$peningkatanHarian = 30;
$hari = 0;

while ($jarakSaatIni<$jarakTarget) {
    $jarakSaatIni += $jarakTarget;
    $hari++;
}
echo "Atlet tersebut memerlukan $hari hari untuk mencapai jarak 500 Kilometer.";

echo"<br>";
echo "<br>";

//perulangan for
$jumlahLahan = 10;
$tanamanPerLahan = 5;
$buahPerTanaman= 10;
$jumlahBuah = 0;
for ($i=1; $i <=$jumlahLahan ; $i++) { 
    $jumlahBuah+=($tanamanPerLahan*$buahPerTanaman);
}
echo "Jumlah buah yang akan dipanen adalah: $jumlahBuah";

echo"<br>";
echo "<br>";

//perulangan foreach
$skorUjian = [85,92,78,96,88];
$totalSkor = 0;

foreach ($skorUjian as $skor) {
    $totalSkor+=$skor;
}
echo "Total skor ujian adalah: $totalSkor";

echo "<br>";
echo "<br>";

//perulangan dengan break dan continue
$nilaiSiswa = [85,92,58,64,90,55,88,79,70,96];

foreach ($nilaiSiswa as $nilai) {
    if ($nilai<60) {
        echo "Nilai: $nilai (Tidak lulus) <br>";
        continue;
    }
    echo "Nilai: $nilai (Lulus) <br>";
}
?>