@extends('layouts.admin')

@section('content')

<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-gray-200">Material Categories</h2>
        <a href="{{ route('admin.categories.create') }}" 
           class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
            Add New Category
        </a>
    </div>

    @if(session('success'))
        <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-800 dark:text-green-200">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left text-gray-400 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-700 dark:bg-gray-700">
                <tr>
                    <th scope="col" class="py-3 px-6">Name</th>
                    <th scope="col" class="py-3 px-6">Materials Count</th>
                    <th scope="col" class="py-3 px-6">Created At</th>
                    <th scope="col" class="py-3 px-6">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $category)
                    <tr class="bg-gray-800 border-b hover:bg-gray-700">
                        <td class="py-4 px-6 font-medium text-gray-200">
                            {{ $category->name }}
                        </td>
                        <td class="py-4 px-6">
                            {{ $category->learning_materials_count }}
                        </td>
                        <td class="py-4 px-6">
                            {{ $category->created_at->format('Y-m-d') }}
                        </td>
                        <td class="py-4 px-6">
                            <a href="{{ route('admin.categories.edit', $category) }}" 
                               class="font-medium text-blue-400 hover:underline">Edit</a>
                            <form action="{{ route('admin.categories.destroy', $category) }}" 
                                  method="POST" 
                                  class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="font-medium text-red-400 hover:underline ml-3"
                                        onclick="return confirm('Are you sure?')">
                                    Delete
                                </button>
                            </form>
                            <a href="{{ route('admin.categories.show', $category) }}"
                               class="font-medium text-green-400 hover:underline ml-3">View</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $categories->links() }}
    </div>
</div>
@endsection
