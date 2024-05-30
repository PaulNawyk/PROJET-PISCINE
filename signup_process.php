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
$adresse_ligne2 = ""; // Valeur par défaut vide pour adresse_ligne2
$ville = $_POST['ville'];
$codePost = $_POST['code-postal'];
$pays = $_POST['pays'];
$telephone = $_POST['telephone'];
$carte_vitale = $_POST['cartev'];
$type_carte = ""; // Valeur par défaut vide pour type_carte
$numero_carte = ""; // Valeur par défaut vide pour numero_carte
$nom_carte = ""; // Valeur par défaut vide pour nom_carte
$date_expi = "9999-12-31"; // Valeur par défaut fictive pour date_expi
$code_carte = ""; // Valeur par défaut vide pour code_carte
$type = 'client';

// Préparer et exécuter la requête d'insertion
$sql = "INSERT INTO users (prenom, nom, email, mdp, adresse_ligne1, adresse_ligne2, ville, codePost, pays, telephone, carte_vitale, type_carte, numero_carte, nom_carte, date_expi, code_carte, type) 
VALUES ('$prenom', '$nom', '$email', '$password', '$adresse_ligne1', '$adresse_ligne2', '$ville', '$codePost', '$pays', '$telephone', '$carte_vitale', '$type_carte', '$numero_carte', '$nom_carte', '$date_expi', '$code_carte', '$type')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Fermer la connexion
$conn->close();
?>
