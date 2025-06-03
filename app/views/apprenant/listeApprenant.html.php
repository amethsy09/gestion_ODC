<style>
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
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
          <div>
            <h1 class="text-2xl font-bold text-[#e52421]">Gestion des Apprenants</h1>
            <p class="text-sm text-gray-500">Administrez les apprenants de votre établissement</p>
          </div>
          <button
            onclick="openModal()"
            class="bg-[#e52421] text-white px-4 py-2 rounded-lg flex items-center gap-2 hover:bg-[#c11e1b] transition-all shadow-md hover:shadow-lg"
            aria-label="Ajouter un nouvel apprenant"
            title="Ajouter un nouvel apprenant">
            <i class="ri-add-line"></i> Ajouter un apprenant
          </button>
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
                class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#e52421] focus:border-transparent"
                onkeyup="filterApprenants()">
            </div>

            <!-- Referentiel Filter -->
            <div class="w-full md:w-48">
              <select id="referentielFilter" class="block w-full pl-3 pr-10 py-2 border border-gray-300 rounded-md leading-5 bg-white focus:outline-none focus:ring-2 focus:ring-[#e52421] focus:border-transparent">
                <option value="">Tous les référentiels</option>
                <?php foreach ($referentiels as $ref): ?>
                  <option value="<?= $ref['id'] ?>"><?= htmlspecialchars($ref['nom']) ?></option>
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

        <!-- Apprenants Grid View -->
        <div id="gridView" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
          <?php if (empty($apprenants)): ?>
            <div class="col-span-full py-12 text-center">
              <div class="mx-auto w-40 h-40 rounded-full bg-gradient-to-br from-gray-50 to-gray-100 flex items-center justify-center mb-6 shadow-inner">
                <i class="fas fa-user-graduate text-5xl text-gray-300"></i>
              </div>
              <h3 class="text-xl font-medium text-gray-700 mb-2">Aucun apprenant enregistré</h3>
              <p class="text-gray-400 mb-4">Ajoutez votre premier apprenant pour commencer</p>
              <button onclick="openModal()" class="bg-[#e52421] text-white px-6 py-2 rounded-lg hover:bg-[#c11e1b] transition inline-flex items-center gap-2">
                <i class="ri-add-line"></i> Nouvel apprenant
              </button>
            </div>
          <?php else: ?>
            <?php foreach ($apprenants as $apprenant): ?>
              <div class="bg-white rounded-xl overflow-hidden shadow-md border border-gray-100 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 flex flex-col h-full">
                <!-- Image Section -->
                <div class="relative aspect-square overflow-hidden">
                  <?php if (!empty($apprenant['photo'])):
                    // Si c'est une ressource (stream), on lit son contenu en chaîne
                    if (is_resource($apprenant['photo'])) {
                      $data = stream_get_contents($apprenant['photo']);
                    } else {
                      $data = $apprenant['photo'];
                    }

                    $finfo = finfo_open(FILEINFO_MIME_TYPE);
                    $type = finfo_buffer($finfo, $data);
                    finfo_close($finfo);
                  ?>
                    <img src="data:<?= $type ?>;base64,<?= base64_encode($data) ?>"
                      alt="<?= htmlspecialchars($apprenant['prenom'] . ' ' . $apprenant['nom']) ?>"
                      class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                  <?php else: ?>
                    <div class="w-full h-full bg-gradient-to-br from-blue-50 to-blue-100 flex items-center justify-center">
                      <div class="avatar placeholder">
                        <div class="bg-neutral-focus text-neutral-content rounded-full w-20">
                          <span class="text-xl"><?= substr($apprenant['prenom'] ?? '', 0, 1) . substr($apprenant['nom'] ?? '', 0, 1) ?></span>
                        </div>
                      </div>
                    </div>
                  <?php endif; ?>
                </div>

                <!-- Content -->
                <div class="p-5 flex-grow flex flex-col">
                  <div class="flex justify-between items-start mb-3">
                    <div class="flex-grow">
                      <h3 class="text-xl font-bold text-gray-800 mb-1">
                        <?= htmlspecialchars($apprenant['prenom'] . ' ' . $apprenant['nom']) ?>
                      </h3>
                      <p class="text-sm text-gray-500 mb-2">
                        <i class="ri-id-card-line mr-1"></i> <?= htmlspecialchars($apprenant['matricule']) ?>
                      </p>
                    </div>
                    <div class="bg-gray-100 w-10 h-10 p-2 rounded-full flex-shrink-0 flex items-center justify-center ml-3">
                      <span class="badge <?= htmlspecialchars($apprenant['statut']) ?> text-xs">
                        <?= substr($apprenant['statut'], 0, 1) ?>
                      </span>
                    </div>
                  </div>

                  <!-- Metadata -->
                  <div class="mt-auto pt-3 border-t border-gray-100">
                    <div class="flex justify-between text-sm text-gray-600 mb-2">
                      <span class="flex items-center">
                        <i class="ri-book-line mr-1"></i>
                        <?= htmlspecialchars($apprenant['nom_referentiel'] ?? 'Non défini') ?>
                      </span>
                      <span class="flex items-center">
                        <i class="ri-group-line mr-1"></i>
                        <?= htmlspecialchars($apprenant['nom_promotion'] ?? 'Non définie') ?>
                      </span>
                    </div>
                    <div class="flex justify-between text-sm">
                      <a href="tel:<?= htmlspecialchars($apprenant['telephone']) ?>" class="text-blue-600 hover:text-blue-800 flex items-center">
                        <i class="ri-phone-line mr-1"></i>
                        <?= htmlspecialchars($apprenant['telephone']) ?>
                      </a>
                      <div class="flex space-x-2">
                        <a href="?controllers=apprenant&page=detailApprenant&id=<?= $apprenant['id'] ?>" class="text-blue-600 hover:text-blue-800" title="Voir détails">
                          <i class="ri-eye-line"></i>
                        </a>
                        <a href="?controllers=apprenant&page=changerStatut&id=<?= $apprenant['id'] ?>" class="text-yellow-600 hover:text-yellow-800" title="Changer statut">
                          <i class="ri-exchange-line"></i>
                        </a>
                        <a href="?controllers=apprenant&page=supprimerApprenant&id=<?= $apprenant['id'] ?>" class="text-red-600 hover:text-red-800" title="Supprimer" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet apprenant ?')">
                          <i class="ri-delete-bin-line"></i>
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </main>
</div>

