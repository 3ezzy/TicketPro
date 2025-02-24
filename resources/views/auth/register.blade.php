<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TicketFlow - Inscription</title>
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
                <h1 class="text-3xl font-bold text-primary mb-2">TicketFlow</h1>
                <p class="text-secondary">Créer votre compte</p>
            </div>

            <!-- Registration Form -->
            <div class="bg-white rounded-xl shadow-lg p-8">
                <h2 class="text-2xl font-semibold text-primary mb-6">Inscription</h2>
                <form method="POST" action="{{ route('register') }}" class="space-y-6">
                    @csrf

                    <!-- Name Fields -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                Prénom
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-user text-gray-400"></i>
                                </div>
                                <x-text-input id="name" 
                                              class="block w-full pl-10 pr-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-mint focus:border-mint" 
                                              type="text" 
                                              name="name" 
                                              :value="old('name')" 
                                              required 
                                              autofocus 
                                              autocomplete="name" 
                                              placeholder="Prénom"/>
                            </div>
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>
                        <div>
                            <label for="last_name" class="block text-sm font-medium text-gray-700 mb-2">
                                Nom
                            </label>
                            <input type="text" 
                                   class="block w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-mint focus:border-mint" 
                                   id="last_name" 
                                   name="last_name" 
                                   placeholder="Nom">
                        </div>
                    </div>

                    <!-- Email Field -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            Email
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-envelope text-gray-400"></i>
                            </div>
                            <x-text-input id="email" 
                                          class="block w-full pl-10 pr-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-mint focus:border-mint" 
                                          type="email" 
                                          name="email" 
                                          :value="old('email')" 
                                          required 
                                          autocomplete="username" 
                                          placeholder="votre@email.com"/>
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password Fields -->
                    <div class="space-y-4">
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
                                              type="password" 
                                              name="password" 
                                              required 
                                              autocomplete="new-password" 
                                              placeholder="Mot de passe"/>
                            </div>
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                                Confirmer le mot de passe
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-lock text-gray-400"></i>
                                </div>
                                <x-text-input id="password_confirmation" 
                                              class="block w-full pl-10 pr-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-mint focus:border-mint" 
                                              type="password" 
                                              name="password_confirmation" 
                                              required 
                                              autocomplete="new-password" 
                                              placeholder="Confirmer le mot de passe"/>
                            </div>
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Role Selection -->
                    <div>
                        <label for="role" class="block text-sm font-medium text-gray-700 mb-2">
                            Rôle
                        </label>
                        <div class="relative">
                            <select id="role" 
                                    name="role" 
                                    class="block w-full pl-3 pr-10 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-mint focus:border-mint appearance-none">
                                <option value="">Sélectionnez votre rôle</option>
                                <option value="developer">Développeur</option>
                                <option value="manager">Manager</option>
                                <option value="admin">Administrateur</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                                <i class="fas fa-chevron-down text-gray-400"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Terms & Conditions -->
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input type="checkbox" 
                                   id="terms" 
                                   name="terms" 
                                   class="h-4 w-4 text-mint focus:ring-mint border-gray-300 rounded" 
                                   required>
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="terms" class="text-gray-700">
                                J'accepte les 
                                <a href="#" class="text-mint hover:text-secondary">conditions d'utilisation</a>
                                et la 
                                <a href="#" class="text-mint hover:text-secondary">politique de confidentialité</a>
                            </label>
                        </div>
                    </div>

                    <!-- Register Button -->
                    <button type="submit" 
                            class="w-full bg-primary text-white py-2 px-4 rounded-lg hover:bg-secondary transition duration-150 flex items-center justify-center space-x-2 group">
                        <i class="fas fa-user-plus group-hover:scale-110 transition-transform"></i>
                        <span>S'inscrire</span>
                    </button>

                    <!-- Login Link -->
                    <div class="text-center mt-6">
                        <p class="text-sm text-gray-600">
                            Déjà inscrit? 
                            <a href="{{ route('login') }}" class="text-mint hover:text-secondary font-medium">
                                Se connecter
                            </a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>