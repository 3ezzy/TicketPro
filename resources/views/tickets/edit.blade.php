@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-primary">Modifier le Ticket #{{ $ticket->id }}</h1>
        <p class="text-secondary mt-2">Modifiez les informations du ticket ci-dessous</p>
    </div>

    <!-- Ticket Edit Form -->
    <div class="bg-white rounded-xl shadow-lg p-8">
        <form action="{{ route('tickets.update', $ticket) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            
            <!-- Title -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Titre du Ticket <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       name="title"
                       value="{{ old('title', $ticket->title) }}"
                       required
                       class="block w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-mint focus:border-mint @error('title') border-red-500 @enderror"
                       placeholder="Entrez un titre descriptif">
                @error('title')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Description <span class="text-red-500">*</span>
                </label>
                <textarea name="description"
                          required
                          rows="6"
                          class="block w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-mint focus:border-mint @error('description') border-red-500 @enderror"
                          placeholder="Décrivez le problème en détail...">{{ old('description', $ticket->description) }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Priority & OS Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Priority -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Priorité <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <select name="priority"
                                required
                                class="block w-full pl-4 pr-10 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-mint focus:border-mint appearance-none @error('priority') border-red-500 @enderror">
                            <option value="low" {{ old('priority', $ticket->priority) == 'low' ? 'selected' : '' }}>Basse</option>
                            <option value="medium" {{ old('priority', $ticket->priority) == 'medium' ? 'selected' : '' }}>Moyenne</option>
                            <option value="high" {{ old('priority', $ticket->priority) == 'high' ? 'selected' : '' }}>Haute</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                            <i class="fas fa-chevron-down text-gray-400"></i>
                        </div>
                    </div>
                    @error('priority')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Operating System -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Système d'Exploitation <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <select name="os"
                                required
                                class="block w-full pl-4 pr-10 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-mint focus:border-mint appearance-none @error('os') border-red-500 @enderror">
                            <option value="">Sélectionnez l'OS</option>
                            <option value="windows" {{ old('os', $ticket->os) == 'windows' ? 'selected' : '' }}>Windows</option>
                            <option value="macos" {{ old('os', $ticket->os) == 'macos' ? 'selected' : '' }}>macOS</option>
                            <option value="linux" {{ old('os', $ticket->os) == 'linux' ? 'selected' : '' }}>Linux</option>
                            <option value="ios" {{ old('os', $ticket->os) == 'ios' ? 'selected' : '' }}>iOS</option>
                            <option value="android" {{ old('os', $ticket->os) == 'android' ? 'selected' : '' }}>Android</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                            <i class="fas fa-chevron-down text-gray-400"></i>
                        </div>
                    </div>
                    @error('os')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Software Selection -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Logiciel Concerné <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <select name="software_id"
                            required
                            class="block w-full pl-4 pr-10 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-mint focus:border-mint appearance-none @error('software_id') border-red-500 @enderror">
                        <option value="">Sélectionnez le logiciel</option>
                        @foreach($software as $sw)
                            <option value="{{ $sw->id }}" {{ old('software_id', $ticket->software_id) == $sw->id ? 'selected' : '' }}>
                                {{ $sw->name }}
                            </option>
                        @endforeach
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                        <i class="fas fa-chevron-down text-gray-400"></i>
                    </div>
                </div>
                @error('software_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Ticket Information -->
            <div class="bg-gray-50 p-4 rounded-lg">
                <div class="flex items-center">
                    <img src="https://ui-avatars.com/api/?name={{ $ticket->user->name }}&background=05BFDB&color=0A4D68" 
                         alt="{{ $ticket->user->name }}" 
                         class="w-10 h-10 rounded-full border-2 border-mint">
                    <div class="ml-4">
                        <p class="text-sm font-medium text-primary">Créé par: {{ $ticket->user->name }}</p>
                        <p class="text-xs text-gray-500">Créé le: {{ $ticket->created_at->format('Y-m-d H:i:s') }} UTC</p>
                        <p class="text-xs text-gray-500">Dernière modification: {{ $ticket->updated_at->format('Y-m-d H:i:s') }} UTC</p>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex space-x-4 pt-4">
                <button type="submit" 
                        class="flex-1 bg-primary text-white py-3 px-6 rounded-lg hover:bg-secondary transition duration-150 flex items-center justify-center space-x-2">
                    <i class="fas fa-save"></i>
                    <span>Enregistrer les Modifications</span>
                </button>
                <a href="{{ route('tickets.show', $ticket) }}" 
                   class="px-6 py-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition duration-150">
                    Annuler
                </a>
            </div>
        </form>
    </div>

    <!-- Help Section -->
    <div class="mt-8 bg-mint bg-opacity-10 rounded-xl p-6">
        <h3 class="text-lg font-semibold text-primary mb-4">
            <i class="fas fa-lightbulb text-mint mr-2"></i>
            Conseils pour la modification
        </h3>
        <ul class="space-y-2 text-secondary">
            <li class="flex items-start">
                <i class="fas fa-check-circle text-mint mt-1 mr-2"></i>
                <span>Conservez les informations pertinentes existantes</span>
            </li>
            <li class="flex items-start">
                <i class="fas fa-check-circle text-mint mt-1 mr-2"></i>
                <span>Mettez à jour uniquement les éléments nécessaires</span>
            </li>
            <li class="flex items-start">
                <i class="fas fa-check-circle text-mint mt-1 mr-2"></i>
                <span>Vérifiez que toutes les informations sont toujours exactes</span>
            </li>
        </ul>
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