<!-- Modal pour ajouter un apprenant -->
<div id="add_apprenant_modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
  <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
    <!-- Background overlay -->
    <div class="fixed inset-0 transition-opacity" aria-hidden="true" onclick="closeModal()">
      <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
    </div>

    <!-- Modal content -->
    <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
      <form id="apprenant_form" method="POST" action="?controllers=apprenant&page=listeApprenant" enctype="multipart/form-data" class="p-6">
        <input type="hidden" name="action" value="add_apprenant">
        <div class="flex justify-between items-center mb-4">
          <h3 class="text-xl font-bold text-gray-900">Ajouter un nouvel apprenant</h3>
          <button type="button" onclick="closeModal()" class="text-gray-400 hover:text-gray-500">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>

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

        <!-- Photo section -->
        <div class="mb-6 text-center">
          <div id="photo_container" class="mx-auto w-32 h-32 rounded-full bg-gray-100 mb-4 overflow-hidden relative cursor-pointer">
            <label for="photo_upload" class="absolute inset-0 flex items-center justify-center">
              <div id="photo_preview" class="w-full h-full flex items-center justify-center">
                <i class="ri-user-line text-3xl text-gray-400"></i>
              </div>
            </label>
            <input id="photo_upload" type="file" name="photo" accept="image/*" class="hidden">
            <button id="change_photo_btn" type="button" class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-50 text-white text-xs py-1 hidden">
              <i class="ri-edit-line"></i> Changer
            </button>
          </div>
          <div id="photo_error" class="text-red-500 text-xs text-center mb-2"></div>
        </div>

        <!-- Form fields -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <!-- Matricule -->
          <div class="col-span-full">
            <label class="block text-sm font-medium text-gray-700 mb-1">Matricule*</label>
            <input type="text" name="matricule" value="<?= htmlspecialchars($_SESSION['old_input']['matricule'] ?? '') ?>"
              class="w-full px-3 py-2 border <?= !empty($_SESSION['form_errors']['matricule']) ? 'border-red-500' : 'border-gray-300' ?> rounded-md focus:outline-none focus:ring-2 focus:ring-[#e52421] focus:border-transparent">
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

          <!-- Téléphone -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Téléphone*</label>
            <input type="tel" name="telephone" value="<?= htmlspecialchars($_SESSION['old_input']['telephone'] ?? '') ?>"
              class="w-full px-3 py-2 border <?= !empty($_SESSION['form_errors']['telephone']) ? 'border-red-500' : 'border-gray-300' ?> rounded-md focus:outline-none focus:ring-2 focus:ring-[#e52421] focus:border-transparent">
            <div id="telephone_error" class="text-red-500 text-xs mt-1">
              <?= htmlspecialchars($_SESSION['form_errors']['telephone'] ?? '') ?>
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

        <!-- Buttons -->
        <div class="mt-8 flex justify-end space-x-3">
          <button type="button" onclick="closeModal()"
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
  const modal = document.getElementById('add_apprenant_modal');
  const form = document.getElementById('apprenant_form');
  const photoUpload = document.getElementById('photo_upload');
  const photoPreview = document.getElementById('photo_preview');
  const changePhotoBtn = document.getElementById('change_photo_btn');
  const photoContainer = document.getElementById('photo_container');

  // Form submission handling
  if (form) {
    form.addEventListener('submit', function(e) {
      e.preventDefault();

      if (!validateForm()) {
        return; // Ne pas soumettre si la validation échoue
      }

      // Loading indicator
      const submitBtn = document.getElementById('submitBtn');
      if (submitBtn) {
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="ri-loader-4-line animate-spin"></i> En cours...';
        submitBtn.disabled = true;
      }

      form.submit();
    });
  }

  // Fonction de validation
  function validateForm() {
    let isValid = true;

    // Réinitialiser les erreurs
    document.querySelectorAll('[id$="_error"]').forEach(el => el.textContent = '');

    // Validation du matricule
    const matricule = form.elements['matricule'].value.trim();
    if (!matricule) {
      document.getElementById('matricule_error').textContent = 'Le matricule est obligatoire';
      isValid = false;
    }

    // Validation du prénom
    const prenom = form.elements['prenom'].value.trim();
    if (!prenom) {
      document.getElementById('prenom_error').textContent = 'Le prénom est obligatoire';
      isValid = false;
    }

    // Validation du nom
    const nom = form.elements['nom'].value.trim();
    if (!nom) {
      document.getElementById('nom_error').textContent = 'Le nom est obligatoire';
      isValid = false;
    }

    // Validation du téléphone
    const telephone = form.elements['telephone'].value.trim();
    if (!telephone) {
      document.getElementById('telephone_error').textContent = 'Le téléphone est obligatoire';
      isValid = false;
    }

    // Validation du référentiel
    const referentiel = form.elements['referentiel'].value;
    if (!referentiel) {
      document.getElementById('referentiel_error').textContent = 'Le référentiel est obligatoire';
      isValid = false;
    }

    // Validation du statut
    const statut = form.elements['statut'].value;
    if (!statut) {
      document.getElementById('statut_error').textContent = 'Le statut est obligatoire';
      isValid = false;
    }

    // Validation de la photo (optionnelle selon vos besoins)
    const photo = photoUpload.files[0];
    if (photo) {
      const validTypes = ['image/jpeg', 'image/png', 'image/gif'];
      const maxSize = 2 * 1024 * 1024; // 2MB

      if (!validTypes.includes(photo.type)) {
        document.getElementById('photo_error').textContent = 'Format non supporté (JPEG, PNG ou GIF seulement)';
        isValid = false;
      }

      if (photo.size > maxSize) {
        document.getElementById('photo_error').textContent = 'La taille maximale est de 2MB';
        isValid = false;
      }
    }

    return isValid;
  }

  // Initialize buttons
  document.addEventListener('DOMContentLoaded', () => {
    const openModalBtn = document.querySelector('[aria-label="Ajouter un nouvel apprenant"]');
    if (openModalBtn) {
      openModalBtn.addEventListener('click', openModal);
    }
  });

  function openModal() {
    if (modal) {
      modal.classList.remove('hidden');
      document.body.style.overflow = 'hidden';
      resetPhotoPreview();
    }
  }

  function closeModal() {
    if (modal) {
      modal.classList.add('hidden');
      document.body.style.overflow = 'auto';
    }
  }

  // Close with ESC key
  document.addEventListener('keydown', e => {
    if (e.key === 'Escape') closeModal();
  });

  // Close when clicking on background
  if (modal) {
    modal.addEventListener('click', e => {
      if (e.target === modal) closeModal();
    });
  }

  // Photo handling
  if (photoContainer && changePhotoBtn && photoUpload) {
    // Click on photo container
    photoContainer.addEventListener('click', e => {
      if (!changePhotoBtn.contains(e.target)) {
        photoUpload.click();
      }
    });

    // "Change" button
    changePhotoBtn.addEventListener('click', e => {
      e.stopPropagation();
      photoUpload.click();
    });

    // File change
    photoUpload.addEventListener('change', e => {
      if (e.target.files && e.target.files[0]) {
        previewPhoto(e.target.files[0]);
      }
    });

    // Drag & drop
    photoContainer.addEventListener('dragover', e => {
      e.preventDefault();
      photoContainer.classList.add('border-2', 'border-[#e52421]');
    });

    photoContainer.addEventListener('dragleave', () => {
      photoContainer.classList.remove('border-2', 'border-[#e52421]');
    });

    photoContainer.addEventListener('drop', e => {
      e.preventDefault();
      photoContainer.classList.remove('border-2', 'border-[#e52421]');
      if (e.dataTransfer.files && e.dataTransfer.files[0]) {
        previewPhoto(e.dataTransfer.files[0]);
      }
    });
  }

  // Photo preview
  function previewPhoto(file) {
    if (!photoPreview) return;

    const reader = new FileReader();
    reader.onload = e => {
      photoPreview.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover" alt="Prévisualisation">`;
      if (changePhotoBtn) {
        changePhotoBtn.classList.remove('hidden');
      }
    };
    reader.readAsDataURL(file);
  }

  // Reset preview
  function resetPhotoPreview() {
    if (photoUpload && photoPreview && changePhotoBtn) {
      photoUpload.value = '';
      photoPreview.innerHTML = '<i class="ri-user-line text-3xl text-gray-400"></i>';
      changePhotoBtn.classList.add('hidden');
    }
  }

  // Search and Filter functions
  function filterApprenants() {
    const searchTerm = document.getElementById('searchInput').value.toLowerCase();
    const referentielFilter = document.getElementById('referentielFilter').value;
    const promotionFilter = document.getElementById('promotionFilter').value;
    const statusFilter = document.getElementById('statusFilter').value;
    const errorMessage = document.getElementById('searchErrorMessage');
    let visibleCount = 0;
    
    document.querySelectorAll('#gridView > div').forEach(card => {
      const name = card.querySelector('h3').textContent.toLowerCase();
      const matricule = card.querySelector('p').textContent.toLowerCase();
      const referentiel = card.querySelector('span:first-of-type').textContent;
      const promotion = card.querySelector('span:nth-of-type(2)').textContent;
      const status = card.querySelector('.badge').textContent.trim().toLowerCase();

      let matchesSearch = name.includes(searchTerm) || matricule.includes(searchTerm);
      let matchesReferentiel = !referentielFilter || referentiel.includes(document.querySelector(`#referentielFilter option[value="${referentielFilter}"]`).textContent);
      let matchesPromotion = !promotionFilter || promotion.includes(document.querySelector(`#promotionFilter option[value="${promotionFilter}"]`).textContent);
      let matchesStatus = !statusFilter || status.includes(statusFilter.toLowerCase());

      if (matchesSearch && matchesReferentiel && matchesPromotion && matchesStatus) {
        card.style.display = 'flex';
        visibleCount++;
      } else {
        card.style.display = 'none';
      }
    });
    
    // Afficher ou masquer le message d'erreur
    if (visibleCount === 0 && (searchTerm.length > 0 || referentielFilter || promotionFilter || statusFilter)) {
      errorMessage.classList.remove('hidden');
    } else {
      errorMessage.classList.add('hidden');
    }
  }

  // Initialize filters
  document.getElementById('referentielFilter').addEventListener('change', filterApprenants);
  document.getElementById('promotionFilter').addEventListener('change', filterApprenants);
  document.getElementById('statusFilter').addEventListener('change', filterApprenants);

  window.openModal = openModal;
  window.closeModal = closeModal;
</script>

<?php
// Nettoyer les sessions après affichage
unset($_SESSION['form_errors']);
unset($_SESSION['old_input']);
?>