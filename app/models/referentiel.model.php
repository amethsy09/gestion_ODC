<?php
// app/models/referentiel.model.php

function getAllReferentiels($searchTerm = '') {
    $sql = "SELECT * FROM referentiel";
    $params = [];

    if (!empty($searchTerm)) {
        $sql .= " WHERE nom ILIKE ?";
        $params[] = "%$searchTerm%";
    }

    $sql .= " ORDER BY id DESC";
    return executeQuery($sql, $params, true);
}

function createReferentiel($data) {
    $sql = "INSERT INTO referentiel 
            (nom, description, duree_mois, capacite, photo, sessions_per_year) 
            VALUES (?, ?, ?, ?, ?, ?)";

    $params = [
        $data['nom'],
        !empty($data['description']) ? $data['description'] : null,
        $data['duree_mois'],
        $data['capacite'],
        $data['photo'],
        $data['sessions_per_year']
    ];

    $pdo = connectDB();
    $stmt = $pdo->prepare($sql);
    
    $stmt->bindValue(1, $params[0]);
    $stmt->bindValue(2, $params[1]);
    $stmt->bindValue(3, $params[2], PDO::PARAM_INT);
    $stmt->bindValue(4, $params[3], PDO::PARAM_INT);
    $stmt->bindValue(5, $params[4], PDO::PARAM_LOB);
    $stmt->bindValue(6, $params[5], PDO::PARAM_INT);
    
    return $stmt->execute();
}

function getReferentielById($id) {
    $sql = "SELECT id, nom, description, duree_mois, capacite, 
            CASE WHEN photo IS NOT NULL THEN true ELSE false END AS has_photo 
            FROM referentiel 
            WHERE id = ?";
    return executeQuery($sql, [$id]);
}

function getReferentielPhoto($id) {
    $sql = "SELECT photo FROM referentiel WHERE id = ?";
    $result = executeQuery($sql, [$id]);
    return $result['photo'] ?? null;
}

function updateReferentielPhoto($id, $photoBinary) {
    $sql = "UPDATE referentiel SET photo = ? WHERE id = ?";
    return executeQuery($sql, [$photoBinary, $id]);
}