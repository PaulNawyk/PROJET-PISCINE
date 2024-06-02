<?php
session_start();

// Vérifiez si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: signin.html");
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
// Assuming the user's ID is stored in the session after login
$user_id = $_SESSION['user_id'];

// Fetch user data
$sql = "SELECT * FROM users WHERE id = $user_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "No user found";
    exit;
}
// Requête SQL pour sélectionner les noms des médecins généralistes
$sql_generalistes = "SELECT m.id, u.nom 
                     FROM medecin m
                     JOIN users u ON m.user_id = u.id
                     WHERE m.specialite_id = 1";
$stmt_generalistes = $conn->prepare($sql_generalistes);
$stmt_generalistes->execute();
$result_generalistes = $stmt_generalistes->get_result();

// Requête SQL pour sélectionner les noms des médecins spécialistes
$sql_specialistes = "SELECT m.id, u.nom, s.nom AS specialite_nom 
                     FROM medecin m
                     JOIN users u ON m.user_id = u.id
                     JOIN specialites s ON m.specialite_id = s.id
                     WHERE m.specialite_id != 1";
$stmt_specialistes = $conn->prepare($sql_specialistes);
$stmt_specialistes->execute();
$result_specialistes = $stmt_specialistes->get_result();


$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medicare</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="profil.css" rel="stylesheet" type="text/css">
</head>

<body>
    <div id="wrapper">
        <div id="header">
            <div id="wrapperlogo">
                <div class="header-text">
                    <h1>MEDICARE</h1>
                    <h2>Services Médicaux</h2>
                </div>
                <div><img class="logo" src="img/logo.jpg" alt="Logo"></div>
            </div>
        </div>

        <div id="navigation" class="d-flex align-items-center">
        <button class="btn btn-default mx-3" onclick="window.location.href='accueil_test.php'">ACCUEIL</button>
            <div class="dropdown">
                <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown">
                    PARCOURIR
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                    <li class="dropdown-submenu">
                        <a class="dropdown-item dropdown-toggle" href="#">Médecin Généraliste</a>
                        <ul class="dropdown-menu">
                            <?php
                            // Affichage des noms des médecins généralistes
                            if ($result_generalistes->num_rows > 0) {
                                while ($row = $result_generalistes->fetch_assoc()) {
                                    echo "<li><a class='dropdown-item' href='profil_medecin.php?id=" . $row["id"] . "'>" . $row["nom"] . "</a></li>";
                                }
                            }
                            ?>
                        </ul>
                    </li>
                    <li class="dropdown-submenu">
                        <a class="dropdown-item dropdown-toggle" href="#">Médecin Spécialiste</a>
                        <ul class="dropdown-menu">
                            <?php
                            // Affichage des noms des médecins spécialistes
                            if ($result_specialistes->num_rows > 0) {
                                while ($row_specialiste = $result_specialistes->fetch_assoc()) {
                                    echo "<li><a class='dropdown-item' href='profil_medecin.php?id=" . $row_specialiste["id"] . "'>" . $row_specialiste["nom"] . " - " . $row_specialiste["specialite_nom"] . "</a></li>";
                                }
                            }
                            ?>
                        </ul>
                    </li>
                    <li class="dropdown-submenu">
                        <a class="dropdown-item dropdown-toggle" href="#">Laboratoire</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="labo.php">Laboratoire de biologie médicale</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <button class="btn btn-default ml-3" onclick="window.location.href='rendezvous.php'">RENDEZ-VOUS</button>
            <button class="btn btn-default ml-3" onclick="window.location.href='profil.php'">PROFIL</button>
            <form action="recherche.php" method="POST" class="d-flex mx-3">
                <input id="searchbar" class="form-control" type="text" name="search" placeholder="RECHERCHE..." style="width: 90%;">
            </form>
            <img src="img/loupe.jpg" alt="LOGO" width="30" height="30">
            <?php
            // Afficher le bouton exclusif pour les admins
            if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'admin') {
                echo '<a href="page_admin.php" class="btn btn-primary ml-3">Bouton Exclusif Admin</a>';
            }
            ?>
        </div>
        
        <div id="section">
        <div id="section">
            <h1>Profil Utilisateur</h1>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $user['prenom'] . ' ' . $user['nom']; ?></h5>
                    <p class="card-text">Adresse: <?php echo $user['adresse_ligne1'] . ', ' . $user['adresse_ligne2'] . ', ' . $user['ville'] . ', ' . $user['codePost'] . ', ' . $user['pays']; ?></p>
                    <p class="card-text">Email: <?php echo $user['email']; ?></p>
                    <p class="card-text">Téléphone: <?php echo $user['telephone']; ?></p>
                    <p class="card-text">Numéro de carte vitale: <?php echo $user['carte_vitale']; ?></p>
                </div>
            </div>
        </div>
        
        <div id="footer">
            <p>Pour nous contacter : medicare.paris@soin.fr</p>
            <p>Par téléphone : +33 6 76 89 90 10</p>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.dropdown-submenu a.dropdown-toggle').on("click", function(e) {
                if (!$(this).next('ul').hasClass('show')) {
                    $(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
                }
                var $subMenu = $(this).next('ul');
                $subMenu.toggleClass('show');
                $(this).parent('li').toggleClass('show');
                $(this).parents('li.nav-item.dropdown.show').on('hidden.bs.dropdown', function(e) {
                    $('.dropdown-submenu .show').removeClass("show");
                });
                return false;
            });
        });
    </script>
</body>

</html>
