@extends('layouts.user')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-md mx-auto">
        <h1 class="text-2xl font-bold mb-6">Edit Profile</h1>

        <form 
            action="{{ route('profile.update') }}" 
            method="POST" 
            enctype="multipart/form-data"
            class="bg-gray-800 p-6 rounded-lg"
        >
            @csrf
            @method('PUT')

            
            <!-- Profile Photo Upload -->
            <div class="mb-4">
                <label class="block text-gray-300 mb-2">Profile Photo</label>
                <div class="flex items-center space-x-4">
                    <img 
                        src="{{ Auth::user()->avatar ?: 'default-avatar.png' }}" 
                        id="preview-avatar"
                        class="w-24 h-24 rounded-full object-cover"
                 >
                    <input 
                        type="file" 
                        name="avatar" 
                        id="avatar-upload" 
                        accept="image/*" 
                        class="hidden"
                        onchange="previewAvatar(event)"
                    >
                    <button 
                        type="button" 
                        onclick="document.getElementById('avatar-upload').click()"
                        class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded"
                    >
                        Change Photo
                    </button>
                </div>
                @error('avatar')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Name Field -->
            <div class="mb-4">
                <label class="block text-gray-300 mb-2">Name</label>
                <input 
                    type="text" 
                    name="name" 
                    value="{{ old('name', Auth::user()->name) }}"
                    class="w-full bg-gray-700 text-white rounded px-3 py-2 @error('name') border-red-500 @enderror"
                >
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email Field -->
            <div class="mb-4">
                <label class="block text-gray-300 mb-2">Email</label>
                <input 
                    type="email" 
                    name="email" 
                    value="{{ old('email', Auth::user()->email) }}"
                    class="w-full bg-gray-700 text-white rounded px-3 py-2 @error('email') border-red-500 @enderror"
                >
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Current Password Field -->
            <div class="mb-4">
                <label class="block text-gray-300 mb-2">Current Password</label>
                <input 
                    type="password" 
                    name="current_password" 
                    class="w-full bg-gray-700 text-white rounded px-3 py-2 @error('current_password') border-red-500 @enderror"
                    placeholder="Enter current password to confirm changes"
                >
                @error('current_password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- New Password Field -->
            <div class="mb-4">
                <label class="block text-gray-300 mb-2">New Password (optional)</label>
                <input 
                    type="password" 
                    name="new_password" 
                    class="w-full bg-gray-700 text-white rounded px-3 py-2 @error('new_password') border-red-500 @enderror"
                    placeholder="Leave blank if not changing"
                >
                @error('new_password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Confirm New Password Field -->
            <div class="mb-4">
                <label class="block text-gray-300 mb-2">Confirm New Password</label>
                <input 
                    type="password" 
                    name="new_password_confirmation" 
                    class="w-full bg-gray-700 text-white rounded px-3 py-2"
                    placeholder="Confirm new password"
                >
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end">
                <button 
                    type="submit" 
                    class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded"
                >
                    Update Profile
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function previewAvatar(event) {
        const file = event.target.files[0];
        const preview = document.getElementById('preview-avatar');
        
        if (file) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                preview.src = e.target.result;
            }
            
            reader.readAsDataURL(file);
        }
    }
</script>

@endsection