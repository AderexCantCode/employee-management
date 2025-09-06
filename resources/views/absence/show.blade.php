@extends('layouts.app')

@section('title', 'Absence Details')

@section('content')
<div class="min-h-screen py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8" data-aos="fade-down">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Absence Details</h1>
                    <p class="text-gray-600">View detailed information about this absence request</p>
                </div>
                <a href="{{ url()->previous() }}"
                   class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 shadow-sm">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Details Card -->
            <div class="lg:col-span-2" data-aos="fade-up">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <!-- Card Header -->
                    <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-4">
                        <h2 class="text-xl font-semibold text-white flex items-center">
                            <i class="fas fa-calendar-alt mr-3"></i>
                            Absence Information
                        </h2>
                    </div>

                    <!-- Card Content -->
                    <div class="p-6">
                        <div class="space-y-6">
                            <!-- Employee Info -->
                            <div class="flex items-start space-x-4 p-4 bg-gray-50 rounded-lg">
                                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                                    @if($absence->user->avatar)
                                        <img src="{{ asset($absence->user->avatar) }}" alt="Avatar" class="w-12 h-12 rounded-full object-cover">
                                    @else
                                        <div class="w-12 h-12 rounded-full flex items-center justify-center bg-gradient-to-br from-blue-500 to-blue-600">
                                            <span class="text-white font-bold text-lg">{{ strtoupper(substr($absence->user->name, 0, 1)) }}</span>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-semibold text-gray-900">{{ $absence->user->name }}</h3>
                                    <p class="text-sm text-gray-600">{{ $absence->user->email }}</p>
                                    <p class="text-xs text-gray-500 mt-1">{{ ucfirst($absence->user->role) }}</p>
                                </div>
                            </div>

                            <!-- Details Grid -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-500 mb-1">Leave Category</label>
                                        <div class="flex items-center space-x-2">
                                            <i class="fas fa-tag text-blue-500"></i>
                                            <span class="text-gray-900 font-medium capitalize">{{ $absence->leave_category }}</span>
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-500 mb-1">Duration</label>
                                        <div class="flex items-center space-x-2">
                                            <i class="fas fa-calendar-check text-green-500"></i>
                                            <span class="text-gray-900 font-medium">
                                                {{ $absence->start_date->diffInDays($absence->end_date) + 1 }} day(s)
                                            </span>
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-500 mb-1">Has Laptop</label>
                                        <div class="flex items-center space-x-2">
                                            @if($absence->has_laptop)
                                                <i class="fas fa-laptop text-blue-500"></i>
                                                <span class="text-green-600 font-medium">Yes</span>
                                            @else
                                                <i class="fas fa-laptop text-gray-400"></i>
                                                <span class="text-red-600 font-medium">No</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-500 mb-1">Period</label>
                                        <div class="bg-blue-50 rounded-lg p-3 border border-blue-200">
                                            <div class="flex items-center justify-between text-sm">
                                                <div class="text-center">
                                                    <div class="text-gray-600">From</div>
                                                    <div class="font-semibold text-blue-600">{{ $absence->start_date->format('M d, Y') }}</div>
                                                </div>
                                                <div class="text-blue-400">
                                                    <i class="fas fa-arrow-right"></i>
                                                </div>
                                                <div class="text-center">
                                                    <div class="text-gray-600">To</div>
                                                    <div class="font-semibold text-blue-600">{{ $absence->end_date->format('M d, Y') }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-500 mb-1">Can Contact</label>
                                        <div class="flex items-center space-x-2">
                                            @if($absence->can_contact)
                                                <i class="fas fa-phone text-green-500"></i>
                                                <span class="text-green-600 font-medium">Available</span>
                                            @else
                                                <i class="fas fa-phone-slash text-gray-400"></i>
                                                <span class="text-red-600 font-medium">Not Available</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-500 mb-1">Submitted</label>
                                        <div class="flex items-center space-x-2">
                                            <i class="fas fa-clock text-purple-500"></i>
                                            <span class="text-gray-900 font-medium">{{ $absence->created_at->format('M d, Y H:i') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Description -->
                            @if($absence->description)
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-2">Description</label>
                                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                    <p class="text-gray-800 leading-relaxed">{{ $absence->description }}</p>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Status & Actions Sidebar -->
            <div class="space-y-6" data-aos="fade-up" data-aos-delay="200">
                <!-- Status Card -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <i class="fas fa-info-circle mr-2 text-blue-500"></i>
                            Status
                        </h3>

                        <div class="text-center">
                            @if($absence->status == 'pending')
                                <div class="inline-flex items-center px-4 py-2 rounded-full bg-yellow-100 text-yellow-800 font-medium mb-3">
                                    <i class="fas fa-clock mr-2"></i>
                                    Pending Review
                                </div>
                                <p class="text-sm text-gray-600">This request is awaiting approval from management.</p>
                            @elseif($absence->status == 'approved')
                                <div class="inline-flex items-center px-4 py-2 rounded-full bg-green-100 text-green-800 font-medium mb-3">
                                    <i class="fas fa-check-circle mr-2"></i>
                                    Approved
                                </div>
                                <p class="text-sm text-gray-600">This absence request has been approved.</p>
                            @elseif($absence->status == 'rejected')
                                <div class="inline-flex items-center px-4 py-2 rounded-full bg-red-100 text-red-800 font-medium mb-3">
                                    <i class="fas fa-times-circle mr-2"></i>
                                    Rejected
                                </div>
                                <p class="text-sm text-gray-600">This absence request has been rejected.</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <i class="fas fa-chart-bar mr-2 text-blue-500"></i>
                            Quick Info
                        </h3>

                        <div class="space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">Total Days</span>
                                <span class="font-semibold text-gray-900">{{ $absence->start_date->diffInDays($absence->end_date) + 1 }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">Category</span>
                                <span class="font-semibold text-gray-900 capitalize">{{ $absence->leave_category }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">Work Days</span>
                                <span class="font-semibold text-gray-900">
                                    {{ $absence->start_date->diffInWeekdays($absence->end_date) + ($absence->start_date->isWeekday() ? 1 : 0) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons (if needed) -->
                @if(auth()->user()->role !== 'employee' && $absence->status == 'pending')
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <i class="fas fa-cogs mr-2 text-blue-500"></i>
                            Actions
                        </h3>

                        <div class="space-y-3">
                            <form method="POST" action="{{ route('administration.absence.approve', $absence) }}" class="w-full">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                        class="w-full bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center">
                                    <i class="fas fa-check mr-2"></i>
                                    Approve
                                </button>
                            </form>

                            <form method="POST" action="{{ route('administration.absence.reject', $absence) }}" class="w-full">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                        class="w-full bg-red-500 hover:bg-red-600 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center"
                                        onclick="return confirm('Are you sure you want to reject this absence request?')">
                                    <i class="fas fa-times mr-2"></i>
                                    Reject
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
