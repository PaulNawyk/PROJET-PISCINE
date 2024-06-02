<?php
$servername = "localhost";
$username = "root"; 
$password = "root"; 
$dbname = "medicare";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$prenom = $_POST['prenom'];
$nom = $_POST['nom'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_BCRYPT);
$adresse_ligne1 = $_POST['adresse1'];
$adresse_ligne2 = $_POST['adresse2'] ?? '';
$ville = $_POST['ville'];
$codePost = $_POST['code-postal'];
$pays = $_POST['pays'];
$telephone = $_POST['telephone'];
$carte_vitale = $_POST['cartev'];
$type = $_POST['type']; 

if ($type === 'admin' && !preg_match('/@omnesadmin\.fr$/', $email)) {
    die("Erreur: Les administrateurs doivent avoir une adresse e-mail se terminant par @omnesadmin.fr");
}

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

$stmt->close();
$conn->close();
?>
