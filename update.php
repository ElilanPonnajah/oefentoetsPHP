<?php

$server = "localhost";
$user = "root";
$pass = "";
$db = "filmclub";

try {

    $conn = new PDO("mysql:host=$server;dbname=$db", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    $film_id = $_GET['id'];


    $sql = "SELECT * FROM film WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':id' => $film_id]);
    $film = $stmt->fetch(PDO::FETCH_ASSOC);


    if (!$film) {
        echo "Film niet gevonden.";
        exit;
    }


    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $titel = $_POST['titel'];
        $genre = $_POST['genre'];


        $sql_update = "UPDATE film SET titel = :titel, genre = :genre WHERE id = :id";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->execute([':titel' => $titel, ':genre' => $genre, ':id' => $film_id]);


        header("Location: index.php");
        exit;
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
    <title>Film bewerken</title>
</head>
<body>
<h1>Film bewerken</h1>
<form method="post">
    <label for="titel">Titel:</label>
    <input type="text" id="titel" name="titel" value="<?php echo htmlspecialchars($film['titel']); ?>" required>
    <br>
    <label for="genre">Genre:</label>
    <input type="text" id="genre" name="genre" value="<?php echo htmlspecialchars($film['genre']); ?>" required>
    <br>
    <input type="submit" value="Bewerken">
</form>
<p><a href="index.php">Terug naarr hoofdpagina</a></p>
</body>
</html>

