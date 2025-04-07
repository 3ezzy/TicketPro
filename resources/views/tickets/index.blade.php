@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto p-6 lg:p-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold text-gray-900">Tickets</h1>
            
            <!-- Only clients can create tickets -->
            @if(auth()->user()->role === 'client')
            <a href="{{ route('tickets.create') }}" class="bg-mint text-primary px-6 py-2 rounded-lg hover:bg-mint-light transition duration-150 font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                <i class="fas fa-plus mr-2"></i>Nouveau Ticket
            </a>
            @endif
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
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
                            <option value="pending_approval" {{ request('status') == 'pending_approval' ? 'selected' : '' }}>En attente d'approbation
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

                    <!-- Software Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Logiciel</label>
                        <select name="software_id"
                            class="block w-full pl-3 pr-10 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-mint focus:border-mint appearance-none">
                            <option value="">Tous les logiciels</option>
                            @foreach(\App\Models\Software::all() as $software)
                                <option value="{{ $software->id }}" {{ request('software_id') == $software->id ? 'selected' : '' }}>
                                    {{ $software->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Additional filter row -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <!-- OS Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Système d'exploitation</label>
                        <select name="os"
                            class="block w-full pl-3 pr-10 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-mint focus:border-mint appearance-none">
                            <option value="">Tous les OS</option>
                            <option value="windows" {{ request('os') == 'windows' ? 'selected' : '' }}>Windows</option>
                            <option value="macos" {{ request('os') == 'macos' ? 'selected' : '' }}>macOS</option>
                            <option value="linux" {{ request('os') == 'linux' ? 'selected' : '' }}>Linux</option>
                            <option value="ios" {{ request('os') == 'ios' ? 'selected' : '' }}>iOS</option>
                            <option value="android" {{ request('os') == 'android' ? 'selected' : '' }}>Android</option>
                        </select>
                    </div>

                    <!-- Only show assigned filter for admins -->
                    @if(auth()->user()->role === 'admin')
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Assignation</label>
                        <select name="assigned"
                            class="block w-full pl-3 pr-10 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-mint focus:border-mint appearance-none">
                            <option value="">Tous les tickets</option>
                            <option value="assigned" {{ request('assigned') == 'assigned' ? 'selected' : '' }}>Assignés</option>
                            <option value="unassigned" {{ request('assigned') == 'unassigned' ? 'selected' : '' }}>Non assignés</option>
                        </select>
                    </div>
                    
                    <!-- Developer filter for admins -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Développeur</label>
                        <select name="developer_id"
                            class="block w-full pl-3 pr-10 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-mint focus:border-mint appearance-none">
                            <option value="">Tous les développeurs</option>
                            @foreach(\App\Models\User::where('role', 'developer')->get() as $developer)
                                <option value="{{ $developer->id }}" {{ request('developer_id') == $developer->id ? 'selected' : '' }}>
                                    {{ $developer->firstName }} {{ $developer->lastName }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @endif
                </div>

                <!-- Filter Actions -->
                <div class="flex justify-end space-x-3">
                    <button type="submit"
                        class="bg-mint text-primary px-6 py-2 rounded-lg hover:bg-mint-light transition duration-150 font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                        <i class="fas fa-filter mr-2"></i>
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
                                Statut</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Client</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Date</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($tickets as $ticket)
                            <tr class="hover:bg-gray-50 transition duration-150">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    #{{ $ticket->id }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <a href="{{ route('tickets.show', $ticket->id) }}" class="text-mint hover:text-secondary">
                                        {{ $ticket->title }}
                                    </a>
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
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($ticket->status == 'open')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                            Ouvert
                                        </span>
                                    @elseif($ticket->status == 'in_progress')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-mint bg-opacity-20 text-secondary">
                                            En cours
                                        </span>
                                    @elseif($ticket->status == 'pending_approval')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            En attente
                                        </span>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Résolu
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-8 w-8">
                                            <img class="h-8 w-8 rounded-full border-2 border-mint"
                                                src="https://ui-avatars.com/api/?name={{ $ticket->user->firstName }}+{{ $ticket->user->lastName }}&background=05BFDB&color=0A4D68"
                                                alt="{{ $ticket->user->firstName }} {{ $ticket->user->lastName }}">
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-gray-900">
                                                {{ $ticket->user->firstName }} {{ $ticket->user->lastName }}
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $ticket->created_at->format('Y-m-d H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end space-x-2">
                                        <a href="{{ route('tickets.show', $ticket->id) }}" class="text-mint hover:text-secondary" title="Voir détails">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        
                                        @if(auth()->user()->role === 'client' && auth()->id() === $ticket->user_id)
                                        <!-- Edit button - only for clients who created the ticket -->
                                        <a href="{{ route('tickets.edit', $ticket->id) }}" class="text-mint hover:text-secondary" title="Modifier">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @endif
                                        
                                        @if(auth()->user()->role === 'admin' && $ticket->status != 'closed')
                                        <!-- Assign button - only for admins and non-closed tickets -->
                                        <a href="{{ route('assignments.create', $ticket->id) }}" class="text-blue-600 hover:text-blue-800" title="Assigner">
                                            <i class="fas fa-user-check"></i>
                                        </a>
                                        @endif
                                        
                                        @if(auth()->user()->role === 'admin' || (auth()->user()->role === 'client' && auth()->id() === $ticket->user_id))
                                        <!-- Delete button - for admins or clients who created the ticket -->
                                        <form action="{{ route('tickets.destroy', $ticket->id) }}" method="POST"
                                            class="inline"
                                            onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce ticket?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800" title="Supprimer">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                        @endif
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