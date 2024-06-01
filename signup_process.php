<?php
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
$prenom = $_POST['prenom'];
$nom = $_POST['nom'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_BCRYPT);
$adresse_ligne1 = $_POST['adresse1'];
$adresse_ligne2 = $_POST['adresse2'] ?? ''; // Champs optionnel
$ville = $_POST['ville'];
$codePost = $_POST['code-postal'];
$pays = $_POST['pays'];
$telephone = $_POST['telephone'];
$carte_vitale = $_POST['cartev'];
$type = $_POST['type']; // Récupérer le type de profil

// Vérifier si l'adresse e-mail est valide pour un compte admin
if ($type === 'admin' && !preg_match('/@omnesadmin\.fr$/', $email)) {
    die("Erreur: Les administrateurs doivent avoir une adresse e-mail se terminant par @omnesadmin.fr");
}

// Préparer et exécuter la requête d'insertion en utilisant des instructions préparées
$stmt = $conn->prepare("INSERT INTO users (prenom, nom, email, mdp, adresse_ligne1, adresse_ligne2, ville, codePost, pays, telephone, carte_vitale, type) 
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

if ($stmt === false) {
    die("Erreur lors de la préparation de la requête: " . $conn->error);
}

$stmt->bind_param("ssssssssssss", $prenom, $nom, $email, $password, $adresse_ligne1, $adresse_ligne2, $ville, $codePost, $pays, $telephone, $carte_vitale, $type);

if ($stmt->execute()) {
    header("Location: signin.html");
} else {
    echo "Error: " . $stmt->error;
}

// Fermer la requête et la connexion
$stmt->close();
$conn->close();
?>
