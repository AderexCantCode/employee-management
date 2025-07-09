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

        <!-- Left Section: Status Tabs & User List -->
        <div class="xl:col-span-7">
            <!-- Status Tabs -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-6">
                <div class="flex flex-wrap gap-2 p-1">
                    <button class="tab-button px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->input('tab', 'ready') == 'ready' ? 'bg-gray-900 text-white' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}" data-tab="ready">
                        Ready
                    </button>
                    <button class="tab-button px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->input('tab') == 'standby' ? 'bg-gray-900 text-white' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}" data-tab="standby">
                        Stand by
                    </button>
                    <button class="tab-button px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->input('tab') == 'not-ready' ? 'bg-gray-900 text-white' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}" data-tab="not-ready">
                        Not ready
                    </button>
                    <button class="tab-button px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->input('tab') == 'complete' ? 'bg-gray-900 text-white' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}" data-tab="complete">
                        Complete
                    </button>
                    <button class="tab-button px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->input('tab') == 'absent' ? 'bg-gray-900 text-white' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}" data-tab="absent">
                        Absent
                    </button>
                </div>
            </div>

            <!-- User Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <!-- Ready Users -->
                <div id="ready" class="tab-content col-span-full">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($readyUsers as $user)
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 hover:shadow-md transition-shadow duration-200">
                            <div class="flex items-center space-x-3 mb-3">
                                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl flex items-center justify-center overflow-hidden">
                                    @if($user->avatar)
                                        <img src="{{ asset($user->avatar) }}" alt="{{ $user->name }}" class="w-12 h-12 object-cover rounded-xl">
                                    @else
                                        <span class="text-white font-bold text-lg">{{ substr($user->name, 0, 1) }}</span>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-semibold text-gray-900">{{ $user->name }}</h3>
                                    <p class="text-sm text-gray-500">{{ ucfirst($user->role) }}</p>
                                </div>
                            </div>
                            <div class="text-sm text-gray-600 mb-3">
                                Working on Farm App: Design landing & prototype page farm app
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="px-2 py-1 bg-gray-100 text-gray-700 rounded-md text-xs font-medium">Review</span>
                                <span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded-md text-xs font-medium">Medium</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Standby Users -->
                <div id="standby" class="tab-content col-span-full hidden">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($standbyUsers as $user)
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 hover:shadow-md transition-shadow duration-200">
                            <div class="flex items-center space-x-3 mb-3">
                                <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-red-600 rounded-xl flex items-center justify-center overflow-hidden">
                                    @if($user->avatar)
                                        <img src="{{ asset($user->avatar) }}" alt="{{ $user->name }}" class="w-12 h-12 object-cover rounded-xl">
                                    @else
                                        <span class="text-white font-bold text-lg">{{ substr($user->name, 0, 1) }}</span>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-semibold text-gray-900">{{ $user->name }}</h3>
                                    <p class="text-sm text-gray-500">{{ ucfirst($user->role) }}</p>
                                </div>
                            </div>
                            <div class="text-sm text-gray-600 mb-3">
                                Working on Project R: Creating a dataset of user accounts
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="px-2 py-1 bg-gray-100 text-gray-700 rounded-md text-xs font-medium">Review</span>
                                <span class="px-2 py-1 bg-red-100 text-red-700 rounded-md text-xs font-medium">High</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Not Ready Users -->
                <div id="not-ready" class="tab-content col-span-full hidden">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($notReadyUsers as $user)
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 hover:shadow-md transition-shadow duration-200">
                            <div class="flex items-center space-x-3 mb-3">
                                <div class="w-12 h-12 bg-gradient-to-br from-teal-500 to-cyan-600 rounded-xl flex items-center justify-center overflow-hidden">
                                    @if($user->avatar)
                                        <img src="{{ asset($user->avatar) }}" alt="{{ $user->name }}" class="w-12 h-12 object-cover rounded-xl">
                                    @else
                                        <span class="text-white font-bold text-lg">{{ substr($user->name, 0, 1) }}</span>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-semibold text-gray-900">{{ $user->name }}</h3>
                                    <p class="text-sm text-gray-500">{{ ucfirst($user->role) }}</p>
                                </div>
                            </div>
                            <div class="text-sm text-gray-600 mb-3">
                                Working on Web Codelab: Try to handle exceptions in Project A there's some bug when click account
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="px-2 py-1 bg-green-100 text-green-700 rounded-md text-xs font-medium">Complete</span>
                                <span class="px-2 py-1 bg-red-100 text-red-700 rounded-md text-xs font-medium">High</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Complete Tasks -->
                <div id="complete" class="tab-content col-span-full hidden">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($completeTasks as $task)
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 hover:shadow-md transition-shadow duration-200">
                            <div class="flex items-center space-x-3 mb-3">
                                <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center">
                                    <span class="text-white font-bold text-lg">{{ substr($task->assignedUser->name ?? 'T', 0, 1) }}</span>
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-semibold text-gray-900">{{ $task->assignedUser->name ?? 'Unknown' }}</h3>
                                    <p class="text-sm text-gray-500">{{ ucfirst($task->assignedUser->role ?? 'role') }}</p>
                                </div>
                            </div>
                            <div class="text-sm text-gray-600 mb-3">
                                {{ $task->title }}: {{ $task->description }}
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="px-2 py-1 bg-green-100 text-green-700 rounded-md text-xs font-medium">Complete</span>
                                <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded-md text-xs font-medium">Low</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Absent Users -->
                <div id="absent" class="tab-content col-span-full hidden">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($absentUsers as $user)
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 hover:shadow-md transition-shadow duration-200">
                            <div class="flex items-center space-x-3 mb-3">
                                <div class="w-12 h-12 bg-gradient-to-br from-gray-400 to-gray-600 rounded-xl flex items-center justify-center overflow-hidden">
                                    @if($user->avatar)
                                        <img src="{{ asset($user->avatar) }}" alt="{{ $user->name }}" class="w-12 h-12 object-cover rounded-xl">
                                    @else
                                        <span class="text-white font-bold text-lg">{{ substr($user->name, 0, 1) }}</span>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-semibold text-gray-900">{{ $user->name }}</h3>
                                    <p class="text-sm text-gray-500">{{ ucfirst($user->role) }}</p>
                                </div>
                            </div>
                            <div class="text-sm text-gray-600 mb-3">
                                Currently absent from work
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="px-2 py-1 bg-gray-100 text-gray-700 rounded-md text-xs font-medium">Absent</span>
                                <span class="px-2 py-1 bg-gray-100 text-gray-700 rounded-md text-xs font-medium">-</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Section: Tasks, Projects & Activity -->
        <div class="xl:col-span-5 space-y-6">

            <!-- Tasks and Projects Row -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Tasks Card -->
                <div class="bg-green-500 rounded-xl shadow-sm p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-white flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            Tasks
                        </h3>
                    </div>

                    <div class="space-y-3">
                        @forelse($userTasks->take(2) as $task)
                        <div class="bg-white rounded-lg p-4">
                            <div class="flex items-start justify-between mb-2">
                                <h4 class="font-medium text-gray-900 text-sm">{{ $task->title }}</h4>
                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800">{{ ucfirst($task->status) }}</span>
                            </div>
                            <p class="text-xs text-gray-600 mb-3">{{ Str::limit($task->description, 50) }}</p>
                            <div class="flex items-center justify-between">
                                <span class="px-2 py-1 bg-gray-100 text-gray-700 rounded-md text-xs font-medium">
                                    {{ ucfirst($task->priority ?? 'medium') }}
                                </span>
                            </div>
                        </div>
                        @empty
                        <div class="bg-white rounded-lg p-4">
                            <div class="text-center py-4">
                                <svg class="mx-auto h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                                <p class="mt-2 text-xs text-gray-500">No tasks assigned</p>
                            </div>
                        </div>
                        @endforelse
                    </div>
                </div>

                <!-- Projects Card -->
                <div class="bg-orange-500 rounded-xl shadow-sm p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-white flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2H5a2 2 0 00-2 2v2m14 0h-4"></path>
                            </svg>
                            Project
                        </h3>
                    </div>

                    <div class="bg-white rounded-lg p-4">
                        @if($userProjects->isNotEmpty())
                            @php $project = $userProjects->first() @endphp
                            <div class="flex items-start justify-between mb-2">
                                <h4 class="font-medium text-gray-900 text-sm">{{ $project->name }}</h4>
                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-red-100 text-red-800">On create</span>
                            </div>
                            <p class="text-xs text-gray-600 mb-3">{{ Str::limit($project->description, 50) }}</p>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <span class="text-xs text-gray-500 mr-2">Team:</span>
                                    <div class="flex -space-x-2">
                                        @foreach($project->members->take(3) as $member)
                                        <div class="w-5 h-5 rounded-full border-2 border-white bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-xs font-bold text-white" title="{{ $member->name }}">
                                            {{ substr($member->name, 0, 1) }}
                                        </div>
                                        @endforeach
                                        @if($project->members->count() > 3)
                                        <div class="w-5 h-5 rounded-full border-2 border-white bg-gray-300 flex items-center justify-center text-xs font-bold text-gray-600">
                                            +{{ $project->members->count() - 3 }}
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <svg class="mx-auto h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2H5a2 2 0 00-2 2v2m14 0h-4"></path>
                                </svg>
                                <p class="mt-2 text-xs text-gray-500">No projects found</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Activity Chart -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
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
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May'],
            datasets: [{
                label: 'Hours',
                data: {!! json_encode(array_slice($activityChartData ?? [40, 28, 34, 52, 27], 0, 5)) !!},
                borderColor: '#3B82F6',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#3B82F6',
                pointBorderColor: '#3B82F6',
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
                btn.classList.remove('bg-gray-900', 'text-white');
                btn.classList.add('text-gray-600', 'hover:text-gray-900', 'hover:bg-gray-50');
            });

            button.classList.add('bg-gray-900', 'text-white');
            button.classList.remove('text-gray-600', 'hover:text-gray-900', 'hover:bg-gray-50');

            // Update content visibility
            tabContents.forEach(content => {
                content.classList.add('hidden');
            });

            document.getElementById(tabId).classList.remove('hidden');
        });
    });

    // Initialize AOS if available
    if (window.AOS) {
        AOS.init({
            duration: 600,
            once: true
        });
    }
});
</script>
@endsection
