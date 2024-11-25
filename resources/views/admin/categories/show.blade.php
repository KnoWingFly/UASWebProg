@extends('layouts.admin')

@section('content')

<div class="container mx-auto px-4 py-8">
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
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-500">
                            {{ $material->created_at->format('Y-m-d') }}
                        </span>
                        <a href="{{ route('admin.materials.show', $material) }}"
                           class="text-blue-400 hover:underline">
                            View Material
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $materials->links() }}
        </div>
    @endif
</div>
@endsection
