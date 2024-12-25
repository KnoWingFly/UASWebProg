@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-[#151515] text-white p-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-white">UMN PC Learning Materials</h1>
            <div class="flex space-x-4">
                <button class="p-2 hover:bg-[#1a1a1a] rounded-lg">
                </button>
            </div>
        </div>

        @if(session('success'))
            <div class="p-4 mb-4 text-sm text-green-400 rounded-lg bg-[#1a1a1a]" role="alert">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="p-4 mb-4 text-sm text-red-400 rounded-lg bg-[#1a1a1a]" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Admin Upload Panel -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-12">
            <!-- Upload PDF Card -->
            <div class="bg-[#1a1a1a] p-6 rounded-lg text-center">
                <div class="flex justify-center mb-4">
                    <svg class="w-12 h-12 text-[#ff4d4d]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-4">Upload PDF</h3>
                <p class="text-gray-400 mb-4">Upload new PDF resources.</p>
                <button data-modal-target="pdf-upload-modal" data-modal-toggle="pdf-upload-modal"
                    class="w-full flex items-center justify-center px-4 py-2 bg-[#ff4d4d] hover:bg-[#e04343] text-white rounded-lg transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Upload PDF
                </button>
            </div>

            <!-- Upload Video Card -->
            <div class="bg-[#1a1a1a] p-6 rounded-lg text-center">
                <div class="flex justify-center mb-4">
                    <svg class="w-12 h-12 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-4">Upload Video</h3>
                <p class="text-gray-400 mb-4">Upload new Video resources.</p>
                <button data-modal-target="video-upload-modal" data-modal-toggle="video-upload-modal"
                    class="w-full flex items-center justify-center px-4 py-2 bg-[#ff4d4d] hover:bg-[#e04343] text-white rounded-lg transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Add Video
                </button>
            </div>

            <!-- Categories Card -->
            <div class="bg-[#1a1a1a] p-6 rounded-lg text-center">
                <div class="flex justify-center mb-4">
                    <svg class="w-12 h-12 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-4">Categories</h3>
                <p class="text-gray-400 mb-4">Manage material categories.</p>
                <button data-modal-target="category-modal" data-modal-toggle="category-modal"
                    class="w-full flex items-center justify-center px-4 py-2 bg-purple-500 hover:bg-purple-600 text-white rounded-lg transition-colors mb-2">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Add Category
                </button>
                <a href="{{ route('admin.categories.index') }}"
                    class="w-full flex items-center justify-center px-4 py-2 bg-[#151515] hover:bg-[#1a1a1a] text-white rounded-lg transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    Manage Categories
                </a>
            </div>
        </div>


        <!-- Recent Uploads -->
<div class="bg-[#151515] rounded-lg p-6">
    <h2 class="text-xl font-semibold text-white mb-6">Recent Uploads</h2>
    @if($recentMaterials->isNotEmpty())
        @foreach($recentMaterials as $material)
            <div class="flex items-center justify-between p-4 hover:bg-[#1a1a1a] rounded-lg transition-colors"
                data-id="{{ $material->id }}" data-type="{{ $material->type }}" data-title="{{ $material->title }}"
                data-description="{{ $material->description }}"
                data-url="{{ $material->type === 'video' ? $material->video_url : '' }}"
                data-downloads="{{ $material->downloads }}" data-views="{{ $material->views }}"
                data-category="{{ $material->category->name ?? 'Uncategorized' }}">
                <div class="flex items-center space-x-4">
                    @if($material->type === 'pdf')
                        <svg class="w-5 h-5 text-[#ff4d4d]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    @else
                        <svg class="w-5 h-5 text-[#ff4d4d]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </svg>
                    @endif
                    <div>
                        <p class="text-sm text-gray-400">{{ ucfirst($material->type) }}</p>
                        <p class="font-medium text-white">{{ $material->title }}</p>
                        <p class="text-sm text-gray-400">
                            {{ $material->type === 'pdf' ? $material->downloads . ' Downloads' : $material->views . ' Views' }}
                        </p>
                        <p class="text-xs text-gray-500">{{ $material->created_at->diffForHumans() }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <p class="text-gray-400 text-center">No recent uploads available.</p>
    @endif
</div>

<!-- Category Modal -->
<div id="category-modal" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <div class="relative bg-[#1a1a1a] rounded-lg shadow">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-[#151515]">
                <h3 class="text-xl font-semibold text-white">
                    Add Category
                </h3>
                <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-[#1a1a1a] rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                    data-modal-hide="category-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                </button>
            </div>
            <form class="p-4 md:p-5" action="{{ route('admin.categories.store') }}" method="POST">
                @csrf
                <div class="grid gap-4 mb-4">
                    <div>
                        <label for="name" class="block mb-2 text-sm font-medium text-white">Category Name</label>
                        <input type="text" name="name" id="name"
                            class="bg-[#1a1a1a] border border-[#151515] text-white text-sm rounded-lg focus:ring-[#ff4d4d] focus:border-[#ff4d4d] block w-full p-2.5"
                            required>
                    </div>
                    <div>
                        <label for="description" class="block mb-2 text-sm font-medium text-white">Description</label>
                        <textarea name="description" id="description" rows="4"
                            class="block p-2.5 w-full text-sm text-white bg-[#1a1a1a] rounded-lg border border-[#151515] focus:ring-[#ff4d4d] focus:border-[#ff4d4d]"></textarea>
                    </div>
                    <div>
                        <label for="parent_id" class="block mb-2 text-sm font-medium text-white">Parent Category
                            (Optional)</label>
                        <select name="parent_id" id="parent_id"
                            class="bg-[#1a1a1a] border border-[#151515] text-white text-sm rounded-lg focus:ring-[#ff4d4d] focus:border-[#ff4d4d] block w-full p-2.5">
                            <option value="">None</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <button type="submit"
                    class="text-white inline-flex items-center bg-[#ff4d4d] hover:bg-[#e94545] focus:ring-4 focus:outline-none focus:ring-[#ff4d4d] font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                    <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                            clip-rule="evenodd"></path>
                    </svg>
                    Add category
                </button>
            </form>
        </div>
    </div>
</div>


    <!-- PDF Upload Modal -->
<div id="pdf-upload-modal" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <div class="relative bg-[#1a1a1a] rounded-lg shadow">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-[#151515]">
                <h3 class="text-xl font-semibold text-white">
                    Upload PDF
                </h3>
                <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-[#151515] rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                    data-modal-hide="pdf-upload-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                </button>
            </div>
            <form class="p-4 md:p-5" action="{{ route('admin.materials.store') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="type" value="pdf">
                <div class="grid gap-4 mb-4">
                    <div>
                        <label for="pdf_title" class="block mb-2 text-sm font-medium text-white">Title</label>
                        <input type="text" name="title" id="pdf_title"
                            class="bg-[#1a1a1a] border border-[#151515] text-white text-sm rounded-lg focus:ring-[#ff4d4d] focus:border-[#ff4d4d] block w-full p-2.5"
                            required>
                    </div>
                    <div>
                        <label for="pdf_description"
                            class="block mb-2 text-sm font-medium text-white">Description</label>
                        <textarea name="description" id="pdf_description" rows="4"
                            class="block p-2.5 w-full text-sm text-white bg-[#1a1a1a] rounded-lg border border-[#151515] focus:ring-[#ff4d4d] focus:border-[#ff4d4d]"></textarea>
                    </div>
                    <div>
                        <label for="pdf_category" class="block mb-2 text-sm font-medium text-white">Category</label>
                        <select name="material_category_id" id="pdf_category"
                            class="bg-[#1a1a1a] border border-[#151515] text-white text-sm rounded-lg focus:ring-[#ff4d4d] focus:border-[#ff4d4d] block w-full p-2.5"
                            required>
                            <option value="0" {{ old('material_category_id', $material->material_category_id ?? 0) == 0 ? 'selected' : '' }}>
                                Uncategorized</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('material_category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-white" for="pdf_file">Upload PDF</label>
                        <input type="file" name="file" id="pdf_file" accept=".pdf"
                            class="block w-full text-sm text-gray-400 border border-[#151515] rounded-lg cursor-pointer bg-[#1a1a1a] focus:outline-none"
                            required>
                    </div>
                </div>
                <button type="submit"
                    class="text-white inline-flex items-center bg-[#ff4d4d] hover:bg-[#e04343] focus:ring-4 focus:outline-none focus:ring-[#ff4d4d] font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                    <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                            clip-rule="evenodd"></path>
                    </svg>
                    Upload PDF
                </button>
            </form>
        </div>
    </div>
</div>

    <!-- Material Details Modal -->
<div id="material-detail-modal" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <div class="relative bg-[#1a1a1a] rounded-lg shadow">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-[#151515]">
                <h3 class="text-xl font-semibold text-white material-title">
                    <!-- Title will be inserted dynamically -->
                </h3>
                <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-[#151515] rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                    data-modal-hide="material-detail-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                </button>
            </div>
            <div class="p-4 md:p-5 space-y-4">
                <p class="text-gray-400 material-description">
                    <!-- Description will be inserted dynamically -->
                </p>

                <!-- Category content -->
                <p class="text-gray-400 category-content hidden"></p>

                <!-- PDF Content -->
                <div class="pdf-content hidden">
                    <div class="flex justify-between items-center">
                        <a href="#"
                            class="download-btn inline-flex items-center px-4 py-2 bg-[#ff4d4d] hover:bg-[#e04343] text-white rounded-lg transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                            Download PDF
                        </a>
                    </div>
                </div>

                <!-- Video Content -->
                <div class="video-content hidden">
                    <div class="aspect-w-16 aspect-h-9">
                        <iframe class="w-full h-96 rounded-lg video-frame" src="" frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Video Upload Modal -->
<div id="video-upload-modal" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <div class="relative bg-[#1a1a1a] rounded-lg shadow">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-[#151515]">
                <h3 class="text-xl font-semibold text-white">
                    Add Video
                </h3>
                <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-[#151515] rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                    data-modal-hide="video-upload-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                </button>
            </div>
            <form class="p-4 md:p-5" action="{{ route('admin.materials.store') }}" method="POST">
                @csrf
                <input type="hidden" name="type" value="video">
                <div class="grid gap-4 mb-4">
                    <div>
                        <label for="video_title" class="block mb-2 text-sm font-medium text-white">Title</label>
                        <input type="text" name="title" id="video_title"
                            class="bg-[#1a1a1a] border border-[#151515] text-white text-sm rounded-lg focus:ring-[#ff4d4d] focus:border-[#ff4d4d] block w-full p-2.5"
                            required>
                    </div>
                    <div>
                        <label for="video_description"
                            class="block mb-2 text-sm font-medium text-white">Description</label>
                        <textarea name="description" id="video_description" rows="4"
                            class="block p-2.5 w-full text-sm text-white bg-[#1a1a1a] rounded-lg border border-[#151515] focus:ring-[#ff4d4d] focus:border-[#ff4d4d]"></textarea>
                    </div>
                    <div>
                        <label for="video_category"
                            class="block mb-2 text-sm font-medium text-white">Category</label>
                        <select name="material_category_id" id="pdf_category"
                            class="bg-[#1a1a1a] border border-[#151515] text-white text-sm rounded-lg focus:ring-[#ff4d4d] focus:border-[#ff4d4d] block w-full p-2.5"
                            required>
                            <option value="0" {{ old('material_category_id', $material->material_category_id ?? 0) == 0 ? 'selected' : '' }}>
                                Uncategorized</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('material_category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="video_url" class="block mb-2 text-sm font-medium text-white">Video URL</label>
                        <input type="url" name="video_url" id="video_url"
                            class="bg-[#1a1a1a] border border-[#151515] text-white text-sm rounded-lg focus:ring-[#ff4d4d] focus:border-[#ff4d4d] block w-full p-2.5"
                            required>
                        <p class="mt-1 text-sm text-gray-400">Enter YouTube URL</p>
                    </div>
                </div>
                <button type="submit"
                    class="text-white inline-flex items-center bg-[#ff4d4d] hover:bg-[#e04343] focus:ring-4 focus:outline-none focus:ring-[#ff4d4d] font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                    <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                            clip-rule="evenodd"></path>
                    </svg>
                    Add Video
                </button>
            </form>
        </div>
    </div>
</div>
</div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Initialize Flowbite modal
        const materialDetailModal = document.getElementById('material-detail-modal');
        const modalOptions = {
            backdrop: 'static',
            backdropClasses: 'bg-gray-900 bg-opacity-50 dark:bg-opacity-80 fixed inset-0 z-40'
        };
        const modal = new Modal(materialDetailModal, modalOptions);

        // Add click event listeners to recent uploads
        const recentItems = document.querySelectorAll('.flex.items-center.justify-between.p-4.hover\\:bg-gray-700');
        recentItems.forEach(item => {
            item.addEventListener('click', function () {
                const materialType = this.querySelector('svg').classList.contains('text-blue-500') ? 'pdf' : 'video';
                const titleElement = this.querySelector('.font-medium.text-white');
                const descriptionElement = this.querySelector('.text-sm.text-gray-400');

                const materialData = {
                    type: materialType,
                    title: titleElement ? titleElement.textContent : '',
                    description: this.getAttribute('data-description'),
                    downloads: materialType === 'pdf' ?
                        descriptionElement.textContent.split(' ')[0] : 0,
                    views: materialType === 'video' ?
                        descriptionElement.textContent.split(' ')[0] : 0,
                    url: this.dataset.url || '',
                    id: this.dataset.id || '',
                    category: this.dataset.category || 'Uncategorized'
                };

                // Update modal content
                const modalTitle = materialDetailModal.querySelector('.material-title');
                const modalDescription = materialDetailModal.querySelector('.material-description');
                const pdfContent = materialDetailModal.querySelector('.pdf-content');
                const videoContent = materialDetailModal.querySelector('.video-content');
                const categoryContent = materialDetailModal.querySelector('.category-content');

                modalTitle.textContent = materialData.title;
                modalDescription.textContent = materialData.description;

                // Hide both content sections initially
                pdfContent.classList.add('hidden');
                videoContent.classList.add('hidden');
                categoryContent.classList.add('hidden');

                // Display category name dynamically
                categoryContent.textContent = `Category: ${materialData.category}`;
                categoryContent.classList.remove('hidden');

                if (materialData.type === 'pdf') {
                    pdfContent.classList.remove('hidden');
                    const downloadBtn = pdfContent.querySelector('.download-btn');


                    // Update download button
                    downloadBtn.onclick = function (e) {
                        e.preventDefault();
                        e.stopPropagation();

                        // Open in new tab to handle the download
                        window.open(`/admin/materials/${materialData.id}/download`, '_blank');
                        return false;
                    };
                } else if (materialData.type === 'video' && materialData.url) {
                    videoContent.classList.remove('hidden');
                    const videoFrame = videoContent.querySelector('.video-frame');

                    // Fixing YouTube regex
                    const youtubeRegex = /(?:youtube\.com\/(?:[^/]+\/[^/]+\/|(?:v|e(?:mbed)?)\/|(?:watch(?:_popup)?)?\?v=)|youtu\.be\/)([a-zA-Z0-9_-]+)/;
                    const match = materialData.url.match(youtubeRegex);

                    if (match && match[1]) {
                        const videoId = match[1];
                        videoFrame.src = `https://www.youtube.com/embed/${videoId}?autoplay=1`;
                    } else {
                        videoFrame.src = '';
                    }
                }
                modal.show();
            });
        });

        function stopVideo(modalElement) {
            const videoFrame = modalElement.querySelector('.video-frame');
            if (videoFrame) {
                videoFrame.src = ''; // Clear the src to stop playback
            }
        }

        // Corrected modal hide event handling for Flowbite
        materialDetailModal.addEventListener('hidden.bs.modal', function () {
            stopVideo(materialDetailModal);
        });

        const closeModalButton = materialDetailModal.querySelector('[data-modal-hide="material-detail-modal"]');
        closeModalButton.addEventListener('click', function () {
            modal.hide();
            stopVideo(materialDetailModal);
        });

        document.querySelectorAll('.download-btn').forEach(button => {
            button.addEventListener('click', function (event) {
                event.preventDefault();

                const downloadUrl = this.href;
                const materialTitle = this.getAttribute('data-title') || 'document';

                window.location.href = downloadUrl;
            });
        });



    });
</script>
@endsection
