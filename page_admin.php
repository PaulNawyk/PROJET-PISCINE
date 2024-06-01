<?php
session_start();

// Vérifier si l'utilisateur est connecté en tant qu'admin
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: signin.html"); // Rediriger vers la page de connexion si l'utilisateur n'est pas un admin
    exit();
}

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

// Suppression d'un médecin
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $medecin_id = $_GET['delete'];
    $sql_delete = "DELETE FROM medecin WHERE id = $medecin_id";
    if ($conn->query($sql_delete) === TRUE) {
        echo "Médecin supprimé avec succès.";
    } else {
        echo "Erreur lors de la suppression du médecin : " . $conn->error;
    }
}

// Affichage de la liste des médecins
$sql_select_medecins = "SELECT * FROM medecin";
$result_medecins = $conn->query($sql_select_medecins);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Panel Admin</title>
</head>
<body>
    <h2>Panel Admin</h2>

    <!-- Liste des médecins -->
    <h3>Médecins existants :</h3>
    <ul>
        <?php
        if ($result_medecins->num_rows > 0) {
            while ($row = $result_medecins->fetch_assoc()) {
                echo "<li>{$row['nom']} - <a href='page_admin.php?delete={$row['id']}'>Supprimer</a></li>";
            }
        } else {
            echo "Aucun médecin trouvé.";
        }
        ?>
    </ul>

    <h2>Ajouter un médecin</h2>
    <form action="add_doctor.php" method="post">
        <label for="nom">Nom du médecin:</label><br>
        <input type="text" id="nom" name="nom"><br>
        <label for="user_id">ID de l'utilisateur associé:</label><br>
        <input type="text" id="user_id" name="user_id"><br>
        <input type="submit" value="Ajouter médecin">
    </form>
</body>
</html>

<?php
// Fermer la connexion à la base de données
$conn->close();
?>
