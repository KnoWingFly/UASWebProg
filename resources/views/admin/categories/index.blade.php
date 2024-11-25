@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-gray-200">Material Categories</h2>
        <button onclick="openCreateModal()"
            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200">
            Add New Category
        </button>
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
                    <option value="parent">Parent Categories</option>
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
                <!-- Rest of the category card content remains the same -->
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
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div class="flex items-center space-x-3 mt-auto">
                        <button onclick="openEditModal(
                                            {{ $category->id }}, 
                                            '{{ $category->name }}', 
                                            '{{ $category->description }}', 
                                            {{ $category->parent_id ?? 'null' }}
                                        )"
                            class="px-3 py-2 text-sm font-medium text-center text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-800 transition-colors duration-200">
                            Edit
                        </button>

                        <a href="{{ route('admin.categories.show', $category) }}"
                            class="px-3 py-2 text-sm font-medium text-center text-white bg-green-600 rounded-lg hover:bg-green-700 focus:ring-4 focus:ring-green-800 transition-colors duration-200">
                            View
                        </a>

                        <button onclick="openDeleteModal({{ $category->id }}, '{{ $category->name }}')"
                            class="px-3 py-2 text-sm font-medium text-center text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:ring-red-800 transition-colors duration-200">
                            Delete
                        </button>
                    </div>
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

                <div class="flex items-center space-x-3 mt-auto">
                    <a href="{{ route('admin.categories.show', 'uncategorized') }}"
                        class="px-3 py-2 text-sm font-medium text-center text-white bg-green-600 rounded-lg hover:bg-green-700 focus:ring-4 focus:ring-green-800 transition-colors duration-200">
                        View the uncategorized
                    </a>

                </div>
            </div>
        </div>
    </div>

    <div class="mt-6">
        {{ $categories->links() }}
    </div>
</div>

<!-- Create/Edit Modal -->
<div id="categoryModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-gray-800 rounded-lg w-full max-w-md mx-4">
        <div class="p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 id="modalTitle" class="text-xl font-semibold text-gray-200"></h3>
                <button onclick="closeCategoryModal()" class="text-gray-400 hover:text-gray-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>

            <form id="categoryForm" method="POST">
                @csrf
                <div id="methodField"></div>

                <div class="mb-4">
                    <label class="block text-gray-200 text-sm font-medium mb-2" for="name">
                        Category Name
                    </label>
                    <input type="text" name="name" id="name" required
                        class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-gray-200 focus:outline-none focus:border-blue-500">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-200 text-sm font-medium mb-2" for="description">
                        Description
                    </label>
                    <textarea name="description" id="description" rows="3"
                        class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-gray-200 focus:outline-none focus:border-blue-500"></textarea>
                </div>

                <div class="mb-6">
                    <label class="block text-gray-200 text-sm font-medium mb-2" for="parent_id">
                        Parent Category (Optional)
                    </label>
                    <select name="parent_id" id="parent_id"
                        class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-gray-200 focus:outline-none focus:border-blue-500">
                        <option value="">None</option>
                        @foreach($allCategories as $cat)
                            @if(!$cat->parent_id)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>

                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeCategoryModal()"
                        class="px-4 py-2 text-sm font-medium text-gray-400 hover:text-gray-200">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        Save Category
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-gray-800 rounded-lg w-full max-w-md mx-4">
        <div class="p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold text-gray-200">Confirm Delete</h3>
                <button onclick="closeDeleteModal()" class="text-gray-400 hover:text-gray-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>

            <p class="text-gray-300 mb-6">Are you sure you want to delete <span id="deleteCategoryName"
                    class="font-semibold"></span>? This action cannot be undone.</p>

            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')

                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeDeleteModal()"
                        class="px-4 py-2 text-sm font-medium text-gray-400 hover:text-gray-200">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                        Delete Category
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Category Modal Functions
    function openCreateModal() {
        const modal = document.getElementById('categoryModal');
        const form = document.getElementById('categoryForm');
        const methodField = document.getElementById('methodField');
        const modalTitle = document.getElementById('modalTitle');

        modalTitle.textContent = 'Add Category';
        form.reset();
        form.action = "{{ route('admin.categories.store') }}";
        methodField.innerHTML = '';

        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function openEditModal(id, name, description, parentId) {
        const modal = document.getElementById('categoryModal');
        const form = document.getElementById('categoryForm');
        const methodField = document.getElementById('methodField');
        const modalTitle = document.getElementById('modalTitle');

        modalTitle.textContent = 'Edit Category';
        form.action = `/admin/categories/${id}`;
        methodField.innerHTML = '@method("PUT")';

        document.getElementById('name').value = name;
        document.getElementById('description').value = description;
        document.getElementById('parent_id').value = parentId || '';

        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeCategoryModal() {
        const modal = document.getElementById('categoryModal');
        modal.classList.remove('flex');
        modal.classList.add('hidden');
    }

    // Delete Modal Functions
    function openDeleteModal(id, name) {
        const modal = document.getElementById('deleteModal');
        const form = document.getElementById('deleteForm');
        const categoryName = document.getElementById('deleteCategoryName');

        form.action = `/admin/categories/${id}`;
        categoryName.textContent = name;

        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeDeleteModal() {
        const modal = document.getElementById('deleteModal');
        modal.classList.remove('flex');
        modal.classList.add('hidden');
    }

    // Close modals when clicking outside
    window.onclick = function (event) {
        const categoryModal = document.getElementById('categoryModal');
        const deleteModal = document.getElementById('deleteModal');

        if (event.target === categoryModal) {
            closeCategoryModal();
        }
        if (event.target === deleteModal) {
            closeDeleteModal();
        }
    }

    function filterCategories() {
        const searchTerm = document.getElementById('searchInput').value.toLowerCase();
        const parentFilter = document.getElementById('parentFilter').value;
        const sortFilter = document.getElementById('sortFilter').value;
        const cards = Array.from(document.getElementsByClassName('category-card'));

        // Filter cards based on search term and parent filter
        cards.forEach(card => {
            const name = card.dataset.name;
            const description = card.dataset.description;
            const parentType = card.dataset.parent;

            const matchesSearch = name.includes(searchTerm) || description.includes(searchTerm);
            const matchesParentFilter = parentFilter === '' || parentFilter === parentType;

            card.style.display = matchesSearch && matchesParentFilter ? 'block' : 'none';
        });

        // Sort filtered cards
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

        // Reorder cards in the DOM
        cards.forEach(card => grid.appendChild(card));
    }

    // Initialize filtering on page load
    document.addEventListener('DOMContentLoaded', function () {
        filterCategories();
    });
</script>

@endsection