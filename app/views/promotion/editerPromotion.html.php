<div class="flex h-screen bg-gray-50">
  <main class="flex-1 overflow-hidden">
    <div class="p-6 overflow-y-auto h-[calc(100vh-80px)]">
      <div class="p-6 bg-white rounded-xl shadow-md">
        <!-- Header Section -->
        <div class="mb-6">
          <h1 class="text-2xl font-bold text-[#e52421] mb-1">Modifier une promotion</h1>
          <p class="text-sm text-gray-500">Modifiez les informations de la promotion.</p>
        </div>

        <!-- Flash message -->
        <?php if (isset($_SESSION['flash_message'])): ?>
          <div class="mb-4 p-4 rounded-lg <?= $_SESSION['flash_message']['type'] === 'success' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
            <?= $_SESSION['flash_message']['message'] ?>
          </div>
          <?php unset($_SESSION['flash_message']); ?>
        <?php endif; ?>

        <!-- Formulaire de modification -->
        <form action="<?= WEBROOT ?>?controllerss=promotion&page=editer&action=submit&id=<?= $promotion['id'] ?>" method="POST" class="space-y-6">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Nom -->
            <div>
              <label for="nom" class="block text-sm font-medium text-gray-700 mb-1">Nom de la promotion *</label>
              <input type="text" id="nom" name="nom" value="<?= htmlspecialchars($promotion['nom']) ?>" required
                class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#e52421] focus:border-transparent">
            </div>

            <!-- Référentiel -->
            <div>
              <label for="referentiel_id" class="block text-sm font-medium text-gray-700 mb-1">Référentiel *</label>
              <select id="referentiel_id" name="referentiel_id" required
                class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#e52421] focus:border-transparent">
                <option value="">Sélectionnez un référentiel</option>
                <?php foreach ($referentiels as $referentiel): ?>
                  <option value="<?= htmlspecialchars($referentiel['id']) ?>" <?= $referentiel['id'] == $promotion['referentiel_id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($referentiel['nom']) ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <!-- Année de début -->
            <div>
              <label for="annee_debut" class="block text-sm font-medium text-gray-700 mb-1">Année de début *</label>
              <input type="number" id="annee_debut" name="annee_debut" value="<?= htmlspecialchars($promotion['annee_debut']) ?>" min="2000" max="2099" required
                class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#e52421] focus:border-transparent">
            </div>

            <!-- Année de fin -->
            <div>
              <label for="annee_fin" class="block text-sm font-medium text-gray-700 mb-1">Année de fin *</label>
              <input type="number" id="annee_fin" name="annee_fin" value="<?= htmlspecialchars($promotion['annee_fin']) ?>" min="2000" max="2099" required
                class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#e52421] focus:border-transparent">
            </div>

            <!-- Statut -->
            <div class="md:col-span-2">
              <label class="block text-sm font-medium text-gray-700 mb-1">Statut *</label>
              <div class="flex items-center gap-6">
                <label class="inline-flex items-center">
                  <input type="radio" name="statut" value="Active" <?= $promotion['statut'] === 'Active' ? 'checked' : '' ?>
                    class="text-[#e52421] focus:ring-[#e52421]">
                  <span class="ml-2 text-sm text-gray-700">Actif</span>
                </label>
                <label class="inline-flex items-center">
                  <input type="radio" name="statut" value="Inactive" <?= $promotion['statut'] === 'Inactive' ? 'checked' : '' ?>
                    class="text-[#e52421] focus:ring-[#e52421]">
                  <span class="ml-2 text-sm text-gray-700">Inactif</span>
                </label>
              </div>
            </div>
          </div>

          <!-- Boutons -->
          <div class="flex justify-end gap-4 pt-6 border-t border-gray-200">
            <a href="<?= WEBROOT ?>?controllers=promotion&page=listePromotion"
              class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
              Annuler
            </a>
            <button type="submit"
              class="px-6 py-2 bg-[#e52421] text-white rounded-lg hover:bg-[#c11e1b] transition flex items-center">
              <i class="ri-save-line mr-2"></i> Enregistrer
            </button>
          </div>
        </form>
      </div>
    </div>
  </main>
</div>
