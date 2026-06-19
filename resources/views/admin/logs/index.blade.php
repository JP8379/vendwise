@extends('admin.layouts.app')

@section('content')
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">System Logs</h1>
        <p class="text-gray-600 mt-1">
            Monitor admin activities, account changes, and system actions.
        </p>
    </div>

    <!-- Summary Cards -->
    <div class="grid gap-5 sm:grid-cols-2 xl:grid-cols-4 mb-6">
        <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
            <p class="text-sm text-gray-500">Total Logs</p>
            <h3 class="mt-3 text-3xl font-bold text-blue-600">{{ $totalLogs }}</h3>
        </div>

        <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
            <p class="text-sm text-gray-500">Today</p>
            <h3 class="mt-3 text-3xl font-bold text-green-600">{{ $todayLogs }}</h3>
        </div>

        <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
            <p class="text-sm text-gray-500">Activations</p>
            <h3 class="mt-3 text-3xl font-bold text-emerald-600">{{ $activationLogs }}</h3>
        </div>

        <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
            <p class="text-sm text-gray-500">Deactivations</p>
            <h3 class="mt-3 text-3xl font-bold text-red-500">{{ $deactivationLogs }}</h3>
        </div>
    </div>

    <!-- Admin Insight -->
    <div class="mb-6 rounded-2xl bg-blue-50 border border-blue-200 p-5">
        <h3 class="font-bold text-blue-800">System Insight</h3>
        <p class="text-sm text-blue-700 mt-2">
            There are <strong>{{ $totalLogs }}</strong> recorded system activities.
            @if($todayLogs > 0)
                <strong>{{ $todayLogs }}</strong> action(s) were recorded today.
            @else
                No admin activity has been recorded today.
            @endif
        </p>
    </div>

    <!-- Logs Table -->
    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
        <div class="flex flex-col gap-4 px-6 py-5 border-b border-gray-200 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Recent Logs</h2>
                <p class="text-sm text-gray-500 mt-1">
                    Search and filter latest system activities.
                </p>
            </div>

            <form method="GET" action="{{ route('admin.logs.index') }}" class="flex flex-col gap-3 lg:flex-row">
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search action or description"
                    class="w-full lg:w-72 px-4 py-2.5 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500"
                >

                <select
                    name="action"
                    class="px-4 py-2.5 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                    <option value="all" {{ request('action') == 'all' || request('action') == '' ? 'selected' : '' }}>
                        All Actions
                    </option>

                    @foreach($actions as $action)
                        <option value="{{ $action }}" {{ request('action') == $action ? 'selected' : '' }}>
                            {{ $action }}
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
                    href="{{ route('admin.logs.index') }}"
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
                        <th class="px-6 py-4">Log ID</th>
                        <th class="px-6 py-4">Admin</th>
                        <th class="px-6 py-4">Action</th>
                        <th class="px-6 py-4">Description</th>
                        <th class="px-6 py-4">Date & Time</th>
                        <th class="px-6 py-4">Time Ago</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200 bg-white">
                    @forelse($logs as $log)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 font-semibold text-gray-900">
                                {{ 'L' . str_pad($log->id, 3, '0', STR_PAD_LEFT) }}
                            </td>

                            <td class="px-6 py-4">
                                <div>
                                    <p class="font-semibold text-gray-900">
                                        {{ $log->admin->name ?? 'Admin' }}
                                    </p>
                                    <p class="text-xs text-gray-500">
                                        Admin #{{ $log->admin_id }}
                                    </p>
                                </div>
                            </td>

                            <td class="px-6 py-4">
                                <span class="px-3 py-1 text-xs font-semibold rounded-full
                                    @if(str_contains($log->action, 'Activation'))
                                        bg-green-100 text-green-700
                                    @elseif(str_contains($log->action, 'Deactivation'))
                                        bg-red-100 text-red-700
                                    @elseif(str_contains($log->action, 'Settings'))
                                        bg-purple-100 text-purple-700
                                    @elseif(str_contains($log->action, 'Support'))
                                        bg-yellow-100 text-yellow-700
                                    @else
                                        bg-gray-100 text-gray-700
                                    @endif">
                                    {{ $log->action }}
                                </span>
                            </td>

                            <td class="px-6 py-4 text-gray-700 max-w-xl">
                                {{ $log->description }}
                            </td>

                            <td class="px-6 py-4 text-gray-700 whitespace-nowrap">
                                {{ $log->created_at->format('d M Y, h:i A') }}
                            </td>

                            <td class="px-6 py-4 text-gray-500 whitespace-nowrap">
                                {{ $log->created_at->diffForHumans() }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <p class="font-semibold text-gray-700">No logs available yet</p>
                                <p class="text-sm text-gray-500 mt-1">
                                    System actions will appear here once admin activities are recorded.
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(method_exists($logs, 'links'))
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $logs->links() }}
            </div>
        @endif
    </div>
@endsection