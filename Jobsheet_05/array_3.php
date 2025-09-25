<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="style.css"/>
    </head>
<body>

    <h2>Multidimensional Array</h2>
<table>
    <tr>
        <th>Judul Film</th>
        <th>Tahun</th>
        <th>Rating</th>
    </tr>
    <?php
        $movie = array(
                        array("Mencuri Raden Saleh", 2022, 4.9),
                        array("Miracle in Cell No. 7", 2022, 4.9),
                        array("Sore: Istri dari Masa Depan", 2025, 4.7),
                        array("Ada Cinta di SMA", 2016, 3.5)
                    );

            echo "<tr>";
                echo "<td>" . $movie[0][0] . "</td>";
                echo "<td>" . $movie[0][1] . "</td>";
                echo "<td>" . $movie[0][2] . "</td>";
            echo "</tr>";

            echo "<tr>";
                echo "<td>" . $movie[1][0] . "</td>";
                echo "<td>" . $movie[1][1] . "</td>";
                echo "<td>" . $movie[1][2] . "</td>";
            echo "</tr>";

            echo "<tr>";
                echo "<td>" . $movie[2][0] . "</td>";
                echo "<td>" . $movie[2][1] . "</td>";
                echo "<td>" . $movie[2][2] . "</td>";
            echo "</tr>";

            echo "<tr>";
                echo "<td>" . $movie[3][0] . "</td>";
                echo "<td>" . $movie[3][1] . "</td>";
                echo "<td>" . $movie[3][2] . "</td>";
            echo "</tr>";
            
            ?>
        </table>
    </body>
</html>