<nav class="bg-primary text-white shadow-lg">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <div class="flex-shrink-0 flex items-center space-x-3">
                <i class="fas fa-ticket-alt text-mint text-2xl"></i>
                <h1 class="text-2xl font-bold text-mint-light">TicketPro</h1>
            </div>

            <!-- Navigation Links -->
            <div class="hidden md:flex space-x-8">
                <a href="{{ route('dashboard') }}"
                    class="flex items-center px-3 py-2 rounded-md text-sm font-medium 
                    {{ request()->routeIs('dashboard') ? 'bg-secondary text-mint-light' : 'hover:bg-secondary hover:text-mint-light transition duration-150' }}">
                    <i class="fas fa-home mr-2"></i>
                    Tableau de bord
                </a>
                <a href="{{ route('tickets.index') }}"
                    class="flex items-center px-3 py-2 rounded-md text-sm font-medium 
                    {{ request()->routeIs('tickets.*') ? 'bg-secondary text-mint-light' : 'hover:bg-secondary hover:text-mint-light transition duration-150' }}">
                    <i class="fas fa-ticket-alt mr-2"></i>
                    Tickets
                </a>
                <a href="{{ route('developers.index') }}"
                    class="flex items-center px-3 py-2 rounded-md text-sm font-medium 
                    {{ request()->routeIs('developers.*') && !request()->routeIs('developers.my-tickets') && !request()->routeIs('developers.pending-approvals') ? 'bg-secondary text-mint-light' : 'hover:bg-secondary hover:text-mint-light transition duration-150' }}">
                    <i class="fas fa-users mr-2"></i>
                    Développeurs
                </a>
                
                @if(auth()->user()->role === 'developer')
                <a href="{{ route('developers.my-tickets') }}"
                    class="flex items-center px-3 py-2 rounded-md text-sm font-medium 
                    {{ request()->routeIs('developers.my-tickets') ? 'bg-secondary text-mint-light' : 'hover:bg-secondary hover:text-mint-light transition duration-150' }}">
                    <i class="fas fa-tasks mr-2"></i>
                    Mes Tickets
                </a>
                @endif
                
                @if(auth()->user()->role === 'admin')
                <a href="{{ route('assignments.index') }}"
                    class="flex items-center px-3 py-2 rounded-md text-sm font-medium 
                    {{ request()->routeIs('assignments.*') ? 'bg-secondary text-mint-light' : 'hover:bg-secondary hover:text-mint-light transition duration-150' }}">
                    <i class="fas fa-clipboard-check mr-2"></i>
                    Affectations
                </a>
                
                @php
                    $pendingCount = \App\Models\Ticket::where('status', 'pending_approval')->count();
                @endphp
                
                <a href="{{ route('developers.pending-approvals') }}"
                    class="flex items-center px-3 py-2 rounded-md text-sm font-medium 
                    {{ request()->routeIs('developers.pending-approvals') ? 'bg-secondary text-mint-light' : 'hover:bg-secondary hover:text-mint-light transition duration-150' }}">
                    <i class="fas fa-check-double mr-2"></i>
                    Approvals
                    @if($pendingCount > 0)
                    <span class="ml-2 px-2 py-0.5 text-xs rounded-full bg-mint text-primary">{{ $pendingCount }}</span>
                    @endif
                </a>
                @endif
            </div>

            <!-- Right Side Items -->
            <div class="flex items-center space-x-4">
                <!-- User Profile with Dropdown -->
                <div class="relative group">
                    <button
                        class="flex items-center space-x-2 text-mint-light hover:text-white transition-all duration-300">
                        <span class="text-sm">{{ auth()->user()->lastName }} {{ auth()->user()->firstName }}</span>
                        <div class="relative">
                            <img src="https://ui-avatars.com/api/?name={{ auth()->user()->lastName }}&{{ auth()->user()->firstName }}&background=05BFDB&color=0A4D68"
                                alt="Profile" class="w-8 h-8 rounded-full border-2 border-mint">
                            <div
                                class="absolute -bottom-1 -right-1 w-3 h-3 bg-mint-light rounded-full border-2 border-primary">
                            </div>
                        </div>
                        <i class="fas fa-caret-down ml-1 text-mint-light"></i>
                    </button>

                    <!-- Enhanced Dropdown Menu -->
                    <div
                        class="absolute right-0 w-64 mt-3
                        bg-white bg-opacity-80
                        rounded-xl
                        shadow-2xl
                        border border-mint-light
                        backdrop-blur-lg
                        opacity-0 invisible
                        group-hover:opacity-100
                        group-hover:visible
                        transition-all duration-300
                        transform origin-top-right
                        scale-95 group-hover:scale-100
                        overflow-hidden">

                        <!-- Profile Option -->
                        <a href="{{ route('profile.edit') }}"
                            class="block px-4 py-3 
                           text-primary
                           hover:bg-gradient-to-r
                           from-mint-light to-mint
                           hover:text-white
                           transition duration-200 
                           flex items-center">
                            <i class="fas fa-user-circle mr-3"></i>
                            Profile
                        </a>

                        <!-- Logout Option -->
                        <form method="POST" action="{{ route('logout') }}" class="block">
                            @csrf
                            <button type="submit"
                                class="w-full text-left 
                                    px-4 py-3 
                                    text-primary
                                    hover:bg-gradient-to-r
                                    from-red-400 to-red-500
                                    hover:text-white
                                    transition duration-200 
                                    flex items-center">
                                <i class="fas fa-sign-out-alt mr-3"></i>
                                Log Out
                            </button>
                        </form>

                        <!-- Time Display with Gradient -->
                        <div
                            class="px-4 py-2 
                            text-xs 
                            text-center 
                            bg-secondary
                            bg-opacity-50 
                            border-t 
                            text-primary
                            font-mono">
                            {{ now()->timezone('Africa/Casablanca')->format('Y-m-d H:i') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>