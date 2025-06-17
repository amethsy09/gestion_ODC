<?php

function getApprenants($filters = []) {
    $searchTerm = $filters['search'] ?? '';
    $referentiel = $filters['referentiel'] ?? null;
    $promotion = $filters['promotion'] ?? null;
    $statut = $filters['statut'] ?? null;

    $sql = "SELECT a.*, 
                   a.referentiel as nom_referentiel,
                   p.nom as nom_promotion
            FROM apprenant a
            LEFT JOIN promotion p ON a.promotion_id = p.id
            WHERE 1=1";

    $params = [];

    if (!empty($searchTerm)) {
        $sql .= " AND (a.matricule ILIKE ? OR 
                     CONCAT(a.prenom, ' ', a.nom) ILIKE ? OR
                     a.telephone ILIKE ? OR
                     r.nom ILIKE ? OR
                     p.nom ILIKE ? OR
                     a.statut ILIKE ?)";
        $params = array_merge($params, array_fill(0, 6, "%$searchTerm%"));
    }

    if (!empty($referentiel)) {
        $sql .= " AND a.referentiel = ?";
        $params[] = $referentiel;
    }

    if (!empty($promotion)) {
        $sql .= " AND a.promotion_id = ?";
        $params[] = $promotion;
    }

    if (!empty($statut)) {
        $sql .= " AND a.statut = ?";
        $params[] = $statut;
    }

    $sql .= " ORDER BY a.nom, a.prenom";

    return executeQuery($sql, $params, true);
}

function createApprenant($data) {
    $sql = "INSERT INTO apprenant 
            (photo, matricule, prenom, nom, telephone, email, referentiel, promotion_id, statut) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?) RETURNING id";

    $params = [
        $data['photo'],
        $data['matricule'],
        $data['prenom'],
        $data['nom'],
        $data['telephone'],
        $data['email'],
        $data['referentiel'],
        $data['promotion_id'],
        $data['statut']
    ];

    $pdo = connectDB();
    $stmt = $pdo->prepare($sql);
    
    foreach ($params as $i => $value) {
        $paramType = is_int($value) ? PDO::PARAM_INT : 
                     (is_resource($value) ? PDO::PARAM_LOB : PDO::PARAM_STR);
        $stmt->bindValue($i + 1, $value, $paramType);
    }

    $stmt->execute();
    // Récupère l'ID retourné par PostgreSQL
    return $stmt->fetchColumn();
}


function getApprenantById($id) {
    $sql = "SELECT a.*, 
                   r.nom as nom_referentiel,
                   p.nom as nom_promotion,
                   CASE WHEN a.photo IS NOT NULL THEN true ELSE false END AS has_photo
            FROM apprenant a
            LEFT JOIN referentiel r ON a.referentiel = r.id::text
            LEFT JOIN promotion p ON a.promotion_id = p.id
            WHERE a.id = ?";
    return executeQuery($sql, [$id]);
}

function getApprenantPhoto($id) {
    $sql = "SELECT photo FROM apprenant WHERE id = ?";
    $result = executeQuery($sql, [$id]);
    return $result['photo'] ?? null;
}

function updateApprenantPhoto($id, $photoBinary) {
    $sql = "UPDATE apprenant SET photo = ? WHERE id = ?";
    return executeQuery($sql, [$photoBinary, $id]);
}

function updateApprenant($id, $data) {
    $sql = "UPDATE apprenant SET 
            photo = ?,
            matricule = ?,
            prenom = ?,
            nom = ?,
            telephone = ?,
            email = ?,
            referentiel = ?,
            statut = ?
            WHERE id = ?";

    $params = [
        $data['photo'],
        $data['matricule'],
        $data['prenom'],
        $data['nom'],
        $data['telephone'],
        $data['email'],
        $data['referentiel'],
        $data['statut'],
        $id
    ];

    return executeQuery($sql, $params);
}

function updateApprenantStatus($id, $nouveauStatut) {
    $sql = "UPDATE apprenant SET statut = ? WHERE id = ?";
    return executeQuery($sql, [$nouveauStatut, $id]);
}

function deleteApprenant($id) {
    $sql = "DELETE FROM apprenant WHERE id = ?";
    return executeQuery($sql, [$id]);
}

function getApprenantFilterOptions() {
    $referentiels = executeQuery("SELECT DISTINCT referentiel FROM apprenant ORDER BY referentiel", [], true);
    $promotions = executeQuery("SELECT id, nom FROM promotion ORDER BY nom", [], true);
    $statuts = executeQuery("SELECT DISTINCT statut FROM apprenant ORDER BY statut", [], true);

    return [
        'referentiels' => $referentiels,
        'promotions' => $promotions,
        'statuts' => array_column($statuts, 'statut')
    ];
}