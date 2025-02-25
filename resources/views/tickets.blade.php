@extends('layouts.app')

@section('content')
    <!-- Advanced Filter Section -->
    <div class="bg-white rounded-xl shadow-lg mb-8 p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-primary">Gestion des Tickets</h2>
            <button class="bg-mint text-primary px-6 py-2 rounded-lg hover:bg-mint-light transition duration-150 font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                <i class="fas fa-plus mr-2"></i>Nouveau Ticket
            </button>
        </div>

        <!-- Filter Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Search -->
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
                <input type="text" 
                       placeholder="Rechercher un ticket..." 
                       class="block w-full pl-10 pr-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-mint focus:border-mint">
            </div>

            <!-- Status Filter -->
            <div class="relative">
                <select class="block w-full pl-3 pr-10 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-mint focus:border-mint appearance-none">
                    <option value="">Tous les statuts</option>
                    <option value="new">Nouveau</option>
                    <option value="in_progress">En cours</option>
                    <option value="resolved">Résolu</option>
                    <option value="closed">Fermé</option>
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                    <i class="fas fa-chevron-down text-gray-400"></i>
                </div>
            </div>

            <!-- Priority Filter -->
            <div class="relative">
                <select class="block w-full pl-3 pr-10 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-mint focus:border-mint appearance-none">
                    <option value="">Toutes les priorités</option>
                    <option value="urgent">Urgent</option>
                    <option value="high">Haute</option>
                    <option value="medium">Moyenne</option>
                    <option value="low">Basse</option>
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                    <i class="fas fa-chevron-down text-gray-400"></i>
                </div>
            </div>

            <!-- Assigned To Filter -->
            <div class="relative">
                <select class="block w-full pl-3 pr-10 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-mint focus:border-mint appearance-none">
                    <option value="">Tous les développeurs</option>
                    <option value="unassigned">Non assigné</option>
                    <option value="john">John Doe</option>
                    <option value="jane">Jane Smith</option>
                    <option value="alex">Alex Johnson</option>
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                    <i class="fas fa-chevron-down text-gray-400"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Tickets List -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <!-- Quick Stats -->
        <div class="grid grid-cols-4 divide-x divide-gray-100 border-b border-gray-100">
            <div class="p-4 text-center">
                <p class="text-sm text-gray-500">Total</p>
                <p class="text-2xl font-bold text-primary">248</p>
            </div>
            <div class="p-4 text-center">
                <p class="text-sm text-gray-500">En attente</p>
                <p class="text-2xl font-bold text-mint">54</p>
            </div>
            <div class="p-4 text-center">
                <p class="text-sm text-gray-500">En cours</p>
                <p class="text-2xl font-bold text-secondary">125</p>
            </div>
            <div class="p-4 text-center">
                <p class="text-sm text-gray-500">Résolus</p>
                <p class="text-2xl font-bold text-green-500">69</p>
            </div>
        </div>

        <!-- Table -->
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-primary uppercase tracking-wider">
                        <div class="flex items-center">
                            ID
                            <i class="fas fa-sort ml-1 text-mint"></i>
                        </div>
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-primary uppercase tracking-wider">
                        <div class="flex items-center">
                            Titre & Description
                            <i class="fas fa-sort ml-1 text-mint"></i>
                        </div>
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-primary uppercase tracking-wider">
                        <div class="flex items-center">
                            Priorité
                            <i class="fas fa-sort ml-1 text-mint"></i>
                        </div>
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-primary uppercase tracking-wider">Statut</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-primary uppercase tracking-wider">Assigné à</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-primary uppercase tracking-wider">
                        <div class="flex items-center">
                            Date
                            <i class="fas fa-sort ml-1 text-mint"></i>
                        </div>
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-primary uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <!-- Ticket Row 1 -->
                <tr class="hover:bg-gray-50 transition duration-150">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="text-sm font-medium text-primary">#1234</span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-900 font-medium">Bug dans le module de paiement</div>
                        <div class="text-sm text-gray-500 truncate w-64">Le système affiche une erreur lors de la validation...</div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Urgent</span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-mint bg-opacity-20 text-secondary">En cours</span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <img src="https://ui-avatars.com/api/?name=John+Doe&background=05BFDB&color=0A4D68" 
                                 class="w-8 h-8 rounded-full border-2 border-mint">
                            <span class="ml-2 text-sm text-gray-700">John Doe</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-500">24 Fév, 2025</div>
                        <div class="text-xs text-gray-400">16:39:47</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex space-x-3">
                            <button class="text-mint hover:text-primary transition duration-150" 
                                    title="Éditer">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="text-secondary hover:text-primary transition duration-150"
                                    title="Voir les détails">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="text-red-500 hover:text-red-700 transition duration-150"
                                    title="Supprimer">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>

                <!-- More ticket rows can be added here -->

            </tbody>
        </table>

        <!-- Pagination -->
        <div class="bg-gray-50 px-6 py-4 border-t border-gray-100">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <span class="text-sm text-gray-700">
                        Affichage de <span class="font-medium">1</span> à <span class="font-medium">10</span> sur <span class="font-medium">248</span> tickets
                    </span>
                </div>
                <div class="flex space-x-2">
                    <button class="px-3 py-1 rounded-md bg-gray-100 text-primary hover:bg-mint-light transition duration-150">
                        <i class="fas fa-chevron-left mr-1"></i>
                        Précédent
                    </button>
                    <button class="px-3 py-1 rounded-md bg-primary text-white">1</button>
                    <button class="px-3 py-1 rounded-md hover:bg-mint-light transition duration-150">2</button>
                    <button class="px-3 py-1 rounded-md hover:bg-mint-light transition duration-150">3</button>
                    <span class="px-3 py-1">...</span>
                    <button class="px-3 py-1 rounded-md hover:bg-mint-light transition duration-150">10</button>
                    <button class="px-3 py-1 rounded-md bg-gray-100 text-primary hover:bg-mint-light transition duration-150">
                        Suivant
                        <i class="fas fa-chevron-right ml-1"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection