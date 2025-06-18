<?php

$server = "localhost";
$user = "root";
$pass = "";
$db = "filmclub";

try {

    $conn = new PDO("mysql:host=$server;dbname=$db", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    $sql_films = "SELECT * FROM film";
    $stmt_films = $conn->prepare($sql_films);
    $stmt_films->execute();
    $films = $stmt_films->fetchAll(PDO::FETCH_ASSOC);


    $sql_beoordelingen = "SELECT * FROM beoordeling";
    $stmt_beoordelingen = $conn->prepare($sql_beoordelingen);
    $stmt_beoordelingen->execute();
    $beoordelingen = $stmt_beoordelingen->fetchAll(PDO::FETCH_ASSOC);


    $film_beoordelingen = [];

    foreach ($films as $film) {
        $film_beoordelingen[$film['id']] = [
            'titel' => $film['titel'],
            'genre' => $film['genre'],
            'beoordelingen' => [],
            'gemiddelde' => 0
        ];
    }


    foreach ($beoordelingen as $beoordeling) {
        $film_beoordelingen[$beoordeling['film_id']]['beoordelingen'][] = $beoordeling['cijfer'];
    }


    foreach ($film_beoordelingen as $film_id => $film_data) {
        $cijfers = $film_data['beoordelingen'];
        if (count($cijfers) > 0) {
            $film_beoordelingen[$film_id]['gemiddelde'] = array_sum($cijfers) / count($cijfers);
        }
    }

} catch(PDOException $e) {
    echo "Fout: " . $e->getMessage();
}

$conn = null;
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Films en Beoordelingen</title>
</head>
<body>
<h1>Alle Films</h1>
<table border="1">
    <tr>
        <th>Titel</th>
        <th>Genre</th>
        <th>Gemiddelde Beoordeling</th>
    </tr>

    <?php foreach ($film_beoordelingen as $film_id => $film): ?>
        <tr>
            <td><?php echo htmlspecialchars($film['titel']); ?></td>
            <td><?php echo htmlspecialchars($film['genre']); ?></td>
            <td><?php echo number_format($film['gemiddelde'], 1); ?></td>
        </tr>
    <?php endforeach; ?>
</table>
</body>
</html>
