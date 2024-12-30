@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8" id="mainContainer">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-gray-200">Material Categories</h2>
        <button onclick="openCreateModal()"
            class="px-4 py-2 bg-[#ff4d4d] text-white rounded-lg hover:bg-[#e14444] transition-colors duration-200 transform hover:scale-105">
            Add New Category
        </button>
    </div>

    @if(session('success'))
        <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-800 dark:text-green-200"
            id="successAlert" role="alert">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="p-4 mb-4 text-sm text-red-400 rounded-lg bg-[#151515]" id="errorAlert" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Search and Filter Section -->
    <div class="mb-6 space-y-4" id="filterSection">
        <div class="flex gap-4 flex-wrap">
            <div class="flex-1 min-w-[200px]">
                <input type="text" id="searchInput" placeholder="Search categories..."
                    class="w-full px-4 py-2 bg-[#1a1a1a] border border-[#1a1a1a] rounded-lg text-gray-200 focus:outline-none focus:border-[#ff4d4d] transition-all duration-300 hover:border-[#ff4d4d]">
            </div>
            <div class="flex gap-2 flex-wrap">
                <select id="parentFilter" onchange="filterCategories()"
                    class="px-4 py-2 bg-[#1a1a1a] border border-[#1a1a1a] rounded-lg text-gray-200 focus:outline-none focus:border-[#ff4d4d] transition-all duration-300 hover:border-[#ff4d4d]">
                    <option value="">All Categories</option>
                    <option value="uncategorized">Uncategorized</option>
                    <option value="parent">Root Categories</option>
                    <option value="sub">Subcategories</option>
                </select>
                <select id="sortFilter" onchange="filterCategories()"
                    class="px-4 py-2 bg-[#1a1a1a] border border-[#1a1a1a] rounded-lg text-gray-200 focus:outline-none focus:border-[#ff4d4d] transition-all duration-300 hover:border-[#ff4d4d]">
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
            <div class="category-card bg-[#151515] border border-[#1a1a1a] rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1"
                data-name="{{ strtolower($category->name) }}" data-description="{{ strtolower($category->description) }}"
                data-parent="{{ $category->parent_id ? 'sub' : ($category->id == 0 ? 'uncategorized' : 'parent') }}"
                data-date="{{ $category->created_at ? $category->created_at->format('Y-m-d') : '0000-00-00' }}">
                <div class="p-5">
                    <div class="mb-4">
                        <div class="flex flex-col gap-2">
                            <h5 class="text-xl font-bold tracking-tight text-white break-words">
                                {{ $category->name }}
                            </h5>
                            <span class="bg-[#ff4d4d] text-white text-xs font-medium px-2.5 py-0.5 rounded-full w-fit transform hover:scale-105 transition-transform">
                                {{ $category->learning_materials_count }} Materials
                            </span>
                        </div>
                    </div>

                    <div class="text-sm text-gray-400 mb-4">
                        <p class="mb-2">Created:
                            {{ $category->created_at ? $category->created_at->format('Y-m-d') : 'N/A' }}
                        </p>
                        @if($category->parent)
                            <p class="mb-2">Parent: <span class="text-[#ff4d4d]">{{ $category->parent->name }}</span></p>
                        @endif
                        <p>{{ $category->description }}</p>
                    </div>

                    @if($category->children->count() > 0)
                        <div class="mb-4">
                            <p class="text-sm text-gray-400">Subcategories:</p>
                            <div class="flex flex-wrap gap-2 mt-2">
                                @foreach($category->children as $child)
                                    <span class="bg-[#1a1a1a] text-gray-300 text-xs px-2 py-1 rounded">
                                        {{ $child->name }}
                                        <span class="text-[#ff4d4d] ml-1">({{ $child->learning_materials_count }} Materials)</span>
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div class="flex items-center space-x-3 mt-auto">
                        @if($category->id != 0)
                            <button
                                onclick="openEditModal({{ $category->id }}, '{{ $category->name }}', '{{ $category->description }}', {{ $category->parent_id ?? 'null' }})"
                                class="px-3 py-2 text-sm font-medium text-center text-white bg-[#ff4d4d] rounded-lg hover:bg-[#e14444] focus:ring-4 focus:ring-[#ff4d4d] transition-all duration-200 transform hover:scale-105">
                                Edit
                            </button>
                        @endif

                        <a href="{{ route('admin.categories.show', $category) }}"
                            class="px-3 py-2 text-sm font-medium text-center text-white bg-blue-500 rounded-lg hover:bg-blue-600 focus:ring-4 focus:ring-blue-800 transition-all duration-200 transform hover:scale-105">
                            View
                        </a>

                        @if($category->id != 0)
                            <button onclick="openDeleteModal({{ $category->id }}, '{{ $category->name }}')"
                                class="px-3 py-2 text-sm font-medium text-center text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:ring-red-800 transition-all duration-200 transform hover:scale-105">
                                Delete
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-6">
        {{ $categories->links() }}
    </div>
