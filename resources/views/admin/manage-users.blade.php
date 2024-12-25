@extends('layouts.admin')

@section('content')
<div class="container mx-auto mt-8 opacity-0" id="mainContainer">
    <h1 class="text-2xl font-bold mb-6 text-white tracking-tight">Manage Users</h1>

    <!-- Feedback Messages with Animation -->
    @if(session('success') || session('error') || $errors->any())
    <div class="feedback-message opacity-0 transform translate-y-[-20px]">
        @if(session('success'))
            <div class="bg-[#ff4d4d] text-white p-4 mb-4 rounded-lg shadow-lg">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-[#ff4d4d] text-white p-4 mb-4 rounded-lg shadow-lg">
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-[#ff4d4d] text-white p-4 mb-4 rounded-lg shadow-lg">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
    @endif

    <!-- Search and Filter Section -->
    <div class="flex flex-col md:flex-row gap-4 mb-6 opacity-0" id="controlsSection">
        <div class="flex-1">
            <input type="text" id="search" placeholder="Search by name or email"
                class="w-full px-4 py-3 border border-[#ff4d4d] rounded-lg bg-[#1a1a1a] text-white placeholder-gray-400 focus:ring-2 focus:ring-[#ff4d4d] focus:border-transparent transition-all duration-300">
        </div>
        <div class="md:w-48">
            <select id="date_filter" name="date_filter" 
                class="w-full px-4 py-3 border border-[#ff4d4d] rounded-lg bg-[#1a1a1a] text-white focus:ring-2 focus:ring-[#ff4d4d] focus:border-transparent transition-all duration-300">
                <option value="">All Time</option>
                <option value="today">Today</option>
                <option value="yesterday">Yesterday</option>
                <option value="last_week">Last Week</option>
                <option value="last_month">Last Month</option>
            </select>
        </div>
    </div>

    <!-- Bulk Operations -->
    <div class="flex flex-wrap gap-3 mb-6 opacity-0" id="bulkActions">
        <form id="bulkApproveForm" action="{{ route('admin.users.bulk-approve') }}" method="POST">
            @csrf
            <input type="hidden" name="userIds" id="approveUserIds">
            <button type="button" onclick="submitBulkAction('approveUserIds', '.user-checkbox', '#bulkApproveForm')"
                class="px-6 py-2 bg-[#ff4d4d] text-white rounded-lg hover:bg-opacity-90 transform hover:scale-105 transition-all duration-300 shadow-lg">
                Approve Selected
            </button>
        </form>

        <form id="bulkDisapproveForm" action="{{ route('admin.users.bulk-disapprove') }}" method="POST">
            @csrf
            <input type="hidden" name="userIds" id="disapproveUserIds">
            <button type="button" onclick="submitBulkAction('disapproveUserIds', '.user-checkbox', '#bulkDisapproveForm')"
                class="px-6 py-2 bg-[#ff4d4d] text-white rounded-lg hover:bg-opacity-90 transform hover:scale-105 transition-all duration-300 shadow-lg">
                Disapprove Selected
            </button>
        </form>

        <form id="bulkDeleteForm" action="{{ route('admin.users.bulk-delete') }}" method="POST">
            @csrf
            <input type="hidden" name="userIds" id="deleteUserIds">
            <button type="button" onclick="submitBulkAction('deleteUserIds', '.user-checkbox', '#bulkDeleteForm')"
                class="px-6 py-2 bg-[#ff4d4d] text-white rounded-lg hover:bg-opacity-90 transform hover:scale-105 transition-all duration-300 shadow-lg">
                Delete Selected
            </button>
        </form>
    </div>

    <!-- Users Table -->
    <div class="relative overflow-hidden rounded-lg shadow-xl opacity-0" id="tableContainer">
        @if($users->isEmpty())
            <div class="text-center text-gray-400 py-8 bg-[#1a1a1a] rounded-lg">
                No users match your criteria.
            </div>
        @else
            <table class="w-full text-sm text-left text-white bg-[#151515]">
                <thead class="text-xs uppercase bg-[#1a1a1a] border-b border-[#ff4d4d]">
                    <tr>
                        <th scope="col" class="px-6 py-4">
                            <input type="checkbox" id="select-all" class="select-all-checkbox cursor-pointer">
                        </th>
                        <th scope="col" class="px-6 py-4">Name</th>
                        <th scope="col" class="px-6 py-4">Email</th>
                        <th scope="col" class="px-6 py-4">Roles</th>
                        <th scope="col" class="px-6 py-4">Status</th>
                        <th scope="col" class="px-6 py-4">Created At</th>
                        <th scope="col" class="px-6 py-4 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody id="userTableBody">
                    @foreach($users as $index => $user)
                        <tr class="user-row opacity-0 border-b border-[#1a1a1a] hover:bg-[#1a1a1a] transition-colors duration-200"
                            data-index="{{ $index }}">
                            <td class="px-6 py-4">
                                <input type="checkbox" class="user-checkbox cursor-pointer" value="{{ $user->id }}">
                            </td>
                            <td class="px-6 py-4">{{ $user->name }}</td>
                            <td class="px-6 py-4">{{ $user->email }}</td>
                            <td class="px-6 py-4">{{ $user->roles }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                                    {{ $user->is_approved ? 'bg-blue-500 text-white' : 'bg-[#ff4d4d] text-white' }}">
                                    {{ $user->is_approved ? 'Approved' : 'Not Approved' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">{{ $user->created_at->format('Y-m-d') }}</td>
                            <td class="px-6 py-4 text-center space-x-2">
                                <button onclick="openEditModal({{ $user }})"
                                    class="inline-flex items-center px-4 py-2 bg-[#ff4d4d] rounded-lg hover:bg-opacity-90 transform hover:scale-105 transition-all duration-300">
                                    Edit
                                </button>
                                <button onclick="openDeleteModal({{ $user->id }})"
                                    class="inline-flex items-center px-4 py-2 bg-[#ff4d4d] rounded-lg hover:bg-opacity-90 transform hover:scale-105 transition-all duration-300">
                                    Delete
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <!-- Modals remain mostly the same but with enhanced styling -->
    <!-- Edit Modal -->
    <div id="editModal" class="hidden fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm flex justify-center items-center">
        <div class="bg-[#1a1a1a] text-white p-8 rounded-xl shadow-2xl max-w-md w-full mx-4 transform scale-95 opacity-0" id="editModalContent">
            <h2 class="text-2xl font-bold mb-6">Edit User</h2>
            <form id="editForm" action="{{ route('admin.users.update', ':userId') }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-1">Name</label>
                        <input type="text" id="name" name="name" 
                            class="w-full px-4 py-2 rounded-lg bg-[#151515] border border-[#ff4d4d] focus:ring-2 focus:ring-[#ff4d4d] focus:border-transparent">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-1">Email</label>
                        <input type="email" id="email" name="email" 
                            class="w-full px-4 py-2 rounded-lg bg-[#151515] border border-[#ff4d4d] focus:ring-2 focus:ring-[#ff4d4d] focus:border-transparent">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-1">Role</label>
                        <select id="roles" name="roles" 
                            class="w-full px-4 py-2 rounded-lg bg-[#151515] border border-[#ff4d4d] focus:ring-2 focus:ring-[#ff4d4d] focus:border-transparent">
                            <option value="user">User</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    
                    <div class="flex items-center space-x-2">
                        <input type="checkbox" id="is_approved" name="is_approved" value="1" 
                            class="rounded bg-[#151515] border-[#ff4d4d] text-[#ff4d4d] focus:ring-[#ff4d4d]">
                        <label class="text-sm font-medium text-gray-300">Approved</label>
                    </div>
                </div>

                <div class="flex justify-end space-x-3 mt-6">
                    <button type="button" onclick="closeModal()" 
                        class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors duration-200">
                        Cancel
                    </button>
                    <button type="submit" 
                        class="px-4 py-2 bg-[#ff4d4d] text-white rounded-lg hover:bg-opacity-90 transition-colors duration-200">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Modal -->
    <div id="deleteModal" class="hidden fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm flex justify-center items-center">
        <div class="bg-[#1a1a1a] text-white p-8 rounded-xl shadow-2xl max-w-md w-full mx-4 transform scale-95 opacity-0" id="deleteModalContent">
            <h3 class="text-xl font-bold mb-4">Confirm Deletion</h3>
            <p class="text-gray-300 mb-6">Are you sure you want to delete this user? This action cannot be undone.</p>
            
            <form id="confirmDeleteForm" method="POST" action="" class="flex justify-end space-x-3">
                @csrf
                @method('DELETE')
                <button type="button" onclick="closeDeleteModal()" 
                    class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors duration-200">
                    Cancel
                </button>
                <button type="submit" 
                    class="px-4 py-2 bg-[#ff4d4d] text-white rounded-lg hover:bg-opacity-90 transition-colors duration-200">
                    Delete User
                </button>
            </form>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-6 opacity-0" id="paginationContainer">
        {{ $users->links() }}
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // Initial animations
    gsap.to('#mainContainer', {
        opacity: 1,
        duration: 0.5,
        ease: 'power2.out'
    });

    gsap.to('#controlsSection', {
        opacity: 1,
        y: 0,
        duration: 0.5,
        delay: 0.2,
        ease: 'power2.out'
    });

    gsap.to('#bulkActions', {
        opacity: 1,
        y: 0,
        duration: 0.5,
        delay: 0.3,
        ease: 'power2.out'
    });

    gsap.to('#tableContainer', {
        opacity: 1,
        y: 0,
        duration: 0.5,
        delay: 0.4,
        ease: 'power2.out'
    });

    // Animate table rows
    document.querySelectorAll('.user-row').forEach((row, index) => {
        gsap.to(row, {
            opacity: 1,
            y: 0,
            duration: 0.3,
            delay: 0.5 + (index * 0.05),
            ease: 'power2.out'
        });
    });

    gsap.to('#paginationContainer', {
        opacity: 1,
        y: 0,
        duration: 0.5,
        delay: 0.6,
        ease: 'power2.out'
    });

    // Animate feedback messages if present
    const feedbackMessage = document.querySelector('.feedback-message');
    if (feedbackMessage) {
        gsap.to(feedbackMessage, {
            opacity: 1,
            y: 0,
            duration: 0.5,
            delay: 0.2,
            ease: 'power2.out'
        });
    }
});

// Modal animations
function openEditModal(user) {
        const modal = document.getElementById('editModal');
        const modalContent = document.getElementById('editModalContent');
        
        // Set form values
        document.getElementById('editForm').action = document.getElementById('editForm').action.replace(':userId', user.id);
        document.getElementById('name').value = user.name;
        document.getElementById('email').value = user.email;
        document.getElementById('is_approved').checked = Boolean(user.is_approved);
        document.getElementById('roles').value = user.roles;

        // Show modal with animation
        modal.classList.remove('hidden');
        gsap.to(modalContent, {
            scale: 1,
            opacity: 1,
            duration: 0.3,
            ease: 'back.out(1.2)'
        });
    }

    function closeModal() {
        const modal = document.getElementById('editModal');
        const modalContent = document.getElementById('editModalContent');

        gsap.to(modalContent, {
            scale: 0.95,
            opacity: 0,
            duration: 0.2,
            ease: 'power2.in',
            onComplete: () => {
                modal.classList.add('hidden');
                // Reset transform to prevent issues with next opening
                modalContent.style.transform = 'scale(0.95)';
            }
        });
    }

    function openDeleteModal(userId) {
        const modal = document.getElementById('deleteModal');
        const modalContent = document.getElementById('deleteModalContent');
        
        // Set form action
        document.getElementById('confirmDeleteForm').action = '/admin/users/' + userId;

        // Show modal with animation
        modal.classList.remove('hidden');
        gsap.to(modalContent, {
            scale: 1,
            opacity: 1,
            duration: 0.3,
            ease: 'back.out(1.2)'
        });
    }

    function closeDeleteModal() {
        const modal = document.getElementById('deleteModal');
        const modalContent = document.getElementById('deleteModalContent');

        gsap.to(modalContent, {
            scale: 0.95,
            opacity: 0,
            duration: 0.2,
            ease: 'power2.in',
            onComplete: () => {
                modal.classList.add('hidden');
                modalContent.style.transform = 'scale(0.95)';
            }
        });
    }

    // Bulk actions handling
    function submitBulkAction(hiddenFieldId, checkboxClass, formId) {
        const selectedIds = [];
        document.querySelectorAll(checkboxClass).forEach(checkbox => {
            if (checkbox.checked) {
                selectedIds.push(checkbox.value);
            }
        });

        if (selectedIds.length === 0) {
            // Animate error message
            const errorMessage = document.createElement('div');
            errorMessage.className = 'fixed top-4 right-4 bg-[#ff4d4d] text-white px-6 py-3 rounded-lg shadow-lg z-50 transform translate-x-full';
            errorMessage.textContent = 'Please select at least one user';
            document.body.appendChild(errorMessage);

            gsap.to(errorMessage, {
                x: 0,
                duration: 0.3,
                ease: 'power2.out',
                onComplete: () => {
                    setTimeout(() => {
                        gsap.to(errorMessage, {
                            x: '100%',
                            duration: 0.3,
                            ease: 'power2.in',
                            onComplete: () => errorMessage.remove()
                        });
                    }, 3000);
                }
            });
            return;
        }

        document.getElementById(hiddenFieldId).value = JSON.stringify(selectedIds);
        document.querySelector(formId).submit();
    }

    // Select all functionality with animation
    const selectAllCheckbox = document.getElementById('select-all');
    selectAllCheckbox.addEventListener('change', () => {
        const checkboxes = document.querySelectorAll('.user-checkbox');
        checkboxes.forEach((checkbox, index) => {
            gsap.to(checkbox.closest('tr'), {
                backgroundColor: selectAllCheckbox.checked ? 'rgba(255, 77, 77, 0.1)' : 'transparent',
                duration: 0.2,
                delay: index * 0.02,
                ease: 'power2.inOut'
            });
            checkbox.checked = selectAllCheckbox.checked;
        });
    });

    // Real-time search and filter with animations
    let searchDebounceTimer;
    document.getElementById('search').addEventListener('input', (e) => {
        clearTimeout(searchDebounceTimer);
        searchDebounceTimer = setTimeout(() => filterUsers(e.target.value), 300);
    });
    
    document.getElementById('date_filter').addEventListener('change', () => filterUsers());

    function filterUsers() {
        const searchValue = document.getElementById('search').value.toLowerCase();
        const filterValue = document.getElementById('date_filter').value;
        const rows = document.querySelectorAll('#userTableBody tr');
        let visibleCount = 0;

        rows.forEach(row => {
            const name = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
            const email = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
            const createdAt = row.querySelector('td:nth-child(6)').textContent;

            let showRow = true;

            // Search filter
            if (searchValue && !(name.includes(searchValue) || email.includes(searchValue))) {
                showRow = false;
            }

            // Date filter
            if (filterValue && showRow) {
                const rowDate = new Date(createdAt);
                const today = new Date();
                today.setHours(0, 0, 0, 0);

                switch (filterValue) {
                    case 'today':
                        showRow = rowDate >= today;
                        break;
                    case 'yesterday':
                        const yesterday = new Date(today);
                        yesterday.setDate(yesterday.getDate() - 1);
                        showRow = rowDate >= yesterday && rowDate < today;
                        break;
                    case 'last_week':
                        const lastWeek = new Date(today);
                        lastWeek.setDate(lastWeek.getDate() - 7);
                        showRow = rowDate >= lastWeek;
                        break;
                    case 'last_month':
                        const lastMonth = new Date(today);
                        lastMonth.setMonth(lastMonth.getMonth() - 1);
                        showRow = rowDate >= lastMonth;
                        break;
                }
            }

            // Animate row visibility
            gsap.to(row, {
                opacity: showRow ? 1 : 0,
                height: showRow ? 'auto' : 0,
                duration: 0.3,
                ease: 'power2.inOut',
                onComplete: () => {
                    row.style.display = showRow ? '' : 'none';
                }
            });

            if (showRow) visibleCount++;
        });

        // Show/hide no results message
        const noResultsMsg = document.getElementById('noUsersMessage');
        if (noResultsMsg) {
            gsap.to(noResultsMsg, {
                opacity: visibleCount === 0 ? 1 : 0,
                height: visibleCount === 0 ? 'auto' : 0,
                duration: 0.3,
                ease: 'power2.inOut',
                onComplete: () => {
                    noResultsMsg.style.display = visibleCount === 0 ? 'block' : 'none';
                }
            });
        }
    }
</script>
@endsection