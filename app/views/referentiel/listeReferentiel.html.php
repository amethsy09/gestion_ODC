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
            <h1 class="text-2xl font-bold text-[#e52421]">Gestion des Promotions</h1>
            <p class="text-sm text-gray-500">Administrez les promotions de votre établissement</p>
          </div>
          <button
            onclick="openModal()"
            class="bg-[#e52421] text-white px-4 py-2 rounded-lg flex items-center gap-2 hover:bg-[#c11e1b] transition-all shadow-md hover:shadow-lg"
            aria-label="Créer un nouveau référentiel"
            title="Créer un nouveau référentiel">
            <i class="ri-add-line"></i> Créer un référentiel
          </button>
        </div>

        <!-- Promotions Grid View -->
        <div id="gridView" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
          <?php if (empty($referentiels)): ?>
            <div class="col-span-full py-12 text-center">
              <div class="mx-auto w-40 h-40 rounded-full bg-gradient-to-br from-gray-50 to-gray-100 flex items-center justify-center mb-6 shadow-inner">
                <i class="fas fa-chalkboard-teacher text-5xl text-gray-300"></i>
              </div>
              <h3 class="text-xl font-medium text-gray-700 mb-2">Aucun référentiel disponible</h3>
              <p class="text-gray-400 mb-4">Créez votre premier référentiel pour commencer</p>
              <button
                onclick="openModal()"
                class="bg-[#e52421] text-white px-6 py-2 rounded-lg hover:bg-[#c11e1b] transition inline-flex items-center gap-2">
                <i class="ri-add-line"></i> Nouveau référentiel
              </button>
            </div>
          <?php else: ?>
            <?php foreach ($referentiels as $referentiel): ?>
              <div class="bg-white rounded-xl overflow-hidden shadow-md border border-gray-100 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                <div class="p-5">
                  <?php if (!empty($referentiel['photo'])): ?>
                    <div class="mb-4">
                      <img
                        src="data:image/jpeg;base64,<?= base64_encode($referentiel['photo']) ?>"
                        alt="Image du référentiel"
                        class="w-full h-40 object-cover rounded-lg">
                    </div>
                  <?php endif; ?>
                  <!-- Référentiel Header -->
                  <div class="flex justify-between items-start mb-4">
                    <div>
                      <h3 class="text-xl font-bold text-gray-800 mb-1">
                        <?= htmlspecialchars($referentiel["nom"] ?? 'Non défini') ?>
                      </h3>
                      <div class="flex items-center text-sm text-gray-500 mb-1">
                        <span><?= htmlspecialchars($referentiel["description"] ?? 'Non défini') ?></span>
                      </div>
                    </div>
                    <div class="bg-gray-100 w-12 h-12 p-2 rounded-full flex items-center justify-center">
                      <i class="ri-book-line text-2xl text-[#e52421]"></i>
                    </div>
                  </div>
                  <!-- Référentiel Description -->
                  <p class="text-gray-600 mb-4">
                    <?= htmlspecialchars($referentiel["capacite"] ?? 'Non défini') ?> places disponibles
                  </p>
                </div>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </main>
</div>

