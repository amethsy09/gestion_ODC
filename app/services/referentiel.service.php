<?php
require_once "../app/models/promotion.model.php";

function listeReferentiel() {
    // Paramètres de pagination
    $itemsPerPage = 10;
    $currentPage = $_GET['page_num'] ?? 1;
    $searchTerm = $_GET['search'] ?? '';
    
    // Requête de base
    $sql = "SELECT * FROM referentiel";
    $params = [];
    
    // Ajout de la recherche si nécessaire
    if (!empty($searchTerm)) {
        $sql .= " WHERE nom ILIKE ?";
        $params[] = "%$searchTerm%";
    }
    
    // Comptage pour la pagination
    $countSql = str_replace('SELECT *', 'SELECT COUNT(*) as total', $sql);
    $totalItems = executeQuery($countSql, $params)['total'];
    $totalPages = ceil($totalItems / $itemsPerPage);
    
    // Ajout de la pagination à la requête principale
    $offset = ($currentPage - 1) * $itemsPerPage;
    $sql .= " ORDER BY nom LIMIT ? OFFSET ?";
    $params[] = $itemsPerPage;
    $params[] = $offset;
    
    // Récupération des données
    $referentiels = executeQuery($sql, $params, true);
    
    // Affichage de la vue
    RenderView("referentiel/listeReferentiel.html.php", [
        'referentiels' => $referentiels,
        'currentPage' => $currentPage,
        'totalPages' => $totalPages,
        'searchTerm' => $searchTerm
    ]);
}
function creerReferentiel($data) {
    $sql = "INSERT INTO referentiel (nom, description, duree_mois, capacite) 
            VALUES (?, ?, ?, ?)";
    return executeQuery($sql, [
        $data['nom'],
        $data['description'],
        $data['duree_mois'],
        $data['capacite']
    ]);
}
function getReferentielById($id) {
    $sql = "SELECT * FROM referentiel WHERE id = ?";
    return executeQuery($sql, [$id]);
}