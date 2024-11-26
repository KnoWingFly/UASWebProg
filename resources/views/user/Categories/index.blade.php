@extends('layouts.user') <!-- Change layout to user -->

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-gray-200">Material Categories</h2>
    </div>

    @if(session('success'))
        <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-800 dark:text-green-200"
            role="alert">
            {{ session('success') }}
        </div>
    @endif

    <!-- Search and Filter Section -->
    <div class="mb-6 space-y-4">
        <div class="flex gap-4">
            <div class="flex-1">
                <input type="text" id="searchInput" placeholder="Search categories..."
                    class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-gray-200 focus:outline-none focus:border-blue-500"
                    oninput="filterCategories()">
            </div>
            <div class="flex gap-2">
                <select id="parentFilter" onchange="filterCategories()"
                    class="px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-gray-200 focus:outline-none focus:border-blue-500">
                    <option value="">All Categories</option>
                    <option value="uncategorized">Uncategorized</option>
                    <option value="parent">Root Categories</option>
                    <option value="sub">Subcategories</option>
                </select>
                <select id="sortFilter" onchange="filterCategories()"
                    class="px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-gray-200 focus:outline-none focus:border-blue-500">
                    <option value="name-asc">Name (A-Z)</option>
                    <option value="name-desc">Name (Z-A)</option>
                    <option value="date-new">Newest First</option>
                    <option value="date-old">Oldest First</option>
                </select>
            </div>
        </div>
    </div>

    <div id="categoriesGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @foreach($categories as $category)
            <div class="category-card bg-gray-800 border border-gray-700 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300"
                data-name="{{ strtolower($category->name) }}" data-description="{{ strtolower($category->description) }}"
                data-parent="{{ $category->parent_id ? 'sub' : 'parent' }}"
                data-date="{{ $category->created_at->format('Y-m-d') }}">
                <div class="p-5">
                    <div class="flex items-center justify-between mb-4">
                        <h5 class="text-xl font-bold tracking-tight text-gray-200">
                            {{ $category->name }}
                        </h5>
                        <span class="bg-blue-900 text-blue-300 text-xs font-medium px-2.5 py-0.5 rounded-full">
                            {{ $category->learning_materials_count }} Materials
                        </span>
                    </div>

                    <div class="text-sm text-gray-400 mb-4">
                        <p class="mb-2">Created: {{ $category->created_at->format('Y-m-d') }}</p>
                        @if($category->parent)
                            <p class="mb-2">Parent: <span class="text-blue-400">{{ $category->parent->name }}</span></p>
                        @endif
                        <p>{{ $category->description }}</p>
                    </div>

                    @if($category->children->count() > 0)
                        <div class="mb-4">
                            <p class="text-sm text-gray-400">Subcategories:</p>
                            <div class="flex flex-wrap gap-2 mt-2">
                                @foreach($category->children as $child)
                                    <span class="bg-gray-700 text-gray-300 text-xs px-2 py-1 rounded">
                                        {{ $child->name }}
                                        <span class="text-blue-300 ml-1">({{ $child->learning_materials_count }} Materials)</span>
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <a href="{{ route('user.categories.show', $category) }}"
                        class="block mt-4 px-3 py-2 text-sm font-medium text-center text-white bg-green-600 rounded-lg hover:bg-green-700 focus:ring-4 focus:ring-green-800 transition-colors duration-200">
                        View Details
                    </a>
                </div>
            </div>
        @endforeach

        <!-- Uncategorized Section -->
        <div class="category-card bg-gray-800 border border-gray-700 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300"
            data-name="uncategorized" data-description="materials without category" data-parent="uncategorized"
            data-date="0000-00-00">
            <div class="p-5">
                <div class="flex items-center justify-between mb-4">
                    <h5 class="text-xl font-bold tracking-tight text-gray-200">
                        Uncategorized
                    </h5>
                    <span class="bg-blue-900 text-blue-300 text-xs font-medium px-2.5 py-0.5 rounded-full">
                        {{ $uncategorizedCount }} Materials
                    </span>
                </div>

                <div class="text-sm text-gray-400 mb-4">
                    <p class="mb-2">Created: 0000-00-00</p>
                    <p>Learning materials that haven't been assigned to any category</p>
                </div>

                <a href="{{ route('user.categories.show', 'uncategorized') }}"
                    class="block mt-4 px-3 py-2 text-sm font-medium text-center text-white bg-green-600 rounded-lg hover:bg-green-700 focus:ring-4 focus:ring-green-800 transition-colors duration-200">
                    View Uncategorized
                </a>
            </div>
        </div>
    </div>

    <div class="mt-6">
        {{ $categories->links() }}
    </div>
</div>

<script>
    // Retain the search and filter logic
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