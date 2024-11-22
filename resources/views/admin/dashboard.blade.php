@extends('layouts.admin')

@section('content')
<div class="p-6 space-y-6">
    <!-- Dashboard Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <!-- Total Users -->
        <div class="p-6 bg-blue-600 rounded-lg shadow-lg">
            <h5 class="text-lg font-semibold text-gray-200">Total Users</h5>
            <p class="mt-3 text-4xl font-bold text-white">{{ $totalUsers }}</p>
        </div>
        
        <!-- User Accounts -->
        <div class="p-6 bg-green-600 rounded-lg shadow-lg">
            <h5 class="text-lg font-semibold text-gray-200">User Accounts</h5>
            <p class="mt-3 text-4xl font-bold text-white">{{ $userUsers }}</p>
        </div>
        
        <!-- Pending Approvals -->
        <div class="p-6 bg-yellow-600 rounded-lg shadow-lg">
            <h5 class="text-lg font-semibold text-gray-800">Pending Approvals</h5>
            <p class="mt-3 text-4xl font-bold text-gray-900">{{ $pendingUsers }}</p>
        </div>
    </div>

    <!-- Admin Menu -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        <div class="col-span-1">
            <div class="bg-gray-800 rounded-lg shadow-lg">
                <div class="p-5">
                    <h5 class="text-lg font-semibold text-gray-200">Admin Menu</h5>
                    <ul class="mt-4 space-y-2">
                        <li>
                            <a href="{{ route('admin.manage-users') }}"
                                class="block p-2 text-sm font-medium text-gray-200 rounded-md hover:bg-gray-700">
                                Manage Users
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.approvals') }}"
                                class="block p-2 text-sm font-medium text-gray-200 rounded-md hover:bg-gray-700">
                                Approve Accounts
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.settings') }}"
                                class="block p-2 text-sm font-medium text-gray-200 rounded-md hover:bg-gray-700">
                                System Settings
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="col-span-1 lg:col-span-3">
            <div class="bg-gray-800 rounded-lg shadow-lg">
                <div class="p-5">
                    <h5 class="text-lg font-semibold text-gray-200">Recent Activity</h5>
                    <p class="mt-4 text-sm text-gray-400">No recent activity.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection