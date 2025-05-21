<?php
require_once "../app/services/promotion.service.php";
require_once "../app/models/promotion.model.php";
// require_once "../helpers/functions.php";

// Vérifie l'authentification
NotReturn();

// Récupère les paramètres GET
$page = $_GET['page'] ?? 'listePromotion';
$id = isset($_GET['id']) ? (int)$_GET['id'] : null;

try {
    switch ($page) {
        case "listePromotion":
            showPromotionList();
            break;
            
            case "creer":
                handleCreatePromotion();
                break;
                
                
                case "editer":
                    // dd("listePromotion");
                    if (!$id) {
                        $_SESSION['flash_message'] = ['type' => 'warning', 'message' => 'ID manquant'];
                        header("Location: " . WEBROOT . "?controllers=promotion&page=listePromotion");
                        exit();
                    }
                    handleUpdatePromotion($id);
                    break;
                    
                    case "supprimer":
                        if (!$id) {
                            $_SESSION['flash_message'] = ['type' => 'warning', 'message' => 'ID manquant'];
                        } else {
                            handleDeletePromotion($id);
                        }
                        break;
                        
                        case "voir":
            if (!$id) {
                $_SESSION['flash_message'] = ['type' => 'warning', 'message' => 'ID manquant'];
                header("Location: " . WEBROOT . "?controllers=promotion&page=listePromotion");
                exit();
            }
            showPromotionDetails($id);
            break;

        default:
            header("Location: " . WEBROOT . "?controllers=promotion&page=listePromotion");
            exit();
    }
} catch (Exception $e) {
    error_log("Erreur dans le contrôleur des promotions : " . $e->getMessage());
    renderView("error.html.php", ['message' => $e->getMessage()]);
}
