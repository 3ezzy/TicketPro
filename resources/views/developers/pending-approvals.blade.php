@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto p-6">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-primary">Tickets En Attente d'Approbation</h1>
                <p class="text-secondary mt-2">Approuvez ou rejetez les résolutions de tickets soumises par les développeurs</p>
            </div>
            <a href="{{ route('dashboard') }}" class="bg-mint text-primary px-6 py-2 rounded-lg hover:bg-mint-light transition duration-150 font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                <i class="fas fa-arrow-left mr-2"></i>Retour au Tableau de Bord
            </a>
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

        <!-- Pending Tickets List -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="p-6 border-b border-gray-100">
                <h3 class="text-xl font-semibold text-primary">Tickets En Attente d'Approbation ({{ $pendingTickets->count() }})</h3>
            </div>

            @if($pendingTickets->count() > 0)
                <div class="divide-y divide-gray-100">
                    @foreach($pendingTickets as $ticket)
                        <div class="p-6 hover:bg-gray-50 transition duration-150">
                            <div class="md:flex justify-between">
                                <!-- Ticket Info -->
                                <div class="md:w-2/3">
                                    <div class="flex items-center mb-3">
                                        <h4 class="text-lg font-semibold text-primary mr-3">
                                            #{{ $ticket->id }} - {{ $ticket->title }}
                                        </h4>
                                        @if($ticket->priority == 'high')
                                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Urgent</span>
                                        @elseif($ticket->priority == 'medium')
                                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-orange-100 text-orange-800">Moyen</span>
                                        @else
                                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Faible</span>
                                        @endif
                                    </div>
                                    
                                    <!-- Client Info -->
                                    <div class="flex items-center mb-3">
                                        <img src="https://ui-avatars.com/api/?name={{ $ticket->user->firstName }}+{{ $ticket->user->lastName }}&background=05BFDB&color=0A4D68"
                                            alt="Client" class="w-8 h-8 rounded-full border-2 border-mint">
                                        <div class="ml-2">
                                            <p class="text-sm font-semibold text-gray-700">{{ $ticket->user->firstName }} {{ $ticket->user->lastName }}</p>
                                            <p class="text-xs text-gray-500">Client</p>
                                        </div>
                                    </div>
                                    
                                    <!-- Developer Info -->
                                    <div class="flex items-center mb-3">
                                        @if($ticket->assignments->first())
                                            <img src="https://ui-avatars.com/api/?name={{ $ticket->assignments->first()->developer->firstName }}+{{ $ticket->assignments->first()->developer->lastName }}&background=05BFDB&color=0A4D68"
                                                alt="Developer" class="w-8 h-8 rounded-full border-2 border-mint">
                                            <div class="ml-2">
                                                <p class="text-sm font-semibold text-gray-700">{{ $ticket->assignments->first()->developer->firstName }} {{ $ticket->assignments->first()->developer->lastName }}</p>
                                                <p class="text-xs text-gray-500">Développeur</p>
                                            </div>
                                        @else
                                            <p class="text-sm text-gray-500">Aucun développeur assigné</p>
                                        @endif
                                    </div>
                                    
                                    <!-- Dates -->
                                    <div class="flex flex-wrap gap-4 text-sm text-gray-500 mb-3">
                                        <div>
                                            <i class="fas fa-calendar-alt text-mint mr-1"></i>
                                            <span>Créé le: {{ $ticket->created_at->format('d/m/Y H:i') }}</span>
                                        </div>
                                        @if($ticket->resolution)
                                            <div>
                                                <i class="fas fa-check-circle text-mint mr-1"></i>
                                                <span>Résolu le: {{ $ticket->resolution->resolved_at->format('d/m/Y H:i') }}</span>
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <!-- Resolution Notes -->
                                    <div class="bg-gray-50 rounded-lg p-4 mb-3">
                                        <h5 class="font-semibold text-gray-700 mb-2">Notes de résolution:</h5>
                                        <p class="text-gray-700">{{ $ticket->resolution ? $ticket->resolution->resolution_notes : 'Aucune note disponible' }}</p>
                                    </div>
                                </div>
                                
                                <!-- Action Panel -->
                                <div class="md:w-1/3 md:pl-6 mt-4 md:mt-0 border-t md:border-t-0 md:border-l md:border-gray-100 pt-4 md:pt-0 md:pl-6">
                                    <div class="bg-gray-50 rounded-lg p-4">
                                        <h5 class="font-semibold text-gray-700 mb-4">Action Requise</h5>
                                        
                                        <form action="{{ route('developers.resolve-ticket', $ticket->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            
                                            <div class="mb-4">
                                                <label for="admin_notes_{{ $ticket->id }}" class="block text-sm font-medium text-gray-700 mb-2">
                                                    Notes (optionnel)
                                                </label>
                                                <textarea 
                                                    name="admin_notes" 
                                                    id="admin_notes_{{ $ticket->id }}" 
                                                    rows="3"
                                                    placeholder="Ajoutez des notes sur cette résolution..."
                                                    class="block w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-mint focus:border-mint text-sm"></textarea>
                                            </div>
                                            
                                            <div class="flex gap-2">
                                                <button 
                                                    type="submit" 
                                                    name="action" 
                                                    value="approve" 
                                                    class="flex-1 bg-green-600 text-white py-2 px-4 rounded-lg hover:bg-green-700 transition duration-150 flex items-center justify-center text-sm">
                                                    <i class="fas fa-check mr-2"></i>
                                                    Approuver
                                                </button>
                                                <button 
                                                    type="submit" 
                                                    name="action" 
                                                    value="reject" 
                                                    class="flex-1 bg-red-600 text-white py-2 px-4 rounded-lg hover:bg-red-700 transition duration-150 flex items-center justify-center text-sm"
                                                    onclick="return confirm('Êtes-vous sûr de vouloir rejeter cette résolution? Le ticket sera remis en statut En Cours.')">
                                                    <i class="fas fa-times mr-2"></i>
                                                    Rejeter
                                                </button>
                                            </div>
                                        </form>
                                        
                                        <div class="mt-4 text-center">
                                            <a href="{{ route('tickets.show', $ticket->id) }}" class="text-mint hover:text-secondary text-sm">
                                                <i class="fas fa-eye mr-1"></i>
                                                Voir détails du ticket
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="p-8 text-center">
                    <i class="fas fa-check-circle text-mint text-4xl mb-4"></i>
                    <h4 class="text-xl font-semibold text-primary mb-2">Aucun ticket en attente d'approbation</h4>
                    <p class="text-gray-500">Tous les tickets résolus par les développeurs ont déjà été traités.</p>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endpush