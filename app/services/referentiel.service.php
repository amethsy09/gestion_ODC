<?php
require_once "../app/models/promotion.model.php";

function listeReferentiel() {
    // Paramètres de pagination
    $itemsPerPage = 10;
    $currentPage = $_GET['page_num'] ?? 1;
    $searchTerm = $_GET['search'] ?? '';
    
    // Requête de base
    $sql = "SELECT * FROM referentiel";
    $params = [];
    
    // Ajout de la recherche si nécessaire
    if (!empty($searchTerm)) {
        $sql .= " WHERE nom ILIKE ?";
        $params[] = "%$searchTerm%";
    }
    
    // Comptage pour la pagination
    $countSql = str_replace('SELECT *', 'SELECT COUNT(*) as total', $sql);
    $totalItems = executeQuery($countSql, $params)['total'];
    $totalPages = ceil($totalItems / $itemsPerPage);
    
    // Ajout de la pagination à la requête principale
    $offset = ($currentPage - 1) * $itemsPerPage;
    $sql .= " ORDER BY nom LIMIT ? OFFSET ?";
    $params[] = $itemsPerPage;
    $params[] = $offset;
    
    // Récupération des données
    $referentiels = executeQuery($sql, $params, true);
    
    // Affichage de la vue
    RenderView("referentiel/listeReferentiel.html.php", [
        'referentiels' => $referentiels,
        'currentPage' => $currentPage,
        'totalPages' => $totalPages,
        'searchTerm' => $searchTerm
    ]);
}
function creerReferentiel($data) {
    $photoBinary = null;
    
    // Si une photo a été uploadée
    if (!empty($_FILES['photo']['tmp_name'])) {
        $photoBinary = file_get_contents($_FILES['photo']['tmp_name']);
    }
    
    $sql = "INSERT INTO referentiel (nom, description, duree_mois, capacite, photo) 
            VALUES (?, ?, ?, ?, ?)";
    return executeQuery($sql, [
        $data['nom'],
        $data['description'],
        $data['duree_mois'],
        $data['capacite'],
        $photoBinary  // Le contenu binaire de l'image
    ]);
}

function getReferentielById($id) {
    $sql = "SELECT id, nom, description, duree_mois, capacite, 
                   CASE WHEN photo IS NOT NULL THEN true ELSE false END AS has_photo 
            FROM referentiel 
            WHERE id = ?";
    return executeQuery($sql, [$id]);
}

function getReferentielPhoto($id) {
    $sql = "SELECT photo FROM referentiel WHERE id = ?";
    $result = executeQuery($sql, [$id]);
    return $result['photo'] ?? null;
}
function updateReferentielPhoto($id, $photoBinary) {
    $sql = "UPDATE referentiel SET photo = ? WHERE id = ?";
    return executeQuery($sql, [$photoBinary, $id]);
}
function handleCreateReferentiel() {
    $errors = [];
    $oldData = [];

    if (isPost()) {
        $oldData = [
            'nom' => trim($_POST['nom'] ?? ''),
            'description' => trim($_POST['description'] ?? ''),
            'duree_mois' => trim($_POST['duree_mois'] ?? ''),
            'capacite' => trim($_POST['capacite'] ?? '')
        ];

        // === Validation ===
        if (empty($oldData['nom'])) {
            $errors['nom'] = "Le nom est obligatoire";
        } elseif (strlen($oldData['nom']) > 100) {
            $errors['nom'] = "Le nom ne doit pas dépasser 100 caractères";
        }

        if (empty($oldData['duree_mois'])) {
            $errors['duree_mois'] = "La durée est obligatoire";
        } elseif (!ctype_digit($oldData['duree_mois']) || $oldData['duree_mois'] < 1) {
            $errors['duree_mois'] = "La durée doit être un nombre entier positif";
        }

        if (empty($oldData['capacite'])) {
            $errors['capacite'] = "La capacité est obligatoire";
        } elseif (!ctype_digit($oldData['capacite']) || $oldData['capacite'] < 1) {
            $errors['capacite'] = "La capacité doit être un nombre entier positif";
        }

        // === Image ===
        $photoBinary = null;
        if (empty($_FILES['photo']['name'])) {
            $errors['photo'] = "Une image est obligatoire";
        } else {
            try {
                $photoBinary = handlePhotoUpload();
            } catch (Exception $e) {
                $errors['photo'] = $e->getMessage();
            }
        }

        // === Insertion si pas d'erreur ===
        if (empty($errors)) {
            $data = $oldData;
            $data['photo'] = $photoBinary;

            $success = creerReferentiel($data);

            if ($success) {
                $_SESSION['flash'] = ['type' => 'success', 'message' => 'Référentiel créé avec succès'];
                redirect('referentiel', 'listeReferentiel');
            } else {
                $errors['general'] = "Erreur lors de la création du référentiel";
            }
        }
    }

    renderView("referentiel/formReferentiel.html.php", [
        'action' => 'creer',
        'errors' => $errors,
        'referentiel' => $oldData,
        'pageTitle' => 'Créer un référentiel'
    ]);
}
function handlePhotoUpload() {
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
    
    return file_get_contents($_FILES['photo']['tmp_name']);
}