@extends('layouts.guest')

@section('title', 'TicketFlow - Inscription')

@section('content')
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
            <form class="space-y-6" method="POST" action="{{ route('register') }}">
                @csrf <!-- CSRF Token for security -->

                <!-- First Name Field -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Prénom
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-user text-gray-400"></i>
                        </div>
                        <input type="text" 
                               name="firstName" 
                               class="block w-full pl-10 pr-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-mint focus:border-mint"
                               placeholder="Prénom"
                               required>
                    </div>
                </div>

                <!-- Last Name Field -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Nom
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-user text-gray-400"></i>
                        </div>
                        <input type="text" 
                               name="lastName" 
                               class="block w-full pl-10 pr-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-mint focus:border-mint"
                               placeholder="Nom"
                               required>
                    </div>
                </div>

                <!-- Username Field -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Nom d'utilisateur
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-at text-gray-400"></i>
                        </div>
                        <input type="text" 
                               name="username" 
                               class="block w-full pl-10 pr-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-mint focus:border-mint"
                               placeholder="Nom d'utilisateur"
                               required>
                    </div>
                </div>

                <!-- Email Field -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Email
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-gray-400"></i>
                        </div>
                        <input type="email" 
                               name="email" 
                               class="block w-full pl-10 pr-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-mint focus:border-mint"
                               placeholder="votre@email.com"
                               required>
                    </div>
                </div>

                <!-- Password Fields -->
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Mot de passe
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-gray-400"></i>
                            </div>
                            <input type="password" 
                                   name="password" 
                                   class="block w-full pl-10 pr-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-mint focus:border-mint"
                                   placeholder="Mot de passe"
                                   required>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Confirmer le mot de passe
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-gray-400"></i>
                            </div>
                            <input type="password" 
                                   name="password_confirmation" 
                                   class="block w-full pl-10 pr-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-mint focus:border-mint"
                                   placeholder="Confirmer le mot de passe"
                                   required>
                        </div>
                    </div>
                </div>

                <!-- Role Selection -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Rôle
                    </label>
                    <div class="relative">
                        <select name="role" 
                                class="block w-full pl-3 pr-10 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-mint focus:border-mint appearance-none">
                            <option value="client" selected>Client</option>
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
                               name="terms" 
                               class="h-4 w-4 text-mint focus:ring-mint border-gray-300 rounded"
                               required>
                    </div>
                    <div class="ml-3 text-sm">
                        <label class="text-gray-700">
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
@endsection