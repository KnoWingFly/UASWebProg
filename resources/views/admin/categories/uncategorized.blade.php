@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-gray-200">Uncategorized Materials</h2>
        <a href="{{ route('admin.categories.index') }}" 
           class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors duration-200">
            Back to Categories
        </a>
    </div>

    @if(session('success'))
        <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-800 dark:text-green-200"
            role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @if($materials->isEmpty())
            <p class="text-gray-400 text-center col-span-full py-8">No uncategorized materials found.</p>
        @else
            @foreach($materials as $material)
                @if($material) {{-- Ensure $material is not null --}}
                    <div class="bg-gray-800 rounded-lg shadow-lg overflow-hidden">
                        <div class="p-6">
                            <h3 class="text-xl font-semibold text-gray-200">{{ $material->title }}</h3>
                            <p class="text-gray-400 mt-2">{{ $material->type }}</p>
                            <p class="text-gray-500 mt-2">Created: {{ $material->created_at->format('Y-m-d') }}</p>
                            
                            <div class="flex space-x-4 mt-4">
                                <!-- View Button -->
                                <a href="{{ route('admin.materials.show', $material->id) }}"
                                   class="px-4 py-2 text-sm bg-blue-600 text-white rounded hover:bg-blue-700">
                                   View
                                </a>

                                <!-- Edit Button (Trigger Modal) -->
                                <button type="button" 
                                        data-modal-toggle="editMaterialModal" 
                                        data-id="{{ $material->id }}" 
                                        data-title="{{ $material->title }}"
                                        data-type="{{ $material->type }}"
                                        class="px-4 py-2 text-sm bg-green-600 text-white rounded hover:bg-green-700">
                                    Edit
                                </button>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        @endif
    </div>

    <div class="mt-6">
        {{ $materials->links() }}
    </div>
</div>

<!-- Edit Material Modal -->
<div id="editMaterialModal" tabindex="-1" aria-hidden="true" class="fixed inset-0 z-50 hidden bg-gray-800 bg-opacity-50 flex justify-center items-center">
    <div class="relative w-full max-w-md bg-white rounded-lg shadow-lg">
        <div class="flex justify-between items-center p-4 border-b border-gray-300">
            <h3 class="text-lg font-semibold text-gray-700">Edit Material</h3>
            <button type="button" data-modal-toggle="editMaterialModal" class="text-gray-500 hover:text-gray-700">
                <span class="sr-only">Close</span>
                <i class="fas fa-times"></i>
            </button>
        </div>

        <!-- Edit Form -->
        <form action="{{ route('admin.materials.update', 0) }}" method="POST" id="editMaterialForm" class="p-4">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="edit-title" class="block text-gray-700">Title</label>
                <input type="text" id="edit-title" name="title" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required />
            </div>
            <div class="mb-4">
                <label for="edit-type" class="block text-gray-700">Type</label>
                <input type="text" id="edit-type" name="type" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required />
            </div>
            <div class="flex justify-end">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // JavaScript to handle the modal and pre-fill form data
    document.querySelectorAll('[data-modal-toggle="editMaterialModal"]').forEach(button => {
        button.addEventListener('click', () => {
            const materialId = button.getAttribute('data-id');
            const materialTitle = button.getAttribute('data-title');
            const materialType = button.getAttribute('data-type');

            const modal = document.getElementById('editMaterialModal');
            const form = document.getElementById('editMaterialForm');

            // Update form action
            form.action = `{{ route('admin.materials.update', '') }}/${materialId}`;
            
            // Pre-fill the form
            document.getElementById('edit-title').value = materialTitle;
            document.getElementById('edit-type').value = materialType;

            // Show modal
            modal.classList.remove('hidden');
        });
    });

    // Close modal when clicking outside
    const modal = document.getElementById('editMaterialModal');
    modal.addEventListener('click', (event) => {
        if (event.target === modal) {
            modal.classList.add('hidden');
        }
    });
</script>

@endsection
