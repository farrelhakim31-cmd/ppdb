<header class="bg-white shadow-sm border-b">
    <div class="max-w-6xl mx-auto px-4 py-4 flex justify-between items-center">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
                <i class="fas fa-graduation-cap text-white"></i>
            </div>
            <a href="{{ route('home') }}" class="text-xl font-semibold text-gray-900 hover:text-blue-600 transition-colors">
                PPDB Online
            </a>
        </div>
        
        <nav class="hidden md:flex items-center space-x-6">
            <a href="{{ route('home') }}" class="text-gray-600 hover:text-blue-600 transition-colors">Beranda</a>
            <a href="{{ route('ppdb.index') }}" class="text-gray-600 hover:text-blue-600 transition-colors">Info PPDB</a>
            
            @auth
                <div class="flex items-center space-x-4">
                    <span class="text-gray-600">{{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}" class="inline" id="logoutForm">
                        @csrf
                        <button type="button" class="text-red-600 hover:text-red-700 transition-colors" onclick="confirmLogout()">
                            <i class="fas fa-sign-out-alt"></i>
                        </button>
                    </form>
                </div>
            @else
                <a href="{{ route('login') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                    Login
                </a>
            @endauth
        </nav>
        
        <!-- Mobile menu button -->
        <button class="md:hidden p-2" onclick="toggleMobileMenu()">
            <i class="fas fa-bars text-gray-600"></i>
        </button>
    </div>
    
    <!-- Mobile menu -->
    <div id="mobile-menu" class="hidden md:hidden border-t border-gray-200 bg-white">
        <div class="px-4 py-3 space-y-2">
            <a href="{{ route('home') }}" class="block text-gray-600 hover:text-blue-600 transition-colors py-2">Beranda</a>
            <a href="{{ route('ppdb.index') }}" class="block text-gray-600 hover:text-blue-600 transition-colors py-2">Info PPDB</a>
            @auth
                <div class="border-t border-gray-200 pt-2">
                    <span class="block text-gray-600 py-2">{{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}" id="logoutFormMobile">
                        @csrf
                        <button type="button" class="block text-red-600 hover:text-red-700 transition-colors py-2" onclick="confirmLogoutMobile()">
                            Logout
                        </button>
                    </form>
                </div>
            @else
                <a href="{{ route('login') }}" class="block bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors text-center">
                    Login
                </a>
            @endauth
        </div>
    </div>
</header>

<script>
function toggleMobileMenu() {
    const menu = document.getElementById('mobile-menu');
    menu.classList.toggle('hidden');
}

function confirmLogout() {
    if (confirm('Anda yakin ingin keluar dari halaman ini?')) {
        document.getElementById('logoutForm').submit();
    }
}

function confirmLogoutMobile() {
    if (confirm('Anda yakin ingin keluar dari halaman ini?')) {
        document.getElementById('logoutFormMobile').submit();
    }
}
</script>