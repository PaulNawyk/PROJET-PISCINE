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

// Vérifier si une recherche a été soumise
if (isset($_POST['search'])) {
    $search_query = $_POST['search'];

    // Requête SQL pour rechercher par nom de médecin
    $sql = "SELECT m.id, u.nom 
            FROM medecin m
            JOIN users u ON m.user_id = u.id
            WHERE u.nom LIKE '%" . $search_query . "%'";

    $result = $conn->query($sql);

    // Afficher les résultats de la recherche
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<p><a href='profil_medecin.php?id=" . $row["id"] . "'>" . $row["nom"] . "</a></p>";
        }
    } else {
        echo "Aucun résultat trouvé.";
    }
}
?>
