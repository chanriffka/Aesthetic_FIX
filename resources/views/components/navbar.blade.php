<nav class="bg-white shadow-lg sticky top-0 z-50" x-data="{ open: false, hover: null }">
    <div class="container mx-auto px-6 py-4 flex justify-between items-center">
        <!-- Logo Section -->
        <div class="text-3xl font-semibold italic text-gray-800">
            <a href="#" class="hover:no-underline">
                <img src="images/aestheticlogo.png" alt="Aesthetic Logo" class="h-12">
            </a>
        </div>
        <!-- Hamburger Menu Button (for mobile) -->
        <div class="block lg:hidden">
            <button @click="open = !open" class="text-gray-700 focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>
        <!-- Navigation Links with custom font -->
        <ul class="nav-links hidden lg:flex space-x-9 text-gray-700 custom-header-font">
            <li class="nav-item">
                <a href="{{ url('/landing2') }}" class="{{ request()->is('landing2') ? 'navbar-active' : '' }} hover:text-indigo-600">HOME</a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/explore') }}" class="{{ request()->is('explore') ? 'navbar-active' : '' }} hover:text-indigo-600">EXPLORE</a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/artists') }}" class="{{ request()->is('artists') ? 'navbar-active' : '' }} hover:text-indigo-600">ARTIST</a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/art-gallery') }}" class="{{ request()->is('art-gallery') ? 'navbar-active' : '' }} hover:text-indigo-600">ART GALLERY</a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/auction') }}" class="{{ request()->is('auction') ? 'navbar-active' : '' }} hover:text-indigo-600">AUCTION</a>
            </li>
        </ul>
        
        <!-- Sign In & Join Button -->
        <div class="hidden lg:flex items-center custom-header-font">
            <a href="#"
                :class="hover === 'signin' ? 'bg-indigo-600 text-white' : 'text-gray-700 hover:bg-indigo-600 hover:text-white'"
                @mouseenter="hover = 'signin'" @mouseleave="hover = null"
                class="mr-4 px-6 py-2 rounded-md transition">SIGN IN</a>
        
            <a href="#"
                :class="hover === 'join' || hover === null ? 'bg-indigo-600 text-white' : 'text-gray-700 hover:bg-indigo-600 hover:text-white'"
                @mouseenter="hover = 'join'" @mouseleave="hover = null"
                class="px-6 py-2 rounded-md transition">JOIN</a>
        </div>
        
    </div>
 
    <!-- Mobile Menu -->
    <div x-show="open" class="lg:hidden nav-links bg-white w-full py-4">
        <ul class="space-y-4 text-center text-gray-700 custom-header-font">
            <li><a href="#" class="block hover:text-indigo-600 transition">HOME</a></li>
            <li><a href="#" class="block hover:text-indigo-600 transition">EXPLORE</a></li>
            <li><a href="#" class="block hover:text-indigo-600 transition">ARTIST</a></li>
            <li><a href="#" class="block hover:text-indigo-600 transition">ART GALLERY</a></li>
            <li><a href="#" class="block hover:text-indigo-600 transition">AUCTION</a></li>
            <li><a href="#" class="block text-gray-700 hover:text-indigo-600">SIGN IN</a></li>
            <li><a href="#" class="block bg-indigo-600 text-white px-6 py-2 rounded-full hover:bg-indigo-700 transition">JOIN</a></li>
        </ul>
    </div>
</nav>