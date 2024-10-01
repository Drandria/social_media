<?php

function count_row ($pdo, $id_ref, $dbname, $col_name) {
    try {
        $sql = "SELECT * FROM $dbname WHERE $col_name = :id_ref";
    
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id_ref', $id_ref);
        $stmt->execute();

        return ($stmt->rowCount());
    
    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
        return false;
    }
}

?>