<?php

// function executeselect1($sql, $isALL = false) {
//     $pdo = connectDB();
    
//    try {
//         $statement = $pdo->query($sql);
//         if (!$isALL) {
//             // dd($statement);
//             return $statement->fetch();
//         }
//         return $statement->fetchAll();
//     } catch(PDOException $e) {
//         echo "Erreur de requête SELECT : " . $e->getMessage();
//     }
// }
// function executeselect($sql, $isALL = false, $params = []) {
//     $pdo = connectDB();
//     $stmt = $pdo->prepare($sql);
    
//     if (!empty($params)) {
//         foreach ($params as $key => $value) {
//             $stmt->bindValue(is_int($key) ? $key + 1 : $key, $value);
//         }
//     }
    
//     $stmt->execute();
//     return $isALL ? $stmt->fetchAll() : $stmt->fetch();
// }
//  * Exécute une requête SQL (SELECT, INSERT, UPDATE, DELETE).
//  * 
//  * @param string $sql La requête SQL avec ou sans paramètres nommés.
//  * @param array $params Les paramètres associés à la requête (optionnel).
//  * @param bool $fetchAll Pour SELECT : true = fetchAll, false = fetch.
//  * 
//  * @return mixed Résultat du fetch pour SELECT, ou booléen pour autres requêtes.
//  */
function executeQuery(string $sql, array $params = [], bool $fetchAll = false) {
    $pdo = connectDB();

    try {
        $stmt = $pdo->prepare($sql);

        foreach ($params as $key => $value) {
            // Gestion des clés numériques ou nommées
            $paramKey = is_int($key) ? $key + 1 : $key;
            $stmt->bindValue($paramKey, $value);
        }

        $stmt->execute();

        // Si c'est une requête SELECT on retourne les données
       if (stripos(trim($sql), 'SELECT') === 0 || stripos($sql, 'RETURNING') !== false) {
            return $fetchAll ? $stmt->fetchAll() : $stmt->fetch();
        }

        // Sinon (INSERT, UPDATE, DELETE) on retourne true si succès
        return true;

    } catch (PDOException $e) {
        echo "Erreur SQL : " . $e->getMessage();
        return false;
    }
}