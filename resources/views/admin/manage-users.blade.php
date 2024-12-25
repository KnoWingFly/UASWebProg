@extends('layouts.admin')

@section('content')
<div class="container mx-auto mt-8">
    <h1 class="text-2xl font-bold mb-6 text-white">Manage Users</h1>

    <!-- ============================================================== Any Error Message ============================================================== -->
    <!-- Feedback Messages -->
    @if(session('success'))
        <div class="bg-[#ff4d4d] text-white p-4 mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Error Message -->
    @if(session('error'))
        <div class="bg-[#ff4d4d] text-white p-4 mb-4">
            {{ session('error') }}
        </div>
    @endif

    <!-- error if not fulfill the rules -->
    @if($errors->any())
        <div class="bg-[#ff4d4d] text-white p-4 mb-4">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- ============================================================== Search, filter ============================================================== -->
    <div class="flex gap-4 mb-4">
        <!-- Search Box -->
        <input type="text" id="search" placeholder="Search by name or email"
            class="px-4 py-2 border rounded bg-[#1a1a1a] text-white" value="{{ request()->search }}">

        <!-- Filter Dropdown -->
        <select id="date_filter" name="date_filter" class="px-4 py-2 border rounded bg-[#1a1a1a] text-white">
            <option value="">Default</option>
            <option value="today" {{ request()->date_filter == 'today' ? 'selected' : '' }}>Today</option>
            <option value="yesterday" {{ request()->date_filter == 'yesterday' ? 'selected' : '' }}>Yesterday</option>
            <option value="last_week" {{ request()->date_filter == 'last_week' ? 'selected' : '' }}>Last Week</option>
            <option value="last_month" {{ request()->date_filter == 'last_month' ? 'selected' : '' }}>Last Month</option>
        </select>
    </div>

    <!-- Bulk Operations -->
    <div class="flex space-x-4 mb-4">

        <!-- approve bulk -->
        <form id="bulkApproveForm" action="{{ route('admin.users.bulk-approve') }}" method="POST">
            @csrf
            <input type="hidden" name="userIds" id="approveUserIds">
            <button type="button" onclick="submitBulkAction('approveUserIds', '.user-checkbox', '#bulkApproveForm')"
                class="px-4 py-2 bg-[#ff4d4d] text-white rounded hover:bg-[#ff4d4d]">Approve Selected</button>
        </form>

        <!-- disapprove bulk -->
        <form id="bulkDisapproveForm" action="{{ route('admin.users.bulk-disapprove') }}" method="POST">
            @csrf
            <input type="hidden" name="userIds" id="disapproveUserIds">
            <button type="button"
                onclick="submitBulkAction('disapproveUserIds', '.user-checkbox', '#bulkDisapproveForm')"
                class="px-4 py-2 bg-[#ff4d4d] text-white rounded hover:bg-[#ff4d4d]">Disapprove Selected</button>
        </form>


        <!-- delete bulk -->
        <form id="bulkDeleteForm" action="{{ route('admin.users.bulk-delete') }}" method="POST">
            @csrf
            <input type="hidden" name="userIds" id="deleteUserIds">
            <button type="button" onclick="submitBulkAction('deleteUserIds', '.user-checkbox', '#bulkDeleteForm')"
                class="px-4 py-2 bg-[#ff4d4d] text-white rounded hover:bg-[#ff4d4d]">Delete Selected</button>
        </form>
    </div>

    <!-- ============================================================== Table ============================================================== -->
    <!-- Users Table -->
    @if($users->isEmpty())
        <div class="text-center text-gray-500 mt-4">
            No users match your criteria.
        </div>
    @else
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-white bg-[#151515]">
                <thead class="text-xs text-gray-300 uppercase bg-[#1a1a1a]">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            <input type="checkbox" id="select-all" class="select-all-checkbox">
                        </th>
                        <th scope="col" class="px-6 py-3">Name</th>
                        <th scope="col" class="px-6 py-3">Email</th>
                        <th scope="col" class="px-6 py-3">Roles</th>
                        <th scope="col" class="px-6 py-3">Status</th>
                        <th scope="col" class="px-6 py-3">Created At</th>
                        <th scope="col" class="px-6 py-3 text-center">Actions</th>
                    </tr>
                </thead>

                <!-- ============================================================== Table Body ============================================================== -->
                <tbody id="userTableBody">
                    @forelse ($users as $user)
                        <tr
                            class="bg-white border-b hover:bg-gray-100 dark:bg-[#1a1a1a] dark:border-[#1a1a1a] dark:hover:bg-[#151515]">
                            <td class="px-6 py-4">
                                <input type="checkbox" class="user-checkbox" value="{{ $user->id }}">
                            </td>
                            <td class="px-6 py-4">{{ $user->name }}</td>
                            <td class="px-6 py-4">{{ $user->email }}</td>
                            <td class="px-6 py-4">{{ $user->roles }}</td>
                            <td class="px-6 py-4">
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-medium 
                                            {{ $user->is_approved ? 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-200' : 'bg-[#FF4D4D] text-white dark:bg-[#FF4D4D] dark:text-white' }}">
                                    {{ $user->is_approved ? 'Approved' : 'Not Approved' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">{{ $user->created_at->format('Y-m-d') }}</td>
                            <td class="px-6 py-4 text-center space-x-2">
                                <button onclick="openEditModal({{ $user }})"
                                    class="text-white bg-[#FF4D4D] hover:bg-[#FF3D3D] px-4 py-2 rounded">Edit</button>
                                <form id="deleteUserForm" action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                    class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="bg-[#FF4D4D] hover:bg-[#FF3D3D] text-white py-2 px-4 rounded"
                                        onclick="openDeleteModal({{ $user->id }})">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">No users found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div id="noUsersMessage" class="text-center text-gray-500 mt-4 hidden">
                No users match your criteria.
            </div>
        </div>

        <!-- ============================================================== Modal ============================================================== -->
        <!-- Edit User Modal -->
        <div id="editModal" class="hidden fixed inset-0 bg-[#151515] bg-opacity-50 flex justify-center items-center">
            <div class="bg-[#1a1a1a] text-white p-6 rounded shadow-lg max-w-sm w-full">
                <h2 class="text-xl font-bold mb-4">Edit User</h2>
                <form id="editForm" action="{{ route('admin.users.update', ':userId') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Name -->
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-300">Name</label>
                        <input type="text" id="name" name="name"
                            class="w-full px-4 py-2 border rounded dark:bg-[#1a1a1a] dark:text-gray-100">
                    </div>

                    <!-- Email -->
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-300">Email</label>
                        <input type="email" id="email" name="email"
                            class="w-full px-4 py-2 border rounded dark:bg-[#1a1a1a] dark:text-gray-100">
                    </div>

                    <!-- Approval Status -->
                    <div class="mb-4">
                        <label for="is_approved" class="block text-sm font-medium text-gray-300">Approved</label>
                        <input type="checkbox" id="is_approved" name="is_approved" class="text-indigo-600" value="1">
                    </div>

                    <!-- Role -->
                    <div class="mb-4">
                        <label for="roles" class="block text-sm font-medium text-gray-300">Role</label>
                        <select id="roles" name="roles"
                            class="w-full px-4 py-2 border rounded dark:bg-[#1a1a1a] dark:text-gray-100">
                            <option value="user">User</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>

                    <!-- Submit & Cancel buttons -->
                    <div class="flex justify-end space-x-2">
                        <button type="submit" class="px-4 py-2 bg-[#FF4D4D] text-white rounded hover:bg-[#FF3D3D]">Save
                            Changes</button>
                        <button type="button" onclick="closeModal()"
                            class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">Cancel</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Delete User Modal -->
        <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-70 flex justify-center items-center hidden">
            <div class="bg-[#1a1a1a] text-white p-6 rounded-lg w-96">
                <h3 class="text-xl mb-4">Are you sure you want to delete this user?</h3>
                <form id="confirmDeleteForm" method="POST" action="" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-[#FF4D4D] hover:bg-[#FF3D3D] text-white py-2 px-4 rounded mr-2">Yes,
                        Delete</button>
                    <button type="button" class="bg-gray-600 hover:bg-gray-500 text-white py-2 px-4 rounded"
                        onclick="closeDeleteModal()">Cancel</button>
                </form>
            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $users->links() }}
        </div>
    @endif
</div>

<!-- ============================================================== JS ============================================================== -->
<script>

    // Edit modal open JS
    function openEditModal(user) {
        const editForm = document.getElementById('editForm');
        editForm.action = editForm.action.replace(':userId', user.id);
        document.getElementById('name').value = user.name;
        document.getElementById('email').value = user.email;

        const approvedCheckbox = document.getElementById('is_approved');
        approvedCheckbox.checked = Boolean(user.is_approved);

        const rolesSelect = document.getElementById('roles');
        rolesSelect.value = user.roles;

        document.getElementById('editModal').classList.remove('hidden');
    }

    // Close the Edit Modal
    function closeModal() {
        document.getElementById('editModal').classList.add('hidden');
    }

    // Open delete modal
    function openDeleteModal(userId) {
        const form = document.getElementById('confirmDeleteForm');
        form.action = '/admin/users/' + userId;
        document.getElementById('deleteModal').classList.remove('hidden');
    }

    // Close delete modal
    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
    }

    // Select/Deselect all checkboxes
    const selectAllCheckbox = document.getElementById('select-all');
    selectAllCheckbox.addEventListener('change', () => {
        const checkboxes = document.querySelectorAll('.user-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.checked = selectAllCheckbox.checked;
        });
    });

    // Bulk action for approve/delete
    function submitBulkAction(hiddenFieldId, checkboxClass, formId) {
        const selectedIds = [];
        document.querySelectorAll(checkboxClass).forEach(checkbox => {
            if (checkbox.checked) {
                selectedIds.push(checkbox.value);
            }
        });

        if (selectedIds.length === 0) {
            alert('Please select at least one user.');
            return;
        }

        // Set the selected IDs as an array
        document.getElementById(hiddenFieldId).value = JSON.stringify(selectedIds);
        document.querySelector(formId).submit();
    }

    // Real-time search and filter
    document.getElementById('search').addEventListener('input', filterUsers);
    document.getElementById('date_filter').addEventListener('change', filterUsers);

    function filterUsers() {
        const searchValue = document.getElementById('search').value.toLowerCase();
        const filterValue = document.getElementById('date_filter').value;
        const rows = document.querySelectorAll('#userTableBody tr');
        let noUsersFound = true;

        rows.forEach(row => {
            const name = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
            const email = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
            const createdAt = row.querySelector('td:nth-child(6)').textContent;

            let showRow = true;

            if (searchValue && !(name.includes(searchValue) || email.includes(searchValue))) {
                showRow = false;
            }

            if (filterValue) {
                const today = new Date().toISOString().split('T')[0];
                const yesterday = new Date(Date.now() - 86400000).toISOString().split('T')[0];
                const lastWeek = new Date(Date.now() - 604800000).toISOString().split('T')[0];
                const lastMonth = new Date(new Date().setMonth(new Date().getMonth() - 1)).toISOString().split('T')[0];

                switch (filterValue) {
                    case 'today':
                        if (createdAt !== today) showRow = false;
                        break;
                    case 'yesterday':
                        if (createdAt !== yesterday) showRow = false;
                        break;
                    case 'last_week':
                        if (createdAt < lastWeek) showRow = false;
                        break;
                    case 'last_month':
                        if (createdAt < lastMonth) showRow = false;
                        break;
                }
            }

            row.style.display = showRow ? '' : 'none';
            if (showRow) noUsersFound = false;
        });

        document.getElementById('noUsersMessage').classList.toggle('hidden', !noUsersFound);
    }
</script>

@endsection