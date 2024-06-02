<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "medicare";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $medecin_id = intval($_GET['id']);

    //  SQL info du med
    $stmt = $conn->prepare("SELECT m.id, u.nom, u.prenom, m.photo, m.cv, s.nom as specialite 
                            FROM medecin m
                            JOIN users u ON m.user_id = u.id
                            JOIN specialites s ON m.specialite_id = s.id
                            WHERE m.id = ?");
    $stmt->bind_param("i", $medecin_id);
    $stmt->execute();
    $result_medecin = $stmt->get_result();

    if ($result_medecin->num_rows > 0) {
        //  info du med
        $row_medecin = $result_medecin->fetch_assoc();
        $nom = htmlspecialchars($row_medecin['nom']);
        $prenom = htmlspecialchars($row_medecin['prenom']);
        $photo = htmlspecialchars($row_medecin['photo']);
        $specialite = htmlspecialchars($row_medecin['specialite']);
        $cv_path = htmlspecialchars($row_medecin['cv']);

        
        if (file_exists($cv_path)) {
            $cv_xml = simplexml_load_file($cv_path);
        } else {
            $cv_xml = null;
        }

        //  SQL pour recuperer les dispo du med
        $stmt_dispo = $conn->prepare("SELECT jour, heure_debut, heure_fin FROM disponibilites WHERE medecin_id = ?");
        $stmt_dispo->bind_param("i", $medecin_id);
        $stmt_dispo->execute();
        $result_disponibilites = $stmt_dispo->get_result();

        // verif des dispo 
        $disponibilites = array();
        if ($result_disponibilites->num_rows > 0) {
            while ($row_disponibilite = $result_disponibilites->fetch_assoc()) {
                $disponibilites[] = $row_disponibilite;
            }
        }
    } else {
        echo "Aucun médecin trouvé avec cet identifiant.";
        exit();
    }
} else {
    echo "Aucun identifiant de médecin spécifié.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Profil Médecin</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="base_medecin.css" rel="stylesheet">
    <style>
        .bg-selected {
            background-color: red;
        }
    </style>
</head>

<body>
    <div id="wrapper">
        <div id="header">
            <div id="wrapperlogo">
                <div class="header-text">
                    <h1>MEDICARE </h1>
                    <h2> Services Médicaux</h2>
                </div>
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
                    <li class="dropdown-submenu">
                        <a class="dropdown-item dropdown-toggle" href="#">Médecin Généraliste</a>
                        <ul class="dropdown-menu">
                            <?php
                            $stmt_gen = $conn->prepare("SELECT m.id, u.nom 
                                                        FROM medecin m
                                                        JOIN users u ON m.user_id = u.id
                                                        WHERE m.specialite_id = 1");
                            $stmt_gen->execute();
                            $result_generalistes = $stmt_gen->get_result();
                            if ($result_generalistes->num_rows > 0) {
                                while ($row_generaliste = $result_generalistes->fetch_assoc()) {
                                    echo "<li><a href='profil_medecin.php?id=" . htmlspecialchars($row_generaliste["id"]) . "'>" . htmlspecialchars($row_generaliste["nom"]) . "</a></li>";
                                }
                            }
                            ?>
                        </ul>
                    </li>
                    <li class="dropdown-submenu">
                        <a class="dropdown-item dropdown-toggle" href="#">Médecin Spécialiste</a>
                        <ul class="dropdown-menu">
                            <?php
                            $stmt_spec = $conn->prepare("SELECT m.id, u.nom 
                                                         FROM medecin m
                                                         JOIN users u ON m.user_id = u.id
                                                         WHERE m.specialite_id != 1");
                            $stmt_spec->execute();
                            $result_specialistes = $stmt_spec->get_result();
                            if ($result_specialistes->num_rows > 0) {
                                while ($row_specialiste = $result_specialistes->fetch_assoc()) {
                                    echo "<li><a href='profil_medecin.php?id=" . htmlspecialchars($row_specialiste["id"]) . "'>" . htmlspecialchars($row_specialiste["nom"]) . "</a></li>";
                                }
                            }
                            ?>
                        </ul>
                    </li>
                    <li class="dropdown-submenu">
                        <a class="dropdown-item dropdown-toggle" href="#">Laboratoire</a>
                        <ul class="dropdown-menu">
                            <li>Laboratoire de biologie médicale</li>
                        </ul>
                    </li>
                </ul>
            </div>
            <button class="btn btn-default ml-3" onclick="window.location.href='rendezvous.html'">RENDEZ-VOUS</button>
            <button class="btn btn-default ml-3" onclick="window.location.href='profil.php'">PROFIL</button>
            <form action="recherche.php" method="POST" class="form-inline">
                <input id="searchbar" class="form-control" type="text" name="search" placeholder="RECHERCHE..." style="width: 300px;">
                <button type="submit" class="btn btn-default ml-2"><img src="img/loupe.jpg" alt="LOGO" width="30" height="30"></button>
            </form>
        </div>

        
        
        <div id="section">
            <h1 style="text-align: center;">Votre médecin</h1>
            <div class="card">
                <div class="card-body">
                    <div style="display: flex; align-items: center;">
                        <div>
                        <h2>Dr. <?php echo "$nom $prenom"; ?></h2>
                        <h5><p><strong>Spécialité :</strong> <?php echo $specialite; ?></p></h5>

                            <div>
                                <h4>Voir le CV de mon médecin:</h4>
                                <?php
                                if ($cv_xml) {
                                    $prenom = htmlspecialchars($cv_xml->PersonalInformation->FirstName);
                                    $html_file = "cv_" . $prenom . ".html";
                                    echo "<a href='$html_file'>Cliquez ici</a>";
                                } else {
                                    echo "<p>CV non disponible.</p>";
                                }
                                ?>
                            </div>
                        </div>

                    
                        <div style="margin-left: 400px;">
                            <img src="<?php echo $photo; ?>" alt="Photo du médecin" width="300">
                        </div>

                    </div>

                    <div class="chat-popup" id="myChatBox">
                        <form action="accueil_test.php" class="form-container" onsubmit="alert('Votre médecin a bien reçu votre question');">
                            <h4>Posez votre question au médecin : </h4>
                            <textarea placeholder="Type message.." name="msg" required></textarea>
                        <button type="submit" class="btn">Send</button>
                            
                            
                        </form>
                    </div>
                    <script>
                        function openChatBox() {
                            document.getElementById("myChatBox").style.display = "block";
                        }

                        function closeChatBox() {
                            document.getElementById("myChatBox").style.display = "none";
                        }
                    </script>
                    <h3>Disponibilités :</h3>
                    <?php if ($disponibilites) : ?>
                        <form action="save_dispo.php" method="post">
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
                                        "8h - 9h", "9h - 10h", "10h - 11h", "11h - 12h", "12h - 13h", "13h - 14h",
                                        "14h - 15h", "15h - 16h", "16h - 17h", "17h - 18h", "18h - 19h", "19h - 20h",
                                        "20h - 21h"
                                    );

                                    $tableau_disponibilites = array();

                                    // Initialiser le tableau des disponibilités
                                    foreach ($plages_horaires as $plage_horaire) {
                                        $tableau_disponibilites[$plage_horaire] = array(
                                            'Lundi' => '', 'Mardi' => '', 'Mercredi' => '', 'Jeudi' => '',
                                            'Vendredi' => '', 'Samedi' => '', 'Dimanche' => ''
                                        );
                                    }

                                    // Remplir le tableau des disponibilités
                                    foreach ($disponibilites as $disponibilite) {
                                        $jour = htmlspecialchars($disponibilite['jour']);
                                        $heure_debut = htmlspecialchars($disponibilite['heure_debut']);
                                        $heure_fin = htmlspecialchars($disponibilite['heure_fin']);

                                        $disponibilite_formattee = "$heure_debut - $heure_fin";

                                        $heure_debut_parts = explode(':', $heure_debut);
                                        $heure_fin_parts = explode(':', $heure_fin);

                                        $index_debut = intval($heure_debut_parts[0]) - 8;
                                        $index_fin = intval($heure_fin_parts[0]) - 8;

                                        for ($i = $index_debut; $i < $index_fin; $i++) {
                                            $tableau_disponibilites[$plages_horaires[$i]][$jour] = 'Disponible';
                                        }
                                    }

                                    // Afficher le tableau des disponibilités
                                    foreach ($tableau_disponibilites as $plage_horaire => $jours) {
                                        echo "<tr><td>$plage_horaire</td>";
                                        foreach ($jours as $jour => $disponible) {
                                            $class_couleur = ($disponible == 'Disponible') ? 'bg-success' : 'bg-light';
                                            echo "<td class='$class_couleur'><input type='checkbox' name='dispo[]' value='$jour-$plage_horaire'></td>";
                                        }
                                        echo "</tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </form>
                    <?php else : ?>
                        <p>Aucune disponibilité trouvée pour ce médecin.</p>
                    <?php endif; ?>
                    <h3>Prendre un rendez-vous :</h3>
                    <form action="process_rdv.php" method="post" id="rdvForm">
                        <label for="date">Date :</label>
                        <input type="date" id="date" name="date" required><br>

                        <label for="heure">Heure :</label>
                        <input type="time" id="heure" name="heure" required><br>

                        <input type="hidden" name="medecin_id" value="<?php echo $medecin_id; ?>">
                        <input type="submit" value="Prendre rendez-vous">
                    </form>
                    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
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

                            $('#rdvForm').submit(function(e) {
                                e.preventDefault(); // empeche le form de soumettre de maniere normale

                                // requete ajax
                                $.ajax({
                                    type: 'POST',
                                    url: $(this).attr('action'),
                                    data: $(this).serialize(),
                                    dataType: 'json',
                                    success: function(response) {
                                        if (response.success) {
                                            alert('Rendez-vous pris avec succès!');
                                            window.location.href = 'rendezvous.php'; // redirige vers la page des rdv
                                        } else {
                                            alert('Erreur lors de la prise de rendez-vous: ' + response.message);
                                        }
                                    },
                                    error: function(xhr, status, error) {
                                        alert('Une erreur est survenue: ' + error);
                                    }
                                });
                            });
                        });
                    </script>
                    <script>
                        $(document).ready(function() {
                            $('#rdvForm').submit(function(e) {
                                e.preventDefault(); // empeche le form de soumettre de maniere normale

                                // requete ajax
                                $.ajax({
                                    type: 'POST',
                                    url: $(this).attr('action'),
                                    data: $(this).serialize(),
                                    dataType: 'json',
                                    success: function(response) {
                                        if (response.success) {
                                            alert('Rendez-vous pris avec succès!');
                                            window.location.href = 'rendezvous.php'; // redirige vers la page des rdv
                                        } else {
                                            alert('Erreur lors de la prise de rendez-vous: ' + response.message);
                                        }
                                    },
                                    error: function(xhr, status, error) {
                                        alert('Une erreur est survenue: ' + error);
                                    }
                                });
                            });
                        });
                    </script>
                </div>
            </div>
        </div>
        <div id="footer">
            <p>Pour nous contacter : medicare.paris@soin.fr </p>
            <p>Par téléphone : +33 6 76 89 90 10</p> 
        </div>
    </div>
</body>

</html>