<?php

//Ada soal cerita : Seorang atlet lari ingin menghitung total jarak yang telah ditempuh selama latihan. 
//Jarak tersebut dihitung dari akumulasi kilometer yang berhasil dicapai setiap harinya.
//Jika total jarak yang ditempuh lebih dari 100 km, maka atlet tersebut akan mendapatkan bonus latihan khusus. 
//Buatlah tampilan pada baris pertama dengan teks “Total jarak tempuh atlet adalah: (kilometer)” 
//dan pada baris kedua dengan teks “Apakah atlet mendapatkan bonus latihan? (YA/TIDAK)”

$jarakHarian = [12, 15, 10, 9, 14, 20, 18, 8]; 

$kilometer = 0;

foreach ($jarakHarian as $jarak) {
    $kilometer += $jarak;
}

$bonusLatihan = ($kilometer > 100) ? 'YA' : 'TIDAK';

echo "Total jarak tempuh atlet adalah: " . number_format($kilometer) . " kilometer <br>";
echo "Apakah atlet mendapatkan bonus latihan? " . $bonusLatihan;

?>