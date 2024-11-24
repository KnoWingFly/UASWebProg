@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gray-900 text-white p-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold">UMN PC Learning Materials</h1>
            <div class="flex space-x-4">
                <button class="p-2 hover:bg-gray-800 rounded-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>
                <button class="p-2 hover:bg-gray-800 rounded-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>

        @if(session('success'))
            <div class="text-green-500">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="text-red-500">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        <!-- Admin Upload Panel -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
            <!-- Upload PDF Card -->
            <div class="bg-gray-800 p-6 rounded-lg">
                <h3 class="text-xl font-semibold mb-4">Upload PDF</h3>
                <p class="text-gray-400 mb-4">Upload new PDF resources.</p>
                <button data-modal-target="pdf-upload-modal" data-modal-toggle="pdf-upload-modal"
                    class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                    Upload
                </button>
            </div>

            <!-- Upload Video Card -->
            <div class="bg-gray-800 p-6 rounded-lg">
                <h3 class="text-xl font-semibold mb-4">Upload Video</h3>
                <p class="text-gray-400 mb-4">Upload new Video resources.</p>
                <button data-modal-target="video-upload-modal" data-modal-toggle="video-upload-modal"
                    class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                    Upload
                </button>
            </div>

            <!-- Manage Resources Card -->
            <div class="bg-gray-800 p-6 rounded-lg">
                <h3 class="text-xl font-semibold mb-4">Manage Resources</h3>
                <p class="text-gray-400 mb-4">Manage existing resources.</p>
                <a href="{{ route('admin.materials.index') }}"
                    class="inline-block bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                    Manage
                </a>
            </div>
        </div>

        <!-- Recent Uploads -->
        <div class="bg-gray-800 rounded-lg p-6">
            <h2 class="text-xl font-semibold text-white mb-6">Recent Uploads</h2>
            @if($recentMaterials->isNotEmpty())
                <div class="space-y-4">
                    @foreach($recentMaterials as $material)
                        <div class="flex items-center justify-between p-4 hover:bg-gray-700 rounded-lg transition-colors">
                            <div class="flex items-center space-x-4">
                                @if($material->type === 'pdf')
                                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                @else
                                    <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        aria-hidden="true">
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
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-400 text-center">No recent uploads available.</p>
            @endif
        </div>

        <!-- Include Modal Components -->
        <div id="pdf-upload-modal" tabindex="-1" aria-hidden="true"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-md max-h-full">
                <div class="relative bg-gray-800 rounded-lg shadow">
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-gray-700">
                        <h3 class="text-xl font-semibold text-white">
                            Upload PDF
                        </h3>
                        <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-700 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                            data-modal-hide="pdf-upload-modal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                        </button>
                    </div>
                    <form class="p-4 md:p-5" action="{{ route('admin.materials.upload-pdf') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="grid gap-4 mb-4">
                            <div>
                                <label for="title" class="block mb-2 text-sm font-medium text-white">Title</label>
                                <input type="text" name="title" id="title"
                                    class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                    required>
                            </div>
                            <div>
                                <label for="description"
                                    class="block mb-2 text-sm font-medium text-white">Description</label>
                                <textarea name="description" id="description" rows="4"
                                    class="block p-2.5 w-full text-sm text-white bg-gray-700 rounded-lg border border-gray-600 focus:ring-blue-500 focus:border-blue-500"></textarea>
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-medium text-white" for="file">Upload PDF</label>
                                <input type="file" name="file" accept=".pdf"
                                    class="block w-full text-sm text-gray-400 border border-gray-600 rounded-lg cursor-pointer bg-gray-700 focus:outline-none"
                                    required>
                            </div>
                        </div>
                        <button type="submit"
                            class="text-white inline-flex items-center bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                            Upload PDF
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div id="video-upload-modal" tabindex="-1" aria-hidden="true"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-md max-h-full">
                <div class="relative bg-gray-800 rounded-lg shadow">
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-gray-700">
                        <h3 class="text-xl font-semibold text-white">
                            Add Video
                        </h3>
                        <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-700 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                            data-modal-hide="video-upload-modal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                        </button>
                    </div>
                    <form class="p-4 md:p-5" action="{{ route('admin.materials.upload-video') }}" method="POST">
                        @csrf
                        <div class="grid gap-4 mb-4">
                            <div>
                                <label for="title" class="block mb-2 text-sm font-medium text-white">Title</label>
                                <input type="text" name="title" id="title"
                                    class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                    required>
                            </div>
                            <div>
                                <label for="description"
                                    class="block mb-2 text-sm font-medium text-white">Description</label>
                                <textarea name="description" id="description" rows="4"
                                    class="block p-2.5 w-full text-sm text-white bg-gray-700 rounded-lg border border-gray-600 focus:ring-blue-500 focus:border-blue-500"></textarea>
                            </div>
                            <div>
                                <label for="video_url" class="block mb-2 text-sm font-medium text-white">Video URL
                                    (YouTube/Video)</label>
                                <input type="url" name="video_url" id="video_url"
                                    class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                    required>
                            </div>
                        </div>
                        <button type="submit"
                            class="text-white inline-flex items-center bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                            Add Video
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <Script>
            // resources/js/modal.js
            document.addEventListener('DOMContentLoaded', function () {
                // Modal show buttons
                const modalToggles = document.querySelectorAll('[data-modal-toggle]');
                modalToggles.forEach(toggle => {
                    toggle.addEventListener('click', () => {
                        const modalId = toggle.getAttribute('data-modal-toggle');
                        const modal = document.getElementById(modalId);
                        modal.classList.remove('hidden');
                        modal.classList.add('flex');
                    });
                });

                // Modal hide buttons
                const modalHides = document.querySelectorAll('[data-modal-hide]');
                modalHides.forEach(hide => {
                    hide.addEventListener('click', () => {
                        const modalId = hide.getAttribute('data-modal-hide');
                        const modal = document.getElementById(modalId);
                        modal.classList.add('hidden');
                        modal.classList.remove('flex');
                    });
                });

                // Click outside to close
                window.addEventListener('click', (e) => {
                    const modals = document.querySelectorAll('[id$="-modal"]');
                    modals.forEach(modal => {
                        if (e.target === modal) {
                            modal.classList.add('hidden');
                            modal.classList.remove('flex');
                        }
                    });
                });
            });
        </Script>
        @endsection