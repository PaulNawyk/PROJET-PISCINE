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
$_SESSION['user_type'] = $row['type']; // Supposons que le type soit stocké dans la colonne 'type' de votre table 'users'


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
            <button class="btn btn-default mx-3" onclick="window.location.href='accueil_test.php'">ACCUEIL</button>

            <div class="dropdown">
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
// Affichage des noms des médecins généralistes
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<li><a href='profil_medecin.php?id=" . $row["id"] . "'>" . $row["nom"] . "</a></li>";
    }
}
?>   </ul>
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

            <button class="btn btn-default ml-3">RENDEZ-VOUS</button>
            <button class="btn btn-default ml-3" onclick="window.location.href='profil.php'">PROFIL</button>
<form action="recherche.php" method="POST">
    <input id="searchbar" class="form-control mx-3" type="text" name="search" placeholder="RECHERCHE..." style="width: 90%;">
</form>
            <img src="img/loupe.jpg" alt="LOGO" width="30" height="30">
            <?php
session_start();

// Vérifier si l'utilisateur est connecté et s'il est admin
if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'admin') {
    // Afficher le bouton exclusif pour les admins
    echo '<a href="page_admin.php" class="btn btn-primary">Bouton Exclusif Admin</a>';}
?>



        </div>
        <div id="section">
            <div class="presentation">
            Laboratoire de biologie médicale <br>
            Dépistage covid-19 <br>
            Biologie préventive<br>
            Biologie de la femme enceinte <br>
            Biologie de routine<br>
            Cancérologie<br>
            Gynécologie   <br>             

            </div>




            </div>
            <div id="footer">
                Pour nous contactez : medicare.paris@soin.fr ; Par téléphone : +33 6 76 89 90 10
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