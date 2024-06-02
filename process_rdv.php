<?php
session_start();

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
    $client_id = $_SESSION['client_id']; // Assurez-vous que le client est connecté

    // Enregistrer le rendez-vous
    $stmt = $conn->prepare("INSERT INTO rendezvous (client_id, medecin_id, date, heure) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiss", $client_id, $medecin_id, $date, $heure);

    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "message" => $stmt->error]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["success" => false, "message" => "Invalid request method."]);
}
?>
