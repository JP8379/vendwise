@extends('admin.layouts.app')

@section('content')
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Support Inbox</h1>
        <p class="text-gray-600 mt-1">
            Manage vendor support requests, reply to issues, and monitor pending tickets.
        </p>
    </div>

    @if(session('success'))
        <div class="mb-6 px-5 py-4 rounded-2xl bg-green-50 border border-green-200 text-green-700">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 px-5 py-4 rounded-2xl bg-red-50 border border-red-200 text-red-700">
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-6 px-5 py-4 rounded-2xl bg-red-50 border border-red-200 text-red-700">
            <p class="font-semibold">Please fix the following:</p>
            <ul class="mt-2 list-disc list-inside text-sm">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Summary Cards -->
    <div class="grid gap-5 sm:grid-cols-2 xl:grid-cols-4 mb-6">
        <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
            <p class="text-sm text-gray-500">Total Tickets</p>
            <h3 class="mt-3 text-3xl font-bold text-blue-600">{{ $totalTickets }}</h3>
        </div>

        <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
            <p class="text-sm text-gray-500">Pending</p>
            <h3 class="mt-3 text-3xl font-bold text-yellow-600">{{ $pendingTickets }}</h3>
        </div>

        <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
            <p class="text-sm text-gray-500">Resolved</p>
            <h3 class="mt-3 text-3xl font-bold text-green-600">{{ $resolvedTickets }}</h3>
        </div>

        <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
            <p class="text-sm text-gray-500">Today</p>
            <h3 class="mt-3 text-3xl font-bold text-purple-600">{{ $todayTickets }}</h3>
        </div>
    </div>

    <!-- Support Insight -->
    <div class="mb-6 rounded-2xl bg-blue-50 border border-blue-200 p-5">
        <h3 class="font-bold text-blue-800">Support Insight</h3>

        <p class="text-sm text-blue-700 mt-2">
            You currently have <strong>{{ $pendingTickets }}</strong> pending support request(s).
            @if($pendingTickets > 0)
                Reply to unresolved tickets to improve vendor satisfaction.
            @else
                All support tickets are currently resolved.
            @endif
        </p>
    </div>

    <!-- Support Table -->
    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">

        <!-- Header -->
        <div class="flex flex-col gap-4 px-6 py-5 border-b border-gray-200 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Support Requests</h2>
                <p class="text-sm text-gray-500 mt-1">
                    Search, filter, reply, and resolve vendor support tickets.
                </p>
            </div>

            <!-- Filters -->
            <form method="GET"
                  action="{{ route('admin.support.index') }}"
                  class="flex flex-col gap-3 lg:flex-row">

                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search vendor, title, message, or reply"
                    class="w-full lg:w-80 px-4 py-2.5 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500"
                >

                <select
                    name="status"
                    class="px-4 py-2.5 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                    <option value="all" {{ request('status') == 'all' || request('status') == '' ? 'selected' : '' }}>
                        All Status
                    </option>

                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>
                        Pending
                    </option>

                    <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>
                        Resolved
                    </option>
                </select>

                <button
                    type="submit"
                    class="px-5 py-2.5 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition font-semibold"
                >
                    Apply
                </button>

                <a
                    href="{{ route('admin.support.index') }}"
                    class="px-5 py-2.5 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition font-semibold text-center"
                >
                    Reset
                </a>
            </form>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-left">

                <thead class="bg-gray-50 text-gray-500 uppercase text-xs tracking-wider">
                    <tr>
                        <th class="px-6 py-4">Ticket</th>
                        <th class="px-6 py-4">Vendor</th>
                        <th class="px-6 py-4">Issue & Reply</th>
                        <th class="px-6 py-4">Priority</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Created</th>
                        <th class="px-6 py-4 text-right">Admin Action</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200 bg-white">
                    @forelse($tickets as $ticket)

                        <tr class="hover:bg-gray-50 transition align-top">

                            <!-- Ticket ID -->
                            <td class="px-6 py-4 font-semibold text-gray-900 whitespace-nowrap">
                                {{ 'T' . str_pad($ticket->id, 3, '0', STR_PAD_LEFT) }}
                            </td>

                            <!-- Vendor -->
                            <td class="px-6 py-4">
                                <div>
                                    <p class="font-semibold text-gray-900">
                                        {{ $ticket->user->business_name ?? $ticket->user->name ?? 'Unknown Vendor' }}
                                    </p>

                                    <p class="text-xs text-gray-500">
                                        {{ $ticket->user->email ?? 'No email available' }}
                                    </p>
                                </div>
                            </td>

                            <!-- Issue and Admin Reply -->
                            <td class="px-6 py-4 text-gray-700 max-w-xl">

                                @if($ticket->title)
                                    <p class="font-semibold text-gray-900 mb-1">
                                        {{ $ticket->title }}
                                    </p>
                                @endif

                                <p class="text-sm text-gray-600">
                                    {{ $ticket->message }}
                                </p>

                                @if($ticket->admin_reply)
                                    <div class="mt-4 rounded-2xl bg-green-50 border border-green-200 p-4">
                                        <p class="text-xs font-bold uppercase tracking-wide text-green-700">
                                            Admin Reply
                                        </p>

                                        <p class="text-sm text-green-800 mt-2">
                                            {{ $ticket->admin_reply }}
                                        </p>

                                        @if($ticket->replied_at)
                                            <p class="text-xs text-green-600 mt-2">
                                                Replied {{ \Carbon\Carbon::parse($ticket->replied_at)->diffForHumans() }}
                                            </p>
                                        @endif
                                    </div>
                                @endif
                            </td>

                            <!-- Priority -->
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 text-xs font-semibold rounded-full
                                    @if($ticket->priority == 'high')
                                        bg-red-100 text-red-700
                                    @elseif($ticket->priority == 'medium')
                                        bg-yellow-100 text-yellow-700
                                    @else
                                        bg-green-100 text-green-700
                                    @endif">

                                    {{ ucfirst($ticket->priority ?? 'low') }}
                                </span>
                            </td>

                            <!-- Status -->
                            <td class="px-6 py-4">

                                @if($ticket->status == 'pending')
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-700">
                                        Pending
                                    </span>
                                @else
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">
                                        Resolved
                                    </span>
                                @endif

                            </td>

                            <!-- Created -->
                            <td class="px-6 py-4 text-gray-700 whitespace-nowrap">
                                <p>{{ $ticket->created_at->format('d M Y') }}</p>
                                <p class="text-xs text-gray-500">
                                    {{ $ticket->created_at->diffForHumans() }}
                                </p>
                            </td>

                            <!-- Admin Action -->
                            <td class="px-6 py-4 text-right min-w-[280px]">

                                <form method="POST"
                                      action="{{ route('admin.support.reply', $ticket->id) }}"
                                      class="space-y-3 text-left">
                                    @csrf

                                    <textarea
                                        name="admin_reply"
                                        rows="3"
                                        placeholder="Write reply to vendor..."
                                        class="w-full rounded-xl border-gray-300 text-sm focus:border-blue-500 focus:ring-blue-500"
                                    >{{ old('admin_reply', $ticket->admin_reply) }}</textarea>

                                    <div class="flex justify-end gap-2">
                                        <button
                                            type="submit"
                                            class="px-4 py-2 text-sm font-semibold text-blue-600 bg-blue-50 rounded-xl hover:bg-blue-100 transition"
                                        >
                                            {{ $ticket->admin_reply ? 'Update Reply' : 'Send Reply' }}
                                        </button>

                                        @if($ticket->status == 'pending')
                                            <button
                                                type="submit"
                                                formaction="{{ route('admin.support.resolve', $ticket->id) }}"
                                                onclick="return confirm('Mark this ticket as resolved without reply?')"
                                                class="px-4 py-2 text-sm font-semibold text-green-600 bg-green-50 rounded-xl hover:bg-green-100 transition"
                                            >
                                                Resolve
                                            </button>
                                        @endif
                                    </div>
                                </form>

                                @if($ticket->status == 'resolved')
                                    <p class="mt-3 text-sm font-semibold text-green-600 text-right">
                                        Completed
                                    </p>
                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <p class="font-semibold text-gray-700">
                                    No support tickets found
                                </p>

                                <p class="text-sm text-gray-500 mt-1">
                                    Vendor support requests will appear here.
                                </p>
                            </td>
                        </tr>

                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if(method_exists($tickets, 'links'))
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $tickets->links() }}
            </div>
        @endif

    </div>
@endsection