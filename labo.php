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

// Stocker le type d'utilisateur dans la session
session_start();
$_SESSION['user_type'] = $row['type']; // Supposons que le type soit stocké dans la colonne 'type' de votre table 'users'

// Requête SQL pour sélectionner les informations du laboratoire
$sql_labo = "SELECT * FROM laboratoire";
$result_labo = $conn->query($sql_labo);
if (!$result_labo) {
    printf("Erreur : %s\n", $conn->error);
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Medicare</title>
    <meta charset="utf-8" />
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <link href="base.css" rel="stylesheet" type="text/css" />
</head>

<body>
    <div id="wrapper" class="container">
    <div id="header">
            <div id="wrapperlogo">
                <div class="header-text">
                    <h1>MEDICARE </h1>
                    <h2> Services Médicaux</h2>
                </div>
                <div><img class="logo" src="img/logo.jpg" /></div>
                
            </div>
        </div>
        <div id="navigation" class="d-flex align-items-center mb-4 justify-content-between">
            <div>
                <button class="btn btn-default mx-1" onclick="window.location.href='accueil_test.php'">ACCUEIL</button>

                <div class="dropdown d-inline-block">
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
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
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
                                        echo "<li><a class='dropdown-item' href='profil_medecin.php?id=" . $row_specialiste["id"] . "'>" . $row_specialiste["nom"] . "</a></li>";
                                    }
                                }
                                ?>
                            </ul>
                        </li>
                        <li class="dropdown-submenu">
                            <a class="dropdown-item dropdown-toggle" href="#">Laboratoire</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Laboratoire de biologie médicale</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>

                <button class="btn btn-default ml-1">RENDEZ-VOUS</button>
                <button class="btn btn-default ml-1" onclick="window.location.href='profil.php'">PROFIL</button>
            </div>
            <div>
                <form action="recherche.php" method="POST" class="form-inline">
                    <input id="searchbar" class="form-control" type="text" name="search" placeholder="RECHERCHE..." style="width: 300px;">
                    <button type="submit" class="btn btn-default ml-2"><img src="img/loupe.jpg" alt="LOGO" width="30" height="30"></button>
                </form>
            </div>
            <?php
            // Vérifier si l'utilisateur est connecté et s'il est admin
            if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'admin') {
                // Afficher le bouton exclusif pour les admins
                echo '<a href="page_admin.php" class="btn btn-primary ml-3">Bouton Exclusif Admin</a>';
            }
            ?>
        </div>
        <div id="section">
            <div class="presentation mb-5">
                <h2>Coordonnées du Laboratoire</h2>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Salle</th>
                            <th>Téléphone</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result_labo->num_rows > 0) {
                            while ($row_labo = $result_labo->fetch_assoc()) {
                                echo "<tr>
                                    <td>{$row_labo['nom']}</td>
                                    <td>{$row_labo['salle']}</td>
                                    <td>{$row_labo['telephone']}</td>
                                    <td>{$row_labo['email']}</td>
                                </tr>";
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            
            <h2>Services du Laboratoire</h2>
            <div class="row">
                <?php
                if ($result_labo->num_rows > 0) {
                    $result_labo->data_seek(0); // Reset pointer to the start
                    while ($row_labo = $result_labo->fetch_assoc()) {
                        $description = "";
                        switch ($row_labo['nom']) {
                            case 'Depistage':
                                $description = "Le dépistage permet de détecter la présence de maladies infectieuses ou chroniques. Idéal pour prévenir les épidémies et traiter les maladies à un stade précoce.";
                                break;
                            case 'Biologie preventive':
                                $description = "La biologie préventive comprend des analyses visant à prévenir les maladies grâce à des bilans de santé réguliers. Cela inclut des tests de cholestérol, de glycémie, et d'autres paramètres de santé cruciaux.";
                                break;
                            case 'Biologie de la femme enceinte':
                                $description = "Ce service propose des analyses spécifiques pour surveiller la santé de la femme enceinte et le développement du fœtus. Des tests comme l'analyse du sang, le dépistage de maladies génétiques, et le suivi hormonal sont réalisés.";
                                break;
                            case 'Biologie de routine':
                                $description = "La biologie de routine comprend les analyses courantes comme les bilans sanguins, les tests urinaires et autres examens standard. Ces tests sont essentiels pour le suivi régulier de votre état de santé.";
                                break;
                            case 'Cancerologie':
                                $description = "Ce service réalise des tests pour détecter et suivre les cancers, aidant à diagnostiquer et à surveiller les traitements. Cela inclut des marqueurs tumoraux, des biopsies et des analyses cytologiques.";
                                break;
                            case 'Gynecologie':
                                $description = "Le service de gynécologie offre des analyses pour surveiller la santé reproductive et détecter les maladies gynécologiques. Cela inclut des frottis, des tests hormonaux et des dépistages d'infections.";
                                break;
                        }
                        echo "<div class='col-md-6'>
                                <div class='card mb-4'>
                                    <div class='card-body'>
                                        <h5 class='card-title'>{$row_labo['nom']}</h5>
                                        <p class='card-text'>{$description}</p>
                                    </div>
                                </div>
                            </div>";
                    }
                }
                ?>
            </div>
        </div>
        <div id="footer" class="mt-4 text-center">
            Pour nous contacter : medicare.paris@soin.fr ; Par téléphone : +33 6 76 89 90 10
        </div>
    </div>
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
