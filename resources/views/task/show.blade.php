@extends('layouts.app')

@section('title', 'Task Detail')

@section('content')
<div class="min-h-screen py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8" data-aos="fade-down">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Task Details</h1>
                    <p class="text-gray-600">Detailed information about this task</p>
                </div>
                <div class="flex items-center space-x-3">
                    @if(auth()->user()->role !== 'employee')
                    <a href="{{ route('tasks.edit', $task->id) }}"
                       class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white font-medium rounded-lg transition-colors duration-200 shadow-sm">
                        <i class="fas fa-edit mr-2"></i>
                        Edit Task
                    </a>
                    @endif
                    <a href="{{ route('tasks.index') }}"
                       class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 shadow-sm">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Back to Tasks
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Task Overview Card -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden" data-aos="fade-up">
                    <!-- Card Header -->
                    <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-4">
                        <h2 class="text-xl font-semibold text-white flex items-center">
                            <i class="fas fa-tasks mr-3"></i>
                            Task Overview
                        </h2>
                    </div>

                    <!-- Card Content -->
                    <div class="p-6">
                        <h3 class="text-2xl font-bold text-gray-900 mb-6 leading-tight">
                            {{ $task->title ?? 'Wordpress plugin update' }}
                        </h3>

                        <!-- Task Description/Details -->
                        @if($task->description)
                        <div class="mb-6">
                            <h4 class="text-sm font-semibold text-gray-700 mb-3 flex items-center">
                                <i class="fas fa-align-left mr-2 text-blue-500"></i>
                                Description
                            </h4>
                            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                <p class="text-gray-800 leading-relaxed">{{ $task->description }}</p>
                            </div>
                        </div>
                        @endif

                        <!-- Progress Bar -->
                        <div class="mb-6">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm font-medium text-gray-700">Progress</span>
                                <span class="text-sm text-gray-600">
                                    @if($task->status == 'done')
                                        100%
                                    @elseif($task->status == 'in_progress')
                                        50%
                                    @else
                                        0%
                                    @endif
                                </span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="h-2 rounded-full transition-all duration-300
                                    @if($task->status == 'done') bg-green-500 w-full
                                    @elseif($task->status == 'in_progress') bg-yellow-500 w-1/2
                                    @else bg-red-500 w-0
                                    @endif">
                                </div>
                            </div>
                        </div>

                        <!-- Key Details Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Priority -->
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center
                                    @if(strtolower($task->priority ?? 'medium') == 'high') bg-red-100
                                    @elseif(strtolower($task->priority ?? 'medium') == 'medium') bg-yellow-100
                                    @else bg-green-100
                                    @endif">
                                    <i class="fas fa-flag text-sm
                                        @if(strtolower($task->priority ?? 'medium') == 'high') text-red-600
                                        @elseif(strtolower($task->priority ?? 'medium') == 'medium') text-yellow-600
                                        @else text-green-600
                                        @endif">
                                    </i>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Priority</p>
                                    <p class="font-semibold text-gray-900 capitalize">{{ $task->priority ?? 'Medium' }}</p>
                                </div>
                            </div>

                            <!-- Status -->
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center
                                    @if(strtolower($task->status ?? 'todo') == 'done') bg-green-100
                                    @elseif(strtolower($task->status ?? 'todo') == 'in_progress') bg-blue-100
                                    @else bg-gray-100
                                    @endif">
                                    <i class="fas text-sm
                                        @if(strtolower($task->status ?? 'todo') == 'done') fa-check-circle text-green-600
                                        @elseif(strtolower($task->status ?? 'todo') == 'in_progress') fa-clock text-blue-600
                                        @else fa-circle text-gray-600
                                        @endif">
                                    </i>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Status</p>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                        @if(strtolower($task->status ?? 'todo') == 'done') bg-green-100 text-green-800
                                        @elseif(strtolower($task->status ?? 'todo') == 'in_progress') bg-blue-100 text-blue-800
                                        @else bg-gray-100 text-gray-800
                                        @endif">
                                        {{ ucfirst(str_replace('_', ' ', $task->status ?? 'To do')) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Timeline Card -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden" data-aos="fade-up" data-aos-delay="100">
                    <div class="bg-gradient-to-r from-purple-500 to-purple-600 px-6 py-4">
                        <h2 class="text-xl font-semibold text-white flex items-center">
                            <i class="fas fa-calendar-alt mr-3"></i>
                            Timeline
                        </h2>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div class="text-center">
                                <p class="text-sm text-gray-600 mb-1">Start Date</p>
                                <p class="font-semibold text-gray-900">
                                    {{ $task->start_date ? $task->start_date->format('M d, Y') : '25 Nov 2024' }}
                                </p>
                                <p class="text-xs text-gray-500 mt-1">
                                    {{ $task->start_date ? $task->start_date->format('l') : 'Monday' }}
                                </p>
                            </div>
                            <div class="flex-1 mx-4">
                                <div class="relative">
                                    <div class="absolute inset-0 flex items-center">
                                        <div class="w-full border-t-2 border-purple-200"></div>
                                    </div>
                                    <div class="relative flex justify-center">
                                        <span class="bg-white px-3 text-purple-500">
                                            <i class="fas fa-arrow-right"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center">
                                <p class="text-sm text-gray-600 mb-1">Due Date</p>
                                <p class="font-semibold text-gray-900">
                                    {{ $task->due_date ? $task->due_date->format('M d, Y') : '30 Nov 2024' }}
                                </p>
                                <p class="text-xs text-gray-500 mt-1">
                                    {{ $task->due_date ? $task->due_date->format('l') : 'Saturday' }}
                                </p>
                            </div>
                        </div>

                        <!-- Days Remaining -->
                        <div class="mt-6 bg-purple-50 rounded-lg p-4 border border-purple-200">
                            <div class="flex items-center justify-center">
                                <i class="fas fa-clock text-purple-600 mr-2"></i>
                                <span class="text-purple-800 font-medium">
                                    @if($task->due_date && $task->due_date->isPast())
                                        Overdue by {{ $task->due_date->diffInDays(now()) }} days
                                    @elseif($task->due_date)
                                        {{ $task->due_date->diffInDays(now()) }} days remaining
                                    @else
                                        5 days remaining
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Assignee Card -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden" data-aos="fade-up" data-aos-delay="200">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <i class="fas fa-user mr-2 text-blue-500"></i>
                            Assignee
                        </h3>

                        <div class="flex items-center space-x-4">
                            @foreach($task->assignedUsers as $user)
                                <div class="w-12 h-12 rounded-full overflow-hidden border-2 border-gray-200">
                                    @if($user->avatar)
                                        <img src="{{ asset('avatar/' . $user->avatar) }}"
                                             alt="{{ $user->name }}"
                                             class="w-12 h-12 object-cover">
                                    @else
                                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center">
                                            <span class="text-white font-bold text-lg">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </span>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <p class="font-semibold text-gray-900">{{ $user->name }}</p>
                                    <p class="text-sm text-gray-600">{{ $user->email }}</p>
                                    @if($user->divisi)
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-cyan-100 text-cyan-800 mt-2">
                                        {{ $user->divisi }}
                                    </span>
                                    @endif
                                </div>
                            @endforeach
                            @if($task->assignedUsers->isEmpty())
                                <div class="w-12 h-12 rounded-full flex items-center justify-center border-2 border-gray-200 bg-gradient-to-br from-blue-500 to-blue-600">
                                    <span class="text-white font-bold text-lg">U</span>
                                </div>
                                <div class="flex-1">
                                    <p class="font-semibold text-gray-900">Unassigned</p>
                                    <p class="text-sm text-gray-600"></p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Project Card -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden" data-aos="fade-up" data-aos-delay="300">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <i class="fas fa-folder mr-2 text-green-500"></i>
                            Project
                        </h3>

                        <div class="bg-green-50 rounded-lg p-4 border border-green-200">
                            <p class="font-semibold text-green-900">{{ $task->project->name ?? 'Website Management Company' }}</p>
                            @if($task->project && $task->project->description)
                            <p class="text-sm text-green-700 mt-1">{{ Str::limit($task->project->description, 100) }}</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Labels & Tags -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden" data-aos="fade-up" data-aos-delay="400">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <i class="fas fa-tags mr-2 text-orange-500"></i>
                            Labels
                        </h3>

                        <div class="space-y-3">
                            <!-- Priority Tag -->
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Priority</span>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                    @if(strtolower($task->priority ?? 'medium') == 'high') bg-red-100 text-red-800
                                    @elseif(strtolower($task->priority ?? 'medium') == 'medium') bg-yellow-100 text-yellow-800
                                    @else bg-green-100 text-green-800
                                    @endif">
                                    {{ ucfirst($task->priority ?? 'Medium') }}
                                </span>
                            </div>

                            <!-- Division Tag -->
                            @if($task->assignedUser && $task->assignedUser->divisi)
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Division</span>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-cyan-100 text-cyan-800">
                                    {{ $task->assignedUser->divisi }}
                                </span>
                            </div>
                            @endif

                            <!-- Category Tag -->
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Category</span>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800">
                                    Development
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                @if(auth()->user()->role !== 'employee')
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden" data-aos="fade-up" data-aos-delay="500">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <i class="fas fa-cogs mr-2 text-purple-500"></i>
                            Quick Actions
                        </h3>

                        <div class="space-y-3">
                            <button class="w-full bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center">
                                <i class="fas fa-edit mr-2"></i>
                                Edit Task
                            </button>
                            <button class="w-full bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center">
                                <i class="fas fa-check mr-2"></i>
                                Mark Complete
                            </button>
                            <button class="w-full bg-red-500 hover:bg-red-600 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center">
                                <i class="fas fa-trash mr-2"></i>
                                Delete Task
                            </button>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
