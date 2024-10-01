<?php

session_start();

$data = json_decode(file_get_contents("php://input"), true);

if ($data) {
    $id_compte = $_SESSION['id'];
    $contenu = $data['contenu'];

    require 'db.php';

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $sql = "INSERT INTO publication (id_compte, contenu) VALUES (:id_compte, :contenu)";
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':id_compte', $id_compte);
        $stmt->bindParam(':contenu', $contenu);

        if ($stmt->execute()) {
            echo json_encode([
                "status" => "success",
                "message" => "Publication enregistrée avec succès"
            ]);
        } else {
            echo json_encode([
                "status" => "error",
                "message" => "Erreur lors de l'enregistrement de la publication"
            ]);
        }
    } catch (PDOException $e) {
        echo json_encode([
            "status" => "error",
            "message" => "Erreur de connexion : " . $e->getMessage()
        ]);
    }
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Aucune donnée reçue"
    ]);
}

?>