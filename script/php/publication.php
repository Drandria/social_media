<?php
header('Content-Type: application/json');

require 'db.php';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT publication.id, publication.contenu, compte.nom_utilisateur AS username
                FROM publication
                JOIN compte ON publication.id_compte = compte.id";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll();

} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    $retour = "";
}

echo json_encode($result);
?>