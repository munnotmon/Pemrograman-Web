<!DOCTYPE html>

<html>
<head>
</head>
<body>


<h2>Array Terindeks</h2>
<?php

$listmahasiswa=["R. Rawdhoh Ardhillah", "Maulida Aprina Putri", "Anjali Violita Pramestri"];

/*
echo $listmahasiswa[2] . "<br>";
echo $listmahasiswa[0] . "<br>";
echo $listmahasiswa[1] . "<br>";
*/

foreach ($listmahasiswa as $mahasiswa) {
    echo $mahasiswa . "<br>";
}

?>
</body>
</html>