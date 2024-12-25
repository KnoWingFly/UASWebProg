@extends('layouts.user')

@section('content')
<div class="container mx-auto px-4 py-8 opacity-0" id="mainContainer">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-[#ff4d4d]">Learning Materials in {{ $category->name }}</h2>
        <a href="{{ route('user.categories.index') }}"
            class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-opacity-90 transition-all duration-200">
            Back to Categories
        </a>
    </div>

    <!-- Search and Filter Section -->
    <div class="mb-6 flex space-x-4 opacity-0" id="filterSection">
        <div class="flex-grow">
            <input type="text" id="search-input" placeholder="Search materials..."
                class="w-full px-4 py-2 bg-[#151515] text-white rounded-lg border border-[#1a1a1a] focus:ring-blue-500 focus:border-blue-500">
        </div>
        <div>
            <select id="type-filter"
                class="px-4 py-2 bg-[#151515] text-white rounded-lg border border-[#1a1a1a] focus:ring-blue-500 focus:border-blue-500">
                <option value="">All Types</option>
                <option value="video">Video</option>
                <option value="pdf">PDF</option>
            </select>
        </div>
    </div>

    <div id="materials-container">
        @if($materials->isEmpty())
            <div class="text-center text-gray-400 opacity-0" id="emptyMessage">
                No materials available in this category.
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6" id="materials-grid">
                @foreach($materials as $material)
                    <div class="material-card opacity-0 bg-[#1a1a1a] p-6 rounded-lg shadow-lg transform hover:scale-[1.02] transition-all duration-300"
                        data-title="{{ strtolower($material->title) }}" data-type="{{ $material->type }}">
                        <h3 class="text-lg font-semibold text-[#ff4d4d] mb-2">
                            {{ $material->title }}
                        </h3>
                        <p class="text-gray-400 mb-4">
                            {{ Str::limit($material->description, 100) }}
                        </p>
                        <div class="flex justify-between items-center mb-4">
                            <span class="text-sm text-gray-500">
                                {{ $material->created_at->format('Y-m-d') }}
                            </span>
                            <span class="text-sm bg-blue-500 bg-opacity-20 text-blue-500 px-3 py-1 rounded">
                                {{ ucfirst($material->type) }}
                            </span>
                        </div>
                        <div class="flex justify-between items-center">
                            <a href="{{ route('user.materials.view', ['material' => $material->id]) }}"
                                class="px-4 py-2 bg-[#ff4d4d] text-white rounded-lg hover:bg-opacity-90 transition-all duration-200">
                                View
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <div class="mt-6">
        {{ $materials->links() }}
    </div>
</div>

<style>
    .material-card {
        transform: translateY(20px);
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Initial animations
        gsap.to('#mainContainer', {
            opacity: 1,
            duration: 0.8,
            ease: 'power2.out'
        });

        gsap.to('#filterSection', {
            opacity: 1,
            y: 0,
            duration: 0.6,
            delay: 0.3,
            ease: 'power2.out'
        });

        if (document.getElementById('emptyMessage')) {
            gsap.to('#emptyMessage', {
                opacity: 1,
                y: 0,
                duration: 0.6,
                delay: 0.5,
                ease: 'power2.out'
            });
        }

        // Animate material cards
        gsap.utils.toArray('.material-card').forEach((card, index) => {
            gsap.to(card, {
                opacity: 1,
                y: 0,
                duration: 0.5,
                delay: 0.2 * index,
                ease: 'power2.out'
            });
        });

        // Initialize filter functionality
        const searchInput = document.getElementById('search-input');
        const typeFilter = document.getElementById('type-filter');

        function filterMaterials() {
            const searchTerm = searchInput.value.toLowerCase();
            const selectedType = typeFilter.value;

            gsap.utils.toArray('.material-card').forEach((card, index) => {
                const title = card.getAttribute('data-title');
                const type = card.getAttribute('data-type');

                const matchesSearch = title.includes(searchTerm);
                const matchesType = selectedType === '' || type === selectedType;

                if (matchesSearch && matchesType) {
                    gsap.to(card, {
                        opacity: 1,
                        scale: 1,
                        y: 0,
                        duration: 0.4,
                        delay: index * 0.1,
                        ease: 'power2.out',
                        display: 'block'
                    });
                } else {
                    gsap.to(card, {
                        opacity: 0,
                        scale: 0.95,
                        y: 20,
                        duration: 0.3,
                        ease: 'power2.in',
                        onComplete: () => {
                            card.style.display = 'none';
                        }
                    });
                }
            });
        }

        // Add event listeners
        searchInput.addEventListener('input', filterMaterials);
        typeFilter.addEventListener('change', filterMaterials);

        // Hover animations
        gsap.utils.toArray('.material-card').forEach(card => {
            const title = card.querySelector('h3');
            const viewButton = card.querySelector('a');

            card.addEventListener('mouseenter', () => {
                gsap.to(title, {
                    color: '#ff6b6b',
                    duration: 0.3
                });
                gsap.to(viewButton, {
                    backgroundColor: '#ff6b6b',
                    duration: 0.3
                });
            });

            card.addEventListener('mouseleave', () => {
                gsap.to(title, {
                    color: '#ff4d4d',
                    duration: 0.3
                });
                gsap.to(viewButton, {
                    backgroundColor: '#ff4d4d',
                    duration: 0.3
                });
            });
        });
    });
</script>
@endsection