<?php
require_once "../app/services/apprenant.service.php";
require_once "../app/models/apprenant.model.php";

// Vérifie l'authentification
NotReturn();
$page = $_GET['page'] ?? 'listeApprenant';
$search = $_GET['search'] ?? '';
$id = isset($_GET['id']) ? (int)$_GET['id'] : null;
try {
    switch ($page) {
        case "listeApprenant":
            RenderView("apprenant/listeApprenant.html.php", [
        
    ]);
            // if (isPost() && isset($_POST['action']) && $_POST['action'] === 'add_apprenant') {
            //     creerApprenantHandler();
            // } else {
            //     listeApprenant();
            // }
            break;
     }
     } catch (Exception $e) {
    error_log("Erreur dans le contrôleur des apprenants : " . $e->getMessage());
    renderView("error.html.php", ['message' => $e->getMessage()]);
}