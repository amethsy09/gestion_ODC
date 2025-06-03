<?php
require_once "../app/models/apprenant.model.php";
require_once "../app/models/model.php";

function listeApprenant()
{
    $searchTerm = $_GET['search'] ?? '';
    $referentiel = $_GET['referentiel'] ?? null;
    $promotion = $_GET['promotion'] ?? null;
    $statut = $_GET['statut'] ?? null;

    // Requête de base avec jointures
    $sql = "SELECT a.*, 
                   r.nom as nom_referentiel,
                   p.nom as nom_promotion
            FROM apprenant a
            LEFT JOIN referentiel r ON a.referentiel = r.id
            LEFT JOIN promotion p ON a.promotion_id = p.id
            WHERE 1=1";

    $params = [];

    // Ajout des conditions de recherche
    if (!empty($searchTerm)) {
        $sql .= " AND (a.matricule ILIKE ? OR 
                     CONCAT(a.prenom, ' ', a.nom) ILIKE ? OR
                     a.telephone ILIKE ? OR
                     r.nom ILIKE ? OR
                     p.nom ILIKE ? OR
                     a.statut ILIKE ?)";
        $params = array_merge($params, array_fill(0, 6, "%$searchTerm%"));
    }

    // Filtre par référentiel
    if (!empty($referentiel)) {
        $sql .= " AND a.referentiel = ?";
        $params[] = $referentiel;
    }

    // Filtre par promotion
    if (!empty($promotion)) {
        $sql .= " AND a.promotion_id = ?";
        $params[] = $promotion;
    }

    // Filtre par statut
    if (!empty($statut)) {
        $sql .= " AND a.statut = ?";
        $params[] = $statut;
    }

    // Ajout du tri
    $sql .= " ORDER BY a.nom, a.prenom";

    // Exécution de la requête
    $apprenants = executeQuery($sql, $params, true);

    // Récupération des options de filtre
    $referentiels = executeQuery("SELECT DISTINCT referentiel FROM apprenant ORDER BY referentiel", [], true);
    $promotions = executeQuery("SELECT id, nom FROM promotion ORDER BY nom", [], true);
    $statuts = executeQuery("SELECT DISTINCT statut FROM apprenant ORDER BY statut", [], true);

    // Affichage de la vue
    RenderView("apprenant/listeApprenant.html.php", [
        'apprenants' => $apprenants,
        'searchTerm' => $searchTerm,
        'selected_referentiel' => $referentiel,
        'selected_promotion' => $promotion,
        'selected_statut' => $statut,
        'referentiels' => $referentiels,
        'promotions' => $promotions,
        'statuts' => array_column($statuts, 'statut')
    ]);
}

function creerApprenantHandler()
{
    if (isPost() && isset($_POST['action']) && $_POST['action'] === 'add_apprenant') {
        try {
            // Validation des champs obligatoires
            $requiredFields = ['matricule', 'prenom', 'nom', 'telephone', 'referentiel', 'statut'];
            $errors = [];

            foreach ($requiredFields as $field) {
                if (empty($_POST[$field])) {
                    $errors[$field] = "Ce champ est obligatoire";
                }
            }

            // Validation du matricule unique
            $existing = executeQuery("SELECT id FROM apprenant WHERE matricule = ?", [$_POST['matricule']]);
            if ($existing) {
                $errors['matricule'] = "Ce matricule est déjà utilisé";
            }

            if (!empty($errors)) {
                throw new Exception("Veuillez corriger les erreurs dans le formulaire");
            }

            $photoBinary = handlePhotoUpload();

            $data = [
                'photo' => $photoBinary,
                'matricule' => $_POST['matricule'],
                'prenom' => $_POST['prenom'],
                'nom' => $_POST['nom'],
                'telephone' => $_POST['telephone'],
                'referentiel' => $_POST['referentiel'],
                'statut' => $_POST['statut'],


            ];

            if (creerApprenant($data)) {
                $_SESSION['flash'] = ['type' => 'success', 'message' => 'Apprenant créé avec succès'];
                header("Location: ?controllers=apprenant&page=listeApprenant");
                exit;
            }
        } catch (Exception $e) {
            $_SESSION['flash'] = ['type' => 'error', 'message' => $e->getMessage()];
            $_SESSION['old_input'] = $_POST;
            $_SESSION['form_errors'] = $errors ?? [];
        }
    }
}

function creerApprenant(array $data): bool
{
    $sql = "INSERT INTO apprenants 
            (photo, matricule, prenom, nom, telephone, referentiel, statut) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";

    $params = [
        $data['photo'],
        $data['matricule'],
        $data['prenom'],
        $data['nom'],
        $data['telephone'],
        $data['referentiel'],
        $data['statut']
    ];

    $pdo = connectDB();
    $stmt = $pdo->prepare($sql);

    // Binding des paramètres
    foreach ($params as $index => $value) {
        $paramType = is_int($value) ? PDO::PARAM_INT : (is_resource($value) ? PDO::PARAM_LOB : PDO::PARAM_STR);
        $stmt->bindValue($index + 1, $value, $paramType);
    }

    return $stmt->execute();
}

function getApprenantById($id)
{
    $sql = "SELECT a.*, 
                   r.nom as nom_referentiel,
                   p.nom as nom_promotion,
                   CASE WHEN a.photo IS NOT NULL THEN true ELSE false END AS has_photo
            FROM apprenant a
            LEFT JOIN referentiel r ON a.referentiel = r.id::text
            LEFT JOIN promotion p ON a.promotion_id = p.id
            WHERE a.id = ?";
    return executeQuery($sql, [$id]);
}

function getApprenantPhoto($id)
{
    $sql = "SELECT photo FROM apprenant WHERE id = ?";
    $result = executeQuery($sql, [$id]);
    return $result['photo'] ?? null;
}

function updateApprenantPhoto($id, $photoBinary)
{
    $sql = "UPDATE apprenant SET photo = ? WHERE id = ?";
    return executeQuery($sql, [$photoBinary, $id]);
}

function updateApprenant($id, array $data): bool
{
    $sql = "UPDATE apprenant SET 
            photo = ?,
            matricule = ?,
            prenom = ?,
            nom = ?,
            telephone = ?,
            email = ?,
            referentiel = ?,
            statut = ?
            WHERE id = ?";

    $params = [
        $data['photo'],
        $data['matricule'],
        $data['prenom'],
        $data['nom'],
        $data['telephone'],
        $data['referentiel'],
        $data['statut'],
        $id
    ];

    return executeQuery($sql, $params);
}

function changerStatutApprenant($id, $nouveauStatut): bool
{
    $sql = "UPDATE apprenant SET statut = ? WHERE id = ?";
    return executeQuery($sql, [$nouveauStatut, $id]);
}

function supprimerApprenant($id): bool
{
    $sql = "DELETE FROM apprenant WHERE id = ?";
    return executeQuery($sql, [$id]);
}

// Réutilisation de votre fonction handlePhotoUpload existante
function handlePhotoUpload()
{
    if (!isset($_FILES['photo']) || $_FILES['photo']['error'] === UPLOAD_ERR_NO_FILE) {
        return null;
    }

    if ($_FILES['photo']['error'] !== UPLOAD_ERR_OK) {
        throw new Exception("Erreur lors du téléchargement de la photo");
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
        throw new Exception("La taille de la photo ne doit pas dépasser 2MB");
    }

    return file_get_contents($_FILES['photo']['tmp_name']);
}
