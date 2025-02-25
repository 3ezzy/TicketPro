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
                <a href="#" class="flex items-center px-3 py-2 rounded-md text-sm font-medium bg-secondary text-mint-light">
                    <i class="fas fa-home mr-2"></i>
                    Tableau de bord
                </a>
                <a href="tickets.html" class="flex items-center px-3 py-2 rounded-md text-sm font-medium hover:bg-secondary hover:text-mint-light transition duration-150">
                    <i class="fas fa-ticket-alt mr-2"></i>
                    Tickets
                </a>
                <a href="developers.html" class="flex items-center px-3 py-2 rounded-md text-sm font-medium hover:bg-secondary hover:text-mint-light transition duration-150">
                    <i class="fas fa-users mr-2"></i>
                    Développeurs
                </a>
                <a href="reports.html" class="flex items-center px-3 py-2 rounded-md text-sm font-medium hover:bg-secondary hover:text-mint-light transition duration-150">
                    <i class="fas fa-chart-bar mr-2"></i>
                    Rapports
                </a>
            </div>

            <!-- Right Side Items -->
            <div class="flex items-center space-x-4">
                <!-- Current DateTime -->
                <div class="hidden md:flex flex-col text-sm text-mint-light">
                    <span class="text-xs">2025-02-24</span>
                    <span class="text-xs">16:21:00 UTC</span>
                </div>
                
                <!-- User Profile -->
                <div class="flex items-center space-x-3">
                    <span class="text-sm text-mint-light">3ezzy</span>
                    <div class="relative">
                        <img src="https://ui-avatars.com/api/?name=3ezzy&background=05BFDB&color=0A4D68" 
                             alt="Profile" 
                             class="w-8 h-8 rounded-full border-2 border-mint">
                        <div class="absolute -bottom-1 -right-1 w-3 h-3 bg-mint-light rounded-full border-2 border-primary"></div>
                    </div>
                </div>
                
                <!-- Settings -->
                <button class="p-2 rounded-full hover:bg-secondary transition duration-150">
                    <i class="fas fa-cog text-mint"></i>
                </button>
            </div>
        </div>
    </div>
</nav>