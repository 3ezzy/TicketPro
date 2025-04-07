@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-6">
    <!-- Back Button and Actions -->
    <div class="flex justify-between items-center mb-6">
        <a href="{{ route('tickets.index') }}" class="inline-flex items-center text-primary hover:text-secondary transition-colors duration-200">
            <i class="fas fa-arrow-left mr-2"></i>
            <span>Retour à la liste des tickets</span>
        </a>
        
        <div class="flex space-x-3">
            @if(auth()->user()->role === 'client' && auth()->user()->id === $ticket->user_id)
            <!-- Only show edit button to the client who created the ticket -->
            <a href="{{ route('tickets.edit', $ticket->id) }}" class="bg-mint text-primary px-4 py-2 rounded-lg hover:bg-mint-light transition duration-150 font-medium shadow-lg hover:shadow-xl">
                <i class="fas fa-edit mr-2"></i>Modifier
            </a>
            
            <!-- Client can delete their own tickets -->
            <form action="{{ route('tickets.destroy', $ticket->id) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce ticket?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition duration-150 font-medium shadow-lg hover:shadow-xl">
                    <i class="fas fa-trash mr-2"></i>Supprimer
                </button>
            </form>
            @endif
            
            @if(auth()->user()->role === 'admin')
            <!-- Admin can assign and delete tickets -->
            @if($ticket->status != 'closed')
            <a href="{{ route('assignments.create', $ticket->id) }}" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-secondary transition duration-150 font-medium shadow-lg hover:shadow-xl">
                <i class="fas fa-user-check mr-2"></i>Assigner
            </a>
            @endif
            
            <form action="{{ route('tickets.destroy', $ticket->id) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce ticket?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition duration-150 font-medium shadow-lg hover:shadow-xl">
                    <i class="fas fa-trash mr-2"></i>Supprimer
                </button>
            </form>
            @endif
            
            <!-- Developers don't see edit/delete buttons -->
        </div>
    </div>

    <!-- Ticket Details Card -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-8">
        <!-- Header with Status -->
        <div class="p-6 border-b border-gray-100 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-primary">Ticket #{{ $ticket->id }}</h1>
                <p class="text-secondary">Créé le {{ $ticket->created_at->format('d/m/Y à H:i') }}</p>
            </div>
            <div>
                @if($ticket->status == 'open')
                    <span class="px-4 py-2 text-sm font-semibold rounded-full bg-blue-100 text-blue-800">
                        <i class="fas fa-ticket-alt mr-2"></i>Ouvert
                    </span>
                @elseif($ticket->status == 'in_progress')
                    <span class="px-4 py-2 text-sm font-semibold rounded-full bg-mint bg-opacity-20 text-secondary">
                        <i class="fas fa-spinner fa-spin mr-2"></i>En cours
                    </span>
                @elseif($ticket->status == 'pending_approval')
                    <span class="px-4 py-2 text-sm font-semibold rounded-full bg-yellow-100 text-yellow-800">
                        <i class="fas fa-clock mr-2"></i>En attente d'approbation
                    </span>
                @elseif($ticket->status == 'closed')
                    <span class="px-4 py-2 text-sm font-semibold rounded-full bg-green-100 text-green-800">
                        <i class="fas fa-check-circle mr-2"></i>Résolu
                    </span>
                @endif
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="md:flex">
            <!-- Left Panel - Ticket Details -->
            <div class="md:w-2/3 p-6">
                <div class="mb-6">
                    <h2 class="text-xl font-semibold text-primary mb-4">{{ $ticket->title }}</h2>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-gray-700 whitespace-pre-line">{{ $ticket->description }}</p>
                    </div>
                </div>
                
                @if(isset($ticket->resolution))
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-primary mb-3">
                        <i class="fas fa-clipboard-check text-mint mr-2"></i>Résolution
                    </h3>
                    <div class="bg-green-50 p-4 rounded-lg border-l-4 border-green-400">
                        <p class="text-gray-700 whitespace-pre-line">{{ $ticket->resolution->resolution_notes }}</p>
                        <div class="mt-2 text-sm text-gray-500">
                            <p>Résolu par: 
                                @if(isset($ticket->resolution->developer))
                                {{ $ticket->resolution->developer->firstName }} {{ $ticket->resolution->developer->lastName }}
                                @else
                                Non spécifié
                                @endif
                            </p>
                            <p>Le: {{ isset($ticket->resolution->resolved_at) ? $ticket->resolution->resolved_at->format('d/m/Y à H:i') : 'N/A' }}</p>
                        </div>
                    </div>
                </div>
                @endif
                
                @if(isset($ticket->resolution) && isset($ticket->resolution->admin_notes) && !empty($ticket->resolution->admin_notes))
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-primary mb-3">
                        <i class="fas fa-comment-alt text-mint mr-2"></i>Notes de l'administrateur
                    </h3>
                    <div class="bg-blue-50 p-4 rounded-lg border-l-4 border-blue-400">
                        <p class="text-gray-700 whitespace-pre-line">{{ $ticket->resolution->admin_notes }}</p>
                        <div class="mt-2 text-sm text-gray-500">
                            <p>Par: 
                                @if(isset($ticket->resolution->admin))
                                {{ $ticket->resolution->admin->firstName }} {{ $ticket->resolution->admin->lastName }}
                                @else
                                Non spécifié
                                @endif
                            </p>
                            <p>Le: {{ isset($ticket->resolution->approved_at) ? $ticket->resolution->approved_at->format('d/m/Y à H:i') : 'N/A' }}</p>
                        </div>
                    </div>
                </div>
                @endif
            </div>
            
            <!-- Right Panel - Meta Info -->
            <div class="md:w-1/3 bg-gray-50 p-6 border-t md:border-t-0 md:border-l border-gray-100">
                <!-- Client Info -->
                <div class="mb-6">
                    <h3 class="text-sm uppercase tracking-wider text-gray-500 font-semibold mb-3">Client</h3>
                    <div class="flex items-center">
                        <img src="https://ui-avatars.com/api/?name={{ $ticket->user->firstName }}+{{ $ticket->user->lastName }}&background=05BFDB&color=0A4D68"
                            alt="Client" class="w-10 h-10 rounded-full border-2 border-mint">
                        <div class="ml-3">
                            <p class="font-semibold text-primary">{{ $ticket->user->firstName }} {{ $ticket->user->lastName }}</p>
                            <p class="text-sm text-gray-500">{{ $ticket->user->email }}</p>
                        </div>
                    </div>
                </div>
                
                <!-- Assignment Info if assigned -->
                @if(isset($ticket->assignments) && count($ticket->assignments) > 0)
                <div class="mb-6">
                    <h3 class="text-sm uppercase tracking-wider text-gray-500 font-semibold mb-3">Développeur assigné</h3>
                    <div class="flex items-center">
                        <img src="https://ui-avatars.com/api/?name={{ $ticket->assignments->first()->developer->firstName }}+{{ $ticket->assignments->first()->developer->lastName }}&background=05BFDB&color=0A4D68"
                            alt="Developer" class="w-10 h-10 rounded-full border-2 border-mint">
                        <div class="ml-3">
                            <p class="font-semibold text-primary">{{ $ticket->assignments->first()->developer->firstName }} {{ $ticket->assignments->first()->developer->lastName }}</p>
                            <p class="text-sm text-gray-500">
                                Assigné le: {{ $ticket->assignments->first()->assigned_at->format('d/m/Y') }}
                            </p>
                        </div>
                    </div>
                </div>
                @endif
                
                <!-- Ticket Information -->
                <div class="mb-6">
                    <h3 class="text-sm uppercase tracking-wider text-gray-500 font-semibold mb-3">Informations</h3>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500">Priorité:</span>
                            <span class="px-3 py-1 text-xs font-semibold rounded-full 
                                {{ $ticket->priority == 'high' ? 'bg-red-100 text-red-800' : 
                                   ($ticket->priority == 'medium' ? 'bg-orange-100 text-orange-800' : 
                                   'bg-green-100 text-green-800') }}">
                                {{ ucfirst($ticket->priority) }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500">Système d'exploitation:</span>
                            <span class="text-sm font-medium text-primary">{{ ucfirst($ticket->os) }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500">Logiciel:</span>
                            <span class="text-sm font-medium text-primary">{{ $ticket->software->name }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500">Créé le:</span>
                            <span class="text-sm font-medium text-primary">{{ $ticket->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500">Dernière mise à jour:</span>
                            <span class="text-sm font-medium text-primary">{{ $ticket->updated_at->format('d/m/Y H:i') }}</span>
                        </div>
                    </div>
                </div>
                
                <!-- Timeline -->
                <div>
                    <h3 class="text-sm uppercase tracking-wider text-gray-500 font-semibold mb-3">Timeline</h3>
                    <div class="relative pl-8 space-y-6 before:absolute before:top-0 before:bottom-0 before:left-3 before:border-l before:border-gray-300">
                        <!-- Created -->
                        <div class="relative">
                            <div class="absolute -left-8 top-0 bg-mint p-1.5 rounded-full border-4 border-white">
                                <i class="fas fa-plus text-white text-xs"></i>
                            </div>
                            <p class="text-xs font-semibold text-primary">Ticket créé</p>
                            <p class="text-xs text-gray-500">{{ $ticket->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        
                        <!-- Assigned (if applicable) -->
                        @if(isset($ticket->assignments) && count($ticket->assignments) > 0)
                        <div class="relative">
                            <div class="absolute -left-8 top-0 bg-mint p-1.5 rounded-full border-4 border-white">
                                <i class="fas fa-user-check text-white text-xs"></i>
                            </div>
                            <p class="text-xs font-semibold text-primary">Ticket assigné</p>
                            <p class="text-xs text-gray-500">{{ $ticket->assignments->first()->assigned_at->format('d/m/Y H:i') }}</p>
                        </div>
                        @endif
                        
                        <!-- Resolution submitted (if applicable) -->
                        @if(isset($ticket->resolution) && $ticket->resolution->status != 'rejected')
                        <div class="relative">
                            <div class="absolute -left-8 top-0 bg-mint p-1.5 rounded-full border-4 border-white">
                                <i class="fas fa-check text-white text-xs"></i>
                            </div>
                            <p class="text-xs font-semibold text-primary">Résolution soumise</p>
                            <p class="text-xs text-gray-500">{{ $ticket->resolution->resolved_at->format('d/m/Y H:i') }}</p>
                        </div>
                        @endif
                        
                        <!-- Resolution approved (if applicable) -->
                        @if(isset($ticket->resolution) && $ticket->resolution->status == 'approved')
                        <div class="relative">
                            <div class="absolute -left-8 top-0 bg-green-500 p-1.5 rounded-full border-4 border-white">
                                <i class="fas fa-check-double text-white text-xs"></i>
                            </div>
                            <p class="text-xs font-semibold text-primary">Résolution approuvée</p>
                            <p class="text-xs text-gray-500">{{ $ticket->resolution->approved_at->format('d/m/Y H:i') }}</p>
                        </div>
                        @endif
                        
                        <!-- Resolution rejected (if applicable) -->
                        @if(isset($ticket->resolution) && $ticket->resolution->status == 'rejected')
                        <div class="relative">
                            <div class="absolute -left-8 top-0 bg-red-500 p-1.5 rounded-full border-4 border-white">
                                <i class="fas fa-times text-white text-xs"></i>
                            </div>
                            <p class="text-xs font-semibold text-primary">Résolution rejetée</p>
                            <p class="text-xs text-gray-500">{{ $ticket->resolution->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endpush