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
          <a href="<?=WEBROOT?>?controllers=promotion&page=creer" 
             class="bg-[#e52421] text-white px-4 py-2 rounded-lg flex items-center gap-2 hover:bg-[#c11e1b] transition-all shadow-md hover:shadow-lg"
             aria-label="Créer une nouvelle promotion"
             title="Créer une nouvelle promotion">
            <i class="ri-add-line"></i> Créer une promotion
          </a>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
          <div class="bg-gradient-to-r from-[#e52421] to-[#c11e1b] text-white p-4 rounded-xl shadow-md relative">
            <p class="text-3xl font-bold mb-1">
              <?= isset($stats["total_apprenant"]) ? htmlspecialchars($stats["total_apprenant"]) : 0 ?>
            </p>
            <p class="text-sm opacity-90">Apprenants</p>
            <i class="ri-user-3-line absolute bottom-4 right-4 text-xl opacity-20"></i>
          </div>
          <div class="bg-gradient-to-r from-[#f36f21] to-[#da641e] text-white p-4 rounded-xl shadow-md relative">
            <p class="text-3xl font-bold mb-1">
              <?= isset($stats["total_referentiel"]) ? htmlspecialchars($stats["total_referentiel"]) : 0 ?>
            </p>
            <p class="text-sm opacity-90">Référentiels</p>
            <i class="ri-book-2-line absolute bottom-4 right-4 text-xl opacity-20"></i>
          </div>
          <div class="bg-gradient-to-r from-[#2e5b97] to-[#234a7a] text-white p-4 rounded-xl shadow-md relative">
            <p class="text-3xl font-bold mb-1">
              <?= isset($stats["total_promotionActive"]) ? htmlspecialchars($stats["total_promotionActive"]) : 0 ?>
            </p>
            <p class="text-sm opacity-90">Promotions actives</p>
            <i class="ri-calendar-event-line absolute bottom-4 right-4 text-xl opacity-20"></i>
          </div>
          <div class="bg-gradient-to-r from-[#3a3a3a] to-[#2d2d2d] text-white p-4 rounded-xl shadow-md relative">
            <p class="text-3xl font-bold mb-1">
              <?= isset($stats["total_promotion"]) ? htmlspecialchars($stats["total_promotion"]) : 0 ?>
            </p>
            <p class="text-sm opacity-90">Total promotions</p>
            <i class="ri-stack-line absolute bottom-4 right-4 text-xl opacity-20"></i>
          </div>
        </div>

        <!-- Filters and View Options -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
          <div class="relative w-full md:w-1/2">
            <i class="ri-search-line absolute left-3 top-3 text-gray-400"></i>
            <input type="text" id="searchInput" placeholder="Rechercher une promotion..."
                   class="pl-10 pr-4 py-2 border border-gray-200 rounded-lg w-full focus:outline-none focus:ring-2 focus:ring-[#e52421] focus:border-transparent">
          </div>
          <div class="flex gap-3 w-full md:w-auto">
            <select id="statusFilter" class="px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#e52421] focus:border-transparent">
              <option value="all">Tous les statuts</option>
              <option value="active">Actif</option>
              <option value="inactive">Inactif</option>
            </select>
            <div class="bg-gray-100 p-1 rounded-lg flex">
              <button id="cardViewBtn" class="p-2 rounded-md bg-white shadow-sm text-[#e52421]" aria-label="Vue grille">
                <i class="ri-grid-fill"></i>
              </button>
              <button id="tableViewBtn" class="p-2 rounded-md text-gray-500 hover:text-[#e52421]" aria-label="Vue liste">
                <i class="ri-list-check"></i>
              </button>
            </div>
          </div>
        </div>

        <!-- Promotions Grid View -->
        <div id="gridView" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
          <?php if (empty($promotions)): ?>
            <div class="col-span-full py-12 text-center">
              <div class="mx-auto w-40 h-40 rounded-full bg-gradient-to-br from-gray-50 to-gray-100 flex items-center justify-center mb-6 shadow-inner">
                <i class="fas fa-chalkboard-teacher text-5xl text-gray-300"></i>
              </div>
              <h3 class="text-xl font-medium text-gray-700 mb-2">Aucune promotion disponible</h3>
              <p class="text-gray-400 mb-4">Créez votre première promotion pour commencer</p>
              <button class="bg-[#e52421] text-white px-6 py-2 rounded-lg hover:bg-[#c11e1b] transition">
                <i class="ri-add-line mr-2"></i>Nouvelle promotion
              </button>
            </div>
          <?php else: ?>
            <?php foreach ($promotions as $promotion): ?>
              <div class="bg-white rounded-xl overflow-hidden shadow-md border border-gray-100 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                <!-- Status Ribbon -->
                <div class="absolute top-0 right-0 bg-[#e52421] text-white text-xs font-bold px-3 py-1 rounded-bl-lg">
                  <?= htmlspecialchars($promotion["statut"] ?? 'Non défini') ?>
                </div>

                <div class="p-5">
                  <!-- Promotion Header -->
                  <div class="flex justify-between items-start mb-4">
                    <div>
                      <h3 class="text-xl font-bold text-gray-800 mb-1">
                        <?= htmlspecialchars($promotion["promotion"] ?? 'Non défini') ?>
                      </h3>
                      <div class="flex items-center text-sm text-gray-500">
                        <i class="ri-calendar-line mr-1"></i>
                        <span><?= htmlspecialchars($promotion["date_debut"] ?? 'Non défini') ?></span>
                        <span class="mx-1">-</span>
                        <span><?= htmlspecialchars($promotion["date_fin"] ?? 'Non défini') ?></span>
                      </div>
                    </div>
                    <div class="bg-gray-100 w-12 h-12 p-2 rounded-full flex items-center justify-center">
                      <i class="ri-group-line text-2xl text-[#e52421]"></i>
                    </div>
                  </div>

                  <!-- Promotion Details -->
                  <div class="mb-4">
                    <div class="flex items-center text-sm text-gray-600 mb-2">
                      <i class="ri-user-line mr-2 text-[#e52421]"></i>
                      <span><?= htmlspecialchars($promotion["nombre_apprenants"] ?? 0) ?> apprenants</span>
                    </div>
                    <div class="flex items-center text-sm text-gray-600">
                      <i class="ri-book-2-line mr-2 text-[#e52421]"></i>
                      <span><?= htmlspecialchars($promotion["referentiel"] ?? 'Non assigné') ?></span>
                    </div>
                  </div>

                  <!-- Progress Bar -->
                  <div class="mb-4">
                    <div class="flex justify-between text-xs text-gray-500 mb-1">
                      <span>Progression</span>
                      <span>65%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                      <div class="bg-[#e52421] h-2 rounded-full" style="width: 65%"></div>
                    </div>
                  </div>

                  <!-- Actions -->
                  <div class="flex justify-between items-center pt-3 border-t border-gray-100">
                    <a href="<?=WEBROOT?>?controllers=promotion&page=voir&id=<?= htmlspecialchars($promotion['id'] ?? '') ?>"
                       class="text-sm text-[#e52421] hover:text-[#c11e1b] flex items-center hover:underline">
                      <i class="ri-eye-line mr-1"></i> Voir
                    </a>
                    <a href="<?=WEBROOT?>?controllers=promotion&page=editer&id=<?= htmlspecialchars($promotion['id']) ?>"
                       class="text-sm text-gray-600 hover:text-gray-800 flex items-center hover:underline">
                      <i class="ri-pencil-line mr-1"></i> Éditer
                    </a>
                    <a href="<?=WEBROOT?>?controllers=promotion&page=supprimer&id=<?= htmlspecialchars($promotion['id'] ?? '') ?>"
                       class="text-sm text-gray-600 hover:text-gray-800 flex items-center hover:underline"
                       onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette promotion ?')">
                      <i class="ri-delete-bin-line mr-1"></i> Supprimer
                    </a>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>

        <!-- Table View (Hidden by default) -->
        <div id="tableView" class="hidden bg-white rounded-xl shadow overflow-hidden mt-6">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Promotion</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Période</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Référentiel</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Apprenants</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <?php if (!empty($promotions)): ?>
                <?php foreach ($promotions as $promotion): ?>
                  <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="flex items-center">
                        <div class="flex-shrink-0 h-10 w-10 bg-[#e52421]/10 rounded-full flex items-center justify-center">
                          <i class="ri-group-line text-[#e52421]"></i>
                        </div>
                        <div class="ml-4">
                          <div class="text-sm font-medium text-gray-900"><?= htmlspecialchars($promotion["promotion"] ?? 'Non défini') ?></div>
                        </div>
                      </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="text-sm text-gray-500">
                        <?= htmlspecialchars($promotion["date_debut"] ?? '') ?> - <?= htmlspecialchars($promotion["date_fin"] ?? '') ?>
                      </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="text-sm text-gray-500"><?= htmlspecialchars($promotion["referentiel"] ?? 'Non assigné') ?></div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-[#e52421]/10 text-[#e52421]">
                        <?= htmlspecialchars($promotion["nombre_apprenants"] ?? 0) ?> apprenants
                      </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?= ($promotion["statut"] ?? '') === 'Active' ? 'bg-green-100 text-green-800' : 'bg-[#e52421]/10 text-[#e52421]' ?>">
                        <?= htmlspecialchars($promotion["statut"] ?? 'Inactive') ?>
                      </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                      <a href="<?=WEBROOT?>?controllers=promotion&page=voir<?= htmlspecialchars($promotion['id'] ?? '') ?>" 
                         class="inline-block text-[#e52421] hover:text-[#c11e1b] mr-3 hover:underline"
                         title="Voir les détails">
                        <i class="ri-eye-line"></i>
                      </a>
                      <a href="<?=WEBROOT?>?controllers=promotion&page=editer<?= htmlspecialchars($promotion['id'] ?? '') ?>" 
                         class="inline-block text-[#2e5b97] hover:text-[#234a7a] mr-3 hover:underline"
                         title="Modifier">
                        <i class="ri-pencil-line"></i>
                      </a>
                      <a href="<?=WEBROOT?>?controllers=promotion&page=supprimer<?= htmlspecialchars($promotion['id'] ?? '') ?>" 
                         class="inline-block text-gray-600 hover:text-gray-900 hover:underline"
                         title="Supprimer"
                         onclick="return confirm('Êtes-vous sûr de vouloir supprimer la promotion <?= htmlspecialchars(addslashes($promotion['promotion'] ?? '')) ?> ?')">
                        <i class="ri-delete-bin-line"></i>
                      </a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                    Aucune promotion disponible
                  </td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </main>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Éléments du DOM
    const searchInput = document.getElementById('searchInput');
    const statusFilter = document.getElementById('statusFilter');
    const cardViewBtn = document.getElementById('cardViewBtn');
    const tableViewBtn = document.getElementById('tableViewBtn');
    const gridView = document.getElementById('gridView');
    const tableView = document.getElementById('tableView');

    // Fonction de filtrage
    function filterPromotions() {
        const searchTerm = searchInput.value.toLowerCase();
        const status = statusFilter.value.toLowerCase();
        
        // Filtrage pour la vue grille
        const cards = gridView.querySelectorAll('.bg-white');
        cards.forEach(card => {
            const title = card.querySelector('h3').textContent.toLowerCase();
            const cardStatus = card.querySelector('.absolute').textContent.toLowerCase();
            
            const matchesSearch = title.includes(searchTerm);
            const matchesStatus = status === 'all' || cardStatus.includes(status);
            
            card.style.display = (matchesSearch && matchesStatus) ? 'block' : 'none';
        });
        
        // Filtrage pour la vue tableau
        const rows = tableView.querySelectorAll('tbody tr');
        rows.forEach(row => {
            if (row.querySelector('td')) {
                let matchesSearch = false;
                const cells = row.querySelectorAll('td');
                
                cells.forEach(cell => {
                    if (cell.textContent.toLowerCase().includes(searchTerm)) {
                        matchesSearch = true;
                    }
                });
                
                const rowStatus = row.querySelector('td:nth-child(5) span').textContent.toLowerCase();
                const matchesStatus = status === 'all' || rowStatus.includes(status);
                
                row.style.display = (matchesSearch && matchesStatus) ? 'table-row' : 'none';
            }
        });
    }

    // Écouteurs d'événements
    searchInput.addEventListener('input', filterPromotions);
    statusFilter.addEventListener('change', filterPromotions);

    // Basculer entre les vues
    cardViewBtn.addEventListener('click', function() {
        gridView.classList.remove('hidden');
        tableView.classList.add('hidden');
        cardViewBtn.classList.add('bg-white', 'shadow-sm', 'text-[#e52421]');
        cardViewBtn.classList.remove('text-gray-500');
        tableViewBtn.classList.remove('bg-white', 'shadow-sm', 'text-[#e52421]');
        tableViewBtn.classList.add('text-gray-500');
    });

    tableViewBtn.addEventListener('click', function() {
        gridView.classList.add('hidden');
        tableView.classList.remove('hidden');
        tableViewBtn.classList.add('bg-white', 'shadow-sm', 'text-[#e52421]');
        tableViewBtn.classList.remove('text-gray-500');
        cardViewBtn.classList.remove('bg-white', 'shadow-sm', 'text-[#e52421]');
        cardViewBtn.classList.add('text-gray-500');
    });
});
</script>