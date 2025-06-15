<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard - Sonatel ODC</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 text-gray-800 min-h-screen">

  <!-- Header -->
  <header class="bg-white shadow p-4 flex justify-between items-center">
    <h1 class="text-xl font-bold">Dashboard - Promotion 2025</h1>
    <div>
      <select id="monthSelector" class="border rounded px-3 py-1">
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
    </div>
  </header>

  <!-- Main Content -->
  <main class="container mx-auto px-4 py-4">
    <!-- Stats Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
      <div class="bg-orange-500 text-white p-4 rounded-xl shadow">
        <p class="text-lg font-semibold">180 Apprenants</p>
      </div>
      <div class="bg-orange-400 text-white p-4 rounded-xl shadow">
        <p class="text-lg font-semibold">5 Référentiels</p>
      </div>
      <div class="bg-orange-300 text-white p-4 rounded-xl shadow">
        <p class="text-lg font-semibold">5 Stagiaires</p>
      </div>
      <div class="bg-orange-200 text-white p-4 rounded-xl shadow">
        <p class="text-lg font-semibold">13 Permanents</p>
      </div>
    </div>

    <!-- Graphique de présence -->
    <div class="bg-white p-6 rounded-xl shadow mb-6">
      <h2 class="text-lg font-semibold mb-4">Présences statistiques</h2>
      <canvas id="presenceChart" height="100"></canvas>
    </div>

    <!-- Taux d'insertion et féminisation -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <div class="bg-white p-6 rounded-xl shadow flex flex-col items-center">
        <p class="text-xl font-semibold">Taux d'insertion professionnelle</p>
        <p class="text-4xl text-green-600 mt-2">100%</p>
      </div>
      <div class="bg-white p-6 rounded-xl shadow flex flex-col items-center">
        <p class="text-xl font-semibold">Taux de féminisation</p>
        <p class="text-4xl text-pink-500 mt-2">56%</p>
      </div>
    </div>
  </main>

  <script>
    const ctx = document.getElementById('presenceChart').getContext('2d');
    const presenceChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: ['Présence', 'Retard', 'Absence'],
        datasets: [{
          label: 'Présences',
          data: [75, 15, 10],
          backgroundColor: ['#10B981', '#F59E0B', '#EF4444']
        }]
      },
      options: {
        responsive: true,
        scales: {
          y: {
            beginAtZero: true,
            max: 100
          }
        }
      }
    });

    document.getElementById('monthSelector').addEventListener('change', function() {
      const month = this.value;
      const dataByMonth = [
        [65, 20, 15],
        [70, 10, 20],
        [75, 15, 10],
        [60, 25, 15],
        [80, 10, 10],
        [85, 10, 5],
        [77, 13, 10],
        [90, 5, 5],
        [68, 22, 10],
        [73, 15, 12],
        [78, 10, 12],
        [83, 12, 5]
      ];

      presenceChart.data.datasets[0].data = dataByMonth[month];
      presenceChart.update();
    });
  </script>
</body>

</html>