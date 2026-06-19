<x-app-layout>
    <div class="flex min-h-screen bg-slate-50">

        <x-sidebar />

        <main class="flex-1 overflow-x-hidden">
            <header class="bg-white border-b border-slate-200 px-6 lg:px-8 py-6">
                <h2 class="text-3xl font-bold text-slate-900">Support</h2>
                <p class="text-sm text-slate-500 mt-1">
                    Submit issues and view responses from the admin team.
                </p>
            </header>

            <div class="p-6 lg:p-8 space-y-8">

                @if(session('success'))
                    <div class="rounded-2xl bg-green-50 border border-green-200 px-5 py-4 text-green-700">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="rounded-2xl bg-red-50 border border-red-200 px-5 py-4 text-red-700">
                        <p class="font-semibold">Please fix the following:</p>
                        <ul class="mt-2 list-disc list-inside text-sm">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Submit Ticket -->
                <div class="bg-white border border-slate-200 rounded-3xl shadow-sm p-6">
                    <h3 class="text-xl font-bold text-slate-900">Submit Support Ticket</h3>
                    <p class="text-sm text-slate-500 mt-1">
                        Describe your issue clearly so admin can help you faster.
                    </p>

                    <form method="POST" action="{{ route('support.store') }}" class="mt-6 space-y-5">
                        @csrf

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Issue Title
                            </label>
                            <input
                                type="text"
                                name="title"
                                value="{{ old('title') }}"
                                placeholder="Example: Cannot add transaction"
                                class="w-full rounded-xl border-slate-300 focus:border-blue-500 focus:ring-blue-500"
                            >
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Priority
                            </label>
                            <select
                                name="priority"
                                class="w-full rounded-xl border-slate-300 focus:border-blue-500 focus:ring-blue-500"
                            >
                                <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Low</option>
                                <option value="medium" {{ old('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
                                <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>High</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Message
                            </label>
                            <textarea
                                name="message"
                                rows="5"
                                placeholder="Explain your issue here..."
                                class="w-full rounded-xl border-slate-300 focus:border-blue-500 focus:ring-blue-500"
                            >{{ old('message') }}</textarea>
                        </div>

                        <button
                            type="submit"
                            class="px-6 py-3 bg-blue-600 text-white rounded-xl font-semibold hover:bg-blue-700 transition"
                        >
                            Submit Ticket
                        </button>
                    </form>
                </div>

                <!-- My Tickets -->
                <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden">
                    <div class="px-6 py-5 border-b border-slate-200">
                        <h3 class="text-xl font-bold text-slate-900">My Support Tickets</h3>
                        <p class="text-sm text-slate-500 mt-1">
                            Track your submitted support requests and admin replies.
                        </p>
                    </div>

                    <div class="divide-y divide-slate-200">
                        @forelse($tickets as $ticket)
                            <div class="p-6 hover:bg-slate-50 transition">
                                <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">

                                    <div class="flex-1">
                                        <div class="flex flex-wrap items-center gap-3">
                                            <p class="font-bold text-slate-900">
                                                {{ 'T' . str_pad($ticket->id, 3, '0', STR_PAD_LEFT) }}
                                            </p>

                                            <span class="px-3 py-1 text-xs font-semibold rounded-full
                                                @if($ticket->priority == 'high') bg-red-100 text-red-700
                                                @elseif($ticket->priority == 'medium') bg-yellow-100 text-yellow-700
                                                @else bg-green-100 text-green-700
                                                @endif">
                                                {{ ucfirst($ticket->priority) }}
                                            </span>

                                            @if($ticket->status == 'pending')
                                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-700">
                                                    Pending
                                                </span>
                                            @else
                                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">
                                                    Resolved
                                                </span>
                                            @endif
                                        </div>

                                        <h4 class="mt-3 text-lg font-bold text-slate-900">
                                            {{ $ticket->title }}
                                        </h4>

                                        <p class="mt-2 text-sm text-slate-600">
                                            {{ $ticket->message }}
                                        </p>

                                        <p class="mt-3 text-xs text-slate-400">
                                            Submitted {{ $ticket->created_at->diffForHumans() }}
                                        </p>

                                        @if($ticket->admin_reply)
                                            <div class="mt-5 rounded-2xl bg-blue-50 border border-blue-200 p-5">
                                                <p class="text-xs font-bold uppercase tracking-wide text-blue-700">
                                                    Admin Reply
                                                </p>

                                                <p class="mt-2 text-sm text-blue-800">
                                                    {{ $ticket->admin_reply }}
                                                </p>

                                                @if($ticket->replied_at)
                                                    <p class="mt-3 text-xs text-blue-600">
                                                        Replied {{ \Carbon\Carbon::parse($ticket->replied_at)->diffForHumans() }}
                                                    </p>
                                                @endif
                                            </div>
                                        @else
                                            <div class="mt-5 rounded-2xl bg-slate-50 border border-slate-200 p-5">
                                                <p class="text-sm text-slate-500">
                                                    Admin has not replied yet. Please wait for an update.
                                                </p>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="text-sm text-slate-500 whitespace-nowrap">
                                        {{ $ticket->created_at->format('d M Y') }}
                                    </div>

                                </div>
                            </div>
                        @empty
                            <div class="px-6 py-12 text-center">
                                <p class="font-semibold text-slate-700">No support tickets submitted yet</p>
                                <p class="text-sm text-slate-500 mt-1">
                                    Submit your first ticket using the form above.
                                </p>
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>
        </main>
    </div>
</x-app-layout>