@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8 bg-[#151515] text-white opacity-0" id="mainContainer">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-white gsap-title">Activity History</h1>

        @if ($errors->any())
        <div class="bg-[#ff4d4d] border border-red-400 text-white px-4 py-3 rounded relative opacity-0 gsap-alert" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
    
        <button data-modal-target="create-activity-modal" data-modal-toggle="create-activity-modal"
            class="gsap-button block text-white bg-[#ff4d4d] hover:bg-[#e04343] focus:ring-4 focus:outline-none focus:ring-[#e04343] font-medium rounded-lg text-sm px-5 py-2.5 text-center transform hover:scale-105 transition-transform duration-200">
            Create Activity
        </button>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 bg-[#1a1a1a] border-[#1a1a1a] text-green-300 px-4 py-3 rounded relative mb-4 opacity-0 gsap-success"
            role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($activities as $index => $activity)
        <div class="activity-card bg-[#1a1a1a] shadow-md rounded-lg p-4 opacity-0 transform translate-y-4" 
             data-index="{{ $index }}">
            <div class="flex justify-between items-center mb-2">
                <h3 class="text-lg font-semibold text-white">{{ $activity->activity_type }}</h3>
                <div class="flex items-center space-x-2">
                <a href="{{ route('admin.activity-history.show', $activity) }}"
   class="text-[#ff4d4d] hover:text-[#e04343] transform hover:scale-110 transition-transform duration-200">
   <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
       <path d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6zM16 7a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V7z" />
   </svg>
</a>


                    <button data-modal-target="edit-activity-modal-{{ $activity->id }}"
                        data-modal-toggle="edit-activity-modal-{{ $activity->id }}"
                        class="text-blue-500 hover:text-blue-400 transform hover:scale-110 transition-transform duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                            <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" />
                        </svg>
                    </button>

                    <form action="{{ route('admin.activity-history.destroy', $activity) }}" method="POST" class="inline delete-form">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="text-[#ff4d4d] hover:text-[#e04343] transform hover:scale-110 transition-transform duration-200"
                            onclick="return confirm('Are you sure?')">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
            <p class="text-gray-300 mb-2">
                <strong>Users:</strong> {{ $activity->users->count() }} participants
            </p>
            <p class="text-gray-300 mb-2">
                <strong>Date:</strong> {{ $activity->activity_date }}
            </p>
            @if($activity->description)
            <p class="text-gray-400 italic">
                {{ Str::limit($activity->description, 100) }}
            </p>
            @endif
        </div>
        {{-- Edit Activity Modal --}}
        <div id="edit-activity-modal-{{ $activity->id }}" tabindex="-1" aria-hidden="true"
            class="modal-container hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full opacity-0 scale-95">
            <div class="relative p-4 w-full max-w-2xl max-h-full">
                <div class="relative bg-[#1a1a1a] rounded-lg shadow">
                    <div class="flex items-center justify-between p-4 md:p-5 border-b border-[#151515] rounded-t">
                        <h3 class="text-lg font-semibold text-white">
                            Edit Activity
                        </h3>
                        <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-[#ff4d4d] hover:text-white rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                            data-modal-toggle="edit-activity-modal-{{ $activity->id }}">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <form action="{{ route('admin.activity-history.update', $activity) }}" method="POST" class="p-4 md:p-5">
                        @csrf
                        @method('PUT')
                        <div class="grid gap-4 mb-4 grid-cols-2">
                            <div class="col-span-2">
                                <label for="activity_type_{{ $activity->id }}"
                                    class="block mb-2 text-sm font-medium text-white">
                                    Activity Type
                                </label>
                                <input type="text" name="activity_type" id="activity_type_{{ $activity->id }}"
                                    value="{{ $activity->activity_type }}"
                                    class="bg-[#151515] border border-[#ff4d4d] text-white text-sm rounded-lg focus:ring-[#ff4d4d] focus:border-[#ff4d4d] block w-full p-2.5"
                                    placeholder="Enter activity type" required>
                            </div>
                            <div class="col-span-2">
                                <label for="activity_date_{{ $activity->id }}"
                                    class="block mb-2 text-sm font-medium text-white">
                                    Activity Date
                                </label>
                                <input type="date" name="activity_date" id="activity_date_{{ $activity->id }}"
                                    value="{{ $activity->activity_date }}"
                                    class="bg-[#151515] border border-[#ff4d4d] text-white text-sm rounded-lg focus:ring-[#ff4d4d] focus:border-[#ff4d4d] block w-full p-2.5"
                                    required>
                            </div>
                            <div class="col-span-2">
                                <label for="description_{{ $activity->id }}"
                                    class="block mb-2 text-sm font-medium text-white">
                                    Description (Optional)
                                </label>
                                <textarea name="description" id="description_{{ $activity->id }}" rows="4"
                                    class="block p-2.5 w-full text-sm text-white bg-[#151515] rounded-lg border border-[#ff4d4d] focus:ring-[#ff4d4d] focus:border-[#ff4d4d]"
                                    placeholder="Write activity description here">{{ $activity->description }}</textarea>
                            </div>
                        </div>
                        <button type="submit"
                            class="w-full text-white inline-flex items-center justify-center bg-[#ff4d4d] hover:bg-[#e04343] focus:ring-4 focus:outline-none focus:ring-[#ff4d4d] font-medium rounded-lg text-sm px-5 py-2.5 text-center transition-colors">
                            Update Activity
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $activities->links() }}
    </div>

    {{-- Create Activity Modal --}}
    <div id="create-activity-modal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <div class="relative bg-[#1a1a1a] rounded-lg shadow-xl">
                <div class="flex items-center justify-between p-4 md:p-5 border-b border-[#151515] rounded-t">
                    <h3 class="text-lg font-semibold text-white">
                        Create New Activity
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-[#ff4d4d] hover:text-white rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                        data-modal-toggle="create-activity-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <form action="{{ route('admin.activity-history.store') }}" method="POST" class="p-4 md:p-5">
                    @csrf
                    <div class="grid gap-4 mb-4 grid-cols-2">
                        <div class="col-span-2">
                            <label for="activity_type"
                                class="block mb-2 text-sm font-medium text-white">
                                Activity Type
                            </label>
                            <input type="text" name="activity_type" id="activity_type"
                                class="bg-[#151515]  text-white text-sm rounded-lg focus:ring-[#ff4d4d] focus:border-[#ff4d4d] focus:outline-none block w-full p-2.5"
                                placeholder="Enter activity type" required>
                        </div>
                        <div class="col-span-2">
                            <label for="activity_date"
                                class="block mb-2 text-sm font-medium text-white">
                                Activity Date
                            </label>
                            <input type="date" name="activity_date" id="activity_date"
                                class="bg-[#151515]  text-white text-sm rounded-lg focus:ring-[#ff4d4d] focus:border-[#ff4d4d] focus:outline-none block w-full p-2.5"
                                required>
                        </div>
                        <div class="col-span-2">
                            <label for="description"
                                class="block mb-2 text-sm font-medium text-white">
                                Description (Optional)
                            </label>
                            <textarea name="description" id="description" rows="4"
                                class="block p-2.5 w-full text-sm text-white bg-[#151515] rounded-lg focus:ring-[#ff4d4d] focus:border-[#ff4d4d] focus:outline-none"
                                placeholder="Write activity description here"></textarea>
                        </div>
                    </div>
                    <button type="submit"
                        class="w-full text-white inline-flex items-center justify-center bg-[#ff4d4d] hover:bg-[#e04343] focus:ring-4 focus:outline-none focus:ring-[#ff4d4d] font-medium rounded-lg text-sm px-5 py-2.5 text-center transition-colors">
                        <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                clip-rule="evenodd"></path>
                        </svg>
                        Create Activity
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
        // Initial animations
        gsap.to('#mainContainer', {
            opacity: 1,
            duration: 0.5,
            ease: 'power2.out'
        });

        gsap.to('.gsap-title', {
            opacity: 1,
            x: 0,
            duration: 0.5,
            ease: 'power2.out'
        });

        gsap.to('.gsap-button', {
            opacity: 1,
            y: 0,
            duration: 0.5,
            delay: 0.2,
            ease: 'back.out(1.7)'
        });

        // Animate activity cards
        const cards = document.querySelectorAll('.activity-card');
        cards.forEach((card, index) => {
            gsap.to(card, {
                opacity: 1,
                y: 0,
                duration: 0.5,
                delay: 0.1 * index,
                ease: 'power2.out'
            });
        });

        // Success message animation
        const successMessage = document.querySelector('.gsap-success');
        if (successMessage) {
            gsap.to(successMessage, {
                opacity: 1,
                y: 0,
                duration: 0.5,
                ease: 'power2.out',
                onComplete: () => {
                    setTimeout(() => {
                        gsap.to(successMessage, {
                            opacity: 0,
                            y: -20,
                            duration: 0.5,
                            ease: 'power2.in'
                        });
                    }, 3000);
                }
            });
        }

        // Modal animations
        function showModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.remove('hidden');
                gsap.to(modal, {
                    opacity: 1,
                    scale: 1,
                    duration: 0.3,
                    ease: 'power2.out'
                });
            }
        }

        function hideModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                gsap.to(modal, {
                    opacity: 0,
                    scale: 0.95,
                    duration: 0.2,
                    ease: 'power2.in',
                    onComplete: () => {
                        modal.classList.add('hidden');
                    }
                });
            }
        }

        // Handle modal triggers
        document.querySelectorAll('[data-modal-toggle]').forEach(button => {
            button.addEventListener('click', () => {
                const modalId = button.getAttribute('data-modal-target');
                const modal = document.getElementById(modalId);
                
                if (modal.classList.contains('hidden')) {
                    showModal(modalId);
                } else {
                    hideModal(modalId);
                }
            });
        });

        // Delete animation
        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                if (confirm('Are you sure?')) {
                    const card = this.closest('.activity-card');
                    gsap.to(card, {
                        opacity: 0,
                        x: -100,
                        duration: 0.3,
                        ease: 'power2.in'
                    });
                } else {
                    e.preventDefault();
                }
            });
        });

        // Pagination animation
        gsap.to('#pagination', {
            opacity: 1,
            duration: 0.5,
            delay: 0.5,
            ease: 'power2.out'
        });

        // Checkbox animations
        document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                gsap.to(this, {
                    scale: 1.2,
                    duration: 0.1,
                    yoyo: true,
                    repeat: 1,
                    ease: 'power2.inOut'
                });
            });
        });
    });
    </script>
@endsection
