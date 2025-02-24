<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TicketPro - Connexion</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#0A4D68',
                        secondary: '#088395',
                        mint: '#05BFDB',
                        'mint-light': '#00FFCA'
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-gray-50">
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full">
            <!-- Logo & Header -->
            <div class="text-center mb-8">
                <div class="flex justify-center mb-4">
                    <div class="rounded-full bg-primary p-4 shadow-lg">
                        <i class="fas fa-ticket-alt text-mint text-3xl"></i>
                    </div>
                </div>
                <h1 class="text-3xl font-bold text-primary mb-2">TicketPro</h1>
                <p class="text-secondary">Système de Gestion des Tickets</p>
            </div>

            <!-- Login Form -->
            <div class="bg-white rounded-xl shadow-lg p-8">
                <h2 class="text-2xl font-semibold text-primary mb-6">Connexion</h2>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            Email
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-user text-gray-400"></i>
                            </div>
                            <x-text-input id="email"
                                class="block w-full pl-10 pr-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-mint focus:border-mint"
                                type="email" name="email" :value="old('email')" required autofocus
                                autocomplete="username" placeholder="Entrez votre email" />
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            Mot de passe
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-gray-400"></i>
                            </div>
                            <x-text-input id="password"
                                class="block w-full pl-10 pr-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-mint focus:border-mint"
                                type="password" name="password" required autocomplete="current-password"
                                placeholder="Entrez votre mot de passe" />
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember_me" type="checkbox"
                                class="h-4 w-4 text-mint focus:ring-mint border-gray-300 rounded" name="remember">
                            <label for="remember_me" class="ml-2 block text-sm text-gray-700">
                                Se souvenir de moi
                            </label>
                        </div>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-sm text-mint hover:text-secondary">
                                Mot de passe oublié?
                            </a>
                        @endif
                    </div>

                    <!-- Login Button -->
                    <button type="submit"
                        class="w-full bg-primary text-white py-2 px-4 rounded-lg hover:bg-secondary transition duration-150 flex items-center justify-center space-x-2 group">
                        <i class="fas fa-sign-in-alt group-hover:translate-x-1 transition-transform"></i>
                        <span>Se connecter</span>
                    </button>

                    <!-- Divider -->
                    <div class="relative my-6">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-200"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 bg-white text-gray-500">Ou continuer avec</span>
                        </div>
                    </div>

                    <!-- Social Login -->
                    <div class="grid grid-cols-2 gap-4">
                        <button
                            class="flex items-center justify-center px-4 py-2 border border-gray-200 rounded-lg hover:bg-gray-50 transition duration-150">
                            <i class="fab fa-google text-red-500 mr-2"></i>
                            Google
                        </button>
                        <button
                            class="flex items-center justify-center px-4 py-2 border border-gray-200 rounded-lg hover:bg-gray-50 transition duration-150">
                            <i class="fab fa-github text-gray-800 mr-2"></i>
                            GitHub
                        </button>
                    </div>

                    <!-- Register Link -->
                    <div class="text-center mt-6">
                        <p class="text-sm text-gray-600">
                            Pas encore de compte?
                            <a href="{{ route('register') }}" class="text-mint hover:text-secondary font-medium">
                                S'inscrire
                            </a>
                        </p>
                    </div>
                </form>
            </div>

            <!-- Footer -->
            <div class="mt-8 text-center text-sm text-gray-500">
                <p>© 2025 TicketFlow. Tous droits réservés.</p>
                <p class="mt-1">Version 1.0.0</p>
            </div>
        </div>
    </div>
</body>

</html>
