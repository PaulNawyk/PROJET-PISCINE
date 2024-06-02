<!DOCTYPE html>
<html>
<head>
    <title>Planning Semainier des Médecins</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            text-align: center;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
        .hour-cell {
            height: 40px;
        }
    </style>
</head>
<body>
    <h1>Planning Semainier des Médecins</h1>
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "medicare";

    // creer co
    $conn = new mysqli($servername, $username, $password, $dbname);

    // verfi co
    if ($conn->connect_error) {
        die("Connexion échouée: " . $conn->connect_error);
    }

    // initialiser tableau jour
    $jours = ["Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi", "Dimanche"];

    $disponibilites = [];

    // recup les disponibilites
    $sql = "SELECT sp.nom AS specialite_nom, u.nom AS medecin_nom, d.jour, d.heure_debut, d.heure_fin 
            FROM disponibilites d
            LEFT JOIN medecin m ON d.medecin_id = m.id
            LEFT JOIN specialites sp ON m.specialite_id = sp.id
            LEFT JOIN users u ON m.user_id = u.id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $specialite_nom = $row['specialite_nom'];
            $medecin_nom = $row['medecin_nom'];
            $jour = $row['jour'];
            $heure_debut = $row['heure_debut'];
            $heure_fin = $row['heure_fin'];

            if (!isset($disponibilites[$jour])) {
                $disponibilites[$jour] = [];
            }

            $disponibilites[$jour][] = [
                'specialite_nom' => $specialite_nom,
                'medecin_nom' => $medecin_nom,
                'heure_debut' => $heure_debut,
                'heure_fin' => $heure_fin
            ];
        }
    } else {
        echo "0 résultats";
    }
    $conn->close();

    // gerer semaine
    echo "<table>";
    echo "<tr><th>Heure</th>";

    // afficher jours 
    foreach ($jours as $jour) {
        echo "<th>$jour</th>";
    }
    echo "</tr>";

    // afficher les heures de 08:00 à 20:00
    for ($heure = 8; $heure <= 20; $heure++) {
        $heure_formatee = str_pad($heure, 2, '0', STR_PAD_LEFT) . ":00";
        echo "<tr>";
        echo "<td class='hour-cell'>$heure_formatee</td>";

        // afficher les disponibilités pour chaque jour
        foreach ($jours as $jour) {
            echo "<td class='hour-cell'>";
            if (isset($disponibilites[$jour])) {
                foreach ($disponibilites[$jour] as $disponibilite) {
                    $heure_debut = substr($disponibilite['heure_debut'], 0, 5);
                    $heure_fin = substr($disponibilite['heure_fin'], 0, 5);
                    if ($heure_formatee >= $heure_debut && $heure_formatee < $heure_fin) {
                        echo "<strong>" . $disponibilite['specialite_nom'] . "</strong> - " . $disponibilite['medecin_nom'] . "<br>";
                    }
                }
            }
            echo "</td>";
        }
        echo "</tr>";
    }

    echo "</table>";
    ?>
</body>
</html>