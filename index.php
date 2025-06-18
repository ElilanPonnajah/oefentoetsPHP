<?php


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "filmclub";

try {

    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    $sql = "SELECT * FROM film";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $films = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "<p><a href='insert.php'>voeg een nieuwe film toe</a></p>";


    echo "<h1>alle Films</h1>";
    echo "<table border='1'>
            <tr>
                <th>Titel</th>
                <th>Genre</th>
                <th>Acties</th>
            </tr>";

    foreach ($films as $film) {
        echo "<tr>
                <td>" . htmlspecialchars($film['titel']) . "</td>
                <td>" . htmlspecialchars($film['genre']) . "</td>
                <td>
                    <a href='detail.php?id=" . $film['id'] . "'>bekijk beoordelingen</a> | 
                    <a href='update.php?id=" . $film['id'] . "'>bewerken</a> | 
                    <a href='delete.php?id=" . $film['id'] . "'>verwijderen</a>
                </td>
              </tr>";
    }
    echo "</table>";


    $sql_count = "SELECT COUNT(*) AS total FROM film";
    $stmt_count = $conn->prepare($sql_count);
    $stmt_count->execute();
    $row_count = $stmt_count->fetch(PDO::FETCH_ASSOC);
    echo "<p> aantal films: " . $row_count['total'] . "</p>";

} catch(PDOException $e) {
    echo "Fout: " . $e->getMessage();
}

$conn = null;


?>