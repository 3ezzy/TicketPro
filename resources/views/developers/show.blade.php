@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto p-6">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('developers.index') }}" class="inline-flex items-center text-primary hover:text-secondary transition-colors duration-200">
                <i class="fas fa-arrow-left mr-2"></i>
                <span>Retour à la liste des développeurs</span>
            </a>
        </div>

        <!-- Developer Profile Header -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-6">
            <div class="md:flex">
                <!-- Profile Section -->
                <div class="p-8 flex-grow">
                    <div class="flex items-center">
                        <img src="https://ui-avatars.com/api/?name={{ $developer->firstName }}+{{ $developer->lastName }}&background=05BFDB&color=0A4D68&size=128" 
                             alt="{{ $developer->firstName }} {{ $developer->lastName }}"
                             class="w-24 h-24 rounded-full border-4 border-mint">
                        
                        <div class="ml-6">
                            <h2 class="text-3xl font-bold text-primary">{{ $developer->firstName }} {{ $developer->lastName }}</h2>
                            <p class="text-lg text-secondary">{{ ucfirst($developer->role) }}</p>
                            <p class="text-gray-500">{{ $developer->email }}</p>
                            <div class="mt-2">
                                <span class="inline-flex items-center px-3 py-1 text-sm font-medium rounded-full {{ $inProgressTickets > 0 ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800' }}">
                                    <i class="fas {{ $inProgressTickets > 0 ? 'fa-circle-notch fa-spin' : 'fa-check-circle' }} mr-1"></i>
                                    {{ $inProgressTickets > 0 ? 'Occupé' : 'Disponible' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Stats Section -->
                <div class="bg-gray-50 p-8 md:w-80">
                    <h3 class="text-xl font-semibold text-primary mb-4">Statistiques</h3>
                    <div class="space-y-4">
                        <div>
                            <p class="text-gray-500">Tickets assignés</p>
                            <p class="text-2xl font-bold text-primary">{{ $totalTickets }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500">Tickets complétés</p>
                            <p class="text-2xl font-bold text-green-600">{{ $completedTickets }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500">Tickets en cours</p>
                            <p class="text-2xl font-bold text-yellow-600">{{ $inProgressTickets }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500">Taux de résolution</p>
                            <div class="flex items-center">
                                <div class="w-full bg-gray-200 rounded-full h-2.5 mr-2">
                                    <div class="bg-mint h-2.5 rounded-full" style="width: {{ $resolutionRate }}%"></div>
                                </div>
                                <span class="text-mint font-bold">{{ $resolutionRate }}%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tickets Assigned Section -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="p-6 border-b border-gray-100">
                <h3 class="text-xl font-semibold text-primary">Tickets Assignés</h3>
            </div>

            <div class="overflow-x-auto">
                @if($assignments->count() > 0)
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-primary uppercase tracking-wider">ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-primary uppercase tracking-wider">Titre</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-primary uppercase tracking-wider">Client</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-primary uppercase tracking-wider">Priorité</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-primary uppercase tracking-wider">Statut</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-primary uppercase tracking-wider">Date d'assignation</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($assignments as $assignment)
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
                                    <td class="px-6 py-4">
                                        @if($assignment->ticket->status == 'open')
                                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">Ouvert</span>
                                        @elseif($assignment->ticket->status == 'in_progress')
                                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-mint bg-opacity-20 text-secondary">En cours</span>
                                        @elseif($assignment->ticket->status == 'closed')
                                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Résolu</span>
                                        @else
                                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">{{ $assignment->ticket->status }}</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $assignment->assigned_at ? $assignment->assigned_at->format('Y-m-d H:i') : 'N/A' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="p-6 text-center">
                        <i class="fas fa-ticket-alt text-mint text-xl mb-3 block"></i>
                        <p class="text-gray-500">Aucun ticket assigné à ce développeur.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endpush