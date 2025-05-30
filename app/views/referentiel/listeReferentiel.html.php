
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
            <h1 class="text-2xl font-bold text-[#e52421]">Gestion des referentiel</h1>
            <p class="text-sm text-gray-500">Administrez les referentiels de votre établissement</p>
          </div>
          <button
            onclick="openModal()"
            class="bg-[#e52421] text-white px-4 py-2 rounded-lg flex items-center gap-2 hover:bg-[#c11e1b] transition-all shadow-md hover:shadow-lg"
            aria-label="Créer un nouveau référentiel"
            title="Créer un nouveau référentiel">
            <i class="ri-add-line"></i> Créer un référentiel
          </button>
        </div>

        <!-- Referentiels Grid View -->
        <div id="gridView" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
          <?php if (empty($referentiels)): ?>
            <div class="col-span-full py-12 text-center">
              <div class="mx-auto w-40 h-40 rounded-full bg-gradient-to-br from-gray-50 to-gray-100 flex items-center justify-center mb-6 shadow-inner">
                <i class="fas fa-chalkboard-teacher text-5xl text-gray-300"></i>
              </div>
              <h3 class="text-xl font-medium text-gray-700 mb-2">Aucun référentiel disponible</h3>
              <p class="text-gray-400 mb-4">Créez votre premier référentiel pour commencer</p>
              <button onclick="openModal()" class="bg-[#e52421] text-white px-6 py-2 rounded-lg hover:bg-[#c11e1b] transition inline-flex items-center gap-2">
                <i class="ri-add-line"></i> Nouveau référentiel
              </button>
            </div>
          <?php else: ?>
            <?php foreach ($referentiels as $referentiel): ?>
              <div class="bg-white rounded-xl overflow-hidden shadow-md border border-gray-100 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 flex flex-col h-full">
                <!-- Image Section -->
                <div class="relative aspect-[4/3] overflow-hidden">
                  <?php if (!empty($referentiel['photo'])): 

                                        // Si c'est une ressource (stream), on lit son contenu en chaîne
                                        if (is_resource($referentiel['photo'])) {
                                            $data = stream_get_contents($referentiel['photo']);
                                        } else {
                                            $data = $referentiel['photo'];
                                        }

                                        $finfo = finfo_open(FILEINFO_MIME_TYPE);
                                        $type = finfo_buffer($finfo, $data);
                                        finfo_close($finfo);
                                    ?>
                                          <img src="data:<?= $type ?>;base64,<?= base64_encode($data) ?>" 
                                              alt="<?= htmlspecialchars($referentiel['nom']) ?>" 
                                              class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                                      <?php else: ?>
                                          <div class="w-full h-full bg-gradient-to-br from-red-50 to-red-100 flex items-center justify-center">
                                              <i class="ri-team-line text-3xl text-red-200"></i>
                                          </div>
                                      <?php endif; ?>
                </div>

                <!-- Content -->
                <div class="p-5 flex-grow flex flex-col">
                  <div class="flex justify-between items-start mb-3">
                    <div class="flex-grow">
                      <h3 class="text-xl font-bold text-gray-800 mb-1 truncate">
                        <?= htmlspecialchars($referentiel["nom"] ?? 'Non défini') ?>
                      </h3>
                      <?php if (!empty($referentiel["description"])): ?>
                        <p class="text-sm text-gray-500 line-clamp-2 mb-2">
                          <?= htmlspecialchars($referentiel["description"]) ?>
                        </p>
                      <?php endif; ?>
                    </div>
                    <div class="bg-gray-100 w-10 h-10 p-2 rounded-full flex-shrink-0 flex items-center justify-center ml-3">
                      <i class="ri-book-line text-xl text-[#e52421]"></i>
                    </div>
                  </div>

                  <!-- Metadata -->
                  <div class="mt-auto pt-3 border-t border-gray-100">
                    <div class="flex justify-between text-sm text-gray-600">
                      <span class="flex items-center">
                        <i class="ri-time-line mr-1"></i>
                        <?= htmlspecialchars($referentiel["duree_mois"] ?? '0') ?> mois
                      </span>
                      <span class="flex items-center">
                        <i class="ri-user-line mr-1"></i>
                        <?= htmlspecialchars($referentiel["capacite"] ?? '0') ?> places
                      </span>
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

<!-- Modal -->
<div id="add_repository_modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
  <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
    <!-- Background overlay -->
    <div class="fixed inset-0 transition-opacity" aria-hidden="true" onclick="closeModal()">
      <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
    </div>

    <!-- Modal content -->
    <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full">
      <form id="repository_form" method="POST" action="?controllers=referentiel&page=listeReferentiel" enctype="multipart/form-data" class="p-6">
      <input type="hidden" name="action" value="add_referentiel">
        <div class="flex justify-between items-center mb-4">
          <h3 class="text-xl font-bold text-gray-900">Créer un nouveau référentiel</h3>
          <button type="button" onclick="closeModal()" class="text-gray-400 hover:text-gray-500">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>

        <!-- Photo section -->
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
        <!-- Form fields -->
        <div class="space-y-4">
          <!-- Name -->
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
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Durée (mois)*</label>
            <input type="number" name="duree_mois" min="1" value="12"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#e52421] focus:border-transparent">
          </div>
          <!-- Capacity -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Capacité*</label>
            <input type="number" name="capacite" min="1" value="30"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#e52421] focus:border-transparent">
          </div>

          <!-- Sessions number -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Nombre de sessions*</label>
            <input type="number" name="sessions_per_year" min="1" value="1"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#e52421] focus:border-transparent">
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
            Créer
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
<script>
  // Global variables
  const modal = document.getElementById('add_repository_modal');
  const form = document.getElementById('repository_form');
  const photoUpload = document.getElementById('photo_upload');
  const photoPreview = document.getElementById('photo_preview');
  const changePhotoBtn = document.getElementById('change_photo_btn');
  const photoContainer = document.getElementById('photo_container');

  // Form submission handling
  if (form) {
    form.addEventListener('submit', function(e) {
      e.preventDefault();
      
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

  // Initialize buttons
  document.addEventListener('DOMContentLoaded', () => {
    const openModalBtn = document.querySelector('[aria-label="Créer un nouveau référentiel"]');
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
      photoPreview.innerHTML = '<i class="ri-camera-line text-3xl text-gray-400"></i>';
      changePhotoBtn.classList.add('hidden');
    }
  }

  window.openModal = openModal;
  window.closeModal = closeModal;
</script>