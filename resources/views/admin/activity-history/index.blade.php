@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8 dark:bg-gray-900 dark:text-white">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold dark:text-white">Activity History</h1>

        @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
        {{-- Create Activity Button --}}
        <button data-modal-target="create-activity-modal" data-modal-toggle="create-activity-modal"
            class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700">
            Create Activity
        </button>
    </div>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 dark:bg-green-900 dark:border-green-700 dark:text-green-300 px-4 py-3 rounded relative mb-4"
            role="alert">
            {{ session('success') }}
        </div>
    @endif

    {{-- Activity History List --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($activities as $activity)
            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-4">
                <div class="flex justify-between items-center mb-2">
                    <h3 class="text-lg font-semibold dark:text-white">{{ $activity->activity_type }}</h3>
                    <div class="flex items-center space-x-2">
                        {{-- Add User Button --}}
                        <button data-modal-target="manage-users-modal-{{ $activity->id }}"
                            data-modal-toggle="manage-users-modal-{{ $activity->id }}"
                            class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6zM16 7a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V7z" />
                            </svg>
                        </button>

                        {{-- Edit Activity Button --}}
                        <button data-modal-target="edit-activity-modal-{{ $activity->id }}"
                            data-modal-toggle="edit-activity-modal-{{ $activity->id }}"
                            class="text-green-600 dark:text-green-400 hover:text-green-800 dark:hover:text-green-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                                <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" />
                            </svg>
                        </button>

                        {{-- Delete Activity Button --}}
                        <form action="{{ route('admin.activity-history.destroy', $activity) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300"
                                onclick="return confirm('Are you sure?')">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
                <p class="text-gray-600 dark:text-gray-300 mb-2">
                    <strong>Users:</strong> {{ $activity->users->count() }} participants
                </p>
                <p class="text-gray-600 dark:text-gray-300 mb-2">
                    <strong>Date:</strong> {{ $activity->activity_date }}
                </p>
                @if($activity->description)
                    <p class="text-gray-500 dark:text-gray-400 italic">
                        {{ Str::limit($activity->description, 100) }}
                    </p>
                @endif
            </div>

                {{-- Manage Users Modal --}}
                <div id="manage-users-modal-{{ $activity->id }}" tabindex="-1" aria-hidden="true"
                    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                    <div class="relative p-4 w-full max-w-4xl max-h-full">
                        <div class="relative bg-white dark:bg-gray-700 rounded-lg shadow">
                            <div class="flex items-center justify-between p-4 md:p-5 border-b dark:border-gray-600 rounded-t">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                    Manage Users for Activity
                                </h3>
                                <button type="button"
                                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600"
                                    data-modal-toggle="manage-users-modal-{{ $activity->id }}">
                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                    </svg>
                                    <span class="sr-only">Close modal</span>
                                </button>
                            </div>
                            <form action="{{ route('admin.activity-history.manage-users', $activity) }}" method="POST" class="p-4 md:p-5">
                                @csrf
                                <div class="overflow-x-auto">
                                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                            <tr>
                                                <th scope="col" class="p-4">
                                                    <div class="flex items-center">
                                                        <input id="checkbox-all-users-{{ $activity->id }}" type="checkbox" 
                                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                                        <label for="checkbox-all-users-{{ $activity->id }}" class="sr-only">checkbox</label>
                                                    </div>
                                                </th>
                                                <th scope="col" class="px-6 py-3">Name</th>
                                                <th scope="col" class="px-6 py-3">Email</th>
                                                <th scope="col" class="px-6 py-3">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($users as $user)
                                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                                <td class="w-4 p-4">
                                                    <div class="flex items-center">
                                                        <input id="checkbox-user-{{ $user->id }}-{{ $activity->id }}" type="checkbox" 
                                                            name="user_ids[]" 
                                                            value="{{ $user->id }}"
                                                            {{ $activity->users->contains($user->id) ? 'checked' : '' }}
                                                            class="user-checkbox w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                                        <label for="checkbox-user-{{ $user->id }}-{{ $activity->id }}" class="sr-only">checkbox</label>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4">{{ $user->name }}</td>
                                                <td class="px-6 py-4">{{ $user->email }}</td>
                                                <td class="px-6 py-4">
                                                    @if($activity->users->contains($user->id))
                                                        <span class="text-green-600 dark:text-green-400">In Activity</span>
                                                    @else
                                                        <span class="text-gray-600 dark:text-gray-400">Not in Activity</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="mt-4 flex justify-end">
                                    <button type="submit"
                                        class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700">
                                        Update Users
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
                {{-- Edit Activity Modal --}}
                <div id="edit-activity-modal-{{ $activity->id }}" tabindex="-1" aria-hidden="true"
                    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                    <div class="relative p-4 w-full max-w-2xl max-h-full">
                        <div class="relative bg-white dark:bg-gray-700 rounded-lg shadow">
                            <div class="flex items-center justify-between p-4 md:p-5 border-b dark:border-gray-600 rounded-t">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                    Edit Activity
                                </h3>
                                <button type="button"
                                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600"
                                    data-modal-toggle="edit-activity-modal-{{ $activity->id }}">
                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                    </svg>
                                    <span class="sr-only">Close modal</span>
                                </button>
                            </div>
                            <form action="{{ route('admin.activity-history.update', $activity) }}" method="POST" class="p-4 md:p-5">
                                @csrf
                                @method('PUT')
                                <div class="grid gap-4 mb-4 grid-cols-2">
                                    <div class="col-span-2">
                                        <label for="activity_type_{{ $activity->id }}"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                            Activity Type
                                        </label>
                                        <input type="text" name="activity_type" id="activity_type_{{ $activity->id }}"
                                            value="{{ $activity->activity_type }}"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                            placeholder="Enter activity type" required>
                                            <div class="col-span-2">
                                        <label for="activity_date_{{ $activity->id }}"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                            Activity Date
                                        </label>
                                        <input type="date" name="activity_date" id="activity_date_{{ $activity->id }}"
                                            value="{{ $activity->activity_date }}"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                            required>
                                    </div>
                                    <div class="col-span-2">
                                        <label for="description_{{ $activity->id }}"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                            Description (Optional)
                                        </label>
                                        <textarea name="description" id="description_{{ $activity->id }}" rows="4"
                                            class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                            placeholder="Write activity description here">{{ $activity->description }}</textarea>
                                    </div>
                                </div>
                                <button type="submit"
                                    class="w-full text-white inline-flex items-center justify-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 transition-colors">
                                    Update Activity
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $activities->links() }}
    </div>

    {{-- Create Activity Modal --}}
    <div id="create-activity-modal" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <div class="relative bg-white dark:bg-gray-700 rounded-lg shadow-xl">
            <div class="flex items-center justify-between p-4 md:p-5 border-b dark:border-gray-600 rounded-t">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Create New Activity
                </h3>
                <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600"
                    data-modal-toggle="create-activity-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <form action="{{ route('admin.activity-history.store') }}" method="POST" class="p-4 md:p-5">
                @csrf
                <div class="grid gap-4 mb-4 grid-cols-2">
                    <div class="col-span-2">
                        <label for="activity_type"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Activity Type
                        </label>
                        <input type="text" name="activity_type" id="activity_type"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                            placeholder="Enter activity type" required>
                    </div>
                    <div class="col-span-2">
                        <label for="activity_date"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Activity Date
                        </label>
                        <input type="date" name="activity_date" id="activity_date"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                            required>
                    </div>
                    <div class="col-span-2">
                        <label for="description"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Description (Optional)
                        </label>
                        <textarea name="description" id="description" rows="4"
                            class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                            placeholder="Write activity description here"></textarea>
                    </div>
                </div>
                <button type="submit"
                    class="w-full text-white inline-flex items-center justify-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 transition-colors">
                    <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                            clip-rule="evenodd"></path>
                    </svg>
                    Create Activity
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Select/Deselect all checkboxes for each modal
        document.querySelectorAll('[id^=checkbox-all-users]').forEach(checkboxAll => {
            const modalId = checkboxAll.id.split('-').slice(-1)[0];
            const userCheckboxes = document.querySelectorAll(`#manage-users-modal-${modalId} .user-checkbox`);

            checkboxAll.addEventListener('change', function() {
                userCheckboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
            });

            // Ensure "Select All" checkbox is unchecked if not all individual checkboxes are checked
            userCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const allChecked = Array.from(userCheckboxes).every(cb => cb.checked);
                    checkboxAll.checked = allChecked;
                });
            });
        });
    });
</script>
@endsection