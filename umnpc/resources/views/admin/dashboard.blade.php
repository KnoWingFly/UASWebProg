<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Welcome, {{ Auth::user()->name }}</h3>

                <!-- Admin Navigation -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Manage Users -->
                    <a href="{{ route('admin.users.index') }}"
                       class="block bg-blue-600 text-white text-center font-medium py-3 px-4 rounded-lg hover:bg-blue-700">
                        Manage Users
                    </a>

                    <!-- Logout -->
                    <form method="POST" action="{{ route('logout') }}" class="block">
                        @csrf
                        <button type="submit"
                                class="w-full bg-red-600 text-white text-center font-medium py-3 px-4 rounded-lg hover:bg-red-700">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
