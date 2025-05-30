<?php
require_once "../app/controllers/controller.php";
// Gestion de la page demandée
$page = $_GET['page'] ?? 'login';
if ($page == 'login') {
    login();
} elseif ($page == 'logout') {
    logout();
}
function login() {
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
            // Vérifier d'abord si l'email existe
            $user = getUserByEmail($email); 
            
            if (!$user) {
                $_SESSION['error']['email'] = 'Cette adresse email n\'existe pas';
            } else {
                // Maintenant vérifier le mot de passe
                $user = loginabc($email, $password);
                if ($user && $user['mot_de_passe'] === $password) {
                    $_SESSION['user'] = $user;
                    
                    switch ($user['role']) {
                        case 'admin':
                            redirect('promotion', 'listePromotion');
                            break;
                        default:
                            redirect('auth', 'login');
                    }
                } else {
                    $_SESSION['error']['global'] = 'Mot de passe incorrect';
                }
            }
        }
    }

    renderView("security/login.html.php", ['error' => $_SESSION['error']], "security");
}

function logout() {
    session_unset();
    session_destroy();
    redirect('auth', 'login');
}