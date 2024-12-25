@extends('layouts.user')

@section('content')
<div class="container mx-auto px-6 py-12 opacity-0" id="mainContainer">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-[#ff4d4d]">Learning Materials</h1>
    </div>

    @if(session('success'))
        <div class="p-4 mb-6 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-[#1a1a1a] dark:text-green-200"
            role="alert">
            {{ session('success') }}
        </div>
    @endif

    <!-- Search and Filter Section -->
    <div class="mb-8 opacity-0" id="filterSection">
        <div class="flex flex-wrap gap-4">
            <div class="flex-1">
                <input type="text" id="searchInput" placeholder="Search materials..."
                    class="w-full px-4 py-2 bg-[#151515] border border-[#1a1a1a] rounded-lg text-gray-200 focus:outline-none focus:ring focus:ring-blue-500"
                    oninput="filterCategories()">
            </div>
            <div class="flex gap-2">
                <select id="parentFilter" onchange="filterCategories()"
                    class="px-4 py-2 bg-[#151515] border border-[#1a1a1a] rounded-lg text-gray-200 focus:outline-none focus:ring focus:ring-blue-500">
                    <option value="">All Categories</option>
                    <option value="uncategorized">Uncategorized</option>
                    <option value="parent">Root Categories</option>
                    <option value="sub">Subcategories</option>
                </select>
                <select id="sortFilter" onchange="filterCategories()"
                    class="px-4 py-2 bg-[#151515] border border-[#1a1a1a] rounded-lg text-gray-200 focus:outline-none focus:ring focus:ring-blue-500">
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
        <div class="mb-12 opacity-0" id="latestCategory">
            <div
                class="bg-[#1a1a1a] border border-[#151515] rounded-lg shadow-lg p-8 transform hover:scale-[1.02] transition-transform duration-300">
                <h2 class="text-xl font-bold text-blue-500 mb-4">Recently Updated</h2>
                <div class="flex flex-col lg:flex-row gap-6 items-start">
                    <div>
                        <h3 class="text-2xl font-bold text-[#ff4d4d] mb-2">{{ $latestCategory->name }}</h3>
                        <p class="text-gray-400 mb-4 text-sm">
                            Updated: {{ $latestCategory->updated_at->format('Y-m-d') }}
                            @if($latestCategory->parent)
                                | Parent: <span class="text-blue-500">{{ $latestCategory->parent->name }}</span>
                            @endif
                        </p>
                        <p class="text-gray-300 mb-4">{{ $latestCategory->description }}</p>
                        <a href="{{ route('user.categories.show', $latestCategory) }}"
                            class="inline-block mt-4 px-6 py-2 text-sm font-medium text-white bg-[#ff4d4d] rounded-lg hover:bg-opacity-90 focus:ring-4 focus:ring-[#ff4d4d] focus:ring-opacity-50 transition-all duration-200">
                            View Details
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Categories Grid -->
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-[#ff4d4d] mb-4">Available Sources</h2>
        <div id="categoriesGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            @foreach($categories->whereNotIn('id', [$latestCategory->id]) as $category)
                <div class="category-card opacity-0 bg-[#1a1a1a] border border-[#151515] rounded-lg shadow-lg hover:shadow-xl transition-all duration-300"
                    data-name="{{ strtolower($category->name) }}"
                    data-description="{{ strtolower($category->description) }}"
                    data-parent="{{ $category->parent_id ? 'sub' : 'parent' }}"
                    data-date="{{ $category->created_at->format('Y-m-d') }}">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-xl font-bold text-[#ff4d4d]">{{ $category->name }}</h3>
                            <span class="bg-blue-500 bg-opacity-20 text-blue-500 text-xs font-semibold px-3 py-1 rounded">
                                {{ $category->learning_materials_count }} Materials
                            </span>
                        </div>

                        <p class="text-gray-400 mb-4 text-sm">
                            Created: {{ $category->created_at->format('Y-m-d') }}
                            @if($category->parent)
                                | Parent: <span class="text-blue-500">{{ $category->parent->name }}</span>
                            @endif
                        </p>

                        <p class="text-sm text-gray-400">{{ $category->description }}</p>

                        <a href="{{ route('user.categories.show', $category) }}"
                            class="block mt-6 px-4 py-2 text-center text-sm font-medium text-white bg-[#ff4d4d] rounded-lg hover:bg-opacity-90 focus:ring-4 focus:ring-[#ff4d4d] focus:ring-opacity-50 transition-all duration-200">
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
    document.addEventListener('DOMContentLoaded', () => {
        // Initial GSAP animations
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

        gsap.to('#latestCategory', {
            opacity: 1,
            y: 0,
            duration: 0.6,
            delay: 0.5,
            ease: 'power2.out'
        });

        // Animate category cards
        gsap.utils.toArray('.category-card').forEach((card, index) => {
            gsap.to(card, {
                opacity: 1,
                y: 0,
                duration: 0.5,
                delay: 0.2 * index,
                ease: 'power2.out'
            });
        });
    });

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

            if (matchesSearch && matchesParentFilter) {
                gsap.to(card, {
                    opacity: 1,
                    scale: 1,
                    duration: 0.3,
                    display: 'block'
                });
            } else {
                gsap.to(card, {
                    opacity: 0,
                    scale: 0.95,
                    duration: 0.3,
                    onComplete: () => {
                        card.style.display = 'none';
                    }
                });
            }
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

        cards.forEach((card, index) => {
            grid.appendChild(card);
            gsap.to(card, {
                opacity: 1,
                scale: 1,
                duration: 0.3,
                delay: index * 0.1
            });
        });
    }
</script>
@endsection