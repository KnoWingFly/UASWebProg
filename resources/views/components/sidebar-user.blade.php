<aside id="sidebar"
    class="fixed top-0 left-0 z-40 w-64 h-full bg-gray-800 transform -translate-x-full transition-transform duration-300 ease-in-out">
    <div class="p-5">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-bold text-gray-100">UMN PC</h2>
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
            <li>
                <a href="{{ route('user.dashboard') }}"
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
            <li>
                <a href="{{ route('user.events') }}"
                    class="flex items-center p-2 text-sm font-medium text-gray-300 rounded-lg hover:bg-gray-700">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                    </svg>
                    Events
                </a>
            </li>
            <li>
                <a href="{{ route('user.categories.index') }}"
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
            <li>
                <!-- New Profile Option -->
                <a href="{{ route('user.profile.index') }}"
                    class="flex items-center p-2 text-sm font-medium text-gray-300 rounded-lg hover:bg-gray-700">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5.121 17.804A2.5 2.5 0 0 1 7.5 17h9a2.5 2.5 0 0 1 2.379 3.224 9.005 9.005 0 0 1-16.758 0zM12 13a5 5 0 1 0 0-10 5 5 0 0 0 0 10z">
                        </path>
                    </svg>
                    Profile
                </a>
            </li>
        </ul>

        <!-- Logout -->
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
