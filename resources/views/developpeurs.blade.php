@extends('layouts.app')

@section('content')
    <!-- Header & Filters -->
    <div class="bg-white rounded-xl shadow-lg mb-8 p-6">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-2xl font-bold text-primary">Équipe de Développement</h2>
                <p class="text-secondary">Gestion et suivi des développeurs</p>
            </div>
            <button class="bg-mint text-primary px-6 py-2 rounded-lg hover:bg-mint-light transition duration-150 font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                <i class="fas fa-user-plus mr-2"></i>Ajouter un Développeur
            </button>
        </div>

        <!-- Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-gray-50 rounded-lg p-4 text-center">
                <p class="text-sm text-gray-500">Total Développeurs</p>
                <p class="text-2xl font-bold text-primary">12</p>
            </div>
            <div class="bg-gray-50 rounded-lg p-4 text-center">
                <p class="text-sm text-gray-500">Disponibles</p>
                <p class="text-2xl font-bold text-mint">8</p>
            </div>
            <div class="bg-gray-50 rounded-lg p-4 text-center">
                <p class="text-sm text-gray-500">En Mission</p>
                <p class="text-2xl font-bold text-secondary">4</p>
            </div>
            <div class="bg-gray-50 rounded-lg p-4 text-center">
                <p class="text-sm text-gray-500">Taux de Résolution</p>
                <p class="text-2xl font-bold text-green-500">85%</p>
            </div>
        </div>

        <!-- Filters -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="relative">
                <input type="text" 
                       placeholder="Rechercher un développeur..." 
                       class="block w-full pl-10 pr-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-mint focus:border-mint">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
            </div>
            <div class="relative">
                <select class="block w-full pl-3 pr-10 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-mint focus:border-mint appearance-none">
                    <option value="">Filtrer par spécialité</option>
                    <option value="frontend">Frontend</option>
                    <option value="backend">Backend</option>
                    <option value="fullstack">Full Stack</option>
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                    <i class="fas fa-chevron-down text-gray-400"></i>
                </div>
            </div>
            <div class="relative">
                <select class="block w-full pl-3 pr-10 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-mint focus:border-mint appearance-none">
                    <option value="">Trier par disponibilité</option>
                    <option value="available">Disponible</option>
                    <option value="busy">Occupé</option>
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                    <i class="fas fa-chevron-down text-gray-400"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Developers Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Developer Card 1 -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden group hover:shadow-xl transition duration-300">
            <div class="p-6">
                <!-- Header -->
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center space-x-4">
                        <img src="https://ui-avatars.com/api/?name=John+Doe&background=05BFDB&color=0A4D68" 
                             alt="John Doe"
                             class="w-16 h-16 rounded-full border-4 border-mint">
                        <div>
                            <h3 class="text-lg font-semibold text-primary">John Doe</h3>
                            <p class="text-secondary">Full Stack Developer</p>
                        </div>
                    </div>
                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                        Disponible
                    </span>
                </div>

                <!-- Info Grid -->
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div class="text-sm">
                        <p class="text-gray-500">Tickets assignés</p>
                        <p class="font-semibold text-primary">8</p>
                    </div>
                    <div class="text-sm">
                        <p class="text-gray-500">Taux de résolution</p>
                        <p class="font-semibold text-mint">92%</p>
                    </div>
                    <div class="text-sm">
                        <p class="text-gray-500">Temps moyen</p>
                        <p class="font-semibold text-primary">2.5 jours</p>
                    </div>
                    <div class="text-sm">
                        <p class="text-gray-500">Satisfaction</p>
                        <p class="font-semibold text-mint">4.8/5</p>
                    </div>
                </div>

                <!-- Skills -->
                <div class="mb-4">
                    <p class="text-sm font-semibold text-gray-500 mb-2">Compétences</p>
                    <div class="flex flex-wrap gap-2">
                        <span class="px-3 py-1 bg-mint bg-opacity-10 text-secondary rounded-full text-xs">React</span>
                        <span class="px-3 py-1 bg-mint bg-opacity-10 text-secondary rounded-full text-xs">Node.js</span>
                        <span class="px-3 py-1 bg-mint bg-opacity-10 text-secondary rounded-full text-xs">Python</span>
                        <span class="px-3 py-1 bg-mint bg-opacity-10 text-secondary rounded-full text-xs">MongoDB</span>
                    </div>
                </div>

                <!-- Contact -->
                <div class="space-y-2 mb-4">
                    <div class="flex items-center text-sm text-gray-500">
                        <i class="fas fa-envelope w-5 text-mint"></i>
                        <span>john.doe@ticketflow.com</span>
                    </div>
                    <div class="flex items-center text-sm text-gray-500">
                        <i class="fas fa-phone w-5 text-mint"></i>
                        <span>+1 234 567 890</span>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex space-x-3">
                    <button class="flex-1 bg-primary text-white px-4 py-2 rounded-lg hover:bg-secondary transition duration-150">
                        <i class="fas fa-tasks mr-2"></i>Voir les tickets
                    </button>
                    <button class="flex-1 bg-mint text-primary px-4 py-2 rounded-lg hover:bg-mint-light transition duration-150">
                        <i class="fas fa-user-edit mr-2"></i>Éditer
                    </button>
                </div>
            </div>
        </div>

        <!-- Developer Card 2 -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden group hover:shadow-xl transition duration-300">
            <!-- Similar structure as Card 1, with different data -->
        </div>

        <!-- Developer Card 3 -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden group hover:shadow-xl transition duration-300">
            <!-- Similar structure as Card 1, with different data -->
        </div>
    </div>
@endsection