<!DOCTYPE html>

<html>
<head>
</head>
<body>


<h2>Array Terindeks dengan loop</h2>
<?php

$listmahasiswa=["Maulida Aprina Putri", "Anjali Violita Pramestri", "R. Rawdhoh Ardhillah"];

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