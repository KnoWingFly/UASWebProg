@extends('layouts.admin')

@section('content')
<div class="container mx-auto mt-8">
    <h1 class="text-2xl font-bold mb-6">Manage Users</h1>

    <!-- Search and Filter Form -->
    <div class="flex mb-4 space-x-4">
        <!-- Search Form -->
        <form action="{{ route('admin.manage-users') }}" method="GET" class="flex space-x-2">
            <input type="text" name="search" placeholder="Search by name or email"
                class="px-4 py-2 border rounded dark:bg-gray-700 dark:text-gray-100" value="{{ request()->search }}">
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Search</button>
        </form>

        <!-- Filter by Created At -->
        <form action="{{ route('admin.manage-users') }}" method="GET" class="flex space-x-2">
            <input type="date" name="start_date" placeholder="Start Date" 
                class="px-4 py-2 border rounded dark:bg-gray-700 dark:text-gray-100" value="{{ request()->start_date }}">
            <input type="date" name="end_date" placeholder="End Date" 
                class="px-4 py-2 border rounded dark:bg-gray-700 dark:text-gray-100" value="{{ request()->end_date }}">
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Filter</button>
        </form>
    </div>

    <!-- Users Table -->
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 dark:bg-gray-800">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-300">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        <input type="checkbox" class="select-all-checkbox" id="select-all">
                    </th>
                    <th scope="col" class="px-6 py-3">Name</th>
                    <th scope="col" class="px-6 py-3">Email</th>
                    <th scope="col" class="px-6 py-3">Status</th>
                    <th scope="col" class="px-6 py-3">Created At</th>
                    <th scope="col" class="px-6 py-3 text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr class="bg-white border-b hover:bg-gray-100 dark:bg-gray-900 dark:border-gray-700 dark:hover:bg-gray-700">
                    <td class="px-6 py-4">
                        <input type="checkbox" class="user-checkbox" value="{{ $user->id }}">
                    </td>
                    <td class="px-6 py-4">{{ $user->name }}</td>
                    <td class="px-6 py-4">{{ $user->email }}</td>
                    <td class="px-6 py-4">
                        @if ($user->is_approved)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-200">
                            Approved
                        </span>
                        @else
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-200">
                            Not Approved
                        </span>
                        @endif
                    </td>
                    <td class="px-6 py-4">{{ $user->created_at->format('Y-m-d') }}</td>
                    <td class="px-6 py-4 text-center">
                        <!-- Edit Button -->
                        <button onclick="openEditModal({{ json_encode($user) }})" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2">
                            Edit
                        </button>


                        <!-- Delete Button -->
                        <button onclick="openDeleteModal({{ $user->id }})" class="text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-4 py-2">
                            Delete
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $users->links() }}
    </div>
</div>

<!-- Edit User Modal -->
<!-- Modal Structure -->
<div id="editModal" class="fixed inset-0 z-50 hidden bg-gray-800 bg-opacity-50 flex justify-center items-center">
    <div class="bg-gray-900 p-6 rounded-lg w-1/3 dark:border dark:border-gray-700">
        <form id="editForm"  action="{{ route('admin.update-user', ['user' => ':userId']) }}" method="POST">
            @csrf
            @method('POST')
            <h2 class="text-lg font-bold mb-4 text-white">Edit User</h2>

            <div class="mb-4">
                <label for="name" class="block text-white mb-2">Name</label>
                <input type="text" name="name" id="name" 
                    class="w-full p-2 border rounded bg-gray-800 text-white border-gray-700 focus:ring-blue-500 focus:border-blue-500" 
                    required>
            </div>

            <div class="mb-4">
                <label for="email" class="block text-white mb-2">Email</label>
                <input type="email" name="email" id="email" 
                    class="w-full p-2 border rounded bg-gray-800 text-white border-gray-700 focus:ring-blue-500 focus:border-blue-500" 
                    required>
            </div>

            <div class="mb-4 flex items-center">
                <input type="checkbox" name="is_approved" id="is_approved" value="1"
                    class="mr-2 rounded bg-gray-700 border-gray-600 focus:ring-blue-500 focus:border-blue-500">
                <label for="is_approved" class="text-white">Approved</label>
            </div>

            <div class="flex justify-end mt-4">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Save Changes</button>
                <button type="button" class="ml-4 bg-gray-700 text-white px-4 py-2 rounded hover:bg-gray-600" onclick="closeModal()">Cancel</button>
            </div>
        </form>
    </div>
</div>

<!-- Delete User Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 z-50 hidden justify-center items-center bg-gray-900 bg-opacity-75 transition-opacity duration-300 ease-in-out">
    <div class="bg-gray-800 p-6 rounded-lg w-96 animate__animated animate__fadeIn">
        <h2 class="text-xl font-bold mb-4 text-white">Are you sure you want to delete this user?</h2>
        <form id="deleteForm" method="POST">
            @csrf
            @method('DELETE')
            <div class="flex justify-between">
                <button type="button" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600" onclick="closeDeleteModal()">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Delete</button>
            </div>
        </form>
    </div>
</div>

<script>
    // Open the Edit Modal with user data
    function openEditModal(user) {
        const editForm = document.getElementById('editForm');
        
        // Replace :userId with the actual user ID
        editForm.action = editForm.action.replace(':userId', user.id);
        
        // Set input values
        document.getElementById('name').value = user.name;
        document.getElementById('email').value = user.email;
        
        // Properly handle the checkbox
        const approvedCheckbox = document.getElementById('is_approved');
        approvedCheckbox.checked = user.is_approved === true || user.is_approved === 1;
        
        // Show the modal
        document.getElementById('editModal').classList.remove('hidden');
    }

    // Close the Edit Modal
    function closeModal() {
        document.getElementById('editModal').classList.add('hidden');
    }

    // Open the Delete Confirmation Modal
    function openDeleteModal(userId) {
        document.getElementById('deleteForm').action = '/admin/users/' + userId;
        document.getElementById('deleteModal').classList.remove('hidden');
    }

    // Close the Delete Confirmation Modal
    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
    }

    // Select/Deselect all checkboxes
    const selectAllCheckbox = document.getElementById('select-all');
    selectAllCheckbox.addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.user-checkbox');
        checkboxes.forEach(checkbox => checkbox.checked = this.checked);
    });
</script>

@if(session('success'))
    <div class="bg-green-500 text-white p-4 mb-4">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="bg-red-500 text-white p-4 mb-4">
        {{ session('error') }}
    </div>
@endif

@if($errors->any())
    <div class="bg-red-500 text-white p-4 mb-4">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<!-- In your manage-users.blade.php -->
@if(session('error'))
    <div class="bg-red-500 text-white p-4 mb-4">
        {{ session('error') }}
    </div>
@endif

@if($errors->any())
    <div class="bg-red-500 text-white p-4 mb-4">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@endsection
