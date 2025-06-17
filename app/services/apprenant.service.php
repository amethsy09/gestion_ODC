<?php
require_once __DIR__ . "/../models/apprenant.model.php";
require_once __DIR__ . "/../models/model.php";


function listeApprenant() {
    $filters = [
        'search' => $_GET['search'] ?? '',
        'referentiel' => $_GET['referentiel'] ?? null,
        'promotion' => $_GET['promotion'] ?? null,
        'statut' => $_GET['statut'] ?? null
    ];

    $apprenants = getApprenants($filters);
    $filterOptions = getApprenantFilterOptions();

    RenderView("apprenant/listeApprenant.html.php", [
        'apprenants' => $apprenants,
        'searchTerm' => $filters['search'],
        'selected_referentiel' => $filters['referentiel'],
        'selected_promotion' => $filters['promotion'],
        'selected_statut' => $filters['statut'],
        'referentiels' => $filterOptions['referentiels'],
        'promotions' => $filterOptions['promotions'],
        'statuts' => $filterOptions['statuts']
    ]);
}

function creerApprenantHandler() {
    $_SESSION['old_input'] = $_POST;
    
    $requiredFields = [
        'matricule' => 'Matricule',
        'prenom' => 'Prénom', 
        'nom' => 'Nom',
        'telephone' => 'Téléphone',
        'email' => 'Email',
        'referentiel' => 'Référentiel',
        'promotion_id' => 'Promotion',
        'statut' => 'Statut'
    ];    
    $errors = [];
    
    foreach ($requiredFields as $field => $label) {
        if (empty(trim($_POST[$field] ?? ''))) {
            $errors[$field] = "Le champ $label est obligatoire";
        }
    }
    
    if (!filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL) && !isset($errors['email'])) {
        $errors['email'] = "Email invalide";
    }
    
    $phone = preg_replace('/[^0-9]/', '', $_POST['telephone'] ?? '');
    if (strlen($phone) < 9 && !isset($errors['telephone'])) {
        $errors['telephone'] = "Téléphone invalide (min 9 chiffres)";
    }
    
    if (!isset($errors['matricule'])) {
        $existing = executeQuery("SELECT id FROM apprenant WHERE matricule = ?", [$_POST['matricule']]);
        if ($existing) {
            $errors['matricule'] = "Matricule déjà utilisé";
        }
    }
    
    if (!empty($errors)) {
        $_SESSION['form_errors'] = $errors;
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }


    try {
        $photoBinary = handlePhotoUpload();

        $data = [
            'matricule' => $_POST['matricule'],
            'prenom' => $_POST['prenom'],
            'nom' => $_POST['nom'],
            'telephone' => $_POST['telephone'],
            'email' => $_POST['email'],
            'referentiel' => $_POST['referentiel'],
            'promotion_id' => $_POST['promotion_id'],
            'statut' => $_POST['statut'],
            'photo' => $photoBinary
        ];
            

        $apprenantId = createApprenant($data);
    dd($apprenantId);


        if ($apprenantId) {

            unset($_SESSION['form_errors'], $_SESSION['old_input']);
            $_SESSION['success_message'] = "Apprenant ajouté avec succès";
            exit();
        }
    } catch (Exception $e) {
        error_log("Erreur création apprenant: " . $e->getMessage());
        $_SESSION['error_message'] = $e->getMessage();
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }
}

function handlePhotoUpload() {
    if (!isset($_FILES['photo']) || $_FILES['photo']['error'] === UPLOAD_ERR_NO_FILE) {
        return null;
    }

    if ($_FILES['photo']['error'] !== UPLOAD_ERR_OK) {
        throw new Exception("Erreur lors du téléchargement de la photo");
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
        throw new Exception("La taille de la photo ne doit pas dépasser 2MB");
    }

    return file_get_contents($_FILES['photo']['tmp_name']);
}