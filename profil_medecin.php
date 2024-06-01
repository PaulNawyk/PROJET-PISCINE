<?php
// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "medicare";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Vérif si l'ID du med est passé en paramètre
if (isset($_GET['id'])) {
    $medecin_id = $_GET['id'];

    // Requête SQL pour récupérer les info du med
    $sql_medecin = "SELECT m.id, u.nom, u.prenom, m.photo, m.cv, s.nom as specialite 
                    FROM medecin m
                    JOIN users u ON m.user_id = u.id
                    JOIN specialites s ON m.specialite_id = s.id
                    WHERE m.id = $medecin_id";

    $result_medecin = $conn->query($sql_medecin);

    if ($result_medecin->num_rows > 0) {
        // Récupération des info du med
        $row_medecin = $result_medecin->fetch_assoc();
        $nom = $row_medecin['nom'];
        $prenom = $row_medecin['prenom'];
        $photo = $row_medecin['photo'];
        $cv = $row_medecin['cv'];
        $specialite = $row_medecin['specialite'];
        $mail = $row_medecin['mail'];

        // Requête SQL pour récupérer les dispo du med
        $sql_disponibilites = "SELECT jour, heure_debut, heure_fin FROM disponibilites WHERE medecin_id = $medecin_id";
        $result_disponibilites = $conn->query($sql_disponibilites);

        // Vérif si des dispo sont trouvées
        if ($result_disponibilites->num_rows > 0) {
            // Initialise un tableau pour stocker les dispo
            $disponibilites = array();

            // Parcours des résultats de la requête et stockage des données de disponibilité dans le tableau
            while ($row_disponibilite = $result_disponibilites->fetch_assoc()) {
                $disponibilites[] = $row_disponibilite;
            }
        } else {
            // Aucune dispo
            $disponibilites = null;
        }
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="base.css" rel="stylesheet" type="text/css" />
    <style>
        .bg-selected {
            background-color: red;
        }
    </style>
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
                <ul class="dropdown-menu">
                    <li>
                    <li>
                    <li class="dropdown-submenu">
                        <a class="dropdown-item dropdown-toggle" href="#">Médecin Généraliste</a>
                        <ul class="dropdown-menu">
                            <?php
                            // Requête SQL pour sélec les noms des med généralistes
                            $sql_generalistes = "SELECT m.id, u.nom 
                                                FROM medecin m
                                                JOIN users u ON m.user_id = u.id
                                                WHERE m.specialite_id = 1";
                            $result_generalistes = $conn->query($sql_generalistes);
                            if (!$result_generalistes) {
                                printf("Erreur : %s\n", $conn->error);
                                exit();
                            }

                            //  noms des med généraliste
                            if ($result_generalistes->num_rows > 0) {
                                while ($row_generaliste = $result_generalistes->fetch_assoc()) {
                                    echo "<li><a href='profil_medecin.php?id=" . $row_generaliste["id"] . "'>" . $row_generaliste["nom"] . "</a></li>";
                                }
                            }
                            ?> </ul>
                    <li class="dropdown-submenu">
                        <a class="dropdown-item dropdown-toggle" href="#">Médecin Spécialiste</a>
                        <ul class="dropdown-menu">
                            <?php
                            // requête SQL pour selec les noms des médecins spécialistes
                            $sql_specialistes = "SELECT m.id, u.nom 
                                                FROM medecin m
                                                JOIN users u ON m.user_id = u.id
                                                WHERE m.specialite_id != 1"; // Changer la condition pour sélectionner les spécialistes
                            $result_specialistes = $conn->query($sql_specialistes);
                            if (!$result_specialistes) {
                                printf("Erreur : %s\n", $conn->error);
                                exit();
                            }

                            //  noms des med spe
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
    <li>Laboratoire de biologie médicale</li>

</ul>
</li>
</ul>
</div>
<button class="btn btn-default
ml-3" onclick="window.location.href='rendezvous.html'">RENDEZ-VOUS</button>
<button class="btn btn-default ml-3" onclick="window.location.href='profil.php'">PROFIL</button>
<input id="searchbar" class="form-control mx-3" type="text" name="search" placeholder="RECHERCHE..." style="width: 15%;">
<img src="img/loupe.jpg" alt="LOGO" width="30" height="30">
</div>
<div id="section">
    <h1>Profil Utilisateur</h1>
    <div class="card">
        <div class="card-body">
            <p class="card-text"><?php echo "<h2>Profil du Dr. $nom $prenom</h2>"; ?></p>
            <p class="card-text"><?php echo "<p><strong>Spécialité :</strong> $specialite</p>"; ?></p>
            <p class="card-text"><?php echo "<img src='$photo' alt='Photo du médecin' width='200'>"; ?></p>
            <p class="card-text"><?php echo "<h3>CV :</h3>"; ?></p>
            <p class="card-text"><?php echo "<p>$cv</p>"; ?></p>
            <p class="card-text"><h3>Disponibilités :</h3></p>
            <?php if ($disponibilites): ?>
            <form action="save_dispo.php" method="post"> <!-- Ajout du formulaire pour enregistrer les disponibilités -->
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Heures</th>
                        <th>Lundi</th>
                        <th>Mardi</th>
                        <th>Mercredi</th>
                        <th>Jeudi</th>
                        <th>Vendredi</th>
                        <th>Samedi</th>
                        <th>Dimanche</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                   
                    $plages_horaires = array(
                        "8h - 9h",
                        "9h - 10h",
                        "10h - 11h",
                        "11h - 12h",
                        "12h - 13h",
                        "13h - 14h",
                        "14h - 15h",
                        "15h - 16h",
                        "16h - 17h",
                        "17h - 18h",
                        "18h - 19h",
                        "19h - 20h",
                        "20h - 21h",
                    
                        
                    );                // tableau pour stocker les dispo
                    $tableau_disponibilites = array();
    
                    //creation du tab des dispo
                    foreach ($plages_horaires as $plage_horaire) {
                        $tableau_disponibilites[$plage_horaire] = array(
                            'Lundi' => '',
                            'Mardi' => '',
                            'Mercredi' => '',
                            'Jeudi' => '',
                            'Vendredi' => '',
                            'Samedi' => '',
                            'Dimanche' => ''
                        );
                    }
    
                    // tab rempli 
                    foreach ($disponibilites as $disponibilite) {
                        $jour = $disponibilite['jour'];
                        $heure_debut = $disponibilite['heure_debut'];
                        $heure_fin = $disponibilite['heure_fin'];
    
                        $disponibilite_formattee = "$heure_debut - $heure_fin";
    
                        // decoupage l'heure de début et l'heure de fin pour avoir les heures
                        $heure_debut_parts = explode(':', $heure_debut);
                        $heure_fin_parts = explode(':', $heure_fin);
    
                        
                        $index_debut = intval($heure_debut_parts[0]) - 8; // 9h - 8 = 1
                        $index_fin = intval($heure_fin_parts[0]) - 8; // 12h - 8 = 4
    
                        // case "dispo"
                        for ($i = $index_debut; $i < $index_fin; $i++) {
                            $tableau_disponibilites[$plages_horaires[$i]][$jour] = 'Disponible';
                        }
                    }
    
                    // tab des dispo
                    foreach ($tableau_disponibilites as $plage_horaire => $jours) {
                        echo "<tr><td>$plage_horaire</td>";
                        foreach ($jours as $jour => $disponible) {
                            // couleur des cases 
                            $class_couleur = ($disponible == 'Disponible') ? 'bg-success' : 'bg-light';
                            // ajout d'un champ de formulaire pour enregistrer l'état de la case
                            echo "<td class='$class_couleur'><input type='checkbox' name='dispo[]' value='$jour-$plage_horaire'></td>";
                        }
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
            <input type="hidden" name="medecin_id" value="<?php echo $medecin_id; ?>"> <!-- Champ caché pour l'ID du médecin -->
            <input type="submit" value="Enregistrer les disponibilités">
            </form>
            <?php else: ?>
            <p>Aucune disponibilité trouvée pour ce médecin.</p>
<?php endif; ?>
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

        // Gestion du changement de couleur au clic sur les cellules du tableau
        $('td.bg-success').on('click', function() {
            $(this).toggleClass('bg-selected');
        });
    });
</script>

</body>
</html>