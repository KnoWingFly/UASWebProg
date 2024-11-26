@extends('layouts.user')

@section('content')
<main class="p-6" x-data="profileManager()">
    <!-- User Profile Section -->
    <div class="text-center mb-8 relative">
        <img src="{{ Auth::user()->profile_photo_path ? asset('storage/profile/' . Auth::user()->profile_photo_path) : asset('storage/profile/default.jpg') }}"
            alt="Profile Image" class="w-32 h-32 rounded-full mx-auto object-cover">
        <h2 class="text-2xl font-bold mt-4">{{ Auth::user()->name }}</h2>
        <p class="text-gray-400">{{ Auth::user()->username }}</p>

        <!-- Edit Profile Button -->
        <button @click="openEditModal()"
            class="absolute top-0 right-0 bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 transition">
            Edit Profile
        </button>
    </div>

    <!-- Achievements Section -->
    <div class="mb-8">
        <h3 class="text-xl font-bold">Achievements</h3>

        @if($userAchievements->isNotEmpty())
            <div class="grid grid-cols-3 gap-4 mt-4">
                @foreach($userAchievements as $achievement)
                    <div class="bg-gray-700 p-4 rounded-lg text-center">
                        <p class="font-semibold">{{ $achievement->title }}</p>
                        <p class="text-gray-400">{{ $achievement->description ?? 'No description' }}</p>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-400">Never give up, achievements will come!</p>
        @endif
    </div>

    <!-- Activity History Section -->
    <div>
        <h3 class="text-xl font-bold">Activity History</h3>
        <ul class="mt-4 space-y-2">
            <!-- Display the join activity as the first entry -->
            <li class="bg-gray-700 p-4 rounded-lg">
                <strong>Joined UMN PC</strong> - {{ Auth::user()->created_at->format('Y-m-d') }} <br>
                <span class="text-gray-400">Welcome to UMN Programming Club!</span>
            </li>

            <!-- Loop through additional activities -->
            @foreach($userActivities as $activity)
                <li class="bg-gray-700 p-4 rounded-lg">
                    <strong>{{ $activity->activity_type }}</strong> - {{ $activity->activity_date }} <br>
                    <span class="text-gray-400">{{ $activity->description }}</span>
                </li>
            @endforeach
        </ul>
    </div>

    <!-- Edit Profile Modal -->
    <div x-show="isModalOpen" x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-gray-800 rounded-lg p-6 w-full max-w-md">
            <h2 class="text-2xl font-bold mb-4">Edit Profile</h2>

            <form @submit.prevent="updateProfile" enctype="multipart/form-data">
                <!-- Profile Photo -->
                <div class="mb-4">
                    <label class="block mb-2">Profile Photo</label>
                    <div class="flex items-center space-x-4">
                        <img src="{{ Auth::user()->profile_photo_path ? asset('storage/profile/' . Auth::user()->profile_photo_path) : asset('storage/profile/default.jpg') }}"
                            alt="Profile Image" class="w-32 h-32 rounded-full mx-auto object-cover">
                        <input type="file" @change="handleFileUpload" accept="image/*" class="hidden"
                            x-ref="profilePhotoInput">
                        <button type="button" @click="$refs.profilePhotoInput.click()"
                            class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                            Change Photo
                        </button>
                    </div>
                </div>

                <!-- Name Input -->
                <div class="mb-4">
                    <label class="block mb-2">Name</label>
                    <input type="text" x-model="formData.name" value="{{ Auth::user()->name }}"
                        class="w-full bg-gray-700 rounded px-3 py-2">
                </div>

                <!-- Email Input -->
                <div class="mb-4">
                    <label class="block mb-2">Email</label>
                    <input type="email" x-model="formData.email" value="{{ Auth::user()->email }}"
                        class="w-full bg-gray-700 rounded px-3 py-2">
                </div>

                <!-- Password Input -->
                <div class="mb-4">
                    <label class="block mb-2">New Password (optional)</label>
                    <input type="password" x-model="formData.password" class="w-full bg-gray-700 rounded px-3 py-2"
                        placeholder="Leave blank if no change">
                </div>

                <!-- Modal Actions -->
                <div class="flex justify-end space-x-2 mt-6">
                    <button type="button" @click="closeModal()"
                        class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">
                        Cancel
                    </button>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Image Crop Modal -->
    <div x-show="isCropModalOpen" x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-gray-800 rounded-lg p-6 w-full max-w-md">
            <h2 class="text-2xl font-bold mb-4">Crop Profile Photo</h2>

            <div class="mb-4">
                <div id="image-cropper" class="w-full h-64"></div>
            </div>

            <div class="flex justify-end space-x-2 mt-6">
                <button type="button" @click="closeCropModal()"
                    class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">
                    Cancel
                </button>
                <button type="button" @click="saveCroppedImage()"
                    class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    Save
                </button>
            </div>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script src="https://cdn.jsdelivr.net/npm/cropperjs@1.5.12/dist/cropper.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/cropperjs@1.5.12/dist/cropper.min.css">

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
                // Reset preview image to current avatar
                this.previewImage = '{{ Auth::user()->profile_photo_path ? asset('storage/profile/' . Auth::user()->profile_photo_path) : asset('storage/profile/default.jpg') }}';
            },

            closeModal() {
                this.isModalOpen = false;
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
@endsection