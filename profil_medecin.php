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
if (isset($_GET['id'])) {
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
        $mail = $row['mail'];
    } else {
        echo "Aucun médecin trouvé avec cet identifiant.";
    }
} else {
    echo "Aucun identifiant de médecin spécifié.";
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Profil Utilisateur</title>
    <meta charset="utf-8" />
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link href="base.css" rel="stylesheet" type="text/css" />
</head>

<body>
    <div id="wrapper">
        <div id="header">Medicare : Services Médicaux</div>
        <div id="navigation" class="d-flex align-items-center">
            <button class="btn btn-default mx-3" onclick="window.location.href='accueil.html'">ACCUEIL</button>
            <div class="dropdown">
                <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown">
                    PARCOURIR
                    <span class="caret"></span>
                </button>
                <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown">
                    PARCOURIR
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                    <li>
                    <li>
                    <li class="dropdown-submenu">
                        <a class="dropdown-item dropdown-toggle" href="#">Médecin Généraliste</a>
                        <ul class="dropdown-menu">
                            <?php
                            // Requête SQL pour sélectionner les noms des médecins généralistes
                            $sql = "SELECT m.id, u.nom 
FROM medecin m
JOIN users u ON m.user_id = u.id
WHERE m.specialite_id = 1";
                            $result = $conn->query($sql);
                            if (!$result) {
                                printf("Erreur : %s\n", $conn->error);
                                exit();
                            }

                            // Affichage des noms des médecins généralistes
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<li><a href='profil_medecin.php?id=" . $row["id"] . "'>" . $row["nom"] . "</a></li>";
                                }
                            }
                            ?> </ul>
                    <li class="dropdown-submenu">
                        <a class="dropdown-item dropdown-toggle" href="#">Médecin Spécialiste</a>
                        <ul class="dropdown-menu">
                            <?php
                            // Requête SQL pour sélectionner les noms des médecins spécialistes
                            $sql_specialistes = "SELECT m.id, u.nom 
                            FROM medecin m
                            JOIN users u ON m.user_id = u.id
                            WHERE m.specialite_id != 1"; // Changer la condition pour sélectionner les spécialistes
                            $result_specialistes = $conn->query($sql_specialistes);
                            if (!$result_specialistes) {
                                printf("Erreur : %s\n", $conn->error);
                                exit();
                            }

                            // Affichage des noms des médecins spécialistes
                            if ($result_specialistes->num_rows > 0) {
                                while ($row_specialiste = $result_specialistes->fetch_assoc()) {
                                    echo "<li><a href='profil_medecin.php?id=" . $row_specialiste["id"] . "'>" . $row_specialiste["nom"] . " - " . $row_specialiste["specialite_nom"] . "</a></li>";
                                }
                            }
                            ?>
                        </ul>
                    </li>

                    <li>
                    <li class="dropdown-submenu">
                        <a class="dropdown-item dropdown-toggle" href="#">Laboratoire</a>
                        <ul class="dropdown-menu">
                            <li>Laboratoire de biologie médicale</a></li>
                        </ul>
                </ul>
            </div>
            <button class="btn btn-default ml-3" onclick="window.location.href='rendezvous.html'">RENDEZ-VOUS</button>
            <button class="btn btn-default ml-3" onclick="window.location.href='profil.php'">PROFIL</button>
            <input id="searchbar" class="form-control mx-3" type="text" name="search" placeholder="RECHERCHE..." style="width: 15%;">
            <img src="img/loupe.jpg" alt="LOGO" width="30" height="30">
        </div>
        <div id="section">
            <h1>Profil Utilisateur</h1>
            <div class="card">
                <div class="card-body">
                    <p class="card-text"> <?php echo "<h2>Profil du Dr. $nom $prenom</h2>"; ?></p>
                    <p class="card-text"> <?php echo "<p><strong>Spécialité :</strong> $specialite</p>"; ?></p>
                    <p class="card-text"> <?php echo "<img src='$photo' alt='Photo du médecin' width='200'>"; ?></p>
                    <p class="card-text"> <?php echo "<h3>CV :</h3>"; ?></p>
                    <p class="card-text"> <?php echo "<p>$cv</p>"; ?></p>
                </div>
            </div>
        </div>
        <div id="footer">
            Pour nous contacter : medicare.paris@soin.fr ; Par téléphone : +33 6 76 89 90 10
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