@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto p-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-primary">Tickets</h1>
                <p class="text-secondary mt-2">Gérez vos tickets de support</p>
            </div>
            <a href="{{ route('tickets.create') }}" <button
                class="bg-mint text-primary px-6 py-2 rounded-lg hover:bg-mint-light transition duration-150 font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                <i class="fas fa-plus mr-2"></i>Nouveau Ticket
                </button>
            </a>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <!-- Filters Section -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
            <form action="{{ route('tickets.index') }}" method="GET" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- Search Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Rechercher</label>
                        <div class="relative">
                            <input type="text" name="search" value="{{ request('search') }}"
                                class="block w-full pl-10 pr-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-mint focus:border-mint"
                                placeholder="Rechercher un ticket...">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Status Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Statut</label>
                        <select name="status"
                            class="block w-full pl-3 pr-10 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-mint focus:border-mint appearance-none">
                            <option value="">Tous les statuts</option>
                            <option value="open" {{ request('status') == 'open' ? 'selected' : '' }}>Ouvert</option>
                            <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>En cours
                            </option>
                            <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Fermé</option>
                        </select>
                    </div>

                    <!-- Priority Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Priorité</label>
                        <select name="priority"
                            class="block w-full pl-3 pr-10 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-mint focus:border-mint appearance-none">
                            <option value="">Toutes les priorités</option>
                            <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>Basse</option>
                            <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>Moyenne</option>
                            <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>Haute</option>
                        </select>
                    </div>

                    <!-- Assigned To Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Assigné à</label>
                        <select name="assigned_to"
                            class="block w-full pl-3 pr-10 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-mint focus:border-mint appearance-none">
                            <option value="">Tous les utilisateurs</option>
                            @foreach ($users ?? [] as $user)
                                <option value="{{ $user->id }}"
                                    {{ request('assigned_to') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Filter Actions -->
                <div class="flex justify-end space-x-3">
                    <button type="submit"
                        class="bg-mint text-primary px-6 py-2 rounded-lg hover:bg-mint-light transition duration-150 font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                        <i class="fas fa-filter"></i>
                        <span>Appliquer les filtres</span>
                    </button>
                    <a href="{{ route('tickets.index') }}"
                        class="border border-gray-200 hover:bg-gray-50 px-4 py-2 rounded-lg transition duration-150">
                        Réinitialiser
                    </a>
                </div>
            </form>
        </div>

        <!-- Tickets Table -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <!-- [Previous table header code remains the same] -->
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Titre
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Priorité</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">OS
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Logiciel</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Créé
                                Par</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($tickets as $ticket)
                            <!-- [Previous table row code remains the same] -->
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    #{{ $ticket->id }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $ticket->title }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    {{ $ticket->priority === 'high'
                                        ? 'bg-red-100 text-red-800'
                                        : ($ticket->priority === 'medium'
                                            ? 'bg-yellow-100 text-yellow-800'
                                            : 'bg-green-100 text-green-800') }}">
                                        {{ ucfirst($ticket->priority) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ ucfirst($ticket->os) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $ticket->software->name }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <img src="https://ui-avatars.com/api/?name={{ $ticket->user->lastName }}+{{ $ticket->user->firstName }}&background=05BFDB&color=0A4D68"
                                            alt="Developer" class="w-8 h-8 rounded-full border-2 border-mint">
                                        <span class="ml-2 text-sm text-gray-700">{{ $ticket->user->lastName }}
                                            {{ $ticket->user->firstName }}</span>
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $ticket->created_at->format('Y-m-d H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end space-x-2">
                                        <a href="{{ route('tickets.show', $ticket->id) }}"
                                            class="text-mint hover:text-secondary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('tickets.edit', $ticket->id) }}"
                                            class="text-mint hover:text-secondary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('assignments.create', $ticket->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="text-blue-600 hover:text-blue-800">
                                                <i class="fas fa-user-check"></i> <!-- Icône d'assignation -->
                                            </button>
                                        </form>
                                        <form action="{{ route('tickets.destroy', $ticket->id) }}" method="POST"
                                            class="inline"
                                            onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce ticket?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                    Aucun ticket trouvé.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                {{ $tickets->links() }}
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endpush

@push('scripts')
    <script src="https://cdn.tailwindcss.com"></script>
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
@endpush
