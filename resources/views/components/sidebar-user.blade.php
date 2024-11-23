<aside id="sidebar"
    class="fixed top-0 left-0 z-40 w-64 h-full bg-gray-800 transform -translate-x-full transition-transform duration-300 ease-in-out">
    <div class="p-5">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-bold text-gray-100">UMN PC</h2>
            <button id="closeSidebar" class="text-gray-300 hover:text-white">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- Navigation -->
        <ul class="mt-6 space-y-2">
            <li>
                <a href="{{ route('user.profile') }}" class="flex items-center p-2 text-sm font-medium text-gray-300 rounded-lg hover:bg-gray-700">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h11M9 21H5a2 2 0 01-2-2v-5m16 5h-4m0 0a2 2 0 002-2v-5a2 2 0 00-2-2h-4m-6 0a2 2 0 00-2-2V7a2 2 0 012-2h6a2 2 0 012 2v1"></path>
                    </svg>
                    Profile
                </a>
            </li>
            <li>
                <a href="{{ route('user.events') }}" class="flex items-center p-2 text-sm font-medium text-gray-300 rounded-lg hover:bg-gray-700">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v8m4-4H8"></path>
                    </svg>
                    Events
                </a>
            </li>
            <li>
        </ul>

        <!-- Logout -->
        <div class="mt-6 border-t border-gray-700 pt-4">
            <a href="{{ route('logout') }}" class="flex items-center p-2 text-sm font-medium text-red-400 rounded-lg hover:bg-gray-700">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 11-4 0v-1m4-8V7a2 2 0 10-4 0v1"></path>
                </svg>
                Log Out
            </a>
        </div>
    </div>
</aside>
