<x-guest-layout>
    <div class="w-full sm:max-w-md px-6 py-8 bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
        <div class="mb-4 text-sm text-gray-300">
            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
        </div>

        @session('status')
            <div class="mb-4 font-medium text-sm text-green-400">
                {{ $value }}
            </div>
        @endsession

        <x-validation-errors class="mb-4 text-red-400" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="block">
                <x-label for="email" value="{{ __('Email') }}" class="text-gray-300" />
                <x-input 
                    id="email" 
                    class="block mt-1 w-full bg-gray-700 border-gray-600 text-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" 
                    type="email" 
                    name="email" 
                    :value="old('email')" 
                    required 
                    autofocus 
                    autocomplete="username" 
                />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button class="bg-indigo-600 hover:bg-indigo-700 text-white">
                    {{ __('Email Password Reset Link') }}
                </x-button>
            </div>
        </form>
    </div>
</x-guest-layout>