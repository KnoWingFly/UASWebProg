@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-[#151515] text-white p-8 opacity-0" id="mainContainer">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8 opacity-0 translate-y-[-20px]" id="header">
            <h1 class="text-3xl font-bold text-white">UMN PC Learning Materials</h1>
        </div>

        <!-- Alerts -->
        @if(session('success'))
            <div class="p-4 mb-4 text-sm text-green-400 rounded-lg bg-[#1a1a1a] opacity-0 translate-y-[-20px]"
                id="alertSuccess" role="alert">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="p-4 mb-4 text-sm text-[#ff4d4d] rounded-lg bg-[#1a1a1a] opacity-0 translate-y-[-20px]"
                id="alertError" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Admin Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
            <!-- PDF Upload Card -->
            <div
                class="admin-card bg-[#1a1a1a] p-6 rounded-lg shadow-lg opacity-0 translate-y-[30px] hover:shadow-xl transition-all duration-300">
                <div class="flex justify-center mb-4">
                    <svg class="w-12 h-12 text-[#ff4d4d]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-4 text-center">Upload PDF</h3>
                <p class="text-gray-400 mb-4 text-center">Upload new PDF resources</p>
                <button data-modal-target="pdf-upload-modal" data-modal-toggle="pdf-upload-modal"
                    class="btn-animate w-full flex items-center justify-center px-4 py-2 bg-[#ff4d4d] hover:bg-opacity-90 text-white rounded-lg">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Upload PDF
                </button>
            </div>

            <!-- Video Upload Card -->
            <div
                class="admin-card bg-[#1a1a1a] p-6 rounded-lg shadow-lg opacity-0 translate-y-[30px] hover:shadow-xl transition-all duration-300">
                <div class="flex justify-center mb-4">
                    <svg class="w-12 h-12 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-4 text-center">Upload Video</h3>
                <p class="text-gray-400 mb-4 text-center">Upload new video resources</p>
                <button data-modal-target="video-upload-modal" data-modal-toggle="video-upload-modal"
                    class="btn-animate w-full flex items-center justify-center px-4 py-2 bg-blue-500 hover:bg-opacity-90 text-white rounded-lg">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Add Video
                </button>
            </div>

            <!-- Categories Card -->
            <div
                class="admin-card bg-[#1a1a1a] p-6 rounded-lg shadow-lg opacity-0 translate-y-[30px] hover:shadow-xl transition-all duration-300">
                <div class="flex justify-center mb-4">
                    <svg class="w-12 h-12 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-4 text-center">Categories</h3>
                <p class="text-gray-400 mb-4 text-center">Manage material categories</p>
                <div class="space-y-2">
                    <button data-modal-target="category-modal" data-modal-toggle="category-modal"
                        class="w-full flex items-center justify-center px-4 py-2 bg-purple-500 hover:bg-purple-600 text-white rounded-lg transition-all duration-300 transform hover:scale-105">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Add Category
                    </button>
                    <a href="{{ route('admin.categories.index') }}"
                        class="w-full flex items-center justify-center px-4 py-2 bg-[#1f1f1f] hover:bg-[#2a2a2a] text-white rounded-lg transition-all duration-300 transform hover:scale-105">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        Manage Categories
                    </a>
                </div>
            </div>
        </div>

        <!-- Recent Uploads -->
        <div class="bg-[#1a1a1a] rounded-lg p-6 opacity-0 translate-y-[30px]" id="recentUploads">
            <h2 class="text-xl font-semibold text-white mb-6">Recent Uploads</h2>
            @if($recentMaterials->isNotEmpty())
                @foreach($recentMaterials as $material)
                    <div class="recent-item flex items-center justify-between p-4 hover:bg-[#1a1a1a] rounded-lg transition-all duration-300 transform hover:scale-[1.02] opacity-0"
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
            class="hidden fixed top-0 left-0 right-0 z-50 w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full flex items-center justify-center">
            <div class="relative w-full max-w-md max-h-full">
                <!-- Modal content -->
                <div class="relative bg-[#1a1a1a] rounded-lg shadow">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-gray-800">
                        <h3 class="text-xl font-semibold text-white">
                            Add Category
                        </h3>
                        <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-800 hover:text-white rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                            data-modal-hide="category-modal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <form class="p-4 md:p-5" action="{{ route('admin.categories.store') }}" method="POST">
                        @csrf
                        <div class="grid gap-4 mb-4">
                            <div>
                                <label for="category_name" class="block mb-2 text-sm font-medium text-white">Category
                                    Name</label>
                                <input type="text" name="name" id="category_name"
                                    class="bg-[#252525] border border-gray-700 text-white text-sm rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5"
                                    required>
                            </div>
                            <div>
                                <label for="category_description"
                                    class="block mb-2 text-sm font-medium text-white">Description</label>
                                <textarea name="description" id="category_description" rows="4"
                                    class="bg-[#252525] border border-gray-700 text-white text-sm rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5"></textarea>
                            </div>
                            <div>
                                <label for="parent_id" class="block mb-2 text-sm font-medium text-white">Parent
                                    Category</label>
                                <select name="parent_id" id="parent_id"
                                    class="bg-[#252525] border border-gray-700 text-white text-sm rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5">
                                    <option value="">None</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <button type="submit"
                            class="text-white inline-flex items-center bg-purple-500 hover:bg-purple-600 focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                            <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            Add Category
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
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
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
                                <label for="pdf_category"
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
                                <label class="block mb-2 text-sm font-medium text-white" for="pdf_file">Upload
                                    PDF</label>
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
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
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
            class="hidden fixed top-0 left-0 right-0 z-50 w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full flex items-center justify-center">
            <div class="relative w-full max-w-md max-h-full">
                <!-- Modal content -->
                <div class="relative bg-[#1a1a1a] rounded-lg shadow">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-gray-800">
                        <h3 class="text-xl font-semibold text-white">
                            Add Video
                        </h3>
                        <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-800 hover:text-white rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                            data-modal-hide="video-upload-modal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <form class="p-4 md:p-5" action="{{ route('admin.materials.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="type" value="video">
                        <div class="grid gap-4 mb-4">
                            <div>
                                <label for="video_title" class="block mb-2 text-sm font-medium text-white">Title</label>
                                <input type="text" name="title" id="video_title"
                                    class="bg-[#252525] border border-gray-700 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                    required>
                            </div>
                            <div>
                                <label for="video_description"
                                    class="block mb-2 text-sm font-medium text-white">Description</label>
                                <textarea name="description" id="video_description" rows="4"
                                    class="bg-[#252525] border border-gray-700 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"></textarea>
                            </div>
                            <div>
                                <label for="video_url" class="block mb-2 text-sm font-medium text-white">Video
                                    URL</label>
                                <input type="url" name="video_url" id="video_url"
                                    class="bg-[#252525] border border-gray-700 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                    required placeholder="https://www.youtube.com/watch?v=...">
                            </div>
                            <div>
                                <label for="video_category"
                                    class="block mb-2 text-sm font-medium text-white">Category</label>
                                <select name="material_category_id" id="video_category"
                                    class="bg-[#252525] border border-gray-700 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                    <option value="0">Uncategorized</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <button type="submit"
                            class="text-white inline-flex items-center bg-blue-500 hover:bg-blue-600 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
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

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Initialize all modals
                const modals = {
                    'video-upload-modal': {
                        id: 'video-upload-modal',
                        modal: null,
                    },
                    'category-modal': {
                        id: 'category-modal',
                        modal: null,
                    },
                    'pdf-upload-modal': {
                        id: 'pdf-upload-modal',
                        modal: null,
                    }
                };

                // Initialize each modal
                Object.keys(modals).forEach(modalId => {
                    const modalElement = document.getElementById(modalId);
                    if (modalElement) {
                        modals[modalId].modal = new Modal(modalElement, {
                            placement: 'center',
                            backdrop: 'dynamic',
                            onShow: () => {
                                gsap.fromTo(modalElement.querySelector('.relative'), {
                                    opacity: 0,
                                    y: -50,
                                    scale: 0.95
                                }, {
                                    opacity: 1,
                                    y: 0,
                                    scale: 1,
                                    duration: 0.3,
                                    ease: 'back.out(1.2)'
                                });
                            },
                            onHide: () => {
                                gsap.to(modalElement.querySelector('.relative'), {
                                    opacity: 0,
                                    y: -50,
                                    scale: 0.95,
                                    duration: 0.2,
                                    ease: 'power2.in'
                                });
                            }
                        });
                    }
                });

                // Add click handlers for modal triggers
                document.querySelectorAll('[data-modal-toggle]').forEach(trigger => {
                    trigger.addEventListener('click', (e) => {
                        e.preventDefault();
                        const targetModalId = trigger.getAttribute('data-modal-target');
                        if (modals[targetModalId] && modals[targetModalId].modal) {
                            modals[targetModalId].modal.show();
                        }
                    });
                });

                // Add click handlers for modal close buttons
                document.querySelectorAll('[data-modal-hide]').forEach(closeBtn => {
                    closeBtn.addEventListener('click', (e) => {
                        e.preventDefault();
                        const targetModalId = closeBtn.getAttribute('data-modal-hide');
                        if (modals[targetModalId] && modals[targetModalId].modal) {
                            modals[targetModalId].modal.hide();
                        }
                    });
                });
            });
        </script>


        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Initialize GSAP
                gsap.registerPlugin(ScrollTrigger);

                // Main Timeline for Initial Animations
                const tl = gsap.timeline();

                // Main container fade in
                tl.to('#mainContainer', {
                    opacity: 1,
                    duration: 0.8,
                    ease: 'power2.out'
                })
                    // Header animation
                    .to('#header', {
                        opacity: 1,
                        y: 0,
                        duration: 0.6,
                        ease: 'back.out(1.2)'
                    })
                    // Alert animations
                    .to('#alertSuccess, #alertError', {
                        opacity: 1,
                        y: 0,
                        duration: 0.4,
                        stagger: 0.2,
                        ease: 'back.out(1.2)'
                    })
                    // Admin cards stagger animation
                    .to('.admin-card', {
                        opacity: 1,
                        y: 0,
                        duration: 0.6,
                        stagger: 0.15,
                        ease: 'back.out(1.2)'
                    })
                    // Recent uploads section
                    .to('#recentUploads', {
                        opacity: 1,
                        y: 0,
                        duration: 0.6,
                        ease: 'back.out(1.2)'
                    })
                    // Recent items stagger animation
                    .to('.recent-item', {
                        opacity: 1,
                        y: 0,
                        duration: 0.5,
                        stagger: 0.1,
                        ease: 'power2.out'
                    });

                // Modal Handling
                const materialDetailModal = document.getElementById('material-detail-modal');
                const modalOptions = {
                    backdrop: 'static',
                    backdropClasses: 'bg-gray-900 bg-opacity-50 dark:bg-opacity-80 fixed inset-0 z-40'
                };
                const modal = new Modal(materialDetailModal, modalOptions);

                // Modal Animations
                function showModal(modalId) {
                    const modal = document.getElementById(modalId);
                    if (!modal) return;

                    modal.classList.remove('hidden');
                    gsap.fromTo(modal.querySelector('.relative'), {
                        opacity: 0,
                        y: -50,
                        scale: 0.95
                    }, {
                        opacity: 1,
                        y: 0,
                        scale: 1,
                        duration: 0.3,
                        ease: 'back.out(1.2)'
                    });
                }

                function hideModal(modalId) {
                    const modal = document.getElementById(modalId);
                    if (!modal) return;

                    gsap.to(modal.querySelector('.relative'), {
                        opacity: 0,
                        y: -50,
                        scale: 0.95,
                        duration: 0.2,
                        ease: 'power2.in',
                        onComplete: () => {
                            modal.classList.add('hidden');
                        }
                    });
                }

                // Modal Triggers
                const modalTriggers = document.querySelectorAll('[data-modal-toggle]');
                modalTriggers.forEach(trigger => {
                    trigger.addEventListener('click', () => {
                        const modalId = trigger.getAttribute('data-modal-target');
                        showModal(modalId);
                    });
                });

                // Close Modal Handlers
                const closeButtons = document.querySelectorAll('[data-modal-hide]');
                closeButtons.forEach(button => {
                    button.addEventListener('click', () => {
                        const modalId = button.getAttribute('data-modal-hide');
                        hideModal(modalId);
                    });
                });

                // Recent Items Click Handlers
                const recentItems = document.querySelectorAll('.recent-item');
                recentItems.forEach(item => {
                    item.addEventListener('click', function () {
                        const materialData = {
                            type: this.getAttribute('data-type'),
                            title: this.getAttribute('data-title'),
                            description: this.getAttribute('data-description'),
                            url: this.getAttribute('data-url'),
                            id: this.getAttribute('data-id'),
                            downloads: this.getAttribute('data-downloads'),
                            views: this.getAttribute('data-views'),
                            category: this.getAttribute('data-category')
                        };

                        // Update modal content
                        const modalTitle = materialDetailModal.querySelector('.material-title');
                        const modalDescription = materialDetailModal.querySelector('.material-description');
                        const pdfContent = materialDetailModal.querySelector('.pdf-content');
                        const videoContent = materialDetailModal.querySelector('.video-content');
                        const categoryContent = materialDetailModal.querySelector('.category-content');

                        modalTitle.textContent = materialData.title;
                        modalDescription.textContent = materialData.description;

                        // Hide all content sections initially
                        pdfContent.classList.add('hidden');
                        videoContent.classList.add('hidden');
                        categoryContent.classList.add('hidden');

                        // Show category
                        categoryContent.textContent = `Category: ${materialData.category}`;
                        categoryContent.classList.remove('hidden');

                        if (materialData.type === 'pdf') {
                            pdfContent.classList.remove('hidden');
                            const downloadBtn = pdfContent.querySelector('.download-btn');
                            downloadBtn.href = `/admin/materials/${materialData.id}/download`;

                            // Update download button click handler
                            downloadBtn.onclick = function (e) {
                                e.preventDefault();
                                e.stopPropagation();
                                window.open(`/admin/materials/${materialData.id}/download`, '_blank');
                                return false;
                            };
                        } else if (materialData.type === 'video' && materialData.url) {
                            videoContent.classList.remove('hidden');
                            const videoFrame = videoContent.querySelector('.video-frame');

                            // YouTube URL handling
                            const youtubeRegex = /(?:youtube\.com\/(?:[^/]+\/[^/]+\/|(?:v|e(?:mbed)?)\/|(?:watch(?:_popup)?)?\?v=)|youtu\.be\/)([a-zA-Z0-9_-]+)/;
                            const match = materialData.url.match(youtubeRegex);

                            if (match && match[1]) {
                                const videoId = match[1];
                                videoFrame.src = `https://www.youtube.com/embed/${videoId}?autoplay=1`;
                            } else {
                                videoFrame.src = '';
                            }
                        }

                        // Show modal with animation
                        modal.show();
                        gsap.fromTo(materialDetailModal.querySelector('.relative'), {
                            opacity: 0,
                            y: -50,
                            scale: 0.95
                        }, {
                            opacity: 1,
                            y: 0,
                            scale: 1,
                            duration: 0.3,
                            ease: 'back.out(1.2)'
                        });
                    });
                });

                // Stop video when modal is closed
                function stopVideo(modalElement) {
                    const videoFrame = modalElement.querySelector('.video-frame');
                    if (videoFrame) {
                        videoFrame.src = '';
                    }
                }

                materialDetailModal.addEventListener('hidden.bs.modal', function () {
                    stopVideo(materialDetailModal);
                });

                const closeModalButton = materialDetailModal.querySelector('[data-modal-hide="material-detail-modal"]');
                closeModalButton.addEventListener('click', function () {
                    modal.hide();
                    stopVideo(materialDetailModal);
                });

                // Download button handlers
                document.querySelectorAll('.download-btn').forEach(button => {
                    button.addEventListener('click', function (event) {
                        event.preventDefault();
                        const downloadUrl = this.href;
                        window.location.href = downloadUrl;
                    });
                });

                // Hover animations for buttons and cards
                gsap.utils.toArray('button, .admin-card').forEach(element => {
                    element.addEventListener('mouseenter', () => {
                        gsap.to(element, {
                            scale: 1.05,
                            duration: 0.2,
                            ease: 'power2.out'
                        });
                    });

                    element.addEventListener('mouseleave', () => {
                        gsap.to(element, {
                            scale: 1,
                            duration: 0.2,
                            ease: 'power2.in'
                        });
                    });
                });
            });
        </script>
        @endsection