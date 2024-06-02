<?php
session_start();
$servername = "localhost";
$username = "root"; 
$password = "root"; 
$dbname = "medicare";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$email = $_POST['email'];
$password = $_POST['password'];

$sql = "SELECT * FROM users WHERE email='$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    
    $row = $result->fetch_assoc();
    $hash = $row['mdp'];

    if (password_verify($password, $hash)) {
        
        if ($row['type'] === 'admin') {
            $_SESSION['user_type'] = 'admin';
        } else {
            $_SESSION['user_type'] = 'client'; 
        }
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['user_email'] = $row['email'];
        
        header("Location: accueil_test.php"); 
        exit();
    } else {
        echo "Mot de passe incorrect";
    }
} else {
    echo "Email non trouvé";
}

$conn->close();
?>
