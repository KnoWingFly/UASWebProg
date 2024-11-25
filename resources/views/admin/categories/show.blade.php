@extends('layouts.admin')

@section('content')

<div class="container mx-auto px-4 py-8">
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-gray-200">Materials in {{ $category->name }}</h2>
        <a href="{{ route('admin.categories.index') }}"
            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
            Back to Categories
        </a>
    </div>

    @if($materials->isEmpty())
        <div class="text-center text-gray-400">
            No materials available in this category.
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            @foreach($materials as $material)
                <div class="bg-gray-800 p-4 rounded-lg shadow-lg">
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
                        <a href="{{ route('admin.materials.show', $material) }}" class="text-blue-400 hover:underline">
                            View Material
                        </a>
                    </div>
                    <div class="flex justify-between items-center">
                        <button data-modal-target="editModal-{{ $material->id }}"
                            data-modal-toggle="editModal-{{ $material->id }}"
                            class="px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700">
                            Edit
                        </button>
                        <button data-modal-target="deleteModal-{{ $material->id }}"
                            data-modal-toggle="deleteModal-{{ $material->id }}"
                            class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                            Delete
                        </button>
                    </div>
                </div>

                <!-- Edit Modal -->
                <div id="editModal-{{ $material->id }}" tabindex="-1" aria-hidden="true"
                    class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                    <div class="relative w-full max-w-2xl max-h-full">
                        <div class="relative bg-gray-700 rounded-lg shadow">
                            <div class="flex items-start justify-between p-4 border-b border-gray-600 rounded-t">
                                <h3 class="text-xl font-semibold text-white">
                                    Edit Learning Material
                                </h3>
                                <button type="button"
                                    class="text-gray-400 bg-transparent hover:bg-gray-600 hover:text-white rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center"
                                    data-modal-hide="editModal-{{ $material->id }}">
                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 14 14">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                    </svg>
                                </button>
                            </div>
                            <form action="{{ route('admin.materials.update', $material) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="p-6">
                                    <div class="mb-4">
                                        <label for="title-{{ $material->id }}"
                                            class="block mb-2 text-sm font-medium text-white">Title</label>
                                        <input type="text" name="title" id="title-{{ $material->id }}"
                                            class="bg-gray-600 border border-gray-500 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                            value="{{ $material->title }}" required>
                                    </div>
                                    <div class="mb-4">
                                        <label for="description-{{ $material->id }}"
                                            class="block mb-2 text-sm font-medium text-white">Description</label>
                                        <textarea name="description" id="description-{{ $material->id }}" rows="4"
                                            class="bg-gray-600 border border-gray-500 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">{{ $material->description }}</textarea>
                                    </div>
                                    <div class="mb-4">
                                        <label for="material_category_id-{{ $material->id }}"
                                            class="block mb-2 text-sm font-medium text-white">Category</label>
                                        <select name="material_category_id" id="material_category_id-{{ $material->id }}"
                                            class="bg-gray-600 border border-gray-500 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                            <option value="0" {{ $material->material_category_id == 0 ? 'selected' : '' }}>
                                                Uncategorized</option>
                                            @foreach($allCategories as $cat)
                                                <option value="{{ $cat->id }}" {{ $material->material_category_id == $cat->id ? 'selected' : '' }}>
                                                    {{ $cat->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-4">
                                        <label for="type-{{ $material->id }}"
                                            class="block mb-2 text-sm font-medium text-white">Type</label>
                                        <select name="type" id="type-{{ $material->id }}"
                                            class="bg-gray-600 border border-gray-500 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                            onchange="toggleContentInput({{ $material->id }})">
                                            <option value="video" {{ $material->type == 'video' ? 'selected' : '' }}>Video
                                            </option>
                                            <option value="pdf" {{ $material->type == 'pdf' ? 'selected' : '' }}>PDF</option>
                                        </select>
                                    </div>

                                    <!-- Dynamic Content Input -->
                                    <div id="content-wrapper-{{ $material->id }}" class="mb-4">
                                        <!-- Video Input -->
                                        <div id="video-input-{{ $material->id }}"
                                            class="{{ $material->type === 'pdf' ? 'hidden' : '' }}">
                                            <label for="video_url-{{ $material->id }}"
                                                class="block mb-2 text-sm font-medium text-white">Video URL</label>
                                            <input type="url" name="video_url" id="video_url-{{ $material->id }}"
                                                class="bg-gray-600 border border-gray-500 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                                value="{{ $material->type === 'video' ? $material->video_url : '' }}"
                                                placeholder="Enter video URL">
                                        </div>

                                        <!-- PDF Input -->
                                        <div id="pdf-input-{{ $material->id }}"
                                            class="{{ $material->type === 'video' ? 'hidden' : '' }}">
                                            <label for="pdf_file-{{ $material->id }}"
                                                class="block mb-2 text-sm font-medium text-white">PDF File</label>
                                            <input type="file" name="file" id="pdf_file-{{ $material->id }}" accept=".pdf"
                                                class="block w-full text-sm text-gray-400 border border-gray-500 rounded-lg cursor-pointer bg-gray-600 focus:outline-none">
                                            @if($material->type === 'pdf' && $material->file_path)
                                                <div class="mt-2 text-sm text-gray-400">
                                                    Current file: {{ basename($material->file_path) }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="flex items-center justify-end space-x-2 border-t border-gray-600 p-4">
                                    <button type="button"
                                        class="text-gray-300 bg-gray-600 hover:bg-gray-500 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg text-sm font-medium px-5 py-2.5"
                                        data-modal-hide="editModal-{{ $material->id }}">Cancel</button>
                                    <button type="submit"
                                        class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Delete Modal -->
                <div id="deleteModal-{{ $material->id }}" tabindex="-1"
                    class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                    <div class="relative w-full max-w-md max-h-full">
                        <div class="relative bg-gray-700 rounded-lg shadow">
                            <button type="button"
                                class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-600 hover:text-white rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center"
                                data-modal-hide="deleteModal-{{ $material->id }}">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                </svg>
                            </button>
                            <div class="p-6 text-center">
                                <svg class="mx-auto mb-4 text-gray-400 w-12 h-12" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                                <h3 class="mb-5 text-lg font-normal text-gray-400">Are you sure you want to delete this
                                    material?</h3>
                                <form action="{{ route('admin.materials.destroy', $material) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                                        Yes, delete it
                                    </button>
                                    <button type="button"
                                        class="text-gray-300 bg-gray-600 hover:bg-gray-500 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg text-sm font-medium px-5 py-2.5"
                                        data-modal-hide="deleteModal-{{ $material->id }}">
                                        Cancel
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $materials->links() }}
        </div>
    @endif
</div>

<script>
    function toggleContentInput(materialId) {
        const type = document.getElementById('type-' + materialId).value;
        const videoInput = document.getElementById('video-input-' + materialId);
        const pdfInput = document.getElementById('pdf-input-' + materialId);

        if (type === 'video') {
            videoInput.classList.remove('hidden');
            pdfInput.classList.add('hidden');
        } else {
            pdfInput.classList.remove('hidden');
            videoInput.classList.add('hidden');
        }
    }

    // Initialize the correct input state for each modal when the page loads
    document.addEventListener('DOMContentLoaded', function () {
        const modals = document.querySelectorAll('[id^="editModal-"]');
        modals.forEach(modal => {
            const materialId = modal.id.split('-')[1];
            toggleContentInput(materialId);
        });
    });
</script>

@endsection