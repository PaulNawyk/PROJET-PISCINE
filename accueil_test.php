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
<html>

<head>
    <title>Medicare</title>
    <meta charset="utf-8" />
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link href="base.css" rel="stylesheet" type="text/css" />
</head>

<body>
    <div id="wrapper">
        <div id="header">Medicare : Services Médicaux</div>
        <div id="navigation" class="d-flex align-items-center">
            <button class="btn btn-default mx-3">ACCUEIL</button>
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
                                    echo "<li><a href='profil_medecin.php?id=" . $row["id"] . "'>" . $row["nom"] . "</a></li>";
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
                                    echo "<li><a href='profil_medecin.php?id=" . $row_specialiste["id"] . "'>" . $row_specialiste["nom"] . " - " . $row_specialiste["specialite_nom"] . "</a></li>";
                                }
                            }
                            ?>
                        </ul>
                    </li>
                    <li class="dropdown-submenu">
                        <a class="dropdown-item dropdown-toggle" href="#">Laboratoire</a>
                        <ul class="dropdown-menu">
                            <li><a href="labo.php">Laboratoire de biologie médicale</a></li>
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
            <div class="presentation">
                Bienvenue sur Medicare,<br> Votre nouvelle plateforme de santé en ligne ! <br><br>
                Nous sommes ravis de vous accueillir sur Medicare, votre partenaire de confiance pour toutes vos consultations médicales et services de santé en ligne. Chez Medicare, notre mission est de rendre l'accès aux soins plus simple, rapide et efficace pour tous. Grâce à notre interface intuitive et notre vaste réseau de professionnels de santé qualifiés, vous pouvez désormais prendre rendez-vous, consulter vos résultats médicaux et obtenir des conseils de santé personnalisés en quelques clics.<br><br>
                Explorez dès maintenant les nombreuses fonctionnalités de Medicare et découvrez comment nous pouvons vous aider à mieux gérer votre santé au quotidien. Merci de nous faire confiance pour vos besoins médicaux. Nous sommes ici pour vous accompagner à chaque étape de votre parcours de santé.<br><br>
                Bienvenue chez Medicare, où votre bien-être est notre priorité. <br>
            </div>
            <div id="myCarousel" class="carousel slide" data-ride="carousel">
                <ul class="carousel-indicators">
                    <li data-target="#demo" data-slide-to="0" class="active"></li>
                    <li data-target="#demo" data-slide-to="1"></li>
                    <li data-target="#demo" data-slide-to="2"></li>
                </ul>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="row no-gutters">
                            <div class="col-4">
                                <img class="rounded mx-auto d-block" src="img/carrousel1.jpg">
                            </div>
                            <div class="col-4">
                                <img class="rounded mx-auto d-block" src="img/carrousel2.jpg">
                            </div>
                            <div class="col-4">
                                <img class="rounded mx-auto d-block" src="img/carrousel3.jpg">
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="row no-gutters">
                            <div class="col-4">
                                <img class="rounded mx-auto d-block" src="img/carrousel4.jpg">
                            </div>
                            <div class="col-4">
                                <img class="rounded mx-auto d-block" src="img/carrousel5.jpg">
                            </div>
                            <div class="col-4">
                                <img class="rounded mx-auto d-block" src="img/carrousel6.jpg">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="wrapper2">
                <div>
                    <img class="evenement" src="img/covid.jpg" />
                </div>
                <div id="description">
                    <h1 class="titre">COVID-19</h1>
                    La recrudescence récente du COVID-19 suscite à nouveau des inquiétudes à travers le monde. Alors que de nombreux pays avaient réussi à maîtriser la propagation du virus grâce à des campagnes de vaccination massives et à des mesures sanitaires strictes, une nouvelle vague d'infections rappelle que la pandémie est loin d'être terminée.
                </div>
            </div>
            <div id="footer">
                Pour nous contacter : medicare.paris@soin.fr ; Par téléphone : +33 6 76 89 90 10
            </div>
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
