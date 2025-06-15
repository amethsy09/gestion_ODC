<style>
  /* Style pour la modale */
  .modal {
    transition: opacity 0.25s ease;
  }
  
  .modal-overlay {
    background-color: rgba(0, 0, 0, 0.5);
    transition: opacity 0.25s ease;
  }
  
  .modal-content {
    transition: all 0.3s ease-out;
    transform: translateY(20px);
    opacity: 0;
  }
  
  .modal.modal-active .modal-content {
    transform: translateY(0);
    opacity: 1;
  }
  
  /* Style pour la prévisualisation de la photo */
  #photo_container {
    transition: all 0.3s ease;
    border: 2px dashed transparent;
  }

  #photo_container:hover {
    background-color: #f3f4f6;
    border-color: #e5e7eb;
  }

  #photo_container.dragover {
    border-color: #e52421 !important;
    background-color: #fce8e8;
  }

  #change_photo_btn {
    transition: opacity 0.2s ease;
  }

  #change_photo_btn:hover {
    opacity: 0.9;
  }

  #photo_preview img {
    transition: transform 0.3s ease;
  }

  #photo_preview:hover img {
    transform: scale(1.05);
  }
</style>

<div class="flex h-screen bg-gray-50">
  <main class="flex-1 overflow-hidden">
    <div class="p-6 overflow-y-auto h-[calc(100vh-80px)]">
      <div class="p-6 bg-white rounded-xl shadow-sm">
        <!-- Header Section -->
       <!-- Header Section -->
<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
  <div>
    <h1 class="text-2xl font-bold text-[#e52421]">Gestion des Apprenants</h1>
    <p class="text-sm text-gray-500">Administrez les apprenants de votre établissement</p>
  </div>
  <div class="flex flex-col md:flex-row gap-2">
    <div class="dropdown dropdown-end">
      <button class="bg-[#e52421] text-white px-4 py-2 rounded-lg flex items-center gap-2 hover:bg-[#c11e1b] transition-all shadow-md hover:shadow-lg">
        <i class="ri-download-line"></i> Télécharger la liste
      </button>
      <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52 mt-1">
        <li>
          <a href="#" onclick="exportToPDF()">
            <i class="ri-file-pdf-line text-red-500"></i> Télécharger en PDF
          </a>
        </li>
        <li>
          <a href="#" onclick="exportToExcel()">
            <i class="ri-file-excel-line text-green-500"></i> Télécharger en Excel
          </a>
        </li>
      </ul>
    </div>
    <button
      id="openAddModalBtn"
      class="bg-[#e52421] text-white px-4 py-2 rounded-lg flex items-center gap-2 hover:bg-[#c11e1b] transition-all shadow-md hover:shadow-lg"
      aria-label="Ajouter un nouvel apprenant"
      title="Ajouter un nouvel apprenant">
      <i class="ri-add-line"></i> Ajouter un apprenant
    </button>
  </div>
