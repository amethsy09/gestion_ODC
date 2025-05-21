 <?php
require_once "login.html.php";
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Tableau de bord</title>
</head>
<body class="p-6 bg-gray-100">
    <div class="max-w-lg p-4 mx-auto bg-white rounded shadow">
        <h2 class="text-xl font-semibold">Bienvenue, <?php echo $_SESSION["user"]["nom"]; ?> !</h2>
        <p>Vous êtes connecté en tant que <?php echo $_SESSION["user"]["role"]; ?>.</p>
        <a href="logout.php" class="block mt-4 text-blue-500">Déconnexion</a>
    </div>
</body>
</html>

