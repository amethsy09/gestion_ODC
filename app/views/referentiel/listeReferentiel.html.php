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
          <a href="<?= WEBROOT ?>?controllers=referentiel&page=creer" 
             class="bg-[#e52421] text-white px-4 py-2 rounded-lg flex items-center gap-2 hover:bg-[#c11e1b] transition-all shadow-md hover:shadow-lg"
             aria-label="Créer une nouvelle promotion"
             title="Créer une nouvelle promotion">
            <i class="ri-add-line"></i> Créer un référentiel
          </a>
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
              <a href="<?= WEBROOT ?>?controllers=referentiel&page=creer"
                 class="bg-[#e52421] text-white px-6 py-2 rounded-lg hover:bg-[#c11e1b] transition inline-flex items-center gap-2">
                <i class="ri-add-line"></i> Nouvelle référentiel
              </a>
               <div class="container mx-auto p-4">
        
            </div>
          <?php else: ?>
            <?php foreach ($referentiels as $referentiel): ?>
              <div class="bg-white rounded-xl overflow-hidden shadow-md border border-gray-100 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                <div class="p-5">
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
        <dialog id="add_repository_modal" class="modal">
            <div class="modal-box w-11/12 max-w-5xl">
                <h3 class="font-bold text-lg">Ajouter un nouveau référentiel</h3>
                <p class="py-4">Tous les champs sont obligatoires</p>
                
                <form id="repository_form" class="space-y-4">
                    <!-- Nom du référentiel -->
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Nom du référentiel*</span>
                        </label>
                        <input type="text" name="name" placeholder="Entrez le nom du référentiel" 
                               class="input input-bordered w-full" required />
                        <label class="label">
                            <span class="label-text-alt">Le nom doit être unique</span>
                        </label>
                    </div>
                    
                    <!-- Photo -->
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Photo*</span>
                        </label>
                        <input type="file" name="photo" accept=".jpg,.jpeg,.png" 
                               class="file-input file-input-bordered w-full" required />
                        <label class="label">
                            <span class="label-text-alt">Formats acceptés: JPG, PNG - Taille max: 2MB</span>
                        </label>
                    </div>
                    
                    <!-- Description -->
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Description*</span>
                        </label>
                        <textarea name="description" class="textarea textarea-bordered h-24" 
                                  placeholder="Description du référentiel" required></textarea>
                    </div>
                    
                    <!-- Capacité -->
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Capacité (nombre d'étudiants)*</span>
                        </label>
                        <input type="number" name="capacity" min="1" 
                               class="input input-bordered w-full" required />
                    </div>
                    
                    <!-- Nombre de sessions -->
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Nombre de sessions de formation par an*</span>
                        </label>
                        <input type="number" name="sessions_per_year" min="1" 
                               class="input input-bordered w-full" required />
                    </div>
                    
                    <div class="modal-action">
                        <button type="button" class="btn" onclick="document.getElementById('add_repository_modal').close()">
                            Annuler
                        </button>
                        <button type="submit" class="btn btn-primary">
                            Enregistrer
                        </button>
                    </div>
                </form>
            </div>
        </dialog>
        
        <script>
            document.getElementById('repository_form').addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Vérification de la taille du fichier
                const photoInput = document.querySelector('input[name="photo"]');
                if (photoInput.files.length > 0) {
                    const file = photoInput.files[0];
                    if (file.size > 2 * 1024 * 1024) {
                        alert("La taille du fichier ne doit pas dépasser 2MB");
                        return;
                    }
                }
                alert("Référentiel créé avec succès (statut inactif)");
                document.getElementById('add_repository_modal').close();
                this.reset();
            });
        </script>
    </div>
</body>
</html>