<?php
require_once "../app/models/referentiel.model.php";
require_once "../app/models/model.php";
function listeReferentiel() {
    $searchTerm = $_GET['search'] ?? '';
    $referentiels = getAllReferentiels($searchTerm);
    
    RenderView("referentiel/listeReferentiel.html.php", [
        'referentiels' => $referentiels,
        'searchTerm' => $searchTerm
    ]);
}

function creerReferentielHandler() {
    if (isPost() && isset($_POST['action']) && $_POST['action'] === 'add_referentiel') {
        try {
            // Validation des champs
            $requiredFields = ['nom', 'duree_mois', 'capacite', 'sessions_per_year'];
            $errors = [];
            
            foreach ($requiredFields as $field) {
                if (empty($_POST[$field])) {
                    $errors[$field] = "Ce champ est obligatoire";
                }
            }
            
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
            
            $data = [
                'nom' => $_POST['nom'],
                'description' => $_POST['description'] ?? null,
                'duree_mois' => (int)$_POST['duree_mois'],
                'capacite' => (int)$_POST['capacite'],
                'photo' => $photoBinary,
                'sessions_per_year' => (int)$_POST['sessions_per_year']
            ];
            
            if (createReferentiel($data)) {
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

function handlePhotoUpload() {
    if (!isset($_FILES['photo']) || $_FILES['photo']['error'] === UPLOAD_ERR_NO_FILE) {
        return null;
    }

    if ($_FILES['photo']['error'] !== UPLOAD_ERR_OK) {
        throw new Exception("Erreur lors du téléchargement de l'image");
    }

    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    $maxSize = 2 * 1024 * 1024;

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
