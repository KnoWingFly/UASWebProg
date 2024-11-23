@extends('layouts.admin')

@section('content')

<div class="p-6 space-y-6 bg-gray-900">
    <h1 class="text-2xl font-semibold text-gray-200">Create Event</h1>

    <!-- Error Messages -->
    @if ($errors->any())
        <div class="bg-red-500 text-white px-4 py-3 rounded-lg">
            <strong>Whoops! Something went wrong:</strong>
            <ul class="mt-2">
                @foreach ($errors->all() as $error)
                    <li>- {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Flash Messages -->
    @if (session('error'))
        <div class="bg-red-500 text-white px-4 py-3 rounded-lg">
            {{ session('error') }}
        </div>
    @endif

    @if (session('success'))
        <div class="bg-green-500 text-white px-4 py-3 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <!-- Event Creation Form -->
    <form 
        action="{{ route('admin.events.store') }}" 
        method="POST" 
        enctype="multipart/form-data" 
        class="space-y-6"
        id="create-event-form"
    >
        @csrf

        <!-- Event Name -->
        <div>
            <label class="block text-gray-400 font-medium mb-2">Event Name</label>
            <input 
                type="text" 
                name="name" 
                class="w-full px-4 py-2 rounded-lg bg-gray-800 border border-gray-600 text-gray-200 placeholder-gray-500 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                required 
                placeholder="Enter event name"
                value="{{ old('name') }}"
            >
        </div>

        <!-- Description -->
        <div>
            <label class="block text-gray-400 font-medium mb-2">Description</label>
            <textarea 
                name="description" 
                rows="4" 
                class="w-full px-4 py-2 rounded-lg bg-gray-800 border border-gray-600 text-gray-200 placeholder-gray-500 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                placeholder="Write a brief description"
            >{{ old('description') }}</textarea>
        </div>

        <!-- Participant Limit -->
        <div>
            <label class="block text-gray-400 font-medium mb-2">Participant Limit</label>
            <input 
                type="number" 
                name="participant_limit" 
                class="w-full px-4 py-2 rounded-lg bg-gray-800 border border-gray-600 text-gray-200 placeholder-gray-500 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                min="1" 
                placeholder="Enter participant limit"
                value="{{ old('participant_limit') }}"
            >
        </div>

        <!-- Event Date/Time Section -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- Event Start -->
    <div class="space-y-4">
        <label class="block text-gray-400 font-medium">Event Start</label>
        <div>
            <label class="text-sm text-gray-500 mb-1 block">Date</label>
            <input 
                type="date" 
                name="event_start_date" 
                class="w-full px-4 py-2 rounded-lg bg-gray-800 border border-gray-600 text-gray-200 placeholder-gray-500 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                value="{{ old('event_start_date') }}" 
                required
            >
        </div>
        <div>
            <label class="text-sm text-gray-500 mb-1 block">Time</label>
            <input 
                type="time" 
                name="event_start_time" 
                class="w-full px-4 py-2 rounded-lg bg-gray-800 border border-gray-600 text-gray-200 placeholder-gray-500 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                value="{{ old('event_start_time') }}" 
                required
            >
        </div>
    </div>

    <!-- Event End -->
    <div class="space-y-4">
        <label class="block text-gray-400 font-medium">Event End</label>
        <div>
            <label class="text-sm text-gray-500 mb-1 block">Date</label>
            <input 
                type="date" 
                name="event_end_date" 
                class="w-full px-4 py-2 rounded-lg bg-gray-800 border border-gray-600 text-gray-200 placeholder-gray-500 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                value="{{ old('event_end_date') }}" 
                required
            >
        </div>
        <div>
            <label class="text-sm text-gray-500 mb-1 block">Time</label>
            <input 
                type="time" 
                name="event_end_time" 
                class="w-full px-4 py-2 rounded-lg bg-gray-800 border border-gray-600 text-gray-200 placeholder-gray-500 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                value="{{ old('event_end_time') }}" 
                required
            >
        </div>
    </div>
</div>


        <!-- Banner Dropzone -->
<div>
    <label class="block text-gray-400 font-medium mb-2">Event Banner</label>
    <div id="dropzone-container" class="relative flex items-center justify-center w-full h-64 border-2 border-dashed border-gray-600 bg-gray-700 rounded-lg cursor-pointer">
        <!-- File Input -->
        <input 
            id="dropzone-file" 
            type="file" 
            name="banner" 
            class="absolute inset-0 opacity-0 cursor-pointer" 
            accept="image/*" 
            onchange="handleFileChange(event)" 
            required
        >

        <!-- Preview Container -->
        <div id="dropzone-preview" class="absolute inset-0 hidden">
            <img id="dropzone-image" class="w-full h-full object-cover rounded-lg">
        </div>

        <!-- Placeholder Content -->
        <div id="dropzone-placeholder" class="flex flex-col items-center justify-center text-center">
            <p class="text-sm text-gray-400">Drag and drop an image here, or click to upload</p>
            <p class="text-xs text-gray-500">JPG, PNG, or GIF up to 2MB</p>
        </div>
    </div>
    @error('banner')
        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
    @enderror
</div>



        <!-- Submit Button -->
        <div class="text-right">
            <button 
                type="submit" 
                class="px-6 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:outline-none transition-colors duration-200"
            >
                Create Event
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const dropzoneFile = document.getElementById('dropzone-file');
    const dropzonePlaceholder = document.getElementById('dropzone-placeholder');
    const dropzonePreview = document.getElementById('dropzone-preview');
    const dropzoneImage = document.getElementById('dropzone-image');

    // Handle file input change
    dropzoneFile.addEventListener('change', function () {
        const file = this.files[0];

        if (file) {
            // Validate file type
            const validTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/svg+xml'];
            if (!validTypes.includes(file.type)) {
                alert('Invalid file type. Please select a valid image (JPG, PNG, GIF, or SVG).');
                this.value = ''; // Reset the file input
                return;
            }

            // Use FileReader to preview the image
            const reader = new FileReader();
            reader.onload = function (e) {
                dropzoneImage.src = e.target.result; // Set the image src to the file data
                dropzonePreview.classList.remove('hidden'); // Show the preview container
                dropzonePlaceholder.classList.add('hidden'); // Hide the placeholder
            };
            reader.readAsDataURL(file);
        } else {
            // Reset the preview if no file is selected
            dropzonePreview.classList.add('hidden');
            dropzonePlaceholder.classList.remove('hidden');
            dropzoneImage.src = ''; // Clear the image src
        }
    });
});

</script>
@endpush
@endsection
