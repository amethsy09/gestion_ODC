<?php
require_once "../app/models/model.php";

function findAllPromotion() {
    $sql = "
        SELECT 
            p.id,
            p.nom AS promotion,
            CONCAT(p.annee_debut, '-', p.annee_fin) AS periode,
            p.annee_debut,
            p.annee_fin,
            p.statut,
            COUNT(a.id) AS nombre_apprenants,
            r.nom AS referentiel
        FROM 
            promotion p
        LEFT JOIN 
            apprenant a ON p.id = a.promotion_id
        LEFT JOIN 
            referentiel r ON p.referentiel_id = r.id
        GROUP BY 
            p.id, p.nom, p.annee_debut, p.annee_fin, p.statut, r.nom
        ORDER BY 
            p.annee_debut DESC;
    ";
    
    return executeQuery($sql, [], true);
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