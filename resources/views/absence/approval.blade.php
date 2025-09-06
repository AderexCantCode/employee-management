@extends('layouts.app')

@section('title', 'Absence Approval')

@section('content')
<div class="max-w-7xl mx-auto" data-aos="fade-up">
    <!-- Header Section -->
    <div class="mb-8">
        <div class="flex items-center space-x-3 mb-2">
            <div class="w-8 h-8 bg-gradient-to-r from-green-500 to-emerald-600 rounded-lg flex items-center justify-center">
                <i class="fas fa-user-check text-white text-sm"></i>
            </div>
            <h1 class="text-3xl font-bold text-gray-900">Absence Approval</h1>
        </div>
        <p class="text-gray-600 ml-11">Review and manage employee absence requests</p>
    </div>

    <!-- Quick Actions Bar -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-8" data-aos="fade-up" data-aos-delay="100">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="text-sm text-gray-600">
                    <span class="font-medium">{{ $absences->count() }}</span> total requests to review
                </div>
                <div class="text-sm text-gray-600">
                    <span class="font-medium text-yellow-600">{{ $absences->where('status', 'pending')->count() }}</span> pending approval
                </div>
            </div>

            <!-- Filter Options -->
            <div class="flex items-center gap-3">
                <select class="border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    <option value="">All Status</option>
                    <option value="pending">Pending</option>
                    <option value="approved">Approved</option>
                    <option value="rejected">Rejected</option>
                </select>
                <select class="border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    <option value="">All Categories</option>
                    <option value="sick">Sick Leave</option>
                    <option value="annual">Annual Leave</option>
                    <option value="personal">Personal Leave</option>
                </select>
                <button class="bg-gray-100 hover:bg-gray-200 px-4 py-2 rounded-lg text-gray-700 transition-colors duration-200">
                    <i class="fas fa-filter"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8" data-aos="fade-up" data-aos-delay="200">
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Requests</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $absences->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-clipboard-list text-blue-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Pending</p>
                    <p class="text-2xl font-bold text-yellow-600">{{ $absences->where('status', 'pending')->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-clock text-yellow-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Approved</p>
                    <p class="text-2xl font-bold text-green-600">{{ $absences->where('status', 'approved')->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-check-circle text-green-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Rejected</p>
                    <p class="text-2xl font-bold text-red-600">{{ $absences->where('status', 'rejected')->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-times-circle text-red-600"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Absence Requests Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden" data-aos="fade-up" data-aos-delay="300">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-900">Employee Absence Requests</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Employee</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Leave Details</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Duration</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Description</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-50">
                    @forelse($absences as $absence)
                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-blue-600 rounded-full flex items-center justify-center">
                                    <span class="text-white font-semibold text-sm">{{ strtoupper(substr($absence->user->name, 0, 1)) }}</span>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">{{ $absence->user->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $absence->user->email ?? 'Employee' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="space-y-1">
                                @php
                                    $categoryColors = [
                                        'sick' => 'bg-red-100 text-red-700 border-red-200',
                                        'annual' => 'bg-blue-100 text-blue-700 border-blue-200',
                                        'personal' => 'bg-purple-100 text-purple-700 border-purple-200',
                                    ];
                                    $colorClass = $categoryColors[$absence->leave_category] ?? 'bg-gray-100 text-gray-700 border-gray-200';
                                @endphp
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium border {{ $colorClass }}">
                                    <i class="fas fa-circle text-xs mr-2"></i>
                                    {{ ucfirst($absence->leave_category) }} Leave
                                </span>
                                <p class="text-xs text-gray-500">
                                    Submitted {{ \Carbon\Carbon::parse($absence->created_at)->diffForHumans() }}
                                </p>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="space-y-1">
                                <p class="text-sm font-medium text-gray-900">
                                    {{ $absence->start_date instanceof \Carbon\Carbon ? $absence->start_date->format('d M Y') : \Carbon\Carbon::parse($absence->start_date)->format('d M Y') }}
                                </p>
                                <p class="text-xs text-gray-500">
                                    to {{ $absence->end_date instanceof \Carbon\Carbon ? $absence->end_date->format('d M Y') : \Carbon\Carbon::parse($absence->end_date)->format('d M Y') }}
                                </p>
                                @php
                                    $days = \Carbon\Carbon::parse($absence->start_date)->diffInDays(\Carbon\Carbon::parse($absence->end_date)) + 1;
                                @endphp
                                <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-gray-100 text-gray-800">
                                    {{ $days }} day{{ $days > 1 ? 's' : '' }}
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-2">
                                <p class="text-sm text-gray-900 max-w-xs truncate" title="{{ $absence->description }}">
                                    {{ $absence->description ?: 'No description provided' }}
                                </p>
                                <a href="{{ route('absence.show', $absence->id) }}"
                                   class="text-blue-600 hover:text-blue-800 hover:bg-blue-50 p-1 rounded transition-colors duration-200"
                                   title="View full details">
                                    <i class="fas fa-eye text-xs"></i>
                                </a>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @if($absence->status === 'pending')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 border border-yellow-200">
                                    <div class="w-2 h-2 bg-yellow-400 rounded-full mr-2 animate-pulse"></div>
                                    Pending Review
                                </span>
                            @elseif($absence->status === 'approved')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-200">
                                    <i class="fas fa-check text-green-600 text-xs mr-2"></i>
                                    Approved
                                </span>
                            @elseif($absence->status === 'rejected')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 border border-red-200">
                                    <i class="fas fa-times text-red-600 text-xs mr-2"></i>
                                    Rejected
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($absence->status === 'pending')
                                <div class="flex space-x-2">
                                    <form action="{{ route('absence.approve', $absence->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit"
                                            class="bg-gradient-to-r from-green-600 to-green-700 text-white px-4 py-2 rounded-lg text-xs font-medium hover:from-green-700 hover:to-green-800 transition-all duration-300 transform hover:scale-105 shadow-sm"
                                            onclick="return confirm('Are you sure you want to approve this absence request?')">
                                            <i class="fas fa-check mr-1"></i>
                                            Approve
                                        </button>
                                    </form>
                                    <form action="{{ route('absence.reject', $absence->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit"
                                            class="bg-gradient-to-r from-red-600 to-red-700 text-white px-4 py-2 rounded-lg text-xs font-medium hover:from-red-700 hover:to-red-800 transition-all duration-300 transform hover:scale-105 shadow-sm"
                                            onclick="return confirm('Are you sure you want to reject this absence request?')">
                                            <i class="fas fa-times mr-1"></i>
                                            Reject
                                        </button>
                                    </form>
                                </div>
                            @else
                                <div class="flex items-center space-x-2">
                                    <span class="text-gray-400 text-xs italic">Already processed</span>
                                    <button class="text-gray-400 hover:text-gray-600 text-xs p-1 hover:bg-gray-50 rounded transition-colors duration-200" title="View details">
                                        <i class="fas fa-info-circle"></i>
                                    </button>
                                </div>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center justify-center space-y-4">
                                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-inbox text-gray-400 text-2xl"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900 mb-2">No absence requests found</h3>
                                    <p class="text-gray-500">There are currently no absence requests to review.</p>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Bulk Actions (if needed) -->
    @if($absences->where('status', 'pending')->count() > 0)
    <div class="mt-6 bg-white rounded-xl shadow-sm border border-gray-100 p-6" data-aos="fade-up" data-aos-delay="400">
        <div class="flex items-center justify-between">
            <div>
                <h4 class="font-medium text-gray-900">Bulk Actions</h4>
                <p class="text-sm text-gray-500">Process multiple requests at once</p>
            </div>
            <div class="flex space-x-3">
                <button class="bg-gradient-to-r from-green-600 to-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium hover:from-green-700 hover:to-green-800 transition-all duration-300 inline-flex items-center gap-2">
                    <i class="fas fa-check-double"></i>
                    Approve Selected
                </button>
                <button class="bg-gradient-to-r from-red-600 to-red-700 text-white px-4 py-2 rounded-lg text-sm font-medium hover:from-red-700 hover:to-red-800 transition-all duration-300 inline-flex items-center gap-2">
                    <i class="fas fa-times-circle"></i>
                    Reject Selected
                </button>
            </div>
        </div>
    </div>
    @endif
</div>

<!-- Enhanced Success/Error Messages -->
@if(session('success'))
<div class="fixed bottom-6 right-6 max-w-sm z-50" data-aos="fade-left">
    <div class="bg-gradient-to-r from-green-500 to-green-600 text-white px-6 py-4 rounded-xl shadow-lg border border-green-400">
        <div class="flex items-center space-x-3">
            <div class="w-8 h-8 bg-green-400 rounded-full flex items-center justify-center">
                <i class="fas fa-check text-green-800 text-sm"></i>
            </div>
            <div class="flex-1">
                <p class="font-medium">Success!</p>
                <p class="text-sm text-green-100">{{ session('success') }}</p>
            </div>
            <button onclick="this.parentElement.parentElement.parentElement.remove()"
                    class="text-green-200 hover:text-white transition-colors duration-200">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
</div>
@endif

@if(session('error'))
<div class="fixed bottom-6 right-6 max-w-sm z-50" data-aos="fade-left">
    <div class="bg-gradient-to-r from-red-500 to-red-600 text-white px-6 py-4 rounded-xl shadow-lg border border-red-400">
        <div class="flex items-center space-x-3">
            <div class="w-8 h-8 bg-red-400 rounded-full flex items-center justify-center">
                <i class="fas fa-exclamation-triangle text-red-800 text-sm"></i>
            </div>
            <div class="flex-1">
                <p class="font-medium">Error!</p>
                <p class="text-sm text-red-100">{{ session('error') }}</p>
            </div>
            <button onclick="this.parentElement.parentElement.parentElement.remove()"
                    class="text-red-200 hover:text-white transition-colors duration-200">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
</div>
@endif

<style>
@keyframes pulse {
    0%, 100% {
        opacity: 1;
    }
    50% {
        opacity: .5;
    }
}

.animate-pulse {
    animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}
</style>

<script>
// Auto hide success/error messages after 6 seconds
setTimeout(function() {
    const messages = document.querySelectorAll('.fixed.bottom-6.right-6');
    messages.forEach(function(message) {
        message.style.transition = 'opacity 0.5s ease-out, transform 0.5s ease-out';
        message.style.opacity = '0';
        message.style.transform = 'translateX(100%)';
        setTimeout(function() {
            message.remove();
        }, 500);
    });
}, 6000);

// Add confirmation dialogs with better styling
document.addEventListener('DOMContentLoaded', function() {
    // You can add more interactive features here if needed
    const actionButtons = document.querySelectorAll('button[onclick*="confirm"]');
    actionButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            const confirmed = window.confirm(this.getAttribute('onclick').replace('return confirm(', '').replace(')', ''));
            if (!confirmed) {
                e.preventDefault();
                this.disabled = false;
                return false;
            }
            // No loading animation, just proceed
        });
    });
});
</script>
@endsection
