<?php
session_start();

// verifz user co
if (!isset($_SESSION['user_id'])) {
    header("Location: signin.html");
    exit();
}

// connexion à la base de donne
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "medicare";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//requete SQL 
$sql_generalistes = "SELECT m.id, u.nom 
                     FROM medecin m
                     JOIN users u ON m.user_id = u.id
                     WHERE m.specialite_id = 1";
$stmt_generalistes = $conn->prepare($sql_generalistes);
$stmt_generalistes->execute();
$result_generalistes = $stmt_generalistes->get_result();

// requete sql
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
    <link href="base.css" rel="stylesheet" type="text/css">
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
            if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'admin') {
                echo '<a href="page_admin.php" class="btn btn-primary ml-3">Bouton Exclusif Admin</a>';
            }
            ?>
        </div>
        
        <div id="section">
            <div class="presentation">
                <p>
                    <span style="font-size: 1.2em;">Bienvenue sur Medicare,</span><br>
                    <span style="font-size: 1.1em;">Votre nouvelle plateforme de santé en ligne !</span> <br><br>
                </p>
                <p>Nous sommes ravis de vous accueillir sur Medicare, votre partenaire de confiance pour toutes vos consultations médicales et services de santé en ligne.</p>
                <p>Chez Medicare, notre mission est de rendre l'accès aux soins plus simple, rapide et efficace pour tous. Grâce à notre interface intuitive et notre vaste réseau de professionnels de santé qualifiés, vous pouvez désormais prendre rendez-vous, consulter vos résultats médicaux et obtenir des conseils de santé personnalisés en quelques clics.</p>
                <p>Explorez dès maintenant les nombreuses fonctionnalités de Medicare et découvrez comment nous pouvons vous aider à mieux gérer votre santé au quotidien. Merci de nous faire confiance pour vos besoins médicaux. Nous sommes ici pour vous accompagner à chaque étape de votre parcours de santé.</p>
                <p>
                    <span style="font-size: 1em;">Bienvenue chez Medicare, où votre bien-être est notre priorité.</span> <br>
                </p>
            </div>

            <div id="myCarousel" class="carousel slide" data-ride="carousel">
                <ul class="carousel-indicators">
                    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                    <li data-target="#myCarousel" data-slide-to="1"></li>
                    <li data-target="#myCarousel" data-slide-to="2"></li>
                </ul>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="row no-gutters">
                            <div class="col-4">
                                <img class="rounded mx-auto d-block" src="img/carrousel1.jpg" alt="Image 1">
                            </div>
                            <div class="col-4">
                                <img class="rounded mx-auto d-block" src="img/carrousel2.jpg" alt="Image 2">
                            </div>
                            <div class="col-4">
                                <img class="rounded mx-auto d-block" src="img/carrousel3.jpg" alt="Image 3">
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="row no-gutters">
                            <div class="col-4">
                                <img class="rounded mx-auto d-block" src="img/carrousel4.jpg" alt="Image 4">
                            </div>
                            <div class="col-4">
                                <img class="rounded mx-auto d-block" src="img/carrousel5.jpg" alt="Image 5">
                            </div>
                            <div class="col-4">
                                <img class="rounded mx-auto d-block" src="img/carrousel6.jpg" alt="Image 6">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="wrapper2">
                <div><img class="evenement" src="img/covid.jpg" alt="COVID-19"></div>
                <div id="description">
                    <h1 class="titre">COVID-19</h1>
                    La recrudescence récente du COVID-19 suscite à nouveau des inquiétudes à travers le monde. Alors que de nombreux pays avaient réussi à maîtriser la propagation du virus grâce à des campagnes de vaccination massives et à des mesures sanitaires strictes, une nouvelle vague d'infections rappelle que la pandémie est loin d'être terminée.
                </div>
            </div>
            <div id="wrapper2">
                <div><img class="evenement" src="img/poux.jpeg" alt="Poux"></div>
                <div id="description">
                    <h1 class="titre">Apparition de Poux :</h1>
                    <h2>Une Préoccupation Croissante</h2>
                    Récemment, plusieurs écoles élémentaires ont signalé une recrudescence des cas de poux parmi les élèves. Ce phénomène, bien que courant, suscite des inquiétudes tant chez les parents que chez les enseignants, en raison de la rapidité avec laquelle ces parasites peuvent se propager dans des environnements où les enfants sont en contact étroit.
                </div>
                
            </div>
            <div id="map-section" class="my-4">
                    Retrouvez nous 10 Rue Sexitus Michel :
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d5250.7452444036135!2d2.2885375999999997!3d48.8511045!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47e6701b486bb253%3A0x61e9cc6979f93fae!2s10%20Rue%20Sextius%20Michel%2C%2075015%20Paris!5e0!3m2!1sfr!2sfr!4v1717347703773!5m2!1sfr!2sfr" width="400" height="auto" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
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
