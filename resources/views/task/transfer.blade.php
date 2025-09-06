@extends('layouts.app')

@section('title', 'Transfer Task')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Page Header -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-6" data-aos="fade-down">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-cyan-500 rounded-lg flex items-center justify-center">
                        <i class="fas fa-exchange-alt text-white"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-semibold text-gray-900">Transfer Task</h1>
                        <p class="text-sm text-gray-500">Assign task to another team member</p>
                    </div>
                </div>
                <a href="{{ url()->previous() }}" class="w-8 h-8 bg-gray-100 hover:bg-gray-200 rounded-lg flex items-center justify-center transition-colors duration-200">
                    <i class="fas fa-times text-gray-600 text-sm"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Transfer Form -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200" data-aos="fade-up">
        <form action="{{ route('task.transfer.submit') }}" method="POST" class="p-6 space-y-6">
            @csrf

            <!-- Task Selection -->
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">
                    <i class="fas fa-tasks text-gray-400 mr-2"></i>
                    Select Task
                </label>
                <select name="task_id" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                    <option value="" disabled selected>Choose a task to transfer...</option>
                    @foreach($tasks as $task)
                        <option value="{{ $task->id }}">{{ $task->title }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Project Selection -->
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">
                    <i class="fas fa-project-diagram text-gray-400 mr-2"></i>
                    Project
                </label>
                <select name="project_id" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                    <option value="" disabled selected>Select project</option>
                    @foreach($projects as $project)
                        <option value="{{ $project->id }}">{{ $project->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Employee Selection -->
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">
                    <i class="fas fa-user text-gray-400 mr-2"></i>
                    Transfer To
                </label>
                <select name="assigned_users[]" multiple required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                    @foreach($employees as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Task Priority Level -->
            <div class="space-y-4">
                <label class="block text-sm font-medium text-gray-700">
                    <i class="fas fa-flag text-gray-400 mr-2"></i>
                    Task Priority Level
                </label>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <!-- Low Priority -->
                    <label class="relative cursor-pointer">
                        <input type="radio" name="level" value="low" class="sr-only" required>
                        <div class="priority-card border-2 border-gray-200 rounded-lg p-4 hover:border-green-300 transition-all duration-200">
                            <div class="flex items-center space-x-3">
                                <div class="priority-indicator w-4 h-4 rounded-full bg-green-100 border-2 border-green-400"></div>
                                <div>
                                    <div class="font-medium text-gray-900">Low</div>
                                    <div class="text-xs text-gray-500">&gt; 2 hours</div>
                                </div>
                            </div>
                        </div>
                    </label>

                    <!-- Medium Priority -->
                    <label class="relative cursor-pointer">
                        <input type="radio" name="level" value="medium" class="sr-only" required>
                        <div class="priority-card border-2 border-gray-200 rounded-lg p-4 hover:border-yellow-300 transition-all duration-200">
                            <div class="flex items-center space-x-3">
                                <div class="priority-indicator w-4 h-4 rounded-full bg-yellow-100 border-2 border-yellow-400"></div>
                                <div>
                                    <div class="font-medium text-gray-900">Medium</div>
                                    <div class="text-xs text-gray-500">&gt; 6 hours</div>
                                </div>
                            </div>
                        </div>
                    </label>

                    <!-- High Priority -->
                    <label class="relative cursor-pointer">
                        <input type="radio" name="level" value="high" class="sr-only" required>
                        <div class="priority-card border-2 border-gray-200 rounded-lg p-4 hover:border-red-300 transition-all duration-200">
                            <div class="flex items-center space-x-3">
                                <div class="priority-indicator w-4 h-4 rounded-full bg-red-100 border-2 border-red-400"></div>
                                <div>
                                    <div class="font-medium text-gray-900">High</div>
                                    <div class="text-xs text-gray-500">&lt; 6 hours</div>
                                </div>
                            </div>
                        </div>
                    </label>
                </div>

                <!-- Priority Info Box -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-info-circle text-blue-500 mt-0.5"></i>
                        <div class="text-sm text-blue-700">
                            <div class="font-medium mb-1">Priority Guidelines:</div>
                            <div class="space-y-1 text-xs">
                                <div><strong>Low:</strong> Tasks that can be completed over 2 hours</div>
                                <div><strong>Medium:</strong> Tasks requiring more than 6 hours</div>
                                <div><strong>High:</strong> Urgent tasks that must be completed within 6 hours</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-200">
                <a href="{{ url()->previous() }}" class="px-6 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-blue-500 to-cyan-500 text-white rounded-lg hover:from-blue-600 hover:to-cyan-600 transition-all duration-200 flex items-center space-x-2">
                    <i class="fas fa-paper-plane"></i>
                    <span>Transfer Task</span>
                </button>
            </div>
        </form>
    </div>
</div>

<style>
/* Custom styles for priority selection */
input[type="radio"]:checked + .priority-card {
    border-color: #3b82f6;
    background-color: #eff6ff;
}

input[type="radio"][value="low"]:checked + .priority-card {
    border-color: #22c55e;
    background-color: #f0fdf4;
}

input[type="radio"][value="medium"]:checked + .priority-card {
    border-color: #eab308;
    background-color: #fefce8;
}

input[type="radio"][value="high"]:checked + .priority-card {
    border-color: #ef4444;
    background-color: #fef2f2;
}

input[type="radio"]:checked + .priority-card .priority-indicator {
    background-color: currentColor;
}

input[type="radio"][value="low"]:checked + .priority-card .priority-indicator {
    background-color: #22c55e;
    border-color: #22c55e;
}

input[type="radio"][value="medium"]:checked + .priority-card .priority-indicator {
    background-color: #eab308;
    border-color: #eab308;
}

input[type="radio"][value="high"]:checked + .priority-card .priority-indicator {
    background-color: #ef4444;
    border-color: #ef4444;
}

/* Focus styles for accessibility */
input[type="radio"]:focus + .priority-card {
    outline: 2px solid #3b82f6;
    outline-offset: 2px;
}
</style>
@endsection
