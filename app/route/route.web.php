<?php
// router.php
require_once "../app/config/database.php";
require_once "../app/controllers/controller.php";
$controllers = [
    "promotion" => "../app/controllers/promotion.controller.php",
    "referentiel" => "../app/controllers/referentiel.controller.php",
    "apprenant" => "../app/controllers/apprenant.controller.php",
    "auth"  => "../app/controllers/auth.controller.php"
];

function loadController(): void
{
    
    global $controllers;
    // Contrôleur demandé ou fallback sur 'security'
    $controller = $_GET['controllers'] ?? 'auth';

    // Vérification de l'existence du contrôleur
    if (array_key_exists($controller, $controllers)) {
        require_once  $controllers[$controller];
    } else {
        require_once $controllers['auth'];
        
    }
}
