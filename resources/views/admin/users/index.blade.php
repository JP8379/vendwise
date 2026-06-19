@extends('admin.layouts.app')

@section('content')
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">User Management</h1>
        <p class="text-gray-600 mt-1">
            Manage vendor accounts, monitor activity, update account status, and review account deletion requests.
        </p>
    </div>

    @if(session('success'))
        <div class="mb-6 px-5 py-4 rounded-2xl bg-green-50 border border-green-200 text-green-700">
            {{ session('success') }}
        </div>
    @endif

    @if(session('warning'))
        <div class="mb-6 px-5 py-4 rounded-2xl bg-orange-50 border border-orange-200 text-orange-700">
            {{ session('warning') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 px-5 py-4 rounded-2xl bg-red-50 border border-red-200 text-red-700">
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-6 px-5 py-4 rounded-2xl bg-red-50 border border-red-200 text-red-700">
            <p class="font-semibold mb-2">Please check the following:</p>
            <ul class="list-disc pl-5 space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Summary Cards -->
    <div class="grid gap-5 sm:grid-cols-2 xl:grid-cols-5 mb-6">
        <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
            <p class="text-sm text-gray-500">Total Vendors</p>
            <h3 class="mt-3 text-3xl font-bold text-blue-600">{{ $totalUsers }}</h3>
        </div>

        <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
            <p class="text-sm text-gray-500">Active Vendors</p>
            <h3 class="mt-3 text-3xl font-bold text-green-600">{{ $activeUsers }}</h3>
        </div>

        <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
            <p class="text-sm text-gray-500">Deactivated</p>
            <h3 class="mt-3 text-3xl font-bold text-red-500">{{ $inactiveUsers }}</h3>
        </div>

        <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
            <p class="text-sm text-gray-500">New This Month</p>
            <h3 class="mt-3 text-3xl font-bold text-purple-600">{{ $newUsers }}</h3>
        </div>

        <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
            <p class="text-sm text-gray-500">Deletion Requests</p>
            <h3 class="mt-3 text-3xl font-bold text-orange-500">
                {{ $pendingDeletionRequests ?? 0 }}
            </h3>
        </div>
    </div>

    <!-- Admin Insight -->
    <div class="mb-6 rounded-2xl bg-blue-50 border border-blue-200 p-5">
        <h3 class="font-bold text-blue-800">Admin Insight</h3>
        <p class="text-sm text-blue-700 mt-2">
            You currently have <strong>{{ $activeUsers }}</strong> active vendors out of
            <strong>{{ $totalUsers }}</strong> total vendors.
            @if(($pendingDeletionRequests ?? 0) > 0)
                There are <strong>{{ $pendingDeletionRequests }}</strong> pending account deletion request(s) that require admin review.
            @elseif($inactiveUsers > 0)
                There are <strong>{{ $inactiveUsers }}</strong> deactivated accounts that may require review.
            @else
                All vendor accounts are currently active and there are no pending deletion requests.
            @endif
        </p>
    </div>

    <!-- Account Deletion Requests -->
    <div class="mb-6 bg-white border border-orange-200 rounded-2xl shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-orange-100 bg-orange-50">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-orange-700">Account Deletion Requests</h2>
                    <p class="text-sm text-orange-600 mt-1">
                        Review vendor requests before deactivating their accounts.
                    </p>
                </div>

                <span class="px-4 py-2 rounded-full bg-orange-100 text-orange-700 text-sm font-bold">
                    {{ ($deletionRequests ?? collect())->count() }} Pending
                </span>
            </div>
        </div>

        @if(($deletionRequests ?? collect())->isEmpty())
            <div class="p-8 text-center text-gray-500">
                <div class="mx-auto mb-3 h-14 w-14 rounded-2xl bg-orange-50 flex items-center justify-center text-3xl">
                    🛡️
                </div>
                <p class="font-semibold text-gray-700">No pending deletion requests</p>
                <p class="text-sm mt-1">New vendor deletion requests will appear here for admin review.</p>
            </div>
        @else
            <div class="divide-y divide-gray-100">
                @foreach($deletionRequests as $requestVendor)
                    <div class="p-6">
                        <div class="flex flex-col gap-5 xl:flex-row xl:items-start xl:justify-between">
                            <div class="flex items-start gap-4">
                                <div class="h-12 w-12 rounded-2xl bg-orange-100 text-orange-700 flex items-center justify-center font-bold text-lg">
                                    {{ strtoupper(substr($requestVendor->business_name ?? $requestVendor->name ?? 'V', 0, 1)) }}
                                </div>

                                <div>
                                    <div class="flex flex-wrap items-center gap-2">
                                        <h3 class="font-bold text-gray-900">
                                            {{ $requestVendor->business_name ?? 'No Business Name' }}
                                        </h3>

                                        <span class="px-3 py-1 rounded-full bg-orange-100 text-orange-700 text-xs font-bold">
                                            Pending Review
                                        </span>
                                    </div>

                                    <p class="text-sm text-gray-500 mt-1">
                                        Owner: {{ $requestVendor->name ?? 'N/A' }}
                                    </p>

                                    <p class="text-sm text-gray-500">
                                        Email: {{ $requestVendor->email }}
                                    </p>

                                    <p class="text-xs text-orange-600 mt-2">
                                        Requested on:
                                        {{ $requestVendor->deletion_requested_at ? $requestVendor->deletion_requested_at->format('d/m/Y h:i A') : 'N/A' }}
                                    </p>
                                </div>
                            </div>

                            <div class="w-full xl:w-[440px]">
                                <div class="flex flex-col gap-3">
                                    <!-- Approve -->
                                    <form method="POST" action="{{ route('admin.users.approve-deletion-request', $requestVendor->id) }}">
                                        @csrf
                                        @method('PATCH')

                                        <button type="submit"
                                            onclick="return confirm('Approve this account deletion request? The vendor account will be deactivated and the vendor will no longer be able to access VendWise.')"
                                            class="w-full px-4 py-2.5 rounded-xl bg-red-600 text-white text-sm font-semibold hover:bg-red-700 transition">
                                            Approve & Deactivate Account
                                        </button>
                                    </form>

                                    <!-- Reject -->
                                    <form method="POST" action="{{ route('admin.users.reject-deletion-request', $requestVendor->id) }}" class="space-y-2">
                                        @csrf
                                        @method('PATCH')

                                        <textarea name="rejection_reason"
                                            rows="2"
                                            placeholder="Reason for rejection..."
                                            class="w-full rounded-xl border border-gray-300 px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500"
                                            required></textarea>

                                        <button type="submit"
                                            onclick="return confirm('Reject this account deletion request? The vendor will see your rejection reason in their settings page.')"
                                            class="w-full px-4 py-2.5 rounded-xl bg-gray-100 text-gray-700 text-sm font-semibold hover:bg-gray-200 transition">
                                            Reject Request
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Vendor Table -->
    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
        <div class="flex flex-col gap-4 px-6 py-5 border-b border-gray-200 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Vendor List</h2>
                <p class="text-sm text-gray-500 mt-1">
                    Search, filter, activate, deactivate, and review vendor accounts.
                </p>
            </div>

            <form method="GET" action="{{ route('admin.users.index') }}" class="flex flex-col gap-3 lg:flex-row">
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search name, business, or email"
                    class="w-full lg:w-72 px-4 py-2.5 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500"
                >

                <select
                    name="status"
                    class="px-4 py-2.5 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                    <option value="all" {{ request('status') == 'all' || request('status') == '' ? 'selected' : '' }}>All Status</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="deactivated" {{ request('status') == 'deactivated' ? 'selected' : '' }}>Deactivated</option>
                </select>

                <select
                    name="deletion_status"
                    class="px-4 py-2.5 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                    <option value="all" {{ request('deletion_status') == 'all' || request('deletion_status') == '' ? 'selected' : '' }}>
                        All Deletion Status
                    </option>
                    <option value="none" {{ request('deletion_status') == 'none' ? 'selected' : '' }}>No Request</option>
                    <option value="pending" {{ request('deletion_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ request('deletion_status') == 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="rejected" {{ request('deletion_status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>

                <select
                    name="business_type"
                    class="px-4 py-2.5 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                    <option value="all" {{ request('business_type') == 'all' || request('business_type') == '' ? 'selected' : '' }}>
                        All Business Types
                    </option>

                    @foreach($businessTypes as $type)
                        <option value="{{ $type }}" {{ request('business_type') == $type ? 'selected' : '' }}>
                            {{ ucfirst($type) }}
                        </option>
                    @endforeach
                </select>

                <button
                    type="submit"
                    class="px-5 py-2.5 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition font-semibold"
                >
                    Apply
                </button>

                <a
                    href="{{ route('admin.users.index') }}"
                    class="px-5 py-2.5 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition font-semibold text-center"
                >
                    Reset
                </a>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-left">
                <thead class="bg-gray-50 text-gray-500 uppercase text-xs tracking-wider">
                    <tr>
                        <th class="px-6 py-4">Vendor ID</th>
                        <th class="px-6 py-4">Vendor</th>
                        <th class="px-6 py-4">Business Type</th>
                        <th class="px-6 py-4">Email</th>
                        <th class="px-6 py-4">Joined Date</th>
                        <th class="px-6 py-4">Last Updated</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Deletion Request</th>
                        <th class="px-6 py-4 text-right">Action</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200 bg-white">
                    @forelse($vendors as $vendor)
                        @php
                            $deletionStatus = $vendor->deletion_request_status ?? 'none';
                        @endphp

                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 font-semibold text-gray-900">
                                {{ 'V' . str_pad($vendor->id, 3, '0', STR_PAD_LEFT) }}
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="h-10 w-10 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center font-bold">
                                        {{ strtoupper(substr($vendor->business_name ?? $vendor->name ?? 'V', 0, 1)) }}
                                    </div>

                                    <div>
                                        <p class="font-semibold text-gray-900">
                                            {{ $vendor->business_name ?? 'No Business Name' }}
                                        </p>
                                        <p class="text-xs text-gray-500">
                                            {{ $vendor->name ?? 'No owner name' }}
                                        </p>
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-4 text-gray-700">
                                {{ $vendor->business_type ? ucfirst($vendor->business_type) : 'N/A' }}
                            </td>

                            <td class="px-6 py-4 text-gray-700">
                                {{ $vendor->email }}
                            </td>

                            <td class="px-6 py-4 text-gray-700">
                                {{ $vendor->created_at ? $vendor->created_at->format('d M Y') : 'N/A' }}
                            </td>

                            <td class="px-6 py-4 text-gray-700">
                                {{ $vendor->updated_at ? $vendor->updated_at->diffForHumans() : 'N/A' }}
                            </td>

                            <td class="px-6 py-4">
                                @if($vendor->status === 'active')
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">
                                        Active
                                    </span>
                                @else
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-700">
                                        Deactivated
                                    </span>
                                @endif
                            </td>

                            <td class="px-6 py-4">
                                @if($deletionStatus === 'pending')
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-orange-100 text-orange-700">
                                        Pending
                                    </span>
                                    <p class="text-xs text-gray-500 mt-1">
                                        {{ $vendor->deletion_requested_at ? $vendor->deletion_requested_at->format('d/m/Y') : '' }}
                                    </p>
                                @elseif($deletionStatus === 'approved')
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">
                                        Approved
                                    </span>
                                @elseif($deletionStatus === 'rejected')
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-700">
                                        Rejected
                                    </span>
                                @else
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-600">
                                        No Request
                                    </span>
                                @endif
                            </td>

                            <td class="px-6 py-4 text-right">
                                <form method="POST" action="{{ route('admin.users.toggle-status', $vendor->id) }}">
                                    @csrf
                                    @method('PATCH')

                                    @if($vendor->status === 'active')
                                        <button
                                            type="submit"
                                            onclick="return confirm('Deactivate this vendor account?')"
                                            class="px-4 py-2 text-sm font-semibold text-red-600 bg-red-50 rounded-xl hover:bg-red-100 transition"
                                        >
                                            Deactivate
                                        </button>
                                    @else
                                        <button
                                            type="submit"
                                            onclick="return confirm('Activate this vendor account?')"
                                            class="px-4 py-2 text-sm font-semibold text-green-600 bg-green-50 rounded-xl hover:bg-green-100 transition"
                                        >
                                            Activate
                                        </button>
                                    @endif
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-6 py-12 text-center">
                                <div class="text-gray-500">
                                    <p class="font-semibold text-gray-700">No vendors found</p>
                                    <p class="text-sm mt-1">Try changing your search or filter options.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(method_exists($vendors, 'links'))
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $vendors->links() }}
            </div>
        @endif
    </div>
@endsection