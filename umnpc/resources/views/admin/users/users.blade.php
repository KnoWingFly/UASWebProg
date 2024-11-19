@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Manage Users</h1>

    <!-- User Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full text-left text-sm text-gray-500">
            <thead class="bg-gray-100 text-xs uppercase text-gray-700">
                <tr>
                    <th scope="col" class="px-6 py-3">Name</th>
                    <th scope="col" class="px-6 py-3">Email</th>
                    <th scope="col" class="px-6 py-3">Status</th>
                    <th scope="col" class="px-6 py-3 text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $user->name }}</td>
                        <td class="px-6 py-4">{{ $user->email }}</td>
                        <td class="px-6 py-4">
                            @if ($user->is_approved)
                                <span class="px-2 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded-lg">Approved</span>
                            @else
                                <span class="px-2 py-1 text-xs font-semibold text-red-700 bg-red-100 rounded-lg">Not Approved</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if (!$user->is_approved)
                                <form action="{{ route('admin.users.approve', $user->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="px-4 py-2 text-sm text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                                        Approve
                                    </button>
                                </form>
                            @else
                                <button disabled class="px-4 py-2 text-sm text-gray-500 bg-gray-200 rounded-lg cursor-not-allowed">
                                    Already Approved
                                </button>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
