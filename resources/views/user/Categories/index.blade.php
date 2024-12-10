@extends('layouts.user') <!-- Change layout to user -->

@section('content')
<div class="container mx-auto px-6 py-12">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-100">Learning Materials</h1>
    </div>

    @if(session('success'))
        <div class="p-4 mb-6 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-800 dark:text-green-200" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <!-- Search and Filter Section -->
    <div class="mb-8">
        <div class="flex flex-wrap gap-4">
            <div class="flex-1">
                <input type="text" id="searchInput" placeholder="Search materials..."
                    class="w-full px-4 py-2 bg-gray-800 border border-gray-600 rounded-lg text-gray-200 focus:outline-none focus:ring focus:ring-blue-500"
                    oninput="filterCategories()">
            </div>
            <div class="flex gap-2">
                <select id="parentFilter" onchange="filterCategories()"
                    class="px-4 py-2 bg-gray-800 border border-gray-600 rounded-lg text-gray-200 focus:outline-none focus:ring focus:ring-blue-500">
                    <option value="">All Categories</option>
                    <option value="uncategorized">Uncategorized</option>
                    <option value="parent">Root Categories</option>
                    <option value="sub">Subcategories</option>
                </select>
                <select id="sortFilter" onchange="filterCategories()"
                    class="px-4 py-2 bg-gray-800 border border-gray-600 rounded-lg text-gray-200 focus:outline-none focus:ring focus:ring-blue-500">
                    <option value="name-asc">Name (A-Z)</option>
                    <option value="name-desc">Name (Z-A)</option>
                    <option value="date-new">Newest First</option>
                    <option value="date-old">Oldest First</option>
                </select>
            </div>
        </div>
    </div>

    
    <!-- Highlighted Latest Category -->
    @if($latestCategory = $categories->sortByDesc('updated_at')->first())
    <div class="mb-12">
        <div class="bg-gray-900 border border-gray-700 rounded-lg shadow-lg p-8">
            <h2 class="text-xl font-bold text-blue-300 mb-4">Recently Updated</h2>
            <div class="flex flex-col lg:flex-row gap-6 items-start">
                <!-- Removed Image -->
                <div>
                    <h3 class="text-2xl font-bold text-gray-100 mb-2">{{ $latestCategory->name }}</h3>
                    <p class="text-gray-400 mb-4 text-sm">
                        Updated: {{ $latestCategory->updated_at->format('Y-m-d') }}
                        @if($latestCategory->parent)
                            | Parent: <span class="text-blue-400">{{ $latestCategory->parent->name }}</span>
                        @endif
                    </p>
                    <p class="text-gray-300 mb-4">{{ $latestCategory->description }}</p>
                    <a href="{{ route('user.categories.show', $latestCategory) }}"
                        class="inline-block mt-4 px-6 py-2 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 focus:ring-4 focus:ring-green-800 transition-colors duration-200">
                        View Details
                    </a>
                </div>
            </div>
        </div>
    </div>
@endif

<!-- Other Categories Section -->
<div class="mb-8">
    <h2 class="text-2xl font-bold text-gray-100 mb-4">Available Sources</h2>
    <div id="categoriesGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
        @foreach($categories->whereNotIn('id', [$latestCategory->id]) as $category)
            <div class="category-card bg-gray-900 border border-gray-700 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300"
                data-name="{{ strtolower($category->name) }}" 
                data-description="{{ strtolower($category->description) }}"
                data-parent="{{ $category->parent_id ? 'sub' : 'parent' }}"
                data-date="{{ $category->created_at->format('Y-m-d') }}">
                <div class="p-6">
                    <!-- Removed Image -->
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-xl font-bold text-gray-200">{{ $category->name }}</h3>
                        <span class="bg-blue-700 text-blue-300 text-xs font-semibold px-3 py-1 rounded">
                            {{ $category->learning_materials_count }} Materials
                        </span>
                    </div>

                    <p class="text-gray-400 mb-4 text-sm">
                        Created: {{ $category->created_at->format('Y-m-d') }}
                        @if($category->parent)
                            | Parent: <span class="text-blue-400">{{ $category->parent->name }}</span>
                        @endif
                    </p>

                    <p class="text-sm text-gray-400">{{ $category->description }}</p>

                    <a href="{{ route('user.categories.show', $category) }}"
                        class="block mt-6 px-4 py-2 text-center text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 focus:ring-4 focus:ring-green-800 transition-colors duration-200">
                        View Details
                    </a>
                </div>
            </div>
        @endforeach
    </div>
</div>


    <!-- Pagination -->
    <div class="mt-12">
        {{ $categories->links() }}
    </div>
</div>

<script>
    function filterCategories() {
        const searchTerm = document.getElementById('searchInput').value.toLowerCase();
        const parentFilter = document.getElementById('parentFilter').value;
        const sortFilter = document.getElementById('sortFilter').value;
        const cards = Array.from(document.getElementsByClassName('category-card'));

        cards.forEach(card => {
            const name = card.dataset.name;
            const description = card.dataset.description;
            const parentType = card.dataset.parent;

            const matchesSearch = name.includes(searchTerm) || description.includes(searchTerm);
            const matchesParentFilter = parentFilter === '' ||
                (parentFilter === 'parent' && parentType === 'parent') ||
                (parentFilter === 'sub' && parentType === 'sub') ||
                (parentFilter === 'uncategorized' && parentType === 'uncategorized');

            card.style.display = matchesSearch && matchesParentFilter ? 'block' : 'none';
        });

        const visibleCards = cards.filter(card => card.style.display !== 'none');
        sortCards(visibleCards, sortFilter);
    }

    function sortCards(cards, sortFilter) {
        const grid = document.getElementById('categoriesGrid');

        cards.sort((a, b) => {
            switch (sortFilter) {
                case 'name-asc':
                    return a.dataset.name.localeCompare(b.dataset.name);
                case 'name-desc':
                    return b.dataset.name.localeCompare(a.dataset.name);
                case 'date-new':
                    return new Date(b.dataset.date) - new Date(a.dataset.date);
                case 'date-old':
                    return new Date(a.dataset.date) - new Date(b.dataset.date);
                default:
                    return 0;
            }
        });

        cards.forEach(card => grid.appendChild(card));
    }

    document.addEventListener('DOMContentLoaded', filterCategories);
</script>
@endsection
