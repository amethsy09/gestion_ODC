<?php
require_once "../app/services/referentiel.service.php";
require_once "../app/models/referentiel.model.php";
// require_once "../helpers/functions.php";

// Vérifie l'authentification
NotReturn();
$page = $_GET['page'] ?? 'listeReferentiel';
$search = $_GET['search'] ?? '';
$id = isset($_GET['id']) ? (int)$_GET['id'] : null;


try {
    switch ($page) {
        case "listeReferentiel":
            listeReferentiel();
            break;
            
        case "creer":
            handleCreateReferentiel();
            break;
                
        default:
            redirect('referentiel', 'listeReferentiel');
    }
} catch (Exception $e) {
    error_log("Erreur dans le contrôleur des référentiels : " . $e->getMessage());
    renderView("error.html.php", ['message' => $e->getMessage()]);
}
