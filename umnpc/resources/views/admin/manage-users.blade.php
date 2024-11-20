@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-8">
    <h1 class="text-2xl font-bold mb-6">Manage Users</h1>

    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <table class="table-auto w-full border-collapse border border-gray-200">
        <thead>
            <tr>
                <th class="border-b px-4 py-2">Name</th>
                <th class="border-b px-4 py-2">Email</th>
                <th class="border-b px-4 py-2">Status</th>
                <th class="border-b px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td class="border-b px-4 py-2">{{ $user->name }}</td>
                    <td class="border-b px-4 py-2">{{ $user->email }}</td>
                    <td class="border-b px-4 py-2">
                        @if ($user->is_approved)
                            <span class="text-green-500">Approved</span>
                        @else
                            <span class="text-red-500">Not Approved</span>
                        @endif
                    </td>
                    <td class="border-b px-4 py-2 flex space-x-2">
                        <!-- Edit Button -->
                        <button onclick="openEditModal({{ $user }})" class="bg-blue-500 text-white px-4 py-2 rounded shadow-md hover:bg-blue-600">
                            Edit
                        </button>

                        <!-- Delete Form -->
                        <form action="{{ route('admin.delete-user', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded shadow-md hover:bg-red-600">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Edit Modal -->
<div id="editModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center">
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-xl font-bold mb-4">Edit User</h2>
        <form id="editForm" method="POST">
            @csrf
            @method('POST')
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" id="editName" name="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required />
            </div>
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" id="editEmail" name="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required />
            </div>
            <div class="mb-4">
                <label for="is_approved" class="block text-sm font-medium text-gray-700">Status</label>
                <select id="editStatus" name="is_approved" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <option value="1">Approved</option>
                    <option value="0">Not Approved</option>
                </select>
            </div>
            <div class="flex justify-end space-x-2">
                <button type="button" onclick="closeEditModal()" class="bg-gray-500 text-white px-4 py-2 rounded shadow-md hover:bg-gray-600">
                    Cancel
                </button>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded shadow-md hover:bg-blue-600">
                    Save
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openEditModal(user) {
        document.getElementById('editName').value = user.name;
        document.getElementById('editEmail').value = user.email;
        document.getElementById('editStatus').value = user.is_approved ? 1 : 0;
        document.getElementById('editForm').action = `/admin/manage-users/${user.id}/update`;
        document.getElementById('editModal').classList.remove('hidden');
    }

    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
    }
</script>
@endsection
