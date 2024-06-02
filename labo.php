<?php

// co bdd
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "medicare";

$conn = new mysqli($servername, $username, $password, $dbname);

// check co
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// requete sql
$sql = "SELECT m.id, u.nom 
        FROM medecin m
        JOIN users u ON m.user_id = u.id
        WHERE m.specialite_id = 1";
$result = $conn->query($sql);
if (!$result) {
    printf("Erreur : %s\n", $conn->error);
    exit();
}

// stocker dans bdd
session_start();
$_SESSION['user_type'] = $row['type']; 

// requete sql
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link href="labo.css" rel="stylesheet" type="text/css"/>
    <style>
       
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body, html {
            width: 100%;
            overflow-x: hidden; 
        }
        #wrapper {
            margin: 0 auto;
            padding: 0 15px;
        }
        #header, #footer {
            width: 100%;
            margin: 0 auto;
            padding: 0 15px;
        }
        #section {
            padding: 15px;
        }

        .card {
            margin: 0;
        }

        .presentation {
            margin: 0 auto;
        }
        #navigation {
            padding: 0 15px;
        }
        .btn {
            padding: 5px 10px;
        }

        .form-inline {
            display: flex;
            flex-wrap: nowrap;
        }

        .form-inline .form-control {
            flex: 1;
        }
    </style>
</head>

<body>
    <div id="wrapper">
        <div id="header">
            <div id="wrapperlogo">
                <div><h1>MEDICARE : Services Médicaux</h1></div>
                <div><img class="logo" src="img/logo.jpg" /></div>
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
                    <li>
                    <li><li class="dropdown-submenu">
                        <a class="dropdown-item dropdown-toggle" href="#">Médecin Généraliste</a>
                        <ul class="dropdown-menu">
                            <?php
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<li><a class='dropdown-item' href='profil_medecin.php?id=" . $row["id"] . "'>" . $row["nom"] . "</a></li>";
                                }
                            }
                            ?>
                        </ul>
                    <li class="dropdown-submenu">
                        <a class="dropdown-item dropdown-toggle" href="#">Médecin Spécialiste</a>
                        <ul class="dropdown-menu">
                            <?php
                            $sql_specialistes = "SELECT m.id, u.nom 
                                                FROM medecin m
                                                JOIN users u ON m.user_id = u.id
                                                WHERE m.specialite_id != 1";
                            $result_specialistes = $conn->query($sql_specialistes);
                            if (!$result_specialistes) {
                                printf("Erreur : %s\n", $conn->error);
                                exit();
                            }
                            if ($result_specialistes->num_rows > 0) {
                                while ($row_specialiste = $result_specialistes->fetch_assoc()) {
                                    echo "<li><a class='dropdown-item' href='profil_medecin.php?id=" . $row_specialiste["id"] . "'>" . $row_specialiste["nom"] . "</a></li>";
                                }
                            }
                            ?>
                        </ul>
                    </li>
                    <li><li class="dropdown-submenu">
                        <a class="dropdown-item dropdown-toggle" href="#">Laboratoire</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Laboratoire de biologie médicale</a></li>
                        </ul>
                </ul>
            </div>

            <button class="btn btn-default ml-3">RENDEZ-VOUS</button>
            <button class="btn btn-default ml-3" onclick="window.location.href='profil.php'">PROFIL</button>
            <form action="recherche.php" method="POST" class="form-inline">
                <input id="searchbar" class="form-control mx-3" type="text" name="search" placeholder="RECHERCHE..." style="width: 15%;">
                <button type="submit" class="btn btn-default ml-2"><img src="img/loupe.jpg" alt="LOGO" width="30" height="30"></button>
            </form>
            <?php
            if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'admin') {
                echo '<a href="page_admin.php" class="btn btn-primary ml-3">Bouton Exclusif Admin</a>';
            }
            ?>
        </div>
        <div id="section">
            <div class="presentation">
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
                    $result_labo->data_seek(0); 
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
