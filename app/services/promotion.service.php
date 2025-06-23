<?php
require_once "../app/models/promotion.model.php";

function showPromotionList() {
    // Récupérer les paramètres de filtre
    $search = $_GET['search'] ?? '';
    $status = $_GET['status'] ?? 'all';
$viewType = $_GET['viewType'] ?? 'grid';
    // Récupérer les promotions avec filtres
    $promotions = findAllPromotion($search, $status);
    
    // Récupérer les stats globales (non filtrées)
    $allPromotions = findAllPromotion('', 'all');
    
    // Calculer les statistiques de manière sécurisée
    $stats = [
        'total_promotion' => count($allPromotions),
        'total_promotionActive' => array_reduce($allPromotions, function($carry, $item) {
            return $carry + (($item['statut'] ?? '') === 'Actif' ? 1 : 0);
        }, 0),
        'total_apprenant' => array_sum(array_column($allPromotions, 'nombre_apprenants')) ?: 0,
        'total_referentiel' => count(array_unique(array_column($allPromotions, 'referentiel'))) ?: 0
    ];
    
    RenderView("promotion/listePromotion.html.php", [
        'promotions' => $promotions,
        'stats' => $stats,
        'search' => $search,
        'status' => $status,
        'viewType' => $viewType
    ]);
}

function showCreatePromotionForm() {
    $referentiels = getReferentiels();
    RenderView("promotion/creerPromotion.html.php", [
        'referentiels' => $referentiels
    ]);
}

function handleCreatePromotion() {
    if (isPost()) {
        // Initialisation des données
        $data = [
            'nom' => trim($_POST['nom'] ?? ''),
            'annee_debut' => intval($_POST['annee_debut'] ?? 0),
            'annee_fin' => intval($_POST['annee_fin'] ?? 0),
            'statut' => 'Inactif', // Statut inactif par défaut comme demandé
            'referentiels' => $_POST['referentiels'] ?? []
        ];

        // Validation des données
        $errors = [];

        // 1. Validation du nom (obligatoire et unique)
        if (empty($data['nom'])) {
            $errors['nom'] = 'Le nom de la promotion est obligatoire';
        } elseif (promotionExists($data['nom'])) {
            $errors['nom'] = 'Ce nom de promotion existe déjà';
        }

        // 2. Validation des années (obligatoires et cohérentes)
        if ($data['annee_debut'] < 2000 || $data['annee_debut'] > 2099) {
            $errors['annee_debut'] = 'L\'année de début doit être entre 2000 et 2099';
        }
        
        if ($data['annee_fin'] < 2000 || $data['annee_fin'] > 2099) {
            $errors['annee_fin'] = 'L\'année de fin doit être entre 2000 et 2099';
        }
        
        if ($data['annee_debut'] > $data['annee_fin']) {
            $errors['annee_fin'] = 'L\'année de fin doit être supérieure à l\'année de début';
        }

        // 3. Validation des référentiels (au moins un sélectionné)
        if (empty($data['referentiels'])) {
            $errors['referentiels'] = 'Vous devez sélectionner au moins un référentiel';
        } else {
            // Vérification que les référentiels existent bien en base
            $data['referentiels'] = array_map('intval', $data['referentiels']);
            $existingRefs = getExistingReferentiels($data['referentiels']);
            if (count($existingRefs) !== count($data['referentiels'])) {
                $errors['referentiels'] = 'Un ou plusieurs référentiels sélectionnés sont invalides';
            }
        }

        // 4. Validation du fichier photo
        $photo = $_FILES['photo'] ?? null;
        $photoPath = null;
        
        if ($photo && $photo['error'] === UPLOAD_ERR_OK) {
            // Vérification du type de fichier
            $allowedTypes = ['image/jpeg' => 'jpg', 'image/png' => 'png'];
            $fileInfo = new finfo(FILEINFO_MIME_TYPE);
            $mime = $fileInfo->file($photo['tmp_name']);
            
            if (!array_key_exists($mime, $allowedTypes)) {
                $errors['photo'] = 'Le format de l\'image doit être JPG ou PNG';
            }
            
            // Vérification de la taille (max 2MB)
            if ($photo['size'] > 2 * 1024 * 1024) {
                $errors['photo'] = 'La taille de l\'image ne doit pas dépasser 2MB';
            }
            
            // Si tout est OK, préparer l'upload
            if (!isset($errors['photo'])) {
                $extension = $allowedTypes[$mime];
                $photoName = uniqid('promo_', true) . '.' . $extension;
                $uploadDir = 'uploads/promotions/';
                
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }
                
                $photoPath = $uploadDir . $photoName;
                if (!move_uploaded_file($photo['tmp_name'], $photoPath)) {
                    $errors['photo'] = 'Erreur lors de l\'enregistrement de l\'image';
                }
            }
        } else {
            $errors['photo'] = 'Une image est obligatoire';
        }

        // Si pas d'erreurs, création de la promotion
        if (empty($errors)) {
            // Ajout du chemin de la photo aux données
            $data['photo'] = $photoPath;
            
            // Création de la promotion et association des référentiels
            if (createPromotionWithReferentiels($data)) {
                $_SESSION['flash_message'] = [
                    'type' => 'success',
                    'message' => 'Promotion créée avec succès!'
                ];
                header("Location: " . WEBROOT . "?controllers=promotion&page=listePromotion");
                exit();
            } else {
                // En cas d'échec de la création, supprimer l'image uploadée
                if ($photoPath && file_exists($photoPath)) {
                    unlink($photoPath);
                }
                
                $errors['general'] = 'Erreur lors de la création de la promotion';
            }
        }

        // Si erreurs, réafficher le formulaire avec les erreurs
        $_SESSION['flash_message'] = [
            'type' => 'danger',
            'message' => 'Veuillez corriger les erreurs dans le formulaire'
        ];
        
        RenderView("promotion/creerPromotion.html.php", [
            'referentiels' => getReferentiels(),
            'data' => $data,
            'errors' => $errors
        ]);
    } else {
        showCreatePromotionForm();
    }
}

