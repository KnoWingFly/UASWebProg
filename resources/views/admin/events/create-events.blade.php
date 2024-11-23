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
    <form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6" id="create-event-form">
        @csrf

        <!-- Event Name -->
        <div>
            <label class="block text-gray-400 font-medium mb-2">Event Name</label>
            <input type="text" name="name"
                class="w-full px-4 py-2 rounded-lg bg-gray-800 border border-gray-600 text-gray-200 placeholder-gray-500 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                required placeholder="Enter event name" value="{{ old('name') }}">
        </div>

        <!-- Description -->
        <div>
            <label class="block text-gray-400 font-medium mb-2">Description</label>
            <textarea name="description" rows="4"
                class="w-full px-4 py-2 rounded-lg bg-gray-800 border border-gray-600 text-gray-200 placeholder-gray-500 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                placeholder="Write a brief description">{{ old('description') }}</textarea>
        </div>

        <!-- Participant Limit -->
        <div>
            <label class="block text-gray-400 font-medium mb-2">Participant Limit</label>
            <input type="number" name="participant_limit"
                class="w-full px-4 py-2 rounded-lg bg-gray-800 border border-gray-600 text-gray-200 placeholder-gray-500 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                min="1" placeholder="Enter participant limit" value="{{ old('participant_limit') }}">
        </div>

        <!-- Event Date/Time Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Event Start -->
            <div class="space-y-4">
                <label class="block text-gray-400 font-medium">Event Start</label>
                <div>
                    <label class="text-sm text-gray-500 mb-1 block">Date</label>
                    <input type="date" name="event_start_date" id="event_start_date"
                        class="w-full px-4 py-2 rounded-lg bg-gray-800 border border-gray-600 text-gray-200 placeholder-gray-500 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        value="{{ old('event_start_date') }}" required>
                </div>
                <div>
                    <label class="text-sm text-gray-500 mb-1 block">Time</label>
                    <input type="time" name="event_start_time" id="event_start_time"
                        class="w-full px-4 py-2 rounded-lg bg-gray-800 border border-gray-600 text-gray-200 placeholder-gray-500 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        value="{{ old('event_start_time') }}" required>
                </div>
            </div>

            <!-- Event End -->
            <div class="space-y-4">
                <label class="block text-gray-400 font-medium">Event End</label>
                <div>
                    <label class="text-sm text-gray-500 mb-1 block">Date</label>
                    <input type="date" name="event_end_date" id="event_end_date"
                        class="w-full px-4 py-2 rounded-lg bg-gray-800 border border-gray-600 text-gray-200 placeholder-gray-500 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        value="{{ old('event_end_date') }}" required>
                </div>
                <div>
                    <label class="text-sm text-gray-500 mb-1 block">Time</label>
                    <input type="time" name="event_end_time" id="event_end_time"
                        class="w-full px-4 py-2 rounded-lg bg-gray-800 border border-gray-600 text-gray-200 placeholder-gray-500 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        value="{{ old('event_end_time') }}" required>
                </div>
            </div>
        </div>

        <!-- Banner input -->
        <div>
            <label class="block text-gray-400 font-medium mb-2">Event Banner</label>
            <div id="dropzone-container" class="relative w-full h-96 border-2 border-dashed border-gray-600 bg-gray-700 rounded-lg cursor-pointer hover:border-gray-500 transition-colors duration-200">
                <div class="absolute inset-0 flex flex-col items-center justify-center p-4 mt-5">
                    <img id="preview-image" src="" alt="Preview" class="max-h-48 max-w-[90%] object-contain mb-4 hidden">
                    <div id="dropzone-placeholder" class="text-center mt-2">
                        <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                            <path d="M28 8H12a4 4 0 00-4 4v20m0 0v4a4 4 0 004 4h20a4 4 0 004-4V28m-4-20v4m0 0v4m0-4h4m-4 0h-4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <p class="text-sm text-gray-400 font-medium">Drag and drop an image here, or click to upload</p>
                        <p class="text-xs text-gray-500 mt-2">JPG, PNG, or GIF up to 2MB</p>
                    </div>
                </div>
                <input id="dropzone-file" type="file" name="banner"
                    class="absolute inset-0 opacity-0 cursor-pointer z-20" accept="image/*" required>
            </div>
            @error('banner')
                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
            @enderror
        </div>

        <!-- Submit Button -->
        <div class="text-right">
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:outline-none transition-colors duration-200">
                Create Event
            </button>
        </div>
    </form>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Date and time elements
    const startDateInput = document.querySelector('input[name="event_start_date"]');
    const startTimeInput = document.querySelector('input[name="event_start_time"]');
    const endDateInput = document.querySelector('input[name="event_end_date"]');
    const endTimeInput = document.querySelector('input[name="event_end_time"]');

    // Dropzone elements
    const dropzoneFile = document.getElementById('dropzone-file');
    const previewImage = document.getElementById('preview-image');
    const placeholder = document.getElementById('dropzone-placeholder');
    const placeholderSvg = placeholder.querySelector('svg');
    const placeholderText = Array.from(placeholder.querySelectorAll('p'));
    const dropzoneContainer = document.getElementById('dropzone-container');

    // Utility function to validate date format (YYYY-MM-DD)
    function isValidDate(date) {
        return /^\d{4}-\d{2}-\d{2}$/.test(date);
    }

    // Utility function to validate time format (HH:MM)
    function isValidTime(time) {
        return /^([01]\d|2[0-3]):([0-5]\d)$/.test(time);
    }

    // Utility function for date formatting
    function formatDate(date) {
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const day = String(date.getDate()).padStart(2, '0');
        return `${year}-${month}-${day}`;
    }

    // Utility function for time formatting
    function formatTime(date) {
        const hours = String(date.getHours()).padStart(2, '0');
        const minutes = String(date.getMinutes()).padStart(2, '0');
        return `${hours}:${minutes}`;
    }

    // Set current date and time restrictions
    const now = new Date();
    const currentDate = formatDate(now);

    startDateInput.setAttribute('min', currentDate);
    endDateInput.setAttribute('min', currentDate);

    // Update the min value for end date and time based on start date and time
    function updateEndDateAndTime() {
        if (isValidDate(startDateInput.value) && isValidTime(startTimeInput.value)) {
            const startDateTime = new Date(`${startDateInput.value}T${startTimeInput.value}`);
            let endDateTime;

            // If the start date and time are on the same day, set end time to +1 hour
            if (startDateTime.toDateString() === new Date().toDateString()) {
                endDateTime = new Date(startDateTime.getTime() + 60 * 60 * 1000); // 1 hour after start time
            } else {
                endDateTime = new Date(startDateTime.getTime() + 30 * 60 * 1000); // 30 minutes after start time
            }

            endDateInput.setAttribute('min', startDateInput.value);
            endTimeInput.setAttribute('min', formatTime(endDateTime));
        }
    }

    // Handle keyboard input for time fields
    function handleTimeInput(input) {
        let value = input.value.replace(/[^\d:]/g, '');

        if (value.length === 2 && !value.includes(':')) {
            value += ':';
        }

        if (value.length >= 4) {
            if (!value.includes(':')) {
                value = value.slice(0, 2) + ':' + value.slice(2);
            }

            const [hours, minutes] = value.split(':');
            const hoursNum = parseInt(hours, 10);
            const minutesNum = parseInt(minutes, 10);

            if (hoursNum >= 0 && hoursNum < 24 && minutesNum >= 0 && minutesNum < 60) {
                input.value = `${String(hoursNum).padStart(2, '0')}:${String(minutesNum).padStart(2, '0')}`;
            }
        }
    }

    // Event listeners for start and end date inputs
    startDateInput.addEventListener('input', updateEndDateAndTime);

    startTimeInput.addEventListener('input', function () {
        handleTimeInput(this);
        updateEndDateAndTime();
    });

    startTimeInput.addEventListener('blur', function () {
        if (!isValidTime(this.value)) {
            alert('Please enter a valid start time (HH:MM)');
            this.value = '';
        }
        updateEndDateAndTime();
    });

    endDateInput.addEventListener('input', function () {
        if (!isValidDate(this.value)) {
            alert('Please enter a valid end date (YYYY-MM-DD)');
            this.value = '';
        }
    });

    endTimeInput.addEventListener('input', function () {
        handleTimeInput(this);
    });

    endTimeInput.addEventListener('blur', function () {
        if (!isValidTime(this.value)) {
            alert('Please enter a valid end time (HH:MM)');
            this.value = '';
        }
    });

    // Dropzone functionality
    function handleFileSelect(file) {
        if (file) {
            const validTypes = ['image/jpeg', 'image/png', 'image/gif'];
            if (!validTypes.includes(file.type)) {
                alert('Please select a valid image file (JPG, PNG, or GIF)');
                return;
            }

            const reader = new FileReader();
            reader.onload = function (e) {
                previewImage.src = e.target.result;
                previewImage.classList.remove('hidden');
                placeholderSvg.classList.add('hidden');
                placeholderText.forEach(text => text.classList.add('opacity-30'));
            };

            reader.readAsDataURL(file);
        } else {
            previewImage.src = '';
            previewImage.classList.add('hidden');
            placeholderSvg.classList.remove('hidden');
            placeholderText.forEach(text => text.classList.remove('opacity-30'));
        }
    }

    dropzoneFile.addEventListener('change', function () {
        const file = this.files[0];
        handleFileSelect(file);
    });

    // Prevent default drag behaviors
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropzoneContainer.addEventListener(eventName, function (e) {
            e.preventDefault();
            e.stopPropagation();
        });
    });

    // Handle drag and drop
    dropzoneContainer.addEventListener('dragenter', function () {
        this.classList.add('border-blue-500');
    });

    dropzoneContainer.addEventListener('dragleave', function () {
        this.classList.remove('border-blue-500');
    });

    dropzoneContainer.addEventListener('drop', function (e) {
        this.classList.remove('border-blue-500');
        const file = e.dataTransfer.files[0];
        dropzoneFile.files = e.dataTransfer.files;
        handleFileSelect(file);
    });
});
</script>
@endsection