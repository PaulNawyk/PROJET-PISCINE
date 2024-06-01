<?php
session_start();

// Vérifier si l'utilisateur est connecté en tant qu'admin
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: signin.html"); // Rediriger vers la page de connexion si l'utilisateur n'est pas un admin
    exit();
}

// Vérifier si le formulaire d'ajout de médecin a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Connexion à la base de données
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "medicare";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Vérification de la connexion
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Récupérer les données du formulaire
    $nom = $_POST['nom'];

    // Récupérer l'ID de l'utilisateur associé au médecin
    $user_id = $_POST['user_id'];

    // Préparer et exécuter la requête d'insertion
    $sql_insert_medecin = "INSERT INTO medecin (user_id) VALUES ('$user_id')";

    if ($conn->query($sql_insert_medecin) === TRUE) {
        echo "Médecin ajouté avec succès.";
    } else {
        echo "Erreur lors de l'ajout du médecin : " . $conn->error;
    }

    // Fermer la connexion à la base de données
    $conn->close();
}
?>
