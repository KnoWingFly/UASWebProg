@extends('layouts.app')

@section('title', 'User Approvals')

@section('content')
    <div class="container mx-auto mt-8">
        <h1 class="text-3xl font-semibold mb-4">User Approvals</h1>

        <form action="{{ route('admin.users.bulkApprove') }}" method="POST">
            @csrf
            <div class="mb-4 flex items-center">
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-lg shadow-md hover:bg-green-600">
                    Approve Selected Users
                </button>
            </div>

            <table class="table-auto w-full border-collapse border border-gray-200">
                <thead>
                    <tr>
                        <th class="border-b text-left px-4 py-2">
                            <input type="checkbox" id="selectAll" class="form-checkbox" />
                        </th>
                        <th class="border-b text-left px-4 py-2">Name</th>
                        <th class="border-b text-left px-4 py-2">Email</th>
                        <th class="border-b text-left px-4 py-2">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td class="border-b px-4 py-2">
                                <input type="checkbox" name="user_ids[]" value="{{ $user->id }}" class="userCheckbox form-checkbox" />
                            </td>
                            <td class="border-b px-4 py-2">{{ $user->name }}</td>
                            <td class="border-b px-4 py-2">{{ $user->email }}</td>
                            <td class="border-b px-4 py-2">
                                @if($user->is_approved)
                                    <span class="text-green-500">Approved</span>
                                @else
                                    <span class="text-red-500">Not Approved</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </form>

    </div>

    <!-- JavaScript to handle bulk select -->
    <script>
        document.getElementById('selectAll').addEventListener('change', function () {
            let checkboxes = document.querySelectorAll('.userCheckbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });
    </script>

@endsection
