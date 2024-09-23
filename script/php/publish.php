<?php

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_compte = $_SESSION['id'];
    $contenu = $_POST['contenu'];

    require 'db.php';

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $sql = "INSERT INTO publication (id_compte, contenu) VALUES (:id_compte, :contenu)";
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':id_compte', $id_compte);
        $stmt->bindParam(':contenu', $contenu);

        if ($stmt->execute()) {
            header("Location: /page/home.html");
            exit();
        } else {
            header("Location: /page/home.html");
            exit();
        }
    } catch (PDOException $e) {
        echo "Erreur de connexion : " . $e->getMessage();
    }
}

?>