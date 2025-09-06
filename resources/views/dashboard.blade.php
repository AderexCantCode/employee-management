@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="p-6 bg-gray-50 min-h-screen">
    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Dashboard</h1>
            <p class="text-gray-600">Welcome back, {{ auth()->user()->name }}!</p>
        </div>
        <div class="text-right">
            <div class="text-sm text-gray-500">{{ now()->format('l, F j, Y') }}</div>
            <div class="text-xl font-bold text-gray-900">{{ now()->format('H:i') }}</div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 xl:grid-cols-12 gap-6">

        <!-- Left Section: Status Categories -->
        <div class="xl:col-span-7">
            <!-- Status Tabs -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-6">
                <div class="flex flex-wrap gap-2 p-4">
                    <button class="tab-button px-6 py-3 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->input('tab', 'ready') == 'ready' ? 'bg-gray-900 text-white shadow-lg' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}" data-tab="ready">
                        <span class="inline-block w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                        Ready
                    </button>
                    <button class="tab-button px-6 py-3 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->input('tab') == 'standby' ? 'bg-gray-900 text-white shadow-lg' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}" data-tab="standby">
                        <span class="inline-block w-2 h-2 bg-orange-500 rounded-full mr-2"></span>
                        Stand by
                    </button>
                    <button class="tab-button px-6 py-3 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->input('tab') == 'not-ready' ? 'bg-gray-900 text-white shadow-lg' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}" data-tab="not-ready">
                        <span class="inline-block w-2 h-2 bg-red-500 rounded-full mr-2"></span>
                        Not ready
                    </button>
                    <button class="tab-button px-6 py-3 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->input('tab') == 'complete' ? 'bg-gray-900 text-white shadow-lg' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}" data-tab="complete">
                        <span class="inline-block w-2 h-2 bg-blue-500 rounded-full mr-2"></span>
                        Complete
                    </button>
                    <button class="tab-button px-6 py-3 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->input('tab') == 'absent' ? 'bg-gray-900 text-white shadow-lg' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}" data-tab="absent">
                        <span class="inline-block w-2 h-2 bg-gray-400 rounded-full mr-2"></span>
                        Absent
                    </button>
                </div>
            </div>

            <!-- User Cards Grid -->
            <div class="space-y-6">
                <!-- Ready Users -->
                <div id="ready" class="tab-content">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($readyUsers as $user)
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-all duration-300 hover:scale-105">
                            <!-- Header with avatar and name -->
                            <div class="p-4 bg-gradient-to-r from-green-50 to-emerald-50 border-b border-green-100">
                                <div class="flex items-center space-x-3">
                                    <div class="w-12 h-12 rounded-full overflow-hidden border-2 border-green-200">
                                        @if($user->avatar)
                                            <img src="{{ asset($user->avatar) }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full bg-gradient-to-br from-blue-500 to-blue-700 flex items-center justify-center">
                                                <span class="text-white font-bold text-lg">{{ substr($user->name, 0, 1) }}</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="font-semibold text-gray-900 text-sm">{{ $user->name }}</h3>
                                        <p class="text-xs text-gray-600">{{ ucfirst($user->role) }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="p-4">
                                <div class="text-xs text-gray-700 mb-4 leading-relaxed">
                                    @php
                                        $assignedProjects = $user->projects ?? collect();
                                        $assignedTasks = $user->tasks ?? collect();
                                    @endphp
                                    @if($assignedProjects->isNotEmpty())
                                        Working on
                                        @foreach($assignedProjects as $project)
                                            <span class="font-semibold text-green-700">{{ $project->name }}</span>@if(!$loop->last), @endif
                                        @endforeach
                                    @endif
                                    @if($assignedTasks->isNotEmpty())
                                        @if($assignedProjects->isNotEmpty())<br>@endif
                                        Tasks:
                                        @foreach($assignedTasks as $task)
                                            <span class="font-semibold text-green-700">{{ $task->title }}</span>@if(!$loop->last), @endif
                                        @endforeach
                                    @endif
                                    @if($assignedProjects->isEmpty() && $assignedTasks->isEmpty())
                                        Available for new assignments
                                    @endif
                                </div>

                                <!-- Status badges -->
                                <div class="flex items-center justify-between">
                                    <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-medium">Ready</span>
                                    <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-medium">Active</span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Standby Users -->
                <div id="standby" class="tab-content hidden">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($standbyUsers as $user)
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-all duration-300 hover:scale-105">
                            <!-- Header with avatar and name -->
                            <div class="p-4 bg-gradient-to-r from-orange-50 to-amber-50 border-b border-orange-100">
                                <div class="flex items-center space-x-3">
                                    <div class="w-12 h-12 rounded-full overflow-hidden border-2 border-orange-200">
                                        @if($user->avatar)
                                            <img src="{{ asset($user->avatar) }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full bg-gradient-to-br from-blue-500 to-blue-700 flex items-center justify-center">
                                                <span class="text-white font-bold text-lg">{{ substr($user->name, 0, 1) }}</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="font-semibold text-gray-900 text-sm">{{ $user->name }}</h3>
                                        <p class="text-xs text-gray-600">{{ ucfirst($user->role) }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="p-4">
                                <div class="text-xs text-gray-700 mb-4 leading-relaxed">
                                    Working on Project R: Creating a dataset of user accounts
                                </div>

                                <!-- Status badges -->
                                <div class="flex items-center justify-between">
                                    <span class="px-3 py-1 bg-orange-100 text-orange-700 rounded-full text-xs font-medium">Review</span>
                                    <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-medium">High</span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Not Ready Users -->
                <div id="not-ready" class="tab-content hidden">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($notReadyUsers as $user)
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-all duration-300 hover:scale-105">
                            <!-- Header with avatar and name -->
                            <div class="p-4 bg-gradient-to-r from-red-50 to-pink-50 border-b border-red-100">
                                <div class="flex items-center space-x-3">
                                    <div class="w-12 h-12 rounded-full overflow-hidden border-2 border-red-200">
                                        @if($user->avatar)
                                            <img src="{{ asset($user->avatar) }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full bg-gradient-to-br from-blue-500 to-blue-700 flex items-center justify-center">
                                                <span class="text-white font-bold text-lg">{{ substr($user->name, 0, 1) }}</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="font-semibold text-gray-900 text-sm">{{ $user->name }}</h3>
                                        <p class="text-xs text-gray-600">{{ ucfirst($user->role) }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="p-4">
                                <div class="text-xs text-gray-700 mb-4 leading-relaxed">
                                    Working on Web Codelab: Try to handle exceptions in Project A there's some bug when click account
                                </div>

                                <!-- Status badges -->
                                <div class="flex items-center justify-between">
                                    <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-medium">Blocked</span>
                                    <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-medium">High</span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Complete Tasks -->
                <div id="complete" class="tab-content hidden">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($completeTasks as $task)
                                                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-all duration-300 hover:scale-105">
                                                    <!-- Header with avatars and names -->
                                                    <div class="p-4 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-blue-100">
                                                        <div class="flex items-center space-x-3">
                                                            @if($task->assignedUsers->count())
                                                                @foreach($task->assignedUsers as $user)
                                                                    @if($user->avatar)
                                                                        <img src="{{ asset($user->avatar) }}" alt="{{ $user->name ?? 'User' }}" class="w-full h-full object-cover inline-block mr-1">
                                                                    @else
                                                                        <span class="text-white font-bold text-lg inline-block mr-1">{{ substr($user->name ?? 'T', 0, 1) }}</span>
                                                                    @endif
                                                                @endforeach
                                                            @else
                                                                <span class="text-white font-bold text-lg">T</span>
                                                            @endif
                                                        </div>
                                                        <h3 class="font-semibold text-gray-900 text-sm">{{ $task->assignedUsers->pluck('name')->join(', ') }}</h3>
                                                        <p class="text-xs text-gray-600">{{ $task->assignedUsers->pluck('role')->filter()->join(', ') }}</p>
                            </div>

                            <!-- Content -->
                            <div class="p-4">
                                <div class="text-xs text-gray-700 mb-4 leading-relaxed">
                                    {{ $task->title }}: {{ $task->description }}
                                </div>

                                <!-- Status badges -->
                                <div class="flex items-center justify-between">
                                    <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-medium">Complete</span>
                                    <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-medium">Low</span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Absent Users -->
                <div id="absent" class="tab-content hidden">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($absentUsers as $user)
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-all duration-300 hover:scale-105">
                            <!-- Header with avatar and name -->
                            <div class="p-4 bg-gradient-to-r from-gray-50 to-slate-50 border-b border-gray-100">
                                <div class="flex items-center space-x-3">
                                    <div class="w-12 h-12 rounded-full overflow-hidden border-2 border-gray-200">
                                        @if($user->avatar)
                                            <img src="{{ asset($user->avatar) }}" alt="{{ $user->name }}" class="w-full h-full object-cover grayscale">
                                        @else
                                            <div class="w-full h-full bg-gradient-to-br from-blue-500 to-blue-700 flex items-center justify-center">
                                                <span class="text-white font-bold text-lg">{{ substr($user->name, 0, 1) }}</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="font-semibold text-gray-900 text-sm">{{ $user->name }}</h3>
                                        <p class="text-xs text-gray-600">{{ ucfirst($user->role) }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="p-4">
                                <div class="text-xs text-gray-700 mb-4 leading-relaxed">
                                    Currently absent from work
                                </div>

                                <!-- Status badges -->
                                <div class="flex items-center justify-between">
                                    <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-xs font-medium">Absent</span>
                                    <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-xs font-medium">-</span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Section: Tasks, Projects & Activity -->
        <div class="xl:col-span-5 space-y-6">

            <!-- Tasks Card -->
            <div class="bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl shadow-lg p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-bold text-white flex items-center">
                        <div class="w-8 h-8 bg-white bg-opacity-20 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                        Tasks
                    </h3>
                </div>

                <div class="space-y-3">
                    @php
                        $currentUserId = auth()->id();
                        $incompleteTasks = $userTasks->where('status', '!=', 'complete')->filter(function($task) use ($currentUserId) {
                            return $task->assignedUsers->pluck('id')->contains($currentUserId);
                        });
                    @endphp
                    @forelse($incompleteTasks->take(2) as $task)
                        <div class="bg-white bg-opacity-90 backdrop-blur rounded-xl p-4 hover:bg-opacity-100 transition-all duration-200">
                            <div class="flex items-start justify-between mb-2">
                                <h4 class="font-semibold text-gray-900 text-sm">{{ $task->title }}</h4>
                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">{{ ucfirst($task->status) }}</span>
                            </div>
                            <p class="text-xs text-gray-600 mb-3 leading-relaxed">{{ Str::limit($task->description, 50) }}</p>
                            <div class="flex items-center justify-between">
                                <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-xs font-medium">
                                    {{ ucfirst($task->priority ?? 'medium') }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="bg-white bg-opacity-90 backdrop-blur rounded-xl p-6">
                            <div class="text-center py-4">
                                <svg class="mx-auto h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                                <p class="mt-2 text-sm text-gray-500">No tasks assigned</p>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Projects Card -->
            <div class="bg-gradient-to-br from-orange-500 to-amber-600 rounded-2xl shadow-lg p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-bold text-white flex items-center">
                        <div class="w-8 h-8 bg-white bg-opacity-20 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2H5a2 2 0 00-2 2v2m14 0h-4"></path>
                            </svg>
                        </div>
                        Project
                    </h3>
                </div>

                <div class="bg-white bg-opacity-90 backdrop-blur rounded-xl p-4 hover:bg-opacity-100 transition-all duration-200">
                    @if($allProjects->isNotEmpty())
                        @foreach($allProjects as $project)
                            <div class="mb-6 last:mb-0">
                                <div class="flex items-start justify-between mb-2">
                                    <h4 class="font-semibold text-gray-900 text-sm">{{ $project->name }}</h4>
                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-red-100 text-red-800">On create</span>
                                </div>
                                <p class="text-xs text-gray-600 mb-4 leading-relaxed">{{ $project->description }}</p>
                                <div class="flex items-center justify-between">
                                    <span class="text-xs text-gray-500">Team:</span>
                                    <div class="flex -space-x-2">
                                        @foreach($project->members as $member)
                                            <div class="w-8 h-8 rounded-full border-2 border-white bg-gray-200 flex items-center justify-center overflow-hidden" title="{{ $member->name }}">
                                                @if($member->avatar)
                                                    <img src="{{ asset($member->avatar) }}" alt="{{ $member->name }}" class="w-8 h-8 object-cover rounded-full">
                                                @else
                                                    <span class="text-gray-700 font-bold text-xs">{{ substr($member->name, 0, 1) }}</span>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-4">
                            <svg class="mx-auto h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2H5a2 2 0 00-2 2v2m14 0h-4"></path>
                            </svg>
                            <p class="mt-2 text-sm text-gray-500">No projects found</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Activity Chart -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-bold text-gray-900 flex items-center">
                        <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        Activity
                    </h3>
                </div>
                <div class="relative h-64">
                    <canvas id="activityChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Chart
    const ctx = document.getElementById('activityChart').getContext('2d');
    // Use $workHoursData and $workHoursLabels from backend
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($workHoursLabels ?? ['Jan', 'Feb', 'Mar', 'Apr', 'May']) !!},
            datasets: [{
                label: 'Hours',
                data: {!! json_encode($workHoursData ?? [40, 28, 34, 52, 27]) !!},
                borderColor: '#3B82F6',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#3B82F6',
                pointBorderColor: '#ffffff',
                pointBorderWidth: 2,
                pointRadius: 6,
                pointHoverRadius: 8,
                borderWidth: 3
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: {
                        color: '#6B7280',
                        font: { size: 12, weight: '500' }
                    }
                },
                y: {
                    beginAtZero: true,
                    grid: {
                        color: '#F3F4F6',
                        borderDash: [5, 5]
                    },
                    ticks: {
                        color: '#6B7280',
                        font: { size: 12, weight: '500' },
                        callback: function(value) {
                            return value + 'h';
                        }
                    }
                }
            },
            elements: {
                point: {
                    hoverBackgroundColor: '#3B82F6',
                    hoverBorderColor: '#1D4ED8'
                }
            }
        }
    });

    // Tab functionality
    const tabButtons = document.querySelectorAll('.tab-button');
    const tabContents = document.querySelectorAll('.tab-content');

    tabButtons.forEach(button => {
        button.addEventListener('click', () => {
            const tabId = button.getAttribute('data-tab');

            // Update button styles
            tabButtons.forEach(btn => {
                btn.classList.remove('bg-gray-900', 'text-white', 'shadow-lg');
                btn.classList.add('text-gray-600', 'hover:text-gray-900', 'hover:bg-gray-50');
            });

            button.classList.add('bg-gray-900', 'text-white', 'shadow-lg');
            button.classList.remove('text-gray-600', 'hover:text-gray-900', 'hover:bg-gray-50');

            // Update content visibility
            tabContents.forEach(content => {
                content.classList.add('hidden');
            });

            document.getElementById(tabId).classList.remove('hidden');
        });
    });
});
</script>
@endsection
