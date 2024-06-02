<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: signin.html");
    exit();
}
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "medicare";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$user_id = $_SESSION['user_id'];

$sql = "SELECT r.date, r.heure, u.nom, u.prenom, s.nom as specialite 
        FROM rendezvous r
        JOIN medecin m ON r.medecin_id = m.id
        JOIN users u ON m.user_id = u.id
        JOIN specialites s ON m.specialite_id = s.id
        WHERE r.client_id = ?
        ORDER BY r.date, r.heure";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result_rendezvous = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mes Rendez-vous</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="profil.css" rel="stylesheet">
</head>
<body>
    <div id="wrapper">
        <div id="header">Medicare : Services Médicaux</div>
        <div id="navigation" class="d-flex align-items-center">
            <button class="btn btn-default mx-3" onclick="window.location.href='accueil_test.php'">ACCUEIL</button>
            <button class="btn btn-default ml-3" onclick="window.location.href='profil.php'">PROFIL</button>
        </div>
        <div id="section">
            <h1>Mes Rendez-vous</h1>
            <?php if ($result_rendezvous->num_rows > 0): ?>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Heure</th>
                            <th>Médecin</th>
                            <th>Spécialité</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result_rendezvous->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['date']); ?></td>
                                <td><?php echo htmlspecialchars($row['heure']); ?></td>
                                <td><?php echo htmlspecialchars($row['nom']) . ' ' . htmlspecialchars($row['prenom']); ?></td>
                                <td><?php echo htmlspecialchars($row['specialite']); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Vous n'avez aucun rendez-vous pour le moment.</p>
            <?php endif; ?>
        </div>
    </div>
    <div id="footer">
        Pour nous contacter : medicare.paris@soin.fr ; Par téléphone : +33 6 76 89 90 10
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
 