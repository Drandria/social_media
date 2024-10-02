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


        $check_sql = "SELECT * FROM reaction_commentaire WHERE id_compte = :id_compte AND id_commentaire = :id_comment";
        $check_stmt = $pdo->prepare($check_sql);
        $check_stmt->bindParam(':id_compte', $id_compte);
        $check_stmt->bindParam(':id_comment', $id_comment);
        $check_stmt->execute();

        if ($check_stmt->rowCount() > 0) {
            $delete_sql = "DELETE FROM reaction_commentaire WHERE id_compte = :id_compte AND id_commentaire = :id_comment";
            $delete_stmt = $pdo->prepare($delete_sql);
            $delete_stmt->bindParam(':id_compte', $id_compte);
            $delete_stmt->bindParam(':id_comment', $id_comment);
            $delete_stmt->execute();

            $action = "deleted";
            $message = "Réaction supprimée avec succès";
        } else {
            $sql = "INSERT INTO reaction_commentaire (type, id_compte, id_commentaire) VALUES (:type, :id_compte, :id_comment)";
            $stmt = $pdo->prepare($sql);

            $stmt->bindParam(':type', $type);
            $stmt->bindParam(':id_compte', $id_compte);
            $stmt->bindParam(':id_comment', $id_comment);
            $stmt->execute();

            $action = "inserted";
            $message = "Réaction enregistrée avec succès";
        }

        $count_sql = "SELECT COUNT(*) AS count FROM reaction_commentaire WHERE id_commentaire = :id_commentaire";
        $count_stmt = $pdo->prepare($count_sql);
        $count_stmt->bindParam(':id_commentaire', $id_comment);
        $count_stmt->execute();
        $count_result = $count_stmt->fetch(PDO::FETCH_ASSOC);

        header('Content-Type: application/json');
        echo json_encode([
            "status" => "success",
            "message" => $message,
            "action" => $action,
            "id" => $id_comment,
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