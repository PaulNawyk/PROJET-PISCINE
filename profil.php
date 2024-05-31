<?php
// Start session to get user data
session_start();

// Database connection details
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "medicare";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Assuming the user's ID is stored in the session after login
$user_id = $_SESSION['user_id'];

// Fetch user data
$sql = "SELECT * FROM users WHERE id = $user_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "No user found";
    exit;
}

$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Profil Utilisateur</title>
    <meta charset="utf-8" />
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link href="base.css" rel="stylesheet" type="text/css"/>
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
                    <li class="dropdown-submenu">
                        <a class="dropdown-item dropdown-toggle" href="#">Médecin Généraliste</a>
                        <ul class="dropdown-menu">
                            <li>Hervé Mathoux</li>
                            <li>Franck Sauzé</li>
                            <li>Patrick Bruel</li>
                            <li>Franck Dubosc</li>
                            <li>Nicolas Sarkozy</li>
                        </ul>
                    </li>
                    <li class="dropdown-submenu">
                        <a class="dropdown-item dropdown-toggle" href="#">Médecin Spécialiste</a>
                        <ul class="dropdown-menu">
                            <li>Addictologie</li>
                            <li>Andrologie</li>
                            <li>Cardiologie</li>
                            <li>Dermatologie</li>
                            <li>Gastro- Hépato-Entérologie</li>
                            <li>Gynécologie</li>
                            <li>I.S.T.</li>
                            <li>Ostéopathie</li>
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
            <input id="searchbar" class="form-control mx-3" type="text" name="search" placeholder="RECHERCHE..." style="width: 15%;">
            <img src="img/loupe.jpg" alt="LOGO" width="30" height="30">
        </div>
        <div id="section">
            <h1>Profil Utilisateur</h1>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $user['prenom'] . ' ' . $user['nom']; ?></h5>
                    <p class="card-text">Adresse: <?php echo $user['adresse_ligne1'] . ', ' . $user['adresse_ligne2'] . ', ' . $user['ville'] . ', ' . $user['codePost'] . ', ' . $user['pays']; ?></p>
                    <p class="card-text">Email: <?php echo $user['email']; ?></p>
                    <p class="card-text">Téléphone: <?php echo $user['telephone']; ?></p>
                    <p class="card-text">Numéro de carte vitale: <?php echo $user['carte_vitale']; ?></p>
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
        $(document).ready(function(){
            $('.dropdown-submenu a.dropdown-toggle').on("click", function(e){
                if(!$(this).next('ul').hasClass('show')){
                    $(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
                }
                var $subMenu = $(this).next('ul');
                $subMenu.toggleClass('show');
                $(this).parent('li').toggleClass('show');
                $(this).parents('li.nav-item.dropdown.show').on('hidden.bs.dropdown', function(e){
                    $('.dropdown-submenu .show').removeClass("show");
                });
                return false;
            });
        });
    </script>
</body>
</html>
