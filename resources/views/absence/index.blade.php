@extends('layouts.app')

@section('title', 'Absence List')

@section('content')
<div class="max-w-7xl mx-auto" data-aos="fade-up">
    <!-- Header Section -->
    <div class="mb-8">
        <div class="flex items-center space-x-3 mb-2">
            <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
                <i class="fas fa-calendar-alt text-white text-sm"></i>
            </div>
            <h1 class="text-3xl font-bold text-gray-900">Absence Management</h1>
        </div>
        <p class="text-gray-600 ml-11">Manage your leave requests and track approval status</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8" data-aos="fade-up" data-aos-delay="100">
        @php
            $userAbsences = \App\Models\Absence::where('user_id', auth()->id());
            $totalAbsences = $userAbsences->count();
            $pendingAbsences = $userAbsences->where('status', 'pending')->count();
            $approvedAbsences = $userAbsences->where('status', 'approved')->count();
            $rejectedAbsences = $userAbsences->where('status', 'rejected')->count();
        @endphp

        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Requests</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalAbsences }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-calendar-check text-blue-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Pending</p>
                    <p class="text-2xl font-bold text-yellow-600">{{ $pendingAbsences }}</p>
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
                    <p class="text-2xl font-bold text-green-600">{{ $approvedAbsences }}</p>
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
                    <p class="text-2xl font-bold text-red-600">{{ $rejectedAbsences }}</p>
                </div>
                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-times-circle text-red-600"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-8" data-aos="fade-up" data-aos-delay="200">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('absence.create') }}" class="bg-gradient-to-r from-blue-600 to-blue-700 text-white px-6 py-3 rounded-lg font-medium hover:from-blue-700 hover:to-blue-800 transition-all duration-300 inline-flex items-center gap-2 shadow-sm hover:shadow-md transform hover:-translate-y-0.5">
                    <i class="fas fa-plus"></i>
                    Submit New Absence
                </a>
                @if(auth()->user()->role === 'admin')
                <a href="{{ route('absence.approval') }}" class="bg-gradient-to-r from-green-600 to-green-700 text-white px-6 py-3 rounded-lg font-medium hover:from-green-700 hover:to-green-800 transition-all duration-300 inline-flex items-center gap-2 shadow-sm hover:shadow-md transform hover:-translate-y-0.5">
                    <i class="fas fa-user-check"></i>
                    Absence Approval
                </a>
                @endif
            </div>

            <!-- Filter Options -->
            <div class="flex items-center gap-3">
                <select class="border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">All Status</option>
                    <option value="pending">Pending</option>
                    <option value="approved">Approved</option>
                    <option value="rejected">Rejected</option>
                </select>
                <button class="bg-gray-100 hover:bg-gray-200 px-4 py-2 rounded-lg text-gray-700 transition-colors duration-200">
                    <i class="fas fa-filter"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 text-green-800 px-6 py-4 rounded-xl mb-6 flex items-center gap-3 shadow-sm" data-aos="fade-down">
            <div class="w-8 h-8 bg-green-200 rounded-full flex items-center justify-center">
                <i class="fas fa-check text-green-600 text-sm"></i>
            </div>
            <div>
                <p class="font-medium">Success!</p>
                <p class="text-sm">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    <!-- Absence Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden" data-aos="fade-up" data-aos-delay="300">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-900">Your Absence Requests</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Category</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Duration</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Description</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Details</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-50">
                    @php
                        $absences = \App\Models\Absence::where('user_id', auth()->id())->orderBy('created_at', 'desc')->get();
                    @endphp
                    @forelse($absences as $absence)
                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-calendar-day text-blue-600 text-sm"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">{{ $absence->leave_category }}</p>
                                    <p class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($absence->created_at)->format('d M Y') }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="space-y-1">
                                <p class="text-sm font-medium text-gray-900">{{ \Carbon\Carbon::parse($absence->start_date)->format('d M Y') }}</p>
                                <p class="text-xs text-gray-500">to {{ \Carbon\Carbon::parse($absence->end_date)->format('d M Y') }}</p>
                                @php
                                    $days = \Carbon\Carbon::parse($absence->start_date)->diffInDays(\Carbon\Carbon::parse($absence->end_date)) + 1;
                                @endphp
                                <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-gray-100 text-gray-800">
                                    {{ $days }} day{{ $days > 1 ? 's' : '' }}
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm text-gray-900 max-w-xs truncate" title="{{ $absence->description }}">{{ $absence->description }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <div class="space-y-2">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-laptop text-xs {{ $absence->has_laptop ? 'text-green-500' : 'text-red-500' }}"></i>
                                    <span class="text-xs {{ $absence->has_laptop ? 'text-green-700' : 'text-red-700' }}">
                                        Laptop: {{ $absence->has_laptop ? 'Yes' : 'No' }}
                                    </span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-phone text-xs {{ $absence->can_contact ? 'text-green-500' : 'text-red-500' }}"></i>
                                    <span class="text-xs {{ $absence->can_contact ? 'text-green-700' : 'text-red-700' }}">
                                        Contact: {{ $absence->can_contact ? 'Yes' : 'No' }}
                                    </span>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @if($absence->status === 'pending')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 border border-yellow-200">
                                    <div class="w-2 h-2 bg-yellow-400 rounded-full mr-2 animate-pulse"></div>
                                    Pending
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
                            <div class="flex items-center gap-2">
                                <button class="text-blue-600 hover:text-blue-800 text-sm p-2 hover:bg-blue-50 rounded-lg transition-colors duration-200" title="View Details">
                                    <i class="fas fa-eye"></i>
                                </button>
                                @if($absence->status === 'pending')
                                <button class="text-gray-600 hover:text-gray-800 text-sm p-2 hover:bg-gray-50 rounded-lg transition-colors duration-200" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="text-red-600 hover:text-red-800 text-sm p-2 hover:bg-red-50 rounded-lg transition-colors duration-200" title="Cancel">
                                    <i class="fas fa-trash"></i>
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center justify-center space-y-4">
                                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-calendar-alt text-gray-400 text-2xl"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900 mb-2">No absence requests found</h3>
                                    <p class="text-gray-500 mb-4">You haven't submitted any absence requests yet.</p>
                                    <a href="{{ route('absence.create') }}" class="bg-gradient-to-r from-blue-600 to-blue-700 text-white px-6 py-2 rounded-lg font-medium hover:from-blue-700 hover:to-blue-800 transition-all duration-300 inline-flex items-center gap-2">
                                        <i class="fas fa-plus"></i>
                                        Submit Your First Request
                                    </a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

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
@endsection
