<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard - Sonatel ODC</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: {
              50: '#f0f9ff',
              100: '#e0f2fe',
              200: '#bae6fd',
              300: '#7dd3fc',
              400: '#38bdf8',
              500: '#0ea5e9',
              600: '#0284c7',
              700: '#0369a1',
              800: '#075985',
              900: '#0c4a6e',
            },
            dark: {
              800: '#1e293b',
              900: '#0f172a',
            }
          }
        }
      }
    }
  </script>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
    
    body, html {
      margin: 0;
      padding: 0;
      width: 100%;
      height: 100%;
      font-family: 'Inter', sans-serif;
    }
    
    .glass-card {
      background: rgba(255, 255, 255, 0.8);
      backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);
      border: 1px solid rgba(255, 255, 255, 0.2);
    }
    
    .hover-scale {
      transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    
    .hover-scale:hover {
      transform: translateY(-2px);
      box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
    }
  </style>
</head>

<body class="bg-gradient-to-br from-gray-50 to-gray-100 text-gray-800 min-h-screen w-full">

  <!-- Header -->
  <header class="glass-card shadow-sm p-4 flex justify-between items-center sticky top-0 z-50 w-full">
    <div>
      <h1 class="text-2xl font-bold text-primary-600">Sonatel ODC</h1>
      <p class="text-sm text-gray-500">Dashboard - Promotion 2025</p>
    </div>
    <div class="flex items-center space-x-4">
      <div class="relative">
        <select id="monthSelector" class="appearance-none bg-white/80 border border-gray-200 rounded-lg px-4 py-2 pr-8 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent text-sm shadow-sm">
          <option value="0">Janvier</option>
          <option value="1">Février</option>
          <option value="2">Mars</option>
          <option value="3">Avril</option>
          <option value="4">Mai</option>
          <option value="5">Juin</option>
          <option value="6">Juillet</option>
          <option value="7">Août</option>
          <option value="8">Septembre</option>
          <option value="9">Octobre</option>
          <option value="10">Novembre</option>
          <option value="11">Décembre</option>
        </select>
        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
          </svg>
        </div>
      </div>
      <div class="w-9 h-9 rounded-full bg-primary-100 flex items-center justify-center shadow-sm hover:bg-primary-200 transition-colors cursor-pointer">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary-600" viewBox="0 0 20 20" fill="currentColor">
          <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
        </svg>
      </div>
    </div>
  </header>

  <!-- Main Content -->
  <main class="w-full max-w-none px-4 py-6 space-y-6 h-full">
    <!-- Grille Statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 w-full">
      <!-- Carte Apprenants -->
      <div class="glass-card rounded-xl p-6 shadow-sm hover-scale transition-all border-l-4 border-primary-500">
        <div class="flex justify-between items-start">
          <div>
            <p class="text-gray-500 text-sm font-medium">Apprenants</p>
            <p class="text-3xl font-bold text-gray-800 mt-1">142</p>
          </div>
          <div class="bg-primary-100/80 p-3 rounded-lg shadow-inner">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
          </div>
        </div>
        <div class="mt-5">
          <div class="flex justify-between text-xs text-gray-500 mb-1">
            <span>Masculin</span>
            <span>Féminin</span>
          </div>
          <div class="w-full bg-gray-200/50 rounded-full h-2">
            <div class="bg-gradient-to-r from-primary-500 to-primary-400 rounded-full h-2" style="width: 58%"></div>
          </div>
          <div class="flex justify-between text-xs mt-1">
            <span class="text-primary-600 font-medium">58%</span>
            <span class="text-primary-400 font-medium">42%</span>
          </div>
        </div>
      </div>

      <!-- Carte Referentiels -->
      <div class="glass-card rounded-xl p-6 shadow-sm hover-scale transition-all border-l-4 border-indigo-500">
        <div class="flex justify-between items-start">
          <div>
            <p class="text-gray-500 text-sm font-medium">Référentiels</p>
            <p class="text-3xl font-bold text-gray-800 mt-1">7</p>
          </div>
          <div class="bg-indigo-100/80 p-3 rounded-lg shadow-inner">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
          </div>
        </div>
        <div class="mt-5">
          <div class="flex justify-between text-xs text-gray-500 mb-1">
            <span>Complets</span>
            <span>En cours</span>
          </div>
          <div class="w-full bg-gray-200/50 rounded-full h-2">
            <div class="bg-gradient-to-r from-indigo-500 to-indigo-400 rounded-full h-2" style="width: 85%"></div>
          </div>
          <div class="flex justify-between text-xs mt-1">
            <span class="text-indigo-600 font-medium">85%</span>
            <span class="text-indigo-400 font-medium">15%</span>
          </div>
        </div>
      </div>

      <!-- Carte Promotion -->
      <div class="glass-card rounded-xl p-6 shadow-sm hover-scale transition-all border-l-4 border-emerald-500">
        <div class="flex justify-between items-start">
          <div>
            <p class="text-gray-500 text-sm font-medium">Promotions</p>
            <p class="text-3xl font-bold text-gray-800 mt-1">5</p>
          </div>
          <div class="bg-emerald-100/80 p-3 rounded-lg shadow-inner">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
          </div>
        </div>
        <div class="mt-5">
          <div class="flex justify-between text-xs text-gray-500 mb-1">
            <span>Actives</span>
            <span>Terminées</span>
          </div>
          <div class="w-full bg-gray-200/50 rounded-full h-2">
            <div class="bg-gradient-to-r from-emerald-500 to-emerald-400 rounded-full h-2" style="width: 60%"></div>
          </div>
          <div class="flex justify-between text-xs mt-1">
            <span class="text-emerald-600 font-medium">3</span>
            <span class="text-emerald-400 font-medium">2</span>
          </div>
        </div>
      </div>

      <!-- Carte Coach -->
      <div class="glass-card rounded-xl p-6 shadow-sm hover-scale transition-all border-l-4 border-amber-500">
        <div class="flex justify-between items-start">
          <div>
            <p class="text-gray-500 text-sm font-medium">Coachs</p>
            <p class="text-3xl font-bold text-gray-800 mt-1">12</p>
          </div>
          <div class="bg-amber-100/80 p-3 rounded-lg shadow-inner">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
            </svg>
          </div>
        </div>
        <div class="mt-5">
          <div class="flex justify-between text-xs text-gray-500 mb-1">
            <span>Disponibles</span>
            <span>Occupés</span>
          </div>
          <div class="w-full bg-gray-200/50 rounded-full h-2">
            <div class="bg-gradient-to-r from-amber-500 to-amber-400 rounded-full h-2" style="width: 75%"></div>
          </div>
          <div class="flex justify-between text-xs mt-1">
            <span class="text-amber-600 font-medium">9</span>
            <span class="text-amber-400 font-medium">3</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Section Graphiques -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 w-full">
      <!-- Graphique Présences -->
      <div class="glass-card p-5 rounded-xl shadow-sm">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-5">
          <h3 class="text-lg font-semibold text-gray-800 mb-2 sm:mb-0">Présences Mensuelles</h3>
          <div class="flex space-x-4">
            <span class="flex items-center text-sm">
              <div class="w-3 h-3 bg-primary-500 rounded-full mr-2"></div>Présences
            </span>
            <span class="flex items-center text-sm">
              <div class="w-3 h-3 bg-primary-200 rounded-full mr-2"></div>Absences
            </span>
          </div>
        </div>
        <div class="h-72">
          <canvas id="myBarChart"></canvas>
        </div>
      </div>

      <!-- Carte Géographique -->
      <div class="glass-card p-5 rounded-xl shadow-sm">
        <h3 class="text-lg font-semibold text-gray-800 mb-5">Localisation des Sites</h3>
        <div class="h-72 relative">
          <div class="bg-gradient-to-br from-gray-50 to-gray-100 w-full h-full rounded-lg flex items-center justify-center">
            <div class="text-center">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-300 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
              </svg>
              <span class="text-gray-400 font-medium">Carte Interactive</span>
              <p class="text-xs text-gray-400 mt-1">Les données géographiques seront affichées ici</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Section Infos Supplémentaires -->
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-4 w-full">
      <!-- Taux d'Insertion -->
      <div class="glass-card p-5 rounded-xl shadow-sm">
        <h3 class="text-lg font-semibold text-gray-800 mb-5">Taux d'Insertion</h3>
        <div class="flex flex-col items-center">
          <div class="relative w-48 h-48">
            <canvas id="insertionChart"></canvas>
            <div class="absolute inset-0 flex items-center justify-center">
              <div class="text-center">
                <span class="text-3xl font-bold text-primary-600">82%</span>
                <p class="text-sm text-gray-500 mt-1">Taux moyen</p>
              </div>
            </div>
          </div>
          <div class="mt-4 text-sm text-gray-600 text-center">
            <p>+5% par rapport au trimestre dernier</p>
          </div>
        </div>
      </div>

      <!-- Dernières Activités -->
      <div class="glass-card p-5 rounded-xl shadow-sm xl:col-span-2">
        <h3 class="text-lg font-semibold text-gray-800 mb-5">Activités Récentes</h3>
        <div class="space-y-3">
          <!-- Item Activité -->
          <div class="flex items-center p-3 hover:bg-gray-50/50 rounded-lg transition-all">
            <div class="bg-primary-100/80 p-2 rounded-lg mr-3 shadow-sm">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
              </svg>
            </div>
            <div class="flex-1">
              <p class="text-sm font-medium text-gray-800">Nouvel apprenant inscrit</p>
              <p class="text-xs text-gray-500">Il y a 2 heures</p>
            </div>
            <div class="text-xs px-2 py-1 bg-primary-100/80 text-primary-600 rounded-full shadow-sm">Nouveau</div>
          </div>

          <!-- Item Activité -->
          <div class="flex items-center p-3 hover:bg-gray-50/50 rounded-lg transition-all">
            <div class="bg-emerald-100/80 p-2 rounded-lg mr-3 shadow-sm">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
            </div>
            <div class="flex-1">
              <p class="text-sm font-medium text-gray-800">Formation terminée - Développement Web</p>
              <p class="text-xs text-gray-500">Aujourd'hui, 09:45</p>
            </div>
          </div>

          <!-- Item Activité -->
          <div class="flex items-center p-3 hover:bg-gray-50/50 rounded-lg transition-all">
            <div class="bg-amber-100/80 p-2 rounded-lg mr-3 shadow-sm">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
            </div>
            <div class="flex-1">
              <p class="text-sm font-medium text-gray-800">Session reportée - Data Science</p>
              <p class="text-xs text-gray-500">Hier, 16:30</p>
            </div>
          </div>

          <!-- Item Activité -->
          <div class="flex items-center p-3 hover:bg-gray-50/50 rounded-lg transition-all">
            <div class="bg-indigo-100/80 p-2 rounded-lg mr-3 shadow-sm">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
              </svg>
            </div>
            <div class="flex-1">
              <p class="text-sm font-medium text-gray-800">Nouveau référentiel ajouté</p>
              <p class="text-xs text-gray-500">Hier, 11:20</p>
            </div>
          </div>
        </div>
        <div class="mt-4 text-center">
          <button class="text-sm text-primary-600 font-medium hover:text-primary-700 transition-colors">Voir toutes les activités →</button>
        </div>
      </div>
    </div>
  </main>

  <script>
    // Bar Chart
    const barCtx = document.getElementById('myBarChart').getContext('2d');

    const barData = {
      labels: ['Sem 1', 'Sem 2', 'Sem 3', 'Sem 4'],
      datasets: [{
        label: 'Présences',
        data: [92, 88, 95, 89],
        backgroundColor: '#0ea5e9',
        borderRadius: 8,
        barThickness: 30
      }, {
        label: 'Absences',
        data: [8, 12, 5, 11],
        backgroundColor: '#bae6fd',
        borderRadius: 8,
        barThickness: 30
      }]
    };

    const barConfig = {
      type: 'bar',
      data: barData,
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            position: 'top',
            labels: {
              color: '#4B5563',
              font: {
                size: 12,
                family: "'Inter', sans-serif"
              },
              boxWidth: 12,
              padding: 20
            }
          },
          tooltip: {
            backgroundColor: '#1F2937',
            titleFont: {
              family: "'Inter', sans-serif",
              size: 12
            },
            bodyFont: {
              family: "'Inter', sans-serif",
              size: 12
            },
            padding: 10,
            cornerRadius: 8
          }
        },
        scales: {
          y: {
            beginAtZero: true,
            grid: {
              color: '#E5E7EB',
              drawBorder: false
            },
            ticks: {
              color: '#6B7280',
              font: {
                family: "'Inter', sans-serif"
              }
            }
          },
          x: {
            grid: {
              display: false,
              drawBorder: false
            },
            ticks: {
              color: '#6B7280',
              font: {
                family: "'Inter', sans-serif"
              }
            }
          }
        }
      }
    };

    new Chart(barCtx, barConfig);

    // Doughnut Chart
    const doughnutCtx = document.getElementById('insertionChart').getContext('2d');

    const doughnutData = {
      labels: ['Insertion', 'En recherche'],
      datasets: [{
        data: [82, 18],
        backgroundColor: ['#0ea5e9', '#e0f2fe'],
        borderWidth: 0,
        cutout: '75%'
      }]
    };

    const doughnutConfig = {
      type: 'doughnut',
      data: doughnutData,
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: false
          }
        }
      }
    };

    new Chart(doughnutCtx, doughnutConfig);
  </script>
</body>

</html>