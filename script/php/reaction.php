<?php

session_start();

$data = json_decode(file_get_contents("php://input"), true);

header('Content-Type: application/json');

if ($data) {
    $id_publication = $data['id_ref'];
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

        $count_sql = "SELECT COUNT(*) AS count FROM reaction_publication WHERE id_publication = :id_publication";
        $count_stmt = $pdo->prepare($count_sql);
        $count_stmt->bindParam(':id_publication', $id_publication);
        $count_stmt->execute();
        $count_result = $count_stmt->fetch(PDO::FETCH_ASSOC);

        header('Content-Type: application/json');
        echo json_encode([
            "status" => "success",
            "message" => "Réaction enregistrée avec succès",
            "id" => $id_publication,
            "count" => $count_result['count']
        ]);

    } catch (PDOException $e) {
        header('Content-Type: application/json');
        echo json_encode([
            "status" => "error",
            "message" => "Erreur de connexion : " . $e->getMessage()
        ]);
    }

    

} else {

    header('Content-Type: application/json');

    echo json_encode([
        "status" => "error",
        "message" => "Aucune donnée reçue"
    ]);
}

?>