<?php
//Sebuah restoran memiliki 45 kursi di dalamnya. 
//Pada suatu malam, 28 kursi telah ditempati oleh pelanggan. 
//Berapa persen kursi yang masih kosong di restoran tersebut?

$totalRak = 120;
$rakTerisi = 85;
$rakKosong = $totalRak - $rakTerisi;

$persentaseKosong = ($rakKosong / $totalRak) * 100;

echo "<p>Dari total $totalRak rak buku, sebanyak $rakKosong rak buku masih kosong.</p>";
echo "<p>Persentase rak yang masih kosong adalah " . number_format($persentaseKosong, 2) . "%.</p>";

?>