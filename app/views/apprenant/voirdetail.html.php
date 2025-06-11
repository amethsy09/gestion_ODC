  <div class="flex h-screen">

      <!-- Sidebar -->
      <aside class="w-64 bg-white p-4 shadow">
          <div class="flex items-center justify-center mb-6">
              <img src="https://via.placeholder.com/80" class="w-20 h-20 rounded-full border" alt="Photo Apprenant">
          </div>
          <div class="flex items-center gap-4 mb-4">
              <div>
                  <div class="flex flex-col items-center">
                      <h1 class="text-xl font-bold text-green-700 text-center">Seydina Mouhammad Diop</h1>
                      <span class="badge badge-success">DEV WEB/MOBILE</span><br>
                      <p class="badge badge-success">Actif</p>
                  </div>

                  <div class="text-sm mt-2 text-gray-700 ml-1">
                      <p>📞 +221 78 959 35 46</p>
                      <p>✉️ mouhdiop7@gmail.com</p>
                      <p>📍 Sicap Liberté 6, Dakar</p>
                  </div>
              </div>
          </div>
      </aside>

      <!-- Main content -->
      <main class="flex-1 p-6">

          <!-- Header Apprenant -->

          <!-- Stats -->
          <div class="grid grid-cols-3 gap-4 mb-6">
              <div class="bg-white p-4 rounded shadow text-center">
                  <h3 class="text-xl font-bold text-green-600">20</h3>
                  <p class="text-sm">Présence(s)</p>
              </div>
              <div class="bg-white p-4 rounded shadow text-center">
                  <h3 class="text-xl font-bold text-yellow-500">5</h3>
                  <p class="text-sm">Retard(s)</p>
              </div>
              <div class="bg-white p-4 rounded shadow text-center">
                  <h3 class="text-xl font-bold text-red-600">1</h3>
                  <p class="text-sm">Absence(s)</p>
              </div>
          </div>

          <!-- Onglets (Options) -->
          <div role="tablist" class="tabs tabs-boxed mb-6">
              <a role="tab" class="tab tab-active" onclick="showTab('modules')">Programme & Modules</a>
              <a role="tab" class="tab" onclick="showTab('absences')">Liste de présences</a>
          </div>

          <!-- Modules -->
          <section id="modules">
              <div class="grid md:grid-cols-2 xl:grid-cols-3 gap-4">
                  <!-- Module Card -->
                  <div class="card bg-white shadow">
                      <div class="card-body">
                          <p class=" bg-black text-gray-400">🧭 : 30 jours</p>
                          <h2 class="card-title text-black">Algorithme & Langage C</h2>
                          <p>Compétence algorithmique & pratique codage en langage C</p>
                          <p class="text-sm text-gray-500">15 Février 2025 - 12:45</p>
                      </div>
                  </div>
                  <!-- Dupliquer les cards pour chaque module... -->
                  <!-- Exemple module suivant -->
                  <div class="card bg-white shadow">
                      <div class="card-body">
                          <p class=" bg-black text-gray-400">🧭: 15 jours</p>
                          <h2 class="card-title text-black">Frontend 1: Html, Css & JS</h2>
                          <p>Création d'interfaces de design avec animations avancées</p>
                          <p class="text-sm text-gray-500">24 Mars 2025 - 12:45</p>
                      </div>
                  </div>
              </div>
          </section>

          <!-- Total Absences -->
          <section id="absences" class="hidden">
              <div class="overflow-x-auto">
                  <table class="table table-zebra bg-white">
                      <thead class="bg-orange-100 text-orange-800">
                          <tr>
                              <th>Photo</th>
                              <th>Matricule</th>
                              <th>Nom Complet</th>
                              <th>Date & Heure</th>
                              <th>Statut</th>
                              <th>Justification</th>
                              <th>Actions</th>
                          </tr>
                      </thead>
                      <tbody>
                          <tr>
                              <td><img src="https://via.placeholder.com/40" class="rounded-full" /></td>
                              <td>1058215</td>
                              <td>Seydina Mouhammad Diop</td>
                              <td>10/02/2025 - 7:32</td>
                              <td><span class="badge badge-error">Absent</span></td>
                              <td><span class="badge badge-success">Justifiée</span></td>
                              <td><button class="btn btn-sm btn-ghost">⋮</button></td>
                          </tr>
                          <tr>
                              <td><img src="https://via.placeholder.com/40" class="rounded-full" /></td>
                              <td>1058216</td>
                              <td>Seydina Mouhammad Diop</td>
                              <td>11/02/2025 - 7:32</td>
                              <td><span class="badge badge-success">Présent</span></td>
                              <td>–</td>
                              <td><button class="btn btn-sm btn-ghost">⋮</button></td>
                          </tr>
                          <!-- Ajouter plus de lignes -->
                      </tbody>
                  </table>
              </div>
          </section>

      </main>
  </div>

  <script>
      function showTab(tab) {
          document.getElementById('modules').classList.add('hidden');
          document.getElementById('absences').classList.add('hidden');
          document.getElementById(tab).classList.remove('hidden');

          document.querySelectorAll('.tab').forEach(tab => tab.classList.remove('tab-active'));
          if (tab === 'modules') document.querySelectorAll('.tab')[0].classList.add('tab-active');
          if (tab === 'absences') document.querySelectorAll('.tab')[1].classList.add('tab-active');
      }
  </script>