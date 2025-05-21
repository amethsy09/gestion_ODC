<?php
// helpers/functions.php
require_once "../app/config/database.php";
// Fonction pour afficher une vue avec un layout
function renderView(string $view, array $datas = [], string $layout = "base") {
    ob_start();
    extract($datas);
    require_once "../app/views/$view";
    $content = ob_get_clean();
    require_once "../app/views/layout/$layout.layout.html.php";
}

function redirect(string $controller, string $page): void {
    $webroot = rtrim(WEBROOT, '/'); // Supprime le slash final s'il existe
    $url = "{$webroot}/?controllers={$controller}&page={$page}";
    header("Location: $url");
    exit;
}
// function redirect($controller, $page) {
//     if (defined('WEBROOT')) {
//         header('Location: ' . WEBROOT . '?controllers=' .($controller) . '&page='.($page));
//         exit;
//     } else {
//         echo "Erreur : La constante WEBROOT n'est pas définie.";
//     }
// }
// Debug et arrêt de l'exécution
function dd($var) {
    echo '<pre>';
    var_dump($var);
    echo '</pre>';
    die();
}

// Vérifie si la méthode est POST
function isPost(): bool {
    return $_SERVER["REQUEST_METHOD"] == "POST";
}

// Vérifie si la méthode est GET
function isGet(): bool {
    return $_SERVER["REQUEST_METHOD"] == "GET";
}

// Redirige si l'utilisateur n'est pas connecté
function NotReturn() {
    if (!isset($_SESSION["user"])) {
        redirect('auth', 'login');
        exit;
    }
}

// Vérifie si l'utilisateur est connecté
function isConnect(): bool {
    return isset($_SESSION["user"]);
}


function loginabc(string $email, string $password): array|bool
{
    $pdo = connectDB();
    $sql = "SELECT u.*, r.nom as role FROM utilisateur u
            JOIN role r ON r.id = u.role_id
            WHERE u.email = :email AND u.mot_de_passe = :password";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':email' => $email,
            ':password' => $password
        ]);
        return $stmt->fetch();
    } catch(PDOException $e) {
        echo "Erreur de requête SELECT : " . $e->getMessage();
        return false;
    }
}
