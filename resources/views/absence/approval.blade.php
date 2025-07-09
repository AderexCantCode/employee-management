@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4">
        <!-- Header Section -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Absence Approval</h1>
            <p class="mt-1 text-gray-600 text-sm">{{ $absences->count() }} requests to review</p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="bg-white rounded border p-4 text-center">
                <div class="text-xs text-gray-500">Pending</div>
                <div class="text-xl font-semibold text-gray-900">{{ $absences->where('status', 'pending')->count() }}</div>
            </div>
            <div class="bg-white rounded border p-4 text-center">
                <div class="text-xs text-gray-500">Approved</div>
                <div class="text-xl font-semibold text-gray-900">{{ $absences->where('status', 'approved')->count() }}</div>
            </div>
            <div class="bg-white rounded border p-4 text-center">
                <div class="text-xs text-gray-500">Rejected</div>
                <div class="text-xl font-semibold text-gray-900">{{ $absences->where('status', 'rejected')->count() }}</div>
            </div>
        </div>

        <!-- Table Section -->
        <div class="bg-white rounded border overflow-hidden">
            <div class="px-4 py-2 border-b">
                <h3 class="text-base font-medium text-gray-900">Absence Requests</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left font-medium text-gray-600">Employee</th>
                            <th class="px-4 py-2 text-left font-medium text-gray-600">Category</th>
                            <th class="px-4 py-2 text-left font-medium text-gray-600">Period</th>
                            <th class="px-4 py-2 text-left font-medium text-gray-600">Description</th>
                            <th class="px-4 py-2 text-left font-medium text-gray-600">Status</th>
                            <th class="px-4 py-2 text-left font-medium text-gray-600">Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y">
                        @foreach($absences as $absence)
                        <tr>
                            <td class="px-4 py-2">
                                <div>
                                    <div class="font-medium text-gray-900">{{ $absence->user->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $absence->user->email ?? 'Employee' }}</div>
                                </div>
                            </td>
                            <td class="px-4 py-2">
                                <span class="px-2 py-1 rounded text-xs
                                    @if($absence->leave_category == 'sick') bg-red-100 text-red-700
                                    @elseif($absence->leave_category == 'annual') bg-blue-100 text-blue-700
                                    @elseif($absence->leave_category == 'personal') bg-purple-100 text-purple-700
                                    @else bg-gray-100 text-gray-700
                                    @endif">
                                    {{ ucfirst($absence->leave_category) }}
                                </span>
                            </td>
                            <td class="px-4 py-2">
                                <div>
                                    <div>
                                        {{ $absence->start_date instanceof \Carbon\Carbon ? $absence->start_date->format('M d, Y') : \Carbon\Carbon::parse($absence->start_date)->format('M d, Y') }}
                                        -
                                        {{ $absence->end_date instanceof \Carbon\Carbon ? $absence->end_date->format('M d, Y') : \Carbon\Carbon::parse($absence->end_date)->format('M d, Y') }}
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-2">
                                <div class="flex items-center space-x-2">
                                    <span title="{{ $absence->description }}">
                                        {{ $absence->description ?: 'No description' }}
                                    </span>
                                    <a href="{{ route('absence.show', $absence->id) }}" class="text-blue-500 hover:text-blue-700" title="View details">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </div>
                            </td>
                            <td class="px-4 py-2">
                                @if($absence->status == 'pending')
                                    <span class="px-2 py-1 rounded bg-yellow-100 text-yellow-700 text-xs">Pending</span>
                                @elseif($absence->status == 'approved')
                                    <span class="px-2 py-1 rounded bg-green-100 text-green-700 text-xs">Approved</span>
                                @elseif($absence->status == 'rejected')
                                    <span class="px-2 py-1 rounded bg-red-100 text-red-700 text-xs">Rejected</span>
                                @endif
                            </td>
                            <td class="px-4 py-2">
                                @if($absence->status == 'pending')
                                    <div class="flex space-x-1">
                                        <form action="{{ route('absence.approve', $absence->id) }}" method="POST">
                                            @csrf
                                            <button type="submit"
                                                class="px-2 py-1 rounded bg-green-500 text-white text-xs hover:bg-green-600"
                                                onclick="return confirm('Approve this request?')">
                                                Approve
                                            </button>
                                        </form>
                                        <form action="{{ route('absence.reject', $absence->id) }}" method="POST">
                                            @csrf
                                            <button type="submit"
                                                class="px-2 py-1 rounded bg-red-500 text-white text-xs hover:bg-red-600"
                                                onclick="return confirm('Reject this request?')">
                                                Reject
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <span class="text-gray-400 text-xs italic">No action</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if($absences->isEmpty())
            <div class="text-center py-8">
                <div class="mb-2 text-2xl text-gray-400">—</div>
                <div class="text-gray-700">No absence requests</div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Success/Error Messages -->
@if(session('success'))
<div class="fixed bottom-4 right-4 max-w-sm">
    <div class="bg-green-500 text-white px-4 py-2 rounded shadow">
        <span>{{ session('success') }}</span>
        <button onclick="this.parentElement.parentElement.remove()" class="ml-2 text-green-200 hover:text-white">x</button>
    </div>
</div>
@endif

@if(session('error'))
<div class="fixed bottom-4 right-4 max-w-sm">
    <div class="bg-red-500 text-white px-4 py-2 rounded shadow">
        <span>{{ session('error') }}</span>
        <button onclick="this.parentElement.parentElement.remove()" class="ml-2 text-red-200 hover:text-white">x</button>
    </div>
</div>
@endif

<script>
// Auto hide success/error messages after 5 seconds
setTimeout(function() {
    const messages = document.querySelectorAll('.fixed.bottom-4.right-4');
    messages.forEach(function(message) {
        message.style.transition = 'opacity 0.5s ease-out';
        message.style.opacity = '0';
        setTimeout(function() {
            message.remove();
        }, 500);
    });
}, 5000);
</script>
@endsection
