<?php
session_start();

// verif admin
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: signin.html"); 
    exit();
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "medicare";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // check co
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // recup data formulaire
    $nom = $_POST['nom'];

    // recup id
    $user_id = $_POST['user_id'];

    $sql_insert_medecin = "INSERT INTO medecin (user_id) VALUES ('$user_id')";

    if ($conn->query($sql_insert_medecin) === TRUE) {
        echo "Médecin ajouté avec succès.";
    } else {
        echo "Erreur lors de l'ajout du médecin : " . $conn->error;
    }

    $conn->close();
}
?>
