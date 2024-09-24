<?php

session_start();

$data = json_decode(file_get_contents("php://input"), true);

if ($data) {
    $id_publication = $data['id_publication'];
    $id_compte = $_SESSION['id'];
    $type = "like";

    require 'db.php';

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $sql = "INSERT INTO reaction_publication (type, id_compte, id_publication) VALUES (:type, :id_compte, :id_publication)";
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':type', $type);
        $stmt->bindParam(':id_compte', $id_compte);
        $stmt->bindParam(':id_publication', $id_publication);
        $stmt->execute();
    } catch (PDOException $e) {
        echo "Erreur de connexion : " . $e->getMessage();
    }

    header('Content-Type: application/json'); // Définit le type de réponse
    echo json_encode([
        "status" => "success",
        "message" => "Réaction enregistrée avec succès",
        "id_publication" => $id_publication
    ]);

} else {

    header('Content-Type: application/json'); // Définit le type de réponse

    echo json_encode([
        "status" => "error",
        "message" => "Aucune donnée reçue"
    ]);
}

?>