<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "medicare";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $medecin_id = intval($_POST['medecin_id']);
    $date = $_POST['date'];
    $heure = $_POST['heure'];

    $stmt = $conn->prepare("DELETE FROM disponibilites WHERE medecin_id = ? AND jour = ? AND heure_debut <= ? AND heure_fin > ?");
    $stmt->bind_param("isss", $medecin_id, $date, $heure, $heure);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false]);
    }

    $stmt->close();
    $conn->close();
}
?>
