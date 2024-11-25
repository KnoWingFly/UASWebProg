@extends('layouts.admin')

@section('content')

<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-gray-200">Material Details</h2>
        <a href="{{ route('admin.categories.show', $material->category->id) }}"
            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
            Back to {{ $material->category->name ?? 'Category' }}
        </a>
    </div>

    <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
        <h3 class="text-lg font-semibold text-white mb-2">{{ $material->title }}</h3>
        <p class="text-gray-400 mb-4">{{ $material->description }}</p>
        <p class="text-gray-500 text-sm mb-4">
            <strong>Category:</strong> {{ $material->category->name ?? 'Uncategorized' }}
        </p>
        <p class="text-gray-500 text-sm mb-4">
            <strong>Created At:</strong> {{ $material->created_at->format('Y-m-d') }}
        </p>
        @if($material->type === 'pdf')
            <a href="{{ route('admin.materials.download', $material) }}"
                class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                Download PDF
            </a>
        @elseif($material->type === 'video')
                @php
                    // Extract YouTube video ID from the URL
                    $youtubeRegex = '/(?:youtube\.com\/(?:[^\/]+\/[^\/]+\/|(?:v|e(?:mbed)?)\/|(?:watch(?:_popup)?)?\?v=)|youtu\.be\/)([a-zA-Z0-9_-]+)/';
                    preg_match($youtubeRegex, $material->video_url, $matches);
                    $videoId = $matches[1] ?? null;
                @endphp

                @if($videoId)
                    <div class="video-content mt-4 flex justify-center">
                        <div class="aspect-w-16 aspect-h-9 w-full max-w-2xl">
                            <iframe class="w-full h-96 rounded-lg" src="https://www.youtube.com/embed/{{ $videoId }}?autoplay=1"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen>
                            </iframe>
                        </div>
                    </div>

                @else
                    <p class="text-gray-400">Invalid video URL.</p>
                @endif
        @else
            <div class="bg-gray-700 p-4 rounded-lg">
                <p class="text-gray-400">{{ $material->content }}</p>
            </div>
        @endif
    </div>
</div>

@endsection