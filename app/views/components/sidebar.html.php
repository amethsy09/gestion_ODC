<div class="flex h-screen bg-gray-50">
  <!-- Sidebar -->
  <div class="hidden md:flex md:flex-shrink-0">
    <div class="flex flex-col w-64 border-r border-gray-200 bg-white">
      <!-- Sidebar header -->
      <div class="flex items-center h-16 px-4 border-b border-gray-200">
        <div class="flex items-center">
          <i class="ri-graduation-cap-line text-2xl text-[#e52421] mr-2"></i>
          <span class="text-xl font-bold text-gray-800">Gestion ODC</span>
        </div>
      </div>

      <!-- Sidebar navigation -->
      <div class="flex-1 overflow-y-auto">
        <nav class="px-4 py-4">
          <div class="space-y-1">
            <!-- Active item -->
            <a href="#" class="text-gray-600 hover:bg-gray-50 hover:text-gray-900 group flex items-center px-3 py-2 text-sm font-medium rounded-md">
              <i class="ri-dashboard-line text-lg mr-3"></i>
              Tableau de bord
            </a>

            <a href="<?= WEBROOT ?>?controllers=apprenant&page=listeApprenant" class="text-gray-600 hover:bg-gray-50 hover:text-gray-900 group flex items-center px-3 py-2 text-sm font-medium rounded-md">
              <i class="ri-group-line text-lg mr-3"></i>
              Apprenants
            </a>

            <a href="<?= WEBROOT ?>?controllers=referentiel&page=listeReferentiel" class="text-gray-600 hover:bg-gray-50 hover:text-gray-900 group flex items-center px-3 py-2 text-sm font-medium rounded-md">
              <i class="ri-book-2-line text-lg mr-3"></i>
              Référentiels
            </a>

            <a href="<?= WEBROOT ?>?controllers=promotion&page=listePromotion" class="bg-[#e52421]/10 text-[#e52421] group flex items-center px-3 py-2 text-sm font-medium rounded-md">
              <i class="ri-calendar-event-line text-lg mr-3"></i>
              Promotions
            </a>

            <a href="#" class="text-gray-600 hover:bg-gray-50 hover:text-gray-900 group flex items-center px-3 py-2 text-sm font-medium rounded-md">
              <i class="ri-file-chart-line text-lg mr-3"></i>
              Gestion des présences
            </a>

            <a href="#" class="text-gray-600 hover:bg-gray-50 hover:text-gray-900 group flex items-center px-3 py-2 text-sm font-medium rounded-md">
              <i class="ri-file-chart-line text-lg mr-3"></i>
              Kits et Laptops
            </a>

            <a href="#" class="text-gray-600 hover:bg-gray-50 hover:text-gray-900 group flex items-center px-3 py-2 text-sm font-medium rounded-md">
              <i class="ri-file-chart-line text-lg mr-3"></i>
              Rapport et Stats
            </a>
          </div>
        </nav>
      </div>

      <!-- Sidebar footer -->
      <div class="p-4 border-t border-gray-200">
        <div class="flex items-center">
          <div class="flex-shrink-0">
            <img class="h-10 w-10 rounded-full" src="https://img.freepik.com/photos-gratuite/avatar-androgyne-personne-queer-non-binaire_23-2151100279.jpg" alt="User avatar">
          </div>
          <div class="ml-3">
            <p class="text-sm font-medium text-gray-700">Admin User</p>
            <a href="<?= WEBROOT ?>?controllers=auth&page=logout" class="text-xs font-medium text-[#e52421] hover:text-[#c11e1b]">Déconnexion</a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Mobile sidebar (hidden by default) -->
  <div class="md:hidden fixed inset-0 z-40" id="mobile-sidebar" style="display: none;">
    <div class="fixed inset-0 bg-gray-600 bg-opacity-75" aria-hidden="true"></div>
    <div class="relative flex flex-col w-72 max-w-xs bg-white">
      <div class="absolute top-0 right-0 -mr-12 pt-2">
        <button class="ml-1 flex items-center justify-center h-10 w-10 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white">
          <span class="sr-only">Close sidebar</span>
          <i class="ri-close-line text-white text-2xl"></i>
        </button>
      </div>
      <div class="flex-1 h-0 pt-5 pb-4 overflow-y-auto">
        <!-- Mobile sidebar content (same as desktop) -->
        <div class="flex-shrink-0 flex items-center px-4">
          <i class="ri-graduation-cap-line text-2xl text-[#e52421] mr-2"></i>
          <span class="text-xl font-bold text-gray-800">PromoManager</span>
        </div>
        <nav class="mt-5 px-2 space-y-1">
          <!-- Same navigation items as desktop -->
        </nav>
      </div>
      <div class="flex-shrink-0 p-4 border-t border-gray-200">
        <!-- Same footer as desktop -->
      </div>
    </div>
  </div>
  
  <!-- Script for mobile sidebar toggle -->
  <script>
    document.getElementById('mobile-menu-button').addEventListener('click', function() {
      document.getElementById('mobile-sidebar').style.display = 'block';
    });

    document.querySelector('#mobile-sidebar button').addEventListener('click', function() {
      document.getElementById('mobile-sidebar').style.display = 'none';
    });
  </script>