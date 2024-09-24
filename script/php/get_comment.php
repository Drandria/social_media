<?php
header('Content-Type: application/json');

require 'db.php';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT commentaire.id, commentaire.contenu, commentaire.date_heure, commentaire.id_publication, compte.nom_utilisateur AS username
                FROM commentaire
                JOIN compte ON commentaire.id_compte = compte.id";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll();

} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    $result = "";
}

echo json_encode($result);
?>