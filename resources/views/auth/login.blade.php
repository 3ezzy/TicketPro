@extends('guest-layout')

@section('title', 'TicketFlow - Connexion')

@section('content')
    <div class="max-w-md w-full">
        <!-- Logo & Header -->
        <div class="text-center mb-8">
            <div class="flex justify-center mb-4">
                <div class="rounded-full bg-primary p-4 shadow-lg">
                    <i class="fas fa-ticket-alt text-mint text-3xl"></i>
                </div>
            </div>
            <h1 class="text-3xl font-bold text-primary mb-2">TicketFlow</h1>
            <p class="text-secondary">Connectez-vous à votre compte</p>
        </div>

        <!-- Login Form -->
        <div class="bg-white rounded-xl shadow-lg p-8">
            <h2 class="text-2xl font-semibold text-primary mb-6">Connexion</h2>

            <!-- Display General Errors -->
            @if ($errors->any())
                <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-circle text-red-400"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-700">
                                @foreach ($errors->all() as $error)
                                    {{ $error }}<br>
                                @endforeach
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            <form class="space-y-6" method="POST" action="{{ route('login') }}">
                @csrf <!-- CSRF Token for security -->

                <!-- Email or Username Field -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Email ou Nom d'utilisateur
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-user text-gray-400"></i>
                        </div>
                        <input type="text" 
                               name="login" 
                               class="block w-full pl-10 pr-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-mint focus:border-mint @error('login') border-red-500 @enderror"
                               placeholder="Email ou nom d'utilisateur"
                               value="{{ old('login') }}"
                               required>
                    </div>
                    @error('login')
                        <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Field -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Mot de passe
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                        <input type="password" 
                               name="password" 
                               class="block w-full pl-10 pr-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-mint focus:border-mint @error('password') border-red-500 @enderror"
                               placeholder="Mot de passe"
                               required>
                    </div>
                    @error('password')
                        <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember Me Checkbox -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input type="checkbox" 
                               name="remember" 
                               id="remember" 
                               class="h-4 w-4 text-mint focus:ring-mint border-gray-300 rounded">
                        <label for="remember" class="ml-2 text-sm text-gray-700">
                            Se souvenir de moi
                        </label>
                    </div>

                    <!-- Forgot Password Link -->
                    <div class="text-sm">
                        <a href="{{ route('password.request') }}" class="text-mint hover:text-secondary">
                            Mot de passe oublié?
                        </a>
                    </div>
                </div>

                <!-- Login Button -->
                <button type="submit" 
                        class="w-full bg-primary text-white py-2 px-4 rounded-lg hover:bg-secondary transition duration-150 flex items-center justify-center space-x-2 group">
                    <i class="fas fa-sign-in-alt group-hover:scale-110 transition-transform"></i>
                    <span>Se connecter</span>
                </button>

                <!-- Register Link -->
                <div class="text-center mt-6">
                    <p class="text-sm text-gray-600">
                        Pas encore inscrit? 
                        <a href="{{ route('register') }}" class="text-mint hover:text-secondary font-medium">
                            Créer un compte
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>
@endsection