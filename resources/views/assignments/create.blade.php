@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto p-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-primary">Assign Developer to Ticket #{{ $ticket->id }}</h1>
            <p class="text-secondary mt-2">Select a developer to handle this ticket</p>
        </div>

        <!-- Assignment Form -->
        <div class="bg-white rounded-xl shadow-lg p-8">
            <form action="{{ route('assignments.store') }}" method="POST" class="space-y-6">
                @csrf
                <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">

                <!-- Ticket Information -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Ticket Information
                    </label>
                    <div class="mb-4">
                        <label for="ticket_title" class="block text-sm font-medium text-gray-700 mb-2">
                            Ticket Title
                        </label>
                        <input type="text" name="ticket_title" id="ticket_title" value="{{ $ticket->title }}" readonly
                            class="block w-full px-4 py-3 border border-gray-200 rounded-lg bg-gray-50 text-gray-700">
                    </div>
                    <div>
                        <label for="ticket_description" class="block text-sm font-medium text-gray-700 mb-2">
                            Ticket Description
                        </label>
                        <textarea name="ticket_description" id="ticket_description" readonly
                            class="block w-full px-4 py-3 border border-gray-200 rounded-lg bg-gray-50 text-gray-700">{{ $ticket->description }}</textarea>
                    </div>
                </div>

                <!-- Developer Selection -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Select Developer <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <select name="developer_id" id="developer" required
                            class="block w-full pl-4 pr-10 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-mint focus:border-mint appearance-none">
                            <option value="">Select a developer</option>
                            @foreach ($developers as $developer)
                                <option value="{{ $developer->id }}">{{ $developer->firstName }} {{ $developer->lastName }}
                                </option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                            <i class="fas fa-chevron-down text-gray-400"></i>
                        </div>
                    </div>
                    @error('developer_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Assignment Info -->
                <div class="bg-gray-50 p-4 rounded-lg">
                    <div class="flex items-center">
                        <img src="https://ui-avatars.com/api/?name={{ auth()->user()->username }}&background=05BFDB&color=0A4D68"
                            alt="{{ auth()->user()->username }}" class="w-10 h-10 rounded-full border-2 border-mint">
                        <div class="ml-4">
                            <p class="text-sm font-medium text-primary">Assigned by: {{ auth()->user()->username }}</p>
                            <p class="text-xs text-gray-500">{{ now()->format('Y-m-d H:i:s') }} UTC</p>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex space-x-4 pt-4">
                    <button type="submit"
                        class="flex-1 bg-primary text-white py-3 px-6 rounded-lg hover:bg-secondary transition duration-150 flex items-center justify-center space-x-2">
                        <i class="fas fa-user-plus"></i>
                        <span>Assign Developer</span>
                    </button>
                    <a href="{{ route('tickets.index') }}"
                        class="px-6 py-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition duration-150">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endpush
