<?php

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_compte = $_SESSION['id'];
    $id_publication = $_POST['id_publication'];
    $contenu = $_POST['contenu'];

    require 'db.php';

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $sql = "INSERT INTO commentaire (id_compte, id_publication, contenu) VALUES (:id_compte, :id_publication, :contenu)";
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':id_compte', $id_compte);
        $stmt->bindParam(':id_publication', $id_publication);
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