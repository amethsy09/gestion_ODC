<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>connexion</title>
    <script src="https://cdn.tailwindcss.com"></script>
     <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            600: '#0284c7',
                            700: '#0369a1',
                        },
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                }
            }
        }
    </script>
</head>

<body class="h-screen flex items-center justify-center p-4 font-sans overflow-hidden " style="background-image:url('assets/images/background2.jpg'); background-size: cover;
background-position: center;
background-repeat: no-repeat;">
         <div class="text-center mb-8">
            <h1 class="text-2xl font-semibold text-gray-800 mb-1">Bienvenue sur Ecote 221</h1>
            <p class="text-gray-600">Connectez-vous pour accéder à votre compte</p>
        </div>
        
        <!-- Bouton Google -->
        <div class="mb-6">
            <button class="w-full flex items-center justify-center gap-3 px-5 py-2.5 border border-gray-200 rounded-lg font-medium text-gray-700 hover:bg-gray-50 transition-colors duration-200 shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-5 h-5">
                    <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                    <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                    <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                    <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                </svg>
                <span>Continuer avec Google</span>
            </button>
        </div>
        
        <div class="relative mb-6">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-200"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-3 bg-white text-gray-400 text-sm">ou connectez-vous par email</span>
            </div>
        </div>
        
        <form id="form" method="POST" class="space-y-5">
            <div>
                <label for="phone" class="block text-sm font-medium text-gray-700 mb-1.5">Email ou numéro de téléphone</label>
                <input id="phone" type="text" name="email" value="<?= $_POST['email'] ?? '' ?>" 
                       class="w-full px-4 py-2.5 border <?= isset($error['email']) ? 'border-red-300' : 'border-gray-200' ?> rounded-lg focus:ring-1 focus:ring-primary-600 focus:border-primary-600 transition-all placeholder-gray-400 text-sm shadow-sm hover:border-gray-300"
                       placeholder="exemple@email.com">
                <?php if(isset($error['email'])): ?>
                    <p class="text-red-500 text-xs mt-1.5 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                        <?= $error['email'] ?>
                    </p>
                <?php endif; ?>
            </div>
            
            <div>
                <div class="flex justify-between items-center mb-1.5">
                    <label for="password" class="block text-sm font-medium text-gray-700">Mot de passe</label>
                    <a href="#" class="text-xs text-primary-600 hover:text-primary-700 transition-colors">Mot de passe oublié ?</a>
                </div>
                <div class="relative">
                    <input id="password" type="password" name="password" 
                           class="w-full px-4 py-2.5 border <?= isset($error['password']) ? 'border-red-300' : 'border-gray-200' ?> rounded-lg focus:ring-1 focus:ring-primary-600 focus:border-primary-600 transition-all placeholder-gray-400 text-sm shadow-sm hover:border-gray-300 pr-10"
                           placeholder="••••••••">
                    <button type="button" onclick="togglePasswordVisibility()" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">
                        <svg id="eye-icon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <svg id="eye-off-icon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                        </svg>
                    </button>
                </div>
                <?php if(isset($error['password'])): ?>
                    <p class="text-red-500 text-xs mt-1.5 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                        <?= $error['password'] ?>
                    </p>
                <?php endif; ?>
            </div>
            
            <button type="submit" class="w-full bg-primary-600 text-white py-2.5 rounded-lg font-medium hover:bg-primary-700 transition-colors duration-200 shadow-sm mt-2 flex items-center justify-center">
                <span>Se connecter</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </button>
        </form>
        
        <div class="text-center text-sm text-gray-500 mt-6">
            Vous n'avez pas de compte ? <a href="#" class="text-primary-600 hover:text-primary-700 font-medium">S'inscrire</a>
        </div>
    </div>

    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            const eyeOffIcon = document.getElementById('eye-off-icon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.add('hidden');
                eyeOffIcon.classList.remove('hidden');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('hidden');
                eyeOffIcon.classList.add('hidden');
            }
        }
    </script>
</body>

</html>