<?php
header('Content-Type: application/json');

require 'db.php';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT commentaire.id, commentaire.contenu, commentaire.date_heure, commentaire.id_publication, compte.nom_utilisateur AS username,
                    (SELECT COUNT(*) FROM reaction_commentaire WHERE reaction_commentaire.id_commentaire = commentaire.id) AS reaction_count
                FROM commentaire
                JOIN compte ON commentaire.id_compte = compte.id
                ORDER BY date_heure DESC";

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
        'date_heure' => $row['date_heure'],
        'username' => $row['username'],
        'id_publication' => $row['id_publication'],
        'reaction' => $row['reaction_count']
    ];
}

echo json_encode($result);
?>