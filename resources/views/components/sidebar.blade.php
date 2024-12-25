<aside id="sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen bg-[#1a1a1a] transform -translate-x-full 
    transition-transform duration-300 ease-out shadow-lg">
    <div class="flex flex-col h-full">
        <!-- Header -->
        <div class="p-5 border-b border-gray-800">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-bold text-[#ff4d4d] tracking-wide">Admin Panel</h2>
                <button id="closeSidebar" class="text-gray-400 hover:text-[#ff4d4d] transition-colors duration-200 
                    focus:outline-none transform hover:rotate-180 transition-transform duration-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 overflow-y-auto py-4">
            <ul class="space-y-2 px-3" id="nav-items">
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center p-3 text-gray-300 rounded-lg hover:bg-[#ff4d4d]/10 
                        hover:text-[#ff4d4d] transition-all duration-200 group">
                        <svg class="w-5 h-5 mr-3 transition-transform duration-300 group-hover:rotate-6" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 10h11M9 21H5a2 2 0 01-2-2v-5m16 5h-4m0 0a2 2 0 002-2v-5a2 2 0 00-2-2h-4m-6 0a2 2 0 00-2-2V7a2 2 0 012-2h6a2 2 0 012 2v1">
                            </path>
                        </svg>
                        <span class="font-medium">Dashboard</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.users.manage') }}" class="flex items-center p-3 text-gray-300 rounded-lg hover:bg-[#ff4d4d]/10 
                        hover:text-[#ff4d4d] transition-all duration-200 group">
                        <svg class="w-5 h-5 mr-3 transition-transform duration-300 group-hover:rotate-6" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 10h.01M12 10h.01M16 10h.01M9 21h6a2 2 0 002-2v-4H7v4a2 2 0 002 2zm2-7a2 2 0 10-4 0 2 2 0 004 0zm4 0a2 2 0 10-4 0 2 2 0 004 0z">
                            </path>
                        </svg>
                        <span class="font-medium">Manage Users</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.events.index') }}" class="flex items-center p-3 text-gray-300 rounded-lg hover:bg-[#ff4d4d]/10 
                        hover:text-[#ff4d4d] transition-all duration-200 group">
                        <svg class="w-5 h-5 mr-3 transition-transform duration-300 group-hover:rotate-6" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 0v4m0-4h4m-4 0H8"></path>
                        </svg>
                        <span class="font-medium">Manage Events</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.activity-history.index') }}" class="flex items-center p-3 text-gray-300 rounded-lg hover:bg-[#ff4d4d]/10 
                        hover:text-[#ff4d4d] transition-all duration-200 group">
                        <svg class="w-5 h-5 mr-3 transition-transform duration-300 group-hover:rotate-6" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z">
                            </path>
                            <circle cx="12" cy="12" r="1"></circle>
                        </svg>
                        <span class="font-medium">Activity History</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.materials.index') }}" class="flex items-center p-3 text-gray-300 rounded-lg hover:bg-[#ff4d4d]/10 
                        hover:text-[#ff4d4d] transition-all duration-200 group">
                        <svg class="w-5 h-5 mr-3 transition-transform duration-300 group-hover:rotate-6" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                            </path>
                        </svg>
                        <span class="font-medium">Learning Materials</span>
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Logout Section -->
        <div class="p-4 border-t border-gray-800">
            <a href="{{ route('logout') }}" class="flex items-center p-3 text-[#ff4d4d] rounded-lg hover:bg-[#ff4d4d]/10 
                transition-all duration-200 group">
                <svg class="w-5 h-5 mr-3 transition-transform duration-300 group-hover:translate-x-1" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 11-4 0v-1m4-8V7a2 2 0 10-4 0v1">
                    </path>
                </svg>
                <span class="font-medium">Log Out</span>
            </a>
        </div>
    </div>
</aside>
<script type="module">
    // Wait for GSAP to be loaded
    window.addEventListener('load', () => {
        const sidebar = document.getElementById('sidebar');
        const closeSidebar = document.getElementById('closeSidebar');
        const navItems = document.querySelectorAll('.nav-item');

        function openSidebar() {
            sidebar.classList.remove('-translate-x-full');
            sidebar.classList.add('translate-x-0');

            if (window.gsap) {
                // Stagger animation for nav items
                gsap.from(navItems, {
                    x: -50,
                    opacity: 0,
                    duration: 0.4,
                    stagger: 0.1,
                    ease: 'power2.out',
                    delay: 0.2
                });
            }
        }

        function closeSidebarAnim() {
            sidebar.classList.remove('translate-x-0');
            sidebar.classList.add('-translate-x-full');
        }

        // Event listeners
        closeSidebar.addEventListener('click', closeSidebarAnim);

        // Click outside to close
        document.addEventListener('click', (e) => {
            if (!sidebar.contains(e.target) &&
                !document.getElementById('hamburger')?.contains(e.target) &&
                !sidebar.classList.contains('-translate-x-full')) {
                closeSidebarAnim();
            }
        });

        // Highlight active route
        const currentPath = window.location.pathname;
        navItems.forEach(item => {
            const link = item.querySelector('a');
            if (link.getAttribute('href') === currentPath) {
                link.classList.add('bg-[#ff4d4d]/10', 'text-[#ff4d4d]');
            }
        });
    });
</script>
