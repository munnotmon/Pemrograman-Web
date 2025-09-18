<?php
$a = 10;
$b = 5;

$hasilTambah = $a + $b;
$hasilKurang = $a - $b;
$hasilKali = $a * $b;
$hasilBagi = $a / $b;
$sisaBagi = $a % $b;
$pangkat = $a ** $b;

//kode tambahan untuk menampilkan hasil
echo("hasil pertambahan = $hasilTambah <br>");
echo("hasil pengurangan = $hasilKurang <br>");
echo("hasil perkalian = $hasilKali <br>");
echo("hasil pembagian = $hasilBagi <br>");
echo("hasil sisa bagi = $sisaBagi <br>");
echo("hasil pangkat = $pangkat <br>");

echo "<br>";

$hasilSama = $a == $b;
$hasilTidakSama = $a != $b;
$hasilLebihKecil = $a < $b;
$hasilLebihBesar = $a > $b;
$hasilLebihKecilSama = $a <= $b;
$hasilLebihBesarSama = $a >= $b;

//kode tambahan untuk menampilkan hasil
echo("hasil Sama = $hasilSama <br>");
echo("hasil Tidak Sama = $hasilTidakSama <br>");
echo("hasil Lebih Kecil= $hasilLebihKecil <br>");
echo("hasil Lebih Besar = $hasilLebihBesar <br>");
echo("hasil Lebih Kecil Sama dengan = $hasilLebihKecilSama <br>");
echo("hasil Lebih Besar Sama dengan = $hasilLebihBesarSama <br>");

echo "<br>";

$hasilAnd = $a && $b;
$hasilOr = $a || $b;
$hasilNotA = !$a;
$hasilNotB = !$b;

//kode tambahan untuk menampilkan hasil
echo("hasil dari And = $hasilAnd <br>");
echo("hasil dari Or = $hasilOr <br>");
echo("hasil Not A = $hasilNotA <br>");
echo("hasil Not B = $hasilNotB <br>");

echo "<br>";

$a += $b;
//kode tambahan untuk menampilkan hasil
$hasilTambahA = $a;
echo("Hasil A adalah = $hasilTambahA<br>");

$a -= $b;
//kode tambahan untuk menampilkan hasil
$hasilKurangA = $a;
echo("Hasil A adalah = $hasilKurangA<br>");

$a *= $b;
//kode tambahan untuk menampilkan hasil
$hasilKaliA = $a;
echo("Hasil A adalah = $hasilKaliA<br>");

$a /= $b;
//kode tambahan untuk menampilkan hasil
$hasilBagiA = $a;
echo("Hasil A adalah = $hasilBagiA<br>");

echo "<br>";

$hasilIdentik = $a === $b;
$hasilTidakIdentik = $a !== $b;

//kode tambahan untuk menampilkan hasil
echo("Hasil Identik = $hasilIdentik<br>");
echo("Hasil Tidak Identik = $hasilTidakIdentik<br>");
?>