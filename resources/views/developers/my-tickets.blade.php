@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto p-6">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-primary">Mes Tickets Assignés</h1>
                <p class="text-secondary mt-2">Gérez vos tickets de support actifs</p>
            </div>
            <a href="{{ route('dashboard') }}" class="bg-mint text-primary px-6 py-2 rounded-lg hover:bg-mint-light transition duration-150 font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                <i class="fas fa-arrow-left mr-2"></i>Retour au Tableau de Bord
            </a>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition duration-300 border-b-4 border-mint">
                <div class="flex items-center">
                    <div class="p-3 bg-primary rounded-lg">
                        <i class="fas fa-ticket-alt text-mint text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-gray-500 text-sm">Total Assigné</h3>
                        <p class="text-2xl font-bold text-primary">{{ $assignments->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition duration-300 border-b-4 border-mint">
                <div class="flex items-center">
                    <div class="p-3 bg-primary rounded-lg">
                        <i class="fas fa-spinner text-mint text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-gray-500 text-sm">En Cours</h3>
                        <p class="text-2xl font-bold text-primary">
                            {{ $assignments->filter(function($a) { return $a->ticket->status == 'in_progress'; })->count() }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition duration-300 border-b-4 border-mint">
                <div class="flex items-center">
                    <div class="p-3 bg-primary rounded-lg">
                        <i class="fas fa-hourglass-half text-mint text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-gray-500 text-sm">En Attente</h3>
                        <p class="text-2xl font-bold text-primary">
                            {{ $assignments->filter(function($a) { return $a->ticket->status == 'pending_approval'; })->count() }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition duration-300 border-b-4 border-mint">
                <div class="flex items-center">
                    <div class="p-3 bg-primary rounded-lg">
                        <i class="fas fa-check-circle text-mint text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-gray-500 text-sm">Résolus</h3>
                        <p class="text-2xl font-bold text-primary">
                            {{ $assignments->filter(function($a) { return $a->ticket->status == 'closed'; })->count() }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                <p>{{ session('error') }}</p>
            </div>
        @endif

        <!-- Active Tickets Section -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-8">
            <div class="p-6 border-b border-gray-100">
                <h3 class="text-xl font-semibold text-primary">Tickets Actifs</h3>
            </div>

            <div class="overflow-x-auto">
                @php
                    $activeAssignments = $assignments->filter(function($a) { 
                        return $a->ticket->status == 'in_progress'; 
                    });
                @endphp
                
                @if($activeAssignments->count() > 0)
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-primary uppercase tracking-wider">ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-primary uppercase tracking-wider">Titre</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-primary uppercase tracking-wider">Client</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-primary uppercase tracking-wider">Priorité</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-primary uppercase tracking-wider">Date d'assignation</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-primary uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($activeAssignments as $assignment)
                                <tr class="hover:bg-gray-50 transition duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-primary font-medium">#{{ $assignment->ticket->id }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-700">
                                        <a href="{{ route('tickets.show', $assignment->ticket->id) }}" class="text-mint hover:text-secondary">
                                            {{ $assignment->ticket->title }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 text-sm">
                                        <div class="flex items-center">
                                            <img src="https://ui-avatars.com/api/?name={{ $assignment->ticket->user->firstName }}+{{ $assignment->ticket->user->lastName }}&background=05BFDB&color=0A4D68"
                                                alt="Client" class="w-8 h-8 rounded-full border-2 border-mint">
                                            <span class="ml-2 text-sm text-gray-700">{{ $assignment->ticket->user->firstName }} {{ $assignment->ticket->user->lastName }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($assignment->ticket->priority == 'high')
                                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Urgent</span>
                                        @elseif($assignment->ticket->priority == 'medium')
                                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-orange-100 text-orange-800">Moyen</span>
                                        @else
                                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Faible</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $assignment->assigned_at ? $assignment->assigned_at->format('Y-m-d H:i') : 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end space-x-2">
                                            <a href="{{ route('tickets.show', $assignment->ticket->id) }}" class="text-mint hover:text-secondary" title="Voir détails">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <button 
                                                type="button" 
                                                class="text-green-600 hover:text-green-800" 
                                                onclick="openResolutionModal('{{ $assignment->ticket->id }}', '{{ addslashes($assignment->ticket->title) }}')"
                                                title="Marquer comme résolu">
                                                <i class="fas fa-check-circle"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="p-6 text-center">
                        <i class="fas fa-clipboard-check text-mint text-xl mb-3 block"></i>
                        <p class="text-gray-500">Félicitations ! Vous n'avez aucun ticket actif pour le moment.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Pending Approval Tickets Section -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-8">
            <div class="p-6 border-b border-gray-100">
                <h3 class="text-xl font-semibold text-primary">Tickets En Attente d'Approbation</h3>
            </div>

            <div class="overflow-x-auto">
                @php
                    $pendingAssignments = $assignments->filter(function($a) { 
                        return $a->ticket->status == 'pending_approval'; 
                    });
                @endphp
                
                @if($pendingAssignments->count() > 0)
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-primary uppercase tracking-wider">ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-primary uppercase tracking-wider">Titre</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-primary uppercase tracking-wider">Client</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-primary uppercase tracking-wider">Priorité</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-primary uppercase tracking-wider">Soumis le</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-primary uppercase tracking-wider">Notes de résolution</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-primary uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($pendingAssignments as $assignment)
                                <tr class="hover:bg-gray-50 transition duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-primary font-medium">#{{ $assignment->ticket->id }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-700">
                                        <a href="{{ route('tickets.show', $assignment->ticket->id) }}" class="text-mint hover:text-secondary">
                                            {{ $assignment->ticket->title }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 text-sm">
                                        <div class="flex items-center">
                                            <img src="https://ui-avatars.com/api/?name={{ $assignment->ticket->user->firstName }}+{{ $assignment->ticket->user->lastName }}&background=05BFDB&color=0A4D68"
                                                alt="Client" class="w-8 h-8 rounded-full border-2 border-mint">
                                            <span class="ml-2 text-sm text-gray-700">{{ $assignment->ticket->user->firstName }} {{ $assignment->ticket->user->lastName }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($assignment->ticket->priority == 'high')
                                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Urgent</span>
                                        @elseif($assignment->ticket->priority == 'medium')
                                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-orange-100 text-orange-800">Moyen</span>
                                        @else
                                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Faible</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ isset($ticketResolutions[$assignment->ticket_id]) ? $ticketResolutions[$assignment->ticket_id]->resolved_at->format('Y-m-d H:i') : 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-700">
                                        {{ isset($ticketResolutions[$assignment->ticket_id]) ? Str::limit($ticketResolutions[$assignment->ticket_id]->resolution_notes, 50) : 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            <i class="fas fa-clock mr-1"></i> En attente d'approbation
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="p-6 text-center">
                        <i class="fas fa-hourglass text-mint text-xl mb-3 block"></i>
                        <p class="text-gray-500">Vous n'avez aucun ticket en attente d'approbation.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Resolved Tickets Section -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="p-6 border-b border-gray-100">
                <h3 class="text-xl font-semibold text-primary">Tickets Résolus</h3>
            </div>

            <div class="overflow-x-auto">
                @php
                    $resolvedAssignments = $assignments->filter(function($a) { 
                        return $a->ticket->status == 'closed'; 
                    });
                @endphp
                
                @if($resolvedAssignments->count() > 0)
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-primary uppercase tracking-wider">ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-primary uppercase tracking-wider">Titre</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-primary uppercase tracking-wider">Client</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-primary uppercase tracking-wider">Priorité</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-primary uppercase tracking-wider">Date de résolution</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($resolvedAssignments as $assignment)
                                <tr class="hover:bg-gray-50 transition duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-primary font-medium">#{{ $assignment->ticket->id }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-700">
                                        <a href="{{ route('tickets.show', $assignment->ticket->id) }}" class="text-mint hover:text-secondary">
                                            {{ $assignment->ticket->title }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 text-sm">
                                        <div class="flex items-center">
                                            <img src="https://ui-avatars.com/api/?name={{ $assignment->ticket->user->firstName }}+{{ $assignment->ticket->user->lastName }}&background=05BFDB&color=0A4D68"
                                                alt="Client" class="w-8 h-8 rounded-full border-2 border-mint">
                                            <span class="ml-2 text-sm text-gray-700">{{ $assignment->ticket->user->firstName }} {{ $assignment->ticket->user->lastName }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($assignment->ticket->priority == 'high')
                                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Urgent</span>
                                        @elseif($assignment->ticket->priority == 'medium')
                                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-orange-100 text-orange-800">Moyen</span>
                                        @else
                                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Faible</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $assignment->ticket->updated_at->format('Y-m-d H:i') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="p-6 text-center">
                        <i class="fas fa-check-circle text-mint text-xl mb-3 block"></i>
                        <p class="text-gray-500">Vous n'avez pas encore de tickets résolus.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Resolution Modal -->
    <div id="resolutionModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg w-full max-w-md p-6 relative">
            <button type="button" onclick="closeResolutionModal()" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700">
                <i class="fas fa-times"></i>
            </button>
            
            <h3 class="text-xl font-bold text-primary mb-4">Marquer le ticket comme résolu</h3>
            <p class="text-gray-600 mb-4" id="modalTicketTitle"></p>
            
            <form id="resolutionForm" action="" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="status" value="pending_approval">
                
                <div class="mb-4">
                    <label for="resolution_notes" class="block text-sm font-medium text-gray-700 mb-2">
                        Notes de résolution <span class="text-red-500">*</span>
                    </label>
                    <textarea 
                        name="resolution_notes" 
                        id="resolution_notes" 
                        rows="4" 
                        required
                        placeholder="Décrivez comment vous avez résolu ce problème..."
                        class="block w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-mint focus:border-mint"></textarea>
                </div>
                
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeResolutionModal()" class="px-4 py-2 border border-gray-200 rounded-lg hover:bg-gray-50">
                        Annuler
                    </button>
                    <button type="submit" class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-secondary">
                        Soumettre pour approbation
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openResolutionModal(ticketId, ticketTitle) {
            document.getElementById('modalTicketTitle').textContent = `Ticket #${ticketId}: ${ticketTitle}`;
            document.getElementById('resolutionForm').action = `{{ url('tickets') }}/${ticketId}/status`;
            document.getElementById('resolutionModal').classList.remove('hidden');
        }
        
        function closeResolutionModal() {
            document.getElementById('resolutionModal').classList.add('hidden');
            document.getElementById('resolution_notes').value = '';
        }
    </script>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endpush