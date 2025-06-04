<?php
require_once "../app/services/apprenant.service.php";
require_once "../app/models/apprenant.model.php";

// Vérifie l'authentification
NotReturn();

// Initialisation de la session pour stocker les erreurs et les anciennes entrées
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Nettoyage des messages d'erreur de la session
if (!isset($_SESSION['form_errors'])) {
    $_SESSION['form_errors'] = [];
}
if (!isset($_SESSION['old_input'])) {
    $_SESSION['old_input'] = [];
}

$page = $_GET['page'] ?? 'listeApprenant';
$search = $_GET['search'] ?? '';
$id = isset($_GET['id']) ? (int)$_GET['id'] : null;

try {
    switch ($page) {
        case "listeApprenant":
            if (isPost() && isset($_POST['action'])) {
                if ($_POST['action'] === 'add_apprenant') {
                    creerApprenantHandler();
                } elseif ($_POST['action'] === 'update_apprenant') {
                    // Gérer la mise à jour si nécessaire
                }
            } else {
                listeApprenant();
            }
            break;

        default:
            redirect('apprenant', 'listeApprenant');
    }
} catch (Exception $e) {
    error_log("Erreur dans le contrôleur des apprenants : " . $e->getMessage());
    
    // Stocker l'erreur dans la session
    $_SESSION['error_message'] = $e->getMessage();
    
    // Rediriger vers la page précédente ou la liste des apprenants
    if (isset($_SERVER['HTTP_REFERER'])) {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    } else {
        redirect('apprenant', 'listeApprenant');
    }
    exit();
}
