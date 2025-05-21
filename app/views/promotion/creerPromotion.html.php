<div class="flex h-screen bg-gray-100">
  <main class="flex-1 overflow-hidden">
    <div class="p-6 overflow-y-auto h-[calc(100vh-80px)]">
      <div class="p-8 bg-white rounded-2xl shadow-md border border-gray-200">
        
        <!-- Header -->
        <div class="mb-8 space-y-1">
          <h1 class="text-3xl font-semibold text-[#e52421]">Créer une nouvelle promotion</h1>
          <p class="text-sm text-gray-500">Remplissez le formulaire pour créer une nouvelle promotion</p>
        </div>

        <!-- Flash Message -->
        <?php if (isset($_SESSION['flash_message'])): ?>
          <div class="mb-6 p-4 rounded-lg font-medium text-sm 
            <?= $_SESSION['flash_message']['type'] === 'success' 
              ? 'bg-green-100 text-green-800' 
              : 'bg-red-100 text-red-800' ?>">
            <?= $_SESSION['flash_message']['message'] ?>
          </div>
          <?php unset($_SESSION['flash_message']); ?>
        <?php endif; ?>

        <!-- Form -->
        <form action="<?= WEBROOT ?>?controllers=promotion&page=creer&action=submit" method="POST" enctype="multipart/form-data" class="space-y-8">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <!-- Nom -->
            <div>
              <label for="nom" class="label font-medium text-sm mb-1">Nom de la promotion *</label>
              <input type="text" id="nom" name="nom"
                class="input input-bordered w-full <?= isset($errors['nom']) ? 'border-red-500' : '' ?>"
                value="<?= htmlspecialchars($data['nom'] ?? '') ?>"
                placeholder="Entrez un nom unique pour la promotion">
              <?php if (isset($errors['nom'])): ?>
                <p class="text-red-500 text-sm mt-1"><?= $errors['nom'] ?></p>
              <?php else: ?>
                <p class="text-gray-400 text-xs mt-1">Le nom doit être unique</p>
              <?php endif; ?>
            </div>

            <!-- Photo -->
            <div>
              <label for="photo" class="label font-medium text-sm mb-1">Photo (JPG/PNG, max 2MB) *</label>
              <input type="file" id="photo" name="photo" accept="image/jpeg, image/png"
                class="file-input file-input-bordered w-full <?= isset($errors['photo']) ? 'border-red-500' : '' ?>">
              <?php if (isset($errors['photo'])): ?>
                <p class="text-red-500 text-sm mt-1"><?= $errors['photo'] ?></p>
              <?php else: ?>
                <p class="text-gray-400 text-xs mt-1">Formats acceptés: JPG, PNG. Taille max: 2MB</p>
              <?php endif; ?>
            </div>

            <!-- Référentiels -->
            <div class="md:col-span-2">
              <label for="referentiel_search" class="label font-medium text-sm mb-1">Rechercher et sélectionner des référentiels *</label>
              <input type="text" id="referentiel_search"
                class="input input-bordered w-full <?= isset($errors['referentiels']) ? 'border-red-500' : '' ?>"
                placeholder="Rechercher un référentiel...">

              <div class="mt-2 border border-gray-200 rounded-lg max-h-48 overflow-y-auto divide-y divide-gray-100 bg-gray-50">
                <?php foreach ($referentiels as $referentiel): ?>
                  <div class="flex items-center px-3 py-2 hover:bg-white transition">
                    <input type="checkbox" id="ref_<?= $referentiel['id'] ?>" name="referentiels[]" value="<?= htmlspecialchars($referentiel['id']) ?>"
                      class="checkbox checkbox-sm text-[#e52421]" 
                      <?= (isset($data['referentiels']) && in_array($referentiel['id'], $data['referentiels'])) ? 'checked' : '' ?>>
                    <label for="ref_<?= $referentiel['id'] ?>" class="ml-2 text-sm"><?= htmlspecialchars($referentiel['nom']) ?></label>
                  </div>
                <?php endforeach; ?>
              </div>
              <?php if (isset($errors['referentiels'])): ?>
                <p class="text-red-500 text-sm mt-1"><?= $errors['referentiels'] ?></p>
              <?php else: ?>
                <p class="text-gray-400 text-xs mt-1">Sélectionnez un ou plusieurs référentiels</p>
              <?php endif; ?>
            </div>

            <!-- Année de début -->
            <div>
              <label for="annee_debut" class="label font-medium text-sm mb-1">Année de début *</label>
              <input type="number" id="annee_debut" name="annee_debut" min="2000" max="2099"
                class="input input-bordered w-full <?= isset($errors['annee_debut']) ? 'border-red-500' : '' ?>"
                value="<?= htmlspecialchars($data['annee_debut'] ?? '') ?>" placeholder="2023">
              <?php if (isset($errors['annee_debut'])): ?>
                <p class="text-red-500 text-sm mt-1"><?= $errors['annee_debut'] ?></p>
              <?php endif; ?>
            </div>

            <!-- Année de fin -->
            <div>
              <label for="annee_fin" class="label font-medium text-sm mb-1">Année de fin *</label>
              <input type="number" id="annee_fin" name="annee_fin" min="2000" max="2099"
                class="input input-bordered w-full <?= isset($errors['annee_fin']) ? 'border-red-500' : '' ?>"
                value="<?= htmlspecialchars($data['annee_fin'] ?? '') ?>" placeholder="2025">
              <?php if (isset($errors['annee_fin'])): ?>
                <p class="text-red-500 text-sm mt-1"><?= $errors['annee_fin'] ?></p>
              <?php endif; ?>
            </div>
          </div>

          <!-- Statut -->
          <input type="hidden" name="statut" value="Inactive">

          <!-- Boutons -->
          <div class="flex justify-end gap-4 pt-6 border-t border-gray-200">
            <a href="<?= WEBROOT ?>?controllers=promotion&page=listePromotion"
              class="btn btn-outline btn-sm">Annuler</a>
            <button type="submit" class="btn bg-[#e52421] hover:bg-[#c11e1b] text-white btn-sm">
              <i class="ri-save-line mr-1"></i> Enregistrer
            </button>
          </div>
        </form>
      </div>
    </div>
  </main>
</div>

<!-- Script pour la recherche de référentiels -->
<script>
document.getElementById('referentiel_search').addEventListener('input', function(e) {
  const searchTerm = e.target.value.toLowerCase();
  const checkboxes = document.querySelectorAll('input[name="referentiels[]"]');

  checkboxes.forEach(checkbox => {
    const label = checkbox.nextElementSibling;
    const item = checkbox.closest('div');
    const text = label.textContent.toLowerCase();

    item.style.display = text.includes(searchTerm) ? 'flex' : 'none';
  });
});
</script>
