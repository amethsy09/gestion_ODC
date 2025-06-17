<?php
checkAuth();
require_once "../app/services/referentiel.service.php";
require_once "../app/models/referentiel.model.php";

// Vérifie l'authentification
$page = $_GET['page'] ?? 'listeReferentiel';
$search = $_GET['search'] ?? '';
$id = isset($_GET['id']) ? (int)$_GET['id'] : null;

try {
    switch ($page) {
        case "listeReferentiel":
            if (isPost() && isset($_POST['action']) && $_POST['action'] === 'add_referentiel') {
                creerReferentielHandler();
            } else {
                listeReferentiel();
            }
            break;
                
        default:
            redirect('referentiel', 'listeReferentiel');
    }
} catch (Exception $e) {
    error_log("Erreur dans le contrôleur des référentiels : " . $e->getMessage());
    renderView("error.html.php", ['message' => $e->getMessage()]);
}