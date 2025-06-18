<?php

$server = "localhost";
$user = "root";
$pass = "";
$db = "filmclub";

try {

    $conn = new PDO("mysql:host=$server;dbname=$db", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    $film_id = $_GET['id'];


    $sql = "DELETE FROM film WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':id' => $film_id]);


    header("Location: index.php");
    exit;

} catch(PDOException $e) {
    echo "Fout: " . $e->getMessage();
}

$conn = null;
?>

