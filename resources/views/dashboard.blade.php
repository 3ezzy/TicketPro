@extends('layouts.app')

@section('content')
    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h2 class="text-3xl font-bold text-primary">Tableau de bord</h2>
            <p class="text-secondary">Vue d'ensemble des tickets et affectations</p>
        </div>
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
                    <p class="text-2xl font-bold text-primary">{{ $totalTickets ?? 'N/A' }}</p>
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
                    <p class="text-2xl font-bold text-primary">{{ $resolvedTickets ?? 'N/A' }}</p>
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
                    <p class="text-2xl font-bold text-primary">{{ $pendingTickets ?? 'N/A' }}</p>
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
                    <p class="text-2xl font-bold text-primary">{{ $urgentTickets ?? 'N/A' }}</p>
                    <span class="text-xs text-mint">-2% ce mois</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Client Tickets Table -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="p-6 border-b border-gray-100">
            <h3 class="text-xl font-semibold text-primary">Tickets Créés par Clients</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-primary uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-primary uppercase tracking-wider">Titre</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-primary uppercase tracking-wider">Client</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-primary uppercase tracking-wider">Logiciel</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-primary uppercase tracking-wider">OS</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-primary uppercase tracking-wider">Priorité</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-primary uppercase tracking-wider">Statut</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-primary uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($clientTickets ?? [] as $ticket)
                    <tr class="hover:bg-gray-50 transition duration-150">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-primary font-medium">#{{ $ticket->id }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $ticket->title }}</td>
                        <td class="px-6 py-4 text-sm">
                            <div class="flex items-center">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($ticket->user->name) }}&background=05BFDB&color=0A4D68"
                                    alt="Client" class="w-8 h-8 rounded-full border-2 border-mint">
                                <span class="ml-2 text-sm text-gray-700">{{ $ticket->user->name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $ticket->software->name ?? 'N/A' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $ticket->os }}</td>
                        <td class="px-6 py-4">
                            @if($ticket->priority == 'high')
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Urgent</span>
                            @elseif($ticket->priority == 'medium')
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-orange-100 text-orange-800">Élevée</span>
                            @else
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Faible</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($ticket->status == 'open')
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">Ouvert</span>
                            @elseif($ticket->status == 'in_progress')
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-mint bg-opacity-20 text-secondary">En cours</span>
                            @elseif($ticket->status == 'closed')
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Résolu</span>
                            @else
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">{{ $ticket->status }}</span>
                            @endif
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
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-10 text-center text-gray-500">
                            <i class="fas fa-ticket-alt text-mint text-xl mb-3 block"></i>
                            <p>Aucun ticket client trouvé</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection