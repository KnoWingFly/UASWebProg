@extends('layouts.user')

@section('content')

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
</head>

<body class="bg-gray-900 text-white" x-data="profileManager()">
    <div class="max-w-4xl mx-auto py-10 relative">
        <!-- Header -->
        <div class="flex flex-col items-center mb-10">
            <!-- Profile Picture -->
            <div class="w-32 h-32 bg-gray-500 rounded-full overflow-hidden relative">
                <img src="{{ Auth::user()->profile_photo_path ? asset('storage/profile/' . Auth::user()->profile_photo_path) : asset('storage/profile/default.jpg') }}"
                    alt="Profile Image" class="w-full h-full object-cover">


            </div>

            <!-- User Information -->
            <h2 class="text-2xl font-bold mt-4">{{ Auth::user()->name }}</h2>
            <p class="text-gray-400">{{ Auth::user()->username }}</p>
        </div>
        <div class="relative flex justify-center items-center h-64">
            <button @click="openEditModal()"
                class="absolute bg-blue-500 text-white px-2 py-1 text-xs rounded-full hover:bg-blue-600 transition m-1">
                Edit
            </button>
        </div>

        <!-- Edit Profile Modal -->
        <div x-show="isModalOpen && !isCropModalOpen" x-cloak @click.outside="closeModal()" x-transition
            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-gray-800 rounded-lg p-6 w-full max-w-md">
                <h2 class="text-2xl font-bold mb-4">Edit Profile</h2>
                <div class="space-y-4">
                    <input x-model="formData.name" type="text" placeholder="Name"
                        class="w-full bg-gray-700 rounded p-2">
                    <input x-model="formData.email" type="email" placeholder="Email"
                        class="w-full bg-gray-700 rounded p-2">
                    <input x-model="formData.password" type="password" placeholder="New Password (optional)"
                        class="w-full bg-gray-700 rounded p-2">
                    <input @change="handleFileUpload($event)" type="file" accept="image/jpeg,image/png,image/gif"
                        class="w-full bg-gray-700 rounded p-2">
                    <div class="flex justify-end space-x-2">
                        <button @click="closeModal()"
                            class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-500">
                            Cancel
                        </button>
                        <button @click="updateProfile()"
                            class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                            Save Changes
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Crop Modal -->
        <div x-show="isCropModalOpen" x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-gray-800 rounded-lg p-6 w-full max-w-md">
                <h2 class="text-2xl font-bold mb-4">Crop Image</h2>
                <div id="image-cropper" class="mb-4"></div>
                <div class="flex justify-end space-x-2">
                    <button @click="closeCropModal()"
                        class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-500">
                        Cancel
                    </button>
                    <button @click="saveCroppedImage()"
                        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                        Crop & Save
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/cropperjs@1.5.12/dist/cropper.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/cropperjs@1.5.12/dist/cropper.min.css">

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

    <div class="participated-events">
        <h3 class="text-2xl font-bold mb-4">Events Participated</h3>
        @if($participatedEvents && $participatedEvents->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($participatedEvents as $event)
                    <div class="bg-gray-800 rounded-lg p-4">
                        <h4 class="text-lg font-semibold">{{ $event->title }}</h4>
                        <p class="text-gray-400">{{ $event->date }}</p>
                        <p class="text-sm">{{ $event->description }}</p>
                        <a href="{{ route('user.event.details', $event->id) }}"
                            class="mt-2 inline-block bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 transition">
                            View Details
                        </a>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-400">You haven't participated in any events yet.</p>
        @endif

    </div>
    <script>
        function profileManager() {
            return {
                isModalOpen: false,
                isCropModalOpen: false,
                previewImage: '{{ Auth::user()->profile_photo_path ? asset('storage/profile/' . Auth::user()->profile_photo_path) : asset('storage/profile/default.jpg') }}',
                cropper: null,
                formData: {
                    name: '{{ Auth::user()->name }}',
                    email: '{{ Auth::user()->email }}',
                    password: '',
                    avatar: null
                },
                openEditModal() {
                    this.isModalOpen = true;
                    this.isCropModalOpen = false;
                    // Reset preview image to current avatar
                    this.previewImage = '{{ Auth::user()->profile_photo_path ? asset('storage/profile/' . Auth::user()->profile_photo_path) : asset('storage/profile/default.jpg') }}';
                },
                closeModal() {
                    this.isModalOpen = false;
                    this.isCropModalOpen = false;
                },
                handleFileUpload(event) {
                    const file = event.target.files[0];
                    if (!file) return;
                    // Validate file type and size
                    const validTypes = ['image/jpeg', 'image/png', 'image/gif'];
                    if (!validTypes.includes(file.type)) {
                        alert('Please upload a valid image (JPEG, PNG, or GIF)');
                        return;
                    }
                    if (file.size > 2 * 1024 * 1024) { // 2MB limit
                        alert('File size should not exceed 2MB');
                        return;
                    }
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        this.previewImage = e.target.result;
                        this.openCropModal(e.target.result);
                    };
                    reader.readAsDataURL(file);
                },
                openCropModal(imageSource) {
                    this.isModalOpen = false;
                    this.isCropModalOpen = true;
                    this.$nextTick(() => {
                        const image = document.getElementById('image-cropper');
                        image.innerHTML = `<img src="${imageSource}" class="w-full">`;
                        this.cropper = new Cropper(image.querySelector('img'), {
                            aspectRatio: 1,
                            viewMode: 1,
                            guides: true,
                        });
                    });
                },
                closeCropModal() {
                    if (this.cropper) {
                        this.cropper.destroy();
                    }
                    this.isCropModalOpen = false;
                    this.isModalOpen = true;
                },
                saveCroppedImage() {
                    const croppedCanvas = this.cropper.getCroppedCanvas({
                        width: 300,
                        height: 300
                    });
                    // Convert to blob
                    croppedCanvas.toBlob((blob) => {
                        // Create a File object from the blob
                        const file = new File([blob], 'profile.jpg', {
                            type: 'image/jpeg'
                        });
                        this.formData.avatar = file;
                        // Update preview image
                        this.previewImage = croppedCanvas.toDataURL('image/jpeg');
                        document.querySelectorAll('img[alt="Profile Image"]').forEach(img => {
                            img.src = this.previewImage;
                        });
                        this.closeCropModal();
                        this.isModalOpen = true;
                    }, 'image/jpeg');
                },
                async updateProfile() {
                    const formData = new FormData();
                    formData.append('name', this.formData.name);
                    formData.append('email', this.formData.email);
                    if (this.formData.password) {
                        formData.append('password', this.formData.password);
                    }
                    // Append avatar if it exists
                    if (this.formData.avatar) {
                        formData.append('avatar', this.formData.avatar);
                    }
                    try {
                        const response = await fetch('{{ route('profile.update') }}', {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        });
                        const result = await response.json();
                        if (response.ok) {
                            // Update main profile image
                            if (result.avatar) {
                                document.querySelector('img[alt="Profile Image"]').src = result.avatar;
                            }
                            this.previewImage = result.avatar;
                            // Show success message
                            alert('Profile updated successfully!');
                            // Close modal
                            this.closeModal();
                        } else {
                            // Handle specific error messages
                            const errorMessage = result.message ||
                                (result.errors ? Object.values(result.errors).flat().join('\n') : 'An unexpected error occurred');
                            alert(errorMessage);
                            console.error('Profile Update Error:', result);
                        }
                    } catch (error) {
                        console.error('Network or Parsing Error:', error);
                        alert('An error occurred while updating the profile. Please try again.');
                    }
                }
            }
        }
    </script>
</body>
@endsection