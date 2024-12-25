@extends('layouts.user')

@section('content')
<div class="container mx-auto px-4 py-8 opacity-0" id="mainContainer">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-[#ff4d4d] translate-x-[-20px] opacity-0" id="pageTitle">
            Material Details
        </h2>
        
        @if($material->category)
            <a href="{{ route('user.categories.show', $material->category->id) }}"
                class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors duration-300 translate-x-[20px] opacity-0"
                id="backButton">
                Back to {{ $material->category->name }}
            </a>
        @else
            <a href="{{ route('user.categories.show', 'uncategorized') }}"
                class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors duration-300 translate-x-[20px] opacity-0"
                id="backButton">
                Back to Uncategorized
            </a>
        @endif
    </div>

    <div class="bg-[#1a1a1a] p-8 rounded-lg shadow-xl scale-95 opacity-0" id="contentCard">
        <h3 class="text-xl font-semibold text-white mb-4 opacity-0" id="materialTitle">
            {{ $material->title }}
        </h3>
        
        <p class="text-gray-300 mb-6 opacity-0" id="materialDescription">
            {{ $material->description }}
        </p>
        
        <div class="grid grid-cols-2 gap-4 mb-6">
            <p class="text-gray-400 text-sm opacity-0" id="categoryInfo">
                <span class="text-[#ff4d4d] font-medium">Category:</span> 
                {{ $material->category->name ?? 'Uncategorized' }}
            </p>
            
            <p class="text-gray-400 text-sm opacity-0" id="dateInfo">
                <span class="text-[#ff4d4d] font-medium">Created At:</span> 
                {{ $material->created_at->format('Y-m-d') }}
            </p>
        </div>

        <div class="mt-8 opacity-0" id="contentSection">
            @if($material->type === 'pdf')
                <a href="{{ route('user.materials.download', $material) }}"
                    class="inline-block px-6 py-3 bg-[#ff4d4d] text-white rounded-lg hover:bg-opacity-90 transition-all duration-300 transform hover:scale-105">
                    <i class="fas fa-download mr-2"></i> Download PDF
                </a>
            @elseif($material->type === 'video')
                @php
                    $youtubeRegex = '/(?:youtube\.com\/(?:[^\/]+\/[^\/]+\/|(?:v|e(?:mbed)?)\/|(?:watch(?:_popup)?)?\?v=)|youtu\.be\/)([a-zA-Z0-9_-]+)/';
                    preg_match($youtubeRegex, $material->video_url, $matches);
                    $videoId = $matches[1] ?? null;
                @endphp

                @if($videoId)
                    <div class="video-content mt-4">
                        <div class="aspect-w-16 aspect-h-9 w-full max-w-3xl mx-auto">
                            <iframe class="w-full h-96 rounded-lg shadow-lg"
                                src="https://www.youtube.com/embed/{{ $videoId }}?autoplay=1"
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
                <div class="bg-[#151515] p-6 rounded-lg">
                    <p class="text-gray-300">{{ $material->content }}</p>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // Main timeline
    const tl = gsap.timeline({
        defaults: { 
            duration: 0.8,
            ease: 'power3.out'
        }
    });

    // Initial container fade in
    tl.to('#mainContainer', {
        opacity: 1,
        duration: 0.4
    });

    // Animate title and back button
    tl.to('#pageTitle', {
        opacity: 1,
        x: 0,
        duration: 0.6
    }, '-=0.2')
    .to('#backButton', {
        opacity: 1,
        x: 0,
        duration: 0.6
    }, '-=0.4');

    // Animate content card
    tl.to('#contentCard', {
        opacity: 1,
        scale: 1,
        duration: 0.8
    }, '-=0.2');

    // Animate content elements
    tl.to('#materialTitle', {
        opacity: 1,
        y: 0,
        duration: 0.5
    }, '-=0.4')
    .to('#materialDescription', {
        opacity: 1,
        duration: 0.5
    }, '-=0.3')
    .to(['#categoryInfo', '#dateInfo'], {
        opacity: 1,
        stagger: 0.15
    }, '-=0.2')
    .to('#contentSection', {
        opacity: 1,
        y: 0,
        duration: 0.6
    }, '-=0.2');

    // Hover animations for buttons
    gsap.utils.toArray('.hover\\:scale-105').forEach(button => {
        button.addEventListener('mouseenter', () => {
            gsap.to(button, {
                scale: 1.05,
                duration: 0.3
            });
        });
        
        button.addEventListener('mouseleave', () => {
            gsap.to(button, {
                scale: 1,
                duration: 0.3
            });
        });
    });
});
</script>
@endsection