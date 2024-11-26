@extends('layouts.user')

@section('content')

<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-gray-200">Learning Materials in {{ $category->name }}</h2>
        <a href="{{ route('user.categories.index') }}"
            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
            Back to Categories
        </a>
    </div>

    <!-- Search and Filter Section -->
    <div class="mb-6 flex space-x-4">
        <div class="flex-grow">
            <input type="text" id="search-input" placeholder="Search materials..."
                class="w-full px-4 py-2 bg-gray-700 text-white rounded-lg border border-gray-600 focus:ring-blue-500 focus:border-blue-500">
        </div>
        <div>
            <select id="type-filter"
                class="px-4 py-2 bg-gray-700 text-white rounded-lg border border-gray-600 focus:ring-blue-500 focus:border-blue-500">
                <option value="">All Types</option>
                <option value="video">Video</option>
                <option value="pdf">PDF</option>
            </select>
        </div>
    </div>

    <div id="materials-container">
        @if($materials->isEmpty())
            <div class="text-center text-gray-400">
                No materials available in this category.
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6" id="materials-grid">
                @foreach($materials as $material)
                    <div class="material-card bg-gray-800 p-4 rounded-lg shadow-lg"
                        data-title="{{ strtolower($material->title) }}" data-type="{{ $material->type }}">
                        <h3 class="text-lg font-semibold text-white mb-2">
                            {{ $material->title }}
                        </h3>
                        <p class="text-gray-400 mb-2">
                            {{ Str::limit($material->description, 100) }}
                        </p>
                        <div class="flex justify-between items-center mb-4">
                            <span class="text-sm text-gray-500">
                                {{ $material->created_at->format('Y-m-d') }}
                            </span>
                            <span class="text-sm text-blue-400">
                                {{ ucfirst($material->type) }}
                            </span>
                        </div>
                        <div class="flex justify-between items-center">
                            <a href="{{ route('user.materials.view', ['material' => $material->id]) }}"
                                class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
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

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('search-input');
        const typeFilter = document.getElementById('type-filter');
        const materialsContainer = document.getElementById('materials-grid');

        searchInput.addEventListener('input', filterMaterials);
        typeFilter.addEventListener('change', filterMaterials);

        function filterMaterials() {
            const searchTerm = searchInput.value.toLowerCase();
            const selectedType = typeFilter.value;

            document.querySelectorAll('.material-card').forEach(card => {
                const title = card.getAttribute('data-title');
                const type = card.getAttribute('data-type');

                const matchesSearch = title.includes(searchTerm);
                const matchesType = selectedType === '' || type === selectedType;

                card.style.display = matchesSearch && matchesType ? 'block' : 'none';
            });
        }
    });
</script>

@endsection