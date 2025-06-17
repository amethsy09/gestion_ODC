<?php
// checkAuth(); // Vérification de l'authentification
require_once "../app/controllers/controller.php";

// Empêcher la mise en cache des pages sensibles
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1
header("Pragma: no-cache"); // HTTP 1.0
header("Expires: 0"); // Proxies

// Gestion de la page demandée
$page = $_GET['page'] ?? 'login';

if ($page == 'logout') {
    logout();
} elseif ($page == 'login') {
    login();
}

function login() {
    // Si déjà connecté, rediriger vers la page d'accueil
    if (isset($_SESSION['user'])) {
        redirect('promotion', 'listePromotion');
        exit(); // Important pour arrêter l'exécution
    }
    
    $_SESSION['error'] = [];

    if (isPost()) {
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');

        // Validation email
        if (empty($email)) {
            $_SESSION['error']['email'] = 'Veuillez saisir votre adresse email';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error']['email'] = 'Veuillez saisir une adresse email valide';
        }

        // Validation mot de passe
        if (empty($password)) {
            $_SESSION['error']['password'] = 'Veuillez saisir votre mot de passe';
        } elseif (strlen($password) < 8) {
            $_SESSION['error']['password'] = 'Le mot de passe doit comporter au moins 8 caractères';
        }

        // Si pas d'erreur -> authentification
        if (empty($_SESSION['error'])) {
            $user = getUserByEmail($email); 
            
            if (!$user) {
                $_SESSION['error']['email'] = 'Cette adresse email n\'existe pas';
            } else {
                $user = loginabc($email, $password);
                if ($user && $user['mot_de_passe'] === $password) {
                    $_SESSION['user'] = $user;
                    
                    // Régénérer l'ID de session pour prévenir les attaques de fixation
                    session_regenerate_id(true);
                    
                    switch ($user['role']) {
                        case 'admin':
                            redirect('promotion', 'listePromotion');
                            break;
                        default:
                            redirect('auth', 'login');
                    }
                    exit();
                } else {
                    $_SESSION['error']['global'] = 'Mot de passe incorrect';
                }
            }
        }
    }

    renderView("security/login.html.php", ['error' => $_SESSION['error']], "security");
}

function logout() {
    // Détruire complètement la session
    $_SESSION = array();
    
    // Supprimer le cookie de session
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    
    session_destroy();
    
    // Rediriger vers la page de login avec des headers pour empêcher le cache
    header("Location: index.php?page=login");
    exit();
}



