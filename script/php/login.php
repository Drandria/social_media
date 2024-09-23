<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $username = $_POST['username'];
    $password = $_POST['password'];

    require 'db.php';

    try {

        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT * FROM compte WHERE nom_utilisateur = :username";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if (password_verify($password,$row['mot_de_passe'])) {
                $_SESSION['username'] = $username;
                $_SESSION['id'] = $row['id'];
                echo "Connexion réussie. Bienvenue " . $username . "!";
                header("Location: /page/home.html");
                exit();
            } else {
                echo "Mot de passe incorrect.";
            }
        } else {
            echo "Nom d'utilisateur non trouvé.";
        }

    } catch(PDOException $e) {
        echo "Erreur de connexion : " . $e->getMessage();
    }

    $conn = null;
}
?>