</div>

<div id="categoryModal" class="fixed inset-0 bg-[#151515] bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-[#1a1a1a] rounded-lg w-full max-w-md mx-4">
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

            <form id="categoryForm" method="POST" action="{{ route('admin.categories.store') }}">
                @csrf
                <input type="hidden" id="methodField" name="_method">
                <input type="hidden" id="categoryId" name="id">

                <!-- Category Fields -->
                <div class="mb-4">
                    <label class="block text-gray-200 text-sm font-medium mb-2" for="name">
                        Category Name
                    </label>
                    <input type="text" name="name" id="name" required
                        class="w-full px-3 py-2 bg-[#151515] border border-[#1a1a1a] rounded-lg text-gray-200 focus:outline-none focus:border-[#ff4d4d]"
                        value="{{ old('name') }}">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-200 text-sm font-medium mb-2" for="description">
                        Description
                    </label>
                    <textarea name="description" id="description" rows="3"
                        class="w-full px-3 py-2 bg-[#151515] border border-[#1a1a1a] rounded-lg text-gray-200 focus:outline-none focus:border-[#ff4d4d]">{{ old('description') }}</textarea>
                </div>

                <div class="mb-6">
                    <label class="block text-gray-200 text-sm font-medium mb-2" for="parent_id">
                        Parent Category (Optional)
                    </label>
                    <select name="parent_id" id="parent_id"
                        class="w-full px-3 py-2 bg-[#151515] border border-[#1a1a1a] rounded-lg text-gray-200 focus:outline-none focus:border-[#ff4d4d]">
                        <option value="">None</option>
                        @foreach($allCategories as $cat)
                                                @php
                                                    $canBeParent = !$cat->children->isNotEmpty() && $cat->id != 0;
                                                @endphp
                                                @if($canBeParent)
                                                    <option value="{{ $cat->id }}" {{ old('parent_id') == $cat->id ? 'selected' : '' }}>
                                                        {{ $cat->name }}
                                                    </option>
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
                        class="px-4 py-2 bg-[#ff4d4d] text-white text-sm font-medium rounded-lg hover:bg-[#ff4d4d] focus:outline-none focus:ring-2 focus:ring-[#ff4d4d]">
                        Save Category
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal"
    class="fixed inset-0 bg-[#151515] bg-opacity-50 hidden items-center justify-center z-50 opacity-0">
    <div class="bg-[#1a1a1a] rounded-lg w-full max-w-md mx-4">
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
                        class="px-4 py-2 bg-[#ff4d4d] text-white text-sm font-medium rounded-lg hover:bg-[#ff4d4d] focus:outline-none focus:ring-2 focus:ring-[#ff4d4d]">
                        Delete Category
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function openCreateModal() {
        const modal = document.getElementById('categoryModal');
        const form = document.getElementById('categoryForm');
        const methodField = document.getElementById('methodField');
        const modalTitle = document.getElementById('modalTitle');
        const categoryId = document.getElementById('categoryId');

        modalTitle.textContent = 'Add Category';

        // Clear out all input fields
        document.getElementById('name').value = '';
        document.getElementById('description').value = '';
        document.getElementById('parent_id').selectedIndex = 0;

        form.action = "{{ route('admin.categories.store') }}";
        methodField.value = ''; // Clear method field
        categoryId.value = ''; // Clear category ID

        showModal(modal);
    }

    function openEditModal(id, name, description, parentId) {
        const modal = document.getElementById('categoryModal');
        const form = document.getElementById('categoryForm');
        const methodField = document.getElementById('methodField');
        const modalTitle = document.getElementById('modalTitle');
        const parentSelect = document.getElementById('parent_id');
        const categoryId = document.getElementById('categoryId');

        modalTitle.textContent = 'Edit Category';
        form.action = `/admin/categories/${id}`;
        methodField.value = 'PUT';
        categoryId.value = id;

        document.getElementById('name').value = name;
        document.getElementById('description').value = description;

        // Reset all options first
        Array.from(parentSelect.options).forEach(option => {
            option.style.display = 'block';
        });

        // Prevent the current category from being selected as a parent
        const currentOption = parentSelect.querySelector(`option[value="${id}"]`);
        if (currentOption) {
            currentOption.style.display = 'none';
        }

        parentSelect.value = parentId || '';
        showModal(modal);
    }

    function openDeleteModal(id, name) {
        const modal = document.getElementById('deleteModal');
        const form = document.getElementById('deleteForm');
        const categoryName = document.getElementById('deleteCategoryName');

        form.action = `/admin/categories/${id}`;
        categoryName.textContent = name;
        showModal(modal);
    }

    // Shared modal functions
    function showModal(modal) {
        modal.style.display = 'flex';
        modal.classList.remove('hidden');

        // Reset position and opacity before animation
        gsap.set(modal, { opacity: 0 });
        gsap.set(modal.children[0], { y: -50, opacity: 0 });

        // Animate modal background
        gsap.to(modal, {
            opacity: 1,
            duration: 0.3,
            ease: 'power2.out'
        });

        // Animate modal content
        gsap.to(modal.children[0], {
            y: 0,
            opacity: 1,
            duration: 0.3,
            delay: 0.1,
            ease: 'back.out(1.7)'
        });
    }

    function hideModal(modal) {
        // Animate modal content out
        gsap.to(modal.children[0], {
            y: -50,
            opacity: 0,
            duration: 0.2,
            ease: 'power2.in'
        });

        // Animate modal background out
        gsap.to(modal, {
            opacity: 0,
            duration: 0.2,
            ease: 'power2.in',
            onComplete: () => {
                modal.classList.add('hidden');
                modal.style.display = 'none';
            }
        });
    }

    function closeCategoryModal() {
        hideModal(document.getElementById('categoryModal'));
    }

    function closeDeleteModal() {
        hideModal(document.getElementById('deleteModal'));
    }

    // Improved filtering system
    function filterCategories() {
        const searchTerm = document.getElementById('searchInput').value.toLowerCase().trim();
        const parentFilter = document.getElementById('parentFilter').value;
        const sortFilter = document.getElementById('sortFilter').value;
        const grid = document.getElementById('categoriesGrid');
        const cards = Array.from(document.getElementsByClassName('category-card'));

        // Create or get no results message
        let noResultsMessage = document.getElementById('noResultsMessage');
        if (!noResultsMessage) {
            noResultsMessage = document.createElement('div');
            noResultsMessage.id = 'noResultsMessage';
            noResultsMessage.className = 'col-span-full text-center py-8 text-gray-400';
            noResultsMessage.innerHTML = `
            <p class="text-xl mb-2">No categories found</p>
            <p class="text-sm">Try adjusting your search or filter criteria</p>
        `;
            grid.appendChild(noResultsMessage);
        }

        // Filter cards
        const visibleCards = cards.filter(card => {
            const name = card.dataset.name || '';
            const description = card.dataset.description || '';
            const parentType = card.dataset.parent || '';

            const matchesSearch = !searchTerm ||
                name.includes(searchTerm) ||
                description.includes(searchTerm);

            const matchesParentFilter = !parentFilter ||
                parentFilter === parentType ||
                (parentFilter === 'uncategorized' && parentType === 'uncategorized');

            return matchesSearch && matchesParentFilter;
        });

        // Sort visible cards
        visibleCards.sort((a, b) => {
            switch (sortFilter) {
                case 'name-asc':
                    return (a.dataset.name || '').localeCompare(b.dataset.name || '');
                case 'name-desc':
                    return (b.dataset.name || '').localeCompare(a.dataset.name || '');
                case 'date-new':
                    return new Date(b.dataset.date || 0) - new Date(a.dataset.date || 0);
                case 'date-old':
                    return new Date(a.dataset.date || 0) - new Date(b.dataset.date || 0);
                default:
                    return 0;
            }
        });

        // Animation timeline
        const tl = gsap.timeline();

        // Hide all cards initially
        cards.forEach(card => {
            card.style.opacity = '0';
            card.style.display = 'none';
        });

        if (visibleCards.length > 0) {
            // Hide no results message
            noResultsMessage.style.display = 'none';

            // Show and animate visible cards
            visibleCards.forEach((card, index) => {
                card.style.display = 'block';
                card.style.order = index; // Maintain sort order
                tl.to(card, {
                    opacity: 1,
                    y: 0,
                    duration: 0.3,
                    delay: index * 0.05,
                    ease: 'power2.out',
                    clearProps: 'transform'
                }, index * 0.05);
            });
        } else {
            // Show no results message with animation
            noResultsMessage.style.display = 'block';
            tl.to(noResultsMessage, {
                opacity: 1,
                y: 0,
                duration: 0.3,
                ease: 'power2.out'
            });
        }
    }

    // Debounced search function
    const debounce = (func, wait) => {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    };

    // Event listeners
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('searchInput');
        const parentFilter = document.getElementById('parentFilter');
        const sortFilter = document.getElementById('sortFilter');

        // Initialize with debounced filter
        const debouncedFilter = debounce(filterCategories, 300);

        // Add event listeners
        searchInput?.addEventListener('input', debouncedFilter);
        parentFilter?.addEventListener('change', filterCategories);
        sortFilter?.addEventListener('change', filterCategories);

        // Handle modal closes on outside click
        window.onclick = function (event) {
            const categoryModal = document.getElementById('categoryModal');
            const deleteModal = document.getElementById('deleteModal');

            if (event.target === categoryModal) {
                closeCategoryModal();
            }
            if (event.target === deleteModal) {
                closeDeleteModal();
            }
        };

        // Initial filter
        filterCategories();
    });
</script>

@endsection