<div class="flex h-screen bg-gray-50">
  <main class="flex-1 overflow-hidden">
    <div class="p-6 overflow-y-auto h-[calc(100vh-80px)]">
      <div class="p-6 bg-white rounded-xl shadow-sm">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
          <div>
            <h1 class="text-2xl font-bold text-[#e52421]">Détails de la promotion</h1>
            <p class="text-sm text-gray-500">Informations complètes sur la promotion</p>
          </div>
          <div class="flex gap-2">
            <a href="<?= WEBROOT ?>?controllers=promotion&page=editer&id=<?= $promotion['id'] ?>"
              class="bg-[#2e5b97] text-white px-4 py-2 rounded-lg flex items-center gap-2 hover:bg-[#234a7a] transition-all">
              <i class="ri-pencil-line"></i> Modifier
            </a>
            <a href="<?= WEBROOT ?>?controllers=promotion&page=listePromotion"
              class="border border-gray-300 text-gray-700 px-4 py-2 rounded-lg flex items-center gap-2 hover:bg-gray-50 transition-all">
              <i class="ri-arrow-left-line"></i> Retour
            </a>
          </div>
        </div>

        <!-- Promotion Details -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          <!-- Informations de base -->
          <div class="col-span-1">
            <div class="bg-gray-50 p-4 rounded-lg">
              <h2 class="text-lg font-semibold text-gray-800 mb-4">Informations générales</h2>
              <div class="space-y-4">
                <div>
                  <p class="text-sm text-gray-500">Nom</p>
                  <p class="font-medium"><?= htmlspecialchars($promotion['nom']) ?></p>
                </div>
                <div>
                  <p class="text-sm text-gray-500">Statut</p>
                  <span class="px-2 py-1 text-xs font-semibold rounded-full <?= $promotion['statut'] === 'Active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
                    <?= htmlspecialchars($promotion['statut']) ?>
                  </span>
                </div>
                <div>
                  <p class="text-sm text-gray-500">Période</p>
                  <p class="font-medium"><?= htmlspecialchars($promotion['annee_debut']) ?> - <?= htmlspecialchars($promotion['annee_fin']) ?></p>
                </div>
                <div>
                  <p class="text-sm text-gray-500">Référentiel</p>
                  <p class="font-medium"><?= htmlspecialchars($promotion['referentiel_nom'] ?? 'Non défini') ?></p>
                </div>
              </div>
            </div>
          </div>

          <!-- Statistiques -->
          <div class="col-span-1">
            <div class="bg-gray-50 p-4 rounded-lg">
              <h2 class="text-lg font-semibold text-gray-800 mb-4">Statistiques</h2>
              <div class="space-y-4">
                <div>
                  <p class="text-sm text-gray-500">Nombre d'apprenants</p>
                  <p class="font-medium"><?= htmlspecialchars($promotion['nombre_apprenants'] ?? 0) ?></p>
                </div>
                <div>
                  <p class="text-sm text-gray-500">Taux de réussite</p>
                  <div class="w-full bg-gray-200 rounded-full h-2 mt-1">
                    <div class="bg-[#e52421] h-2 rounded-full" style="width: 75%"></div>
                  </div>
                  <p class="text-sm text-right text-gray-500 mt-1">75%</p>
                </div>
                <div>
                  <p class="text-sm text-gray-500">Date de création</p>
                  <p class="font-medium"><?= date('d/m/Y', strtotime($promotion['created_at'] ?? 'now')) ?></p>
                </div>
              </div>
            </div>
          </div>

          <!-- Actions rapides -->
          <div class="col-span-1">
            <div class="bg-gray-50 p-4 rounded-lg">
              <h2 class="text-lg font-semibold text-gray-800 mb-4">Actions</h2>
              <div class="space-y-3">
                <a href="#"
                  class="block p-3 bg-white rounded-lg border border-gray-200 hover:border-[#e52421] transition flex items-center gap-3">
                  <div class="bg-[#e52421]/10 p-2 rounded-lg">
                    <i class="ri-user-add-line text-[#e52421]"></i>
                  </div>
                  <span>Ajouter des apprenants</span>
                </a>
                <a href="#"
                  class="block p-3 bg-white rounded-lg border border-gray-200 hover:border-[#e52421] transition flex items-center gap-3">
                  <div class="bg-[#e52421]/10 p-2 rounded-lg">
                    <i class="ri-calendar-todo-line text-[#e52421]"></i>
                  </div>
                  <span>Planifier des évaluations</span>
                </a>
                <a href="#"
                  class="block p-3 bg-white rounded-lg border border-gray-200 hover:border-[#e52421] transition flex items-center gap-3">
                  <div class="bg-[#e52421]/10 p-2 rounded-lg">
                    <i class="ri-file-chart-line text-[#e52421]"></i>
                  </div>
                  <span>Générer un rapport</span>
                </a>
              </div>
            </div>
          </div>
        </div>

        <!-- Apprenants Section -->
        <div class="mt-8">
          <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold text-gray-800">Liste des apprenants</h2>
            <a href="#"
              class="text-sm text-[#e52421] hover:text-[#c11e1b] flex items-center gap-1 hover:underline">
              <i class="ri-user-add-line"></i> Ajouter des apprenants
            </a>
          </div>
          
          <div class="bg-white rounded-xl shadow overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-50">
                <tr>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom complet</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Téléphone</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                <tr>
                  <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                    Aucun apprenant trouvé pour cette promotion
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </main>
</div>