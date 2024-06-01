<?php
// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $nom = $_POST['nom']; // Remplacez 'nom' par les autres champs du médecin si nécessaire

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

    // Insertion du médecin dans la base de données
    $sql_insert_medecin = "INSERT INTO medecin (nom) VALUES ('$nom')"; // Ajoutez d'autres champs si nécessaire
    if ($conn->query($sql_insert_medecin) === TRUE) {
        echo "Nouveau médecin ajouté avec succès.";
    } else {
        echo "Erreur lors de l'ajout du médecin : " . $conn->error;
    }

    // Fermer la connexion à la base de données
    $conn->close();
}
?>
