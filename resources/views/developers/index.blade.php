@extends('layouts.app')

@section('content')
    <!-- Header & Filters -->
    <div class="bg-white rounded-xl shadow-lg mb-8 p-6">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-2xl font-bold text-primary">Équipe de Développement</h2>
                <p class="text-secondary">Gestion et suivi des développeurs</p>
            </div>
            <a href="{{ route('dashboard') }}" class="bg-mint text-primary px-6 py-2 rounded-lg hover:bg-mint-light transition duration-150 font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                <i class="fas fa-arrow-left mr-2"></i>Retour au Tableau de Bord
            </a>
        </div>

        <!-- Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-gray-50 rounded-lg p-4 text-center">
                <p class="text-sm text-gray-500">Total Développeurs</p>
                <p class="text-2xl font-bold text-primary">{{ $totalDevelopers }}</p>
            </div>
            <div class="bg-gray-50 rounded-lg p-4 text-center">
                <p class="text-sm text-gray-500">Disponibles</p>
                <p class="text-2xl font-bold text-mint">{{ $availableDevelopers }}</p>
            </div>
            <div class="bg-gray-50 rounded-lg p-4 text-center">
                <p class="text-sm text-gray-500">En Mission</p>
                <p class="text-2xl font-bold text-secondary">{{ $busyDevelopers }}</p>
            </div>
            <div class="bg-gray-50 rounded-lg p-4 text-center">
                <p class="text-sm text-gray-500">Taux de Résolution</p>
                <p class="text-2xl font-bold text-green-500">{{ $overallResolutionRate }}%</p>
            </div>
        </div>

        <!-- Filters -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="relative">
                <input type="text" 
                       id="searchInput"
                       placeholder="Rechercher un développeur..." 
                       class="block w-full pl-10 pr-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-mint focus:border-mint">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
            </div>
            <div class="relative">
                <select id="filterStatus" class="block w-full pl-3 pr-10 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-mint focus:border-mint appearance-none">
                    <option value="">Filtrer par disponibilité</option>
                    <option value="available">Disponible</option>
                    <option value="busy">Occupé</option>
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                    <i class="fas fa-chevron-down text-gray-400"></i>
                </div>
            </div>
            <div class="relative">
                <select id="sortBy" class="block w-full pl-3 pr-10 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-mint focus:border-mint appearance-none">
                    <option value="">Trier par</option>
                    <option value="name">Nom</option>
                    <option value="performance">Performance</option>
                    <option value="workload">Charge de travail</option>
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                    <i class="fas fa-chevron-down text-gray-400"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Developers Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($developers as $developer)
            <!-- Developer Card -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden group hover:shadow-xl transition duration-300">
                <div class="p-6">
                    <!-- Header -->
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center space-x-4">
                            <img src="https://ui-avatars.com/api/?name={{ $developer->firstName }}+{{ $developer->lastName }}&background=05BFDB&color=0A4D68" 
                                alt="{{ $developer->firstName }} {{ $developer->lastName }}"
                                class="w-16 h-16 rounded-full border-4 border-mint">
                            <div>
                                <h3 class="text-lg font-semibold text-primary">{{ $developer->firstName }} {{ $developer->lastName }}</h3>
                                <p class="text-secondary">{{ $developer->role }}</p>
                            </div>
                        </div>
                        <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $developer->active_tickets > 0 ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800' }}">
                            {{ $developer->active_tickets > 0 ? 'Occupé' : 'Disponible' }}
                        </span>
                    </div>

                    <!-- Info Grid -->
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div class="text-sm">
                            <p class="text-gray-500">Tickets assignés</p>
                            <p class="font-semibold text-primary">{{ $developer->assigned_tickets }}</p>
                        </div>
                        <div class="text-sm">
                            <p class="text-gray-500">Taux de résolution</p>
                            <p class="font-semibold text-mint">{{ $developer->resolution_rate }}%</p>
                        </div>
                        <div class="text-sm">
                            <p class="text-gray-500">Tickets actifs</p>
                            <p class="font-semibold text-primary">{{ $developer->active_tickets }}</p>
                        </div>
                        <div class="text-sm">
                            <p class="text-gray-500">Temps moyen</p>
                            <p class="font-semibold text-mint">{{ $developer->avg_resolution_time }} jours</p>
                        </div>
                    </div>

                    <!-- Contact -->
                    <div class="space-y-2 mb-4">
                        <div class="flex items-center text-sm text-gray-500">
                            <i class="fas fa-envelope w-5 text-mint"></i>
                            <span>{{ $developer->email }}</span>
                        </div>
                        <div class="flex items-center text-sm text-gray-500">
                            <i class="fas fa-user w-5 text-mint"></i>
                            <span>{{ $developer->username }}</span>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex space-x-3">
                        <a href="{{ route('developers.show', $developer->id) }}" class="flex-1 bg-primary text-white px-4 py-2 rounded-lg hover:bg-secondary transition duration-150 text-center">
                            <i class="fas fa-tasks mr-2"></i>Voir profil
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-3 bg-white rounded-xl shadow-lg p-8 text-center">
                <i class="fas fa-users text-mint text-5xl mb-4"></i>
                <h3 class="text-xl font-bold text-primary mb-2">Aucun développeur trouvé</h3>
                <p class="text-secondary">Il n'y a actuellement aucun développeur enregistré dans le système.</p>
            </div>
        @endforelse
    </div>

    <!-- Simple filtering script - can be enhanced later -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const filterStatus = document.getElementById('filterStatus');
            const sortBy = document.getElementById('sortBy');
            const developerCards = document.querySelectorAll('.grid > div');
            
            function filterDevelopers() {
                const searchTerm = searchInput.value.toLowerCase();
                const statusFilter = filterStatus.value;
                
                developerCards.forEach(card => {
                    const name = card.querySelector('h3')?.textContent.toLowerCase() || '';
                    const isAvailable = card.querySelector('.rounded-full').textContent.trim() === 'Disponible';
                    
                    let showCard = name.includes(searchTerm);
                    
                    if (statusFilter === 'available' && !isAvailable) {
                        showCard = false;
                    } else if (statusFilter === 'busy' && isAvailable) {
                        showCard = false;
                    }
                    
                    card.style.display = showCard ? '' : 'none';
                });
            }
            
            if (searchInput) searchInput.addEventListener('input', filterDevelopers);
            if (filterStatus) filterStatus.addEventListener('change', filterDevelopers);
        });
    </script>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endpush