<!-- Modal -->
<!-- Modal de création -->
<div id="add_repository_modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
  <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
    <!-- Background overlay -->
    <div class="fixed inset-0 transition-opacity" aria-hidden="true" onclick="closeModal()">
      <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
    </div>

    <!-- Modal content -->
    <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full">
      <form id="repository_form" method="POST" action="?controllers=referentiel&page=creer" class="p-6">
        <div class="flex justify-between items-center mb-4">
          <h3 class="text-xl font-bold text-gray-900">Créer un nouveau référentiel</h3>
          <button type="button" onclick="closeModal()" class="text-gray-400 hover:text-gray-500">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>

        <!-- Section photo -->

        <div class="mb-6 text-center">
          <div id="photo_container" class="mx-auto w-32 h-32 rounded-full bg-gray-100 mb-4 overflow-hidden relative cursor-pointer">
            <label for="photo_upload" class="absolute inset-0 flex items-center justify-center">
              <div id="photo_preview" class="w-full h-full flex items-center justify-center">
                <i class="ri-camera-line text-3xl text-gray-400"></i>
              </div>
            </label>
            <input id="photo_upload" type="file" name="photo" accept="image/*" class="hidden">
            <button id="change_photo_btn" type="button" class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-50 text-white text-xs py-1 hidden">
              <i class="ri-edit-line"></i> Changer
            </button>
          </div>
        </div>
        <!-- Champs du formulaire -->
        <div class="space-y-4">
          <!-- Nom -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Nom*</label>
            <input type="text" name="nom"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#e52421] focus:border-transparent">
          </div>

          <!-- Description -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
            <textarea name="description" rows="3"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#e52421] focus:border-transparent"></textarea>
          </div>

          <!-- Capacité -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Capacité*</label>
            <input type="number" name="capacite" min="1" value="30"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#e52421] focus:border-transparent">
          </div>

          <!-- Nombre de sessions -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Nombre de sessions*</label>
            <input type="number" name="sessions_per_year" min="1" value="1"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#e52421] focus:border-transparent">
          </div>
        </div>

        <!-- Boutons -->
        <div class="mt-8 flex justify-end space-x-3">
          <button type="button" onclick="closeModal()"
            class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#e52421]">
            Annuler
          </button>
          <button type="submit"
            class="px-4 py-2 bg-[#e52421] text-white rounded-md hover:bg-[#c11e1b] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#e52421]">
            Créer
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
<script>
  // Gestion du modal
  function openModal() {
    document.getElementById('add_repository_modal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
    resetFileInput(); // Réinitialiser l'input file à l'ouverture
  }

  function closeModal() {
    document.getElementById('add_repository_modal').classList.add('hidden');
    document.body.style.overflow = 'auto';
  }

  // Fermeture avec la touche ESC
  document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeModal();
  });

  // Références aux éléments DOM
  const photoUpload = document.getElementById('photo_upload');
  const photoPreview = document.getElementById('photo_preview');
  const changePhotoBtn = document.getElementById('change_photo_btn');
  const photoContainer = document.getElementById('photo_container');
  const form = document.getElementById('repository_form');

  // Gestion de l'upload de photo
  photoContainer.addEventListener('click', function(e) {
    // Ne pas déclencher si on clique sur le bouton "changer"
    if (!changePhotoBtn.contains(e.target)) {
      photoUpload.click();
    }
  });

  // Bouton "Changer"
  changePhotoBtn.addEventListener('click', function(e) {
    e.stopPropagation(); // Empêcher le déclenchement du clic sur le container
    photoUpload.click();
  });

  // Lorsqu'un fichier est sélectionné
  photoUpload.addEventListener('change', function(e) {
    handleFileUpload(e.target.files[0]);
  });

  // Gestion du drag and drop (optionnel)
  photoContainer.addEventListener('dragover', function(e) {
    e.preventDefault();
    this.classList.add('border-2', 'border-[#e52421]');
  });

  photoContainer.addEventListener('dragleave', function() {
    this.classList.remove('border-2', 'border-[#e52421]');
  });

  photoContainer.addEventListener('drop', function(e) {
    e.preventDefault();
    this.classList.remove('border-2', 'border-[#e52421]');
    if (e.dataTransfer.files.length) {
      handleFileUpload(e.dataTransfer.files[0]);
    }
  });

  // Fonction pour gérer l'upload de fichier
  function handleFileUpload(file) {
    if (!file) return;

    // Validation du fichier
    if (!file.type.match('image.*')) {
      alert('Veuillez sélectionner une image valide (JPG, PNG)');
      return;
    }

    if (file.size > 2 * 1024 * 1024) {
      alert('La taille de la photo ne doit pas dépasser 2MB');
      return;
    }

    // Prévisualisation
    const reader = new FileReader();
    reader.onload = function(e) {
      photoPreview.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover" alt="Prévisualisation">`;
      changePhotoBtn.classList.remove('hidden');
    };
    reader.readAsDataURL(file);
  }

  // Réinitialiser l'input file
  function resetFileInput() {
    photoUpload.value = '';
    photoPreview.innerHTML = '<i class="ri-camera-line text-3xl text-gray-400"></i>';
    changePhotoBtn.classList.add('hidden');
  }

  // Soumission du formulaire
  form.addEventListener('submit', function(e) {
    e.preventDefault();

    // Validation supplémentaire si nécessaire
    if (!form.nom.value || !form.capacite.value || !form.sessions_per_year.value) {
      alert('Veuillez remplir tous les champs obligatoires');
      return;
    }

    const formData = new FormData(form);

    // Envoi AJAX
    fetch(form.action, {
        method: 'POST',
        body: formData
      })
      .then(response => {
        if (!response.ok) throw new Error('Erreur réseau');
        return response.json();
      })
      .then(data => {
        if (data.success) {
          alert('Référentiel créé avec succès !');
          closeModal();
          window.location.reload();
        } else {
          throw new Error(data.message || 'Erreur lors de la création');
        }
      })
      .catch(error => {
        console.error('Erreur:', error);
        alert(`Erreur: ${error.message}`);
      });
  });

  // Fermeture en cliquant à l'extérieur
  document.querySelector('.fixed.inset-0').addEventListener('click', function(e) {
    if (e.target === this) {
      closeModal();
    }
  });
</script>