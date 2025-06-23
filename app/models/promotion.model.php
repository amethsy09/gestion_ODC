<?php
require_once "../app/models/model.php";

function findAllPromotion(string $search = '', string $status = 'all'): array {
    $sql = "
        SELECT 
            p.id, 
            p.nom as promotion, 
            p.annee_debut, 
            p.annee_fin, 
            p.statut,
            p.photo,
            r.nom as referentiel,
            COUNT(a.id) as nombre_apprenants
        FROM promotion p
        LEFT JOIN promotion_referentiel pr ON p.id = pr.promotion_id
        LEFT JOIN referentiel r ON pr.referentiel_id = r.id
        LEFT JOIN apprenant a ON p.id = a.promotion_id
    ";

    $conditions = [];
    $params = [];

    // Ajouter les conditions de filtre
    if (!empty($search)) {
        $conditions[] = "p.nom LIKE ?";
        $params[] = "%$search%";
    }
    
    if ($status !== 'all') {
        $statusValue = ($status === 'active') ? 'Actif' : 'Inactif';
        $conditions[] = "p.statut = ?";
        $params[] = $statusValue;
    }

    // Construire la clause WHERE si nécessaire
    if (!empty($conditions)) {
        $sql .= " WHERE " . implode(' AND ', $conditions);
    }

    $sql .= " GROUP BY p.id, r.nom ORDER BY p.annee_debut DESC";

   return executeQuery($sql, $params, true);
}


function findPromotionById($id) {
    $sql = "
        SELECT 
            p.*,
            r.nom AS referentiel_nom
        FROM 
            promotion p
        LEFT JOIN 
            referentiel r ON p.referentiel_id = r.id
        WHERE 
            p.id = :id
    ";
    
    return executeQuery($sql, ['id' => $id]);
}

function createPromotion($data) {
    $sql = "
        INSERT INTO promotion 
            (nom, annee_debut, annee_fin, referentiel_id, statut) 
        VALUES 
            (:nom, :annee_debut, :annee_fin, :referentiel_id, :statut)
    ";
    
    return executeQuery($sql, $data);
}

function updatePromotion($id, $data) {
    $sql = "
        UPDATE promotion SET 
            nom = :nom,
            annee_debut = :annee_debut,
            annee_fin = :annee_fin,
            referentiel_id = :referentiel_id,
            statut = :statut
        WHERE 
            id = :id
    ";
    
    $data['id'] = $id;
    return executeQuery($sql, $data);
}

function deletePromotion($id) {
    $sql = "DELETE FROM promotion WHERE id = :id";
    return executeQuery($sql, ['id' => $id]);
}

function getReferentiels() {
    $sql = "SELECT id, nom FROM referentiel ORDER BY nom";
    return executeQuery($sql, [], true);
}
function promotionExists(string $nom): bool {
    $result = executeQuery(
        "SELECT COUNT(*) as count FROM promotion WHERE nom = ?", 
        [$nom]
    );
    return $result && $result['count'] > 0;
}

function getExistingReferentiels(array $ids): array {
    if (empty($ids)) return [];
    
    $placeholders = implode(',', array_fill(0, count($ids), '?'));
    $result = executeQuery(
        "SELECT id FROM referentiel WHERE id IN ($placeholders)", 
        $ids,
        true
    );
    
    return $result ? array_column($result, 'id') : [];
}