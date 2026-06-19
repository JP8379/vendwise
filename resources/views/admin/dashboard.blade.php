@extends('admin.layouts.app')

@section('content')
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">System Oversight</h1>
        <p class="text-gray-600 mt-1">
            Manage vendors, monitor system activity, and handle support requests.
        </p>
    </div>

    <!-- Summary Cards -->
    <div class="grid gap-5 sm:grid-cols-2 xl:grid-cols-4 mb-6">
        <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
            <p class="text-sm text-gray-500">Total Vendors</p>
            <h3 class="mt-3 text-3xl font-bold text-blue-600">{{ $totalVendors }}</h3>
        </div>

        <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
            <p class="text-sm text-gray-500">Active Vendors</p>
            <h3 class="mt-3 text-3xl font-bold text-green-600">{{ $activeVendors }}</h3>
        </div>

        <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
            <p class="text-sm text-gray-500">Deactivated</p>
            <h3 class="mt-3 text-3xl font-bold text-red-500">{{ $deactivatedVendors }}</h3>
        </div>

        <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
            <p class="text-sm text-gray-500">Pending Tickets</p>
            <h3 class="mt-3 text-3xl font-bold text-yellow-600">{{ $pendingTickets }}</h3>
        </div>
    </div>

    <!-- Second Cards -->
    <div class="grid gap-5 sm:grid-cols-2 xl:grid-cols-3 mb-6">
        <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
            <p class="text-sm text-gray-500">Resolved Tickets</p>
            <h3 class="mt-3 text-3xl font-bold text-emerald-600">{{ $resolvedTickets }}</h3>
        </div>

        <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
            <p class="text-sm text-gray-500">Today System Logs</p>
            <h3 class="mt-3 text-3xl font-bold text-purple-600">{{ $todayLogs }}</h3>
        </div>

        <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
            <p class="text-sm text-gray-500">System Status</p>
            <h3 class="mt-3 text-2xl font-bold text-green-600">Operational</h3>
        </div>
    </div>

    <!-- Admin Insight -->
    <div class="mb-6 rounded-2xl bg-blue-50 border border-blue-200 p-5">
        <h3 class="font-bold text-blue-800">Admin Insight</h3>
        <p class="text-sm text-blue-700 mt-2">
            There are <strong>{{ $activeVendors }}</strong> active vendors out of
            <strong>{{ $totalVendors }}</strong> total vendors.
            @if($pendingTickets > 0)
                You also have <strong>{{ $pendingTickets }}</strong> pending support request(s) that need attention.
            @else
                All support requests are currently resolved.
            @endif
        </p>
    </div>

    <div class="grid gap-6 xl:grid-cols-2">
        <!-- Recent Vendors -->
        <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-200">
                <h2 class="text-2xl font-bold text-gray-900">Recent Vendors</h2>
                <p class="text-sm text-gray-500 mt-1">Latest registered vendor accounts</p>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-left">
                    <thead class="bg-gray-50 text-gray-500 uppercase text-xs tracking-wider">
                        <tr>
                            <th class="px-6 py-4">Vendor</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4">Joined</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200">
                        @forelse($recentVendors as $vendor)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4">
                                    <p class="font-semibold text-gray-900">
                                        {{ $vendor->business_name ?? $vendor->name ?? 'Unknown Vendor' }}
                                    </p>
                                    <p class="text-xs text-gray-500">
                                        {{ $vendor->email }}
                                    </p>
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

                                <td class="px-6 py-4 text-gray-600">
                                    {{ $vendor->created_at->format('d M Y') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-10 text-center text-gray-500">
                                    No vendors available yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Recent Logs -->
        <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-200">
                <h2 class="text-2xl font-bold text-gray-900">Recent System Activity</h2>
                <p class="text-sm text-gray-500 mt-1">Latest admin actions and system logs</p>
            </div>

            <div class="divide-y divide-gray-200">
                @forelse($recentLogs as $log)
                    <div class="px-6 py-4 hover:bg-gray-50 transition">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <span class="px-3 py-1 text-xs font-semibold rounded-full
                                    @if(str_contains($log->action, 'Activation'))
                                        bg-green-100 text-green-700
                                    @elseif(str_contains($log->action, 'Deactivation'))
                                        bg-red-100 text-red-700
                                    @elseif(str_contains($log->action, 'Support'))
                                        bg-yellow-100 text-yellow-700
                                    @else
                                        bg-gray-100 text-gray-700
                                    @endif">
                                    {{ $log->action }}
                                </span>

                                <p class="text-sm text-gray-700 mt-3">
                                    {{ $log->description }}
                                </p>

                                <p class="text-xs text-gray-500 mt-2">
                                    {{ $log->admin->name ?? 'Admin' }} · {{ $log->created_at->diffForHumans() }}
                                </p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="px-6 py-10 text-center text-gray-500">
                        No system activity recorded yet.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection