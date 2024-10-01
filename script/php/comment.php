<?php

session_start();

$data = json_decode(file_get_contents("php://input"), true);

header('Content-Type: application/json');

if ($data) {
    $id_compte = $_SESSION['id'];
    $id_publication = $data['id_publication'];
    $contenu = $data['contenu'];

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
            
            $sq = "SELECT commentaire.id, commentaire.contenu, commentaire.date_heure, commentaire.id_publication, compte.nom_utilisateur AS username,
                            (SELECT COUNT(*) FROM reaction_commentaire WHERE reaction_commentaire.id_commentaire = commentaire.id) AS reaction_count
                        FROM commentaire
                        JOIN compte ON commentaire.id_compte = compte.id
                        WHERE commentaire.id_publication = :id_publication
                        ORDER BY date_heure DESC";

            $stm = $pdo->prepare($sq);
            $stm->bindParam(':id_publication', $id_publication);
            $stm->execute();
            $rows = $stm->fetchAll(PDO::FETCH_ASSOC);

            $result = [];

            foreach ($rows as $row) {
                $result[] = [ 
                    'id' => $row['id'],
                    'contenu' => $row['contenu'],
                    'date_heure' => $row['date_heure'],
                    'username' => $row['username'],
                    'id_publication' => $row['id_publication'],
                    'reaction' => $row['reaction_count']
                ];
            }

            echo json_encode($result);

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