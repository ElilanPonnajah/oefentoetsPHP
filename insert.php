<?php

try {
    $pdo = new PDO('mysql:host=localhost;dbname=filmclub', 'root', ''); // Pas de gegevens aan als nodig
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Kan geen verbinding maken met de database: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titel = $_POST['titel'];
    $genre = $_POST['genre'];


    if (empty($titel) || empty($genre)) {
        $error = "Titel en genre zijn verplicht.";
    } else {

        $stmt = $pdo->prepare("SELECT * FROM film WHERE titel = ?");
        $stmt->execute([$titel]);
        $film = $stmt->fetch();

        if ($film) {
            $error = "Film met deze titel bestaat al.";
        } else {

            $stmt = $pdo->prepare("INSERT INTO film (titel, genre) VALUES (?, ?)");
            $stmt->execute([$titel, $genre]);
            $success = "Film '$titel' succesvol toegevoegd!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Film toevoegen</title>
</head>
<body>
<h1>Film toevoegen</h1>

<?php if (isset($error)): ?>
    <p ><?php echo htmlspecialchars($error); ?></p>
<?php endif; ?>

<?php if (isset($success)): ?>
    <p ><?php echo htmlspecialchars($success); ?></p>
<?php endif; ?>

<form method="POST">
    <label for="titel">Titel:</label><br>
    <input type="text" name="titel" id="titel" required><br><br>
    <label for="genre">Genre:</label><br>
    <input type="text" name="genre" id="genre" required><br><br>
    <button type="submit">Voeg film toe</button>
    <p><a href="index.php">Terug naarr hoofdpagina</a></p>
</form>
</body>
</html>
