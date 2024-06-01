<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Message envoyé</title>
</head>
<body>
    <?php
    // Vérifie si des données ont été soumises via POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Vérifie si le champ "msg" existe dans les données soumises
        if (isset($_POST["msg"])) {
            // Récupère le message envoyé
            $message = $_POST["msg"];
            
            // Affiche le message envoyé
            echo "<h1>Message envoyé :</h1>";
            echo "<p>$message</p>";
        } else {
            echo "<p>Aucun message envoyé.</p>";
        }
    } else {
        echo "<p>Aucune donnée soumise.</p>";
    }
    ?>
</body>
</html>
