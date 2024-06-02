<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Message envoyé</title>
</head>
<body>
    <?php
    // check donne post
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // check 'msg'
        if (isset($_POST["msg"])) {
            $message = $_POST["msg"];
            
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