function showEditPromotionForm($id) {
    $promotion = findPromotionById($id);
    $referentiels = getReferentiels();
    
    if (!$promotion) {
        $_SESSION['flash_message'] = [
            'type' => 'danger',
            'message' => 'Promotion non trouvée'
        ];
        header("Location: " . WEBROOT . "?controllers=promotion&page=listePromotion");
        exit();
    }
    
    RenderView("promotion/editerPromotion.html.php", [
        'promotion' => $promotion,
        'referentiels' => $referentiels
    ]);
}

function handleUpdatePromotion($id) {
    if (isPost()) {
        $data = [
            'nom' => $_POST['nom'], 
            'photo' => $_FILES['photo'] ?? null,
            'annee_debut' => $_POST['annee_debut'],
            'annee_fin' => $_POST['annee_fin'],
            'referentiel_id' => $_POST['referentiel_id'],
            'statut' => $_POST['statut'] ?? 'Actif'
        ];
        
        if (updatePromotion($id, $data)) {
            $_SESSION['flash_message'] = [
                'type' => 'success',
                'message' => 'Promotion mise à jour avec succès!'
            ];
            header("Location: " . WEBROOT . "?controllers=promotion&page=listePromotion");
            exit();
        } else {
            $_SESSION['flash_message'] = [
                'type' => 'danger',
                'message' => 'Erreur lors de la mise à jour de la promotion'
            ];
            showEditPromotionForm($id);
        }
    } else {
        showEditPromotionForm($id);
    }
}

function handleDeletePromotion($id) {
    if (deletePromotion($id)) {
        $_SESSION['flash_message'] = [
            'type' => 'success',
            'message' => 'Promotion supprimée avec succès!'
        ];
    } else {
        $_SESSION['flash_message'] = [
            'type' => 'danger',
            'message' => 'Erreur lors de la suppression de la promotion'
        ];
    }
    
    header("Location: " . WEBROOT . "?controllers=promotion&page=listePromotion");
    exit();
}

function showPromotionDetails($id) {
    $promotion = findPromotionById($id);
    
    if (!$promotion) {
        $_SESSION['flash_message'] = [
            'type' => 'danger',
            'message' => 'Promotion non trouvée'
        ];
        header("Location: " . WEBROOT . "?controllers=promotion&page=listePromotion");
        exit();
    }
    
    RenderView("promotion/voirPromotion.html.php", [
        'promotion' => $promotion
    ]);
}

function createPromotionWithReferentiels(array $data): bool {
    try {
        // 1. Insertion de la promotion avec récupération de l'ID via RETURNING
        $sqlPromotion = "
            INSERT INTO promotion (nom, annee_debut, annee_fin, photo, statut) 
            VALUES (?, ?, ?, ?, ?)
            RETURNING id
        ";

        $paramsPromotion = [
            $data['nom'],
            $data['annee_debut'],
            $data['annee_fin'],
            $data['photo'],
            $data['statut']
        ];

        // Exécution de la requête d'insertion et récupération de l'ID
        $result = executeQuery($sqlPromotion, $paramsPromotion);
        $promotionId = $result['id'] ?? null;

        if (!$promotionId) {
            throw new Exception("Impossible de récupérer l'ID de la nouvelle promotion");
        }

        // 2. Insertion des associations promotion-référentiels
        if (!empty($data['referentiels'])) {
            $sqlRef = "
                INSERT INTO promotion_referentiel (promotion_id, referentiel_id) 
                VALUES (?, ?)
            ";

            foreach ($data['referentiels'] as $referentielId) {
                $success = executeQuery($sqlRef, [$promotionId, $referentielId]);
                if (!$success) {
                    throw new Exception("Erreur lors de l'association des référentiels");
                }
            }
        }

        return true;

    } catch (Exception $e) {
        error_log("Erreur dans createPromotionWithReferentiels: " . $e->getMessage());

        // En cas d'échec, suppression de la promotion créée pour cohérence
        if (isset($promotionId)) {
            executeQuery("DELETE FROM promotion WHERE id = ?", [$promotionId]);
        }

        return false;
    }
}