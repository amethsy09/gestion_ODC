<?php
require_once "../app/models/referentiel.model.php";
require_once "../app/models/model.php";

    function listeReferentiel()
{
    $searchTerm = $_GET['search'] ?? '';
    // Requête de base
    $sql = "SELECT * FROM referentiel";
    $params = [];

    // Ajout de la recherche si nécessaire
    if (!empty($searchTerm)) {
        $sql .= " WHERE nom ILIKE ?";
        $params[] = "%$searchTerm%";
    }

    // Ajout du tri
    $sql .= " ORDER BY id DESC";

    // Récupération des données
    $referentiels = executeQuery($sql, $params, true); 
    // Affichage de la vue
    RenderView("referentiel/listeReferentiel.html.php", [
        'referentiels' => $referentiels,
        'searchTerm' => $searchTerm
    ]);
}

function creerReferentielHandler()
{
    if (isPost() && isset($_POST['action']) && $_POST['action'] === 'add_referentiel') {
        try {
            // Validation des champs obligatoires
            $requiredFields = ['nom', 'duree_mois', 'capacite', 'sessions_per_year'];
            $errors = [];
            
            foreach ($requiredFields as $field) {
                if (empty($_POST[$field])) {
                    $errors[$field] = "Ce champ est obligatoire";
                }
            }
            
            // Validation numérique
            $numericFields = ['duree_mois', 'capacite', 'sessions_per_year'];
            foreach ($numericFields as $field) {
                if (!empty($_POST[$field]) && !is_numeric($_POST[$field])) {
                    $errors[$field] = "Valeur numérique invalide";
                }
            }
            
            if (!empty($errors)) {
                throw new Exception("Veuillez corriger les erreurs dans le formulaire");
            }
            
            $photoBinary = handlePhotoUpload();
            // La photo peut être optionnelle selon vos besoins
            // if ($photoBinary === null) {
            //     throw new Exception("Une photo est obligatoire");
            // }
            
            $data = [
                'nom' => $_POST['nom'],
                'description' => $_POST['description'] ?? null,
                'duree_mois' => (int)$_POST['duree_mois'],
                'capacite' => (int)$_POST['capacite'],
                'photo' => $photoBinary, 
                'sessions_per_year' => (int)$_POST['sessions_per_year']
            ];
            
            if (creerReferentiel($data)) {
                $_SESSION['flash'] = ['type' => 'success', 'message' => 'Référentiel créé avec succès'];
                header("Location: ?controllers=referentiel&page=listeReferentiel");
                exit;
            }
        } catch (Exception $e) {
            $_SESSION['flash'] = ['type' => 'error', 'message' => $e->getMessage()];
            $_SESSION['old_input'] = $_POST;
            $_SESSION['form_errors'] = $errors ?? [];
        }
    }
}

function creerReferentiel(array $data): bool
{
    $sql = "INSERT INTO referentiel 
            (nom, description, duree_mois, capacite, photo, sessions_per_year) 
            VALUES (?, ?, ?, ?, ?, ?)";

    $params = [
        $data['nom'],
        !empty($data['description']) ? $data['description'] : null,
        $data['duree_mois'],
        $data['capacite'],
        $data['photo'],  // Doit contenir les données binaires brutes (pas base64)
        $data['sessions_per_year']
    ];

    // Version spéciale pour gérer le LOB
    $pdo = connectDB();
    $stmt = $pdo->prepare($sql);
    
    $stmt->bindValue(1, $params[0]);
    $stmt->bindValue(2, $params[1]);
    $stmt->bindValue(3, $params[2], PDO::PARAM_INT);
    $stmt->bindValue(4, $params[3], PDO::PARAM_INT);
    $stmt->bindValue(5, $params[4], PDO::PARAM_LOB);  // Spécifie que c'est un LOB
    $stmt->bindValue(6, $params[5], PDO::PARAM_INT);
    
    return $stmt->execute();
}

function getReferentielById($id)
{
    $sql = "SELECT id, nom, description, duree_mois, capacite, 
            CASE WHEN photo IS NOT NULL THEN true ELSE false END AS has_photo 
            FROM referentiel 
            WHERE id = ?";
    return executeQuery($sql, [$id]);
}

function getReferentielPhoto($id)
{
    $sql = "SELECT photo FROM referentiel WHERE id = ?";
    $result = executeQuery($sql, [$id]);
    return $result['photo'] ?? null;
}

function updateReferentielPhoto($id, $photoBinary)
{
    $sql = "UPDATE referentiel SET photo = ? WHERE id = ?";
    return executeQuery($sql, [$photoBinary, $id]);
}

function handlePhotoUpload()
{
    if (!isset($_FILES['photo']) || $_FILES['photo']['error'] === UPLOAD_ERR_NO_FILE) {
        return null;
    }

    if ($_FILES['photo']['error'] !== UPLOAD_ERR_OK) {
        throw new Exception("Erreur lors du téléchargement de l'image");
    }

    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    $maxSize = 2 * 1024 * 1024; // 2MB

    $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($fileInfo, $_FILES['photo']['tmp_name']);
    finfo_close($fileInfo);

    if (!in_array($mime, $allowedTypes)) {
        throw new Exception("Format d'image non supporté (seuls JPG, PNG et GIF sont autorisés)");
    }

    if ($_FILES['photo']['size'] > $maxSize) {
        throw new Exception("La taille de l'image ne doit pas dépasser 2MB");
    }

    // Retourne directement les données binaires sans encodage base64
    return file_get_contents($_FILES['photo']['tmp_name']);
}
