<?php
session_start();

// Configurer la connexion à la base de données
$servername = "localhost";
$username = "root"; // Votre nom d'utilisateur MySQL
$password = "root"; // Votre mot de passe MySQL
$dbname = "medicare";

// Créer la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Récupérer les données du formulaire
$email = $_POST['email'];
$password = $_POST['password'];

// Préparer et exécuter la requête de sélection
$sql = "SELECT * FROM users WHERE email='$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Récupérer le hash du mot de passe
    $row = $result->fetch_assoc();
    $hash = $row['mdp'];

    // Vérifier le mot de passe
    if (password_verify($password, $hash)) {
        // Identifiants corrects
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['user_email'] = $row['email'];
        header("Location: accueil.html"); // Rediriger vers la page de destination
        exit();
    } else {
        // Mot de passe incorrect
        echo "Mot de passe incorrect";
    }
} else {
    // Email non trouvé
    echo "Email non trouvé";
}

// Fermer la connexion
$conn->close();
?>
