<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>connexion</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="h-screen flex items-center justify-center p-4 font-sans overflow-hidden " style="background-image:url('assets/images/background2.jpg'); background-size: cover;
background-position: center;
background-repeat: no-repeat;">
  <div class="bg-white p-8 rounded-2xl shadow-sm w-full max-w-md mx-auto mt-16 border border-gray-200">
    <div class="text-center mb-8">
        <h1 class="text-2xl font-bold text-gray-800 mb-1">Bienvenue sur ecote 221</h1>
        <h2 class="text-xl font-semibold text-gray-700 mb-6">Se connecter</h2>
    </div>
    
    <!-- Bouton Google -->
    <div class="mb-8">
        <button class="w-full flex items-center justify-center gap-2 px-5 py-3 border border-gray-300 rounded-lg font-medium text-gray-700 hover:bg-gray-50 transition-colors">
            <span class="font-bold">G</span>
            <span>Sign in with Google</span>
        </button>
    </div>
    
    <div class="relative mb-8">
        <div class="absolute inset-0 flex items-center">
            <div class="w-full border-t border-gray-300"></div>
        </div>
        <div class="relative flex justify-center text-sm">
            <span class="px-2 bg-white text-gray-500">Ou</span>
        </div>
    </div>
    
    <form id="form" method="POST" class="space-y-4">
        <div>
            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Entrez votre numéro de téléphone ou votre email</label>
            <input id="phone" type="text" name="email" value="<?= $_POST['email'] ?? '' ?>" 
                   class="w-full px-4 py-3 border <?= isset($error['email']) ? 'border-red-500' : 'border-gray-300' ?> rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all placeholder-gray-400">
            <?php if(isset($error['email'])): ?>
                <p class="text-red-500 text-sm mt-1"><?= $error['email'] ?></p>
            <?php endif; ?>
        </div>
        
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Mot de passe</label>
            <input id="password" type="password" name="password" 
                   class="w-full px-4 py-3 border <?= isset($error['password']) ? 'border-red-500' : 'border-gray-300' ?> rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all placeholder-gray-400">
            <?php if(isset($error['password'])): ?>
                <p class="text-red-500 text-sm mt-1"><?= $error['password'] ?></p>
            <?php endif; ?>
            <a href="#" class="text-sm text-blue-600 hover:text-blue-800 transition-colors mt-1 inline-block">Mot de passe oublié ?</a>
        </div>
        
        <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg font-medium hover:bg-blue-700 transition-colors mt-6">
            Se connecter
        </button>
    </form>
</div>
</body>

</html>