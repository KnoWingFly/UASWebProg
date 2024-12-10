<aside id="sidebar"
    class="fixed top-0 left-0 z-40 w-64 h-full bg-gray-800 transform -translate-x-full transition-transform duration-300 ease-in-out">
    <div class="p-5">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-bold text-gray-100">Admin Panel</h2>
            <button id="closeSidebar" class="text-gray-300 hover:text-white">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
        </div>

        <!-- Navigation -->
        <ul class="mt-6 space-y-2">
            <!-- Dashboard link -->
            <li>
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center p-2 text-sm font-medium text-gray-300 rounded-lg hover:bg-gray-700">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 10h11M9 21H5a2 2 0 01-2-2v-5m16 5h-4m0 0a2 2 0 002-2v-5a2 2 0 00-2-2h-4m-6 0a2 2 0 00-2-2V7a2 2 0 012-2h6a2 2 0 012 2v1">
                        </path>
                    </svg>
                    Dashboard
                </a>
            </li>

            <!-- Manage user link -->
            <li>
                <a href="{{ route('admin.users.manage') }}"
                    class="flex items-center p-2 text-sm font-medium text-gray-300 rounded-lg hover:bg-gray-700">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 10h.01M12 10h.01M16 10h.01M9 21h6a2 2 0 002-2v-4H7v4a2 2 0 002 2zm2-7a2 2 0 10-4 0 2 2 0 004 0zm4 0a2 2 0 10-4 0 2 2 0 004 0z">
                        </path>
                    </svg>
                    Manage Users
                </a>
            </li>
            <li>
                <a href="{{ route('admin.events.index') }}"
                    class="flex items-center p-2 text-sm font-medium text-gray-300 rounded-lg hover:bg-gray-700">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4m0 0v4m0-4h4m-4 0H8"></path>
                    </svg>
                    Manage Events
                </a>
            </li>
              <!-- Activity history -->
            <li>
                <a href="{{ route('admin.activity-history.index') }}"
                    class="flex items-center p-2 text-sm font-medium text-gray-300 rounded-lg hover:bg-gray-700">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z">
                        </path>
                        <circle cx="12" cy="12" r="1"></circle>
                    </svg>
                    Activity History
                </a>
            </li>

            <!-- Learning Materials link -->
            <li>
                <a href="{{ route('admin.materials.index') }}"
                    class="flex items-center p-2 text-sm font-medium text-gray-300 rounded-lg hover:bg-gray-700">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                        </path>
                    </svg>
                    Learning Materials
                </a>
            </li>

            <!-- logout -->
            <div class="mt-6 border-t border-gray-700 pt-4">
                <a href="{{ route('logout') }}"
                    class="flex items-center p-2 text-sm font-medium text-red-400 rounded-lg hover:bg-gray-700">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 11-4 0v-1m4-8V7a2 2 0 10-4 0v1"></path>
                    </svg>
                    Log Out
                </a>
            </div>
    </div>
</aside>
