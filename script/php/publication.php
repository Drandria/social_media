<?php
header('Content-Type: application/json');

require 'db.php';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT publication.id, publication.contenu, publication.created_at, compte.nom_utilisateur AS username,
                    (SELECT COUNT(*) FROM reaction_publication WHERE reaction_publication.id_publication = publication.id) AS reaction_count,
                    (SELECT COUNT(*) FROM commentaire WHERE commentaire.id_publication = publication.id) AS comment_count
                FROM publication
                JOIN compte ON publication.id_compte = compte.id
                ORDER BY created_at DESC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    $rows = "";
}

$result = [];

foreach ($rows as $row) {
    $result[] = [
        'id' => $row['id'],
        'contenu' => $row['contenu'],
        'created_at' => $row['created_at'],
        'username' => $row['username'],
        'reaction' => $row['reaction_count'],
        'comment' => $row['comment_count']
    ];
}

echo json_encode($result);

?>