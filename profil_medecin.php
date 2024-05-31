<?php
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

// Vérification si l'ID du médecin est passé en paramètre
if(isset($_GET['id'])) {
    $medecin_id = $_GET['id'];

    // Requête SQL pour récupérer les informations du médecin
    $sql = "SELECT m.id, u.nom, u.prenom, m.photo, m.cv, s.nom as specialite 
            FROM medecin m
            JOIN users u ON m.user_id = u.id
            JOIN specialites s ON m.specialite_id = s.id
            WHERE m.id = $medecin_id";
    
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Affichage des informations du médecin
        $row = $result->fetch_assoc();
        $nom = $row['nom'];
        $prenom = $row['prenom'];
        $photo = $row['photo'];
        $cv = $row['cv'];
        $specialite = $row['specialite'];

        echo "<h2>Profil du Dr. $nom $prenom</h2>";
        echo "<p><strong>Spécialité :</strong> $specialite</p>";
        echo "<img src='$photo' alt='Photo du médecin' width='200'>";
        echo "<h3>Curriculum Vitae :</h3>";
        echo "<p>$cv</p>";
    } else {
        echo "Aucun médecin trouvé avec cet identifiant.";
    }
} else {
    echo "Aucun identifiant de médecin spécifié.";
}
?>

