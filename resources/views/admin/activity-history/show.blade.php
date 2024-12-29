@extends('layouts.admin')

@section('content')
<style>
        /* Fade-in effect for the form */
    .fade-in {
        opacity: 0;
        transform: translateY(20px);
        animation: fadeIn 0.6s ease-in-out forwards;
    }

    /* Fade-in animation keyframes */
    @keyframes fadeIn {
        0% {
            opacity: 0;
            transform: translateY(20px);
        }
        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Table container styles */
    .overflow-x-auto {
        width: 100%;
        max-width: 100%; /* Prevents horizontal dragging */
        overflow-x: auto; /* Adds scroll if necessary */
    }

    /* Table styles */
    table {
        width: 100%;
        table-layout: auto; /* Ensures the table adjusts based on content */
        border-collapse: collapse; /* Cleaner table look */
    }

    /* Responsive container padding */
    @media (min-width: 768px) {
        .overflow-x-auto {
            padding: 0 1rem; /* Adds padding for wider screens */
        }
    }

    /* Table row hover effects */
    tbody tr {
        transition: background-color 0.3s ease, transform 0.2s ease;
    }
    tbody tr:hover {
        background-color: #333333;
        transform: scale(1.02);
    }

    /* Button hover effect */
    button {
        transition: background-color 0.3s ease, transform 0.2s ease;
    }
    button:hover {
        transform: translateY(-2px);
    }
</style>

<div class="fade-in">
    <form action="{{ route('admin.activity-history.manage-users', $activity) }}" method="POST">
        @csrf
        <input type="hidden" name="activity_history_id" value="{{ $activity->id }}">
        <input type="hidden" name="user_ids" value="">

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-[#1a1a1a] text-gray-400">
                    <tr>
                        <th scope="col" class="p-4">
                            <input id="select-all-checkbox" type="checkbox"
                                   class="w-4 h-4 text-[#ff4d4d] bg-[#1a1a1a] border-gray-300 rounded focus:ring-[#ff4d4d]">
                        </th>
                        <th scope="col" class="px-6 py-3">Name</th>
                        <th scope="col" class="px-6 py-3">Email</th>
                        <th scope="col" class="px-6 py-3">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr class="bg-[#1a1a1a] border-b dark:bg-[#1a1a1a] dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-[#333333]">
                        <td class="p-4">
                            <input id="checkbox-user-{{ $user->id }}" type="checkbox" 
                                   name="user_ids[]" 
                                   value="{{ $user->id }}"
                                   {{ $activity->users->contains($user->id) ? 'checked' : '' }}
                                   class="user-checkbox w-4 h-4 text-[#ff4d4d] bg-[#1a1a1a] border-gray-300 rounded">
                        </td>
                        <td class="px-6 py-4">{{ $user->name }}</td>
                        <td class="px-6 py-4">{{ $user->email }}</td>
                        <td class="px-6 py-4">
                            @if($activity->users->contains($user->id))
                            <span class="status-text text-green-600">In Activity</span>
                            @else
                            <span class="status-text text-gray-400">Not in Activity</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination Info and Controls -->
        <div class="flex justify-between items-center mt-4">
            <!-- Pagination Info (moved to the right) -->
            <div id="pagination-info" class="ml-4 text-sm text-gray-500">
                Showing <span id="current-start">1</span> to <span id="current-end">5</span> of <span id="total-results">0</span> results
            </div>

            <!-- Pagination -->
            <div id="pagination" class="flex justify-end mt-4"></div>
        </div>

        <!-- Submit button -->
        <div class="mt-4 flex justify-end">
            <button type="submit"
                    class="text-white bg-[#ff4d4d] hover:bg-[#e04343] focus:ring-4 focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5">
                Update Users
            </button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const rowsPerPage = 10; // Jumlah baris per halaman
        const tableBody = document.querySelector('tbody');
        const rows = tableBody.querySelectorAll('tr');
        const pagination = document.getElementById('pagination');
        const paginationInfo = document.getElementById('pagination-info');
        const currentStart = document.getElementById('current-start');
        const currentEnd = document.getElementById('current-end');
        const totalResults = document.getElementById('total-results');

        const totalPages = Math.ceil(rows.length / rowsPerPage);

        // Update pagination info
        function updatePaginationInfo(page) {
            const start = (page - 1) * rowsPerPage + 1;
            const end = Math.min(page * rowsPerPage, rows.length);
            currentStart.textContent = start;
            currentEnd.textContent = end;
            totalResults.textContent = rows.length;
        }

        // Fungsi untuk menampilkan halaman tertentu
        function displayPage(page) {
            const start = (page - 1) * rowsPerPage;
            const end = start + rowsPerPage;

            rows.forEach((row, index) => {
                row.style.display = (index >= start && index < end) ? '' : 'none';
            });

            updatePaginationInfo(page); // Update informasi pagination
        }

        // Fungsi untuk membuat pagination
        function createPagination() {
            pagination.innerHTML = ''; // Hapus pagination sebelumnya

            for (let i = 1; i <= totalPages; i++) {
                const button = document.createElement('button');
                button.textContent = i;
                button.className = 'px-3 py-1 mx-1 text-white bg-[#ff4d4d] hover:bg-[#e04343] rounded';
                button.addEventListener('click', function (event) {
                    event.preventDefault(); // Mencegah submit form
                    displayPage(i);

                    // Highlight tombol aktif
                    const activeButton = pagination.querySelector('.active');
                    if (activeButton) activeButton.classList.remove('active');
                    button.classList.add('active');
                });

                if (i === 1) button.classList.add('active'); // Halaman pertama aktif secara default
                pagination.appendChild(button);
            }
        }

        createPagination();
        displayPage(1); // Tampilkan halaman pertama
    });
</script>

@endsection
