@extends('layouts.app')

@section('content')
    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h2 class="text-3xl font-bold text-primary">Tableau de bord</h2>
            <p class="text-secondary">Vue d'ensemble des tickets et affectations</p>
        </div>
        <button
            class="bg-mint text-primary px-6 py-2 rounded-lg hover:bg-mint-light transition duration-150 font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
            <i class="fas fa-plus mr-2"></i>Nouveau Ticket
        </button>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition duration-300 border-b-4 border-mint">
            <div class="flex items-center">
                <div class="p-3 bg-primary rounded-lg">
                    <i class="fas fa-ticket-alt text-mint text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-gray-500 text-sm">Total Tickets</h3>
                    <p class="text-2xl font-bold text-primary">248</p>
                    <span class="text-xs text-mint">+12% ce mois</span>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition duration-300 border-b-4 border-mint">
            <div class="flex items-center">
                <div class="p-3 bg-primary rounded-lg">
                    <i class="fas fa-check text-mint text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-gray-500 text-sm">Tickets Résolus</h3>
                    <p class="text-2xl font-bold text-primary">156</p>
                    <span class="text-xs text-mint">+8% ce mois</span>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition duration-300 border-b-4 border-mint">
            <div class="flex items-center">
                <div class="p-3 bg-primary rounded-lg">
                    <i class="fas fa-clock text-mint text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-gray-500 text-sm">En Attente</h3>
                    <p class="text-2xl font-bold text-primary">54</p>
                    <span class="text-xs text-mint">-5% ce mois</span>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition duration-300 border-b-4 border-mint">
            <div class="flex items-center">
                <div class="p-3 bg-primary rounded-lg">
                    <i class="fas fa-exclamation-circle text-mint text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-gray-500 text-sm">Urgents</h3>
                    <p class="text-2xl font-bold text-primary">38</p>
                    <span class="text-xs text-mint">-2% ce mois</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Tickets Table -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="p-6 border-b border-gray-100">
            <h3 class="text-xl font-semibold text-primary">Tickets Récents</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-primary uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-primary uppercase tracking-wider">Titre</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-primary uppercase tracking-wider">Priorité
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-primary uppercase tracking-wider">Statut
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-primary uppercase tracking-wider">
                            Développeur</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-primary uppercase tracking-wider">Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <tr class="hover:bg-gray-50 transition duration-150">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-primary font-medium">#1234</td>
                        <td class="px-6 py-4 text-sm text-gray-700">Bug dans le module de paiement</td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Urgent</span>
                        </td>
                        <td class="px-6 py-4">
                            <span
                                class="px-3 py-1 text-xs font-semibold rounded-full bg-mint bg-opacity-20 text-secondary">En
                                cours</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <img src="https://ui-avatars.com/api/?name=John+Doe&background=05BFDB&color=0A4D68"
                                    alt="Developer" class="w-8 h-8 rounded-full border-2 border-mint">
                                <span class="ml-2 text-sm text-gray-700">John Doe</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex space-x-3">
                                <button class="text-secondary hover:text-primary transition duration-150">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="text-mint hover:text-primary transition duration-150">
                                    <i class="fas fa-check-circle"></i>
                                </button>
                                <button class="text-red-500 hover:text-red-700 transition duration-150">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <!-- Add more rows as needed -->
                </tbody>
            </table>
        </div>
        <!-- Pagination -->
        <div class="p-4 border-t border-gray-100">
            <div class="flex items-center justify-between">
                <p class="text-sm text-gray-600">
                    Affichage 1-10 sur 248 tickets
                </p>
                <div class="flex space-x-2">
                    <button
                        class="px-3 py-1 rounded-md bg-gray-100 text-primary hover:bg-mint-light transition duration-150">
                        Précédent
                    </button>
                    <button class="px-3 py-1 rounded-md bg-primary text-white">1</button>
                    <button
                        class="px-3 py-1 rounded-md bg-gray-100 text-primary hover:bg-mint-light transition duration-150">2</button>
                    <button
                        class="px-3 py-1 rounded-md bg-gray-100 text-primary hover:bg-mint-light transition duration-150">3</button>
                    <button
                        class="px-3 py-1 rounded-md bg-gray-100 text-primary hover:bg-mint-light transition duration-150">
                        Suivant
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
