<?php

session_start();

$data = json_decode(file_get_contents("php://input"), true);

if ($data) {
    $id_comment = $data['id_ref'];
    $id_compte = $_SESSION['id'];
    $type = "like";

    require 'db.php';

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $sql = "INSERT INTO reaction_commentaire (type, id_compte, id_commentaire) VALUES (:type, :id_compte, :id_comment)";
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':type', $type);
        $stmt->bindParam(':id_compte', $id_compte);
        $stmt->bindParam(':id_comment', $id_comment);
        $stmt->execute();
    } catch (PDOException $e) {
        echo "Erreur de connexion : " . $e->getMessage();
    }

    header('Content-Type: application/json');
    echo json_encode([
        "status" => "success",
        "message" => "Réaction enregistrée avec succès",
        "id_publication" => $id_publication
    ]);

} else {

    header('Content-Type: application/json');

    echo json_encode([
        "status" => "error",
        "message" => "Aucune donnée reçue"
    ]);
}

?>