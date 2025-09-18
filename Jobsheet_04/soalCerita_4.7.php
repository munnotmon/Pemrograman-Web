<?php

//Seorang pembeli ingin membeli sebuah jaket dengan harga Rp 250.000.
//Toko memberikan potongan harga sebesar 15% untuk setiap pembelian di atas Rp 200.000.
//Hitunglah berapa jumlah uang yang harus dibayar pembeli tersebut setelah mendapatkan diskon.

$hargaAwal = 250000;
$diskonPersen = 15;

if ($hargaAwal > 200000) {
    $nilaiDiskon = ($diskonPersen / 100) * $hargaAwal;
    $hargaSetelahDiskon = $hargaAwal - $nilaiDiskon;
} else {
    $hargaSetelahDiskon = $hargaAwal;
}

echo "Harga produk awal: Rp " . number_format($hargaAwal) ."<br>" ;
echo "Persentase diskon: " . $diskonPersen ."<br>";
echo "Harga setelah diskon: Rp " . number_format($hargaSetelahDiskon) ."<br>";

?>