@extends('layouts.user')

@section('content')
<main class="p-6" x-data="profileManager()">


    <!-- Achievements Section -->
    <div class="mb-8"></div>
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