</div>

        <!-- Search and Filters Section -->
        <div class="mb-6">
          <div class="flex flex-col md:flex-row gap-4">
            <!-- Search Input -->
            <div class="relative flex-grow">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="ri-search-line text-gray-400"></i>
              </div>
              <input
                type="text"
                id="searchInput"
                placeholder="Rechercher un apprenant..."
                class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#e52421] focus:border-transparent">
            </div>

            <!-- Referentiel Filter -->
            <div class="w-full md:w-48">
              <select id="referentielFilter" class="block w-full pl-3 pr-10 py-2 border border-gray-300 rounded-md leading-5 bg-white focus:outline-none focus:ring-2 focus:ring-[#e52421] focus:border-transparent">
                <option value="">Tous les référentiels</option>
                <?php foreach ($referentiels as $ref): ?>
                  <option value="<?= $ref['id'] ?>"><?= htmlspecialchars($ref['referentiel']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>

            <!-- Promotion Filter -->
            <div class="w-full md:w-48">
              <select id="promotionFilter" class="block w-full pl-3 pr-10 py-2 border border-gray-300 rounded-md leading-5 bg-white focus:outline-none focus:ring-2 focus:ring-[#e52421] focus:border-transparent">
                <option value="">Toutes les promotions</option>
                <?php foreach ($promotions as $promo): ?>
                  <option value="<?= $promo['id'] ?>"><?= htmlspecialchars($promo['nom']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>

            <!-- Status Filter -->
            <div class="w-full md:w-48">
              <select id="statusFilter" class="block w-full pl-3 pr-10 py-2 border border-gray-300 rounded-md leading-5 bg-white focus:outline-none focus:ring-2 focus:ring-[#e52421] focus:border-transparent">
                <option value="">Tous les statuts</option>
                <?php foreach ($statuts as $statut): ?>
                  <option value="<?= htmlspecialchars($statut) ?>"><?= htmlspecialchars($statut) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div id="searchErrorMessage" class="hidden mt-4 p-4 bg-red-50 border-l-4 border-red-500 text-red-700">
            <p>Aucun apprenant trouvé pour votre recherche.</p>
          </div>
        </div>

        <!-- Tableau des apprenants -->
        <div class="overflow-x-auto bg-white rounded-lg shadow">
          <?php if (empty($apprenants)): ?>
            <div class="p-12 text-center">
              <div class="mx-auto w-40 h-40 rounded-full bg-gradient-to-br from-gray-50 to-gray-100 flex items-center justify-center mb-6 shadow-inner">
                <i class="fas fa-user-graduate text-5xl text-gray-300"></i>
              </div>
              <p class="text-gray-400 mb-4">Ajoutez votre premier apprenant pour commencer</p>
              <button id="openAddModalBtn2" class="bg-[#e52421] text-white px-6 py-2 rounded-lg hover:bg-[#c11e1b] transition inline-flex items-center gap-2">
                <i class="ri-add-line"></i> Nouvel apprenant
              </button>
            </div>
          <?php else: ?>
            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-50">
                <tr>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Photo
                  </th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Matricule
                  </th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Nom & Prénom
                  </th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Téléphone
                  </th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Référentiel
                  </th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Promotion
                  </th>
                  <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Statut
                  </th>
                  <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Actions
                  </th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                <?php foreach ($apprenants as $apprenant): ?>
                  <tr class="hover:bg-gray-50" 
                      data-referentiel="<?= htmlspecialchars($apprenant['referentiel_id'] ?? '') ?>"
                      data-promotion="<?= htmlspecialchars($apprenant['promotion_id'] ?? '') ?>"
                      data-status="<?= htmlspecialchars(strtolower($apprenant['statut'] ?? '')) ?>">
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="flex-shrink-0 h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center overflow-hidden">
                        <?php if (!empty($apprenant['photo'])): ?>
                          <img src="data:image/jpeg;base64,<?= base64_encode($apprenant['photo']) ?>" 
                               alt="Photo de <?= htmlspecialchars($apprenant['prenom'] . ' ' . $apprenant['nom']) ?>"
                               class="h-10 w-10 object-cover">
                        <?php else: ?>
                          <span class="text-blue-600 font-medium">
                            <?= strtoupper(substr($apprenant['prenom'] ?? '', 0, 1) . substr($apprenant['nom'] ?? '', 0, 1)) ?>
                          </span>
                        <?php endif; ?>
                      </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                      <?= htmlspecialchars($apprenant['matricule']) ?>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="flex items-center">
                        <div class="ml-4">
                          <div class="text-sm font-medium text-gray-900">
                            <?= htmlspecialchars($apprenant['prenom'] . ' ' . $apprenant['nom']) ?>
                          </div>
                          <div class="text-sm text-gray-500">
                            <?= htmlspecialchars($apprenant['email']) ?>
                          </div>
                        </div>
                      </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                      <a href="tel:<?= htmlspecialchars($apprenant['telephone']) ?>" class="text-blue-600 hover:text-blue-800">
                        <?= htmlspecialchars($apprenant['telephone']) ?>
                      </a>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                      <?= htmlspecialchars($apprenant['nom_referentiel'] ?? 'Non défini') ?>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                      <?= htmlspecialchars($apprenant['nom_promotion'] ?? 'Non définie') ?>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <?php if (!empty($apprenant['statut'])): ?>
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                          <?= $apprenant['statut'] === 'actif' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
                          <?= ucfirst($apprenant['statut']) ?>
                        </span>
                      <?php endif; ?>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                      <div class="dropdown dropdown-end">
                        <div tabindex="0" role="button" class="btn btn-ghost btn-sm">
                          <i class="ri-more-2-fill text-lg"></i>
                        </div>
                        <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52">
                          <li>
                            <a href="?controllers=apprenant&page=voirdetail&id=<?= $apprenant['id'] ?>" class="flex items-center">
                              <i class="ri-eye-line mr-2"></i>
                              <span>Voir les détails</span>
                            </a>
                          </li>
                          <li>
                            <a href="?controllers=apprenant&page=changerStatut&id=<?= $apprenant['id'] ?>" class="flex items-center">
                              <i class="ri-exchange-line mr-2"></i>
                              <span>Changer le statut</span>
                            </a>
                          </li>
                          <li>
                            <a href="?controllers=apprenant&page=supprimerApprenant&id=<?= $apprenant['id'] ?>" 
                               class="flex items-center text-error"
                               onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet apprenant ?')">
                              <i class="ri-delete-bin-line mr-2"></i>
                              <span>Supprimer</span>
                            </a>
                          </li>
                        </ul>
                      </div>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </main>
</div>

<!-- Modal pour ajouter un apprenant -->
<div id="add_apprenant_modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
  <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
    <!-- Background overlay -->
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
    
    <!-- This element is to trick the browser into centering the modal contents. -->
    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

    <!-- Modal content -->
    <div class="relative inline-block w-full max-w-2xl px-4 pt-5 pb-4 overflow-hidden text-left align-bottom bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle sm:p-6">
      <button type="button" class="absolute top-4 right-4 text-gray-400 hover:text-gray-500" onclick="closeApprenantModal()">
        <span class="sr-only">Fermer</span>
        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
      </button>
      <form id="apprenant_form" class="space-y-6" method="POST" action="?action=add_apprenant" enctype="multipart/form-data">
        <input type="hidden" name="action" value="add_apprenant">
        
        <?php if (!empty($_SESSION['form_errors'])): ?>
          <div class="mb-4 p-4 bg-red-50 border-l-4 border-red-500">
            <div class="flex">
              <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                </svg>
              </div>
              <div class="ml-3">
                <p class="text-sm text-red-700">
                  <?= htmlspecialchars($_SESSION['flash']['message'] ?? '') ?>
                </p>
              </div>
            </div>
          </div>
        <?php endif; ?>

        <!-- Photo de profil -->
        <div class="mb-6 text-center">
          <div id="photo_container" class="mx-auto w-32 h-32 rounded-full bg-gray-100 mb-4 overflow-hidden relative cursor-pointer">
            <label for="photo_upload" class="absolute inset-0 flex items-center justify-center">
              <div id="photo_preview" class="w-full h-full flex items-center justify-center">
                <i class="ri-user-line text-4xl text-gray-400"></i>
              </div>
            </label>
            <input id="photo_upload" type="file" name="photo" accept="image/*" class="hidden">
            <button id="change_photo_btn" type="button" class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-50 text-white text-xs py-1 hidden">
              <i class="ri-edit-line"></i> Changer
            </button>
          </div>
          <div id="photo_error" class="text-red-500 text-xs text-center mb-2"></div>
        </div>

        <!-- Informations personnelles -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
          <!-- Matricule -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Matricule*</label>
            <input type="text" name="matricule" value="<?= htmlspecialchars($_SESSION['old_input']['matricule'] ?? '') ?>"
              class="w-full px-3 py-2 border <?= !empty($_SESSION['form_errors']['matricule']) ? 'border-red-500' : 'border-gray-300' ?> rounded-md focus:outline-none focus:ring-2 focus:ring-[#e52421] focus:border-transparent"
              placeholder="Ex: AP2023001">
            <div id="matricule_error" class="text-red-500 text-xs mt-1">
              <?= htmlspecialchars($_SESSION['form_errors']['matricule'] ?? '') ?>
            </div>
          </div>

          <!-- Prénom -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Prénom*</label>
            <input type="text" name="prenom" value="<?= htmlspecialchars($_SESSION['old_input']['prenom'] ?? '') ?>"
              class="w-full px-3 py-2 border <?= !empty($_SESSION['form_errors']['prenom']) ? 'border-red-500' : 'border-gray-300' ?> rounded-md focus:outline-none focus:ring-2 focus:ring-[#e52421] focus:border-transparent">
            <div id="prenom_error" class="text-red-500 text-xs mt-1">
              <?= htmlspecialchars($_SESSION['form_errors']['prenom'] ?? '') ?>
            </div>
          </div>

          <!-- Nom -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Nom*</label>
            <input type="text" name="nom" value="<?= htmlspecialchars($_SESSION['old_input']['nom'] ?? '') ?>"
              class="w-full px-3 py-2 border <?= !empty($_SESSION['form_errors']['nom']) ? 'border-red-500' : 'border-gray-300' ?> rounded-md focus:outline-none focus:ring-2 focus:ring-[#e52421] focus:border-transparent">
            <div id="nom_error" class="text-red-500 text-xs mt-1">
              <?= htmlspecialchars($_SESSION['form_errors']['nom'] ?? '') ?>
            </div>
          </div>

          <!-- Date de naissance -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Date de naissance*</label>
            <input type="date" name="date_naissance" value="<?= htmlspecialchars($_SESSION['old_input']['date_naissance'] ?? '') ?>"
              class="w-full px-3 py-2 border <?= !empty($_SESSION['form_errors']['date_naissance']) ? 'border-red-500' : 'border-gray-300' ?> rounded-md focus:outline-none focus:ring-2 focus:ring-[#e52421] focus:border-transparent">
            <div id="date_naissance_error" class="text-red-500 text-xs mt-1">
              <?= htmlspecialchars($_SESSION['form_errors']['date_naissance'] ?? '') ?>
            </div>
          </div>

          <!-- Lieu de naissance -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Lieu de naissance*</label>
            <input type="text" name="lieu_naissance" value="<?= htmlspecialchars($_SESSION['old_input']['lieu_naissance'] ?? '') ?>"
              class="w-full px-3 py-2 border <?= !empty($_SESSION['form_errors']['lieu_naissance']) ? 'border-red-500' : 'border-gray-300' ?> rounded-md focus:outline-none focus:ring-2 focus:ring-[#e52421] focus:border-transparent">
            <div id="lieu_naissance_error" class="text-red-500 text-xs mt-1">
              <?= htmlspecialchars($_SESSION['form_errors']['lieu_naissance'] ?? '') ?>
            </div>
          </div>

          <!-- Adresse -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Adresse*</label>
            <input type="text" name="adresse" value="<?= htmlspecialchars($_SESSION['old_input']['adresse'] ?? '') ?>"
              class="w-full px-3 py-2 border <?= !empty($_SESSION['form_errors']['adresse']) ? 'border-red-500' : 'border-gray-300' ?> rounded-md focus:outline-none focus:ring-2 focus:ring-[#e52421] focus:border-transparent">
            <div id="adresse_error" class="text-red-500 text-xs mt-1">
              <?= htmlspecialchars($_SESSION['form_errors']['adresse'] ?? '') ?>
            </div>
          </div>

          <!-- Téléphone -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Téléphone*</label>
            <input type="tel" name="telephone" value="<?= htmlspecialchars($_SESSION['old_input']['telephone'] ?? '') ?>"
              class="w-full px-3 py-2 border <?= !empty($_SESSION['form_errors']['telephone']) ? 'border-red-500' : 'border-gray-300' ?> rounded-md focus:outline-none focus:ring-2 focus:ring-[#e52421] focus:border-transparent">
            <div id="telephone_error" class="text-red-500 text-xs mt-1">
              <?= htmlspecialchars($_SESSION['form_errors']['telephone'] ?? '') ?>
            </div>
          </div>

          <!-- Email -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Email*</label>
            <input type="email" name="email" value="<?= htmlspecialchars($_SESSION['old_input']['email'] ?? '') ?>"
              class="w-full px-3 py-2 border <?= !empty($_SESSION['form_errors']['email']) ? 'border-red-500' : 'border-gray-300' ?> rounded-md focus:outline-none focus:ring-2 focus:ring-[#e52421] focus:border-transparent">
            <div id="email_error" class="text-red-500 text-xs mt-1">
              <?= htmlspecialchars($_SESSION['form_errors']['email'] ?? '') ?>
            </div>
          </div>

          <!-- Référentiel -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Référentiel*</label>
            <select name="referentiel" class="w-full px-3 py-2 border <?= !empty($_SESSION['form_errors']['referentiel']) ? 'border-red-500' : 'border-gray-300' ?> rounded-md focus:outline-none focus:ring-2 focus:ring-[#e52421] focus:border-transparent">
              <option value="">Sélectionnez un référentiel</option>
              <?php foreach ($referentiels as $ref): ?>
                <option value="<?= $ref['id'] ?? $ref['referentiel'] ?>" <?= ($_SESSION['old_input']['referentiel'] ?? '') == ($ref['id'] ?? $ref['referentiel']) ? 'selected' : '' ?>>
                  <?= htmlspecialchars($ref['referentiel']) ?>
                </option>
              <?php endforeach; ?>
            </select>
            <div id="referentiel_error" class="text-red-500 text-xs mt-1">
              <?= htmlspecialchars($_SESSION['form_errors']['referentiel'] ?? '') ?>
            </div>
          </div>

          <!-- Promotion -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Promotion*</label>
            <select name="promotion_id" class="w-full px-3 py-2 border <?= !empty($_SESSION['form_errors']['promotion_id']) ? 'border-red-500' : 'border-gray-300' ?> rounded-md focus:outline-none focus:ring-2 focus:ring-[#e52421] focus:border-transparent">
              <option value="">Sélectionnez une promotion</option>
              <?php foreach ($promotions as $promo): ?>
                <option value="<?= $promo['id'] ?>" <?= ($_SESSION['old_input']['promotion_id'] ?? '') == $promo['id'] ? 'selected' : '' ?>>
                  <?= htmlspecialchars($promo['nom']) ?>
                </option>
              <?php endforeach; ?>
            </select>
            <div id="promotion_id_error" class="text-red-500 text-xs mt-1">
              <?= htmlspecialchars($_SESSION['form_errors']['promotion_id'] ?? '') ?>
            </div>
          </div>

          <!-- Statut -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Statut*</label>
            <select name="statut" class="w-full px-3 py-2 border <?= !empty($_SESSION['form_errors']['statut']) ? 'border-red-500' : 'border-gray-300' ?> rounded-md focus:outline-none focus:ring-2 focus:ring-[#e52421] focus:border-transparent">
              <option value="">Sélectionnez un statut</option>
              <?php foreach ($statuts as $statut): ?>
                <option value="<?= htmlspecialchars($statut) ?>" <?= ($_SESSION['old_input']['statut'] ?? '') == $statut ? 'selected' : '' ?>>
                  <?= htmlspecialchars($statut) ?>
                </option>
              <?php endforeach; ?>
            </select>
            <div id="statut_error" class="text-red-500 text-xs mt-1">
              <?= htmlspecialchars($_SESSION['form_errors']['statut'] ?? '') ?>
            </div>
          </div>
        </div>

        <!-- Informations du tuteur -->
        <div class="mb-6">
          <h4 class="text-lg font-semibold mb-3">Informations du tuteur</h4>
          
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Nom complet du tuteur -->
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Nom complet*</label>
              <input type="text" name="tuteur_nom" value="<?= htmlspecialchars($_SESSION['old_input']['tuteur_nom'] ?? '') ?>"
                class="w-full px-3 py-2 border <?= !empty($_SESSION['form_errors']['tuteur_nom']) ? 'border-red-500' : 'border-gray-300' ?> rounded-md focus:outline-none focus:ring-2 focus:ring-[#e52421] focus:border-transparent">
              <div id="tuteur_nom_error" class="text-red-500 text-xs mt-1">
                <?= htmlspecialchars($_SESSION['form_errors']['tuteur_nom'] ?? '') ?>
              </div>
            </div>

            <!-- Lien de parenté -->
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Lien de parenté*</label>
              <input type="text" name="tuteur_parente" value="<?= htmlspecialchars($_SESSION['old_input']['tuteur_parente'] ?? '') ?>"
                class="w-full px-3 py-2 border <?= !empty($_SESSION['form_errors']['tuteur_parente']) ? 'border-red-500' : 'border-gray-300' ?> rounded-md focus:outline-none focus:ring-2 focus:ring-[#e52421] focus:border-transparent">
              <div id="tuteur_parente_error" class="text-red-500 text-xs mt-1">
                <?= htmlspecialchars($_SESSION['form_errors']['tuteur_parente'] ?? '') ?>
              </div>
            </div>

            <!-- Téléphone du tuteur -->
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Téléphone*</label>
              <input type="tel" name="tuteur_telephone" value="<?= htmlspecialchars($_SESSION['old_input']['tuteur_telephone'] ?? '') ?>"
                class="w-full px-3 py-2 border <?= !empty($_SESSION['form_errors']['tuteur_telephone']) ? 'border-red-500' : 'border-gray-300' ?> rounded-md focus:outline-none focus:ring-2 focus:ring-[#e52421] focus:border-transparent">
              <div id="tuteur_telephone_error" class="text-red-500 text-xs mt-1">
                <?= htmlspecialchars($_SESSION['form_errors']['tuteur_telephone'] ?? '') ?>
              </div>
            </div>

            <!-- Email du tuteur -->
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
              <input type="email" name="tuteur_email" value="<?= htmlspecialchars($_SESSION['old_input']['tuteur_email'] ?? '') ?>"
                class="w-full px-3 py-2 border <?= !empty($_SESSION['form_errors']['tuteur_email']) ? 'border-red-500' : 'border-gray-300' ?> rounded-md focus:outline-none focus:ring-2 focus:ring-[#e52421] focus:border-transparent">
              <div id="tuteur_email_error" class="text-red-500 text-xs mt-1">
                <?= htmlspecialchars($_SESSION['form_errors']['tuteur_email'] ?? '') ?>
              </div>
            </div>
          </div>
        </div>

        <!-- Documents -->
        <div class="mb-6">
          <label class="block text-sm font-medium text-gray-700 mb-2">Pièces jointes</label>
          <div class="border-2 border-dashed border-gray-300 rounded-md p-4 text-center">
            <input type="file" name="documents[]" multiple class="hidden" id="document_upload">
            <label for="document_upload" class="cursor-pointer">
              <i class="ri-upload-line text-2xl text-gray-400 mb-2"></i>
              <p class="text-sm text-gray-600">Glissez-déposez des fichiers ou cliquez pour télécharger</p>
              <p class="text-xs text-gray-500 mt-1">Formats acceptés: PDF, JPG, PNG (max. 5Mo)</p>
            </label>
          </div>
          <div id="documents_preview" class="mt-2 space-y-2"></div>
        </div>

        <!-- Buttons -->
        <div class="mt-8 flex justify-end space-x-3">
          <button type="button" onclick="closeApprenantModal()"
            class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#e52421]">
            Annuler
          </button>
          <button type="submit" id="submitBtn"
            class="px-4 py-2 bg-[#e52421] text-white rounded-md hover:bg-[#c11e1b] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#e52421]">
            Enregistrer
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  // Global variables
  const apprenantModal = document.getElementById('add_apprenant_modal');
  const apprenantForm = document.getElementById('apprenant_form');
  const photoUpload = document.getElementById('photo_upload');
  const photoPreview = document.getElementById('photo_preview');
  const changePhotoBtn = document.getElementById('change_photo_btn');
  const photoContainer = document.getElementById('photo_container');

  // Initialize when DOM is loaded
  document.addEventListener('DOMContentLoaded', () => {
    // Initialize modal buttons
    const openModalBtns = document.querySelectorAll('[id^="openAddModalBtn"]');
    openModalBtns.forEach(btn => {
      btn.addEventListener('click', openApprenantModal);
    });

    // Initialize photo upload
    if (photoContainer && changePhotoBtn && photoUpload) {
      photoContainer.addEventListener('click', e => {
        if (!changePhotoBtn.contains(e.target)) {
          photoUpload.click();
        }
      });

      changePhotoBtn.addEventListener('click', e => {
        e.stopPropagation();
        photoUpload.click();
      });

      photoUpload.addEventListener('change', e => {
        if (e.target.files && e.target.files[0]) {
          previewPhoto(e.target.files[0]);
        }
      });

      // Drag and drop for photo
      photoContainer.addEventListener('dragover', e => {
        e.preventDefault();
        photoContainer.classList.add('dragover');
      });

      photoContainer.addEventListener('dragleave', () => {
        photoContainer.classList.remove('dragover');
      });

      photoContainer.addEventListener('drop', e => {
        e.preventDefault();
        photoContainer.classList.remove('dragover');
        if (e.dataTransfer.files && e.dataTransfer.files[0]) {
          previewPhoto(e.dataTransfer.files[0]);
        }
      });
    }

    // Initialize form submission
    if (apprenantForm) {
      apprenantForm.addEventListener('submit', function(e) {
        e.preventDefault();

        if (!validateApprenantForm()) {
          return false;
        }

        // Show loading state
        const submitBtn = document.getElementById('submitBtn');
        if (submitBtn) {
          submitBtn.innerHTML = '<i class="ri-loader-4-line animate-spin"></i> En cours...';
          submitBtn.disabled = true;
        }

        // Submit form
        this.submit();
      });
    }

    // Initialize filters
    initApprenantFilters();
  });

  // Modal functions
  function openApprenantModal() {
    if (apprenantModal) {
      apprenantModal.classList.remove('hidden');
      document.body.style.overflow = 'hidden';
      resetPhotoPreview();
    }
  }

  function closeApprenantModal() {
    if (apprenantModal) {
      apprenantModal.classList.add('hidden');
      document.body.style.overflow = '';
      resetForm();
    }
  }
  function resetForm() {
    if (apprenantForm) {
      apprenantForm.reset();
      resetPhotoPreview();
      document.getElementById('photo_error').textContent = '';
      document.getElementById('documents_preview').innerHTML = '';
      document.querySelectorAll('.text-red-500').forEach(el => el.textContent = '');
    }
  }
  function resetPhotoPreview() {
    if (photoPreview) {
      photoPreview.innerHTML = '<i class="ri-user-line text-4xl text-gray-400"></i>';
      changePhotoBtn.classList.add('hidden');
      photoContainer.classList.remove('dragover');
    }
  }
  function previewPhoto(file) {
    if (file && file.type.startsWith('image/')) {
      const reader = new FileReader();
      reader.onload = function(e) {
        photoPreview.innerHTML = `<img src="${e.target.result}" alt="Photo de l'apprenant" class="h-10 w-10 object-cover">`;
        changePhotoBtn.classList.remove('hidden');
      };
      reader.readAsDataURL(file);
    } else {
      document.getElementById('photo_error').textContent = 'Veuillez sélectionner une image valide.';
      resetPhotoPreview();
    }
  }
  function validateApprenantForm() {
    let isValid = true;
    const requiredFields = [
      'matricule', 'prenom', 'nom', 'date_naissance', 'lieu_naissance',
      'adresse', 'telephone', 'email', 'referentiel', 'promotion_id', 'statut',
      'tuteur_nom', 'tuteur_parente', 'tuteur_telephone'
    ];

    requiredFields.forEach(field => {
      const input = apprenantForm[field];
      const errorDiv = document.getElementById(`${field}_error`);
      if (input && input.value.trim() === '') {
        errorDiv.textContent = `Le champ ${input.previousElementSibling.textContent} est requis.`;
        isValid = false;
      } else {
        errorDiv.textContent = '';
      }
    });

    return isValid;
  }
  function initApprenantFilters() {
    const searchInput = document.getElementById('searchInput');
    const referentielFilter = document.getElementById('referentielFilter');
    const promotionFilter = document.getElementById('promotionFilter');
    const statusFilter = document.getElementById('statusFilter');
    const searchErrorMessage = document.getElementById('searchErrorMessage');

    if (searchInput && referentielFilter && promotionFilter && statusFilter) {
      searchInput.addEventListener('input', filterApprenants);
      referentielFilter.addEventListener('change', filterApprenants);
      promotionFilter.addEventListener('change', filterApprenants);
      statusFilter.addEventListener('change', filterApprenants);
    }

    function filterApprenants() {
      const searchTerm = searchInput.value.toLowerCase();
      const referentielValue = referentielFilter.value;
      const promotionValue = promotionFilter.value;
      const statusValue = statusFilter.value;

      let found = false;
      const rows = document.querySelectorAll('tbody tr');
      rows.forEach(row => {
        const matricule = row.cells[1].textContent.toLowerCase();
        const nomPrenom = row.cells[2].textContent.toLowerCase();
        const referentielId = row.dataset.referentiel || '';
        const promotionId = row.dataset.promotion || '';
        const status = row.dataset.status || '';

        if ((matricule.includes(searchTerm) || nomPrenom.includes(searchTerm)) &&
            (referentielValue === '' || referentielId === referentielValue) &&
            (promotionValue === '' || promotionId === promotionValue) &&
            (statusValue === '' || status.toLowerCase() === statusValue.toLowerCase())) {
          row.style.display = '';
          found = true;
        } else {
          row.style.display = 'none';
        }
      });

      searchErrorMessage.classList.toggle('hidden', found);
    }
  }
</script>