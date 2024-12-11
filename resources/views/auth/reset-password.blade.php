<x-guest-layout>
    <div class="w-full sm:max-w-md px-6 py-8 bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
        <x-validation-errors class="mb-4 text-red-400" />

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div class="block">
                <x-label for="email" value="{{ __('Email') }}" class="text-gray-300" />
                <x-input 
                    id="email" 
                    class="block mt-1 w-full bg-gray-700 border-gray-600 text-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" 
                    type="email" 
                    name="email" 
                    :value="old('email', $request->email)" 
                    required 
                    autofocus 
                    autocomplete="username" 
                />
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('Password') }}" class="text-gray-300" />
                <x-input 
                    id="password" 
                    class="block mt-1 w-full bg-gray-700 border-gray-600 text-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" 
                    type="password" 
                    name="password" 
                    required 
                    autocomplete="new-password" 
                />
            </div>

            <div class="mt-4">
                <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" class="text-gray-300" />
                <x-input 
                    id="password_confirmation" 
                    class="block mt-1 w-full bg-gray-700 border-gray-600 text-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" 
                    type="password" 
                    name="password_confirmation" 
                    required 
                    autocomplete="new-password" 
                />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button class="bg-indigo-600 hover:bg-indigo-700 text-white">
                    {{ __('Reset Password') }}
                </x-button>
            </div>
        </form>
    </div>
</x-guest-layout>