<?php
session_start();

// verif user co
if (!isset($_SESSION['user_id'])) {
    header("Location: signin.html");
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Medicare Dashboard</title>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h1>Bienvenue, <?php echo $_SESSION['user_email']; ?>!</h1>
        <p>Vous êtes connecté à votre tableau de bord.</p>
    </div>
</body>

</html>
