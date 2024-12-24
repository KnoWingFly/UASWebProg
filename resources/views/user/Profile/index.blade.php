@extends('layouts.user')

@section('content')

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <style>
        .activity-item {
            transition: transform 0.3s ease;
        }

        .activity-item:hover {
            transform: translateX(8px);
        }
    </style>
</head>

<body class="bg-gray-900 text-white" x-data="profileManager()">
    <div class="min-h-screen bg-[#151515]" x-data="profileManager()">
        <!-- Profile Section -->
        <div class="max-w-4xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
            <!-- Profile Header -->
            <div class="flex flex-col items-center mb-12 text-center opacity-0 translate-y-8" id="profile-header">
                <div
                    class="w-32 h-32 bg-[#1a1a1a] rounded-full overflow-hidden relative shadow-xl border-4 border-[#ff4d4d] transform hover:scale-105 transition-transform duration-300">
                    <img src="{{ Auth::user()->profile_photo_path ? asset('storage/profile/' . Auth::user()->profile_photo_path) : asset('storage/profile/default.jpg') }}"
                        alt="Profile Image" class="w-full h-full object-cover">
                </div>
                <h2 class="text-3xl font-bold mt-6 text-white">{{ Auth::user()->name }}</h2>
            </div>

            <!-- Edit Button -->
            <div class="flex justify-center mb-16">
                <button @click="openEditModal()"
                    class="bg-[#ff4d4d] text-white px-6 py-3 text-lg font-semibold rounded-lg opacity-0 translate-y-4 hover:bg-opacity-90 transition-all duration-300 transform hover:scale-105"
                    id="edit-button">
                    Edit Profile
                </button>
            </div>

            <!-- Activity History -->
            <div class="mb-16">
                <div class="flex items-center mb-8 opacity-0" id="activity-header">
                    <h3 class="text-2xl font-bold text-white">Activity History</h3>
                    <div class="h-0.5 bg-[#ff4d4d] flex-grow ml-4"></div>
                </div>

                <div class="relative pl-8">
                    <div class="absolute left-0 top-0 h-full w-0.5 bg-[#1a1a1a]" id="timeline-line"></div>

                    <ul class="space-y-6">
                        <!-- Join Activity -->
                        <li
                            class="relative bg-[#1a1a1a] p-6 rounded-lg shadow-lg border-l-4 border-[#ff4d4d] opacity-0 translate-x-8 activity-item hover:transform hover:translate-x-4 transition-transform duration-300">
                            <div class="absolute -left-10 w-4 h-4 rounded-full bg-[#ff4d4d]"></div>
                            <h4 class="text-lg font-semibold text-white mb-2">Joined UMN PC</h4>
                            <p class="text-gray-400 text-sm">
                                {{ \Carbon\Carbon::parse(Auth::user()->created_at)->format('Y-m-d') }}
                            </p>
                            <p class="text-gray-400 mt-2">Welcome to UMN Programming Club!</p>
                        </li>

                        @foreach($userActivities as $activity)
                            <li
                                class="relative bg-[#1a1a1a] p-6 rounded-lg shadow-lg border-l-4 border-blue-500 opacity-0 translate-x-8 activity-item hover:transform hover:translate-x-4 transition-transform duration-300">
                                <div class="absolute -left-10 w-4 h-4 rounded-full bg-blue-500"></div>
                                <h4 class="text-lg font-semibold text-white mb-2">{{ $activity->activity_type }}</h4>
                                <p class="text-gray-400 text-sm">{{ $activity->activity_date }}</p>
                                <p class="text-gray-400 mt-2">{{ $activity->description }}</p>
                            </li>
                        @endforeach
                    </ul>

                    <!-- Activity Pagination -->
                    <div class="mt-8">
                        {{ $userActivities->links('components.pagination') }}
                    </div>
                </div>
            </div>

            <!-- Events Section -->
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 mb-16 opacity-0" id="events-section">
                <div class="flex items-center mb-8">
                    <h3 class="text-2xl font-bold text-white">Events Participated</h3>
                    <div class="h-0.5 bg-[#ff4d4d] flex-grow ml-4"></div>
                </div>

                @if($participatedEvents && $participatedEvents->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($participatedEvents as $eventUser)
                            <div
                                class="bg-[#1a1a1a] rounded-xl overflow-hidden shadow-lg opacity-0 translate-y-4 event-card group">
                                <div class="relative h-48 overflow-hidden">
                                    @if($eventUser->event->banner)
                                        <img src="{{ asset('storage/' . $eventUser->event->banner) }}" alt="Event Banner"
                                            class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                                    @else
                                        <div class="h-full bg-gradient-to-r from-[#ff4d4d] to-blue-500">
                                            <div class="absolute inset-0 bg-black bg-opacity-40"></div>
                                        </div>
                                    @endif
                                    <div
                                        class="absolute bottom-4 left-4 right-4 z-10 bg-black bg-opacity-50 backdrop-blur-sm rounded-lg p-3">
                                        <h4 class="text-xl font-bold text-white mb-1">{{ $eventUser->event->name }}</h4>
                                        <p class="text-gray-200 text-sm">
                                            {{ \Carbon\Carbon::parse($eventUser->event->registration_start)->format('Y-m-d') }}
                                        </p>
                                    </div>
                                </div>

                                <div class="p-6">
                                    <p class="text-gray-400 text-sm mb-4 line-clamp-3">{{ $eventUser->event->description }}</p>
                                    <a href="{{ route('user.event.details', $eventUser->event->id) }}"
                                        class="block bg-[#1a1a1a] border border-[#ff4d4d] text-white text-center px-4 py-2 rounded-lg hover:bg-[#ff4d4d] transition-all duration-300 group-hover:transform group-hover:translate-y-[-4px]">
                                        View Details
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Events Pagination -->
                    <div class="mt-8">
                        {{ $participatedEvents->links('components.pagination') }}
                    </div>
                @else
                    <div class="bg-[#1a1a1a] rounded-xl p-8 text-center">
                        <div class="mb-4">
                            <svg class="w-16 h-16 mx-auto text-gray-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <p class="text-gray-400 text-lg">You haven't participated in any events yet.</p>
                        <p class="text-gray-500 mt-2">Check out our upcoming events to get started!</p>
                    </div>
                @endif
            </div>

            <!-- Modals (Edit Profile & Crop Modal) -->
            <div x-show="isModalOpen && !isCropModalOpen" x-cloak @click.outside="closeModal()"
                class="fixed inset-0 z-50 overflow-y-auto" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0">
                <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                    <div class="fixed inset-0 transition-opacity bg-black bg-opacity-75" aria-hidden="true"></div>

                    <div class="relative inline-block w-full max-w-md p-6 overflow-hidden text-left align-middle transition-all transform bg-[#1a1a1a] rounded-2xl shadow-xl"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">

                        <div class="absolute top-0 right-0 hidden pt-4 pr-4 sm:block">
                            <button @click="closeModal()" type="button"
                                class="text-gray-400 bg-transparent rounded-lg hover:text-gray-200 focus:outline-none">
                                <span class="sr-only">Close</span>
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <div class="sm:flex sm:items-start">
                            <div class="w-full">
                                <h3 class="text-2xl font-bold text-white mb-6">Edit Profile</h3>

                                <div class="space-y-4">
                                    <!-- Profile Image Preview -->
                                    <div class="flex justify-center mb-6">
                                        <div
                                            class="relative w-24 h-24 rounded-full overflow-hidden border-4 border-[#ff4d4d] group">
                                            <img :src="previewImage" alt="Preview" class="w-full h-full object-cover">
                                            <div
                                                class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                                <label class="cursor-pointer">
                                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    </svg>
                                                    <input @change="handleFileUpload($event)" type="file"
                                                        accept="image/jpeg,image/png,image/gif" class="hidden">
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Form Fields -->
                                    <div class="space-y-4">
                                        <div class="relative">
                                            <input x-model="formData.name" type="text" placeholder="Name"
                                                class="w-full bg-[#151515] text-white rounded-lg px-4 py-3 focus:ring-2 focus:ring-[#ff4d4d] focus:outline-none transition-all duration-200">
                                        </div>

                                        <div class="relative">
                                            <input x-model="formData.email" type="email" placeholder="Email"
                                                class="w-full bg-[#151515] text-white rounded-lg px-4 py-3 focus:ring-2 focus:ring-[#ff4d4d] focus:outline-none transition-all duration-200">
                                        </div>

                                        <div class="relative">
                                            <input x-model="formData.password" type="password"
                                                placeholder="New Password (optional)"
                                                class="w-full bg-[#151515] text-white rounded-lg px-4 py-3 focus:ring-2 focus:ring-[#ff4d4d] focus:outline-none transition-all duration-200">
                                        </div>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="flex justify-end space-x-4 mt-6">
                                        <button @click="closeModal()"
                                            class="px-4 py-2 text-white bg-[#151515] rounded-lg hover:bg-opacity-80 transition-all duration-200">
                                            Cancel
                                        </button>
                                        <button @click="updateProfile()"
                                            class="px-4 py-2 text-white bg-[#ff4d4d] rounded-lg hover:bg-opacity-90 transition-all duration-200">
                                            Save Changes
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Crop Modal -->
            <div x-show="isCropModalOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto"
                x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                    <div class="fixed inset-0 transition-opacity bg-black bg-opacity-75" aria-hidden="true"></div>

                    <div
                        class="relative inline-block w-full max-w-md p-6 overflow-hidden text-left align-middle transition-all transform bg-[#1a1a1a] rounded-2xl shadow-xl">
                        <h3 class="text-2xl font-bold text-white mb-6">Crop Image</h3>

                        <div id="image-cropper" class="mb-6 bg-[#151515] rounded-lg overflow-hidden"></div>

                        <div class="flex justify-end space-x-4">
                            <button @click="closeCropModal()"
                                class="px-4 py-2 text-white bg-[#151515] rounded-lg hover:bg-opacity-80 transition-all duration-200">
                                Cancel
                            </button>
                            <button @click="saveCroppedImage()"
                                class="px-4 py-2 text-white bg-[#ff4d4d] rounded-lg hover:bg-opacity-90 transition-all duration-200">
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

</body>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Profile Header Animation
        gsap.to('#profile-header', {
            opacity: 1,
            y: 0,
            duration: 1,
            ease: 'power3.out'
        });

        // Edit Button Animation
        gsap.to('#edit-button', {
            opacity: 1,
            y: 0,
            duration: 1,
            delay: 0.3,
            ease: 'power3.out'
        });

        // Activity Header Animation
        gsap.to('#activity-header', {
            opacity: 1,
            duration: 1,
            delay: 0.5,
            ease: 'power3.out'
        });

        // Timeline Line Animation
        gsap.from('#timeline-line', {
            scaleY: 0,
            transformOrigin: 'top',
            duration: 1.5,
            delay: 0.8,
            ease: 'power3.inOut'
        });

        // Activity Items Animation
        gsap.utils.toArray('.activity-item').forEach((item, index) => {
            gsap.to(item, {
                opacity: 1,
                x: 0,
                duration: 0.8,
                delay: 1 + (index * 0.2),
                ease: 'power3.out'
            });
        });

        // Events Section Animation
        gsap.to('#events-section', {
            opacity: 1,
            duration: 1,
            delay: 1.5,
            ease: 'power3.out'
        });

        // Event Cards Animation
        gsap.utils.toArray('.event-card').forEach((card, index) => {
            gsap.to(card, {
                opacity: 1,
                y: 0,
                duration: 0.8,
                delay: 2 + (index * 0.2),
                ease: 'power3.out'
            });
        });

        // Events Section Animation
        gsap.to('#events-section', {
            opacity: 1,
            duration: 1,
            delay: 1.5,
            ease: 'power3.out'
        });

        // Event Cards Staggered Animation
        gsap.utils.toArray('.event-card').forEach((card, index) => {
            gsap.to(card, {
                opacity: 1,
                y: 0,
                duration: 0.8,
                delay: 2 + (index * 0.2),
                ease: 'power3.out'
            });
        });

        // Modal Animations
        const modalTimeline = gsap.timeline({ paused: true });
        modalTimeline
            .from('.modal-content', {
                y: 50,
                opacity: 0,
                duration: 0.4,
                ease: 'power3.out'
            })
            .from('.modal-content .form-field', {
                y: 20,
                opacity: 0,
                duration: 0.3,
                stagger: 0.1,
                ease: 'power3.out'
            }, '-=0.2');

        // Trigger modal animation when opened
        document.addEventListener('modalOpened', () => {
            modalTimeline.play();
        });
    });
</script>

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