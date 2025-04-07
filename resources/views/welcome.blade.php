<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'TicketPro') }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Styles -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#0A4D68',    // Dark Blue
                        secondary: '#088395',   // Medium Blue
                        mint: '#05BFDB',       // Bright Mint
                        'mint-light': '#00FFCA' // Light Mint
                    }
                }
            }
        }
    </script>
    <style>
        .hero-gradient {
            background: linear-gradient(135deg, #0A4D68 0%, #088395 100%);
        }
        .feature-card:hover {
            transform: translateY(-5px);
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Header / Navigation -->
    <header class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0 flex items-center">
                        <i class="fas fa-ticket-alt text-mint text-2xl mr-2"></i>
                        <span class="font-bold text-2xl text-primary">TicketPro</span>
                    </div>
                </div>
                
                <!-- Navigation Links -->
                <div class="hidden md:flex md:items-center md:space-x-4">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="px-5 py-2 border border-transparent rounded-md text-sm font-medium text-white bg-primary hover:bg-secondary">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="px-5 py-2 border border-transparent rounded-md text-sm font-medium text-primary hover:text-secondary">
                                Login
                            </a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="px-5 py-2 border border-primary rounded-md text-sm font-medium text-primary hover:bg-primary hover:text-white">
                                    Register
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>
                
                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center">
                    <button type="button" class="mobile-menu-button p-2 rounded-md text-primary hover:text-mint focus:outline-none">
                        <i class="fas fa-bars text-lg"></i>
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Mobile menu -->
        <div class="md:hidden hidden mobile-menu">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3 border-t">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="block px-3 py-2 text-base font-medium text-white bg-primary rounded-md">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="block px-3 py-2 text-base font-medium text-primary hover:bg-gray-100 rounded-md">
                            Login
                        </a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="block px-3 py-2 text-base font-medium text-primary hover:bg-gray-100 rounded-md">
                                Register
                            </a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero-gradient">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 md:py-28">
            <div class="md:flex md:items-center md:justify-between">
                <div class="md:w-1/2 text-white mb-10 md:mb-0">
                    <h1 class="text-4xl md:text-5xl font-bold mb-6">Système de Gestion de Tickets</h1>
                    <p class="text-xl md:text-2xl mb-8 text-mint-light">Centralisez et résolvez efficacement les problèmes de vos clients avec notre plateforme intuitive.</p>
                    <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="px-8 py-3 bg-mint text-primary font-semibold rounded-lg hover:bg-mint-light shadow-lg transition duration-300">
                                Accéder au Tableau de Bord
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="px-8 py-3 bg-mint text-primary font-semibold rounded-lg hover:bg-mint-light shadow-lg transition duration-300">
                                Connectez-vous
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="px-8 py-3 border-2 border-mint text-white font-semibold rounded-lg hover:bg-mint hover:text-primary transition duration-300">
                                    Créer un Compte
                                </a>
                            @endif
                        @endauth
                    </div>
                </div>
                <div class="md:w-1/2 flex justify-center">
                    <div class="relative">
                        <div class="absolute inset-0 bg-mint rounded-xl opacity-10 transform rotate-3"></div>
                        <img src="https://ui-avatars.com/api/?name=Ticket+Pro&background=05BFDB&color=0A4D68&size=200&format=svg&bold=true" alt="TicketPro" class="relative z-10 rounded-xl shadow-2xl">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-primary">Fonctionnalités Principales</h2>
                <p class="mt-4 text-xl text-gray-600">Tout ce dont vous avez besoin pour gérer efficacement l'assistance client</p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="feature-card bg-white p-6 rounded-xl shadow-lg border-t-4 border-mint transition duration-300">
                    <div class="rounded-full bg-mint bg-opacity-10 w-14 h-14 flex items-center justify-center mb-4">
                        <i class="fas fa-ticket-alt text-mint text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-primary mb-2">Gestion de Tickets</h3>
                    <p class="text-gray-600">Créez, assignez et suivez les tickets de support dans une interface intuitive et organisée.</p>
                </div>
                
                <!-- Feature 2 -->
                <div class="feature-card bg-white p-6 rounded-xl shadow-lg border-t-4 border-mint transition duration-300">
                    <div class="rounded-full bg-mint bg-opacity-10 w-14 h-14 flex items-center justify-center mb-4">
                        <i class="fas fa-users text-mint text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-primary mb-2">Équipe de Développeurs</h3>
                    <p class="text-gray-600">Assignez les tickets aux développeurs appropriés et suivez leur résolution en temps réel.</p>
                </div>
                
                <!-- Feature 3 -->
                <div class="feature-card bg-white p-6 rounded-xl shadow-lg border-t-4 border-mint transition duration-300">
                    <div class="rounded-full bg-mint bg-opacity-10 w-14 h-14 flex items-center justify-center mb-4">
                        <i class="fas fa-chart-line text-mint text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-primary mb-2">Suivi et Statistiques</h3>
                    <p class="text-gray-600">Analysez les performances et les métriques pour améliorer continuellement votre processus de support.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Workflow Section -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-primary">Comment ça fonctionne</h2>
                <p class="mt-4 text-xl text-gray-600">Un processus simple et efficace pour résoudre les problèmes</p>
            </div>
            
            <div class="relative">
                <!-- Timeline -->
                <div class="hidden md:block absolute h-1 bg-mint top-1/2 left-0 right-0 transform -translate-y-1/2 z-0"></div>
                
                <div class="grid md:grid-cols-4 gap-8 relative z-10">
                    <!-- Step 1 -->
                    <div class="text-center">
                        <div class="mb-4 rounded-full bg-mint w-16 h-16 flex items-center justify-center text-white text-2xl font-bold mx-auto">1</div>
                        <h3 class="text-xl font-semibold text-primary mb-2">Création du Ticket</h3>
                        <p class="text-gray-600">Le client crée un ticket détaillant son problème avec le système.</p>
                    </div>
                    
                    <!-- Step 2 -->
                    <div class="text-center">
                        <div class="mb-4 rounded-full bg-mint w-16 h-16 flex items-center justify-center text-white text-2xl font-bold mx-auto">2</div>
                        <h3 class="text-xl font-semibold text-primary mb-2">Assignation</h3>
                        <p class="text-gray-600">L'administrateur assigne le ticket à un développeur qualifié.</p>
                    </div>
                    
                    <!-- Step 3 -->
                    <div class="text-center">
                        <div class="mb-4 rounded-full bg-mint w-16 h-16 flex items-center justify-center text-white text-2xl font-bold mx-auto">3</div>
                        <h3 class="text-xl font-semibold text-primary mb-2">Résolution</h3>
                        <p class="text-gray-600">Le développeur résout le problème et soumet la solution.</p>
                    </div>
                    
                    <!-- Step 4 -->
                    <div class="text-center">
                        <div class="mb-4 rounded-full bg-mint w-16 h-16 flex items-center justify-center text-white text-2xl font-bold mx-auto">4</div>
                        <h3 class="text-xl font-semibold text-primary mb-2">Approbation</h3>
                        <p class="text-gray-600">L'administrateur approuve la résolution et ferme le ticket.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 bg-primary">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold text-white mb-6">Prêt à améliorer votre système de support client?</h2>
            <p class="text-xl text-mint-light mb-8 max-w-3xl mx-auto">Rejoignez notre plateforme et commencez à centraliser et résoudre efficacement les problèmes de vos clients dès aujourd'hui.</p>
            <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-4">
                @auth
                    <a href="{{ url('/dashboard') }}" class="px-8 py-3 bg-mint text-primary font-semibold rounded-lg hover:bg-mint-light shadow-lg transition duration-300">
                        Accéder au Tableau de Bord
                    </a>
                @else
                    <a href="{{ route('register') }}" class="px-8 py-3 bg-mint text-primary font-semibold rounded-lg hover:bg-mint-light shadow-lg transition duration-300">
                        Démarrer Maintenant
                    </a>
                    <a href="{{ route('login') }}" class="px-8 py-3 border-2 border-mint text-white font-semibold rounded-lg hover:bg-mint hover:text-primary transition duration-300">
                        Connectez-vous
                    </a>
                @endauth
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between">
                <div class="mb-8 md:mb-0">
                    <div class="flex items-center mb-4">
                        <i class="fas fa-ticket-alt text-mint text-2xl mr-2"></i>
                        <span class="font-bold text-2xl">TicketPro</span>
                    </div>
                    <p class="text-gray-400 max-w-md">Une solution complète pour la gestion des tickets de support client et leur résolution efficace.</p>
                </div>
                
                <div class="grid grid-cols-2 md:grid-cols-3 gap-8">
                    <!-- Navigation -->
                    <div>
                        <h3 class="text-lg font-semibold text-mint mb-4">Navigation</h3>
                        <ul class="space-y-2">
                            <li><a href="/" class="text-gray-400 hover:text-mint">Accueil</a></li>
                            @auth
                                <li><a href="{{ url('/dashboard') }}" class="text-gray-400 hover:text-mint">Tableau de Bord</a></li>
                            @else
                                <li><a href="{{ route('login') }}" class="text-gray-400 hover:text-mint">Connexion</a></li>
                                <li><a href="{{ route('register') }}" class="text-gray-400 hover:text-mint">Inscription</a></li>
                            @endauth
                        </ul>
                    </div>
                    
                    <!-- Fonctionnalités -->
                    <div>
                        <h3 class="text-lg font-semibold text-mint mb-4">Fonctionnalités</h3>
                        <ul class="space-y-2">
                            <li><a href="#" class="text-gray-400 hover:text-mint">Gestion de Tickets</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-mint">Assignation</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-mint">Statistiques</a></li>
                        </ul>
                    </div>
                    
                    <!-- Légal -->
                    <div>
                        <h3 class="text-lg font-semibold text-mint mb-4">Légal</h3>
                        <ul class="space-y-2">
                            <li><a href="#" class="text-gray-400 hover:text-mint">Mentions Légales</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-mint">Confidentialité</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-mint">CGU</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="border-t border-gray-700 mt-10 pt-6 flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-400">© {{ date('Y') }} TicketPro. Tous droits réservés.</p>
                <div class="flex space-x-4 mt-4 md:mt-0">
                    <a href="#" class="text-gray-400 hover:text-mint"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="text-gray-400 hover:text-mint"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="text-gray-400 hover:text-mint"><i class="fab fa-linkedin-in"></i></a>
                    <a href="#" class="text-gray-400 hover:text-mint"><i class="fab fa-github"></i></a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Mobile menu toggle
        document.querySelector('.mobile-menu-button').addEventListener('click', function() {
            document.querySelector('.mobile-menu').classList.toggle('hidden');
        });
    </script>
</body>
</html>